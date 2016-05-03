<?php
/**
* @package SPLIB
* @version $Id: RssGenerator.php,v 1.1 2003/12/12 08:06:02 kevin Exp $
*/
/**
* RssGenerator Class
* Generates RSS 1.0 documents according to http://purl.org/rss/1.0/
* @access public
* @package SPLIB
*/
class RssGenerator {
    /**
    * Stores the document as a DOM Document instance
    * @access private
    * @var resource
    */
    var $dom;

    /**
    * Stores the root element of the rss feed
    * as a DOM Element object
    * @access private
    * @var resource
    */
    var $rss;

    /**
    * Stores the channel element
    * as a DOM Element object
    * @access private
    * @var resource
    */
    var $channel;

    /**
    * Stores the item sequence for the channel
    * as a DOM Element object
    * @access private
    * @var resource
    */
    var $itemSequence;

    /**
    * Stores the image element
    * as a DOM Element object
    * @access private
    * @var resource
    */
    var $image;

    /**
    * An array of items as DOM Element instances
    * @access private
    * @var resource
    */
    var $items;

    /**
    * Stores the textinput element
    * as a DOM Element object
    * @access private
    * @var resource
    */
    var $textinput;

    /**
    * RssGenerator constructor
    * @access public
    */
    function RssGenerator () {
        $this->dom=domxml_new_doc('1.0');
        $this->initialize();
    }

