<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  use OSC\OM\OSCOM;

  class cfg_modules {
    var $_modules = array();

    function cfg_modules() {
      global $PHP_SELF;

      $file_extension = substr($PHP_SELF, strrpos($PHP_SELF, '.'));
      $directory = OSCOM::getConfig('dir_root') . 'includes/modules/cfg_modules';

      if ($dir = @dir($directory)) {
        while ($file = $dir->read()) {
          if (!is_dir($directory . $file)) {
            if (substr($file, strrpos($file, '.')) == $file_extension) {
              $class = substr($file, 0, strrpos($file, '.'));

              include(OSCOM::getConfig('dir_root') . 'includes/languages/' . $_SESSION['language'] . '/modules/cfg_modules/' . $file);
              include(OSCOM::getConfig('dir_root') . 'includes/modules/cfg_modules/' . $class . '.php');

              $m = new $class();

              $this->_modules[] = array('code' => $m->code,
                                        'directory' => $m->directory,
                                        'language_directory' => $m->language_directory,
                                        'key' => $m->key,
                                        'title' => $m->title,
                                        'template_integration' => $m->template_integration);
            }
          }
        }
      }
    }

    function getAll() {
      return $this->_modules;
    }

    function get($code, $key) {
      foreach ($this->_modules as $m) {
        if ($m['code'] == $code) {
          return $m[$key];
        }
      }
    }

    function exists($code) {
      foreach ($this->_modules as $m) {
        if ($m['code'] == $code) {
          return true;
        }
      }

      return false;
    }
  }
?>
