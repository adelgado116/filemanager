<?php
/**
* @package SPLIB
* @version $Id: ArticlePDF.php,v 1.1 2003/12/12 08:06:06 kevin Exp $
*/

error_reporting(E_ALL ^ E_NOTICE);

/**
* Include R&OS pdf class
* http://www.ros.co.nz/pdf/
*/
require_once('ThirdParty/rospdf/class.pdf.php');
require_once('ThirdParty/rospdf/class.ezpdf.php');
/**
* ArticlePDF acts as a wrapper for R&OS PDF<br />
* Renders a specific PDF design
* @package SPLIB
* @access public
*/
class ArticlePdf {
    /**
    * The URL of the article
    * @access private
    * @var string
    */
    var $articleUrl;
    /**
    * Where the fonts can be found
    * @access private
    * @var string
    */
    var $fontPath;

    /**
    * Where the image can be found
    * @access private
    * @var string
    */
    var $imagePath;
    /**
    * Instance of R&OS PDF
    * @access private
    * @var object
    */
    var $pdf;

    /**
    * ArticlePdf constructor
    * @param string url of the article
    * @param string font path
    * @param string image path
    */
    function ArticlePdf ($url,$fontPath,$imagePath='') {
        $this->articleUrl=$url;
        $this->fontPath=$fontPath;
        $this->imagePath=$imagePath;
        $this->pdf=& new Cezpdf();
        $this->pdf->ezSetMargins(40,40,155.28,90);
        $this->addObjects();
    }

    /**
    * Adds the repeating objects to the document
    * @return void
    * @access private
    */
    function addObjects () {
        $headfoot = $this->pdf->openObject();
        $this->pdf->saveState();
        $this->pdf->addJpegFromFile($this->imagePath.'sitepoint_logo.jpg',
            430,813,70,20);
        $this->pdf->setStrokeColor(0,0.2,0.4);
        $this->pdf->setLineStyle(2,'round');
        $this->pdf->line(155.28,811.89,505.28,811.89);
        $this->pdf->line(155.28,30,505.28,30);
        $this->pdf->restoreState();
        $this->pdf->closeObject();
        $bottomUrl = $this->pdf->openObject();
        $this->pdf->saveState();
        $this->pdf->selectFont($this->fontPath.'Helvetica.afm');
        $this->pdf->addText(155.28,24,6,'Found at: '.$this->articleUrl);
        $this->pdf->restoreState();
        $this->pdf->closeObject();
        $this->pdf->addObject($headfoot,'all');
        $this->pdf->addObject($bottomUrl,'even');
    }

    /**
    * Adds the PDF summary information
    * @param string title of document
    * @param string author of document
    * @param string producer of document
    * @param string date
    * @return void
    * @access public
    */
    function addInfo($title,$author,$producer,$date) {
        $info=array (
            'Title'=>$title,
            'Author'=>$author,
            'Producer'=>$producer,
            'CreationDate'=>$date
                );
        $this->pdf->addInfo($info);
    }

    /**
    * Adds the title page
    * @param string title of document
    * @param string author of document
    * @param string date
    * @param string introduction
    * @return void
    * @access public
    */
    function addTitlePage($title,$author,$date,$intro) {
        $this->pdf->selectFont($this->fontPath.'Helvetica-Bold.afm');
        $this->pdf->ezSetY(650);
        $this->pdf->saveState();
        $this->pdf->setColor(1,0.4,0);
        $this->pdf->ezText($title,20,array('justification'=>'center'));
        $this->pdf->restoreState();
        $this->pdf->ezSetDy(-50);
        $this->pdf->ezText('by '.$author,15,
            array('justification'=>'center'));
        $this->pdf->ezSetDy(-50);
        $this->pdf->ezText("<c:alink:".$this->articleUrl.">".
                    $this->articleUrl."</c:alink>",
                    11,array('justification'=>'centre'));
        $this->pdf->ezSetDy(-50);
        $this->pdf->ezText($date,13,array('justification'=>'center'));
        $this->pdf->ezSetDy(-50);
        $this->pdf->selectFont($this->fontPath.'Helvetica.afm');
        $this->pdf->ezText($intro,10,array('justification'=>'full'));
        $this->pdf->ezNewPage();
        $this->pdf->ezStartPageNumbers(505,24,6);
    }

    /**
    * Adds the text to the page
    * @param string text
    * @param int (optional) size of text
    * @param string (optional) justification
    * @return void
    * @access public
    */
    function addText ($text,$size=10,$justification='full') {
        $this->pdf->ezText($text,$size,
            array('justification'=>$justification));
    }

    /**
    * Sends the PDF document to the visitors browser
    * @param string (optional) filename
    * @return void
    * @access public
    */
    function display ($fileName='file.pdf') {
        $fileName=explode(',',chunk_split($fileName,1,','));
        foreach ( $fileName as $key => $char ) {
            if ( preg_match("/^[A-Za-z0-9_\.]$/",
                            $char,$matches) == 0 ) {
                unset($fileName[$key]);
            }
        }
        $fileName=implode('',$fileName);
        $options=array('Content-Disposition'=>$fileName);
        $this->pdf->ezStream($options);
    }
}
?>