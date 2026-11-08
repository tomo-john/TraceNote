# Composer依存パッケージの更新(2026-11-08)

`composer audit`で出ていたセキュリティアドバイザリ(15件ほど)に対応するため、依存パッケージを更新して本番(VPS)に反映した作業めも。

## まとめ(先に結論)

| やったこと | 結果 |
| --- | --- |
| ローカルで`composer update` | 80個を更新、2個を追加 |
| `composer audit` | アドバイザリ15件ほど => **0件** |
| テスト | 依存の更新とは関係ない既存の問題が3つ見つかった(後述) |
| VPSに反映 | メンテナンスモードにして`composer install --no-dev` |
| 動作確認 | Laravel 13.40.0、アドバイザリ0件、エラーなし 🐶 |

主なパッケージの変化:

| パッケージ | 更新前 | 更新後 | メモ |
| --- | --- | --- | --- |
| laravel/framework | 13.29.0 | 13.40.0 | |
| livewire/livewire | 4.4.3 | 4.4.8 | `#[Authorize]`の認可バイパスの修正版 |
| livewire/flux | 2.18.0 | 2.21.0 | |
| laravel/fortify | 1.39.0 | 1.41.0 | |
| symfony/http-foundation など | 7.4.18 | 7.4.23 | symfony系の複数のアドバイザリ |
| league/commonmark | 2.10.0 | 2.10.7 | |
| brick/math | 0.18.0 | 1.0.0 | メジャー更新はこれだけ。Laravel内部で使う計算ライブラリ |

=> TraceNoteのコードでは`#[Authorize]`を使っていないので、Livewireの脆弱性の影響は直接は受けていなかった(それでも更新しておく)

---

## 前提知識

### composer.json / composer.lock / vendor/

```
composer.json  … 「こういう条件で欲しい」(注文書)
   ↓ composer update(条件に合う最新を計算する)
composer.lock  … 「実際にこのバージョンを使う」(確定したレシート)
   ↓ composer install(レシートどおりに入れる)
vendor/        … 実際にインストールされたパッケージ
```

=> 詳しくは[Composer 基礎まとめ](../draft/202608/20260807.md)

### 更新の基本の流れ

```
ローカル: composer update => 確認・テスト => composer.lockをコミット & push
   ↓
VPS: git pull => composer install(lockどおりに入れるだけ)
```

=> **VPSで`composer update`はしない**(lockがローカルとずれてしまう)

### platformの設定

`composer.json`の`config.platform.php`を`8.3.6`にしているので、ローカルのPHP(8.5)で`composer update`しても、**PHP 8.3で動くバージョンだけ**が選ばれる。

=> 詳しくは[composer installでエラー](./composer_install_error.md)

---

## ローカルでの作業

### 0. 未コミットのcomposer.lockの正体

作業前から`git status`に`M composer.lock`が出ていた。

```bash
git diff composer.lock | grep -B1 -E '^[-+] +"version"' | grep -E '"name"|"version"'
```

- `git diff composer.lock`: コミット済みのlockとの差分を表示する
- `grep -B1 -E '^[-+] +"version"'`: バージョンが変わった行と、その1行前を取り出す
- `grep -E '"name"|"version"'`: パッケージ名とバージョンの行だけを残す

```bash
# 結果
             "name": "laravel/framework",
-            "version": "v13.29.0",
+            "version": "v13.30.1",
             "name": "league/flysystem",
-            "version": "3.35.3",
+            "version": "3.36.0",
             "name": "monolog/monolog",
-            "version": "3.10.0",
+            "version": "3.11.0",
```

=> ファイルの更新日時は2026-09-06。デプロイ後にローカルで`composer update`して、コミットしないまま残っていたもの

=> `composer update`はlockを計算し直すので、この変更は気にせずそのまま上書きしてOK

### 1. composer update

```bash
composer update
```

- `composer.json`の条件(とplatformの設定)をもとに、依存関係を計算し直して`composer.lock`と`vendor/`を更新する

```bash
# 結果(抜粋)
  - Upgrading laravel/framework (v13.30.1 => v13.40.0): Extracting archive
  - Upgrading livewire/livewire (v4.4.3 => v4.4.8): Extracting archive
  - Upgrading livewire/flux (v2.18.0 => v2.21.0): Extracting archive
  ...
Generating optimized autoload files
> @php artisan package:discover --ansi
...
No security vulnerability advisories found.
```

設定が効いているかの確認(`composer.lock`の最後):

```json
    "platform-overrides": {
        "php": "8.3.6"
    },
```

### 2. composer audit

```bash
composer audit
```

- `composer.lock`に書かれたパッケージに、既知のセキュリティアドバイザリがないかを調べる

```bash
# 結果
No security vulnerability advisories found.
```

=> 15件ほど => 0件 ✅

### 3. テスト

```bash
composer test
```

