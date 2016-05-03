<?php
/**
* @package SPLIB
* @version $Id: Menu.php,v 1.1 2003/12/12 08:06:02 kevin Exp $
*/
/**
* Define constants for table column names
*/
@define ('MENU_TABLE','menu'); # Name of menu table
@define ('MENU_ID','menu_id'); # ID of menu item
@define ('MENU_PARENT_ID','parent_id'); # Parent ID column
@define ('MENU_NAME','name'); # Name of menu item (for humans);
@define ('MENU_DESCRIPTION','description'); # Description of menu item (for humans);
@define ('MENU_LOCATION','location'); # URI of menu
/**
* Menu Class
* Base class for building menus from database adjacency data
* @access protected
* @abstract
* @package SPLIB
*/
class Menu {
    /**
    * Database connection class
    * @access private
    * @var object
    */
    var $db;

    /**
    * Unsorted list of menu items
    * @access private
    * @var array
    */
    var $items;

    /**
    * Organised menu placed here
    * @access private
    * @var  array
    */
    var $menu;

    /**
    * Menu constructor
    * @access protected
    * @param object database connection
    */
    function Menu (& $db) {
        $this->db=& $db;
        $this->readMenu();
        $this->menu=array();
    }

    /**
    * Fetchs menu items from database
    * @return void
    * @access private
    */
    function readMenu () {
        $this->items=array();
        $sql="SELECT * FROM ".MENU_TABLE.
                " ORDER BY ".MENU_PARENT_ID.", ".MENU_NAME;
        $result=$this->db->query($sql);
        while ( $row = $result->fetch() ) {
            $this->items[]=new MenuItem($row);
        }
    }

    /**
    * Gets a menu item by the value of the location field
    * @return object instance of MenuItem
    * @access private
    */
    function locate ($location) {
        $sql="SELECT * FROM ".MENU_TABLE." WHERE ".
                MENU_LOCATION."='".$location."'";
        $result=$this->db->query($sql);
        if ( $result->size() != 1 ) {
            trigger_error('Menu Location not found');
        }
        return new MenuItem($result->fetch());
    }

    /**
    * Counts the size of the menu array
    * @return int number of elements in menu
    * @access public
    */
    function size () {
        return count ($this->menu);
    }

    /**
    * Returns the completed menu
    * @return array the menu array
    * @access public
    */
    function fetchAll () {
        return $this->menu;
    }

    /**
    * Iterates over the menu array
    * @return mixed item from menu
    * @access public
    */
    function fetch () {
        $item = each ( $this->menu );
        if ( $item ) {
            return ( $item['value'] );
        } else {
            reset ( $this->menu );
            return false;
        }
    }
}
/**
* MenuItem Class
* Represents a single item in the menu
* @access public
* @package SPLIB
*/
class MenuItem {
    /**
    * Contains all the properties of a menu item
    * obtained from a row in table menu
    * @access private
    * @var array
    */
    var $item;

    /**
    * Identifies this as current menu item
    * @access private
    * @var boolean
    */
    var $current;

    /**
    * MenuItem constructor
    * @param array a row from table menu
    * @access public
    */
    function MenuItem ($item) {
        $this->item=$item;
        $this->current=false;
    }

    /**
    * Returns the menu_id
    * @return int
    * @access public
    */
    function id () {
        return $this->item[MENU_ID];
    }

    /**
    * Returns the parent_id
    * @return int
    * @access public
    */
    function parent_id () {
        return $this->item[MENU_PARENT_ID];
    }

    /**
    * Returns the name of the menu item
    * @return string
    * @access public
    */
    function name () {
        return $this->item[MENU_NAME];
    }

    /**
    * Returns the description of the menu item
    * @return string
    * @access public
    */
    function description () {
        return $this->item[MENU_DESCRIPTION];
    }

    /**
    * Returns the location (URL fragment)
    * @return string
    * @access public
    */
    function location () {
        return $this->item[MENU_LOCATION];
    }

    /**
    * Used to mark item as current
    * @return void
    * @access public
    */
    function setCurrent () {
        $this->current=true;
    }

    /**
    * Identifies item as a current node or not
    * @return boolean
    * @access public
    */
    function isCurrent () {
        return $this->current;
    }

    /**
    * Identifies item as a root node or not
    * @return boolean
    * @access public
    */
    function isRoot () {
        if ($this->item[MENU_PARENT_ID]==0)
            return true;
        else
            return false;
    }

    /**
    * Mirrors Marker class
    * @return boolean
    * @access public
    */
    function isStart () {
        return false;
    }

    /**
    * Mirrors Marker class
    * @return boolean
    * @access public
    */
    function isEnd () {
        return false;
    }
}

/**
* Marker class
* Used to mark the beginning and end of a set of menu items
* all possessing the same parent
* @access public
* @package SPLIB
*/
class Marker extends MenuItem {
    /**
    * Stores either 'start' or 'end'
    * @var string
    * @access private
    */
    var $type;

    /**
    * Marker constructor
    * @param array values from database
    * @access public
    */
    function Marker ($type) {
        $this->type=$type;
        $this->item=array (
            MENU_ID=>false,
            MENU_PARENT_ID=>false,
            MENU_NAME=>false,
            MENU_DESCRIPTION=>false,
            MENU_LOCATION=>false
                );
    }

    /**
    * Returns true this is a start menu level marker
    * @return boolean
    * @access public
    */
    function isStart () {
        if ( $this->type=='start' )
            return true;
        else
            return false;
    }

    /**
    * Returns true this is a end menu level marker
    * @return boolean
    * @access public
    */
    function isEnd () {
        if ( $this->type=='end' )
            return true;
        else
            return false;
    }
}
?>