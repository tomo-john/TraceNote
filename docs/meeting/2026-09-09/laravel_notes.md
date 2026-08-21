# Trace Note振返り

## 3か月でやったこと

- アプリ構想考案
- Laravelアプリ作成
- GitHub連携
- ER図
- VPS

### 最初は分からなかったけど、今は分かること

- LivewireでのCRUD作成: 単一ページとそれぞれのページ
- 1対多のリレーション
- Bladeコンポーネントの置き場所と呼び出し方
- Enumsの使い方

### 作る前と比べて、できるようになったこと

- BladeコンポーネントによるUIの共通化
- 理解不足だが、多対多のリレーションを初めて作った

### 今でもよく分かっていないこと

- Alpine.js
- Eloquent
- スターターキットでのログインや認証の仕組み
- Livewireでない通常のContorollerでのCRUD作成
- 何でRelationTypeをTraceと別モデルにしたのか

### 作っていて「面白い」と感じたこと

- Traceの関連付けメソッドが思うように動いた
- BladeコンポーネントによるUIの共通化
- Laravelの仕組みを少しずつでも学べたこと

### 作っていて「もう二度とやりたくない」と思ったこと

- 二度とやりたくないと思う程のことは今のとこなし

## TraceNoteで実装したことの洗い出し

- CRUD(Trace, Tag)
    - Trace: Livewire(Index, Show, Create, Edit, Delete)
    - Tags: Livewire(Index単一ページでindex, create, edit, delete)
- Livewire
- Tailwind CSS
- Alpine(x-ui.toast)
- Policy
- Pagination(Trace Index)
- Relations
    - User - Traces
    - User - Tags
    - Trace - Tags
    - Traces - Traces
- Dashboard
- Service(dashboard, growth)
- UI
    - Bladeコンポーネント
    - User Profile
    - Login, Register
    - Top, Header, Footer
- Enums(TraceStatus, TraceRelationType)

## 設計・工夫した点

- TALL Stackを使ってみた
- UIに統一性を持たせるためにBladeコンポーネント
- Dashboardの処理をServeceに移譲 -> さらに成長関連の処理をGrowth Serviceへ移譲
- Traceの自己参照型の多対多のリレーション
- Trace同士の関連付けに3種類のタイプを用意
- 隠れ要素に犬をおいた

## 苦労した点

- Traceのリレーションメソッドの作成
- TraceRelationTypeのモデル化(Traceモデルと分ける) + Enums化
- スターターキットページのUI修正(ログイン・ユーザープロフィールの仕組み)

## 話したい内容メモ

- 自身が製品学習や新しい学習をするときに使用できるアプリをテーマにした

## その他本音など

AIに教えてもらいながら作ったので、全体的な理解不足を痛感。

アプリのテーマ、内容としてもありきたりなCRUDメモアプリでアピールポイントがない。

何をして、何を考えて、何を学んだかが自信を持って言語化できない。

アピールしたいポイントなどがまだ自分の中で全然理解・整理できていない。

どうゆう順番で何を説明したらいいのかわからない。