- `composer.json`の`scripts.test`に書かれた処理をまとめて実行する
  - `php artisan config:clear` => `pint --test`(コード整形チェック) => `php artisan test`(Pest)

依存の更新とは関係ない、**もともとの問題**が3つ見つかった:

| 問題 | 原因 |
| --- | --- |
| Pintが失敗して、テストまで進まない | 35ファイルでスタイルのずれ(importの順番、末尾の空行など) |
| `Vite manifest not found` | `npm run build`をしていなかった(`public/build/`はGit管理外) |
| `no such table: users` | `tests/Pest.php`の`RefreshDatabase`が、プロジェクト作成時からコメントアウトされている |

依存の更新で壊れていないかを確かめるため、次のようにした:

```bash
npm run build
```

- フロントエンドをビルドして`public/build/manifest.json`を作る

その後、`tests/Pest.php`の`RefreshDatabase`を**一時的に有効にして**`php artisan test`を実行し、終わったら`git checkout -- tests/Pest.php`で元に戻した。

- `RefreshDatabase`: テストごとにDBのテーブルを作り直す仕組み
- `git checkout -- ファイル`: そのファイルをコミット済みの状態に戻す

```bash
# 結果
tests=33 passed=31 failed=2
```

=> 失敗した2件(`SecurityTest`)は、テストが`Passkeys`や`Update password`などの**英語の文言**を確認しているのに、TraceNoteは日本語化(`APP_LOCALE=ja`)されていて「パスキー」「パスワードを更新」と表示されるため

=> 依存の更新が原因の失敗はなし ✅

### 4. ローカルでの起動確認

```bash
php artisan serve
```

- 開発用のサーバーを起動する

| ページ | 結果 |
| --- | --- |
| `/` | 200 |
| `/login` | 200 |
| `/register` | 200 |
| `/dashboard` | ログイン画面へリダイレクト(未ログインなので正常) |

=> そのあと`composer run dev`で起動して、ブラウザでログイン後の画面も確認した 🐶

### 5. コミット & push

```bash
git add composer.lock
git commit
git push origin main
```

=> コミット: `e4d87d3 chore: Composer依存パッケージを更新(セキュリティアドバイザリ対応)`

---

## VPSでの作業

### Step 1: 事前確認

```bash
cd /var/www/apps/tracenote
git status --short && git log -1 --oneline
```

- `git status --short`: VPS上でファイルが直接変更されていないか確認する(何も出なければOK)
  - `M composer.lock`などが出たら、pullで競合するので止める
- `git log -1 --oneline`: 今動いているコミットを控える(何かあったときに戻す先)

```bash
# 結果
ca0483c (HEAD -> main, origin/main, origin/HEAD) chore: リンク先変更
```

=> 変更なし。**戻す先は`ca0483c`**

```bash
composer --version
```

```bash
# 結果
Composer version 2.7.1 2024-02-09 15:26:28
```

=> VPSのComposerはapt版の2.7.1(古い。今後入れ替えたい)

### Step 2: DBのバックアップ

```bash
cp -a database/database.sqlite ~/backup/database.sqlite.$(date +%Y%m%d-%H%M)
ls -l ~/backup/
```

- `$(date +%Y%m%d-%H%M)`: `20261108-1807`のような日付と時刻になる(同じ日に何回バックアップしても分けられる)

```bash
# 結果
-rw-rw-r-- 1 john john 667648 Nov  8 17:04 database.sqlite.20261108
-rw-rw-r-- 1 john john 667648 Nov  8 17:52 database.sqlite.20261108-1807
```

=> ファイル名は`-1807`なのに日時が`17:52`なのは、`cp -a`が**元のファイルの更新日時を引き継ぐ**から(17:52はDBに最後に書き込みがあった時刻)

### Step 3: pull

```bash
git pull
git log -1 --oneline
```

```bash
# 結果
Updating ca0483c..e4d87d3
Fast-forward
 composer.lock                  | 1324 +++++-----
 ...
e4d87d3 (HEAD -> main, origin/main, origin/HEAD) chore: Composer依存パッケージを更新(セキュリティアドバイザリ対応)
```

- `Fast-forward`: VPS側に変更がないので、単純に新しいコミットまで進めただけ(競合なし)

=> pullしただけでは`vendor/`は古いままなので、サイトの動きはまだ変わらない

### Step 4: パッケージを入れ替える

`composer install`の最中は`vendor/`が入れ替わっている途中なので、アクセスがあるとエラーになる可能性がある。

=> 本番を想定して、**メンテナンスモードにしてから作業する**

#### 4-1. メンテナンスモードにする

```bash
php artisan down
```

- サイトにアクセスすると「503 Service Unavailable」(メンテナンス中)が表示されるようになる

#### 4-2. パッケージをインストールする

```bash
composer install --no-dev --no-interaction
```

