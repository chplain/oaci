<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Admin_controller extends Oa_controller {

  public function __construct () {
    parent::__construct ();
    $this->load->helper ('identity');

    $this
         ->set_componemt_path ('component', 'admin')
         ->set_frame_path ('frame', 'admin')
         ->set_content_path ('content', 'admin')
         ->set_public_path ('public')

         ->set_title ("OA's CI")

         ->_add_meta ()
         ->_add_css ()
         ->_add_js ()
         ;
  }

  private function _add_meta () {
    return $this;
  }

  private function _add_css () {
    return $this;
  }

  private function _add_js () {
    return $this->add_js (base_url (utilitySameLevelPath ('resource', 'javascript', 'jquery_v1.10.2', 'jquery-1.10.2.min.js')))
                ;
  }
}