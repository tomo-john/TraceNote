# PHP脆弱性対応(2026年10月 / CVE-2026-109618・CVE-2026-109619)

2026年10月21日に公開されたPHPの脆弱性への対応めも。

作業日: 2026-11-08

## まとめ(先に結論)

| やったこと | 結果 |
| --- | --- |
| PHPのバージョン確認 | 10/22に自動更新で修正版(`.13`)になっていた |
| 修正版が実際に動いているか確認 | PHP-FPMはアップデート後に起動していた => OK |
| `session.upload_progress`を無効化 | 未修正の別CVE(CVE-2026-115560)の暫定対策 |
| OSのパッケージ更新(55個 + カーネル) | カーネル `6.8.0-90` => `6.8.0-149` |
| サーバー再起動 | 119日ぶり。再起動後もTraceNoteは正常 |
| 古いカーネルの整理 | `apt autoremove`を実行(削除対象なし。古いカーネルは次回のカーネル更新後に整理) |

=> PHPの脆弱性は自動更新で対応済みだった

=> ただし**カーネルは4か月前のまま**だったので、ついでにOS全体を最新にした🐶

---

## 脆弱性の概要

| 項目 | 内容 |
| --- | --- |
| CVE | CVE-2026-109618(メモリ不足時の処理の不具合)/ CVE-2026-109619(ワーカー使い回し時の状態の不具合) |
| 危険度 | CVSS 9.2。**認証なしでリモートからコード実行(RCE)** できる |
| 状況 | 実際に攻撃に使われている(10/26にCISA KEVに登録) |
| 対象 | Webリクエストを処理するPHPすべて(PHP-FPM、mod_phpなど) |
| 修正版(PHP公式) | 8.5.12 / 8.4.27 / **8.3.36** / 8.2.35 |
| 修正版(Ubuntu 24.04) | **`8.3.6-0ubuntu0.24.04.13`** 以降(USN-8948-1) |

Laravelのコードの問題ではなく、PHP本体の問題。

=> PHP公式は「設定で完全に防ぐ方法はなく、アップデートするしかない」と言っている

参考:

