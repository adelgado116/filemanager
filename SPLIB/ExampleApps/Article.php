<?php
/**
* @package SPLIB
* @version $Id: Article.php,v 1.1 2003/12/12 08:06:06 kevin Exp $
*/
/**
* Article class<br />
* Stores data for a single article
* @access public
* @package SPLIB
*/
class Article {
    /**
    * The article id
    * @access private
    * @var int
    */
    var $article_id;

    /**
    * The article title
    * @access private
    * @var string
    */
    var $title;

    /**
    * The article introduction
    * @access private
    * @var string
    */
    var $intro;

    /**
    * The article body
    * @access private
    * @var string
    */
    var $body;

    /**
    * The author
    * @access private
    * @var string
    */
    var $author;

    /**
    * Date published ( UNIX timestamp )
    * @access private
    * @var int
    */
    var $published;

    /**
    * Whether the article is "public"
    * @access private
    * @var int
    */
    var $public;

    /**
    * Article constructor
    * @param array data from database contain an Article
    * @access public
    */
    function Article($data) {
        $this->article_id = isset ( $data['article_id'] ) ?
            $data['article_id'] : FALSE;
        $this->title = isset ( $data['title'] ) ?
            $data['title'] : FALSE;
        $this->intro = isset ( $data['intro'] ) ?
            $data['intro'] : FALSE;
        $this->body = isset ( $data['body'] ) ?
            $data['body'] : FALSE;
        $this->author = isset ( $data['author'] ) ?
            $data['author'] : FALSE;
        $this->published = isset ( $data['published'] ) ?
            $data['published'] : FALSE;
        $this->public = isset ( $data['public'] ) ?
            $data['public'] : FALSE;
    }

    /**
    * Returns the article_id
    * @return int
    * @access public
    */
    function id () {
        return $this->article_id;
    }

    /**
    * Returns the article title
    * @return string
    * @access public
    */
    function title() {
        return $this->title;
    }

    /**
    * Returns the article intro
    * @return string
    * @access public
    */
    function intro() {
        return $this->intro;
    }

    /**
    * Returns the article title
    * @return string
    * @access public
    */
    function body() {
        return $this->body;
    }

    /**
    * Returns the author
    * @return string
    * @access public
    */
    function author () {
        return $this->author;
    }

    /**
    * Returns the data published like "October 1st 2001"
    * @param string (optional) date format
    * @return string
    * @access public
    */
    function published ($format='F jS Y') {
        return date($format,$this->published);
    }

    /**
    * Whether the article is "public" or not
    * @return boolean
    * @access public
    */
    function public () {
        return $this->public == 1 ? true : false;
    }
}
?>