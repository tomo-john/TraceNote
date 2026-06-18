# コマンドメモ

## Zone.Identifier 消す

```bash
# 全部
find . -name "*:Zone.Identifier" -delete

# docsディレクトリのみ対象
find docs -name "*:Zone.Identifier" -delete
```