- `composer install`: `composer.lock`のとおりに`vendor/`を入れ替える
- `--no-dev`: `require-dev`のパッケージ(Pest、Pail、Sail、breezejpなどの開発用ツール)を入れない
  - 本番では使わないので、入れないほうが安全で軽い
  - 初回デプロイは`--no-dev`なしだったので、今回は開発用パッケージの削除(`Removing ...`)もたくさん表示された
- `--no-interaction`: 途中で質問されたら、自動でデフォルトの答えを選ぶ

```bash
# 結果(抜粋)
  - Upgrading laravel/fortify (v1.39.0 => v1.41.0): Extracting archive
  - Upgrading livewire/livewire (v4.4.3 => v4.4.8): Extracting archive
  - Upgrading livewire/flux (v2.18.0 => v2.21.0): Extracting archive
Generating optimized autoload files
> @php artisan package:discover --ansi

   INFO  Discovering packages.

  laravel/fortify ....................................................... DONE
  laravel/passkeys ...................................................... DONE
  laravel/tinker ........................................................ DONE
  livewire/flux ......................................................... DONE
  livewire/livewire ..................................................... DONE
  nesbot/carbon ......................................................... DONE
  nunomaduro/termwind ................................................... DONE
```

=> `package:discover`のリストからpail、sail、pest、breezejpなどが消えている => `--no-dev`が効いている

=> breezejp(日本語化パッケージ)も外れたが、翻訳ファイルはすでに`lang/`に入っているので日本語表示は問題なし

#### 4-3. キャッシュを消す

```bash
php artisan optimize:clear
```

- 設定・ルート・ビュー・イベントなどのキャッシュをまとめて消す
- 古いバージョンのパッケージで作られたキャッシュが残らないようにする

```bash
# 結果
  config ...... DONE
  cache ....... DONE
  compiled .... DONE
  events ...... DONE
  routes ...... DONE
  views ....... DONE
```

#### 4-4. PHP-FPMをreloadする

```bash
sudo systemctl reload php8.3-fpm
```

- PHP-FPMはOPcacheで、一度読み込んだPHPファイルをメモリに残している
- reloadして、新しい`vendor/`のファイルを読み込ませる(処理中のリクエストは切らない)

#### 4-5. メンテナンスモードを解除する

```bash
php artisan up
```

```bash
# 結果
   INFO  Application is now live.
```

### Step 5: 動作確認

```bash
php artisan --version
```

```bash
# 結果
Laravel Framework 13.40.0
```

```bash
composer audit --no-dev
```

- 本番に入っているパッケージ(`require`側だけ)にアドバイザリがないか調べる

```bash
# 結果
No security vulnerability advisories found.
```

```bash
grep -E '^\[2026-11-08 1[89]:' storage/logs/laravel.log | cut -c1-200
```

- 作業した時間帯(18時台・19時台)のログだけを取り出す

=> 何も出なかった(エラーなし) ✅

```bash
sudo tail -n 20 /var/log/nginx/error.log
```

=> 空(エラーなし) ✅

ブラウザ:

- トップページが日本語で表示される ✅
- ログイン、ダッシュボード、トレースの画面も動く ✅

---

## もし戻すことになったら(今回は未使用)

VPSで、作業前のコミット(`ca0483c`)の状態に戻す:

```bash
php artisan down
git reset --hard ca0483c
composer install --no-dev --no-interaction
php artisan optimize:clear
sudo systemctl reload php8.3-fpm
php artisan up
```

- `git reset --hard コミット`: 作業ツリーをそのコミットの状態に戻す(VPS上の未コミットの変更は消えるので、`git status`で何もないことを確認してから)
- DBはこの作業では変わっていないので、戻す必要はない(念のためバックアップはある)

---

## 次回からのチェックリスト 🐶

### ローカル

- [ ] `composer update`
- [ ] `composer audit`
- [ ] テスト(`npm run build`してから`php artisan test`)
- [ ] `composer run dev`でブラウザ確認
- [ ] `composer.lock`をコミット & push

### VPS

- [ ] `git status --short && git log -1 --oneline`(戻す先を控える)
- [ ] DBのバックアップ
- [ ] `git pull`
- [ ] `php artisan down`
- [ ] `composer install --no-dev --no-interaction`
- [ ] (フロントやマイグレーションの変更があれば)`npm run build`・`php artisan migrate`
- [ ] `php artisan optimize:clear`
- [ ] `sudo systemctl reload php8.3-fpm`
- [ ] `php artisan up`
- [ ] バージョン・ログ・ブラウザで確認

---

## 今後の宿題

- [ ] テスト環境を直す
  - `tests/Pest.php`の`RefreshDatabase`を有効にする
  - `SecurityTest`の英語の文言を日本語化に対応させる
  - Pintで整形する
- [ ] VPSのComposer(apt版2.7.1)を公式インストーラー版に入れ替える
