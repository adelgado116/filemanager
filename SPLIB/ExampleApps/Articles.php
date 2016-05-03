<?php
/**
* @package SPLIB
* @version $Id: Articles.php,v 1.1 2003/12/12 08:06:06 kevin Exp $
*/
/**
* Include the Article class
*/
require_once('ExampleApps/Article.php');
/**
* Articles class<br />
* Fetches data for articles from MySQL
* @access public
* @package SPLIB
*/
class Articles {
    /**
    * Instance of MySQL class
    * @access private
    * @var object
    */
    var $db;

    /**
    * Array of article data
    * @access private
    * @var array
    */
    var $articles;

    /**
    * Articles constructor
    * @param object instance of MySQL class
    * @access public
    */
    function Articles(& $db) {
        $this->db=& $db;
    }

    /**
    * Fetches a list of articles into the local array
    * @param int (optional) number of rows to fetch
    * @param int (optional) row to start from
    * @return boolean
    * @access public
    */
    function getArticles ($numRows=false,$startRow=false) {
        $sql="SELECT
                article_id, title, intro, body, author, published, public
              FROM
                articles
              ORDER BY
                published
              DESC";

        if ( $numRows && $startRow ) {
            $sql.=
             " LIMIT
                $startRow, $numRows";
        } else if ( $numRows ) {
            $sql.=
             " LIMIT
                $numRows";
        }

        $result=$this->db->query($sql);

        if ( $result->isError() ) {
            trigger_error('Articles::fetchArticles: '.
                          'Unable to fetch articles');
            return false;
        }

        while ( $row = $result->fetch() ) {
            $this->articles[]=$row;
        }

        return true;
    }

    /**
    * Fetches a single article into the local array
    * @param int article_id
    * @return boolean
    * @access public
    */
    function getArticle($articleID) {
        if ( !is_numeric($articleID) ){
            trigger_error(
                'Articles::fetchArticle: Numeric value for'.
                '$articleID required');
        }

        $articleID=addslashes($articleID);

        $sql="SELECT
                article_id, title, intro, body, author, published, public
              FROM
                articles
              WHERE
                article_id = '".$articleID."'";
        $result=$this->db->query($sql);

        if ( $result->isError() ) {
            trigger_error('Articles::fetchArticle: '.
                          'Unable to fetch article');
            return false;
        }

        $this->articles[]=$result->fetch();
        return true;
    }

    /**
    * Returns the current article from the internal array
    * and moves the internal array point forward
    * @return object instance of Article
    * @access public
    */
    function fetch () {
        $article=each ( $this->articles );
        if ( $article ) {
            return new Article($article['value']);
        } else {
            reset ( $this->articles );
            return false;
        }
    }
}
?>