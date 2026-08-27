# Trace同士のリレーション

## なぜ作ったか

Trace(知識)は1つで完結するものでなく、関連する知識が存在すると考えた。

Trace自体を単なるメモやノートでなく、Trace同士がお互いに関連し合う機能を実装したかったため。

## 最初に考えたこと

関連(リレーション)はどういうタイプなのか？(1対1？1対多？)

- 1対1:
    1つのTraceに対して1つだけのTraceとは限らないので違う

    1つのTraceが複数のTraceに関連する場合がある

- 1対多:
    1つのTraceは複数のTraceに関連することはできる

    しかし今回の関係では、関連先のTrace側も、別の複数のTraceと関連する可能性がある

- 多対多:
    複数のTraceは複数のTraceに関連できる(これがよさそう)

    => 今回の関係に最も適していると考えた

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

- `traces`: `id`, `title`, .... => Trace自体の情報
- `trace_relations`: `id`, `from_trace_id`, `to_trace_id`, `relation_type` => Trace同士の関係の情報

## Laravelではどう実装したか

### Traceモデル

- `outgoingRelations()`: 自分を`from_trace_id`とする関連を取得
- `incomingRelations()`: 自分を`to_trace_id`とする関連を取得

### TraceRelationモデル

- `fromTrace()`: `from_trace_id`側のTraceを取得する
- `toTrace()`: `to_trace_id`側のTraceを取得する

これにより、あるTraceから見たときに、自分から出ていく関係と、自分に入ってくる関係を区別して取得できる。

また、取得した関係は単なる中間テーブルの値ではなく`TraceRelation`モデルとして扱えるため、

関係そのものに対してリレーションやメソッドを持たせることができる。

`relation_type`カラムには関連タイプを保存し、LaravelではEnumとして管理した。

## なぜTraceRelationモデルが必要だったか

`traces`テーブルはTraceそのものの情報を管理する。

一方で`trace_relations`テーブルは、「どのTraceとどのTraceが、どのような関係にあるか」という関係そのものの情報を管理する。

なので、Traceそのものではなく、TraceとTraceの関係自体を独立したモデルとして扱いたかった。

=> trace_relationsの1レコードを、「TraceとTraceの関係を表す1つのデータ」として扱いたかった。

## ここで学んだこと

- 自己参照の多対多リレーションの考え方
- 中間テーブルをモデルとして扱う方法
- hasMany()とbelongsTo()を組み合わせて関係を表現する方法
- `relation_type`をEnumとして扱う方法

## memo

```
Trace
＝ 知識そのもの

TraceRelation
＝ 知識と知識の関係そのもの
```

