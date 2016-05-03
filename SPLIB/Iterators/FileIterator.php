<?php
/**
* @package SPLIB
* @version $Id: FileIterator.php,v 1.1 2003/12/12 08:06:06 kevin Exp $
*/
/**
* FileIterator<br />
* SimpleIterator for reading files
* @package SPLIB
* @access public
*/
class FileIterator /* implements SimpleIterator */ {
    /**
    * Name of the file to iterate over
    * @access private
    * @var string
    */
    var $filename;

    /**
    * PHP Resource created when file is opened
    * @access private
    * @var resource
    */
    var $fp;

    /**
    * FileIterator Constructor
    * @param string directory name to iterate over
    * @access public
    */
    function FileIterator ($filename) {
        $this->filename = $filename;
    }

    /**
    * Iterator method which returns content from the file
    * @return mixed either file content or false when no more entries
    * @access public
    */
    function fetch() {
        if ( ! $this->fp ) {
            $this->fp = fopen($this->filename,'r');
        }
        if ( !feof($this->fp) ) {
            return fgets($this->fp,4096);
        } else {
            fclose($this->fp);
            $this->fp = NULL;
            return false;
        }
    }
}
?>