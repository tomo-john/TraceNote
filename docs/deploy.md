# Trace Noteデプロイ時(2回目)

160.251.234.145

## 作業前確認

```bash
df -h
Filesystem      Size  Used Avail Use% Mounted on
tmpfs           197M  1.1M  196M   1% /run
/dev/vda2        99G  6.1G   88G   7% /
...
```

=> Disk容量問題なし

## 手順の流れ

### Laravle

- git clone
- composer install
- .env
- APP_KEY
- migrate

### Front

- nmp install
- npm run build

### Nginx

- root変更
- nginx reload

---

## サーバー準備(git clone)

`/var/www/apps/`に`TraceNote`を`git clone`する。

```
git clone git@github.com:tomo-john/TraceNote.git
```

ディレクトリの名前は`TraceNote`から`tracenote`(小文字)へ変更した。

## Composer install

`/var/www/apps/tracenote`で実施。

=> 初回はエラーが出たので、PHP 8,3(VPS)対応を別途実施

=> [対応メモ](./composer_install_error.md)

## 環境設定(.env)

Git管理の`.env.example`から`.env`を作成(cp)

`.env`の編集(本番環境用へ):

```bash
APP_ENV=local              # production
APP_DEBUG=true             # false
APP_URL=http://localhost   # http://160.xxx (VPSのアドレス)
```

=> DBはいったんSQLiteで進める

その後、

```bash
php artisan key:generate
```

=> `.env`の`APP_KEY`が自動ではいる

## 初回マイグレーション

```bash
php artisan migrate
```

=> 本番環境だけどいいですか?と確認あり

=> `database/database.sqlite`がないので作りますか?の確認あり

## フロントエンド

Node.jsとnpmは以前にインストール済み。

```bash
npm install
npm run build
```

## Nginxの設定変更(pawverse -> tracenote)

```bash
ls -l /etc/nginx/sites-enabled/
total 0
lrwxrwxrwx 1 root root 34 Jul 14 18:32 default -> /etc/nginx/sites-available/default
```

=> 今のNginxの設定は`sites-available/default`よ読込まれているのでこれを編集(`sudo`)

```bash
server {
  listen 80 default_server;
  listen [::]:80 default_server;

  # 変更前
  root /var/www/apps/pawverse/public;

  # 変更後
  root /var/www/apps/tracenote/public;
  ...
}
```

=> その他の設定は初回デプロイ時に行った為今回なし

### 文法チェック

```bash
sudo nginx -t
```

### リロード(設定の反映)

```bash
sudo systemctl reload nginx
```

=> この時点ではまだ、権限関係でアクセスできない

## 権限設定

`/var/log/nginx/error.log`の抜粋:

```bash
/var/www/apps/tracenote/storage/logs/laravel.log
could not be opened in append mode
Permission denied
```

つまり、

```bash
PHP-FPM(www-data) -> Laravel -> storage/logs/laravel.log にログを書きたい -> Permission denied 🐶💥
```

対応(`/var/www/apps/tracenote`にて):

```bash
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

=> これでNginxがログが書ける(まだ500 Server Error)

`storage/logs/laravel.log`の抜粋:

```bash
production.ERROR: SQLSTATE[HY000]: 
General error: 8 attempt to write a readonly database 
(Connection: sqlite, Database: /var/www/apps/tracenote/database/database.sqlite, SQL: update 
"se  2 [stacktraceon.ERROR: SQLSTATE[HY000]: 
General error: 8 attempt to write a readonly database 
(Connection: sqlite, Database: /var/www/apps/tracenote/database/database.sqlite, SQL: update "se  2 [stacktrace]
```

=> `www-data`が`database.sqlite`に書込めない

対応:

```bash
sudo chgrp -R www-data database
sudo chmod -R 775 database
```

=> これでブラウザから(http://だけど...)アクセスできた

