# TraceRelation

TraceNoteにおける知識リレーション(TraceRelation)の定義を記載。

## 実装方針

> Trace同士を自己参照多対多で関連付け、その関係を relation_type によって表現する。

## コンセプト

> 一つの知識関係には、一つの意味だけを持たせる

複数の`relation_type`や逆方向のリレーションを許可すると、
知識同士の関係が曖昧になり、管理や理解が難しくなる。

TraceNoteでは、一組のTraceに対して一つのリレーションのみを持つことで、
知識の繋がりをシンプルかつ一貫して表現する。

## ルール

- 同じ2つのTraceにはリレーションは1つだけ
- 向きも1つだけ

```
A -> B (relation_type1)
```

のリレーションが存在するとき:

```
B -> A 
```

は存在しない。

また、

```
A -> B (relation_type2)
```

のような異なる`relation_type`の登録も禁止する。

## relation_type

定義ファイル: `app/Enums/TraceRelationType.php`

```php
<?php
case PREREQUISITE = 'prerequisite'; // 前提知識
case CHILD = 'child';               // 子知識
case RELATED = 'related';           // 関連知識
```

定義:

- PREREQUISITE: 理解を支える土台となる知識
    `from -> to`: from は to を理解するための前提知識

- CHILD: ある知識をさらに細かく分解した知識
    `from -> to`: to は from をさらに詳細化した知識

- RELATED: 一緒に考えると理解が深まる知識
    `from -> to`: from と to は関連知識

## イメージ

```
PHP Array
    |
    | PREREQUISITE
    v
Collection
    |
    | CHILD
    v
map()
```

## 今後検討したいこと

- タイムライン
- relation_typeの追加
- グラフ表示

