<?php
/**
* @package SPLIB
* @version $Id: FullTree.php,v 1.1 2003/12/12 08:06:02 kevin Exp $
*/
/**
*  FullTree clas
* <pre>
*  Home
*    - About
*    - Contact
*  Products
*    - Pets
*      - Cats
*      - Birds
*    - Books
*  Etc
* </pre>
* @access public
* @package SPLIB
*/
class FullTree extends Menu {
    /**
    * Stores the current location item
    * @access private
    * @var  object
    */
    var $current;

    /**
    * FullTree constructor
    * @param object database connection
    * @param string URL fragment
    * @access public
    */
    function FullTree (&$db,$location='') {
        Menu::Menu($db);
        $this->current=$this->locate($location);
        $this->build();
    }

    /**
    * Resursive function that adds any children to the
    * current node
    * @param object instance of MenuItem
    * @return void
    * @access private
    */
    function appendChildren ($treeItem) {
        foreach ( $this->items as $item ) {
            if ( $treeItem->id() == $item->parent_id() ) {
                $this->menu[]=new Marker('start');
                if ( $item->id() == $this->current->id() )
                    $item->setCurrent();
                $this->menu[]=$item;
                $this->appendChildren($item);
                $check=end($this->menu);
                if ( $check->isStart() )
                    array_pop($this->menu);
                else
                    $this->menu[]=new Marker('end');
            }
        }
    }

    /**
    * Starts construction, building the root elements
    * @return void
    * @access private
    */
    function build () {
        foreach ( $this->items as $item ) {
            if ( $item->isRoot() ) {
                if ( $item->id() == $this->current->id() )
                    $item->setCurrent();
                $this->menu[]=$item;
                $this->appendChildren($item);
            }
        }
        reset ( $this->menu );
    }
}
?>