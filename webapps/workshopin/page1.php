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

//Class_Initialize Event @3-F8D03602
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
            $this->PageSize = 5;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->date_received = & new clsControl(ccsLabel, "date_received", "date_received", ccsText, "", CCGetRequestParam("date_received", ccsGet, NULL), $this);
        $this->ship_name = & new clsControl(ccsLabel, "ship_name", "ship_name", ccsText, "", CCGetRequestParam("ship_name", ccsGet, NULL), $this);
        $this->imo = & new clsControl(ccsLabel, "imo", "imo", ccsText, "", CCGetRequestParam("imo", ccsGet, NULL), $this);
        $this->customer = & new clsControl(ccsLabel, "customer", "customer", ccsText, "", CCGetRequestParam("customer", ccsGet, NULL), $this);
        $this->EQUIP_TYPE = & new clsControl(ccsLabel, "EQUIP_TYPE", "EQUIP_TYPE", ccsText, "", CCGetRequestParam("EQUIP_TYPE", ccsGet, NULL), $this);
        $this->MANUF_NAME = & new clsControl(ccsLabel, "MANUF_NAME", "MANUF_NAME", ccsText, "", CCGetRequestParam("MANUF_NAME", ccsGet, NULL), $this);
        $this->EQUIP_MODEL = & new clsControl(ccsLabel, "EQUIP_MODEL", "EQUIP_MODEL", ccsText, "", CCGetRequestParam("EQUIP_MODEL", ccsGet, NULL), $this);
        $this->sn = & new clsControl(ccsLabel, "sn", "sn", ccsText, "", CCGetRequestParam("sn", ccsGet, NULL), $this);
        $this->emp_login = & new clsControl(ccsLabel, "emp_login", "emp_login", ccsText, "", CCGetRequestParam("emp_login", ccsGet, NULL), $this);
        $this->Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "page1_1.php";
        $this->Navigator = & new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
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

