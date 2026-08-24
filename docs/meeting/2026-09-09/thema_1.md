# Trace同士のリレーション

## なぜ作ったか

Trace(知識)は1つで簡潔するものでなく、関連する知識が存在すると考えた。

Trace自体を単なるメモやノートでなく、Trace同士がお互いに関連し合う機能を実装したかったため。

## 最初に考えたこと

関連(リレーション)はどうゆうタイプなのか？(1対1？1対多？)

- 1対1: 1つのTraceに対して1つだけのTraceとは限らないので違う

    => 1つのTraceが複数のTraceに関連する場合がある

- 1対多: 1つのTraceは複数のTraceに関連する(これはOK)

    => しかし、今回のリレーションはどちらもTraceモデル

- 多対多: 複数のTraceは複数のTraceに関連できる(これがよさそう)

    => 今回のTraceのリレーションはこのタイプでいくのがよさそう

リレーションに種類を持たせることはできないか？

=> 知識の関連には、前提となる知識、その知識から派生した知識、単純な関連となる知識とパターン分けができる

## どういう関係にしたかったか

Trace同士の関係それぞれに意味がある関連。

```
Trace A
    |
    |---> 前提となる知識 ---> Trace B
    |---> 派生した知識 ---> Trace C
    |---> 関連する知識 ---> Trace D
```

## 最終的なDB構造

traces: id, title, .... => Trace自体の情報
trace_relations: id, from_trace_id, to_trace_id, relation_type => Trace間同士の関係の情報

## Laravelではどう実装したか

Traceモデル -> TraceRelationモデルに`hasMany()`のリレーションを設定。

このとき、`from_trace_id`, `to_trace_id`のそれぞれを基準とするため2つメソッドを定義。

=> `outgoingRelations()`と`incomingRelations()`の2つ。

TraceRelationモデルにはTraceモデルに対する`belongsTo()`のリレーションを設定。

こちらも、`from_trace_id`, `to_trace_id`どちら基準かを定義する為2つのメソッドを定義。

=> `fromTrace()`と`toTrace`

これにより、あるTraceから見た時まず自分に関連するTrace(関連情報)を矢印の向きを指定して取得

=> 自分から出ていく矢印(`from`)なのか、自分に入ってくる矢印(`to`)なのか

そしてこの取得した関連情報が`TraceRelationモデルのインスタンス`として扱うことができ、さらに関連先のTraceを取得することができる。

さらに、TraceRelation(trace_relationsテーブル)にはどの関連タイプかを指定する`relation_type`のメソッドを持たせた。

そして、この`relation_type`はEnumsとして管理した。

## なぜTraceRelationモデルが必要だったか

単純な中間テーブル = trace間の紐づけ情報 に対して、矢印の向き(from, to)と関連の種類(relation_type)という情報を持たせたかった。

=> ここの説明が特に弱い

## ここで学んだこと

- 中間テーブルを独立したモデルとして扱う設定
- relation_typeをEnumとして扱う

