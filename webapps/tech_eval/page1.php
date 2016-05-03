<?php
//Include Common Files @1-FB3B84F7
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page1.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridemployees_tbl_tech_eval { //employees_tbl_tech_eval class @2-AE3DF9E0

//Variables @2-AC1EDBB9

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

//Class_Initialize Event @2-760DFFB7
    function clsGridemployees_tbl_tech_eval($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "employees_tbl_tech_eval";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid employees_tbl_tech_eval";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsemployees_tbl_tech_evalDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->service_date_month = & new clsControl(ccsLabel, "service_date_month", "service_date_month", ccsText, "", CCGetRequestParam("service_date_month", ccsGet, NULL), $this);
        $this->emp_login = & new clsControl(ccsLabel, "emp_login", "emp_login", ccsText, "", CCGetRequestParam("emp_login", ccsGet, NULL), $this);
        $this->tech_eval_value_1 = & new clsControl(ccsLabel, "tech_eval_value_1", "tech_eval_value_1", ccsText, "", CCGetRequestParam("tech_eval_value_1", ccsGet, NULL), $this);
        $this->tech_eval_value_2 = & new clsControl(ccsLabel, "tech_eval_value_2", "tech_eval_value_2", ccsText, "", CCGetRequestParam("tech_eval_value_2", ccsGet, NULL), $this);
        $this->service_date_year = & new clsControl(ccsLabel, "service_date_year", "service_date_year", ccsText, "", CCGetRequestParam("service_date_year", ccsGet, NULL), $this);
        $this->service_date_day = & new clsControl(ccsLabel, "service_date_day", "service_date_day", ccsText, "", CCGetRequestParam("service_date_day", ccsGet, NULL), $this);
        $this->tech_eval_value_4 = & new clsControl(ccsLabel, "tech_eval_value_4", "tech_eval_value_4", ccsText, "", CCGetRequestParam("tech_eval_value_4", ccsGet, NULL), $this);
        $this->Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "page1_1.php";
        $this->tech_eval_value_3 = & new clsControl(ccsLabel, "tech_eval_value_3", "tech_eval_value_3", ccsText, "", CCGetRequestParam("tech_eval_value_3", ccsGet, NULL), $this);
        $this->Link2 = & new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $this);
        $this->Link2->Page = "page2.php";
        $this->Navigator = & new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @2-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @2-88D69082
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlORDER_NO"] = CCGetFromGet("ORDER_NO", NULL);

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
            $this->ControlsVisible["service_date_month"] = $this->service_date_month->Visible;
            $this->ControlsVisible["emp_login"] = $this->emp_login->Visible;
            $this->ControlsVisible["tech_eval_value_1"] = $this->tech_eval_value_1->Visible;
            $this->ControlsVisible["tech_eval_value_2"] = $this->tech_eval_value_2->Visible;
            $this->ControlsVisible["service_date_year"] = $this->service_date_year->Visible;
            $this->ControlsVisible["service_date_day"] = $this->service_date_day->Visible;
            $this->ControlsVisible["tech_eval_value_4"] = $this->tech_eval_value_4->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            $this->ControlsVisible["tech_eval_value_3"] = $this->tech_eval_value_3->Visible;
            $this->ControlsVisible["Link2"] = $this->Link2->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->service_date_month->SetValue($this->DataSource->service_date_month->GetValue());
                $this->emp_login->SetValue($this->DataSource->emp_login->GetValue());
                $this->tech_eval_value_1->SetValue($this->DataSource->tech_eval_value_1->GetValue());
                $this->tech_eval_value_2->SetValue($this->DataSource->tech_eval_value_2->GetValue());
                $this->service_date_year->SetValue($this->DataSource->service_date_year->GetValue());
                $this->service_date_day->SetValue($this->DataSource->service_date_day->GetValue());
                $this->tech_eval_value_4->SetValue($this->DataSource->tech_eval_value_4->GetValue());
                $this->Link1->Parameters = "";
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "evaluation_id", $this->DataSource->f("evaluation_id"));
                $this->tech_eval_value_3->SetValue($this->DataSource->tech_eval_value_3->GetValue());
                $this->Link2->Parameters = "";
                $this->Link2->Parameters = CCAddParam($this->Link2->Parameters, "tech_id", $this->DataSource->f("tech_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->service_date_month->Show();
                $this->emp_login->Show();
                $this->tech_eval_value_1->Show();
                $this->tech_eval_value_2->Show();
                $this->service_date_year->Show();
                $this->service_date_day->Show();
                $this->tech_eval_value_4->Show();
                $this->Link1->Show();
                $this->tech_eval_value_3->Show();
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
        $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator->TotalPages = $this->DataSource->PageCount();
        if ($this->Navigator->TotalPages <= 1) {
            $this->Navigator->Visible = false;
        }
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-729BECA4
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->service_date_month->Errors->ToString());
        $errors = ComposeStrings($errors, $this->emp_login->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tech_eval_value_1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tech_eval_value_2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->service_date_year->Errors->ToString());
        $errors = ComposeStrings($errors, $this->service_date_day->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tech_eval_value_4->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tech_eval_value_3->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End employees_tbl_tech_eval Class @2-FCB6E20C

class clsemployees_tbl_tech_evalDataSource extends clsDBhss_db {  //employees_tbl_tech_evalDataSource Class @2-93401197

//DataSource Variables @2-D4D4476B
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $CountSQL;
    var $wp;


    // Datasource fields
    var $service_date_month;
    var $emp_login;
    var $tech_eval_value_1;
    var $tech_eval_value_2;
    var $service_date_year;
    var $service_date_day;
    var $tech_eval_value_4;
    var $tech_eval_value_3;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-F6084E86
    function clsemployees_tbl_tech_evalDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid employees_tbl_tech_eval";
        $this->Initialize();
        $this->service_date_month = new clsField("service_date_month", ccsText, "");
        
        $this->emp_login = new clsField("emp_login", ccsText, "");
        
        $this->tech_eval_value_1 = new clsField("tech_eval_value_1", ccsText, "");
        
        $this->tech_eval_value_2 = new clsField("tech_eval_value_2", ccsText, "");
        
        $this->service_date_year = new clsField("service_date_year", ccsText, "");
        
        $this->service_date_day = new clsField("service_date_day", ccsText, "");
        
        $this->tech_eval_value_4 = new clsField("tech_eval_value_4", ccsText, "");
        
        $this->tech_eval_value_3 = new clsField("tech_eval_value_3", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-D0B97935
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "tech_eval.service_date_year desc, tech_eval.service_date_month desc, tech_eval.service_date_day desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-4D178149
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlORDER_NO", ccsText, "", "", $this->Parameters["urlORDER_NO"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "tech_eval.ORDER_NO", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-4BF01FD5
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((((tech_eval INNER JOIN employees_tbl ON\n\n" .
        "employees_tbl.emp_id = tech_eval.tech_id) INNER JOIN tech_eval_values ON\n\n" .
        "tech_eval.performance = tech_eval_values.tech_eval_value_id) INNER JOIN tech_eval_values tech_eval_values1 ON\n\n" .
        "tech_eval.coordination = tech_eval_values1.tech_eval_value_id) INNER JOIN tech_eval_values tech_eval_values2 ON\n\n" .
        "tech_eval.accomplishment = tech_eval_values2.tech_eval_value_id) INNER JOIN tech_eval_values tech_eval_values3 ON\n\n" .
        "tech_eval.quality = tech_eval_values3.tech_eval_value_id";
        $this->SQL = "SELECT emp_login, tech_eval.*, tech_eval_values.tech_eval_value AS tech_eval_values_tech_eval_value, tech_eval_values1.tech_eval_value AS tech_eval_values1_tech_eval_value,\n\n" .
        "tech_eval_values2.tech_eval_value AS tech_eval_values2_tech_eval_value, tech_eval_values3.tech_eval_value AS tech_eval_values3_tech_eval_value \n\n" .
        "FROM ((((tech_eval INNER JOIN employees_tbl ON\n\n" .
        "employees_tbl.emp_id = tech_eval.tech_id) INNER JOIN tech_eval_values ON\n\n" .
        "tech_eval.performance = tech_eval_values.tech_eval_value_id) INNER JOIN tech_eval_values tech_eval_values1 ON\n\n" .
        "tech_eval.coordination = tech_eval_values1.tech_eval_value_id) INNER JOIN tech_eval_values tech_eval_values2 ON\n\n" .
        "tech_eval.accomplishment = tech_eval_values2.tech_eval_value_id) INNER JOIN tech_eval_values tech_eval_values3 ON\n\n" .
        "tech_eval.quality = tech_eval_values3.tech_eval_value_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-5121AF59
    function SetValues()
    {
        $this->service_date_month->SetDBValue($this->f("service_date_month"));
        $this->emp_login->SetDBValue($this->f("emp_login"));
        $this->tech_eval_value_1->SetDBValue($this->f("tech_eval_values_tech_eval_value"));
        $this->tech_eval_value_2->SetDBValue($this->f("tech_eval_values1_tech_eval_value"));
        $this->service_date_year->SetDBValue($this->f("service_date_year"));
        $this->service_date_day->SetDBValue($this->f("service_date_day"));
        $this->tech_eval_value_4->SetDBValue($this->f("tech_eval_values3_tech_eval_value"));
        $this->tech_eval_value_3->SetDBValue($this->f("tech_eval_values2_tech_eval_value"));
    }
//End SetValues Method

} //End employees_tbl_tech_evalDataSource Class @2-FCB6E20C

//Initialize Page @1-05FAD16F
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
$TemplateFileName = "page1.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-63B556BD
include_once("./page1_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-C54A4B52
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$employees_tbl_tech_eval = & new clsGridemployees_tbl_tech_eval("", $MainPage);
$Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $MainPage);
$Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link1->Parameters = CCAddParam($Link1->Parameters, "ORDER_NO", CCGetSession("order", NULL));
$Link1->Page = "page1.php";
$MainPage->employees_tbl_tech_eval = & $employees_tbl_tech_eval;
$MainPage->Link1 = & $Link1;
$employees_tbl_tech_eval->Initialize();

BindEvents();

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

//Go to destination page @1-59248B96
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($employees_tbl_tech_eval);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-5DD5A50A
$employees_tbl_tech_eval->Show();
$Link1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-D89E94A3
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($employees_tbl_tech_eval);
unset($Tpl);
//End Unload Page


?>