- [PHP: News Archive - 2026](https://www.php.net/archive/2026.php)
- [Ubuntu USN-8948-1](https://ubuntu.com/security/notices/USN-8948-1)
- [Laravel Forge: PHP security advisory (October 2026)](https://laravel.com/forge/docs/knowledge-base/php-security-release-october-2026)

---

## 前提知識(今回わかったこと)

### 1. Ubuntuのphpはバージョン表記が違う

`composer.json`で`platform.php`を`8.3.6`にしているので、VPSはUbuntu 24.04標準(apt)のphp8.3。

Ubuntuは「PHP 8.3.36に上げる」のではなく、**8.3.6のまま修正だけを取り込む**(バックポート)。

```
8.3.6-0ubuntu0.24.04.13
~~~~~                ~~
PHP本体のバージョン   Ubuntuの修正回数(ここが増える)
```

=> 修正が入っても`php -v`の表示は`8.3.6`のまま

=> 確認は`php -v`ではなく**パッケージのバージョン**(`apt-cache policy`や`dpkg -l`)で見る

### 2. パッケージ更新 ≠ 動いているプログラムの更新

パッケージを新しくしても、**すでに動いているプロセスはメモリに古いプログラムを読み込んだまま**。

```
パッケージ更新(ディスク上のファイルが新しくなる)
  ↓
プロセスを再起動(新しいファイルを読み込む) ← ここまでやって初めて対応完了
```

=> PHP-FPMの起動日時がアップデートより後かどうかを確認する

### 3. カーネルはサーバー再起動しないと新しくならない

Ubuntuの自動更新(unattended-upgrades)はカーネルのパッケージも入れてくれるが、**再起動はしてくれない**。

=> 今回、自動更新でカーネル`-147`が入っていたのに、動いていたのは`-90`(119日前に起動したまま)だった

### 4. `reload`と`restart`の違い

| コマンド | 動き | 本番での影響 |
| --- | --- | --- |
| `systemctl restart` | 一度止めてから起動 | 処理中のリクエストが切れることがある |
| `systemctl reload` | 設定を読み直して、ワーカーを順番に入れ替える | 処理中のリクエストは最後まで処理される |

=> PHP-FPMの設定変更は`reload`で反映するのが本番向き

---

## Step 1: 今のPHPのバージョンを確認

```bash
apt-cache policy php8.3-fpm
```

コマンドの意味:

- `apt-cache policy パッケージ名`: そのパッケージの**インストール済みのバージョン**と**インストールできる最新のバージョン**を表示する
- `Installed`: 今入っているバージョン
- `Candidate`: `apt upgrade`したときに入るバージョン
- `***`: 今入っているもの

```bash
# 結果
php8.3-fpm:
  Installed: 8.3.6-0ubuntu0.24.04.13
  Candidate: 8.3.6-0ubuntu0.24.04.13
  Version table:
 *** 8.3.6-0ubuntu0.24.04.13 500
        500 http://jp.archive.ubuntu.com/ubuntu noble-updates/universe amd64 Packages
        500 http://security.ubuntu.com/ubuntu noble-security/universe amd64 Packages
        100 /var/lib/dpkg/status
     8.3.6-0maysync1 500
        500 http://jp.archive.ubuntu.com/ubuntu noble/universe amd64 Packages
```

=> すでに修正版の`.13`になっていた

=> `noble-security`から入っているので、Ubuntuの自動セキュリティ更新で上がったと思われる

---

## Step 2: 修正版が実際に動いているか確認

### 2-1. php8.3関連のパッケージがすべて`.13`か

FPMだけでなく、`common`や`opcache`などもそろっている必要がある。

```bash
dpkg -l 'php8.3*' | awk '/^ii/ {print $2, $3}'
```

コマンドの意味:

- `dpkg -l 'php8.3*'`: 名前が`php8.3`で始まるパッケージを一覧表示する
- `|`(パイプ): 左のコマンドの出力を右のコマンドに渡す
- `awk '/^ii/ {print $2, $3}'`: 行の先頭が`ii`(=インストール済み)の行だけを取り出して、2列目(パッケージ名)と3列目(バージョン)を表示する

```bash
# 結果
php8.3-bcmath 8.3.6-0ubuntu0.24.04.13
php8.3-cli 8.3.6-0ubuntu0.24.04.13
php8.3-common 8.3.6-0ubuntu0.24.04.13
php8.3-curl 8.3.6-0ubuntu0.24.04.13
php8.3-fpm 8.3.6-0ubuntu0.24.04.13
php8.3-intl 8.3.6-0ubuntu0.24.04.13
php8.3-mbstring 8.3.6-0ubuntu0.24.04.13
php8.3-opcache 8.3.6-0ubuntu0.24.04.13
php8.3-readline 8.3.6-0ubuntu0.24.04.13
php8.3-sqlite3 8.3.6-0ubuntu0.24.04.13
php8.3-xml 8.3.6-0ubuntu0.24.04.13
php8.3-zip 8.3.6-0ubuntu0.24.04.13
```

=> 12個すべて`.13` 🐶

### 2-2. アップデートした日時とFPMの起動日時を比べる

```bash
grep -h 'upgrade php8.3' /var/log/dpkg.log* | tail -5
```

コマンドの意味:

- `/var/log/dpkg.log*`: パッケージのインストール・更新の履歴(`*`で古いログファイルも対象にする)
- `grep -h 'upgrade php8.3'`: `upgrade php8.3`を含む行だけを取り出す(`-h`はファイル名を表示しない)
- `tail -5`: 最後の5行だけ表示する

```bash
# 結果
2026-10-22 06:43:07 upgrade php8.3-sqlite3:amd64 8.3.6-0ubuntu0.24.04.12 8.3.6-0ubuntu0.24.04.13
2026-10-22 06:43:08 upgrade php8.3-mbstring:amd64 8.3.6-0ubuntu0.24.04.12 8.3.6-0ubuntu0.24.04.13
2026-10-22 06:43:08 upgrade php8.3-curl:amd64 8.3.6-0ubuntu0.24.04.12 8.3.6-0ubuntu0.24.04.13
2026-10-22 06:43:08 upgrade php8.3-bcmath:amd64 8.3.6-0ubuntu0.24.04.12 8.3.6-0ubuntu0.24.04.13
2026-10-22 06:43:08 upgrade php8.3-common:amd64 8.3.6-0ubuntu0.24.04.12 8.3.6-0ubuntu0.24.04.13
```

=> 2026-10-22 06:43に`.12` => `.13`へ更新されていた(脆弱性公開の翌朝)

```bash
systemctl status php8.3-fpm --no-pager | head -5
```

コマンドの意味:

- `systemctl status サービス名`: サービスの状態(動いているか、いつ起動したか)を表示する
- `--no-pager`: `less`のような画面切り替えをせずに、そのまま出力する
- `head -5`: 最初の5行だけ表示する

```bash
# 結果
● php8.3-fpm.service - The PHP 8.3 FastCGI Process Manager
     Loaded: loaded (/usr/lib/systemd/system/php8.3-fpm.service; enabled; preset: enabled)
     Active: active (running) since Wed 2026-11-04 06:38:37 JST; 4 days ago
       Docs: man:php-fpm8.3(8)
   Main PID: 1008266 (php-fpm8.3)
```

| | 日時 |
| --- | --- |
| アップデート | 2026-10-22 06:43 |
| FPMの起動 | 2026-11-04 06:38 |

=> FPMはアップデートの**後**に起動しているので、修正版のPHPで動いている ✅

=> 脆弱性が公開されてから10/22朝に自動更新が入るまでは無防備だったけど、今は大丈夫

### 2-3. 古いライブラリを使ったままのプロセスがないか

```bash
sudo needrestart -b
```

コマンドの意味:

- `needrestart`: 更新されたライブラリを古いまま使っているサービスや、カーネルの状態を調べるツール(Ubuntu 24.04に標準で入っている)
- `-b`: バッチモード。画面(GUI)を出さずにテキストで結果を出す

> 最初に`sudo needrestart -r l`を実行したら、カーネル更新のお知らせ画面(GUI)が出た。
> `Esc`で抜けて、`-b`で実行し直した。

```bash
# 結果
NEEDRESTART-VER: 3.6
NEEDRESTART-KCUR: 6.8.0-90-generic
NEEDRESTART-KEXP: 6.8.0-147-generic
NEEDRESTART-KSTA: 3
NEEDRESTART-SVC: dbus.service
NEEDRESTART-SVC: serial-getty@ttyS0.service
NEEDRESTART-SVC: systemd-logind.service
NEEDRESTART-SVC: unattended-upgrades.service
NEEDRESTART-SESS: john @ session #525
NEEDRESTART-SESS: john @ user manager service
NEEDRESTART-SESS: root @ session #3
NEEDRESTART-SESS: root @ user manager service
```

結果の読み方:

| 項目 | 意味 | 今回 |
| --- | --- | --- |
| `KCUR` | 今動いているカーネル | `6.8.0-90` |
| `KEXP` | 次に起動したときに使われるカーネル | `6.8.0-147` |
| `KSTA` | カーネルの状態(`1`=最新で動いている、`3`=新しいバージョンが入っているのに使われていない) | `3` => 再起動が必要 |
| `SVC` | 再起動が必要なサービス | dbusなど。**php8.3-fpmとnginxは含まれていない** ✅ |
| `SESS` | 古いライブラリを使っているログインセッション | rootのセッションが残っている(後で確認) |

### 2-4. 再起動に向けた確認

```bash
uptime
```

- 最後に再起動してから何日たったかを表示する

```bash
# 結果
 16:41:21 up 119 days,  4:07,  4 users,  load average: 0.00, 0.00, 0.00
```

=> 119日(約4か月)再起動していなかった

```bash
systemctl is-enabled nginx php8.3-fpm
```

- サーバーを起動したときに、そのサービスが**自動で立ち上がる設定か**を表示する
- 本番で再起動する前に必ず確認するところ(`disabled`だと再起動後にサイトが落ちたままになる)

```bash
# 結果
enabled
enabled
```

=> 自動起動はOK

---

## Step 3: `session.upload_progress`を無効にする

### なぜやるのか

- CVE-2026-109619の暫定対策としてPHP公式が案内している設定
- さらに10/23に、**まだ修正版が出ていない別の脆弱性(CVE-2026-115560)** についても、この設定をオフにするよう案内が出ている
- Laravelはこの機能(PHP標準のセッションのアップロード進捗)を使わないので、オフにしても影響なし

### 方針(本番向け)

- `php.ini`は直接編集せず、**自分用の設定ファイルを別に追加する**
  - パッケージ更新で上書きされにくい
  - 元に戻すときはファイルを消すだけ
- 反映する前に構文チェックをする
- `restart`ではなく`reload`で反映する

### 3-1. 今の値を確認

```bash
php-fpm8.3 -i 2>/dev/null | grep 'session.upload_progress.enabled'
```

コマンドの意味:

- `php-fpm8.3 -i`: **PHP-FPM用の設定**で`phpinfo()`の内容をテキストで表示する
  - `php -i`だとCLI用の設定(`/etc/php/8.3/cli/`)になるので、Webで使われる設定を見るときは`php-fpm8.3 -i`を使う
  - 動いているプロセスの値ではなく、**設定ファイルを読んだらこうなる**という値
- `2>/dev/null`: エラー出力(2番)を捨てる(余計なメッセージを消すため)
- `grep '...'`: その設定の行だけを取り出す

```bash
# 結果
session.upload_progress.enabled => On => On
```

### 3-2. FPM用の設定ファイルを追加

```bash
echo -e '; CVE-2026-109619 / CVE-2026-115560 mitigation (2026-11-08)\nsession.upload_progress.enabled = 0' | sudo tee /etc/php/8.3/fpm/conf.d/99-tracenote-security.ini
```

コマンドの意味:

- `echo -e '...'`: 文字列を出力する。`-e`をつけると`\n`が改行になる
  - 1行目: `;`で始まる行はiniファイルのコメント(何のための設定かを残しておく)
  - 2行目: 実際の設定
- `| sudo tee ファイル`: 受け取った内容をファイルに書き込む(画面にも表示される)
- `/etc/php/8.3/fpm/conf.d/`: このフォルダの`.ini`ファイルは、PHP-FPMの起動時に**名前順に**読み込まれる
- `99-`: 名前順で最後に読み込ませて、ほかの設定より優先させるため

> **`sudo echo ... > ファイル`ではダメな理由**
>
> `>`(リダイレクト)は`sudo`より先に**今のユーザーの権限で**実行されるので、`/etc`に書き込めずに`Permission denied`になる。
> `sudo tee`ならファイルへの書き込み自体をroot権限で行える。

```bash
# 結果(teeが書き込んだ内容を表示)
; CVE-2026-109619 / CVE-2026-115560 mitigation (2026-11-08)
session.upload_progress.enabled = 0
```

### 3-3. 構文チェックと値の確認

```bash
sudo php-fpm8.3 -t
```

- `-t`: PHP-FPMの設定ファイルに間違いがないかチェックする(実際には起動しない)
- 反映する前にこれをやっておけば、設定ミスでサイトが落ちるのを防げる

```bash
# 結果
[08-Nov-2026 17:01:43] NOTICE: configuration file /etc/php/8.3/fpm/php-fpm.conf test is successful
```

```bash
php-fpm8.3 -i 2>/dev/null | grep 'session.upload_progress.enabled'
```

```bash
# 結果
session.upload_progress.enabled => Off => Off
```

=> `On` => `Off`になった

### 3-4. reloadで反映

```bash
sudo systemctl reload php8.3-fpm
```

- 設定を読み直して、PHP-FPMのワーカーを順番に入れ替える
- 処理中のリクエストは切らずに反映できる

=> ブラウザからTraceNoteにアクセスできることを確認 🐶

元に戻すとき:

```bash
sudo rm /etc/php/8.3/fpm/conf.d/99-tracenote-security.ini
sudo systemctl reload php8.3-fpm
```

---

## Step 4: OSのパッケージをまとめて更新

カーネルのために再起動するので、**ほかの更新待ちパッケージも先に当てて、再起動を1回で済ませる**。

### 4-1. 再起動前の確認

```bash
uname -r
```

- 今動いているカーネルのバージョンを表示する(再起動の前後で比べるために控えておく)

```bash
# 結果
6.8.0-90-generic
```

```bash
dpkg -l 'linux-image-*' | awk '/^ii/ {print $2, $3}'
```

- インストール済みのカーネル(`linux-image-*`)を一覧表示する(`awk`の部分はStep 2-1と同じ)

```bash
# 結果
linux-image-6.8.0-147-generic 6.8.0-147.147
linux-image-6.8.0-90-generic 6.8.0-90.91
linux-image-generic 6.8.0-147.147
```

=> `-147`は入っているけど、動いているのは`-90`

```bash
df -h /boot
```

- `/boot`(カーネルが置かれる場所)の空き容量を表示する
- 空きが足りないと、新しいカーネルで起動できないことがある
- `-h`: 容量をGやMなど読みやすい単位で表示する

```bash
# 結果
Filesystem      Size  Used Avail Use% Mounted on
/dev/vda2        99G  6.7G   88G   8% /
```

=> `/boot`は`/`と同じ場所で、空きは88GB。問題なし

### 4-2. 更新待ちのパッケージを確認

```bash
sudo apt update && apt list --upgradable
```

コマンドの意味:

- `apt update`: パッケージの**最新情報を取ってくる**だけ(まだ何もインストールしない)
- `&&`: 左のコマンドが成功したら右のコマンドを実行する
- `apt list --upgradable`: 更新できるパッケージを一覧表示する

結果(抜粋):

```bash
apparmor/noble-updates 4.0.1really4.0.1-0ubuntu0.24.04.9 amd64 [upgradable from: ...]
libkrb5-3/noble-updates 1.20.1-6ubuntu2.10 amd64 [upgradable from: 1.20.1-6ubuntu2.7]
libsqlite3-0/noble-updates 3.45.1-1ubuntu2.9 amd64 [upgradable from: 3.45.1-1ubuntu2.8]
linux-generic/noble-updates 6.8.0-149.149 amd64 [upgradable from: 6.8.0-147.147]
linux-image-generic/noble-updates 6.8.0-149.149 amd64 [upgradable from: 6.8.0-147.147]
netplan.io/noble-updates 1.1.2-8ubuntu1~24.04.3 amd64 [upgradable from: 1.1.2-8ubuntu1~24.04.2]
...(全55個)
```

=> すべてUbuntu公式のパッケージ。PHPとNginxは含まれていない

=> カーネルはさらに新しい`-149`が出ていた

=> `libsqlite3-0`はTraceNoteのDB(SQLite)が使うライブラリなので、更新後の動作確認でDBへの書き込みも見る

### 4-3. データのバックアップ

```bash
mkdir -p ~/backup
cp -a /var/www/apps/tracenote/database/database.sqlite ~/backup/database.sqlite.$(date +%Y%m%d)
ls -l ~/backup/
```

コマンドの意味:

- `mkdir -p`: フォルダを作る(`-p`をつけると、すでにあってもエラーにならない)
- `cp -a`: 権限や日時もそのままでコピーする
- `$(date +%Y%m%d)`: コマンドの結果をその場に埋め込む => `20261108`のような日付になる

=> VPS会社のコントロールパネルにイメージ保存(スナップショット)の機能があれば、それも取っておくとサーバーごと戻せる

=> 万一新しいカーネルで起動しなくなっても、コントロールパネルのコンソール画面からGRUBで古いカーネルを選べる

### 4-4. tmuxの中で更新する

```bash
tmux new -s upgrade
sudo apt upgrade
```

コマンドの意味:

- `tmux new -s upgrade`: `upgrade`という名前のtmuxセッションを作って、その中に入る
  - tmuxの中で実行したコマンドは、**SSHが切れても止まらずに動き続ける**
  - パッケージ更新が途中で止まるとシステムが壊れることがあるので、本番ではtmuxの中で実行する
  - SSHが切れたら、再ログインして`tmux attach -t upgrade`で元の画面に戻れる
  - 終わったら`exit`で抜ける
- `apt upgrade`: 更新できるパッケージをまとめて更新する(新しいカーネルなど、必要なら新しいパッケージも入れる)

実行前に表示された内容:

```bash
55 upgraded, 25 newly installed, 0 to remove and 0 not upgraded.
Need to get 895 MB of archives.
After this operation, 305 MB of additional disk space will be used.
Do you want to continue? [Y/n]
```

`Y`を押す前に確認したところ:

| 項目 | 内容 | 判断 |
| --- | --- | --- |
| `0 to remove` | 削除されるパッケージはなし | OK |
| `NEW packages` | `linux-image-6.8.0-149-generic`など | 予定どおり |
| `linux-firmware-*`が18個 | Ubuntuでlinux-firmwareが細かく分けられたため | 通常の動き |
| 容量 | 305MB増える(空きは88GB) | OK |

=> `Y`で実行

途中で出るかもしれない画面と対応:

- 設定ファイルを新しいものにするか聞かれたら => 今の設定を残す(`N`)
- needrestartのサービス選択画面 => そのまま`Enter`(このあと再起動するので)

### 4-5. 再起動の前に確認

```bash
dpkg -l 'linux-image-*' | awk '/^ii/ {print $2, $3}'
```

```bash
# 結果
linux-image-6.8.0-147-generic 6.8.0-147.147
linux-image-6.8.0-149-generic 6.8.0-149.149
linux-image-6.8.0-90-generic 6.8.0-90.91
linux-image-generic 6.8.0-149.149
```

```bash
sudo needrestart -b | grep KEXP
```

- `needrestart -b`の結果から`KEXP`(次に使われるカーネル)の行だけを取り出す

```bash
# 結果
NEEDRESTART-KEXP: 6.8.0-149-generic
```

=> 次の起動で`-149`が使われる。準備OK

---

## Step 5: 再起動

```bash
sudo reboot
```

- サーバーを再起動する。SSHは切れるので、1〜3分待ってから再ログインする

---

## Step 6: 再起動後の確認

### 6-1. 新しいカーネルで起動したか

```bash
uname -r
```

```bash
# 結果
6.8.0-149-generic
```

=> `-90` => `-149` ✅

### 6-2. サービスが動いているか

```bash
systemctl is-active nginx php8.3-fpm
```

- サービスが今動いているかを表示する(`active`なら動いている)

```bash
# 結果
active
active
```

```bash
systemctl --failed
```

- 起動に失敗したサービスを一覧表示する

```bash
# 結果
  UNIT LOAD ACTIVE SUB DESCRIPTION

0 loaded units listed.
```

=> 失敗したサービスなし ✅

### 6-3. 再起動が必要なものが残っていないか

```bash
sudo needrestart -b
```

```bash
# 結果
NEEDRESTART-VER: 3.6
NEEDRESTART-KCUR: 6.8.0-149-generic
NEEDRESTART-KEXP: 6.8.0-149-generic
NEEDRESTART-KSTA: 1
```

=> `KSTA: 1`(最新のカーネルで動いている)、`SVC`の行もなし ✅

### 6-4. upload_progressの設定が残っているか

```bash
php-fpm8.3 -i 2>/dev/null | grep 'session.upload_progress.enabled'
```

```bash
# 結果
session.upload_progress.enabled => Off => Off
```

=> ✅

### 6-5. ログにエラーが出ていないか

```bash
sudo tail -n 20 /var/log/nginx/error.log
```

- `tail -n 20`: ファイルの最後の20行を表示する

=> 空(エラーなし) ✅

```bash
tail -n 20 /var/www/apps/tracenote/storage/logs/laravel.log
```

=> スタックトレースが出ていたけど、`tail`だと**エラーの最後の部分しか見えない**ので、いつ・何のエラーかがわからない

=> エラーの1行目(日時とメッセージ)だけを取り出して確認:

```bash
grep -E '^\[[0-9]{4}-' /var/www/apps/tracenote/storage/logs/laravel.log | tail -n 5 | cut -c1-300
```

コマンドの意味:

- `grep -E '^\[[0-9]{4}-'`: 行の先頭が`[2026-`のような日付で始まる行(=各エラーの1行目)だけを取り出す
  - `-E`: 拡張正規表現を使う
  - `^`: 行の先頭
  - `\[`: `[`という文字そのもの
  - `[0-9]{4}`: 数字4桁(年)
- `tail -n 5`: 新しいものから5件
- `cut -c1-300`: 1行が長すぎるので、300文字で切る

```bash
# 結果
[2026-09-02 08:10:03] production.ERROR: SQLSTATE[HY000]: General error: 8 attempt to write a readonly database (Connection: sqlite, ...
```

=> 2026-09-02のエラー1件だけ。初回デプロイ時の権限エラー([deploy.md](./deploy.md)の「権限設定」で解決済み)

=> 今日の作業のあとのエラーはなし ✅

### 6-6. ブラウザで確認

- トップページが表示される ✅
- ログインできる ✅

=> TraceNoteは`SESSION_DRIVER=database`なので、ログインするとsessionsテーブルに書き込みが発生する

=> ログインできれば、更新したSQLiteライブラリでもDBへの書き込みはOK 🐶

---

## Step 7: 後片付け(古いカーネルの整理)

```bash
sudo apt autoremove
```

- もう使われていないパッケージ(古いカーネルなど)を削除する
- `Y/n`を押す前に、**消える一覧を必ず確認する**
  - `linux-image-6.8.0-90-generic`などの古いカーネルと、`libfwupd2`・`libgusb2`ならOK
  - **今動いている`-149`が入っていたら`n`で止める**
  - `-147`は、`-149`で問題が起きたときに戻せるよう予備として残ることが多い

```bash
# 結果
Reading package lists... Done
Building dependency tree... Done
Reading state information... Done
0 upgraded, 0 newly installed, 0 to remove and 0 not upgraded.
```

=> 削除対象は0個で、何も消えなかった

=> 古いカーネル(`-90`、`-147`)は残ったまま

### なぜ`-90`が消えなかったのか

最初は「古いUbuntuにある、自動削除しないカーネルのリスト(`/etc/apt/apt.conf.d/01autoremove-kernels`)で保護されているのでは?」と考えて確認した。

```bash
cat /etc/apt/apt.conf.d/01autoremove-kernels
```

```bash
# 結果
cat: /etc/apt/apt.conf.d/01autoremove-kernels: No such file or directory
```

=> ファイル自体がなかった。Ubuntu 24.04ではこのファイルは使われず、apt自身が「**今動いているカーネル + 最新 + その1つ前**」を自動で保護する

=> 今は`-149`(動いている・最新)と`-147`(1つ前)が保護対象なので、`-147`が残るのは正常

=> `-90`は保護対象ではないので、本来は消えるはず

**次に考えられる原因**: `-90`が「**手動でインストールしたパッケージ**」の扱いになっている

- aptはパッケージを「自動(auto)」と「手動(manual)」に分けて管理している
  - auto: ほかのパッケージの依存で入ったもの => 不要になったら`autoremove`で消える
  - manual: 自分で`apt install`したもの => `autoremove`では**消えない**
- VPSの初期イメージで入っていたカーネルは、manual扱いになっていることがある

確認するコマンド:

```bash
apt-mark showmanual | grep -E '^linux-(image|modules|headers)'
```

- `apt-mark showmanual`: manual扱いのパッケージを一覧表示する
- `grep -E '^linux-(image|modules|headers)'`: カーネル関連のパッケージだけを取り出す

```bash
# 結果
(何も出なかった)
```

=> カーネル関連はmanual扱いではなかった。この原因でもない

**現時点では原因不明。** 害はないので、次にカーネルが更新されたときに`autoremove`でどうなるかを見る。

さらに調べるときは、aptがなぜ残すと判断したのかを表示させる:

```bash
sudo apt-get autoremove --dry-run -o Debug::pkgAutoRemove=1 2>&1 | grep '6.8.0-90'
```

- `apt-get autoremove --dry-run`: 実際には何も消さずに、autoremoveの動きだけを試す
- `-o Debug::pkgAutoRemove=1`: autoremoveの判断の過程(どのパッケージを、なぜ残すか)をデバッグ表示する
- `2>&1`: デバッグ表示はエラー出力(2番)に出るので、通常の出力(1番)にまとめて`grep`に渡す

=> どちらにしても、空き容量は88GBあるので残っていても問題なし。**無理に手動で消さない** 🐶

> `apt upgrade`のときに「もう不要」と表示された`libfwupd2`・`libgusb2`も、今回は削除対象に出てこなかった。
> 残っているかどうかは`dpkg -l libfwupd2 libgusb2`で確認できる。

---

## 今後の宿題

- [ ] **Composer依存パッケージのアドバイザリ対応**
  - `composer audit`で15件ほど出ている(Livewireの`#[Authorize]`認可バイパス、symfony系など)
  - リポジトリで`composer update` => テスト => デプロイ
- [ ] **apt版Composerの入れ替え**
  - `apt upgrade`のときに「`composer`はUbuntu Pro(ESM)でしかセキュリティ更新されない」と表示された
  - Composer公式のインストーラー版にするか、Ubuntu Pro(個人利用ならマシン5台まで無料)を有効にする
- [ ] **rootでのSSHログインの確認**
  - `needrestart`でrootのセッションが残っていた
  - `/etc/ssh/sshd_config`の`PermitRootLogin`を確認する
- [ ] **定期的な再起動の習慣**
  - 自動更新はパッケージを入れるだけで、カーネルの更新には再起動が必要
  - 月1回くらい`sudo needrestart -b`で`KSTA`を確認する(`3`なら再起動する)

## 学び 🐶

- Ubuntuのphpは`php -v`ではなく**パッケージのバージョン**で確認する
- パッケージが新しくても、**プロセスを再起動しないと対応したことにならない**
- 自動更新に任せていても、**カーネルは再起動しないと古いまま**
- 本番で設定を変えるときは「**別ファイルで追加 => 構文チェック => reload**」の順に進める
- 本番を再起動するときは「**自動起動の確認 => バックアップ => tmuxで更新 => 再起動 => 確認**」の順に進める
