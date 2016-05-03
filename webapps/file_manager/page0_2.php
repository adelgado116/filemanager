<?php
//Include Common Files @1-9110B898
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page0_2.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridships_tbl { //ships_tbl class @3-78CD5D10

//Variables @3-AC1EDBB9

    // Public variables
    var $ComponentType = "Grid";
    var $ComponentName;
    var $Visible;
    var $Errors;
    var $ErrorBlock;
    var $ds;
    var $DataSource;
    var $PageSize;
    var $IsEmpty;
    var $ForceIteration = false;
    var $HasRecord = false;
    var $SorterName = "";
    var $SorterDirection = "";
    var $PageNumber;
    var $RowNumber;
    var $ControlsVisible = array();

    var $CCSEvents = "";
    var $CCSEventResult;

    var $RelativePath = "";
    var $Attributes;

    // Grid Controls
    var $StaticControls;
    var $RowControls;
//End Variables

//Class_Initialize Event @3-D0C27145
    function clsGridships_tbl($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "ships_tbl";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid ships_tbl";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsships_tblDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 1;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->SHIP_NAME = & new clsControl(ccsLabel, "SHIP_NAME", "SHIP_NAME", ccsText, "", CCGetRequestParam("SHIP_NAME", ccsGet, NULL), $this);
        $this->IMO_NUMBER = & new clsControl(ccsLabel, "IMO_NUMBER", "IMO_NUMBER", ccsText, "", CCGetRequestParam("IMO_NUMBER", ccsGet, NULL), $this);
        $this->OWNER = & new clsControl(ccsLabel, "OWNER", "OWNER", ccsText, "", CCGetRequestParam("OWNER", ccsGet, NULL), $this);
        $this->MMSI = & new clsControl(ccsLabel, "MMSI", "MMSI", ccsText, "", CCGetRequestParam("MMSI", ccsGet, NULL), $this);
        $this->CALL_SIGN = & new clsControl(ccsLabel, "CALL_SIGN", "CALL_SIGN", ccsText, "", CCGetRequestParam("CALL_SIGN", ccsGet, NULL), $this);
        $this->Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "page1.php";
        $this->satcom_voice_1 = & new clsControl(ccsLabel, "satcom_voice_1", "satcom_voice_1", ccsText, "", CCGetRequestParam("satcom_voice_1", ccsGet, NULL), $this);
        $this->Link2 = & new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $this);
        $this->Link2->Page = "page2_2.php";
    }
//End Class_Initialize Event

