<?php
/**
* @package SPLIB
* @version $Id: SitepointBBCode.php,v 1.1 2003/12/12 08:06:05 kevin Exp $
*/
/**
* SitePointBBCode loads custom BBCode tags for bbcode class
* Developed by Leif K-Brooks.
* @see http://www.phpclasses.org/browse.html/package/951.html
* @access public
* @package SPLIB
*/
class SitePointBBCode {
    /**
    * Stores an instance of the bbcode class
    * @var bbcode
    * @access private
    */
    var $bbcode;

    /**
    * SitePointBBCode constructor
    * Loads the custom BBCode tags into the bbcode class
    * @access public
    */
    function SitePointBBCode () {
        $this->bbcode = new bbcode();
        // Adds [b /] tag for bold text
        $this->bbcode->add_tag(
            array(
            'Name'=>'b',
            'HtmlBegin'=>'<span style="font-weight: bold;">',
            'HtmlEnd'=>'</span>')
            );
        // Adds [i /] tag for italic text
        $this->bbcode->add_tag(
            array(
            'Name'=>'i',
            'HtmlBegin'=>'<span style="font-style: italic;">',
            'HtmlEnd'=>'</span>')
            );
        // Adds [u /] tag for underlining text
        $this->bbcode->add_tag(
            array('Name'=>'u',
            'HtmlBegin'=>'<span style="text-decoration: underline;">',
            'HtmlEnd'=>'</span>')
            );
        // Adds [link /] tag to convert to <a href="" />
        $this->bbcode->add_tag(
            array(
            'Name'=>'link',
            'HasParam'=>true,
            'HtmlBegin'=>'<a href="%%P%%">',
            'HtmlEnd'=>'</a>')
            );
        // Adds [color /] tag to control font color
        $this->bbcode->add_tag(
            array(
            'Name'=>'color',
            'HasParam'=>true,
            'ParamRegex'=>'[A-Za-z0-9#]+',
            'HtmlBegin'=>'<span style="color: %%P%%;">',
            'HtmlEnd'=>'</span>',
            'ParamRegexReplace'=>array('/^[A-Fa-f0-9]{6}$/'=>'#$0'))
            );
        // Adds [email /] tag to convert to <a href="mailto:" />
        $this->bbcode->add_tag(
            array(
            'Name'=>'email',
            'HasParam'=>true,
            'HtmlBegin'=>'<a href="mailto:%%P%%">',
            'HtmlEnd'=>'</a>')
            );
        // Adds [size /] tag to control font size
        $this->bbcode->add_tag(
            array(
            'Name'=>'size',
            'HasParam'=>true,
            'HtmlBegin'=>'<span style="font-size: %%P%%pt;">',
            'HtmlEnd'=>'</span>',
            'ParamRegex'=>'[0-9]+')
            );
        // Adds [bg /] tag to background color of text
        $this->bbcode->add_tag(
            array(
            'Name'=>'bg',
            'HasParam'=>true,
            'HtmlBegin'=>'<span style="background: %%P%%;">',
            'HtmlEnd'=>'</span>',
            'ParamRegex'=>'[A-Za-z0-9#]+'));
        // Adds [s /] tag for strikethrough effect
        $this->bbcode->add_tag(
            array(
            'Name'=>'s',
            'HtmlBegin'=>'<span style="text-decoration: line-through;">',
            'HtmlEnd'=>'</span>')
            );
        // Adds [align /] tag for text alignment
        $this->bbcode->add_tag(
            array(
            'Name'=>'align',
            'HtmlBegin'=>'<div style="text-align: %%P%%">',
            'HtmlEnd'=>'</div>',
            'HasParam'=>true,
            'ParamRegex'=>'(center|right|left)')
            );
        // Adds [url /] tag to [link /] tag
        $this->bbcode->add_alias('url','link');
    }
    /**
    * Replaces bbcode with corresponding HTML using underlying
    * bbcode->parse_bbcode() method
    * @param string text to parse for BBCode
    * @return string parsed text
    * @access public
    */
    function parse ($text) {
        return $this->bbcode->parse_bbcode($text);
    }
}
?>