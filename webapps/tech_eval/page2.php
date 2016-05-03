<?php
//Include Common Files @1-C5BBDFFC
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page2.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridtech_eval { //tech_eval class @3-9D1F7CE7

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

//Class_Initialize Event @3-625B8FA2
    function clsGridtech_eval($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "tech_eval";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid tech_eval";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clstech_evalDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 25;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->ORDER_NO = & new clsControl(ccsLabel, "ORDER_NO", "ORDER_NO", ccsText, "", CCGetRequestParam("ORDER_NO", ccsGet, NULL), $this);
        $this->service_date_day = & new clsControl(ccsLabel, "service_date_day", "service_date_day", ccsText, "", CCGetRequestParam("service_date_day", ccsGet, NULL), $this);
        $this->performance = & new clsControl(ccsLabel, "performance", "performance", ccsText, "", CCGetRequestParam("performance", ccsGet, NULL), $this);
        $this->coordination = & new clsControl(ccsLabel, "coordination", "coordination", ccsText, "", CCGetRequestParam("coordination", ccsGet, NULL), $this);
        $this->accomplishment = & new clsControl(ccsLabel, "accomplishment", "accomplishment", ccsText, "", CCGetRequestParam("accomplishment", ccsGet, NULL), $this);
        $this->quality = & new clsControl(ccsLabel, "quality", "quality", ccsText, "", CCGetRequestParam("quality", ccsGet, NULL), $this);
        $this->service_date_month = & new clsControl(ccsLabel, "service_date_month", "service_date_month", ccsText, "", CCGetRequestParam("service_date_month", ccsGet, NULL), $this);
        $this->service_date_year = & new clsControl(ccsLabel, "service_date_year", "service_date_year", ccsText, "", CCGetRequestParam("service_date_year", ccsGet, NULL), $this);
        $this->Navigator = & new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->emp_name = & new clsControl(ccsLabel, "emp_name", "emp_name", ccsText, "", CCGetRequestParam("emp_name", ccsGet, NULL), $this);
        $this->Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "export.php";
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

//Show Method @3-8AC89C06
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urltech_id"] = CCGetFromGet("tech_id", NULL);

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
            $this->ControlsVisible["ORDER_NO"] = $this->ORDER_NO->Visible;
            $this->ControlsVisible["service_date_day"] = $this->service_date_day->Visible;
            $this->ControlsVisible["performance"] = $this->performance->Visible;
            $this->ControlsVisible["coordination"] = $this->coordination->Visible;
            $this->ControlsVisible["accomplishment"] = $this->accomplishment->Visible;
            $this->ControlsVisible["quality"] = $this->quality->Visible;
            $this->ControlsVisible["service_date_month"] = $this->service_date_month->Visible;
            $this->ControlsVisible["service_date_year"] = $this->service_date_year->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->ORDER_NO->SetValue($this->DataSource->ORDER_NO->GetValue());
                $this->service_date_day->SetValue($this->DataSource->service_date_day->GetValue());
                $this->performance->SetValue($this->DataSource->performance->GetValue());
                $this->coordination->SetValue($this->DataSource->coordination->GetValue());
                $this->accomplishment->SetValue($this->DataSource->accomplishment->GetValue());
                $this->quality->SetValue($this->DataSource->quality->GetValue());
                $this->service_date_month->SetValue($this->DataSource->service_date_month->GetValue());
                $this->service_date_year->SetValue($this->DataSource->service_date_year->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->ORDER_NO->Show();
                $this->service_date_day->Show();
                $this->performance->Show();
                $this->coordination->Show();
                $this->accomplishment->Show();
                $this->quality->Show();
                $this->service_date_month->Show();
                $this->service_date_year->Show();
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
        $this->emp_name->SetValue($this->DataSource->emp_name->GetValue());
        $this->Link1->Parameters = "";
        $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "tech_id", $this->DataSource->f("tech_id"));
        $this->Navigator->Show();
        $this->emp_name->Show();
        $this->Link1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @3-7E8364DB
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->ORDER_NO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->service_date_day->Errors->ToString());
        $errors = ComposeStrings($errors, $this->performance->Errors->ToString());
        $errors = ComposeStrings($errors, $this->coordination->Errors->ToString());
        $errors = ComposeStrings($errors, $this->accomplishment->Errors->ToString());
        $errors = ComposeStrings($errors, $this->quality->Errors->ToString());
        $errors = ComposeStrings($errors, $this->service_date_month->Errors->ToString());
        $errors = ComposeStrings($errors, $this->service_date_year->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End tech_eval Class @3-FCB6E20C

class clstech_evalDataSource extends clsDBhss_db {  //tech_evalDataSource Class @3-C566368A

//DataSource Variables @3-9A1F2B4F
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $CountSQL;
    var $wp;


    // Datasource fields
    var $ORDER_NO;
    var $service_date_day;
    var $performance;
    var $coordination;
    var $accomplishment;
    var $quality;
    var $emp_name;
    var $service_date_month;
    var $service_date_year;
//End DataSource Variables

//DataSourceClass_Initialize Event @3-FFE7E5D2
    function clstech_evalDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid tech_eval";
        $this->Initialize();
        $this->ORDER_NO = new clsField("ORDER_NO", ccsText, "");
        
        $this->service_date_day = new clsField("service_date_day", ccsText, "");
        
        $this->performance = new clsField("performance", ccsText, "");
        
        $this->coordination = new clsField("coordination", ccsText, "");
        
        $this->accomplishment = new clsField("accomplishment", ccsText, "");
        
        $this->quality = new clsField("quality", ccsText, "");
        
        $this->emp_name = new clsField("emp_name", ccsText, "");
        
        $this->service_date_month = new clsField("service_date_month", ccsText, "");
        
        $this->service_date_year = new clsField("service_date_year", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @3-D0B97935
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "tech_eval.service_date_year desc, tech_eval.service_date_month desc, tech_eval.service_date_day desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @3-A802CAFF
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urltech_id", ccsInteger, "", "", $this->Parameters["urltech_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "tech_eval.tech_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @3-719A3C44
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((((tech_eval INNER JOIN employees_tbl ON\n\n" .
        "tech_eval.tech_id = employees_tbl.emp_id) INNER JOIN tech_eval_values ON\n\n" .
        "tech_eval.performance = tech_eval_values.tech_eval_value_id) INNER JOIN tech_eval_values tech_eval_values1 ON\n\n" .
        "tech_eval.coordination = tech_eval_values1.tech_eval_value_id) INNER JOIN tech_eval_values tech_eval_values2 ON\n\n" .
        "tech_eval.accomplishment = tech_eval_values2.tech_eval_value_id) INNER JOIN tech_eval_values tech_eval_values3 ON\n\n" .
        "tech_eval.quality = tech_eval_values3.tech_eval_value_id";
        $this->SQL = "SELECT tech_eval.*, emp_name, tech_eval_values.tech_eval_value AS tech_eval_values_tech_eval_value, tech_eval_values1.tech_eval_value AS tech_eval_values1_tech_eval_value,\n\n" .
        "tech_eval_values2.tech_eval_value AS tech_eval_values2_tech_eval_value, tech_eval_values3.tech_eval_value AS tech_eval_values3_tech_eval_value \n\n" .
        "FROM ((((tech_eval INNER JOIN employees_tbl ON\n\n" .
        "tech_eval.tech_id = employees_tbl.emp_id) INNER JOIN tech_eval_values ON\n\n" .
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

//SetValues Method @3-45A3D867
    function SetValues()
    {
        $this->ORDER_NO->SetDBValue($this->f("ORDER_NO"));
        $this->service_date_day->SetDBValue($this->f("service_date_day"));
        $this->performance->SetDBValue($this->f("tech_eval_values_tech_eval_value"));
        $this->coordination->SetDBValue($this->f("tech_eval_values1_tech_eval_value"));
        $this->accomplishment->SetDBValue($this->f("tech_eval_values2_tech_eval_value"));
        $this->quality->SetDBValue($this->f("tech_eval_values3_tech_eval_value"));
        $this->emp_name->SetDBValue($this->f("emp_name"));
        $this->service_date_month->SetDBValue($this->f("service_date_month"));
        $this->service_date_year->SetDBValue($this->f("service_date_year"));
    }
//End SetValues Method

} //End tech_evalDataSource Class @3-FCB6E20C

//Initialize Page @1-B392DC04
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
$TemplateFileName = "page2.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-3B332475
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tech_eval = & new clsGridtech_eval("", $MainPage);
$MainPage->tech_eval = & $tech_eval;
$tech_eval->Initialize();

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

//Go to destination page @1-D16CF0FF
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($tech_eval);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-D6791599
$tech_eval->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-0FE9238D
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($tech_eval);
unset($Tpl);
//End Unload Page


?>
