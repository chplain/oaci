<?php defined ('OACI') || exit ('此檔案不允許讀取。');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2013 - 2018, OACI
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

class AdminSort {
  const KEY = '_o';
  const SPLIT_KEY = ':';

  private $sort = 'id DESC';

  public function __construct ($sort = '') {
    if ($sort && count ($sort = array_values (array_filter (array_map ('trim', explode (' ', $sort))))) == 2 && in_array (strtolower ($sort[1]), array ('desc', 'asc')))
      $this->sort = $sort[0] . ' ' . strtoupper ($sort[1]);

    if (($sort = Input::get (AdminSort::KEY)) && count ($sort = array_values (array_filter (array_map ('trim', explode (AdminSort::SPLIT_KEY, $sort))))) == 2 && in_array (strtolower ($sort[1]), array ('desc', 'asc')))
      $this->sort = $sort[0] . ' ' . strtoupper ($sort[1]);
  }
  
  public static function set ($title, $column = '') {
    if (!$column) return $title;

    $gets = Input::get ();
    
    if (!(isset ($gets[AdminSort::KEY]) && count ($sort = array_values (array_filter (explode (AdminSort::SPLIT_KEY, $gets[AdminSort::KEY])))) == 2 && in_array (strtolower ($sort[1]), array ('desc', 'asc')) && ($sort[0] == $column))) {
      $gets[AdminSort::KEY] = $column . AdminSort::SPLIT_KEY . 'desc';
      return $title . ' <a href="' . URL::current () . '?' . http_build_query ($gets) . '" class="sort"></a>';
    }
    $class = strtolower ($sort[1]);
    if ($class != 'asc')
      $gets[AdminSort::KEY] = $column . AdminSort::SPLIT_KEY . 'asc';
    else
      unset ($gets[AdminSort::KEY]);

    return $title . ' <a href="' . URL::current () . '?' . http_build_query ($gets) . '" class="sort ' . $class . '"></a>';
  }

  private static function _desc ($column = '') {
    return ($column ? $column : 'id') . ' ' . strtoupper ('desc');
  }

  private static function _asc ($column = '') {
    return ($column ? $column : 'id') . ' ' . strtoupper ('asc');
  }

  public function __call ($name, $arguments) {
    switch (strtolower (trim ($name))) {
      case 'asc':
        $this->sort = call_user_func_array (array ('self', '_asc'), $arguments);
        break;

      case 'desc':
        $this->sort = call_user_func_array (array ('self', '_desc'), $arguments);
        break;

      default:
        gg ('AdminSort 沒有「' . $name . '」方法。');
        break;
    }
    return $this;
  }

  public static function __callStatic ($name, $arguments) {
    switch (strtolower (trim ($name))) {
      case 'asc':
        return AdminSort::create (call_user_func_array (array ('self', '_asc'), $arguments));
        break;

      case 'desc':
        return AdminSort::create (call_user_func_array (array ('self', '_desc'), $arguments));
        break;

      default:
        gg ('AdminSort 沒有「' . $name . '」方法。');
        break;
    }
  }

  public function __toString () {
    return $this->toString ();
  }

  public function toString () {
    return $this->sort;
  }

  public static function create ($sort = '') {
    return new AdminSort ($sort);
  }
}