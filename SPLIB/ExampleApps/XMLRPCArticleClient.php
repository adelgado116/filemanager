<?php
/**
* @package SPLIB
* @version $Id: XMLRPCArticleClient.php,v 1.1 2003/12/12 08:06:06 kevin Exp $
*/
/**
* Include the Incution XML RPC library
* http://scripts.incutio.com/xmlrpc/
*/
require_once('ThirdParty/xmlrpc/IXR_Library.inc.php');
/**
* XMLRPCArticleClient class
* Builds an XML-RPC client for the XMLRPC Articles service<br />
* Uses Simon Wilsons XML-RPC implementation<br />
* http://scripts.incutio.com/xmlrpc/
* @see XMLRPCArticleServer
* @access public
*/
class XMLRPCArticleClient {
    /**
    * Instance of IXR_Client class
    * @access private
    * @var IXR_Client
    */
    var $client;

    /**
    * ArticleClient constructor
    * @param string URL of server
    * @param boolean true switches on debugging
    * @access public
    */
    function XMLRPCArticleClient($url,$debug=false) {
        $this->client= new IXR_Client($url);
        $this->client->debug=$debug;
    }

    /**
    * Returns an array of articles
    * @return array
    * @access public
    */
    function getArticles () {
        if (!$this->client->query('articles.getArticles')) {
            trigger_error($this->client->getErrorCode().
                ' : '.$this->client->getErrorMessage());
            return false;
        }
        return $this->client->getResponse();
    }

    /**
    * Returns a single article
    * @param int article id
    * @return array
    * @access public
    */
    function getArticleById($articleID) {
        if (!$this->client->query('articles.getArticleById',$articleID)) {
            trigger_error($this->client->getErrorCode().
                ' : '.$this->client->getErrorMessage());
            return false;
        }
        return $this->client->getResponse();
    }
}
?>