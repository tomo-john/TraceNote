# Level Rules

## 目的

TraceNoteでは、登録したTrace数に応じてLevelが上がる。

Levelが上がるほど、次のLevelに必要なTrace数が増える。
序盤はLevelを上げやすくし、継続するほど成長に必要なTrace数を増やす。

## 経験値テーブル

| Level | 必要Trace数 | 総Trace数 |
| ----- | ----------: | --------: |
| 0     | 1           | 0         |
| 1     | 2           | 1         |
| 2     | 2           | 3         |
| 3     | 3           | 5         |
| 4     | 3           | 8         |
| 5     | 3           | 11        |
| 6     | 4           | 14        |
| 7     | 4           | 18        |
| 8     | 4           | 22        |
| 9     | 4           | 26        |
| 10    | 5           | 30        |
| 11    | ...         | 35        |

## Levelアップのルール

必要Trace数を1つのまとまりとして扱う。

- 必要Trace数 1：1回
- 必要Trace数 2：2回
- 必要Trace数 3：3回
- 必要Trace数 4：4回
- ...

つまり、必要Trace数がNの場合、その必要Trace数をN回繰り返してLevelが上がる。

### 例

```text
必要Trace数 1 × 1回
必要Trace数 2 × 2回
必要Trace数 3 × 3回
必要Trace数 4 × 4回
```

そのため、Levelが上がるほど次のLevelまでに必要なTrace数が徐々に増えていく。

## LevelInfo

GrowthServiceでは、現在のTrace数から以下の情報を取得する。

- 現在のLevel
- 現在のTrace数
- 次のLevelまでに必要なTrace数
- 現在のLevelの進捗率

```php
<?php
[
    'level' => 6,
    'traceCount' => 15,
    'remainingTraces' => 3,
    'progress' => 25,
]
```

## 成長の流れ

```text
Trace数
  ↓
Level
  ↓
LevelInfo
  ├─ Level
  ├─ Trace数
  ├─ 次のLevelまであと何Trace
  └─ 進捗率
```

Levelは今後、犬の成長段階を決定するためにも利用する。

