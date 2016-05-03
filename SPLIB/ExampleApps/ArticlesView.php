<?php
/**
* @package SPLIB
* @version $Id: ArticlesView.php,v 1.1 2003/12/12 08:06:06 kevin Exp $
*/
/**
* ArticlesView<br />
* Constructs an HTML table from a list of articles
* @access public
* @package SPLIB
*/
class ArticlesView {
    /**
    * Instance of Articles
    * @access private
    * @var Articles
    */
    var $articles;

    /**
    * Rendered HTML placed here
    * @access private
    * @var string
    */
    var $html;

    /**
    * ArticlesView constructor
    * @param object instance of Articles
    * @access public
    */
    function ArticlesView(& $articles) {
        $this->articles=& $articles;
        $this->html="<table>\n";
        $this->build();
    }

    /**
    * Builds the body of the table
    * @return void
    * @access private
    */
    function build () {
        while ( $article = $this->articles->fetch() ) {
            $this->html.="  <tr>\n";
            $this->html.="    <td><a href=\"".
                $_SERVER['PHP_SELF']."?id=".$article->id()."\">".
                $article->title()."</a></td>\n";
            $this->html.="  </tr>\n";
        }
    }

    /**
    * Returns the constructed HTML
    * @return string
    * @access public
    */
    function render() {
        $this->html.="</table>\n";
        return $this->html;
    }
}
?>