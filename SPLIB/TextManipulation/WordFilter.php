<?php
/**
* @package SPLIB
* @version $Id: WordFilter.php,v 1.1 2003/12/12 08:06:05 kevin Exp $
*/
/**
* WordFilter<br />
* Class for censoring words in text
* @access public
* @package SPLIB
*/
class WordFilter {
    /**
    * An array of words to censor
    * @access private
    * @var array
    */
    var $badWords;
    /**
    * WordFilter constructor
    * Randomly generates strings to censor words with
    * @param array an array of words to filter
    * @access public
    */
    function WordFilter($badWords) {
        $this->badWords=array();
        srand ((float)microtime()*1000000);
        $censors=array ('$','@','#','*','£');
        foreach ($badWords as $badWord) {
            $badWord = preg_quote($badWord);
            $replaceStr='';
            $size=strlen($badWord);
            for ($i=0;$i<$size;$i++) {
                shuffle($censors);
                $replaceStr.=$censors[0];
            }
            $this->badWords[$badWord]=$replaceStr;
        }
    }
    /**
    * Searchs for bad words in text and censors them
    * @param string text to filter
    * @return string the filtered text
    * @access public
    */
    function filter ($text) {
        foreach ($this->badWords as $badWord => $replaceStr) {
            $text=preg_replace('/'.$badWord.'/i',$replaceStr,$text);
        }
        return $text;
    }
}
?>