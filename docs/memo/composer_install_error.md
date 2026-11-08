# composer installでエラー

```
Mac(ローカル)のPHPが新しい
    |
ComposerがSymfony 8系を選択
    |
composer.lockに固定される
    |
VPS PHP 8.3でcomposer install
    |
Symfony 8がPHP 8.4以上を要求してエラー
```

## ゴール

- Laravel 13
- PHP 8.3
- Symfony 7.4

## ComposerにPHP 8.3環境として依存関係を解決してねと伝える

### composer.jsonを編集

変更前:

```json
    "config": {
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "php-http/discovery": true
        }
    },
```

変更後:

```json
    "config": {
        "platform": {
             "php": "8.3.6"
        },
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "php-http/discovery": true
        }
    },
```

=> `"platform": { "php": "8.3.6" },`を追加

=> 編集後に`composer update`を実行する

これで現在のcomposer.lockをPHP 8.3.6前提で作り直す。

### Symfonyのバージョン確認

```bash
composer show symfony/http-foundation
```

変更前 => 変更後:

```
v8.0.8 => v7.4.18
```

=> 実際のコマンド出力は`versions : * v7.4.18`のように、**今入っているバージョンだけ**が表示される(上は変更前後を並べたメモ)

### VPS側に反映

- ローカル: `commit -> push`
- VPS: `pull -> (再度)composer install`

## composer.jsonのconfig -> platform

```json
    "config": {
        "platform": {
             "php": "8.3.6"
        },
```

=> Composerの依存関係解決をPHP 8.3.6の環境として考えさせる

=> 実際のローカルPHPを8.3.6に変更するわけではない

## 補足(2026-11-08 追記)

### `composer update`は実行したPCのPHPを基準に計算する

ここが今回のエラーの根本原因。

```
composer update
    |
「このPCのPHPは何?」を確認(platformの設定があればそちらを優先)
    |
そのPHPで動く範囲で、composer.jsonの条件に合う最新バージョンを選ぶ
    |
composer.lockに書き込む
```

=> ローカル(PHP 8.4以上)でそのまま`composer update`すると、PHP 8.4以上が必要なSymfony 8が選ばれてしまう

=> `composer install`はlockどおりに入れるだけなので、VPSで計算し直してはくれない

### なぜ`8.3`ではなく`8.3.6`なのか

VPSはUbuntu 24.04標準(apt)のphp8.3を使っている。

Ubuntuのphpは、セキュリティ修正が入っても**PHP本体のバージョン表示は`8.3.6`のまま**(修正だけを取り込むため)。

```
8.3.6-0ubuntu0.24.04.13
~~~~~                ~~
PHP本体のバージョン   Ubuntuの修正回数(ここだけが増える)
```

=> VPSの`php -v`の表示どおり`8.3.6`を指定しておけば、ずっと合ったまま

=> 詳しくは[PHP脆弱性対応メモ](../php_update_8.3.36.md)の「前提知識」

### 設定が効いているかの確認

`composer.lock`の最後に次のように記録されていればOK:

```json
    "platform-overrides": {
        "php": "8.3.6"
    },
```

### 今後の注意点

- **VPSのPHPを変えるとき**(例: Ubuntu 26.04にしてPHP 8.5になる)は、`platform`の値も合わせて変えてから`composer update`する
  - 変えないままだと、新しいPHPで使えるパッケージがあっても古いものが選ばれ続ける
- **ローカルは今PHP 8.5で動いている**ので、「PHP 8.3向けに選んだパッケージをPHP 8.5で動かしている」状態
  - 普段は問題にならないが、ローカルでは動くのにVPSでは動かない(またはその逆)ときは、PHPのバージョンの違いを疑う
- パッケージを追加・更新するときは、必ず**ローカルで`composer update`(または`composer require`) => lockをコミット => VPSで`composer install`**の順にする
  - VPSで`composer update`はしない(lockがローカルとずれてしまう)

