<?php
/**
* @package SPLIB
* @version $Id: HTMLtoPDF.php,v 1.1 2003/12/12 08:06:02 kevin Exp $
*/
/**
* Include PEAR::XML_HTMLSax
* http://pear.php.net/XML_HTMLSax
*/
require_once('XML/XML_HTMLSax.php');
/**
* HTMLtoPDF converts simple HTML to PDF
* Defines handlers for responding to HTML elements
* @package SPLIB
* @access public
*/
class HTMLtoPDF {
    /**
    * Instance of PEAR::XML_HTMLSax
    * @access private
    * @var XML_HTMLSax
    */
    var $parser;
    /**
    * Instance of ArticlePDF
    * @access private
    * @var HTMLtoPDF
    */
    var $articlePdf;
    /**
    * Stores text until added to PDF document
    * @access private
    * @var  string
    */
    var $buffer = '';
    /**
    * Temporary store for R&OS PDF tags
    * @access private
    * @var  string
    */
    var $open = NULL;
    /**
    * Temporary store for R&OS PDF tags
    * @access private
    * @var  string
    */
    var $close = NULL;
    /**
    * Value to increase text size by for headers
    * @access private
    * @var  int
    */
    var $header = NULL;
    /**
    * PdfFilter Constructor
    * @param ArticlePDF instance of ArticlePDF
    * @access public
    */
    function HTMLtoPDF(& $articlePDF) {
        $this->articlePDF=& $articlePDF;
        $this->parser = new XML_HTMLSax();
        $this->parser->set_object($this);
        $this->parser->set_element_handler('open','close');
        $this->parser->set_data_handler('data');
    }
    /**
    * Opening tag event "listener"
    * @param XML_HTMLSax instance of the parser
    * @param string HTML tag name
    * @param array of tag attributes
    * @return void
    * @access private
    */
    function open($parser,$tag,$attr) {
        $tag=strtolower($tag); // Convert tag to lower case
        switch ( $tag ) {
            case 'a':
                if ( isset ($attr['href']) ) {
                    $this->open='<c:alink:'.$attr['href'].'>';
                    $this->close='</c:alink>';
                }
                break;
            case 'b':
                $this->open='<b>';
                $this->close='</b>';
                break;
            case 'br':
                $this->articlePDF->addText($this->buffer);
                $this->buffer='';
                break;
            case 'h1':
                $this->header='12';
                break;
            case 'h2':
                $this->header='10';
                break;
            case 'h3':
                $this->header='8';
                break;
            case 'h4':
                $this->header='6';
                break;
            case 'h5':
                $this->header='4';
                break;
            case 'i':
                $this->open='<i>';
                $this->close='</i>';
                break;
            case 'p':
                $this->articlePDF->addText($this->buffer);
                $this->buffer='';
                break;
            case 'strong':
                $this->open='<b>';
                $this->close='</b>';
                break;
        }
    }
    /**
    * Character data event "listener"
    * @param XML_HTMLSax instance of the parser
    * @param string character data
    * @return void
    * @access private
    */
    function data($parser, $data) {
        $data= str_replace(
            array('&gt;', '&lt;', '&quot;', '&amp;', '&nbsp;'),
            array('>', '<', '"', '&', ' '),
            $data);
        if ( isset($this->open) && isset($this->close) ) {
            $this->buffer.=$this->open.$data.$this->close;
            $this->open=NULL;
            $this->close=NULL;
        } else if ( isset ( $this->header ) ) {
            $this->articlePDF->addText($data,10+$this->header,'left');
            $this->header=NULL;
        } else {
            $this->buffer.=$data;
        }
    }
    /**
    * Closing tag event "listener"
    * @param XML_HTMLSax instance of the parser
    * @param string HTML tag name
    * @return void
    * @access private
    */
    function close($parser,$tag) {
        // Do nothing
    }
    /**
    * Triggers parsing and converts newlines to &lt;br /%gt;
    * @param string HTML document
    * @return void
    * @access public
    */
    function parse($html) {
        $this->parser->parse(nl2br($html));
    }
    /**
    * Adds any remaining text in the buffer then
    * returns the ArticlePDF object
    * @return object instance of ArticlePDF
    * @access public
    */
    function getPdf () {
        $this->articlePDF->addText($this->buffer);
        return $this->articlePDF;
    }
}
?>