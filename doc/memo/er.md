# 下書き

```
User
 |-- Trace
 |-- Tag

Trace
 |-- Tag(多対多)
 |-- Trace(自己参照多対多)

TraceRelation
 |-- relation_type
```

- User : Trace = 1 : N
- User : Tag = 1 : N
- Trace : Tag = N : N

### trace_relations

```
id
trace_id
related_trace_id
relation_type
created_at
updated_at
```

### relation_type (Enum)

```
RELATED
PREREQUISITE
CHILD
```

### dbdiagram.io (ER図作成ツール)

ER図を作るなら一番おすすめ(?)