//Show Method @3-22B1C52B
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_date_received"] = CCGetFromGet("s_date_received", NULL);
        $this->DataSource->Parameters["urls_ship_name"] = CCGetFromGet("s_ship_name", NULL);
        $this->DataSource->Parameters["urls_imo"] = CCGetFromGet("s_imo", NULL);
        $this->DataSource->Parameters["urls_customer"] = CCGetFromGet("s_customer", NULL);
        $this->DataSource->Parameters["urls_EQUIP_TYPE"] = CCGetFromGet("s_EQUIP_TYPE", NULL);
        $this->DataSource->Parameters["urls_MANUF_NAME"] = CCGetFromGet("s_MANUF_NAME", NULL);
        $this->DataSource->Parameters["urls_EQUIP_MODEL"] = CCGetFromGet("s_EQUIP_MODEL", NULL);
        $this->DataSource->Parameters["urls_sn"] = CCGetFromGet("s_sn", NULL);
        $this->DataSource->Parameters["urls_emp_id"] = CCGetFromGet("s_emp_id", NULL);

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
            $this->ControlsVisible["date_received"] = $this->date_received->Visible;
            $this->ControlsVisible["ship_name"] = $this->ship_name->Visible;
            $this->ControlsVisible["imo"] = $this->imo->Visible;
            $this->ControlsVisible["customer"] = $this->customer->Visible;
            $this->ControlsVisible["EQUIP_TYPE"] = $this->EQUIP_TYPE->Visible;
            $this->ControlsVisible["MANUF_NAME"] = $this->MANUF_NAME->Visible;
            $this->ControlsVisible["EQUIP_MODEL"] = $this->EQUIP_MODEL->Visible;
            $this->ControlsVisible["sn"] = $this->sn->Visible;
            $this->ControlsVisible["emp_login"] = $this->emp_login->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->date_received->SetValue($this->DataSource->date_received->GetValue());
                $this->ship_name->SetValue($this->DataSource->ship_name->GetValue());
                $this->imo->SetValue($this->DataSource->imo->GetValue());
                $this->customer->SetValue($this->DataSource->customer->GetValue());
                $this->EQUIP_TYPE->SetValue($this->DataSource->EQUIP_TYPE->GetValue());
                $this->MANUF_NAME->SetValue($this->DataSource->MANUF_NAME->GetValue());
                $this->EQUIP_MODEL->SetValue($this->DataSource->EQUIP_MODEL->GetValue());
                $this->sn->SetValue($this->DataSource->sn->GetValue());
                $this->emp_login->SetValue($this->DataSource->emp_login->GetValue());
                $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "workshop_in_id", $this->DataSource->f("workshop_in_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->date_received->Show();
                $this->ship_name->Show();
                $this->imo->Show();
                $this->customer->Show();
                $this->EQUIP_TYPE->Show();
                $this->MANUF_NAME->Show();
                $this->EQUIP_MODEL->Show();
                $this->sn->Show();
                $this->emp_login->Show();
                $this->Link1->Show();
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

//GetErrors Method @3-044484E8
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->date_received->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ship_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->imo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->customer->Errors->ToString());
        $errors = ComposeStrings($errors, $this->EQUIP_TYPE->Errors->ToString());
        $errors = ComposeStrings($errors, $this->MANUF_NAME->Errors->ToString());
        $errors = ComposeStrings($errors, $this->EQUIP_MODEL->Errors->ToString());
        $errors = ComposeStrings($errors, $this->sn->Errors->ToString());
        $errors = ComposeStrings($errors, $this->emp_login->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End workshop_repair Class @3-FCB6E20C

class clsworkshop_repairDataSource extends clsDBhss_db {  //workshop_repairDataSource Class @3-ACAA58D1

//DataSource Variables @3-CEDD7A2A
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $CountSQL;
    var $wp;


    // Datasource fields
    var $date_received;
    var $ship_name;
    var $imo;
    var $customer;
    var $EQUIP_TYPE;
    var $MANUF_NAME;
    var $EQUIP_MODEL;
    var $sn;
    var $emp_login;
//End DataSource Variables

//DataSourceClass_Initialize Event @3-D98DB7E3
    function clsworkshop_repairDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid workshop_repair";
        $this->Initialize();
        $this->date_received = new clsField("date_received", ccsText, "");
        
        $this->ship_name = new clsField("ship_name", ccsText, "");
        
        $this->imo = new clsField("imo", ccsText, "");
        
        $this->customer = new clsField("customer", ccsText, "");
        
        $this->EQUIP_TYPE = new clsField("EQUIP_TYPE", ccsText, "");
        
        $this->MANUF_NAME = new clsField("MANUF_NAME", ccsText, "");
        
        $this->EQUIP_MODEL = new clsField("EQUIP_MODEL", ccsText, "");
        
        $this->sn = new clsField("sn", ccsText, "");
        
        $this->emp_login = new clsField("emp_login", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @3-533BC107
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "workshop_repair.workshop_in_id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @3-67197621
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_date_received", ccsText, "", "", $this->Parameters["urls_date_received"], "", false);
        $this->wp->AddParameter("2", "urls_ship_name", ccsText, "", "", $this->Parameters["urls_ship_name"], "", false);
        $this->wp->AddParameter("3", "urls_imo", ccsText, "", "", $this->Parameters["urls_imo"], "", false);
        $this->wp->AddParameter("4", "urls_customer", ccsText, "", "", $this->Parameters["urls_customer"], "", false);
        $this->wp->AddParameter("5", "urls_EQUIP_TYPE", ccsText, "", "", $this->Parameters["urls_EQUIP_TYPE"], "", false);
        $this->wp->AddParameter("6", "urls_MANUF_NAME", ccsText, "", "", $this->Parameters["urls_MANUF_NAME"], "", false);
        $this->wp->AddParameter("7", "urls_EQUIP_MODEL", ccsText, "", "", $this->Parameters["urls_EQUIP_MODEL"], "", false);
        $this->wp->AddParameter("8", "urls_sn", ccsText, "", "", $this->Parameters["urls_sn"], "", false);
        $this->wp->AddParameter("9", "urls_emp_id", ccsInteger, "", "", $this->Parameters["urls_emp_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "workshop_repair.date_received", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "workshop_repair.ship_name", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "workshop_repair.imo", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opContains, "workshop_repair.customer", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opContains, "workshop_repair.EQUIP_TYPE", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsText),false);
        $this->wp->Criterion[6] = $this->wp->Operation(opContains, "workshop_repair.MANUF_NAME", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsText),false);
        $this->wp->Criterion[7] = $this->wp->Operation(opContains, "workshop_repair.EQUIP_MODEL", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsText),false);
        $this->wp->Criterion[8] = $this->wp->Operation(opContains, "workshop_repair.sn", $this->wp->GetDBValue("8"), $this->ToSQL($this->wp->GetDBValue("8"), ccsText),false);
        $this->wp->Criterion[9] = $this->wp->Operation(opEqual, "workshop_repair.emp_id", $this->wp->GetDBValue("9"), $this->ToSQL($this->wp->GetDBValue("9"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]), 
             $this->wp->Criterion[4]), 
             $this->wp->Criterion[5]), 
             $this->wp->Criterion[6]), 
             $this->wp->Criterion[7]), 
             $this->wp->Criterion[8]), 
             $this->wp->Criterion[9]);
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

