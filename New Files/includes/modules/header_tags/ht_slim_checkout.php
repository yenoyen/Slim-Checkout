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

      require('includes/classes/osc_template_ext.php');
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
                   'MODULE_HEADER_TAGS_SLIM_CHECKOUT_SORT_ORDER');
    }
   
  }

?>
