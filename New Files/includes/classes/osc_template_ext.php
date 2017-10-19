<?php
/*
  $Id$ oscTemplateExt.php
  $Loc$ includes/classes/

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2017 osCommerce

  Released under the GNU General Public License
*/

  if (class_exists('oscTemplate')) {
    class oscTemplateExt extends oscTemplate {
    public $_blocks = array();
    public $_grid_container_width = 12;
    public $_grid_content_width = BOOTSTRAP_CONTENT;
    public $_grid_column_width = 0; // deprecated
    public $_page;
    public $_hide_array;
    public $_hide_columns = false;
  
      function __construct() {
        global $PHP_SELF, $oscTemplate;
        $this->_blocks = $oscTemplate->_blocks;
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
          return $this->_grid_container_width;
        } else {
          return $this->_grid_content_width;
        }
      }
  
      function getGridColumnWidth() {
        if ( $this->_hide_columns === true ) {
          return 0;
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
        if ( ($this->_hide_array[$group] == '0' || strpos($this->_page, 'checkout') === false) && ($this->_hide_array[$group] < '2' || $this->_page != 'shopping_cart.php') ) {
          $this->_content[$group][] = $content;
        }
      }

    }
  }
?>
