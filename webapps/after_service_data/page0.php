<?php
//Include Common Files @1-EEBBB20E
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page0.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files



class clsRecordafter_service_tbl_employe { //after_service_tbl_employe Class @17-A040CC65

//Variables @17-D6FF3E86

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

//Class_Initialize Event @17-CEFDECEA
    function clsRecordafter_service_tbl_employe($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record after_service_tbl_employe/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "after_service_tbl_employe";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = & new clsButton("Button_DoSearch", $Method, $this);
            $this->s_ORDER_NO = & new clsControl(ccsTextBox, "s_ORDER_NO", "s_ORDER_NO", ccsText, "", CCGetRequestParam("s_ORDER_NO", $Method, NULL), $this);
            $this->s_PORT_ID = & new clsControl(ccsListBox, "s_PORT_ID", "s_PORT_ID", ccsInteger, "", CCGetRequestParam("s_PORT_ID", $Method, NULL), $this);
            $this->s_PORT_ID->DSType = dsTable;
            $this->s_PORT_ID->DataSource = new clsDBhss_db();
            $this->s_PORT_ID->ds = & $this->s_PORT_ID->DataSource;
            $this->s_PORT_ID->DataSource->SQL = "SELECT * \n" .
"FROM ports_tbl {SQL_Where} {SQL_OrderBy}";
            $this->s_PORT_ID->DataSource->Order = "PORT_NAME";
            list($this->s_PORT_ID->BoundColumn, $this->s_PORT_ID->TextColumn, $this->s_PORT_ID->DBFormat) = array("PORT_ID", "PORT_NAME", "");
            $this->s_PORT_ID->DataSource->Order = "PORT_NAME";
            $this->s_service_date_day = & new clsControl(ccsListBox, "s_service_date_day", "s_service_date_day", ccsText, "", CCGetRequestParam("s_service_date_day", $Method, NULL), $this);
            $this->s_service_date_day->DSType = dsTable;
            $this->s_service_date_day->DataSource = new clsDBhss_db();
            $this->s_service_date_day->ds = & $this->s_service_date_day->DataSource;
            $this->s_service_date_day->DataSource->SQL = "SELECT * \n" .
"FROM days_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->s_service_date_day->BoundColumn, $this->s_service_date_day->TextColumn, $this->s_service_date_day->DBFormat) = array("days", "days", "");
            $this->s_service_date_month = & new clsControl(ccsListBox, "s_service_date_month", "s_service_date_month", ccsText, "", CCGetRequestParam("s_service_date_month", $Method, NULL), $this);
            $this->s_service_date_month->DSType = dsTable;
            $this->s_service_date_month->DataSource = new clsDBhss_db();
            $this->s_service_date_month->ds = & $this->s_service_date_month->DataSource;
            $this->s_service_date_month->DataSource->SQL = "SELECT * \n" .
"FROM months_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->s_service_date_month->BoundColumn, $this->s_service_date_month->TextColumn, $this->s_service_date_month->DBFormat) = array("months", "months", "");
            $this->s_service_date_year = & new clsControl(ccsTextBox, "s_service_date_year", "s_service_date_year", ccsText, "", CCGetRequestParam("s_service_date_year", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @17-3BC9655B
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_ORDER_NO->Validate() && $Validation);
        $Validation = ($this->s_PORT_ID->Validate() && $Validation);
        $Validation = ($this->s_service_date_day->Validate() && $Validation);
        $Validation = ($this->s_service_date_month->Validate() && $Validation);
        $Validation = ($this->s_service_date_year->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_ORDER_NO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_PORT_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_service_date_day->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_service_date_month->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_service_date_year->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @17-A104DD09
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_ORDER_NO->Errors->Count());
        $errors = ($errors || $this->s_PORT_ID->Errors->Count());
        $errors = ($errors || $this->s_service_date_day->Errors->Count());
        $errors = ($errors || $this->s_service_date_month->Errors->Count());
        $errors = ($errors || $this->s_service_date_year->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @17-ED598703
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

//Operation Method @17-7765A60C
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
        $Redirect = "page0.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "page0.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @17-451B662A
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

        $this->s_PORT_ID->Prepare();
        $this->s_service_date_day->Prepare();
        $this->s_service_date_month->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_ORDER_NO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_PORT_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_service_date_day->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_service_date_month->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_service_date_year->Errors->ToString());
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
        $this->s_ORDER_NO->Show();
        $this->s_PORT_ID->Show();
        $this->s_service_date_day->Show();
        $this->s_service_date_month->Show();
        $this->s_service_date_year->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End after_service_tbl_employe Class @17-FCB6E20C

class clsGridafter_service_tbl_employe1 { //after_service_tbl_employe1 class @25-AFDA8D49

//Variables @25-AC1EDBB9

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

//Class_Initialize Event @25-E8A3BCCA
    function clsGridafter_service_tbl_employe1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "after_service_tbl_employe1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid after_service_tbl_employe1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsafter_service_tbl_employe1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
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
        $this->PORT_NAME = & new clsControl(ccsLabel, "PORT_NAME", "PORT_NAME", ccsText, "", CCGetRequestParam("PORT_NAME", ccsGet, NULL), $this);
        $this->TRANSPORT_FEE_DESCRIPTION = & new clsControl(ccsLabel, "TRANSPORT_FEE_DESCRIPTION", "TRANSPORT_FEE_DESCRIPTION", ccsText, "", CCGetRequestParam("TRANSPORT_FEE_DESCRIPTION", ccsGet, NULL), $this);
        $this->FOLLOW_UP = & new clsControl(ccsLabel, "FOLLOW_UP", "FOLLOW_UP", ccsText, "", CCGetRequestParam("FOLLOW_UP", ccsGet, NULL), $this);
        $this->NT_INV_WO = & new clsControl(ccsLabel, "NT_INV_WO", "NT_INV_WO", ccsText, "", CCGetRequestParam("NT_INV_WO", ccsGet, NULL), $this);
        $this->OT_INV_WO = & new clsControl(ccsLabel, "OT_INV_WO", "OT_INV_WO", ccsText, "", CCGetRequestParam("OT_INV_WO", ccsGet, NULL), $this);
        $this->OT_TEC_WO = & new clsControl(ccsLabel, "OT_TEC_WO", "OT_TEC_WO", ccsText, "", CCGetRequestParam("OT_TEC_WO", ccsGet, NULL), $this);
        $this->ND_WO = & new clsControl(ccsLabel, "ND_WO", "ND_WO", ccsText, "", CCGetRequestParam("ND_WO", ccsGet, NULL), $this);
        $this->WE_WO = & new clsControl(ccsLabel, "WE_WO", "WE_WO", ccsText, "", CCGetRequestParam("WE_WO", ccsGet, NULL), $this);
        $this->service_date_month = & new clsControl(ccsLabel, "service_date_month", "service_date_month", ccsText, "", CCGetRequestParam("service_date_month", ccsGet, NULL), $this);
        $this->service_date_year = & new clsControl(ccsLabel, "service_date_year", "service_date_year", ccsText, "", CCGetRequestParam("service_date_year", ccsGet, NULL), $this);
        $this->NT_INV_WA = & new clsControl(ccsLabel, "NT_INV_WA", "NT_INV_WA", ccsText, "", CCGetRequestParam("NT_INV_WA", ccsGet, NULL), $this);
        $this->NT_INV_TR = & new clsControl(ccsLabel, "NT_INV_TR", "NT_INV_TR", ccsText, "", CCGetRequestParam("NT_INV_TR", ccsGet, NULL), $this);
        $this->NT_TEC_WO = & new clsControl(ccsLabel, "NT_TEC_WO", "NT_TEC_WO", ccsText, "", CCGetRequestParam("NT_TEC_WO", ccsGet, NULL), $this);
        $this->NT_TEC_WA = & new clsControl(ccsLabel, "NT_TEC_WA", "NT_TEC_WA", ccsText, "", CCGetRequestParam("NT_TEC_WA", ccsGet, NULL), $this);
        $this->NT_TEC_TR = & new clsControl(ccsLabel, "NT_TEC_TR", "NT_TEC_TR", ccsText, "", CCGetRequestParam("NT_TEC_TR", ccsGet, NULL), $this);
        $this->OT_INV_WA = & new clsControl(ccsLabel, "OT_INV_WA", "OT_INV_WA", ccsText, "", CCGetRequestParam("OT_INV_WA", ccsGet, NULL), $this);
        $this->OT_INV_TR = & new clsControl(ccsLabel, "OT_INV_TR", "OT_INV_TR", ccsText, "", CCGetRequestParam("OT_INV_TR", ccsGet, NULL), $this);
        $this->OT_TEC_WA = & new clsControl(ccsLabel, "OT_TEC_WA", "OT_TEC_WA", ccsText, "", CCGetRequestParam("OT_TEC_WA", ccsGet, NULL), $this);
        $this->OT_TEC_TR = & new clsControl(ccsLabel, "OT_TEC_TR", "OT_TEC_TR", ccsText, "", CCGetRequestParam("OT_TEC_TR", ccsGet, NULL), $this);
        $this->ND_WA = & new clsControl(ccsLabel, "ND_WA", "ND_WA", ccsText, "", CCGetRequestParam("ND_WA", ccsGet, NULL), $this);
        $this->ND_TR = & new clsControl(ccsLabel, "ND_TR", "ND_TR", ccsText, "", CCGetRequestParam("ND_TR", ccsGet, NULL), $this);
        $this->WE_WA = & new clsControl(ccsLabel, "WE_WA", "WE_WA", ccsText, "", CCGetRequestParam("WE_WA", ccsGet, NULL), $this);
        $this->WE_TR = & new clsControl(ccsLabel, "WE_TR", "WE_TR", ccsText, "", CCGetRequestParam("WE_TR", ccsGet, NULL), $this);
        $this->Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "page1.php";
        $this->AGENT_EVAL_TECH = & new clsControl(ccsLabel, "AGENT_EVAL_TECH", "AGENT_EVAL_TECH", ccsText, "", CCGetRequestParam("AGENT_EVAL_TECH", ccsGet, NULL), $this);
        $this->TIME_OFF = & new clsControl(ccsLabel, "TIME_OFF", "TIME_OFF", ccsText, "", CCGetRequestParam("TIME_OFF", ccsGet, NULL), $this);
        $this->SICKNESS_TIME_OFF = & new clsControl(ccsLabel, "SICKNESS_TIME_OFF", "SICKNESS_TIME_OFF", ccsText, "", CCGetRequestParam("SICKNESS_TIME_OFF", ccsGet, NULL), $this);
        $this->Navigator = & new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->emp_name = & new clsControl(ccsLabel, "emp_name", "emp_name", ccsText, "", CCGetRequestParam("emp_name", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @25-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @25-E6DA3157
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_ORDER_NO"] = CCGetFromGet("s_ORDER_NO", NULL);
        $this->DataSource->Parameters["sesUserID"] = CCGetSession("UserID", NULL);
        $this->DataSource->Parameters["urls_PORT_ID"] = CCGetFromGet("s_PORT_ID", NULL);
        $this->DataSource->Parameters["urls_service_date_day"] = CCGetFromGet("s_service_date_day", NULL);
        $this->DataSource->Parameters["urls_service_date_month"] = CCGetFromGet("s_service_date_month", NULL);
        $this->DataSource->Parameters["urls_service_date_year"] = CCGetFromGet("s_service_date_year", NULL);

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
            $this->ControlsVisible["PORT_NAME"] = $this->PORT_NAME->Visible;
            $this->ControlsVisible["TRANSPORT_FEE_DESCRIPTION"] = $this->TRANSPORT_FEE_DESCRIPTION->Visible;
            $this->ControlsVisible["FOLLOW_UP"] = $this->FOLLOW_UP->Visible;
            $this->ControlsVisible["NT_INV_WO"] = $this->NT_INV_WO->Visible;
            $this->ControlsVisible["OT_INV_WO"] = $this->OT_INV_WO->Visible;
            $this->ControlsVisible["OT_TEC_WO"] = $this->OT_TEC_WO->Visible;
            $this->ControlsVisible["ND_WO"] = $this->ND_WO->Visible;
            $this->ControlsVisible["WE_WO"] = $this->WE_WO->Visible;
            $this->ControlsVisible["service_date_month"] = $this->service_date_month->Visible;
            $this->ControlsVisible["service_date_year"] = $this->service_date_year->Visible;
            $this->ControlsVisible["NT_INV_WA"] = $this->NT_INV_WA->Visible;
            $this->ControlsVisible["NT_INV_TR"] = $this->NT_INV_TR->Visible;
            $this->ControlsVisible["NT_TEC_WO"] = $this->NT_TEC_WO->Visible;
            $this->ControlsVisible["NT_TEC_WA"] = $this->NT_TEC_WA->Visible;
            $this->ControlsVisible["NT_TEC_TR"] = $this->NT_TEC_TR->Visible;
            $this->ControlsVisible["OT_INV_WA"] = $this->OT_INV_WA->Visible;
            $this->ControlsVisible["OT_INV_TR"] = $this->OT_INV_TR->Visible;
            $this->ControlsVisible["OT_TEC_WA"] = $this->OT_TEC_WA->Visible;
            $this->ControlsVisible["OT_TEC_TR"] = $this->OT_TEC_TR->Visible;
            $this->ControlsVisible["ND_WA"] = $this->ND_WA->Visible;
            $this->ControlsVisible["ND_TR"] = $this->ND_TR->Visible;
            $this->ControlsVisible["WE_WA"] = $this->WE_WA->Visible;
            $this->ControlsVisible["WE_TR"] = $this->WE_TR->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            $this->ControlsVisible["AGENT_EVAL_TECH"] = $this->AGENT_EVAL_TECH->Visible;
            $this->ControlsVisible["TIME_OFF"] = $this->TIME_OFF->Visible;
            $this->ControlsVisible["SICKNESS_TIME_OFF"] = $this->SICKNESS_TIME_OFF->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->ORDER_NO->SetValue($this->DataSource->ORDER_NO->GetValue());
                $this->service_date_day->SetValue($this->DataSource->service_date_day->GetValue());
                $this->PORT_NAME->SetValue($this->DataSource->PORT_NAME->GetValue());
                $this->TRANSPORT_FEE_DESCRIPTION->SetValue($this->DataSource->TRANSPORT_FEE_DESCRIPTION->GetValue());
                $this->FOLLOW_UP->SetValue($this->DataSource->FOLLOW_UP->GetValue());
                $this->NT_INV_WO->SetValue($this->DataSource->NT_INV_WO->GetValue());
                $this->OT_INV_WO->SetValue($this->DataSource->OT_INV_WO->GetValue());
                $this->OT_TEC_WO->SetValue($this->DataSource->OT_TEC_WO->GetValue());
                $this->ND_WO->SetValue($this->DataSource->ND_WO->GetValue());
                $this->WE_WO->SetValue($this->DataSource->WE_WO->GetValue());
                $this->service_date_month->SetValue($this->DataSource->service_date_month->GetValue());
                $this->service_date_year->SetValue($this->DataSource->service_date_year->GetValue());
                $this->NT_INV_WA->SetValue($this->DataSource->NT_INV_WA->GetValue());
                $this->NT_INV_TR->SetValue($this->DataSource->NT_INV_TR->GetValue());
                $this->NT_TEC_WO->SetValue($this->DataSource->NT_TEC_WO->GetValue());
                $this->NT_TEC_WA->SetValue($this->DataSource->NT_TEC_WA->GetValue());
                $this->NT_TEC_TR->SetValue($this->DataSource->NT_TEC_TR->GetValue());
                $this->OT_INV_WA->SetValue($this->DataSource->OT_INV_WA->GetValue());
                $this->OT_INV_TR->SetValue($this->DataSource->OT_INV_TR->GetValue());
                $this->OT_TEC_WA->SetValue($this->DataSource->OT_TEC_WA->GetValue());
                $this->OT_TEC_TR->SetValue($this->DataSource->OT_TEC_TR->GetValue());
                $this->ND_WA->SetValue($this->DataSource->ND_WA->GetValue());
                $this->ND_TR->SetValue($this->DataSource->ND_TR->GetValue());
                $this->WE_WA->SetValue($this->DataSource->WE_WA->GetValue());
                $this->WE_TR->SetValue($this->DataSource->WE_TR->GetValue());
                $this->Link1->Parameters = "";
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "record_id", $this->DataSource->f("record_id"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "ORDER_NO", $this->DataSource->f("ORDER_NO"));
                $this->AGENT_EVAL_TECH->SetValue($this->DataSource->AGENT_EVAL_TECH->GetValue());
                $this->TIME_OFF->SetValue($this->DataSource->TIME_OFF->GetValue());
                $this->SICKNESS_TIME_OFF->SetValue($this->DataSource->SICKNESS_TIME_OFF->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->ORDER_NO->Show();
                $this->service_date_day->Show();
                $this->PORT_NAME->Show();
                $this->TRANSPORT_FEE_DESCRIPTION->Show();
                $this->FOLLOW_UP->Show();
                $this->NT_INV_WO->Show();
                $this->OT_INV_WO->Show();
                $this->OT_TEC_WO->Show();
                $this->ND_WO->Show();
                $this->WE_WO->Show();
                $this->service_date_month->Show();
                $this->service_date_year->Show();
                $this->NT_INV_WA->Show();
                $this->NT_INV_TR->Show();
                $this->NT_TEC_WO->Show();
                $this->NT_TEC_WA->Show();
                $this->NT_TEC_TR->Show();
                $this->OT_INV_WA->Show();
                $this->OT_INV_TR->Show();
                $this->OT_TEC_WA->Show();
                $this->OT_TEC_TR->Show();
                $this->ND_WA->Show();
                $this->ND_TR->Show();
                $this->WE_WA->Show();
                $this->WE_TR->Show();
                $this->Link1->Show();
                $this->AGENT_EVAL_TECH->Show();
                $this->TIME_OFF->Show();
                $this->SICKNESS_TIME_OFF->Show();
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
        $this->Navigator->Show();
        $this->emp_name->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @25-BE882DC5
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->ORDER_NO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->service_date_day->Errors->ToString());
        $errors = ComposeStrings($errors, $this->PORT_NAME->Errors->ToString());
        $errors = ComposeStrings($errors, $this->TRANSPORT_FEE_DESCRIPTION->Errors->ToString());
        $errors = ComposeStrings($errors, $this->FOLLOW_UP->Errors->ToString());
        $errors = ComposeStrings($errors, $this->NT_INV_WO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->OT_INV_WO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->OT_TEC_WO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ND_WO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->WE_WO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->service_date_month->Errors->ToString());
        $errors = ComposeStrings($errors, $this->service_date_year->Errors->ToString());
        $errors = ComposeStrings($errors, $this->NT_INV_WA->Errors->ToString());
        $errors = ComposeStrings($errors, $this->NT_INV_TR->Errors->ToString());
        $errors = ComposeStrings($errors, $this->NT_TEC_WO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->NT_TEC_WA->Errors->ToString());
        $errors = ComposeStrings($errors, $this->NT_TEC_TR->Errors->ToString());
        $errors = ComposeStrings($errors, $this->OT_INV_WA->Errors->ToString());
        $errors = ComposeStrings($errors, $this->OT_INV_TR->Errors->ToString());
        $errors = ComposeStrings($errors, $this->OT_TEC_WA->Errors->ToString());
        $errors = ComposeStrings($errors, $this->OT_TEC_TR->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ND_WA->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ND_TR->Errors->ToString());
        $errors = ComposeStrings($errors, $this->WE_WA->Errors->ToString());
        $errors = ComposeStrings($errors, $this->WE_TR->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->AGENT_EVAL_TECH->Errors->ToString());
        $errors = ComposeStrings($errors, $this->TIME_OFF->Errors->ToString());
        $errors = ComposeStrings($errors, $this->SICKNESS_TIME_OFF->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End after_service_tbl_employe1 Class @25-FCB6E20C

class clsafter_service_tbl_employe1DataSource extends clsDBhss_db {  //after_service_tbl_employe1DataSource Class @25-B688D45C

//DataSource Variables @25-5C47D78C
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
    var $PORT_NAME;
    var $TRANSPORT_FEE_DESCRIPTION;
    var $FOLLOW_UP;
    var $NT_INV_WO;
    var $OT_INV_WO;
    var $OT_TEC_WO;
    var $ND_WO;
    var $WE_WO;
    var $service_date_month;
    var $service_date_year;
    var $NT_INV_WA;
    var $NT_INV_TR;
    var $NT_TEC_WO;
    var $NT_TEC_WA;
    var $NT_TEC_TR;
    var $OT_INV_WA;
    var $OT_INV_TR;
    var $OT_TEC_WA;
    var $OT_TEC_TR;
    var $ND_WA;
    var $ND_TR;
    var $WE_WA;
    var $WE_TR;
    var $emp_name;
    var $AGENT_EVAL_TECH;
    var $TIME_OFF;
    var $SICKNESS_TIME_OFF;
//End DataSource Variables

//DataSourceClass_Initialize Event @25-DB705D09
    function clsafter_service_tbl_employe1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid after_service_tbl_employe1";
        $this->Initialize();
        $this->ORDER_NO = new clsField("ORDER_NO", ccsText, "");
        
        $this->service_date_day = new clsField("service_date_day", ccsText, "");
        
        $this->PORT_NAME = new clsField("PORT_NAME", ccsText, "");
        
        $this->TRANSPORT_FEE_DESCRIPTION = new clsField("TRANSPORT_FEE_DESCRIPTION", ccsText, "");
        
        $this->FOLLOW_UP = new clsField("FOLLOW_UP", ccsText, "");
        
        $this->NT_INV_WO = new clsField("NT_INV_WO", ccsText, "");
        
        $this->OT_INV_WO = new clsField("OT_INV_WO", ccsText, "");
        
        $this->OT_TEC_WO = new clsField("OT_TEC_WO", ccsText, "");
        
        $this->ND_WO = new clsField("ND_WO", ccsText, "");
        
        $this->WE_WO = new clsField("WE_WO", ccsText, "");
        
        $this->service_date_month = new clsField("service_date_month", ccsText, "");
        
        $this->service_date_year = new clsField("service_date_year", ccsText, "");
        
        $this->NT_INV_WA = new clsField("NT_INV_WA", ccsText, "");
        
        $this->NT_INV_TR = new clsField("NT_INV_TR", ccsText, "");
        
        $this->NT_TEC_WO = new clsField("NT_TEC_WO", ccsText, "");
        
        $this->NT_TEC_WA = new clsField("NT_TEC_WA", ccsText, "");
        
        $this->NT_TEC_TR = new clsField("NT_TEC_TR", ccsText, "");
        
        $this->OT_INV_WA = new clsField("OT_INV_WA", ccsText, "");
        
        $this->OT_INV_TR = new clsField("OT_INV_TR", ccsText, "");
        
        $this->OT_TEC_WA = new clsField("OT_TEC_WA", ccsText, "");
        
        $this->OT_TEC_TR = new clsField("OT_TEC_TR", ccsText, "");
        
        $this->ND_WA = new clsField("ND_WA", ccsText, "");
        
        $this->ND_TR = new clsField("ND_TR", ccsText, "");
        
        $this->WE_WA = new clsField("WE_WA", ccsText, "");
        
        $this->WE_TR = new clsField("WE_TR", ccsText, "");
        
        $this->emp_name = new clsField("emp_name", ccsText, "");
        
        $this->AGENT_EVAL_TECH = new clsField("AGENT_EVAL_TECH", ccsText, "");
        
        $this->TIME_OFF = new clsField("TIME_OFF", ccsText, "");
        
        $this->SICKNESS_TIME_OFF = new clsField("SICKNESS_TIME_OFF", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @25-F90D8966
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "service_date_year desc, service_date_month desc, service_date_day desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @25-F4E9509D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_ORDER_NO", ccsText, "", "", $this->Parameters["urls_ORDER_NO"], "", false);
        $this->wp->AddParameter("2", "sesUserID", ccsInteger, "", "", $this->Parameters["sesUserID"], "", false);
        $this->wp->AddParameter("3", "urls_PORT_ID", ccsInteger, "", "", $this->Parameters["urls_PORT_ID"], "", false);
        $this->wp->AddParameter("4", "urls_service_date_day", ccsText, "", "", $this->Parameters["urls_service_date_day"], "", false);
        $this->wp->AddParameter("5", "urls_service_date_month", ccsText, "", "", $this->Parameters["urls_service_date_month"], "", false);
        $this->wp->AddParameter("6", "urls_service_date_year", ccsText, "", "", $this->Parameters["urls_service_date_year"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "after_service_tbl.ORDER_NO", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "after_service_tbl.emp_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "after_service_tbl.PORT_ID", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opContains, "after_service_tbl.service_date_day", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opContains, "after_service_tbl.service_date_month", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsText),false);
        $this->wp->Criterion[6] = $this->wp->Operation(opContains, "after_service_tbl.service_date_year", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsText),false);
        $this->Where = $this->wp->opAND(
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
             $this->wp->Criterion[6]);
    }
//End Prepare Method

//Open Method @25-4EBA932A
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((after_service_tbl INNER JOIN employees_tbl ON\n\n" .
        "after_service_tbl.emp_id = employees_tbl.emp_id) INNER JOIN ports_tbl ON\n\n" .
        "after_service_tbl.PORT_ID = ports_tbl.PORT_ID) INNER JOIN port_fees_tbl ON\n\n" .
        "after_service_tbl.PORT_FEE_ID = port_fees_tbl.PORT_FEE_ID) INNER JOIN transport_fees_tbl ON\n\n" .
        "after_service_tbl.TRANSPORT_FEE_ID = transport_fees_tbl.TRANSPORT_FEE_ID";
        $this->SQL = "SELECT after_service_tbl.*, emp_login, PORT_NAME, PORT_FEE_VALUE, TRANSPORT_FEE_DESCRIPTION, emp_name \n\n" .
        "FROM (((after_service_tbl INNER JOIN employees_tbl ON\n\n" .
        "after_service_tbl.emp_id = employees_tbl.emp_id) INNER JOIN ports_tbl ON\n\n" .
        "after_service_tbl.PORT_ID = ports_tbl.PORT_ID) INNER JOIN port_fees_tbl ON\n\n" .
        "after_service_tbl.PORT_FEE_ID = port_fees_tbl.PORT_FEE_ID) INNER JOIN transport_fees_tbl ON\n\n" .
        "after_service_tbl.TRANSPORT_FEE_ID = transport_fees_tbl.TRANSPORT_FEE_ID {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @25-74D2E921
    function SetValues()
    {
        $this->ORDER_NO->SetDBValue($this->f("ORDER_NO"));
        $this->service_date_day->SetDBValue($this->f("service_date_day"));
        $this->PORT_NAME->SetDBValue($this->f("PORT_NAME"));
        $this->TRANSPORT_FEE_DESCRIPTION->SetDBValue($this->f("TRANSPORT_FEE_DESCRIPTION"));
        $this->FOLLOW_UP->SetDBValue($this->f("FOLLOW_UP"));
        $this->NT_INV_WO->SetDBValue($this->f("NT_INV_WO"));
        $this->OT_INV_WO->SetDBValue($this->f("OT_INV_WO"));
        $this->OT_TEC_WO->SetDBValue($this->f("OT_TEC_WO"));
        $this->ND_WO->SetDBValue($this->f("ND_WO"));
        $this->WE_WO->SetDBValue($this->f("WE_WO"));
        $this->service_date_month->SetDBValue($this->f("service_date_month"));
        $this->service_date_year->SetDBValue($this->f("service_date_year"));
        $this->NT_INV_WA->SetDBValue($this->f("NT_INV_WA"));
        $this->NT_INV_TR->SetDBValue($this->f("NT_INV_TR"));
        $this->NT_TEC_WO->SetDBValue($this->f("NT_TEC_WO"));
        $this->NT_TEC_WA->SetDBValue($this->f("NT_TEC_WA"));
        $this->NT_TEC_TR->SetDBValue($this->f("NT_TEC_TR"));
        $this->OT_INV_WA->SetDBValue($this->f("OT_INV_WA"));
        $this->OT_INV_TR->SetDBValue($this->f("OT_INV_TR"));
        $this->OT_TEC_WA->SetDBValue($this->f("OT_TEC_WA"));
        $this->OT_TEC_TR->SetDBValue($this->f("OT_TEC_TR"));
        $this->ND_WA->SetDBValue($this->f("ND_WA"));
        $this->ND_TR->SetDBValue($this->f("ND_TR"));
        $this->WE_WA->SetDBValue($this->f("WE_WA"));
        $this->WE_TR->SetDBValue($this->f("WE_TR"));
        $this->emp_name->SetDBValue($this->f("emp_name"));
        $this->AGENT_EVAL_TECH->SetDBValue($this->f("AGENT_EVAL_TECH"));
        $this->TIME_OFF->SetDBValue($this->f("TIME_OFF"));
        $this->SICKNESS_TIME_OFF->SetDBValue($this->f("SICKNESS_TIME_OFF"));
    }
//End SetValues Method

} //End after_service_tbl_employe1DataSource Class @25-FCB6E20C



//Initialize Page @1-6822D5B6
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
$TemplateFileName = "page0.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-F06F9F88
CCSecurityRedirect("1;2;3;4", "login.php");
//End Authenticate User

//Include events file @1-DA4E8D55
include_once("./page0_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-399DF9A1
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$after_service_tbl_employe = & new clsRecordafter_service_tbl_employe("", $MainPage);
$after_service_tbl_employe1 = & new clsGridafter_service_tbl_employe1("", $MainPage);
$Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $MainPage);
$Link1->Page = "page1.php";
$Link2 = & new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $MainPage);
$Link2->Page = "page2.php";
$Link3 = & new clsControl(ccsLink, "Link3", "Link3", ccsText, "", CCGetRequestParam("Link3", ccsGet, NULL), $MainPage);
$Link3->Page = "page3.php";
$Link4 = & new clsControl(ccsLink, "Link4", "Link4", ccsText, "", CCGetRequestParam("Link4", ccsGet, NULL), $MainPage);
$Link4->Page = "";
$Link5 = & new clsControl(ccsLink, "Link5", "Link5", ccsText, "", CCGetRequestParam("Link5", ccsGet, NULL), $MainPage);
$Link5->Page = "monitor.php";
$Logout = & new clsControl(ccsLink, "Logout", "Logout", ccsText, "", CCGetRequestParam("Logout", ccsGet, NULL), $MainPage);
$Logout->Page = "login.php";
$MainPage->after_service_tbl_employe = & $after_service_tbl_employe;
$MainPage->after_service_tbl_employe1 = & $after_service_tbl_employe1;
$MainPage->Link1 = & $Link1;
$MainPage->Link2 = & $Link2;
$MainPage->Link3 = & $Link3;
$MainPage->Link4 = & $Link4;
$MainPage->Link5 = & $Link5;
$MainPage->Logout = & $Logout;
$Logout->Parameters = "";
$Logout->Parameters = CCAddParam($Logout->Parameters, "Logout", "True");
$after_service_tbl_employe1->Initialize();

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

//Execute Components @1-B3501B90
$after_service_tbl_employe->Operation();
//End Execute Components

//Go to destination page @1-3DA157DE
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($after_service_tbl_employe);
    unset($after_service_tbl_employe1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-111FFD91
$after_service_tbl_employe->Show();
$after_service_tbl_employe1->Show();
$Link1->Show();
$Link2->Show();
$Link3->Show();
$Link4->Show();
$Link5->Show();
$Logout->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-9756F704
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($after_service_tbl_employe);
unset($after_service_tbl_employe1);
unset($Tpl);
//End Unload Page


?>
