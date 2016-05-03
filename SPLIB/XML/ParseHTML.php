<?php
/**
* @package SPLIB
* @version $Id: ParseHTML.php,v 1.1 2003/12/12 08:06:02 kevin Exp $
*/
/**
* ParseHTML class demonostrates simple parsing of HTML using PEAR::XML_HTMLSax
* <br />Defines handlers for responding to HTML elements<br />
* Requires PEAR::XML_HTMLSax
* @package SPLIB
* @access public
*/
class ParseHTML {
    /**
    * Stores the parser
    * @var XML_HTMLSax instance of PEAR::XML_HTMLSax
    * @access private
    */
    var $parser;
    /**
    * ParseHTML Constructor sets up the parser
    * @access public
    */
    function ParseHTML() {
        $this->parser = & new XML_HTMLSax();
        $this->parser->set_object($this);
        $this->parser->set_element_handler('open','close');
        $this->parser->set_data_handler('data');
    }
    /**
    * Opening tag event "listener"
    * @param XML_HTMLSax the parser
    * @param string HTML tag name
    * @param array of tag attributes
    * @return void
    * @access private
    */
    function open($parser,$tag,$attr) {
        echo ('<hr />Opening Tag: '.$tag.'<br />');
        if ( count($attr) > 0 ) {
            echo ( '...has attributes: <pre>' );
            print_r($attr);
            echo ( '</pre>' );
        }
    }
    /**
    * Closing tag event "listener"
    * @param XML_HTMLSax the parser
    * @param string HTML tag name
    * @return void
    * @access private
    */
    function close($parser,$tag) {
        echo ('Closing Tag: '.$tag.'<br />');
    }
    /**
    * Character data event "listener"
    * @param XML_HTMLSax the parser
    * @param string character data
    * @return void
    * @access private
    */
    function data($parser,$data) {
        echo ('Character data: '.$data.'<br />');
    }
    /**
    * Instructs the parser to parse some HTML
    * @param string HTML to parser
    * @return void
    * @access public
    */
    function parse($html) {
        $this->parser->parse($html);
    }
}
?>