<?php
/**
* @package SPLIB
* @version $Id: SOAPArticleServer.php,v 1.1 2003/12/12 08:06:06 kevin Exp $
*/
/**
* Include the PEAR::SOAP Server class
* http://pear.php.net/SOAP
*/
require_once('SOAP/Server.php');
/**
* SOAP Article Server class<br />
* Builds a SOAP server for the articles database using
* PEAR::SOAP<br />
* @access public
* @package SPLIB
*/
class SOAPArticleServer {
    /**
    * Database access object
    * @access private
    * @var object
    */
    var $db;

    /**
    * Instance of PEAR::SOAP Server
    * @access private
    * @var object
    */
    var $soapServer;

    /**
    * SOAP dispatch map maps SOAP methods to class methods
    * defined here
    * @access private
    * @var array
    */
    var $__dispatch_map;

    /**
    * Type definition is used to define the variable types accepted and
    * returned from the server. The type map is used to generate WSDL
    * @access private
    * @var array
    */
    var $__typedef;

    /**
    * SOAPArticleServer constructor<br />
    * @param object instance of database access class
    * @param boolean auto start server
    * @access public
    */
    function SOAPArticleServer(& $db, $autostart = true) {
        error_reporting(E_ALL ^ E_NOTICE);
        $this->db=& $db;
        $this->defineServer();
        if ( $autostart )
            $this->start();
    }

    /**
    * Sets up the dispatch map and type definition for WSDL generation
    * @return void
    * @access private
    */
    function defineServer() {
        $this->__dispatch_map['getArticles'] = array (
                    'in'  => array(),
                    'out' => array('result' => '{urn:sitepoint}Articles')
                  );
        $this->__dispatch_map['getArticleById'] = array(
                    'in' => array('article_id' => 'int'),
                    'out' => array('result' => '{urn:sitepoint}ArticleFull')
                  );
        $this->__typedef['Articles'] = 
                    array(
                        array('article'=>'{urn:sitepoint}ArticleShort')
                    );
        $this->__typedef['ArticleShort'] = 
                    array(
                        'article_id'=>'int',
                        'title'=>'string',
                        'author'=>'string'
                    );
        $this->__typedef['ArticleFull'] = 
                    array(
                        'title'=>'string',
                        'author'=>'string',
                        'body'=>'string'
                    );
    }

    /**
    * Returns an array of articles
    * @return array of objects
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
            return new SOAP_Fault('Problem fetching data','Server');

        $articles = array();
        while ( $row = $result->fetch() ) {
            $articles[]=$row;
        }
        return $articles;
    }

    /**
    * Return a single article
    * @param int article_id
    * @return object
    * @access public
    */
    function getArticleById($articleID) {
        if ( !is_numeric($articleID) )
            return new SOAP_Fault('Expecting numeric article ID','Client');

        $articleID=addslashes($articleID);

        $sql="SELECT
                title, author, body
              FROM
                articles
              WHERE
                article_id = '".$articleID."'";
        $result=$this->db->query($sql);

        if ( $result->isError() )
            return new SOAP_Fault('Problem fetching data','Server');

        return $row = $result->fetch();
    }

    /**
    * Starts the server, telling it to listen for incoming requests.<br />
    * Called automatically is auto start argument not passed as false to
    * constructor
    * @return void
    * @access public
    */
    function start() {
        $this->soapServer=new SOAP_Server();
        $this->soapServer->addObjectMap($this,'http://www.sitepoint.com');
        if (isset($_SERVER['REQUEST_METHOD']) &&
            $_SERVER['REQUEST_METHOD']=='POST') {
            $this->soapServer->service($GLOBALS['HTTP_RAW_POST_DATA']);
        } else {
            require_once 'SOAP/Disco.php';
            $disco = new SOAP_DISCO_Server($this->soapServer,'Sitepoint');
            $disco->_service_desc="Sitepoint Article Server";
            if (isset($_SERVER['QUERY_STRING']) &&
                strcasecmp($_SERVER['QUERY_STRING'],'wsdl')==0) {
                header("Content-type: text/xml");
                echo $disco->getWSDL();
            } else  {
                echo ('This is the Sitepoint SOAP Server. Click
                <a href="?wsdl">here</a> for WSDL' );
            }
            exit;
        }
    }
}
?>