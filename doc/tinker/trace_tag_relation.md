# TraceとTagのリレーション確認

> $trace->tags()->attach($tagId); で遊ぶ

```php
$trace = App\Models\Trace::first();

$tag = App\Models\Tag::first();

$trace->tags()->attach($tag->id); // nullが返る

// 確認
$trace->tags;
$tag->traces;
```

