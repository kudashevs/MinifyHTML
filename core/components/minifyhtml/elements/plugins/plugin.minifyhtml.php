<?php
/**
 * MODx Revolution plugin which minify output HTML code
 *
 * @package minifyhtml
 * @var modX $modx
 */
if ($modx->event->name == 'OnWebPagePrerender') {
    $cid = $modx->resource->get('id');

    if (empty($cid)) {
        return;
    }

    $output = &$modx->resource->_output;
    $pattern = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');
    $replace = array('>', '<', '\\1');
    $output = preg_replace($pattern, $replace, $output);
}