# Service移譲

## なぜServiceを使おうと思ったか

Dashboardで表示するデータの取得や整形などの処理をControllerにまとめるのではなく、処理を担当するクラスとして分けて管理してみたかった。

## 最初はどういう構造だったか

Dashboardの実装を始める際から、Controllerにデータ取得や整形の処理をまとめず、DashboardServiceを作成して処理を分ける構成にした。

Growth関連は最初はDashboardServiceに記述していたが、その後GrowthServiceに分けた。

## DashboardServiceに移譲した理由

Controllerはリクエストを受けてServiceを呼び出し、Viewを返す役割とし、

Dashboardで使用するデータ取得や整形の処理はDashboardServiceに分けたかった。

## さらにGrowthServiceに分けた理由

Growthに関する処理は、Dashboardを表示するためだけの処理ではなく、ユーザーの成長情報を扱う処理そのものだと考えた。

=> 再利用できる可能性 + 責務の分離

=> Growthに関する処理をDashboard固有の処理から分離したかった

## 最終的な役割分担

- DashboardController
    - リクエストを受ける
    - DashboardServiceを呼び出す
    - 受け取ったデータをViewへ渡す

- DashboardService
    - Dashboard画面に必要な情報を取得・まとめる
    - 必要に応じてGrowthServiceを利用する
    - 呼び出し元へデータを返す

- GrowthService
    - 成長関連の処理を担当
    - Trace数によるレベル算出
    - 現在のレベルに応じた情報を算出

## ここで学んだこと

- Serviceクラスを利用した処理の分離
- クラスごとの責務を考えて処理を分けること
- Service間の依存関係とDI
- 単一アクションコントローラ(__invoke)

