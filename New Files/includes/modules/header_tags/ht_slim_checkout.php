<?php
/*
  $Id$
   by @raiwa Rainer Schmied / info@oscaddons.com  / www.oscaddons.com
  
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
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Slim Checkout', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_STATUS', 'True', 'Enable this module?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Hide Navbar', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_NAVBAR', '0', 'Hide the Navabr module on Checkout Pages?<br>0 = Do Not Hide<br>1 = Hide on Checkout Pages<br>2 = Hide on Shopping Cart and Checkout Pages', '6', '3', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Hide Header Area Modules', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_HEADER', '0', 'Hide the modules in the Header Area on Checkout Pages?<br>0 = Do Not Hide<br>1 = Hide on Checkout Pages<br>2 = Hide on Shopping Cart and Checkout Pages', '6', '3', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Hide Side Column Boxes', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_BOXES', '1', 'Hide the Side Column Boxes on Checkout Pages?<br>0 = Do Not Hide<br>1 = Hide on Checkout Pages<br>2 = Hide on Shopping Cart and Checkout Pages', '6', '3', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Hide Footer Modules', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_FOOTER', '0', 'Hide the Footer Modules on Checkout Pages?<br>0 = Do Not Hide<br>1 = Hide on Checkout Pages<br>2 = Hide on Shopping Cart and Checkout Pages', '6', '3', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Hide Footer Suffix Modules', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_FOOTER_SUFFIX', '0', 'Hide the Footer Suffix Modules on Checkout Pages?<br>0 = Do Not Hide<br>1 = Hide on Checkout Pages<br>2 = Hide on Shopping Cart and Checkout Pages', '6', '3', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Exclude Header Logo', 'MODULE_HEADER_TAGS_SLIM_HEADER_LOGO', 'True', 'Show the Store Logo in the Header area always, even the other header modules are hidden?<br> Show it always = True<br>Hide it also if header area is hidden = False.', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Content Width', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_CONTENT_WIDTH', '8', 'Content width if side columns are hidden.<br>Should be a pair value between the normal main content width (default = 8) => no content stretch, and the max width (12) => stretch content to full width.<br>Usual values: 8, 10 or 12', '6', '3', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_SLIM_CHECKOUT_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '27', now())");
    }

    function remove() {
      tep_db_query("delete from configuration where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_HEADER_TAGS_SLIM_CHECKOUT_STATUS',
                   'MODULE_HEADER_TAGS_SLIM_CHECKOUT_NAVBAR',
                   'MODULE_HEADER_TAGS_SLIM_CHECKOUT_HEADER',
                   'MODULE_HEADER_TAGS_SLIM_CHECKOUT_BOXES',
                   'MODULE_HEADER_TAGS_SLIM_CHECKOUT_FOOTER',
                   'MODULE_HEADER_TAGS_SLIM_CHECKOUT_FOOTER_SUFFIX',
                   'MODULE_HEADER_TAGS_SLIM_HEADER_LOGO', 
                   'MODULE_HEADER_TAGS_SLIM_CHECKOUT_CONTENT_WIDTH', 
                   'MODULE_HEADER_TAGS_SLIM_CHECKOUT_SORT_ORDER');
    }
   
  } // end class
  

  if (class_exists('oscTemplate')) {
    class oscTemplateExt extends oscTemplate {
    public $_blocks = array();
    public $_content = array();
    public $_grid_container_width = 12;
    public $_grid_content_width = BOOTSTRAP_CONTENT;
    public $_grid_column_width = 0; // deprecated
    public $_page;
    public $_hide_array;
    public $_hide_columns = false;
  
      function __construct() {
        global $PHP_SELF, $oscTemplate;
        $this->_blocks = $oscTemplate->_blocks;
        $this->_content = $oscTemplate->_content;
        $this->_grid_container_width = $oscTemplate->_grid_container_width;
        $this->_grid_column_width = $oscTemplate->_grid_column_width;
        $this->_page = $PHP_SELF;
        $this->_hide_array = array('navigation' => MODULE_HEADER_TAGS_SLIM_CHECKOUT_NAVBAR, 
                                   'header' => MODULE_HEADER_TAGS_SLIM_CHECKOUT_HEADER, 
                                   'footer' => MODULE_HEADER_TAGS_SLIM_CHECKOUT_FOOTER, 
                                   'footer_suffix' => MODULE_HEADER_TAGS_SLIM_CHECKOUT_FOOTER_SUFFIX);
      }
    
      function getGridContentWidth() {
        if ( $this->_hide_columns === true ) {
          return MODULE_HEADER_TAGS_SLIM_CHECKOUT_CONTENT_WIDTH;
        } else {
          return $this->_grid_content_width;
        }
      }
  
      function getGridColumnWidth() {
        if ( $this->_hide_columns === true ) {
          return (12 - MODULE_HEADER_TAGS_SLIM_CHECKOUT_CONTENT_WIDTH) / 2;
        } else {
          return (12 - BOOTSTRAP_CONTENT) / 2;
        }
      }
  
      function getBlocks($group) {
        if ( ((MODULE_HEADER_TAGS_SLIM_CHECKOUT_BOXES > '0' && strpos($this->_page, 'checkout') !== false)) || (MODULE_HEADER_TAGS_SLIM_CHECKOUT_BOXES == '2' && $this->_page == 'shopping_cart.php') ) {
          $this->_hide_columns = true;
        }  
        if ( $this->hasBlocks($group) && ((strpos($group, 'boxes_column') === false) || $this->_hide_columns !== true) ) {
          return implode("\n", $this->_blocks[$group]);
        }
      }

      function addContent($content, $group) {
        if ( $group == 'header' || (($this->_hide_array[$group] == '0' || strpos($this->_page, 'checkout') === false) && ($this->_hide_array[$group] < '2' || $this->_page != 'shopping_cart.php')) ) {
          $this->_content[$group][] = $content;
        }
      }

      function getContent($group) {
        global $language;
  
        if ( !class_exists('tp_' . $group) && file_exists('includes/modules/pages/tp_' . $group . '.php') ) {
          include('includes/modules/pages/tp_' . $group . '.php');
        }
  
        if ( class_exists('tp_' . $group) ) {
          $template_page_class = 'tp_' . $group;
          $template_page = new $template_page_class();
          $template_page->prepare();
        }
  
        foreach ( $this->getContentModules($group) as $module ) {

//          echo '<br><br>$group' . $group;
//          echo '<br><br>$module' . $module;

          
          if ( !class_exists($module) ) {
            if ( $group != 'header' || ($module == 'cm_header_logo' && MODULE_HEADER_TAGS_SLIM_HEADER_LOGO == 'True') || (($this->_hide_array[$group] == '0' || strpos($this->_page, 'checkout') === false) && ($this->_hide_array[$group] < '2' || $this->_page != 'shopping_cart.php')) ) { 
              if ( file_exists('includes/modules/content/' . $group . '/' . $module . '.php') ) {
                if ( file_exists('includes/languages/' . $language . '/modules/content/' . $group . '/' . $module . '.php') ) {
                  include('includes/languages/' . $language . '/modules/content/' . $group . '/' . $module . '.php');
                }
    
                include('includes/modules/content/' . $group . '/' . $module . '.php');
              }
            }
          }
  
          if ( class_exists($module) ) {
            $mb = new $module();
  
            if ( $mb->isEnabled() ) {
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

    }
  }

?>
