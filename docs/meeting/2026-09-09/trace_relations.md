# Traceの自己参照多対多リレーション

TraceNoteでは、学習した知識をTraceとして管理し、Trace同士の関連性も管理したかった。

関連には、「前提知識」「子知識」「単純関連」という種類があり、

前提知識や子知識では関連の方向性に意味を持たせたかった。

そのため、Traceテーブル自身に関連先を持たせるのではなく、Trace同士の関係を専用の中間テーブルで管理し、

`from_trace_id`, `to_trace_id`, `relation_type`を持たせた。

また、同じ2つのTraceについて複数のRelationを作る必要はないと考え、

同一Trace間の関連は1つだけというルールにした。

## リレーションサンプル

Trace:

| id  | title      |
| --- | ---------- |
| 1   | PHP Array  |
| 2   | Collection |
| 3   | map()      |
| 4   | filter()   |

TraceRelation:

| id  | from_trace_id | to_trace_id | relation_tyep |
| --- | ------------- | ----------- | ------------- |
| 1   | 1             | 2           | prerequisite  |
| 2   | 2             | 3           | child         |
| 3   | 3             | 4           | related       |
| 4   | 2             | 4           | child         |

### 前提知識(prerequisite)

`PHP Array -> Collection`

Collectionを理解する上で、PHP Arrayの知識が前提となる。

### 子知識(child)

`Collection -> map()`, `Collection -> filter()`

Collectionという大きな知識から、map()やfilter()という具体的な知識に繋がっている。

## 単純関連(related)

`map() - filter()`

map()とfilter()はCollectionのメソッドとして関連している。

