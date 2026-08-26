# DI

## DI(Dependency Injection)とは？

必要な依存先のオブジェクトを、自分で作るのではなく外部から渡してもらう。

## newで作る場合

```php
<?php
class DashboardService
{
    private GrowthService $growthService;

    public function __construct()
    {
        $this->growthService = new GrowthService();
    }
}
```

この場合:

```
DashboardService -> 自分でGrowthServiceを作る -> new ...
```

=> GrowthServiceが必要だから自分で作るという責任まで持ってしまう

## 実際のコード(DI)

```php
<?php
class DashboardService
{
    public function __construct(private GrowthService $growthService) {}

    ...
}
```

```
Laravelのサービスコンテナ -> GrowthServiceを用意 -> DashboardServiceに渡す
```

## なぜTraceNoteでDashboardServiceがGrowthServiceにDIを使う？

DashboardServiceでGrowthServiceを利用する際に、

GrowthServiceを自分でnewして生成する責務まで持たせない方が良いと考えた。

DashboardServiceでは、GrowthServiceが必要であることをコンストラクタで宣言し、

GrowthServiceを実際に生成・解決する処理はLaravelのサービスコンテナに任す。

これにより、DashboardServiceはGrowthServiceを生成することではなく、GrowthServiceを利用することに集中できる。

