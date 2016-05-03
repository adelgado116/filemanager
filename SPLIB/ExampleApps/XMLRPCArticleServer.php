<?php
/**
* @package SPLIB
* @version $Id: XMLRPCArticleServer.php,v 1.1 2003/12/12 08:06:06 kevin Exp $
*/
/**
* Include the Incutio XML RPC library
* http://scripts.incutio.com/xmlrpc/
*/
require_once('ThirdParty/xmlrpc/IXR_Library.inc.php');
/**
* XML-RPC Article Server class<br />
* Builds an XML-RPC server for the articles database using
* Simon Wilsons XML-RPC implementation<br />
* http://scripts.incutio.com/xmlrpc/
* @access public
* @package SPLIB
*/
class XMLRPCArticleServer extends IXR_Server {
    /**
    * Database access object
    * @access private
    * @var  object
    */
    var $db;

    /**
    * XMLRPCArticleServer constructor
    * @param object instance of database access class
    * @access public
    */
    function XMLRPCArticleServer(& $db) {
        $this->db = & $db;
        // Define the XML-RPC methods
        $this->IXR_Server(array(
            'articles.getArticles' => 'this:getArticles',
            'articles.getArticleById' => 'this:getArticleById'
            ));
    }

    /**
    * Returns an array of articles
    * @return array
    * @access public
    */
    function getArticles () {
        $sql="SELECT
                article_id, title, author
              FROM
                articles
              WHERE
                public = '1'
              ORDER BY
                title";

        $result=$this->db->query($sql);

        if ( $result->isError() )
            return new IXR_Error(-2, 'Problem fetching data');

        while ( $row = $result->fetch() ) {
            $articles[]=$row;
        }
        return $articles;
    }

    /**
    * Return a single article
    * @param int article_id
    * @return array
    * @access public
    */
    function getArticleById($articleID) {
        if ( !is_numeric($articleID) )
            return new IXR_Error(-1, 'Expecting numeric article ID');

        $articleID=addslashes($articleID);

        $sql="SELECT
                title, author, body
              FROM
                articles
              WHERE
                article_id = '".$articleID."'
              AND
                public = '1'";
        $result=$this->db->query($sql);

        if ( $result->isError() )
            return new IXR_Error(-2, 'Problem fetching data');

        return $row = $result->fetch();
    }
}
?>