<?php
/*
  $Id$
  Slim Checkout by @raiwa Rainer Schmied / info@oscaddons.com  / www.oscaddons.com
  
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2017 osCommerce

  Released under the GNU General Public License
*/

  class ht_slim_checkout {
    var $code = 'ht_slim_checkout';
    var $group = 'header_tags';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function __construct() {
      $this->title = MODULE_HEADER_TAGS_SLIM_CHECKOUT_TITLE;
      $this->description = MODULE_HEADER_TAGS_SLIM_CHECKOUT_DESCRIPTION;

      if ( defined('MODULE_HEADER_TAGS_SLIM_CHECKOUT_STATUS') ) {
        $this->sort_order = MODULE_HEADER_TAGS_SLIM_CHECKOUT_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_SLIM_CHECKOUT_STATUS == 'True');
      }
    }

    function execute() {
      global $oscTemplate;

      $oscTemplate = new oscTemplateExt;

    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_HEADER_TAGS_SLIM_CHECKOUT_STATUS');
    }

    function install() {
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Current Version', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_VERSION', '1.0', 'Read only.', '6', '1', 'tep_version_readonly(', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Slim Checkout', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_STATUS', 'True', 'Enable this module?', '6', '2', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Hide Navbar', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_NAVBAR', '0', 'Hide the Navabar module on Checkout Pages?', '6', '3', 'ht_slim_navbar_show_pages', 'ht_slim_navbar_edit_pages(', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Hide Header Area Modules', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_HEADER', '" . implode(';', $this->get_default_pages()) . "', 'Hide the modules in the Header Area on Checkout Pages?', '6', '4', 'ht_slim_header_show_pages', 'ht_slim_header_edit_pages(', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Hide Side Column Boxes', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_BOXES', '" . implode(';', $this->get_default_pages()) . "', 'Hide the Side Column Boxes on Checkout Pages?', '6', '5', 'ht_slim_boxes_show_pages', 'ht_slim_boxes_edit_pages(', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Hide Footer Modules', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_FOOTER', '" . implode(';', $this->get_default_pages()) . "', 'Hide the Footer Modules on Checkout Pages?', '6', '6', 'ht_slim_footer_show_pages', 'ht_slim_footer_edit_pages(', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Hide Footer Suffix Modules', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_FOOTER_SUFFIX', '0', 'Hide the Footer Suffix Modules on Checkout Pages?', '6', '7', 'ht_slim_footer_suffix_show_pages', 'ht_slim_footer_suffix_edit_pages(', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Exclude Header Modules', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_EXCLUDE', 'cm_header_logo', 'List of modules to show always in the header area, even the header module area is hidden?<br>Comma separated list.<br>Only for header modules: \"cm_header_...\"', '6', '8', 'tep_textarea(', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Content Width', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_CONTENT_WIDTH', '8', 'Content width if side columns are hidden.<br>Should be a pair value between the normal main content width (default = 8) => no content stretch, and the max width (12) => stretch content to full width.<br>Usual values: 8, 10 or 12', '6', '9', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '11', now())");
    }

    function remove() {
      tep_db_query("delete from configuration where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_HEADER_TAGS_SLIM_CHECKOUT_VERSION', 
                   'MODULE_HEADER_TAGS_SLIM_CHECKOUT_STATUS',
                   'MODULE_HEADER_TAGS_SLIM_CHECKOUT_NAVBAR',
                   'MODULE_HEADER_TAGS_SLIM_CHECKOUT_HEADER',
                   'MODULE_HEADER_TAGS_SLIM_CHECKOUT_BOXES',
                   'MODULE_HEADER_TAGS_SLIM_CHECKOUT_FOOTER',
                   'MODULE_HEADER_TAGS_SLIM_CHECKOUT_FOOTER_SUFFIX',
                   'MODULE_HEADER_TAGS_SLIM_CHECKOUT_EXCLUDE', 
                   'MODULE_HEADER_TAGS_SLIM_CHECKOUT_CONTENT_WIDTH', 
                   'MODULE_HEADER_TAGS_SLIM_CHECKOUT_SORT_ORDER');
    }
   
    function get_default_pages() {
      return array('checkout_shipping.php',
                   'checkout_payment.php',
                   'checkout_confirmation.php');
    }
  } // end class

  function ht_slim_navbar_show_pages($text) {
    return nl2br(implode("\n", explode(';', $text)));
  }

  function ht_slim_navbar_edit_pages($values, $key) {
    global $PHP_SELF;

    $files_array = get_controlled_pages();

    $values_array = explode(';', $values);

    $output = '';
    foreach ($files_array as $file) {
      $output .= tep_draw_checkbox_field('ht_slim_navbar_file[]', $file, in_array($file, $values_array)) . '&nbsp;' . tep_output_string($file) . '<br />';
    }

    if (!empty($output)) {
      $output = '<br />' . substr($output, 0, -6);
    }

    $output .= tep_draw_hidden_field('configuration[' . $key . ']', '', 'id="htrn_navbar_files"');

    $output .= '<script>
                function htrn_navbar_update_cfg_value() {
                  var htrn_navbar_selected_files = \'\';

                  if ($(\'input[name="ht_slim_navbar_file[]"]\').length > 0) {
                    $(\'input[name="ht_slim_navbar_file[]"]:checked\').each(function() {
                      htrn_navbar_selected_files += $(this).attr(\'value\') + \';\';
                    });

                    if (htrn_navbar_selected_files.length > 0) {
                      htrn_navbar_selected_files = htrn_navbar_selected_files.substring(0, htrn_navbar_selected_files.length - 1);
                    }
                  }

                  $(\'#htrn_navbar_files\').val(htrn_navbar_selected_files);
                }

                $(function() {
                  htrn_navbar_update_cfg_value();

                  if ($(\'input[name="ht_slim_navbar_file[]"]\').length > 0) {
                    $(\'input[name="ht_slim_navbar_file[]"]\').change(function() {
                      htrn_navbar_update_cfg_value();
                    });
                  }
                });
                </script>';

    return $output;
  }
  
  function ht_slim_header_show_pages($text) {
    return nl2br(implode("\n", explode(';', $text)));
  }

  function ht_slim_header_edit_pages($values, $key) {
    global $PHP_SELF;

    $files_array = get_controlled_pages();

    $values_array = explode(';', $values);

    $output = '';
    foreach ($files_array as $file) {
      $output .= tep_draw_checkbox_field('ht_slim_header_file[]', $file, in_array($file, $values_array)) . '&nbsp;' . tep_output_string($file) . '<br />';
    }

    if (!empty($output)) {
      $output = '<br />' . substr($output, 0, -6);
    }

    $output .= tep_draw_hidden_field('configuration[' . $key . ']', '', 'id="htrn_header_files"');

    $output .= '<script>
                function htrn_header_update_cfg_value() {
                  var htrn_header_selected_files = \'\';

                  if ($(\'input[name="ht_slim_header_file[]"]\').length > 0) {
                    $(\'input[name="ht_slim_header_file[]"]:checked\').each(function() {
                      htrn_header_selected_files += $(this).attr(\'value\') + \';\';
                    });

                    if (htrn_header_selected_files.length > 0) {
                      htrn_header_selected_files = htrn_header_selected_files.substring(0, htrn_header_selected_files.length - 1);
                    }
                  }

                  $(\'#htrn_header_files\').val(htrn_header_selected_files);
                }

                $(function() {
                  htrn_header_update_cfg_value();

                  if ($(\'input[name="ht_slim_header_file[]"]\').length > 0) {
                    $(\'input[name="ht_slim_header_file[]"]\').change(function() {
                      htrn_header_update_cfg_value();
                    });
                  }
                });
                </script>';

    return $output;
  }

  function ht_slim_boxes_show_pages($text) {
    return nl2br(implode("\n", explode(';', $text)));
  }

  function ht_slim_boxes_edit_pages($values, $key) {
    global $PHP_SELF;

    $files_array = get_controlled_pages();

    $values_array = explode(';', $values);

    $output = '';
    foreach ($files_array as $file) {
      $output .= tep_draw_checkbox_field('ht_slim_boxes_file[]', $file, in_array($file, $values_array)) . '&nbsp;' . tep_output_string($file) . '<br />';
    }

    if (!empty($output)) {
      $output = '<br />' . substr($output, 0, -6);
    }

    $output .= tep_draw_hidden_field('configuration[' . $key . ']', '', 'id="htrn_boxes_files"');

    $output .= '<script>
                function htrn_boxes_update_cfg_value() {
                  var htrn_boxes_selected_files = \'\';

                  if ($(\'input[name="ht_slim_boxes_file[]"]\').length > 0) {
                    $(\'input[name="ht_slim_boxes_file[]"]:checked\').each(function() {
                      htrn_boxes_selected_files += $(this).attr(\'value\') + \';\';
                    });

                    if (htrn_boxes_selected_files.length > 0) {
                      htrn_boxes_selected_files = htrn_boxes_selected_files.substring(0, htrn_boxes_selected_files.length - 1);
                    }
                  }

                  $(\'#htrn_boxes_files\').val(htrn_boxes_selected_files);
                }

                $(function() {
                  htrn_boxes_update_cfg_value();

                  if ($(\'input[name="ht_slim_boxes_file[]"]\').length > 0) {
                    $(\'input[name="ht_slim_boxes_file[]"]\').change(function() {
                      htrn_boxes_update_cfg_value();
                    });
                  }
                });
                </script>';

    return $output;
  }

  function ht_slim_footer_show_pages($text) {
    return nl2br(implode("\n", explode(';', $text)));
  }

  function ht_slim_footer_edit_pages($values, $key) {
    global $PHP_SELF;

    $files_array = get_controlled_pages();

    $values_array = explode(';', $values);

    $output = '';
    foreach ($files_array as $file) {
      $output .= tep_draw_checkbox_field('ht_slim_footer_file[]', $file, in_array($file, $values_array)) . '&nbsp;' . tep_output_string($file) . '<br />';
    }

    if (!empty($output)) {
      $output = '<br />' . substr($output, 0, -6);
    }

    $output .= tep_draw_hidden_field('configuration[' . $key . ']', '', 'id="htrn_footer_files"');

    $output .= '<script>
                function htrn_footer_update_cfg_value() {
                  var htrn_footer_selected_files = \'\';

                  if ($(\'input[name="ht_slim_footer_file[]"]\').length > 0) {
                    $(\'input[name="ht_slim_footer_file[]"]:checked\').each(function() {
                      htrn_footer_selected_files += $(this).attr(\'value\') + \';\';
                    });

                    if (htrn_footer_selected_files.length > 0) {
                      htrn_footer_selected_files = htrn_footer_selected_files.substring(0, htrn_footer_selected_files.length - 1);
                    }
                  }

                  $(\'#htrn_footer_files\').val(htrn_footer_selected_files);
                }

                $(function() {
                  htrn_footer_update_cfg_value();

                  if ($(\'input[name="ht_slim_footer_file[]"]\').length > 0) {
                    $(\'input[name="ht_slim_footer_file[]"]\').change(function() {
                      htrn_footer_update_cfg_value();
                    });
                  }
                });
                </script>';

    return $output;
  }

  function ht_slim_footer_suffix_show_pages($text) {
    return nl2br(implode("\n", explode(';', $text)));
  }

  function ht_slim_footer_suffix_edit_pages($values, $key) {
    global $PHP_SELF;

    $files_array = get_controlled_pages();
    
    $values_array = explode(';', $values);

    $output = '';
    foreach ($files_array as $file) {
      $output .= tep_draw_checkbox_field('ht_slim_footer_suffix_file[]', $file, in_array($file, $values_array)) . '&nbsp;' . tep_output_string($file) . '<br />';
    }

    if (!empty($output)) {
      $output = '<br />' . substr($output, 0, -6);
    }

    $output .= tep_draw_hidden_field('configuration[' . $key . ']', '', 'id="htrn_footer_suffix_files"');

    $output .= '<script>
                function htrn_footer_suffix_update_cfg_value() {
                  var htrn_footer_suffix_selected_files = \'\';

                  if ($(\'input[name="ht_slim_footer_suffix_file[]"]\').length > 0) {
                    $(\'input[name="ht_slim_footer_suffix_file[]"]:checked\').each(function() {
                      htrn_footer_suffix_selected_files += $(this).attr(\'value\') + \';\';
                    });

                    if (htrn_footer_suffix_selected_files.length > 0) {
                      htrn_footer_suffix_selected_files = htrn_footer_suffix_selected_files.substring(0, htrn_footer_suffix_selected_files.length - 1);
                    }
                  }

                  $(\'#htrn_footer_suffix_files\').val(htrn_footer_suffix_selected_files);
                }

                $(function() {
                  htrn_footer_suffix_update_cfg_value();

                  if ($(\'input[name="ht_slim_footer_suffix_file[]"]\').length > 0) {
                    $(\'input[name="ht_slim_footer_suffix_file[]"]\').change(function() {
                      htrn_footer_suffix_update_cfg_value();
                    });
                  }
                });
                </script>';

    return $output;
  }
  
  function get_controlled_pages() {
    $files_array = array('login.php',
                         'shopping_cart.php',
                         'checkout_shipping.php',
                         'checkout_payment.php',
                         'checkout_confirmation.php',
                         'checkout_success.php');    
    return $files_array;
  }

// Function to read in text area in admin
  if(!function_exists('tep_textarea')) {
    function tep_textarea($text, $key = '') {
      $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
      return tep_draw_textarea_field($name, false, 35, 5, $text);
    }
  }
  
// function show the version read only  
  if(!function_exists('tep_version_readonly')) {
  	function tep_version_readonly($value){
  		$version_text = '<br>Version ' . $value;
      return $version_text;
    }
  }

  if (class_exists('oscTemplate')) {
    class oscTemplateExt extends oscTemplate {
      public $_blocks = array();
      public $_hide_column = false;

      function __construct() {
        global $PHP_SELF, $oscTemplate;
        $this->_blocks = $oscTemplate->_blocks;
        // check if side columns are hidden
        if (in_array(basename($PHP_SELF), explode(';', MODULE_HEADER_TAGS_SLIM_CHECKOUT_BOXES))) $this->_hide_column = true;          
      }

      function getGridContentWidth() {
        if ( $this->_hide_column == true ) {
          return MODULE_HEADER_TAGS_SLIM_CHECKOUT_CONTENT_WIDTH; // define main content width if side columns are hidden
        } else {
          return $this->_grid_content_width;
        }
      }

      function getGridColumnWidth() {
        if ( $this->_hide_column == true ) { // define columns width if side columns are hidden
          return (12 - MODULE_HEADER_TAGS_SLIM_CHECKOUT_CONTENT_WIDTH) / 2;
        } else {
          return (12 - BOOTSTRAP_CONTENT) / 2;
        }
      }

      function getBlocks($group) {
        global $PHP_SELF;
        if ( $this->hasBlocks($group) && ((strpos($group, 'boxes_column') === false) || !in_array(basename($PHP_SELF), $this->checkPages('bm_'))) ) { // hide side columns
          return implode("\n", $this->_blocks[$group]);
        }
      }

      function getContent($group) {
        global $PHP_SELF, $language;
  
        if ( !class_exists('tp_' . $group) && file_exists('includes/modules/pages/tp_' . $group . '.php') ) {
          include('includes/modules/pages/tp_' . $group . '.php');
        }
  
        if ( class_exists('tp_' . $group) ) {
          $template_page_class = 'tp_' . $group;
          $template_page = new $template_page_class();
          $template_page->prepare();
        }
  
        foreach ( $this->getContentModules($group) as $module ) {
          if ( !class_exists($module) ) {
            if ( file_exists('includes/modules/content/' . $group . '/' . $module . '.php') ) {
              if ( file_exists('includes/languages/' . $language . '/modules/content/' . $group . '/' . $module . '.php') ) {
                include('includes/languages/' . $language . '/modules/content/' . $group . '/' . $module . '.php');
              }
  
              include('includes/modules/content/' . $group . '/' . $module . '.php');
            }
          }
  
          if ( class_exists($module) ) {
            $mb = new $module();
             if ( $mb->isEnabled() && !in_array(basename($PHP_SELF), $this->checkPages($module))) { // check if module should be hidden, get hidden pages array
              $mb->execute();
            }
          }
        }
  
        if ( class_exists('tp_' . $group) ) {
          $template_page->build();
        }
  
        if ($this->hasContent($group)) {
          return implode("\n", $this->_content[$group]);
        }
      }

      function checkPages($module){ //$module what is called in the and content modules
        global $PHP_SELF;
          if (strtok($module, '_') == 'bm') {
            $module_group_prefix = strtok($module, '_');
          } elseif ((strpos($module, 'cm_footer_extra') !== false)) {
            $module_group_prefix = 'footer_extra';
          } elseif (strtok($module, '_') == 'cm') {
            $module_group_prefix = (strtok($module, '_'.strtok($module, '_')));
          }          
          $hide_array[$module_group_prefix] = array();
          
          $hide_array['navbar'] =  explode(';', MODULE_HEADER_TAGS_SLIM_CHECKOUT_NAVBAR);
          if ( !in_array($module, explode(',', MODULE_HEADER_TAGS_SLIM_CHECKOUT_EXCLUDE)) ) {
            $hide_array['header'] =  explode(';', MODULE_HEADER_TAGS_SLIM_CHECKOUT_HEADER);
          }
          $hide_array['bm'] =  explode(';', MODULE_HEADER_TAGS_SLIM_CHECKOUT_BOXES);
          $hide_array['footer'] =  explode(';', MODULE_HEADER_TAGS_SLIM_CHECKOUT_FOOTER);
          $hide_array['footer_extra'] =  explode(';', MODULE_HEADER_TAGS_SLIM_CHECKOUT_FOOTER_SUFFIX);
  
          return $hide_array[$module_group_prefix];
      }

    } // end class
  } // end if class exists

?>
