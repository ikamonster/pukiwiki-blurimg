# PukiWiki用プラグイン<br>ぼかし画像表示 blurimg.inc.php

ぼかし画像を表示する[PukiWiki](https://pukiwiki.osdn.jp/)用プラグイン。  
img標準プラグインと使い方は同じですが、画像がぼかされて表示されます。  
マウスオーバーまたはタッチでぼかしが解除されます。  
ぼかしフィルター非対応のレガシーブラウザーでは、ぼかしの代わりに灰色の塗り潰しで画像が隠されます。

|対象PukiWikiバージョン|対象PHPバージョン|
|:---:|:---:|
|PukiWiki 1.5.3 ~ 1.5.4RC (UTF-8)|PHP 7.4 ~ 8.1|

## インストール

下記GitHubページからダウンロードした blurimg.inc.php を PukiWiki の plugin ディレクトリに配置してください。

[https://github.com/ikamonster/pukiwiki-blurimg](https://github.com/ikamonster/pukiwiki-blurimg)

## 使い方

プラグイン名を blurimg とするだけで、引数などは img 標準プラグインと同じ。

## 使用例

```
#blurimg(lenna.jpg)
```

## 設定

ソース内の下記の定数で動作を制御することができます。

|定数名|値|既定値|意味|
|:---|:---:|:---:|:---|
|PLUGIN_BLURIMG_BLUR_RADIUS|数値|16|ぼかし半径（px単位）|
|PLUGIN_BLURIMG_DURATION|数値|250|ぼかし解除時間（ms単位）|
|PLUGIN_BLURIMG_DOUBLECLICK|0 or 1|1|ダブルクリックで画像ファイルのURLに遷移|
