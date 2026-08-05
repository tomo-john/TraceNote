# UI Components

## ディレクトリ

```bash
resources/views/components
|
|--- ui     # 汎用コンポーネント
|--- trace  # Trace専用
|--- tag    # Tag専用
```

## Component一覧

| Component              | Purpose               |
| ---------------------- | --------------------- |
| x-ui.button            | ボタン                |
| x-ui.card              | カード                |
| x-ui.dropdown-item     | ドロップダウン内      |
| x-ui.empty-state       | データなし表示        |
| x-ui.error             | エラー                |
| x-ui.input             | 入力欄                |
| x-ui.link              | リンク                |
| x-ui.logo              | アプリロゴ            |
| x-ui.modal             | モーダル              |
| x-ui.nav-link          | ナビリンク            |
| x-ui.select            | セレクトボックス      |
| x-ui.status-badge      | Traceステータスバッジ |
| x-ui.tag-badge         | タグバッジ            |
| x-ui.textarea          | テキストエリア        |
| x-trace.card           | Traceカード           |
| x-trace.page-header    | ページヘッダ          |
| x-trace.relation-card  | 関連Traceカード       |
| x-tag.card             | Tag表示               |

## 命名ルール

- `x-ui.*`：複数画面で再利用する汎用コンポーネント
- `x-trace.*`：Trace機能専用
- `x-tag.*`：Tag機能専用

汎用化できそうなものは`ui`へ移動する。

## memo

`badge`系は表示でのみ使用。ボタンやプレビューは現在非対応。
