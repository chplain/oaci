<?php

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2017 OA Wu Design
 * @license     http://creativecommons.org/licenses/by-nc/2.0/tw/
 */

class CSSMin {
  public static function minify ($css) {
    $comment     = '/\*[^*]*\*+(?:[^/*][^*]*\*+)*/';
    $dq = '"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"';
    $sq = "'[^'\\\\]*(?:\\\\.[^'\\\\]*)*'";
    $css = preg_replace ("<($dq|$sq)|$comment>Ss", "$1", $css);
    $css = preg_replace_callback ('<' . '\s*([@{};,])\s*' . '| \s+([\)])' . '| ([\(:])\s+' . '>xS', function ($m) { unset ($m[0]); return current (array_filter ($m)); }, $css);
    return trim ($css);
  }
}