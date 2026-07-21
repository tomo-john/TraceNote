# User Profile 設計

## 概要

TraceNoteでは、スターターキットの `app/Livewire/Settings/` をそのまま利用せず、
アプリの世界観に合わせたユーザープロフィール設定画面を独自実装する。

認証処理（Fortify）は利用するが、UI・画面構成は TraceNote 独自のものとする。

---

## ディレクトリ構成

```text
app/Livewire/User/Profile.php
resources/views/livewire/user/profile.blade.php
```

---

## URL

```text
/user/profile
```

---

## ページの責務

### Dashboard

学習状況を確認するページ。

- Trace数
- Tag数
- レベル
- 活動履歴
- 学習状況

### User/Profile

ログイン中ユーザーのアカウント情報を管理するページ。

- 名前
- メールアドレス
- パスワード
- アカウント削除

Dashboardと役割を分離し、学習状況は表示しない。

---

# MVP

プロフィール画面は3つのカードで構成する。

## 1. 基本情報

- 名前変更
- メールアドレス変更

---

## 2. パスワード変更

スターターキットのロジックを参考に実装する。

- 現在のパスワード
- 新しいパスワード
- パスワード確認

---

## 3. アカウント削除

アカウント削除機能を実装する。

---

# 将来の追加機能

- プロフィール画像
- 自己紹介
- GitHubアカウント連携

## 学習ポイント

- Fortifyは認証処理のみ利用する
- Profile画面はLivewireで独自実装する
- スターターキットは設計の参考とし、UIはTraceNoteに合わせて再設計する

