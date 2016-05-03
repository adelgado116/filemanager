<?php
/**
* @package SPLIB
* @version $Id: DomRssParser.php,v 1.1 2003/12/12 08:06:02 kevin Exp $
*/
/**
* DomRssParser Class
* Parses an RSS feed with DOM
* @access public
* @package SPLIB
*/
class DomRssParser {
    /**
    * Stores the data from a single <item /> tag as an stdClass
    * @access private
    * @var stdClass
    */
    var $rssItem;

    /**
    * Stores a list of all <item /> tags
    * @access private
    * @var array
    */
    var $rssItems;

    /**
    * DomRssParser constructor
    * @access public
    * @param string the RSS document
    */
    function DomRssParser ($rssDoc) {
        $dom = domxml_open_mem($rssDoc);
        $this->rssItem=new stdClass;
        $this->rssItems=array();
        $this->Rdf($dom);
    }

    /**
    * Iterator for RSS Items, returning prepared items as stdClasses
    * Returns an instance of stdClass containing the parameters
    * title, description and link or false if at end of collection
    * @return mixed
    * @access public
    */
    function fetch () {
        $item=each($this->rssItems);
        if ( $item ) {
            return $item['value'];
        } else {
            reset ( $this->rssItems );
            return false;
        }
    }

    /**
    * Fetchs the root element
    * @param resource instance of DOM Document
    * @return void
    * @access private
    */
    function rdf ($dom) {
        $rdf = $dom->document_element();
        $this->items($rdf);
    }

    /**
    * Fetches all the <item /> elements from the document
    * @param resource instance of DOM Element for the root element
    * @return void
    * @access private
    */
    function items ($rdf) {
        $items = $rdf->get_elements_by_tagname('item');
        $this->item ($items);
    }

    /**
    * Populates $this->rssItems with single <item />'s
    * @param array of DOM Elements for <item /> tags
    * @return void
    * @access private
    */
    function item ($items) {
        foreach ( $items as $item ) {
            // Get the children of each item
            $itemNodes = $item->child_nodes();
            $this->itemNode($itemNodes);
            $this->rssItems[]=$this->rssItem;
            $this->rssItem=new stdClass;
        }
    }

    /**
    * Loops through an item's nodes
    * @param array of DOM Elements item nodes
    * @return void
    * @access private
    */
    function itemNode($itemNodes) {
        foreach ( $itemNodes as $itemNode ) {
            $itemContents=$itemNode->child_nodes();
            $this->ItemContent($itemNode,$itemContents);
        }
    }

    /**
    * Collects the text nodes from within the content
    * @param resource DOM Element for item node child
    * @param array of DOM Elements for item node children
    * @return void
    * @access private
    */
    function itemContent ($itemNode,$itemContents) {
        foreach ( $itemContents as $itemContent ) {
            if( $itemContent->node_type() == XML_TEXT_NODE ) {
                $itemData=$itemContent->content;
                $this->StoreData($itemNode,$itemData);
            }
        }
    }

    /**
    * Stores the text node in the current $rssItem global variable
    * @param resource DOM Element for item node child
    * @param string contents of the text node child
    * @return void
    * @access private
    */
    function storeData ($itemNode,$itemData) {
        // Deal with the specific elements we want
        switch ( strtoupper($itemNode->tagname) ) {
            case 'TITLE':
                $this->rssItem->title=$itemData;
                break;
            case 'DESCRIPTION':
                $this->rssItem->description=$itemData;
                break;
            case 'LINK':
                $this->rssItem->link=$itemData;
                break;
        }
    }
}
?>