//SetValues Method @3-5973A1D8
    function SetValues()
    {
        $this->date_received->SetDBValue($this->f("date_received"));
        $this->ship_name->SetDBValue($this->f("ship_name"));
        $this->imo->SetDBValue($this->f("imo"));
        $this->customer->SetDBValue($this->f("customer"));
        $this->EQUIP_TYPE->SetDBValue($this->f("EQUIP_TYPE"));
        $this->MANUF_NAME->SetDBValue($this->f("MANUF_NAME"));
        $this->EQUIP_MODEL->SetDBValue($this->f("EQUIP_MODEL"));
        $this->sn->SetDBValue($this->f("sn"));
        $this->emp_login->SetDBValue($this->f("emp_login"));
    }
//End SetValues Method

} //End workshop_repairDataSource Class @3-FCB6E20C

class clsRecordworkshop_repairSearch { //workshop_repairSearch Class @4-09A9C8F3

//Variables @4-D6FF3E86

    // Public variables
    var $ComponentType = "Record";
    var $ComponentName;
    var $Parent;
    var $HTMLFormAction;
    var $PressedButton;
    var $Errors;
    var $ErrorBlock;
    var $FormSubmitted;
    var $FormEnctype;
    var $Visible;
    var $IsEmpty;

    var $CCSEvents = "";
    var $CCSEventResult;

    var $RelativePath = "";

    var $InsertAllowed = false;
    var $UpdateAllowed = false;
    var $DeleteAllowed = false;
    var $ReadAllowed   = false;
    var $EditMode      = false;
    var $ds;
    var $DataSource;
    var $ValidatingControls;
    var $Controls;
    var $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @4-2932D48F
    function clsRecordworkshop_repairSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record workshop_repairSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "workshop_repairSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = & new clsButton("Button_DoSearch", $Method, $this);
            $this->s_date_received = & new clsControl(ccsTextBox, "s_date_received", "s_date_received", ccsText, "", CCGetRequestParam("s_date_received", $Method, NULL), $this);
            $this->s_ship_name = & new clsControl(ccsTextBox, "s_ship_name", "s_ship_name", ccsText, "", CCGetRequestParam("s_ship_name", $Method, NULL), $this);
            $this->s_imo = & new clsControl(ccsTextBox, "s_imo", "s_imo", ccsText, "", CCGetRequestParam("s_imo", $Method, NULL), $this);
            $this->s_customer = & new clsControl(ccsTextBox, "s_customer", "s_customer", ccsText, "", CCGetRequestParam("s_customer", $Method, NULL), $this);
            $this->s_EQUIP_TYPE = & new clsControl(ccsTextBox, "s_EQUIP_TYPE", "s_EQUIP_TYPE", ccsText, "", CCGetRequestParam("s_EQUIP_TYPE", $Method, NULL), $this);
            $this->s_MANUF_NAME = & new clsControl(ccsTextBox, "s_MANUF_NAME", "s_MANUF_NAME", ccsText, "", CCGetRequestParam("s_MANUF_NAME", $Method, NULL), $this);
            $this->s_emp_id = & new clsControl(ccsListBox, "s_emp_id", "s_emp_id", ccsInteger, "", CCGetRequestParam("s_emp_id", $Method, NULL), $this);
            $this->s_emp_id->DSType = dsTable;
            $this->s_emp_id->DataSource = new clsDBhss_db();
            $this->s_emp_id->ds = & $this->s_emp_id->DataSource;
            $this->s_emp_id->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->s_emp_id->BoundColumn, $this->s_emp_id->TextColumn, $this->s_emp_id->DBFormat) = array("emp_id", "emp_login", "");
        }
    }
