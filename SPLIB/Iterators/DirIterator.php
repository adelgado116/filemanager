<?php
/**
* @package SPLIB
* @version $Id: DirIterator.php,v 1.1 2003/12/12 08:06:06 kevin Exp $
*/
/**
* DirIterator<br />
* SimpleIterator for reading directories
* @package SPLIB
* @access public
*/
class DirIterator /* implements SimpleIterator */ {
    /**
    * Name of the directory to iterate over
    * @access private
    * @var string
    */
    var $directory;

    /**
    * PHP Resource created when directory is opened
    * @access private
    * @var resource
    */
    var $dir;

    /**
    * DirIterator Constructor
    * @param string directory name to iterate over
    * @access public
    */
    function DirIterator ($directory) {
        $this->directory = $directory;
    }

    /**
    * Iterator method which returns an entry from the directory
    * @return mixed either directory entry or false when no more entries
    * @access public
    */
    function fetch() {
        if ( ! $this->dir ) {
            $this->dir = dir($this->directory);
        }
        if  ( false !== ($entry = $this->dir->read())) {
            return $entry;
        } else {
            $this->dir->close();
            $this->dir = NULL;
            return false;
        }
    }
}
?>