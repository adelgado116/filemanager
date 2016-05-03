<?php
/**
* @package SPLIB
* @version $Id: ArticlesXML.php,v 1.1 2003/12/12 08:06:06 kevin Exp $
*/
/**
* Articles XML class<br />
* Fetches data from articles.xml
* @access public
* @package SPLIB
*/
class ArticlesXML {
    /**
    * An array of Article objects
    * @access private
    * @var  array
    */
    var $articles;

    /**
    * ArticlesXML constructor
    * @param string the articles.xml document
    * @access public
    */
    function ArticlesXML ($articlesDoc) {
        $dom=domxml_open_mem($articlesDoc);
        $xpath=$dom->xpath_init(); 
        $ctx = $dom->xpath_new_context(); 
        $ctx->xpath_register_ns("spt","http://www.sitepoint.com");

        $articles=& $ctx->xpath_eval("//spt:article/descendant-or-self::*");

        foreach ( $articles->nodeset as $node ) {
            switch ( $node->tagname ) {
                case 'article':
                    if ( isset($article) ) {
                        $this->articles[] = new Article($article);
                    }
                    $article = array();
                break;
                case 'body':
                    $article['body'] = $dom->dump_node($node);
                break;
                default:
                    $article[$node->tagname] = $node->get_content();
                break;
            }
        }
        if ( isset($article) ) {
            $this->articles[] = new Article($article);
        }
    }

    /**
    * Returns an single ArticleXML object, iterating of the
    * collection of articles
    * @return object
    * @access public
    */
    function fetch() {
        $article = each ($this->articles);
        if ( $article ) {
            return $article['value'];
        } else {
            reset ($this->articles);
            return false;
        }
    }

    /**
    * Returns an Article object by it's article_id value
    * @param int ID of article
    * @return object
    * @access public
    */
    function getArticleById($id) {
        foreach ( $this->articles as $article ) {
            if ( $article->id() == $id ) {
                return $article;
            }
        }
        return false;
    }
}
?>