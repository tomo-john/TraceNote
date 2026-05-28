# 2台目PCメモ

1. リポジトリのクローン

```
git@github.com:tomo-john/TraceNote.git
```

2. 環境変数ファイル

```
cp .env.example .env
```

3. 依存パッケージのインストール

```
# PHP依存パッケージをインストール
composer install

# JS/CSS依存パッケージをインストール
npm install
```

4. アプリケーションキー生成

```
php artisan key:generate
```

最低限ここまで。あとは必要に応じてマイグレーションなど。

