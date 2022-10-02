<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
blurimg.inc.php, v1.0.1 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

ぼかし画像を表示するPukiWiki用プラグイン。

img標準プラグインと使い方は同じですが、画像がぼかされて表示されます。マウスオーバーまたはタッチでぼかしが解除されます。ぼかしフィルター非対応のレガシーブラウザーでは、ぼかしの代わりに灰色の塗り潰しで画像が隠されます。

【使い方】
img標準プラグインと同じ。
*/

/////////////////////////////////////////////////
// ぼかし画像表示プラグイン設定（blurimg.inc.php）
if (!defined('PLUGIN_BLURIMG_BLUR_RADIUS')) define('PLUGIN_BLURIMG_BLUR_RADIUS', 16);  // ぼかし半径（px単位）
if (!defined('PLUGIN_BLURIMG_DURATION'))    define('PLUGIN_BLURIMG_DURATION',    250); // ぼかし解除時間（ms単位）
if (!defined('PLUGIN_BLURIMG_DOUBLECLICK')) define('PLUGIN_BLURIMG_DOUBLECLICK', 1);   // ダブルクリックで画像ファイルのURLに遷移

function plugin_blurimg_convert() {
	return plugin_blurimg_makeTag(func_get_args(), false);
}

function plugin_blurimg_inline() {
	return plugin_blurimg_makeTag(func_get_args(), true);
}

function plugin_blurimg_makeTag($args, $inline) {
	$img = '';

	if (($inline && exist_plugin_inline('img')) || (!$inline && exist_plugin_convert('img'))) {
		if (!end($args)) array_pop($args);
		$args = implode(',', $args);

		$img = ($inline)? do_plugin_inline('img', $args, $v) : do_plugin_convert('img', $args);

		$code = (PKWK_ALLOW_JAVASCRIPT && PLUGIN_BLURIMG_DOUBLECLICK)? ' ondblclick="window.location.href=this.getAttribute(\'data-blurimg\')"' : '';
		$img = str_replace('href=', $code . ' ontouchstart="" data-blurimg=', $img);
	}

	static	$included = false;
	if (!$included) {
		$radius = PLUGIN_BLURIMG_BLUR_RADIUS;
		$duration = PLUGIN_BLURIMG_DURATION;
		$img .= <<<EOT
<style>
a[data-blurimg]:hover{background-color:transparent}
a[data-blurimg]{display:inline-block;position:relative;width:auto;height:auto;z-index:0;overflow:hidden}
a[data-blurimg]::before{display:block;position:absolute;left:0;top:0;content:'';width:100%;height:100%;z-index:1;margin:0;padding:0;background-color:gray;opacity:1;-webkit-transition:opacity 100ms;transition:opacity 100ms;}
a[data-blurimg]:hover::before{opacity:0;-webkit-transition:opacity {$duration}ms 50ms;transition:opacity {$duration}ms 50ms}
@supports ((-webkit-filter:blur({$radius}px)) or (filter:blur({$radius}px))) {
a[data-blurimg] img{-webkit-filter:blur({$radius}px);filter:blur({$radius}px);-webkit-transition:100ms;transition:100ms}
a[data-blurimg]:hover img{-webkit-filter:none;filter:none;-webkit-transition:{$duration}ms 50ms;transition:{$duration}ms 50ms}
a[data-blurimg]::before{display:none}
}
</style>
EOT;
		$included = true;
	}

	return $img;
}