//End Class_Initialize Event

//Validate Method @4-66188A1A
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_date_received->Validate() && $Validation);
        $Validation = ($this->s_ship_name->Validate() && $Validation);
        $Validation = ($this->s_imo->Validate() && $Validation);
        $Validation = ($this->s_customer->Validate() && $Validation);
        $Validation = ($this->s_EQUIP_TYPE->Validate() && $Validation);
        $Validation = ($this->s_MANUF_NAME->Validate() && $Validation);
        $Validation = ($this->s_emp_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_date_received->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_ship_name->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_imo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_customer->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_EQUIP_TYPE->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_MANUF_NAME->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_emp_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @4-A39EE76B
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_date_received->Errors->Count());
        $errors = ($errors || $this->s_ship_name->Errors->Count());
        $errors = ($errors || $this->s_imo->Errors->Count());
        $errors = ($errors || $this->s_customer->Errors->Count());
        $errors = ($errors || $this->s_EQUIP_TYPE->Errors->Count());
        $errors = ($errors || $this->s_MANUF_NAME->Errors->Count());
        $errors = ($errors || $this->s_emp_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @4-ED598703
function SetPrimaryKeys($keyArray)
{
    $this->PrimaryKeys = $keyArray;
}
function GetPrimaryKeys()
{
    return $this->PrimaryKeys;
}
function GetPrimaryKey($keyName)
{
    return $this->PrimaryKeys[$keyName];
}
//End MasterDetail

//Operation Method @4-61B01389
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        if(!$this->FormSubmitted) {
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = "Button_DoSearch";
            if($this->Button_DoSearch->Pressed) {
                $this->PressedButton = "Button_DoSearch";
            }
        }
        $Redirect = "page1.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "page1.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @4-31D0A280
    function Show()
    {
        global $CCSUseAmp;
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->s_emp_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_date_received->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_ship_name->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_imo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_customer->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_EQUIP_TYPE->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_MANUF_NAME->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_emp_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_DoSearch->Show();
        $this->s_date_received->Show();
        $this->s_ship_name->Show();
        $this->s_imo->Show();
        $this->s_customer->Show();
        $this->s_EQUIP_TYPE->Show();
        $this->s_MANUF_NAME->Show();
        $this->s_emp_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End workshop_repairSearch Class @4-FCB6E20C





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

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-BE961318
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Link2 = & new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $MainPage);
$Link2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link2->Page = "page2.php";
$workshop_repair = & new clsGridworkshop_repair("", $MainPage);
$workshop_repairSearch = & new clsRecordworkshop_repairSearch("", $MainPage);
$Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $MainPage);
$Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link1->Page = "http://extranet.thrane.com/Support/Warranty%20Checker.aspx";
$MainPage->Link2 = & $Link2;
$MainPage->workshop_repair = & $workshop_repair;
$MainPage->workshop_repairSearch = & $workshop_repairSearch;
$MainPage->Link1 = & $Link1;
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

//Execute Components @1-E7587AAD
$workshop_repairSearch->Operation();
//End Execute Components

//Go to destination page @1-791B1464
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($workshop_repair);
    unset($workshop_repairSearch);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-80868BCB
$workshop_repair->Show();
$workshop_repairSearch->Show();
$Link2->Show();
$Link1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-B6DC77B0
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($workshop_repair);
unset($workshop_repairSearch);
unset($Tpl);
//End Unload Page


?>
