# Assets

Pass an array of allowed script and style handles. Any handle not includes will be removed from the WordPress asset queue. This also works with the [vite-4-wp](https://github.com/kucrut/vite-for-wp) assets.

```php
$asset_queue = new AssetQueue();
$asset_queue->filter(
    [ 'your_style' ],
    [ 'your_script' ]
);
```