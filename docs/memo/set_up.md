# Laravel App Setup

## WSL2/Ubuntu上でプロジェクト作成

- Composer version: 2.8.12
- PHP version 8.4.1

### プロジェクト作成コマンド

```bash
laravel new Laravel-App
```

> Laravel-App ディレクトリ(プロジェクトが作成される)
> .git があるディレクトリで laravel new . --force はダメだった
> 後で空のリポジトリに紐づけ済みの .git を移動させる

## インストール時の選択

-  Which starter kit would you like to install?

> Livewire

- Which authentication provider do you prefer?

> Laravel's built-in authentication

- Would you like to use Laravel Volt?

> No

- Which testing framework do you prefer?

> Pest

- Which authentication features would you like to enable?

> 全部チェック入れる

```
  ◼ Email verification
  ◼ Registration
  ◼ Two-factor authentication
  ◼ Passkeys
  ◼ Password confirmation
```

- Would you like to run npm install and npm run build?

> Yes

=> これでプロジェクトが作成される

起動確認:

```bash
php artisan serve
npm run dev
```

- 退避させていた .git を作成したプロジェクトへ移動

> ここで一度コミット

