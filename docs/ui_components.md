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

| Component        | Purpose            |
| ---------------- | ------------------ |
| x-ui.button      | ボタン             |
| x-ui.card        | カード             |
| x-ui.input       | 入力欄             |
| x-ui.select      | セレクトボックス   |
| x-ui.error       | バリデーション表示 |
| x-ui.empty-state | データなし表示     |
| x-ui.modal       | モーダル           |
| x-trace.card     | Trace表示          |
| x-tag.card       | Tag表示            |

## 命名ルール

- `x-ui.*`：複数画面で再利用する汎用コンポーネント
- `x-trace.*`：Trace機能専用
- `x-tag.*`：Tag機能専用

汎用化できそうなものは`ui`へ移動する。