    /**
    * Creates the root rdf element
    * Sets up the channel and item sequence
    * @return void
    * @access private
    */
    function initialize () {
        $rss=$this->dom->create_element('rdf:RDF');

        // Namespace hack
        $rss->set_attribute('xmlns:rdf',
            'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
        $rss->set_attribute('xmlns',
            'http://purl.org/rss/1.0/');
        $this->rss=$this->dom->append_child($rss);
        $this->channel=$this->dom->create_element('channel');
        $this->itemSequence=$this->dom->create_element('rdf:seq');
    }

    /**
    * Adds the url of the image to the channel element
    * @param string url of image
    * @return void
    * @access private
    */
    function addChannelImage($url) {
        $image=$this->dom->create_element('image');
        $image->set_attribute('rdf:resource',$url);
        $this->channel->append_child($image);
    }

    /**
    * Adds a url of an item to the items sequence in the channel element
    * @param string url of an item
    * @return void
    * @access private
    */
    function addChannelItem ($url) {
        $li=$this->dom->create_element('rdf:li');
        $li->set_attribute('resource',$url);
        $this->itemSequence->append_child($li);
    }

    /**
    * Adds a url of an item to the items sequence in the channel element
    * @param string url of an item
    * @return void
    * @access private
    */
    function addChannelTextInput($url) {
        $textInput=$this->dom->create_element('textinput');
        $textInput->set_attribute('rdf:resource',$url);
        $this->channel->append_child($textInput);
    }

    /**
    * Makes the final appends to the rss document
    * @return void
    * @access private
    */
    function finalize () {
        $channelItems=$this->dom->create_element('items');
        $channelItems->append_child($this->itemSequence);
        $this->channel->append_child($channelItems);
        $this->rss->append_child($this->channel);

        if ( isset ( $this->image ) )
            $this->rss->append_child($this->image);

        if ( is_array ( $this->items ) ) {
            foreach ($this->items as $item) {
                $this->rss->append_child($item);
            }
        }

        if ( isset ( $this->textinput ) )
            $this->rss->append_child($this->textinput);
    }

    /**
    * Add the basic channel information
    * @param string title of the channel e.g. "Sitepoint"
    * @param string mail URL of channel e.g. "http://www.sitepoint.com"
    * @param string description of channel
    * @param string about URL e.g. "http://www.sitepoint.com/about/"
    * @return void
    * @access public
    */
    function addChannel ($title,$link,$desc,$aboutUrl) {
        $this->channel->set_attribute('rdf:about',$aboutUrl);
        $titleNode=$this->dom->create_element('title');
        $titleNodeText=$this->dom->create_text_node($title);
        $titleNode->append_child($titleNodeText);
        $this->channel->append_child($titleNode);
        $linkNode=$this->dom->create_element('link');
        $linkNodeText=$this->dom->create_text_node($link);
        $linkNode->append_child($linkNodeText);
        $this->channel->append_child($linkNode);
        $descNode=$this->dom->create_element('description');
        $descNodeText=$this->dom->create_text_node($desc);
        $descNode->append_child($descNodeText);
        $this->channel->append_child($descNode);
    }

    /**
    * Adds the channel logo description to the feed
    * @param string src: "http://www.sitepoint.com/images/sitepoint-logo.gif"
    * @param string alternative text to display for image
    * @param string link for image e.g. http://www.sitepoint.com
    * @return void
    * @access public
    */
    function addImage ($src,$alt,$link) {
        $this->addChannelImage($src);
        $this->image=$this->dom->create_element('image');
        $this->image->set_attribute('rdf:about',$src);
        $titleNode=$this->dom->create_element('title');
        $titleNodeText=$this->dom->create_text_node($alt);
        $titleNode->append_child($titleNodeText);
        $this->image->append_child($titleNode);
        $urlNode=$this->dom->create_element('url');
        $urlNodeText=$this->dom->create_text_node($src);
        $urlNode->append_child($urlNodeText);
        $this->image->append_child($urlNode);
        $linkNode=$this->dom->create_element('link');
        $linkNodeText=$this->dom->create_text_node($link);
        $linkNode->append_child($linkNodeText);
        $this->image->append_child($linkNode);
    }

    /**
    * Adds the description of the site search URL
    * @param string title of search e.g. "Search"
    * @param string descrption of search e.g. "Search Sitepoint..."
    * @param string search url: "http://www.sitepoint.com/search/search.php"
    * @param string GET variable for search e.g. "q" for "?q="
    * @return void
    * @access public
    */
    function addSearch ($title,$desc,$url,$var) {
        $this->addChannelTextInput($url);
        $this->textinput=$this->dom->create_element('textinput');
        $this->textinput->set_attribute('rdf:about',$url);
        $titleNode=$this->dom->create_element('title');
        $titleNodeText=$this->dom->create_text_node($title);
        $titleNode->append_child($titleNodeText);
        $this->textinput->append_child($titleNode);
        $descNode=$this->dom->create_element('description');
        $descNodeText=$this->dom->create_text_node($desc);
        $descNode->append_child($descNodeText);
        $this->textinput->append_child($descNode);
        $nameNode=$this->dom->create_element('name');
        $nameNodeText=$this->dom->create_text_node($var);
        $nameNode->append_child($nameNodeText);
        $this->textinput->append_child($nameNode);
        $linkNode=$this->dom->create_element('link');
        $linkNodeText=$this->dom->create_text_node($url);
        $linkNode->append_child($linkNodeText);
        $this->textinput->append_child($linkNode);
    }

    /**
    * Adds an RSS item to the document
    * @param string title of item
    * @param string link for item
    * @param string description of item
    * @return void
    * @access public
    */
    function addItem ($title,$link,$desc) {
        $this->addChannelItem($link);
        $itemNode=$this->dom->create_element('item');
        $itemNode->set_attribute('rdf:about',$link);
        $titleNode=$this->dom->create_element('title');
        $titleNodeText=$this->dom->create_text_node($title);
        $titleNode->append_child($titleNodeText);
        $itemNode->append_child($titleNode);
        $linkNode=$this->dom->create_element('link');
        $linkNodeText=$this->dom->create_text_node($link);
        $linkNode->append_child($linkNodeText);
        $itemNode->append_child($linkNode);
        $descNode=$this->dom->create_element('description');
        $descNodeText=$this->dom->create_text_node($desc);
        $descNode->append_child($descNodeText);
        $itemNode->append_child($descNode);
        $this->items[]=$itemNode;
    }

    /**
    * Returns the RSS document as a string
    * @return string XML document
    * @access public
    */
    function toString () {
        $this->finalize();
        return $this->dom->dump_mem(true);
    }
}
?>