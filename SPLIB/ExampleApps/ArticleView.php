<?php
/**
* @package SPLIB
* @version $Id: ArticleView.php,v 1.1 2003/12/12 08:06:06 kevin Exp $
*/
/**
* ArticleView<br />
* Renders article data as HTML
* @access public
* @package SPLIB
*/
class ArticleView {
    /**
    * Instance of Article
    * @access private
    * @var Article
    */
    var $article;

    /**
    * Rendered HTML placed here
    * @access private
    * @var string
    */
    var $html;

    /**
    * ArticleView constructor
    * @param object instance of Article
    * @access public
    */
    function ArticleView(& $article) {
        $this->article=& $article;
        $this->html="<table>\n";
        $this->build();
    }

    /**
    * Builds the body of the table
    * @return void
    * @access private
    */
    function build () {
        $this->html.="  <tr>\n";
        $this->html.="    <td><b>".$this->article->title()."</b> by ".
            $this->article->author()." ".$this->article->published()."</td>";
        $this->html.="  </tr>\n";
        $this->html.="  <tr>\n";
        $this->html.="    <td>".$this->article->body()."</td>";
        $this->html.="  </tr>\n";
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