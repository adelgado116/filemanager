<?php
//Include Common Files @1-AF90E393
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page0_1.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridservice_tbl_ships_tbl1 { //service_tbl_ships_tbl1 class @3-01A05661

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

//Class_Initialize Event @3-9F11B7B3
    function clsGridservice_tbl_ships_tbl1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "service_tbl_ships_tbl1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid service_tbl_ships_tbl1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsservice_tbl_ships_tbl1DataSource($this);
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

        $this->IMO_NUMBER = & new clsControl(ccsLabel, "IMO_NUMBER", "IMO_NUMBER", ccsText, "", CCGetRequestParam("IMO_NUMBER", ccsGet, NULL), $this);
        $this->SHIP_NAME = & new clsControl(ccsLabel, "SHIP_NAME", "SHIP_NAME", ccsText, "", CCGetRequestParam("SHIP_NAME", ccsGet, NULL), $this);
        $this->Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "page2.php";
        $this->Link2 = & new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $this);
        $this->Link2->Page = "../returned_parts/page1.php";
        $this->Link4 = & new clsControl(ccsLink, "Link4", "Link4", ccsText, "", CCGetRequestParam("Link4", ccsGet, NULL), $this);
        $this->Link4->Page = "../tech_eval/page1.php";
        $this->ORDER_NO1 = & new clsControl(ccsLabel, "ORDER_NO1", "ORDER_NO1", ccsText, "", CCGetRequestParam("ORDER_NO1", ccsGet, NULL), $this);
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

//Show Method @3-5CEE36F0
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlORDER_NO"] = CCGetFromGet("ORDER_NO", NULL);
        $this->DataSource->Parameters["urls_ORDER_NO"] = CCGetFromGet("s_ORDER_NO", NULL);

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
            $this->ControlsVisible["IMO_NUMBER"] = $this->IMO_NUMBER->Visible;
            $this->ControlsVisible["SHIP_NAME"] = $this->SHIP_NAME->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            $this->ControlsVisible["Link2"] = $this->Link2->Visible;
            $this->ControlsVisible["Link4"] = $this->Link4->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->IMO_NUMBER->SetValue($this->DataSource->IMO_NUMBER->GetValue());
                $this->SHIP_NAME->SetValue($this->DataSource->SHIP_NAME->GetValue());
                $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "ORDER_NO", $this->DataSource->f("ORDER_NO"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "IMO_NUMBER", $this->DataSource->f("IMO_NUMBER"));
                $this->Link2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link2->Parameters = CCAddParam($this->Link2->Parameters, "ORDER_NO", $this->DataSource->f("ORDER_NO"));
                $this->Link4->Parameters = "";
                $this->Link4->Parameters = CCAddParam($this->Link4->Parameters, "ORDER_NO", $this->DataSource->f("ORDER_NO"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->IMO_NUMBER->Show();
                $this->SHIP_NAME->Show();
                $this->Link1->Show();
                $this->Link2->Show();
                $this->Link4->Show();
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
        $this->ORDER_NO1->SetValue($this->DataSource->ORDER_NO1->GetValue());
        $this->ORDER_NO1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @3-6AC7EE8C
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->IMO_NUMBER->Errors->ToString());
        $errors = ComposeStrings($errors, $this->SHIP_NAME->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link4->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End service_tbl_ships_tbl1 Class @3-FCB6E20C

class clsservice_tbl_ships_tbl1DataSource extends clsDBhss_db {  //service_tbl_ships_tbl1DataSource Class @3-59736FCC

//DataSource Variables @3-FDA5279E
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $CountSQL;
    var $wp;


    // Datasource fields
    var $IMO_NUMBER;
    var $SHIP_NAME;
    var $ORDER_NO1;
//End DataSource Variables

//DataSourceClass_Initialize Event @3-16503B27
    function clsservice_tbl_ships_tbl1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid service_tbl_ships_tbl1";
        $this->Initialize();
        $this->IMO_NUMBER = new clsField("IMO_NUMBER", ccsText, "");
        
        $this->SHIP_NAME = new clsField("SHIP_NAME", ccsText, "");
        
        $this->ORDER_NO1 = new clsField("ORDER_NO1", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @3-F6FA0505
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "ORDER_NO desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @3-F21A03E2
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlORDER_NO", ccsText, "", "", $this->Parameters["urlORDER_NO"], "", false);
        $this->wp->AddParameter("2", "urls_ORDER_NO", ccsText, "", "", $this->Parameters["urls_ORDER_NO"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "service_tbl.ORDER_NO", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "service_tbl.ORDER_NO", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @3-41048CA8
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM service_tbl INNER JOIN ships_tbl ON\n\n" .
        "service_tbl.IMO_NUMBER = ships_tbl.IMO_NUMBER";
        $this->SQL = "SELECT service_tbl.*, SHIP_NAME \n\n" .
        "FROM service_tbl INNER JOIN ships_tbl ON\n\n" .
        "service_tbl.IMO_NUMBER = ships_tbl.IMO_NUMBER {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @3-27E5849C
    function SetValues()
    {
        $this->IMO_NUMBER->SetDBValue($this->f("IMO_NUMBER"));
        $this->SHIP_NAME->SetDBValue($this->f("SHIP_NAME"));
        $this->ORDER_NO1->SetDBValue($this->f("ORDER_NO"));
    }
//End SetValues Method

} //End service_tbl_ships_tbl1DataSource Class @3-FCB6E20C

//Initialize Page @1-04357CC0
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
$TemplateFileName = "page0_1.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-91D8A80F
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $MainPage);
$Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link1->Page = "page0.php";
$service_tbl_ships_tbl1 = & new clsGridservice_tbl_ships_tbl1("", $MainPage);
$MainPage->Link1 = & $Link1;
$MainPage->service_tbl_ships_tbl1 = & $service_tbl_ships_tbl1;
$service_tbl_ships_tbl1->Initialize();

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

//Go to destination page @1-8A625B89
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($service_tbl_ships_tbl1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-5A47EC9A
$service_tbl_ships_tbl1->Show();
$Link1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-753B5D1D
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($service_tbl_ships_tbl1);
unset($Tpl);
//End Unload Page


?>
