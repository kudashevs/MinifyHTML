<?php
/**
 * MODx Revolution plugin which minify output HTML code
 *
 * @package minifyhtml
 * @var modX $modx
 */
if ($modx->event->name == 'OnWebPagePrerender') {
    $cid = $modx->resource->get('id');
    $excluded = $modx->getOption('minifyhtml.exclude', null, '');
    $removeNewlines = $modx->getOption('minifyhtml.newlines', null, true);
    $removeDoubleSpaces = $modx->getOption('minifyhtml.doubles', null, false);

    if (empty($cid) || in_array($cid, explode(',', trim($excluded)), false)) {
        return '';
    }

    // remove all space symbols after and before angle brackets
    $pattern = ['/\>[^\S]+/u', '/[^\S]+\</u'];
    $replace = ['>', '<'];

    if ($removeNewlines) {
        $pattern = array_merge($pattern, ['/(\r)?\n/u']);
        $replace = array_merge($replace, ['']);
    }

    if ($removeDoubleSpaces) {
        $pattern = array_merge($pattern, ['/(\s)+/u']);
        $replace = array_merge($replace, ['$1']);
    }

    $output = &$modx->resource->_output;
    $output = preg_replace($pattern, $replace, $output);
}