//Initialize Method @3-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @3-5BA44D95
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_SHIP_NAME"] = CCGetFromGet("s_SHIP_NAME", NULL);
        $this->DataSource->Parameters["urls_IMO_NUMBER"] = CCGetFromGet("s_IMO_NUMBER", NULL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->Prepare();
        $this->DataSource->Open();
        $this->HasRecord = $this->DataSource->has_next_record();
        $this->IsEmpty = ! $this->HasRecord;
        $this->Attributes->Show();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $GridBlock = "Grid " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $GridBlock;


        if (!$this->IsEmpty) {
            $this->ControlsVisible["SHIP_NAME"] = $this->SHIP_NAME->Visible;
            $this->ControlsVisible["IMO_NUMBER"] = $this->IMO_NUMBER->Visible;
            $this->ControlsVisible["OWNER"] = $this->OWNER->Visible;
            $this->ControlsVisible["MMSI"] = $this->MMSI->Visible;
            $this->ControlsVisible["CALL_SIGN"] = $this->CALL_SIGN->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            $this->ControlsVisible["satcom_voice_1"] = $this->satcom_voice_1->Visible;
            $this->ControlsVisible["Link2"] = $this->Link2->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->SHIP_NAME->SetValue($this->DataSource->SHIP_NAME->GetValue());
                $this->IMO_NUMBER->SetValue($this->DataSource->IMO_NUMBER->GetValue());
                $this->OWNER->SetValue($this->DataSource->OWNER->GetValue());
                $this->MMSI->SetValue($this->DataSource->MMSI->GetValue());
                $this->CALL_SIGN->SetValue($this->DataSource->CALL_SIGN->GetValue());
                $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "IMO_NUMBER", $this->DataSource->f("IMO_NUMBER"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "SHIP_NAME", $this->DataSource->f("SHIP_NAME"));
                $this->satcom_voice_1->SetValue($this->DataSource->satcom_voice_1->GetValue());
                $this->Link2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link2->Parameters = CCAddParam($this->Link2->Parameters, "IMO_NUMBER", $this->DataSource->f("IMO_NUMBER"));
                $this->Link2->Parameters = CCAddParam($this->Link2->Parameters, "SHIP_NAME", $this->DataSource->f("SHIP_NAME"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->SHIP_NAME->Show();
                $this->IMO_NUMBER->Show();
                $this->OWNER->Show();
                $this->MMSI->Show();
                $this->CALL_SIGN->Show();
                $this->Link1->Show();
                $this->satcom_voice_1->Show();
                $this->Link2->Show();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
            }
        }
        else { // Show NoRecords block if no records are found
            $this->Attributes->Show();
            $Tpl->parse("NoRecords", false);
        }

        $errors = $this->GetErrors();
        if(strlen($errors))
        {
            $Tpl->replaceblock("", $errors);
            $Tpl->block_path = $ParentPath;
            return;
        }
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @3-9743B056
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->SHIP_NAME->Errors->ToString());
        $errors = ComposeStrings($errors, $this->IMO_NUMBER->Errors->ToString());
        $errors = ComposeStrings($errors, $this->OWNER->Errors->ToString());
        $errors = ComposeStrings($errors, $this->MMSI->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CALL_SIGN->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->satcom_voice_1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End ships_tbl Class @3-FCB6E20C

class clsships_tblDataSource extends clsDBhss_db {  //ships_tblDataSource Class @3-5873B2D2

//DataSource Variables @3-B44EE968
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $CountSQL;
    var $wp;


    // Datasource fields
    var $SHIP_NAME;
    var $IMO_NUMBER;
    var $OWNER;
    var $MMSI;
    var $CALL_SIGN;
    var $satcom_voice_1;
//End DataSource Variables

//DataSourceClass_Initialize Event @3-A3EC048B
    function clsships_tblDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid ships_tbl";
        $this->Initialize();
        $this->SHIP_NAME = new clsField("SHIP_NAME", ccsText, "");
        
        $this->IMO_NUMBER = new clsField("IMO_NUMBER", ccsText, "");
        
        $this->OWNER = new clsField("OWNER", ccsText, "");
        
        $this->MMSI = new clsField("MMSI", ccsText, "");
        
        $this->CALL_SIGN = new clsField("CALL_SIGN", ccsText, "");
        
        $this->satcom_voice_1 = new clsField("satcom_voice_1", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @3-079394FA
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "SHIP_NAME";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @3-946C8FA0
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_SHIP_NAME", ccsText, "", "", $this->Parameters["urls_SHIP_NAME"], "", false);
        $this->wp->AddParameter("2", "urls_IMO_NUMBER", ccsText, "", "", $this->Parameters["urls_IMO_NUMBER"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "SHIP_NAME", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "IMO_NUMBER", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @3-817D0CAB
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ships_tbl";
        $this->SQL = "SELECT * \n\n" .
        "FROM ships_tbl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @3-05752FA8
    function SetValues()
    {
        $this->SHIP_NAME->SetDBValue($this->f("SHIP_NAME"));
        $this->IMO_NUMBER->SetDBValue($this->f("IMO_NUMBER"));
        $this->OWNER->SetDBValue($this->f("OWNER"));
        $this->MMSI->SetDBValue($this->f("MMSI"));
        $this->CALL_SIGN->SetDBValue($this->f("CALL_SIGN"));
        $this->satcom_voice_1->SetDBValue($this->f("satcom_voice_1"));
    }
//End SetValues Method

} //End ships_tblDataSource Class @3-FCB6E20C

//Initialize Page @1-B25D71AB
// Variables
$FileName = "";
$Redirect = "";
$Tpl = "";
$TemplateFileName = "";
$BlockToParse = "";
$ComponentName = "";
$Attributes = "";

// Events;
$CCSEvents = "";
$CCSEventResult = "";

$FileName = FileName;
$Redirect = "";
$TemplateFileName = "page0_2.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-4FE59E94
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $MainPage);
$Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link1->Page = "page0.php";
$ships_tbl = & new clsGridships_tbl("", $MainPage);
$MainPage->Link1 = & $Link1;
$MainPage->ships_tbl = & $ships_tbl;
$ships_tbl->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize", $MainPage);

if ($Charset) {
    header("Content-Type: " . $ContentType . "; charset=" . $Charset);
} else {
    header("Content-Type: " . $ContentType);
}
//End Initialize Objects

//Initialize HTML Template @1-E710DB26
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView", $MainPage);
$Tpl = new clsTemplate($FileEncoding, $TemplateEncoding);
$Tpl->LoadTemplate(PathToCurrentPage . $TemplateFileName, $BlockToParse, "CP1252");
$Tpl->block_path = "/$BlockToParse";
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow", $MainPage);
$Attributes->SetValue("pathToRoot", "");
$Attributes->Show();
//End Initialize HTML Template

//Go to destination page @1-F0DB16C0
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($ships_tbl);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-4C017F9B
$ships_tbl->Show();
$Link1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-6D687C9E
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($ships_tbl);
unset($Tpl);
//End Unload Page


?>
