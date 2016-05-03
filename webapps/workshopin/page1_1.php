<?php
//Include Common Files @1-A554397E
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page1_1.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridworkshop_repair { //workshop_repair class @3-E47C0801

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

//Class_Initialize Event @3-21E6C426
    function clsGridworkshop_repair($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "workshop_repair";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid workshop_repair";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsworkshop_repairDataSource($this);
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

        $this->workshop_in_id = & new clsControl(ccsLabel, "workshop_in_id", "workshop_in_id", ccsInteger, "", CCGetRequestParam("workshop_in_id", ccsGet, NULL), $this);
        $this->date_received = & new clsControl(ccsLabel, "date_received", "date_received", ccsText, "", CCGetRequestParam("date_received", ccsGet, NULL), $this);
        $this->ship_name = & new clsControl(ccsLabel, "ship_name", "ship_name", ccsText, "", CCGetRequestParam("ship_name", ccsGet, NULL), $this);
        $this->imo = & new clsControl(ccsLabel, "imo", "imo", ccsText, "", CCGetRequestParam("imo", ccsGet, NULL), $this);
        $this->customer = & new clsControl(ccsLabel, "customer", "customer", ccsText, "", CCGetRequestParam("customer", ccsGet, NULL), $this);
        $this->customer_phone = & new clsControl(ccsLabel, "customer_phone", "customer_phone", ccsText, "", CCGetRequestParam("customer_phone", ccsGet, NULL), $this);
        $this->customer_email = & new clsControl(ccsLabel, "customer_email", "customer_email", ccsText, "", CCGetRequestParam("customer_email", ccsGet, NULL), $this);
        $this->EQUIP_TYPE = & new clsControl(ccsLabel, "EQUIP_TYPE", "EQUIP_TYPE", ccsText, "", CCGetRequestParam("EQUIP_TYPE", ccsGet, NULL), $this);
        $this->MANUF_NAME = & new clsControl(ccsLabel, "MANUF_NAME", "MANUF_NAME", ccsText, "", CCGetRequestParam("MANUF_NAME", ccsGet, NULL), $this);
        $this->EQUIP_MODEL = & new clsControl(ccsLabel, "EQUIP_MODEL", "EQUIP_MODEL", ccsText, "", CCGetRequestParam("EQUIP_MODEL", ccsGet, NULL), $this);
        $this->part_no = & new clsControl(ccsLabel, "part_no", "part_no", ccsText, "", CCGetRequestParam("part_no", ccsGet, NULL), $this);
        $this->sn = & new clsControl(ccsLabel, "sn", "sn", ccsText, "", CCGetRequestParam("sn", ccsGet, NULL), $this);
        $this->notes = & new clsControl(ccsLabel, "notes", "notes", ccsMemo, "", CCGetRequestParam("notes", ccsGet, NULL), $this);
        $this->emp_login = & new clsControl(ccsLabel, "emp_login", "emp_login", ccsText, "", CCGetRequestParam("emp_login", ccsGet, NULL), $this);
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

//Show Method @3-E4D616E2
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlworkshop_in_id"] = CCGetFromGet("workshop_in_id", NULL);

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
            $this->ControlsVisible["workshop_in_id"] = $this->workshop_in_id->Visible;
            $this->ControlsVisible["date_received"] = $this->date_received->Visible;
            $this->ControlsVisible["ship_name"] = $this->ship_name->Visible;
            $this->ControlsVisible["imo"] = $this->imo->Visible;
            $this->ControlsVisible["customer"] = $this->customer->Visible;
            $this->ControlsVisible["customer_phone"] = $this->customer_phone->Visible;
            $this->ControlsVisible["customer_email"] = $this->customer_email->Visible;
            $this->ControlsVisible["EQUIP_TYPE"] = $this->EQUIP_TYPE->Visible;
            $this->ControlsVisible["MANUF_NAME"] = $this->MANUF_NAME->Visible;
            $this->ControlsVisible["EQUIP_MODEL"] = $this->EQUIP_MODEL->Visible;
            $this->ControlsVisible["part_no"] = $this->part_no->Visible;
            $this->ControlsVisible["sn"] = $this->sn->Visible;
            $this->ControlsVisible["notes"] = $this->notes->Visible;
            $this->ControlsVisible["emp_login"] = $this->emp_login->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->workshop_in_id->SetValue($this->DataSource->workshop_in_id->GetValue());
                $this->date_received->SetValue($this->DataSource->date_received->GetValue());
                $this->ship_name->SetValue($this->DataSource->ship_name->GetValue());
                $this->imo->SetValue($this->DataSource->imo->GetValue());
                $this->customer->SetValue($this->DataSource->customer->GetValue());
                $this->customer_phone->SetValue($this->DataSource->customer_phone->GetValue());
                $this->customer_email->SetValue($this->DataSource->customer_email->GetValue());
                $this->EQUIP_TYPE->SetValue($this->DataSource->EQUIP_TYPE->GetValue());
                $this->MANUF_NAME->SetValue($this->DataSource->MANUF_NAME->GetValue());
                $this->EQUIP_MODEL->SetValue($this->DataSource->EQUIP_MODEL->GetValue());
                $this->part_no->SetValue($this->DataSource->part_no->GetValue());
                $this->sn->SetValue($this->DataSource->sn->GetValue());
                $this->notes->SetValue($this->DataSource->notes->GetValue());
                $this->emp_login->SetValue($this->DataSource->emp_login->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->workshop_in_id->Show();
                $this->date_received->Show();
                $this->ship_name->Show();
                $this->imo->Show();
                $this->customer->Show();
                $this->customer_phone->Show();
                $this->customer_email->Show();
                $this->EQUIP_TYPE->Show();
                $this->MANUF_NAME->Show();
                $this->EQUIP_MODEL->Show();
                $this->part_no->Show();
                $this->sn->Show();
                $this->notes->Show();
                $this->emp_login->Show();
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

//GetErrors Method @3-0B76226B
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->workshop_in_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->date_received->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ship_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->imo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->customer->Errors->ToString());
        $errors = ComposeStrings($errors, $this->customer_phone->Errors->ToString());
        $errors = ComposeStrings($errors, $this->customer_email->Errors->ToString());
        $errors = ComposeStrings($errors, $this->EQUIP_TYPE->Errors->ToString());
        $errors = ComposeStrings($errors, $this->MANUF_NAME->Errors->ToString());
        $errors = ComposeStrings($errors, $this->EQUIP_MODEL->Errors->ToString());
        $errors = ComposeStrings($errors, $this->part_no->Errors->ToString());
        $errors = ComposeStrings($errors, $this->sn->Errors->ToString());
        $errors = ComposeStrings($errors, $this->notes->Errors->ToString());
        $errors = ComposeStrings($errors, $this->emp_login->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End workshop_repair Class @3-FCB6E20C

class clsworkshop_repairDataSource extends clsDBhss_db {  //workshop_repairDataSource Class @3-ACAA58D1

//DataSource Variables @3-0C1ABD0D
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $CountSQL;
    var $wp;


    // Datasource fields
    var $workshop_in_id;
    var $date_received;
    var $ship_name;
    var $imo;
    var $customer;
    var $customer_phone;
    var $customer_email;
    var $EQUIP_TYPE;
    var $MANUF_NAME;
    var $EQUIP_MODEL;
    var $part_no;
    var $sn;
    var $notes;
    var $emp_login;
//End DataSource Variables

//DataSourceClass_Initialize Event @3-5D432008
    function clsworkshop_repairDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid workshop_repair";
        $this->Initialize();
        $this->workshop_in_id = new clsField("workshop_in_id", ccsInteger, "");
        
        $this->date_received = new clsField("date_received", ccsText, "");
        
        $this->ship_name = new clsField("ship_name", ccsText, "");
        
        $this->imo = new clsField("imo", ccsText, "");
        
        $this->customer = new clsField("customer", ccsText, "");
        
        $this->customer_phone = new clsField("customer_phone", ccsText, "");
        
        $this->customer_email = new clsField("customer_email", ccsText, "");
        
        $this->EQUIP_TYPE = new clsField("EQUIP_TYPE", ccsText, "");
        
        $this->MANUF_NAME = new clsField("MANUF_NAME", ccsText, "");
        
        $this->EQUIP_MODEL = new clsField("EQUIP_MODEL", ccsText, "");
        
        $this->part_no = new clsField("part_no", ccsText, "");
        
        $this->sn = new clsField("sn", ccsText, "");
        
        $this->notes = new clsField("notes", ccsMemo, "");
        
        $this->emp_login = new clsField("emp_login", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @3-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @3-B9BF68E3
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlworkshop_in_id", ccsInteger, "", "", $this->Parameters["urlworkshop_in_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "workshop_repair.workshop_in_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @3-54D87842
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM workshop_repair INNER JOIN employees_tbl ON\n\n" .
        "workshop_repair.emp_id = employees_tbl.emp_id";
        $this->SQL = "SELECT workshop_repair.*, emp_login \n\n" .
        "FROM workshop_repair INNER JOIN employees_tbl ON\n\n" .
        "workshop_repair.emp_id = employees_tbl.emp_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @3-520C98F2
    function SetValues()
    {
        $this->workshop_in_id->SetDBValue(trim($this->f("workshop_in_id")));
        $this->date_received->SetDBValue($this->f("date_received"));
        $this->ship_name->SetDBValue($this->f("ship_name"));
        $this->imo->SetDBValue($this->f("imo"));
        $this->customer->SetDBValue($this->f("customer"));
        $this->customer_phone->SetDBValue($this->f("customer_phone"));
        $this->customer_email->SetDBValue($this->f("customer_email"));
        $this->EQUIP_TYPE->SetDBValue($this->f("EQUIP_TYPE"));
        $this->MANUF_NAME->SetDBValue($this->f("MANUF_NAME"));
        $this->EQUIP_MODEL->SetDBValue($this->f("EQUIP_MODEL"));
        $this->part_no->SetDBValue($this->f("part_no"));
        $this->sn->SetDBValue($this->f("sn"));
        $this->notes->SetDBValue($this->f("notes"));
        $this->emp_login->SetDBValue($this->f("emp_login"));
    }
//End SetValues Method

} //End workshop_repairDataSource Class @3-FCB6E20C

//Initialize Page @1-53A2AB57
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
$TemplateFileName = "page1_1.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-1C1C39C3
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Link2 = & new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $MainPage);
$Link2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link2->Page = "page1.php";
$workshop_repair = & new clsGridworkshop_repair("", $MainPage);
$MainPage->Link2 = & $Link2;
$MainPage->workshop_repair = & $workshop_repair;
$workshop_repair->Initialize();

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

//Go to destination page @1-AB3877A1
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($workshop_repair);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-04343E53
$workshop_repair->Show();
$Link2->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-E565BE31
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($workshop_repair);
unset($Tpl);
//End Unload Page


?>
