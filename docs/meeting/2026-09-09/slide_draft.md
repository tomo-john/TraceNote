# スライド構成下書き

## 構成案

- 1. タイトル
- 2. TraceNoteとは
- 3. なぜTraceNoteを作ったのか
- 4. 使用技術・開発期間
- 5. 主な機能
- 6. DB設計
- 7. Theme1: Trace同士のリレーション
- 8. Theme2: Serviceへの処理の分離
- 9. Theme3: UIコンポーネント
- 10. Demo
- 11. 今後実装・改善したいこと
- 12. 開発を通じて学んだこと
- 13. 今後チャレンジしたい技術

Theme1-3では自分が設計で考えた点・苦労した点・どう解決したのか・何を学んだのか各セクションごとに記載。

最後のスライドにGitHub, VPSのURLを記載する。

---

## Slide 1: タイトル

ここはタイトルだけの資料。

---

## Slide 2: TraceNoteとは

### 伝えること

- 学習した知識を記録・整理するアプリ
- Trace = 学んだ知識
- Tag = 知識の分類
- Trace同士の関連付け、知識のつながりを表現

### 載せるもの

- 概念図

---

## Slide 3: なぜTraceNoteを作ったのか

### 伝えること

自分自身の課題からテーマを決めたこと。

- 自分自身が製品学習を始めた
- 学習した内容を整理・アウトプットし自分自信が使えるアプリを作ろうと考えた
- 3か月という期間と自身の技術力を考えてMVPを設定した

### 載せるもの

製品学習 -> 学んだ内容を整理したい -> 自分自身で使えるアプリ -> TraceNote

のような流れの図

---

## Slide 4: 使用技術・開発期間

### 伝えること

使用技術:
- Laravel
- Livewire
- Tailwind CSS
- Alpine.js
- GitHub
- VPS / Nginx

開発期間:
- 2026/5/22 ～ 8/31(約3か月間)
- アプリ構想 -> MVP決定 -> Laravel開発 -> 機能追加・改善 -> VPS構築 -> デプロイ

### 載せるもの

- 上段: 使用技術
- 下段: 開発期間と開発の流れ

---

## Slide 5: 主な機能

### 伝えること

- Trace, Tag CRUD
- Trace <-> Tag / Trace <-> Trace Relation
- Dashboard

### 載せるもの

- 機能マップ

---

## Slide 6: DB設計

### 伝えること

```
users
  │
  ├── traces
  │      │
  │      ├── trace_relations
  │      │
  │      └── trace_tag
  │
  └── tags
```

### 載せるもの

- ER図

この中で特に説明したいのが、TraceとTraceRelationの部分

=> 次のスライドに繋げる

---

## Slide 7：Trace同士のリレーション

### 伝えること

Trace同士の関係を、関係そのものとして扱えるように設計した。

### 載せるもの

- `Trace A -> Trace B の図`
- `traces`
- `trace_relations`
- `TraceRelationモデル`
- `relation_type`

### 話すこと

- なぜTrace同士を関連付けたかったか
- なぜ多対多なのか
- なぜ`belongsToMany`ではなく`TraceRelation`にしたのか
- `from` / `to` / `relation_type`を持たせた理由

---

## Slide 8: Service処理の分離

### 伝えること

- DashboardController -> DashboardService -> GrowthService という構造
- どうしてこの構造にしたのか
- どうしてGrowthServiceを別で用意したのか
- DIについても軽く

### 載せるもの

- DashboardContollerからViewまでのデータの流れの図

---

## Slide 9: UIコンポーネント

### 伝えること

- どうしてUIコンポーネントにしたのか
- どのタイミングで作成したのか(最初からUIコンポーネントにしなかった理由など)
- どんなものをコンポーネント化してどのように使用しているのか

### 載せるもの

- 実際にUIコンポーネントしたものをいくつか抜粋
- MVPから見直し、UIコンポーネント作成の流れ

---

## Slide 10: Demo

### 伝えること

- これまでの機能説明を踏まえ実際にVPSを操作
- 3つのテーマを軸に説明

### 載せるもの

```
Login -> Dashboard -> Trace作成 / Tag作成

Trace - Tag / Trace - Trace

Dashboard
```

ここのスライドはシンプルにし、実際の操作を行う。

Demoは「機能を全部見せる時間」ではなく「説明した設計が実際に動くことを確認してもらう時間」

---

## Slide 11: 今後実装・改善したいこと

### 伝えること

Traceの活用:
- 関連知識をたどる画面
- TraceStatusと関連性を利用したDashboard

=> TraceRelation、関連付け機能をもっと画面上で活用したい

Growth:
- Dashboard以外での成長情報の活用

=> アプリ全体でGrowthServiceを活用したい

ユーザー間:
- Traceの公開・非公開設定
- 他ユーザーのTrace閲覧

=> 自分だけの知識管理から、他ユーザーの学びも見られるようにしたい

### 載せるもの

3つの発展方向 + それぞれの具体例

---

## Slide 12: 開発を通じて学んだこと

### 開発前

- Laravelの知識は断片的
- 実際にアプリを最初から作った経験が少なかった

### 開発を通して

- アプリを構想から実装、デプロイまで進めた
- DB設計やリレーションを考えることができた
- 責務分離や再利用性を意識した

---

## Slide 13: 今後チャレンジしたい技術など / Links

### 伝えること

- Laravel認証機能の理解・活用
- APIでの外部連携
- LaravelをAPIバックエンドとして利用
- フロントエンドとの分離

### 載せるもの(Link)

- GitHub URL
- VPS URL

---

