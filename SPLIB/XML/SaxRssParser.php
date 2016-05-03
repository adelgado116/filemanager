<?php
/**
* @package SPLIB
* @version $Id: SaxRssParser.php,v 1.1 2003/12/12 08:06:02 kevin Exp $
*/
/**
* SaxRssParser Class
* Parses an RSS feed with SAX
* @access public
* @package SPLIB
*/
class SaxRssParser {
    /**
    * Instance of the PHP SAX XML parser
    * @access private
    * @var resource
    */
    var $sax;

    /**
    * The marker for <item /> tags
    * @access private
    * @var boolean
    */
    var $newItem;

    /**
    * Stores the name of the current element either
    * title, description or link
    * @access private
    * @var string
    */
    var $element;

    /**
    * Stores the contents of <title />
    * @access private
    * @var string
    */
    var $title;

    /**
    * Stores the contents of <description />
    * @access private
    * @var string
    */
    var $description;

    /**
    * Stores the contents of <link />
    * @access private
    * @var string
    */
    var $link;

    /**
    * An array of items stored as stdClass objects
    * @access private
    * @var array
    */
    var $items;

    /**
    * SaxRssParser constructor
    * @access public
    */
    function SaxRssParser () {
        $this->newItem=false;
        $this->element='';
        $this->title='';
        $this->description='';
        $this->link='';
        $this->items=array();
        $this->sax = xml_parser_create();
        xml_set_object($this->sax,$this);
        xml_set_element_handler($this->sax, 'open', 'close');
        xml_set_character_data_handler($this->sax, 'data');
    }

    /**
    * Parses a chunk of XML document
    * @param string a chunk of XML
    * @return boolean
    * @access public
    */
    function parse($data) {
        if ( !xml_parse($this->sax, $data) ) { 
            $error=xml_error_string (xml_get_error_code ($this->sax));
            $line=xml_get_current_line_number($this->sax);
            trigger_error ('XML error '.$error.' at line '.$line);
            return false;
        } else {
            return true;
        }
    }

    /**
    * Destroys the parser
    * @return void
    * @access public
    */
    function destroy() {
        xml_parser_free($this->sax);
    }

    /**
    * Iterator for RSS Items, returning prepared items as stdClasses
    * Returns an instance of stdClass containing the parameters
    * title, description and link or false if at end of collection
    * @return mixed
    * @access public
    */
    function fetch () {
        $item=each ( $this->items );
        if ( $item ) {
            return $item['value'];
        } else {
            reset ( $this->items );
            return false;
        }
    }

    /**
    * Handles opening tags
    * @param resource instance of PHP SAX XML
    * @param string element name
    * @param array element attributes
    * @return void
    * @access private
    */
    function open ($sax, $element, $attributes) { 
        if ($this->newItem)
            $this->element = $element; 
        else if ($element == 'ITEM')
            $this->newItem = true; 
    }

    /**
    * Handles closing tags
    * @param resource instance of PHP SAX XML
    * @param string element name
    * @return void
    * @access private
    */
    function close($sax, $element) { 
        if ($element == 'ITEM') {
            $item=new stdClass;
            $item->title=$this->title;
            $item->link=$this->link;
            $item->description=$this->description;
            $this->items[] = $item;
        
            $this->title = '';
            $this->description = '';
            $this->link = ''; 
            $this->newItem = false; 
        }
    }

    /**
    * Handles character data
    * @param resource instance of PHP SAX XML
    * @param string element name
    * @return void
    * @access private
    */
    function data($sax, $data) { 
        if ($this->newItem) { 
            switch ($this->element) { 
                case 'TITLE':
                    $this->title .= $data; 
                    break; 
                case 'DESCRIPTION':
                    $this->description .= $data; 
                    break; 
                case 'LINK':
                    $this->link .= $data;
                    break; 
            } 
        } 
    }
}
?>