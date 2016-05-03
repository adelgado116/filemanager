<?php
//Include Common Files @1-573A333F
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page9.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordafter_service_tbl { //after_service_tbl Class @2-5925C991

//Variables @2-9E315808

    // Public variables
    public $ComponentType = "Record";
    public $ComponentName;
    public $Parent;
    public $HTMLFormAction;
    public $PressedButton;
    public $Errors;
    public $ErrorBlock;
    public $FormSubmitted;
    public $FormEnctype;
    public $Visible;
    public $IsEmpty;

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";

    public $InsertAllowed = false;
    public $UpdateAllowed = false;
    public $DeleteAllowed = false;
    public $ReadAllowed   = false;
    public $EditMode      = false;
    public $ds;
    public $DataSource;
    public $ValidatingControls;
    public $Controls;
    public $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @2-E9DA8149
    function clsRecordafter_service_tbl($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record after_service_tbl/Error";
        $this->DataSource = new clsafter_service_tblDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "after_service_tbl";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->record_id = new clsControl(ccsHidden, "record_id", "Record Id", ccsInteger, "", CCGetRequestParam("record_id", $Method, NULL), $this);
            $this->ORDER_NO = new clsControl(ccsTextBox, "ORDER_NO", "ORDER NO", ccsText, "", CCGetRequestParam("ORDER_NO", $Method, NULL), $this);
            $this->ORDER_NO->Required = true;
            $this->emp_id = new clsControl(ccsListBox, "emp_id", "Emp Id", ccsInteger, "", CCGetRequestParam("emp_id", $Method, NULL), $this);
            $this->emp_id->DSType = dsTable;
            $this->emp_id->DataSource = new clsDBhss_db();
            $this->emp_id->ds = & $this->emp_id->DataSource;
            $this->emp_id->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            $this->emp_id->DataSource->Order = "emp_login";
            list($this->emp_id->BoundColumn, $this->emp_id->TextColumn, $this->emp_id->DBFormat) = array("emp_id", "emp_login", "");
            $this->emp_id->DataSource->Order = "emp_login";
            $this->emp_id->Required = true;
            $this->service_date_day = new clsControl(ccsListBox, "service_date_day", "Service Date Day", ccsText, "", CCGetRequestParam("service_date_day", $Method, NULL), $this);
            $this->service_date_day->DSType = dsTable;
            $this->service_date_day->DataSource = new clsDBhss_db();
            $this->service_date_day->ds = & $this->service_date_day->DataSource;
            $this->service_date_day->DataSource->SQL = "SELECT * \n" .
"FROM days_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->service_date_day->BoundColumn, $this->service_date_day->TextColumn, $this->service_date_day->DBFormat) = array("days", "days", "");
            $this->service_date_day->Required = true;
            $this->FOLLOW_UP = new clsControl(ccsListBox, "FOLLOW_UP", "FOLLOW UP", ccsText, "", CCGetRequestParam("FOLLOW_UP", $Method, NULL), $this);
            $this->FOLLOW_UP->DSType = dsTable;
            $this->FOLLOW_UP->DataSource = new clsDBhss_db();
            $this->FOLLOW_UP->ds = & $this->FOLLOW_UP->DataSource;
            $this->FOLLOW_UP->DataSource->SQL = "SELECT * \n" .
"FROM closed_answer_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->FOLLOW_UP->BoundColumn, $this->FOLLOW_UP->TextColumn, $this->FOLLOW_UP->DBFormat) = array("answer", "answer", "");
            $this->FOLLOW_UP->Required = true;
            $this->AGENT_EVAL_TECH = new clsControl(ccsListBox, "AGENT_EVAL_TECH", "AGENT EVAL TECH", ccsText, "", CCGetRequestParam("AGENT_EVAL_TECH", $Method, NULL), $this);
            $this->AGENT_EVAL_TECH->DSType = dsTable;
            $this->AGENT_EVAL_TECH->DataSource = new clsDBhss_db();
            $this->AGENT_EVAL_TECH->ds = & $this->AGENT_EVAL_TECH->DataSource;
            $this->AGENT_EVAL_TECH->DataSource->SQL = "SELECT * \n" .
"FROM evaluation_values_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->AGENT_EVAL_TECH->BoundColumn, $this->AGENT_EVAL_TECH->TextColumn, $this->AGENT_EVAL_TECH->DBFormat) = array("grades", "grades", "");
            $this->AGENT_EVAL_TECH->Required = true;
            $this->PORT_FEE_ID = new clsControl(ccsListBox, "PORT_FEE_ID", "PORT FEE ID", ccsInteger, "", CCGetRequestParam("PORT_FEE_ID", $Method, NULL), $this);
            $this->PORT_FEE_ID->DSType = dsTable;
            $this->PORT_FEE_ID->DataSource = new clsDBhss_db();
            $this->PORT_FEE_ID->ds = & $this->PORT_FEE_ID->DataSource;
            $this->PORT_FEE_ID->DataSource->SQL = "SELECT * \n" .
"FROM port_fees_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->PORT_FEE_ID->BoundColumn, $this->PORT_FEE_ID->TextColumn, $this->PORT_FEE_ID->DBFormat) = array("PORT_FEE_ID", "PORT_FEE_VALUE", "");
            $this->PORT_FEE_ID->Required = true;
            $this->TRANSPORT_FEE_ID = new clsControl(ccsListBox, "TRANSPORT_FEE_ID", "TRANSPORT FEE ID", ccsInteger, "", CCGetRequestParam("TRANSPORT_FEE_ID", $Method, NULL), $this);
            $this->TRANSPORT_FEE_ID->DSType = dsTable;
            $this->TRANSPORT_FEE_ID->DataSource = new clsDBhss_db();
            $this->TRANSPORT_FEE_ID->ds = & $this->TRANSPORT_FEE_ID->DataSource;
            $this->TRANSPORT_FEE_ID->DataSource->SQL = "SELECT * \n" .
"FROM transport_fees_tbl {SQL_Where} {SQL_OrderBy}";
            $this->TRANSPORT_FEE_ID->DataSource->Order = "TRANSPORT_FEE_DESCRIPTION";
            list($this->TRANSPORT_FEE_ID->BoundColumn, $this->TRANSPORT_FEE_ID->TextColumn, $this->TRANSPORT_FEE_ID->DBFormat) = array("TRANSPORT_FEE_ID", "TRANSPORT_FEE_DESCRIPTION", "");
            $this->TRANSPORT_FEE_ID->DataSource->Order = "TRANSPORT_FEE_DESCRIPTION";
            $this->TRANSPORT_FEE_ID->Required = true;
            $this->WE_WO = new clsControl(ccsTextBox, "WE_WO", "WE WO", ccsText, "", CCGetRequestParam("WE_WO", $Method, NULL), $this);
            $this->WE_WO->Required = true;
            $this->service_date_month = new clsControl(ccsListBox, "service_date_month", "Service Date Month", ccsText, "", CCGetRequestParam("service_date_month", $Method, NULL), $this);
            $this->service_date_month->DSType = dsTable;
            $this->service_date_month->DataSource = new clsDBhss_db();
            $this->service_date_month->ds = & $this->service_date_month->DataSource;
            $this->service_date_month->DataSource->SQL = "SELECT * \n" .
"FROM months_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->service_date_month->BoundColumn, $this->service_date_month->TextColumn, $this->service_date_month->DBFormat) = array("months", "months", "");
            $this->service_date_month->Required = true;
            $this->service_date_year = new clsControl(ccsTextBox, "service_date_year", "Service Date Year", ccsText, "", CCGetRequestParam("service_date_year", $Method, NULL), $this);
            $this->service_date_year->Required = true;
            $this->PORT_ID = new clsControl(ccsListBox, "PORT_ID", "PORT_ID", ccsInteger, "", CCGetRequestParam("PORT_ID", $Method, NULL), $this);
            $this->PORT_ID->DSType = dsTable;
            $this->PORT_ID->DataSource = new clsDBhss_db();
            $this->PORT_ID->ds = & $this->PORT_ID->DataSource;
            $this->PORT_ID->DataSource->SQL = "SELECT * \n" .
"FROM ports_tbl {SQL_Where} {SQL_OrderBy}";
            $this->PORT_ID->DataSource->Order = "PORT_NAME";
            list($this->PORT_ID->BoundColumn, $this->PORT_ID->TextColumn, $this->PORT_ID->DBFormat) = array("PORT_ID", "PORT_NAME", "");
            $this->PORT_ID->DataSource->Order = "PORT_NAME";
            $this->PORT_ID->Required = true;
            $this->NT_TEC_WO = new clsControl(ccsTextBox, "NT_TEC_WO", "NT TEC WO", ccsText, "", CCGetRequestParam("NT_TEC_WO", $Method, NULL), $this);
            $this->NT_TEC_WO->Required = true;
            $this->NT_TEC_WA = new clsControl(ccsTextBox, "NT_TEC_WA", "NT TEC WA", ccsText, "", CCGetRequestParam("NT_TEC_WA", $Method, NULL), $this);
            $this->NT_TEC_WA->Required = true;
            $this->NT_TEC_TR = new clsControl(ccsTextBox, "NT_TEC_TR", "NT TEC TR", ccsText, "", CCGetRequestParam("NT_TEC_TR", $Method, NULL), $this);
            $this->NT_TEC_TR->Required = true;
            $this->OT_INV_WO = new clsControl(ccsTextBox, "OT_INV_WO", "OT INV WO", ccsText, "", CCGetRequestParam("OT_INV_WO", $Method, NULL), $this);
            $this->OT_INV_WO->Required = true;
            $this->OT_INV_WA = new clsControl(ccsTextBox, "OT_INV_WA", "OT INV WA", ccsText, "", CCGetRequestParam("OT_INV_WA", $Method, NULL), $this);
            $this->OT_INV_WA->Required = true;
            $this->OT_INV_TR = new clsControl(ccsTextBox, "OT_INV_TR", "OT INV TR", ccsText, "", CCGetRequestParam("OT_INV_TR", $Method, NULL), $this);
            $this->OT_INV_TR->Required = true;
            $this->OT_TEC_WO = new clsControl(ccsTextBox, "OT_TEC_WO", "OT TEC WO", ccsText, "", CCGetRequestParam("OT_TEC_WO", $Method, NULL), $this);
            $this->OT_TEC_WO->Required = true;
            $this->OT_TEC_WA = new clsControl(ccsTextBox, "OT_TEC_WA", "OT TEC WA", ccsText, "", CCGetRequestParam("OT_TEC_WA", $Method, NULL), $this);
            $this->OT_TEC_WA->Required = true;
            $this->OT_TEC_TR = new clsControl(ccsTextBox, "OT_TEC_TR", "OT TEC TR", ccsText, "", CCGetRequestParam("OT_TEC_TR", $Method, NULL), $this);
            $this->OT_TEC_TR->Required = true;
            $this->ND_WO = new clsControl(ccsTextBox, "ND_WO", "ND WO", ccsText, "", CCGetRequestParam("ND_WO", $Method, NULL), $this);
            $this->ND_WO->Required = true;
            $this->ND_WA = new clsControl(ccsTextBox, "ND_WA", "ND WA", ccsText, "", CCGetRequestParam("ND_WA", $Method, NULL), $this);
            $this->ND_WA->Required = true;
            $this->ND_TR = new clsControl(ccsTextBox, "ND_TR", "ND TR", ccsText, "", CCGetRequestParam("ND_TR", $Method, NULL), $this);
            $this->ND_TR->Required = true;
            $this->WE_WA = new clsControl(ccsTextBox, "WE_WA", "WE WA", ccsText, "", CCGetRequestParam("WE_WA", $Method, NULL), $this);
            $this->WE_WA->Required = true;
            $this->WE_TR = new clsControl(ccsTextBox, "WE_TR", "WE TR", ccsText, "", CCGetRequestParam("WE_TR", $Method, NULL), $this);
            $this->WE_TR->Required = true;
            $this->NT_INV_WO = new clsControl(ccsTextBox, "NT_INV_WO", "NT INV WO", ccsText, "", CCGetRequestParam("NT_INV_WO", $Method, NULL), $this);
            $this->NT_INV_WO->Required = true;
            $this->NT_INV_WA = new clsControl(ccsTextBox, "NT_INV_WA", "NT INV WA", ccsText, "", CCGetRequestParam("NT_INV_WA", $Method, NULL), $this);
            $this->NT_INV_WA->Required = true;
            $this->NT_INV_TR = new clsControl(ccsTextBox, "NT_INV_TR", "NT INV TR", ccsText, "", CCGetRequestParam("NT_INV_TR", $Method, NULL), $this);
            $this->NT_INV_TR->Required = true;
            $this->NT_APP_BY = new clsControl(ccsListBox, "NT_APP_BY", "NT_APP_BY", ccsInteger, "", CCGetRequestParam("NT_APP_BY", $Method, NULL), $this);
            $this->NT_APP_BY->DSType = dsTable;
            $this->NT_APP_BY->DataSource = new clsDBhss_db();
            $this->NT_APP_BY->ds = & $this->NT_APP_BY->DataSource;
            $this->NT_APP_BY->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->NT_APP_BY->BoundColumn, $this->NT_APP_BY->TextColumn, $this->NT_APP_BY->DBFormat) = array("emp_id", "emp_login", "");
            $this->NT_APP_BY->Required = true;
            $this->OT_APP_BY = new clsControl(ccsListBox, "OT_APP_BY", "OT_APP_BY", ccsInteger, "", CCGetRequestParam("OT_APP_BY", $Method, NULL), $this);
            $this->OT_APP_BY->DSType = dsTable;
            $this->OT_APP_BY->DataSource = new clsDBhss_db();
            $this->OT_APP_BY->ds = & $this->OT_APP_BY->DataSource;
            $this->OT_APP_BY->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->OT_APP_BY->BoundColumn, $this->OT_APP_BY->TextColumn, $this->OT_APP_BY->DBFormat) = array("emp_id", "emp_login", "");
            $this->OT_APP_BY->Required = true;
            if(!$this->FormSubmitted) {
                if(!is_array($this->WE_WO->Value) && !strlen($this->WE_WO->Value) && $this->WE_WO->Value !== false)
                    $this->WE_WO->SetText(0);
                if(!is_array($this->service_date_year->Value) && !strlen($this->service_date_year->Value) && $this->service_date_year->Value !== false)
                    $this->service_date_year->SetText(2009);
                if(!is_array($this->NT_TEC_WO->Value) && !strlen($this->NT_TEC_WO->Value) && $this->NT_TEC_WO->Value !== false)
                    $this->NT_TEC_WO->SetText(0);
                if(!is_array($this->NT_TEC_WA->Value) && !strlen($this->NT_TEC_WA->Value) && $this->NT_TEC_WA->Value !== false)
                    $this->NT_TEC_WA->SetText(0);
                if(!is_array($this->NT_TEC_TR->Value) && !strlen($this->NT_TEC_TR->Value) && $this->NT_TEC_TR->Value !== false)
                    $this->NT_TEC_TR->SetText(0);
                if(!is_array($this->OT_INV_WO->Value) && !strlen($this->OT_INV_WO->Value) && $this->OT_INV_WO->Value !== false)
                    $this->OT_INV_WO->SetText(0);
                if(!is_array($this->OT_INV_WA->Value) && !strlen($this->OT_INV_WA->Value) && $this->OT_INV_WA->Value !== false)
                    $this->OT_INV_WA->SetText(0);
                if(!is_array($this->OT_INV_TR->Value) && !strlen($this->OT_INV_TR->Value) && $this->OT_INV_TR->Value !== false)
                    $this->OT_INV_TR->SetText(0);
                if(!is_array($this->OT_TEC_WO->Value) && !strlen($this->OT_TEC_WO->Value) && $this->OT_TEC_WO->Value !== false)
                    $this->OT_TEC_WO->SetText(0);
                if(!is_array($this->OT_TEC_WA->Value) && !strlen($this->OT_TEC_WA->Value) && $this->OT_TEC_WA->Value !== false)
                    $this->OT_TEC_WA->SetText(0);
                if(!is_array($this->OT_TEC_TR->Value) && !strlen($this->OT_TEC_TR->Value) && $this->OT_TEC_TR->Value !== false)
                    $this->OT_TEC_TR->SetText(0);
                if(!is_array($this->ND_WO->Value) && !strlen($this->ND_WO->Value) && $this->ND_WO->Value !== false)
                    $this->ND_WO->SetText(0);
                if(!is_array($this->ND_WA->Value) && !strlen($this->ND_WA->Value) && $this->ND_WA->Value !== false)
                    $this->ND_WA->SetText(0);
                if(!is_array($this->ND_TR->Value) && !strlen($this->ND_TR->Value) && $this->ND_TR->Value !== false)
                    $this->ND_TR->SetText(0);
                if(!is_array($this->WE_WA->Value) && !strlen($this->WE_WA->Value) && $this->WE_WA->Value !== false)
                    $this->WE_WA->SetText(0);
                if(!is_array($this->WE_TR->Value) && !strlen($this->WE_TR->Value) && $this->WE_TR->Value !== false)
                    $this->WE_TR->SetText(0);
                if(!is_array($this->NT_INV_WO->Value) && !strlen($this->NT_INV_WO->Value) && $this->NT_INV_WO->Value !== false)
                    $this->NT_INV_WO->SetText(0);
                if(!is_array($this->NT_INV_WA->Value) && !strlen($this->NT_INV_WA->Value) && $this->NT_INV_WA->Value !== false)
                    $this->NT_INV_WA->SetText(0);
                if(!is_array($this->NT_INV_TR->Value) && !strlen($this->NT_INV_TR->Value) && $this->NT_INV_TR->Value !== false)
                    $this->NT_INV_TR->SetText(0);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @2-0CB5929C
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlrecord_id"] = CCGetFromGet("record_id", NULL);
    }
//End Initialize Method

//Validate Method @2-E47E2D13
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->record_id->Validate() && $Validation);
        $Validation = ($this->ORDER_NO->Validate() && $Validation);
        $Validation = ($this->emp_id->Validate() && $Validation);
        $Validation = ($this->service_date_day->Validate() && $Validation);
        $Validation = ($this->FOLLOW_UP->Validate() && $Validation);
        $Validation = ($this->AGENT_EVAL_TECH->Validate() && $Validation);
        $Validation = ($this->PORT_FEE_ID->Validate() && $Validation);
        $Validation = ($this->TRANSPORT_FEE_ID->Validate() && $Validation);
        $Validation = ($this->WE_WO->Validate() && $Validation);
        $Validation = ($this->service_date_month->Validate() && $Validation);
        $Validation = ($this->service_date_year->Validate() && $Validation);
        $Validation = ($this->PORT_ID->Validate() && $Validation);
        $Validation = ($this->NT_TEC_WO->Validate() && $Validation);
        $Validation = ($this->NT_TEC_WA->Validate() && $Validation);
        $Validation = ($this->NT_TEC_TR->Validate() && $Validation);
        $Validation = ($this->OT_INV_WO->Validate() && $Validation);
        $Validation = ($this->OT_INV_WA->Validate() && $Validation);
        $Validation = ($this->OT_INV_TR->Validate() && $Validation);
        $Validation = ($this->OT_TEC_WO->Validate() && $Validation);
        $Validation = ($this->OT_TEC_WA->Validate() && $Validation);
        $Validation = ($this->OT_TEC_TR->Validate() && $Validation);
        $Validation = ($this->ND_WO->Validate() && $Validation);
        $Validation = ($this->ND_WA->Validate() && $Validation);
        $Validation = ($this->ND_TR->Validate() && $Validation);
        $Validation = ($this->WE_WA->Validate() && $Validation);
        $Validation = ($this->WE_TR->Validate() && $Validation);
        $Validation = ($this->NT_INV_WO->Validate() && $Validation);
        $Validation = ($this->NT_INV_WA->Validate() && $Validation);
        $Validation = ($this->NT_INV_TR->Validate() && $Validation);
        $Validation = ($this->NT_APP_BY->Validate() && $Validation);
        $Validation = ($this->OT_APP_BY->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->record_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ORDER_NO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->emp_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->service_date_day->Errors->Count() == 0);
        $Validation =  $Validation && ($this->FOLLOW_UP->Errors->Count() == 0);
        $Validation =  $Validation && ($this->AGENT_EVAL_TECH->Errors->Count() == 0);
        $Validation =  $Validation && ($this->PORT_FEE_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TRANSPORT_FEE_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->WE_WO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->service_date_month->Errors->Count() == 0);
        $Validation =  $Validation && ($this->service_date_year->Errors->Count() == 0);
        $Validation =  $Validation && ($this->PORT_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->NT_TEC_WO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->NT_TEC_WA->Errors->Count() == 0);
        $Validation =  $Validation && ($this->NT_TEC_TR->Errors->Count() == 0);
        $Validation =  $Validation && ($this->OT_INV_WO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->OT_INV_WA->Errors->Count() == 0);
        $Validation =  $Validation && ($this->OT_INV_TR->Errors->Count() == 0);
        $Validation =  $Validation && ($this->OT_TEC_WO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->OT_TEC_WA->Errors->Count() == 0);
        $Validation =  $Validation && ($this->OT_TEC_TR->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ND_WO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ND_WA->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ND_TR->Errors->Count() == 0);
        $Validation =  $Validation && ($this->WE_WA->Errors->Count() == 0);
        $Validation =  $Validation && ($this->WE_TR->Errors->Count() == 0);
        $Validation =  $Validation && ($this->NT_INV_WO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->NT_INV_WA->Errors->Count() == 0);
        $Validation =  $Validation && ($this->NT_INV_TR->Errors->Count() == 0);
        $Validation =  $Validation && ($this->NT_APP_BY->Errors->Count() == 0);
        $Validation =  $Validation && ($this->OT_APP_BY->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-FBA5E621
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->record_id->Errors->Count());
        $errors = ($errors || $this->ORDER_NO->Errors->Count());
        $errors = ($errors || $this->emp_id->Errors->Count());
        $errors = ($errors || $this->service_date_day->Errors->Count());
        $errors = ($errors || $this->FOLLOW_UP->Errors->Count());
        $errors = ($errors || $this->AGENT_EVAL_TECH->Errors->Count());
        $errors = ($errors || $this->PORT_FEE_ID->Errors->Count());
        $errors = ($errors || $this->TRANSPORT_FEE_ID->Errors->Count());
        $errors = ($errors || $this->WE_WO->Errors->Count());
        $errors = ($errors || $this->service_date_month->Errors->Count());
        $errors = ($errors || $this->service_date_year->Errors->Count());
        $errors = ($errors || $this->PORT_ID->Errors->Count());
        $errors = ($errors || $this->NT_TEC_WO->Errors->Count());
        $errors = ($errors || $this->NT_TEC_WA->Errors->Count());
        $errors = ($errors || $this->NT_TEC_TR->Errors->Count());
        $errors = ($errors || $this->OT_INV_WO->Errors->Count());
        $errors = ($errors || $this->OT_INV_WA->Errors->Count());
        $errors = ($errors || $this->OT_INV_TR->Errors->Count());
        $errors = ($errors || $this->OT_TEC_WO->Errors->Count());
        $errors = ($errors || $this->OT_TEC_WA->Errors->Count());
        $errors = ($errors || $this->OT_TEC_TR->Errors->Count());
        $errors = ($errors || $this->ND_WO->Errors->Count());
        $errors = ($errors || $this->ND_WA->Errors->Count());
        $errors = ($errors || $this->ND_TR->Errors->Count());
        $errors = ($errors || $this->WE_WA->Errors->Count());
        $errors = ($errors || $this->WE_TR->Errors->Count());
        $errors = ($errors || $this->NT_INV_WO->Errors->Count());
        $errors = ($errors || $this->NT_INV_WA->Errors->Count());
        $errors = ($errors || $this->NT_INV_TR->Errors->Count());
        $errors = ($errors || $this->NT_APP_BY->Errors->Count());
        $errors = ($errors || $this->OT_APP_BY->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @2-ED598703
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

//Operation Method @2-0BF2B389
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted) {
            $this->EditMode = $this->DataSource->AllParametersSet;
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update") {
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//InsertRow Method @2-F28A45A8
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->record_id->SetValue($this->record_id->GetValue(true));
        $this->DataSource->ORDER_NO->SetValue($this->ORDER_NO->GetValue(true));
        $this->DataSource->emp_id->SetValue($this->emp_id->GetValue(true));
        $this->DataSource->service_date_day->SetValue($this->service_date_day->GetValue(true));
        $this->DataSource->FOLLOW_UP->SetValue($this->FOLLOW_UP->GetValue(true));
        $this->DataSource->AGENT_EVAL_TECH->SetValue($this->AGENT_EVAL_TECH->GetValue(true));
        $this->DataSource->PORT_FEE_ID->SetValue($this->PORT_FEE_ID->GetValue(true));
        $this->DataSource->TRANSPORT_FEE_ID->SetValue($this->TRANSPORT_FEE_ID->GetValue(true));
        $this->DataSource->WE_WO->SetValue($this->WE_WO->GetValue(true));
        $this->DataSource->service_date_month->SetValue($this->service_date_month->GetValue(true));
        $this->DataSource->service_date_year->SetValue($this->service_date_year->GetValue(true));
        $this->DataSource->PORT_ID->SetValue($this->PORT_ID->GetValue(true));
        $this->DataSource->NT_TEC_WO->SetValue($this->NT_TEC_WO->GetValue(true));
        $this->DataSource->NT_TEC_WA->SetValue($this->NT_TEC_WA->GetValue(true));
        $this->DataSource->NT_TEC_TR->SetValue($this->NT_TEC_TR->GetValue(true));
        $this->DataSource->OT_INV_WO->SetValue($this->OT_INV_WO->GetValue(true));
        $this->DataSource->OT_INV_WA->SetValue($this->OT_INV_WA->GetValue(true));
        $this->DataSource->OT_INV_TR->SetValue($this->OT_INV_TR->GetValue(true));
        $this->DataSource->OT_TEC_WO->SetValue($this->OT_TEC_WO->GetValue(true));
        $this->DataSource->OT_TEC_WA->SetValue($this->OT_TEC_WA->GetValue(true));
        $this->DataSource->OT_TEC_TR->SetValue($this->OT_TEC_TR->GetValue(true));
        $this->DataSource->ND_WO->SetValue($this->ND_WO->GetValue(true));
        $this->DataSource->ND_WA->SetValue($this->ND_WA->GetValue(true));
        $this->DataSource->ND_TR->SetValue($this->ND_TR->GetValue(true));
        $this->DataSource->WE_WA->SetValue($this->WE_WA->GetValue(true));
        $this->DataSource->WE_TR->SetValue($this->WE_TR->GetValue(true));
        $this->DataSource->NT_INV_WO->SetValue($this->NT_INV_WO->GetValue(true));
        $this->DataSource->NT_INV_WA->SetValue($this->NT_INV_WA->GetValue(true));
        $this->DataSource->NT_INV_TR->SetValue($this->NT_INV_TR->GetValue(true));
        $this->DataSource->NT_APP_BY->SetValue($this->NT_APP_BY->GetValue(true));
        $this->DataSource->OT_APP_BY->SetValue($this->OT_APP_BY->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-5C692219
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->record_id->SetValue($this->record_id->GetValue(true));
        $this->DataSource->ORDER_NO->SetValue($this->ORDER_NO->GetValue(true));
        $this->DataSource->emp_id->SetValue($this->emp_id->GetValue(true));
        $this->DataSource->service_date_day->SetValue($this->service_date_day->GetValue(true));
        $this->DataSource->FOLLOW_UP->SetValue($this->FOLLOW_UP->GetValue(true));
        $this->DataSource->AGENT_EVAL_TECH->SetValue($this->AGENT_EVAL_TECH->GetValue(true));
        $this->DataSource->PORT_FEE_ID->SetValue($this->PORT_FEE_ID->GetValue(true));
        $this->DataSource->TRANSPORT_FEE_ID->SetValue($this->TRANSPORT_FEE_ID->GetValue(true));
        $this->DataSource->WE_WO->SetValue($this->WE_WO->GetValue(true));
        $this->DataSource->service_date_month->SetValue($this->service_date_month->GetValue(true));
        $this->DataSource->service_date_year->SetValue($this->service_date_year->GetValue(true));
        $this->DataSource->PORT_ID->SetValue($this->PORT_ID->GetValue(true));
        $this->DataSource->NT_TEC_WO->SetValue($this->NT_TEC_WO->GetValue(true));
        $this->DataSource->NT_TEC_WA->SetValue($this->NT_TEC_WA->GetValue(true));
        $this->DataSource->NT_TEC_TR->SetValue($this->NT_TEC_TR->GetValue(true));
        $this->DataSource->OT_INV_WO->SetValue($this->OT_INV_WO->GetValue(true));
        $this->DataSource->OT_INV_WA->SetValue($this->OT_INV_WA->GetValue(true));
        $this->DataSource->OT_INV_TR->SetValue($this->OT_INV_TR->GetValue(true));
        $this->DataSource->OT_TEC_WO->SetValue($this->OT_TEC_WO->GetValue(true));
        $this->DataSource->OT_TEC_WA->SetValue($this->OT_TEC_WA->GetValue(true));
        $this->DataSource->OT_TEC_TR->SetValue($this->OT_TEC_TR->GetValue(true));
        $this->DataSource->ND_WO->SetValue($this->ND_WO->GetValue(true));
        $this->DataSource->ND_WA->SetValue($this->ND_WA->GetValue(true));
        $this->DataSource->ND_TR->SetValue($this->ND_TR->GetValue(true));
        $this->DataSource->WE_WA->SetValue($this->WE_WA->GetValue(true));
        $this->DataSource->WE_TR->SetValue($this->WE_TR->GetValue(true));
        $this->DataSource->NT_INV_WO->SetValue($this->NT_INV_WO->GetValue(true));
        $this->DataSource->NT_INV_WA->SetValue($this->NT_INV_WA->GetValue(true));
        $this->DataSource->NT_INV_TR->SetValue($this->NT_INV_TR->GetValue(true));
        $this->DataSource->NT_APP_BY->SetValue($this->NT_APP_BY->GetValue(true));
        $this->DataSource->OT_APP_BY->SetValue($this->OT_APP_BY->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-53959901
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

        $this->emp_id->Prepare();
        $this->service_date_day->Prepare();
        $this->FOLLOW_UP->Prepare();
        $this->AGENT_EVAL_TECH->Prepare();
        $this->PORT_FEE_ID->Prepare();
        $this->TRANSPORT_FEE_ID->Prepare();
        $this->service_date_month->Prepare();
        $this->PORT_ID->Prepare();
        $this->NT_APP_BY->Prepare();
        $this->OT_APP_BY->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                if(!$this->FormSubmitted){
                    $this->record_id->SetValue($this->DataSource->record_id->GetValue());
                    $this->ORDER_NO->SetValue($this->DataSource->ORDER_NO->GetValue());
                    $this->emp_id->SetValue($this->DataSource->emp_id->GetValue());
                    $this->service_date_day->SetValue($this->DataSource->service_date_day->GetValue());
                    $this->FOLLOW_UP->SetValue($this->DataSource->FOLLOW_UP->GetValue());
                    $this->AGENT_EVAL_TECH->SetValue($this->DataSource->AGENT_EVAL_TECH->GetValue());
                    $this->PORT_FEE_ID->SetValue($this->DataSource->PORT_FEE_ID->GetValue());
                    $this->TRANSPORT_FEE_ID->SetValue($this->DataSource->TRANSPORT_FEE_ID->GetValue());
                    $this->WE_WO->SetValue($this->DataSource->WE_WO->GetValue());
                    $this->service_date_month->SetValue($this->DataSource->service_date_month->GetValue());
                    $this->service_date_year->SetValue($this->DataSource->service_date_year->GetValue());
                    $this->PORT_ID->SetValue($this->DataSource->PORT_ID->GetValue());
                    $this->NT_TEC_WO->SetValue($this->DataSource->NT_TEC_WO->GetValue());
                    $this->NT_TEC_WA->SetValue($this->DataSource->NT_TEC_WA->GetValue());
                    $this->NT_TEC_TR->SetValue($this->DataSource->NT_TEC_TR->GetValue());
                    $this->OT_INV_WO->SetValue($this->DataSource->OT_INV_WO->GetValue());
                    $this->OT_INV_WA->SetValue($this->DataSource->OT_INV_WA->GetValue());
                    $this->OT_INV_TR->SetValue($this->DataSource->OT_INV_TR->GetValue());
                    $this->OT_TEC_WO->SetValue($this->DataSource->OT_TEC_WO->GetValue());
                    $this->OT_TEC_WA->SetValue($this->DataSource->OT_TEC_WA->GetValue());
                    $this->OT_TEC_TR->SetValue($this->DataSource->OT_TEC_TR->GetValue());
                    $this->ND_WO->SetValue($this->DataSource->ND_WO->GetValue());
                    $this->ND_WA->SetValue($this->DataSource->ND_WA->GetValue());
                    $this->ND_TR->SetValue($this->DataSource->ND_TR->GetValue());
                    $this->WE_WA->SetValue($this->DataSource->WE_WA->GetValue());
                    $this->WE_TR->SetValue($this->DataSource->WE_TR->GetValue());
                    $this->NT_INV_WO->SetValue($this->DataSource->NT_INV_WO->GetValue());
                    $this->NT_INV_WA->SetValue($this->DataSource->NT_INV_WA->GetValue());
                    $this->NT_INV_TR->SetValue($this->DataSource->NT_INV_TR->GetValue());
                    $this->NT_APP_BY->SetValue($this->DataSource->NT_APP_BY->GetValue());
                    $this->OT_APP_BY->SetValue($this->DataSource->OT_APP_BY->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->record_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ORDER_NO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->emp_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->service_date_day->Errors->ToString());
            $Error = ComposeStrings($Error, $this->FOLLOW_UP->Errors->ToString());
            $Error = ComposeStrings($Error, $this->AGENT_EVAL_TECH->Errors->ToString());
            $Error = ComposeStrings($Error, $this->PORT_FEE_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TRANSPORT_FEE_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->WE_WO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->service_date_month->Errors->ToString());
            $Error = ComposeStrings($Error, $this->service_date_year->Errors->ToString());
            $Error = ComposeStrings($Error, $this->PORT_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->NT_TEC_WO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->NT_TEC_WA->Errors->ToString());
            $Error = ComposeStrings($Error, $this->NT_TEC_TR->Errors->ToString());
            $Error = ComposeStrings($Error, $this->OT_INV_WO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->OT_INV_WA->Errors->ToString());
            $Error = ComposeStrings($Error, $this->OT_INV_TR->Errors->ToString());
            $Error = ComposeStrings($Error, $this->OT_TEC_WO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->OT_TEC_WA->Errors->ToString());
            $Error = ComposeStrings($Error, $this->OT_TEC_TR->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ND_WO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ND_WA->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ND_TR->Errors->ToString());
            $Error = ComposeStrings($Error, $this->WE_WA->Errors->ToString());
            $Error = ComposeStrings($Error, $this->WE_TR->Errors->ToString());
            $Error = ComposeStrings($Error, $this->NT_INV_WO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->NT_INV_WA->Errors->ToString());
            $Error = ComposeStrings($Error, $this->NT_INV_TR->Errors->ToString());
            $Error = ComposeStrings($Error, $this->NT_APP_BY->Errors->ToString());
            $Error = ComposeStrings($Error, $this->OT_APP_BY->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
        $this->Button_Insert->Visible = !$this->EditMode && $this->InsertAllowed;
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Cancel->Show();
        $this->record_id->Show();
        $this->ORDER_NO->Show();
        $this->emp_id->Show();
        $this->service_date_day->Show();
        $this->FOLLOW_UP->Show();
        $this->AGENT_EVAL_TECH->Show();
        $this->PORT_FEE_ID->Show();
        $this->TRANSPORT_FEE_ID->Show();
        $this->WE_WO->Show();
        $this->service_date_month->Show();
        $this->service_date_year->Show();
        $this->PORT_ID->Show();
        $this->NT_TEC_WO->Show();
        $this->NT_TEC_WA->Show();
        $this->NT_TEC_TR->Show();
        $this->OT_INV_WO->Show();
        $this->OT_INV_WA->Show();
        $this->OT_INV_TR->Show();
        $this->OT_TEC_WO->Show();
        $this->OT_TEC_WA->Show();
        $this->OT_TEC_TR->Show();
        $this->ND_WO->Show();
        $this->ND_WA->Show();
        $this->ND_TR->Show();
        $this->WE_WA->Show();
        $this->WE_TR->Show();
        $this->NT_INV_WO->Show();
        $this->NT_INV_WA->Show();
        $this->NT_INV_TR->Show();
        $this->NT_APP_BY->Show();
        $this->OT_APP_BY->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End after_service_tbl Class @2-FCB6E20C

class clsafter_service_tblDataSource extends clsDBhss_db {  //after_service_tblDataSource Class @2-A5ADE14F

//DataSource Variables @2-F19144B9
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $record_id;
    public $ORDER_NO;
    public $emp_id;
    public $service_date_day;
    public $FOLLOW_UP;
    public $AGENT_EVAL_TECH;
    public $PORT_FEE_ID;
    public $TRANSPORT_FEE_ID;
    public $WE_WO;
    public $service_date_month;
    public $service_date_year;
    public $PORT_ID;
    public $NT_TEC_WO;
    public $NT_TEC_WA;
    public $NT_TEC_TR;
    public $OT_INV_WO;
    public $OT_INV_WA;
    public $OT_INV_TR;
    public $OT_TEC_WO;
    public $OT_TEC_WA;
    public $OT_TEC_TR;
    public $ND_WO;
    public $ND_WA;
    public $ND_TR;
    public $WE_WA;
    public $WE_TR;
    public $NT_INV_WO;
    public $NT_INV_WA;
    public $NT_INV_TR;
    public $NT_APP_BY;
    public $OT_APP_BY;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-BD17A6FB
    function clsafter_service_tblDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record after_service_tbl/Error";
        $this->Initialize();
        $this->record_id = new clsField("record_id", ccsInteger, "");
        
        $this->ORDER_NO = new clsField("ORDER_NO", ccsText, "");
        
        $this->emp_id = new clsField("emp_id", ccsInteger, "");
        
        $this->service_date_day = new clsField("service_date_day", ccsText, "");
        
        $this->FOLLOW_UP = new clsField("FOLLOW_UP", ccsText, "");
        
        $this->AGENT_EVAL_TECH = new clsField("AGENT_EVAL_TECH", ccsText, "");
        
        $this->PORT_FEE_ID = new clsField("PORT_FEE_ID", ccsInteger, "");
        
        $this->TRANSPORT_FEE_ID = new clsField("TRANSPORT_FEE_ID", ccsInteger, "");
        
        $this->WE_WO = new clsField("WE_WO", ccsText, "");
        
        $this->service_date_month = new clsField("service_date_month", ccsText, "");
        
        $this->service_date_year = new clsField("service_date_year", ccsText, "");
        
        $this->PORT_ID = new clsField("PORT_ID", ccsInteger, "");
        
        $this->NT_TEC_WO = new clsField("NT_TEC_WO", ccsText, "");
        
        $this->NT_TEC_WA = new clsField("NT_TEC_WA", ccsText, "");
        
        $this->NT_TEC_TR = new clsField("NT_TEC_TR", ccsText, "");
        
        $this->OT_INV_WO = new clsField("OT_INV_WO", ccsText, "");
        
        $this->OT_INV_WA = new clsField("OT_INV_WA", ccsText, "");
        
        $this->OT_INV_TR = new clsField("OT_INV_TR", ccsText, "");
        
        $this->OT_TEC_WO = new clsField("OT_TEC_WO", ccsText, "");
        
        $this->OT_TEC_WA = new clsField("OT_TEC_WA", ccsText, "");
        
        $this->OT_TEC_TR = new clsField("OT_TEC_TR", ccsText, "");
        
        $this->ND_WO = new clsField("ND_WO", ccsText, "");
        
        $this->ND_WA = new clsField("ND_WA", ccsText, "");
        
        $this->ND_TR = new clsField("ND_TR", ccsText, "");
        
        $this->WE_WA = new clsField("WE_WA", ccsText, "");
        
        $this->WE_TR = new clsField("WE_TR", ccsText, "");
        
        $this->NT_INV_WO = new clsField("NT_INV_WO", ccsText, "");
        
        $this->NT_INV_WA = new clsField("NT_INV_WA", ccsText, "");
        
        $this->NT_INV_TR = new clsField("NT_INV_TR", ccsText, "");
        
        $this->NT_APP_BY = new clsField("NT_APP_BY", ccsInteger, "");
        
        $this->OT_APP_BY = new clsField("OT_APP_BY", ccsInteger, "");
        

        $this->InsertFields["record_id"] = array("Name" => "record_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["ORDER_NO"] = array("Name" => "ORDER_NO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["emp_id"] = array("Name" => "emp_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["service_date_day"] = array("Name" => "service_date_day", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["FOLLOW_UP"] = array("Name" => "FOLLOW_UP", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["AGENT_EVAL_TECH"] = array("Name" => "AGENT_EVAL_TECH", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["PORT_FEE_ID"] = array("Name" => "PORT_FEE_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["TRANSPORT_FEE_ID"] = array("Name" => "TRANSPORT_FEE_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["WE_WO"] = array("Name" => "WE_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["service_date_month"] = array("Name" => "service_date_month", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["service_date_year"] = array("Name" => "service_date_year", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["PORT_ID"] = array("Name" => "PORT_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["NT_TEC_WO"] = array("Name" => "NT_TEC_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["NT_TEC_WA"] = array("Name" => "NT_TEC_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["NT_TEC_TR"] = array("Name" => "NT_TEC_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["OT_INV_WO"] = array("Name" => "OT_INV_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["OT_INV_WA"] = array("Name" => "OT_INV_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["OT_INV_TR"] = array("Name" => "OT_INV_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["OT_TEC_WO"] = array("Name" => "OT_TEC_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["OT_TEC_WA"] = array("Name" => "OT_TEC_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["OT_TEC_TR"] = array("Name" => "OT_TEC_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["ND_WO"] = array("Name" => "ND_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["ND_WA"] = array("Name" => "ND_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["ND_TR"] = array("Name" => "ND_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["WE_WA"] = array("Name" => "WE_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["WE_TR"] = array("Name" => "WE_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["NT_INV_WO"] = array("Name" => "NT_INV_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["NT_INV_WA"] = array("Name" => "NT_INV_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["NT_INV_TR"] = array("Name" => "NT_INV_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["NT_APP_BY"] = array("Name" => "NT_APP_BY", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["OT_APP_BY"] = array("Name" => "OT_APP_BY", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["record_id"] = array("Name" => "record_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["ORDER_NO"] = array("Name" => "ORDER_NO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["emp_id"] = array("Name" => "emp_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["service_date_day"] = array("Name" => "service_date_day", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["FOLLOW_UP"] = array("Name" => "FOLLOW_UP", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["AGENT_EVAL_TECH"] = array("Name" => "AGENT_EVAL_TECH", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["PORT_FEE_ID"] = array("Name" => "PORT_FEE_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["TRANSPORT_FEE_ID"] = array("Name" => "TRANSPORT_FEE_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["WE_WO"] = array("Name" => "WE_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["service_date_month"] = array("Name" => "service_date_month", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["service_date_year"] = array("Name" => "service_date_year", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["PORT_ID"] = array("Name" => "PORT_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["NT_TEC_WO"] = array("Name" => "NT_TEC_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["NT_TEC_WA"] = array("Name" => "NT_TEC_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["NT_TEC_TR"] = array("Name" => "NT_TEC_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["OT_INV_WO"] = array("Name" => "OT_INV_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["OT_INV_WA"] = array("Name" => "OT_INV_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["OT_INV_TR"] = array("Name" => "OT_INV_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["OT_TEC_WO"] = array("Name" => "OT_TEC_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["OT_TEC_WA"] = array("Name" => "OT_TEC_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["OT_TEC_TR"] = array("Name" => "OT_TEC_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["ND_WO"] = array("Name" => "ND_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["ND_WA"] = array("Name" => "ND_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["ND_TR"] = array("Name" => "ND_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["WE_WA"] = array("Name" => "WE_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["WE_TR"] = array("Name" => "WE_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["NT_INV_WO"] = array("Name" => "NT_INV_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["NT_INV_WA"] = array("Name" => "NT_INV_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["NT_INV_TR"] = array("Name" => "NT_INV_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["NT_APP_BY"] = array("Name" => "NT_APP_BY", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["OT_APP_BY"] = array("Name" => "OT_APP_BY", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-5FD8AECD
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlrecord_id", ccsInteger, "", "", $this->Parameters["urlrecord_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "record_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-79A832F9
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM after_service_tbl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-9B0EEB8F
    function SetValues()
    {
        $this->record_id->SetDBValue(trim($this->f("record_id")));
        $this->ORDER_NO->SetDBValue($this->f("ORDER_NO"));
        $this->emp_id->SetDBValue(trim($this->f("emp_id")));
        $this->service_date_day->SetDBValue($this->f("service_date_day"));
        $this->FOLLOW_UP->SetDBValue($this->f("FOLLOW_UP"));
        $this->AGENT_EVAL_TECH->SetDBValue($this->f("AGENT_EVAL_TECH"));
        $this->PORT_FEE_ID->SetDBValue(trim($this->f("PORT_FEE_ID")));
        $this->TRANSPORT_FEE_ID->SetDBValue(trim($this->f("TRANSPORT_FEE_ID")));
        $this->WE_WO->SetDBValue($this->f("WE_WO"));
        $this->service_date_month->SetDBValue($this->f("service_date_month"));
        $this->service_date_year->SetDBValue($this->f("service_date_year"));
        $this->PORT_ID->SetDBValue(trim($this->f("PORT_ID")));
        $this->NT_TEC_WO->SetDBValue($this->f("NT_TEC_WO"));
        $this->NT_TEC_WA->SetDBValue($this->f("NT_TEC_WA"));
        $this->NT_TEC_TR->SetDBValue($this->f("NT_TEC_TR"));
        $this->OT_INV_WO->SetDBValue($this->f("OT_INV_WO"));
        $this->OT_INV_WA->SetDBValue($this->f("OT_INV_WA"));
        $this->OT_INV_TR->SetDBValue($this->f("OT_INV_TR"));
        $this->OT_TEC_WO->SetDBValue($this->f("OT_TEC_WO"));
        $this->OT_TEC_WA->SetDBValue($this->f("OT_TEC_WA"));
        $this->OT_TEC_TR->SetDBValue($this->f("OT_TEC_TR"));
        $this->ND_WO->SetDBValue($this->f("ND_WO"));
        $this->ND_WA->SetDBValue($this->f("ND_WA"));
        $this->ND_TR->SetDBValue($this->f("ND_TR"));
        $this->WE_WA->SetDBValue($this->f("WE_WA"));
        $this->WE_TR->SetDBValue($this->f("WE_TR"));
        $this->NT_INV_WO->SetDBValue($this->f("NT_INV_WO"));
        $this->NT_INV_WA->SetDBValue($this->f("NT_INV_WA"));
        $this->NT_INV_TR->SetDBValue($this->f("NT_INV_TR"));
        $this->NT_APP_BY->SetDBValue(trim($this->f("NT_APP_BY")));
        $this->OT_APP_BY->SetDBValue(trim($this->f("OT_APP_BY")));
    }
//End SetValues Method

//Insert Method @2-7EE75EEA
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["record_id"]["Value"] = $this->record_id->GetDBValue(true);
        $this->InsertFields["ORDER_NO"]["Value"] = $this->ORDER_NO->GetDBValue(true);
        $this->InsertFields["emp_id"]["Value"] = $this->emp_id->GetDBValue(true);
        $this->InsertFields["service_date_day"]["Value"] = $this->service_date_day->GetDBValue(true);
        $this->InsertFields["FOLLOW_UP"]["Value"] = $this->FOLLOW_UP->GetDBValue(true);
        $this->InsertFields["AGENT_EVAL_TECH"]["Value"] = $this->AGENT_EVAL_TECH->GetDBValue(true);
        $this->InsertFields["PORT_FEE_ID"]["Value"] = $this->PORT_FEE_ID->GetDBValue(true);
        $this->InsertFields["TRANSPORT_FEE_ID"]["Value"] = $this->TRANSPORT_FEE_ID->GetDBValue(true);
        $this->InsertFields["WE_WO"]["Value"] = $this->WE_WO->GetDBValue(true);
        $this->InsertFields["service_date_month"]["Value"] = $this->service_date_month->GetDBValue(true);
        $this->InsertFields["service_date_year"]["Value"] = $this->service_date_year->GetDBValue(true);
        $this->InsertFields["PORT_ID"]["Value"] = $this->PORT_ID->GetDBValue(true);
        $this->InsertFields["NT_TEC_WO"]["Value"] = $this->NT_TEC_WO->GetDBValue(true);
        $this->InsertFields["NT_TEC_WA"]["Value"] = $this->NT_TEC_WA->GetDBValue(true);
        $this->InsertFields["NT_TEC_TR"]["Value"] = $this->NT_TEC_TR->GetDBValue(true);
        $this->InsertFields["OT_INV_WO"]["Value"] = $this->OT_INV_WO->GetDBValue(true);
        $this->InsertFields["OT_INV_WA"]["Value"] = $this->OT_INV_WA->GetDBValue(true);
        $this->InsertFields["OT_INV_TR"]["Value"] = $this->OT_INV_TR->GetDBValue(true);
        $this->InsertFields["OT_TEC_WO"]["Value"] = $this->OT_TEC_WO->GetDBValue(true);
        $this->InsertFields["OT_TEC_WA"]["Value"] = $this->OT_TEC_WA->GetDBValue(true);
        $this->InsertFields["OT_TEC_TR"]["Value"] = $this->OT_TEC_TR->GetDBValue(true);
        $this->InsertFields["ND_WO"]["Value"] = $this->ND_WO->GetDBValue(true);
        $this->InsertFields["ND_WA"]["Value"] = $this->ND_WA->GetDBValue(true);
        $this->InsertFields["ND_TR"]["Value"] = $this->ND_TR->GetDBValue(true);
        $this->InsertFields["WE_WA"]["Value"] = $this->WE_WA->GetDBValue(true);
        $this->InsertFields["WE_TR"]["Value"] = $this->WE_TR->GetDBValue(true);
        $this->InsertFields["NT_INV_WO"]["Value"] = $this->NT_INV_WO->GetDBValue(true);
        $this->InsertFields["NT_INV_WA"]["Value"] = $this->NT_INV_WA->GetDBValue(true);
        $this->InsertFields["NT_INV_TR"]["Value"] = $this->NT_INV_TR->GetDBValue(true);
        $this->InsertFields["NT_APP_BY"]["Value"] = $this->NT_APP_BY->GetDBValue(true);
        $this->InsertFields["OT_APP_BY"]["Value"] = $this->OT_APP_BY->GetDBValue(true);
        $this->SQL = CCBuildInsert("after_service_tbl", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-B6AF1B53
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["record_id"]["Value"] = $this->record_id->GetDBValue(true);
        $this->UpdateFields["ORDER_NO"]["Value"] = $this->ORDER_NO->GetDBValue(true);
        $this->UpdateFields["emp_id"]["Value"] = $this->emp_id->GetDBValue(true);
        $this->UpdateFields["service_date_day"]["Value"] = $this->service_date_day->GetDBValue(true);
        $this->UpdateFields["FOLLOW_UP"]["Value"] = $this->FOLLOW_UP->GetDBValue(true);
        $this->UpdateFields["AGENT_EVAL_TECH"]["Value"] = $this->AGENT_EVAL_TECH->GetDBValue(true);
        $this->UpdateFields["PORT_FEE_ID"]["Value"] = $this->PORT_FEE_ID->GetDBValue(true);
        $this->UpdateFields["TRANSPORT_FEE_ID"]["Value"] = $this->TRANSPORT_FEE_ID->GetDBValue(true);
        $this->UpdateFields["WE_WO"]["Value"] = $this->WE_WO->GetDBValue(true);
        $this->UpdateFields["service_date_month"]["Value"] = $this->service_date_month->GetDBValue(true);
        $this->UpdateFields["service_date_year"]["Value"] = $this->service_date_year->GetDBValue(true);
        $this->UpdateFields["PORT_ID"]["Value"] = $this->PORT_ID->GetDBValue(true);
        $this->UpdateFields["NT_TEC_WO"]["Value"] = $this->NT_TEC_WO->GetDBValue(true);
        $this->UpdateFields["NT_TEC_WA"]["Value"] = $this->NT_TEC_WA->GetDBValue(true);
        $this->UpdateFields["NT_TEC_TR"]["Value"] = $this->NT_TEC_TR->GetDBValue(true);
        $this->UpdateFields["OT_INV_WO"]["Value"] = $this->OT_INV_WO->GetDBValue(true);
        $this->UpdateFields["OT_INV_WA"]["Value"] = $this->OT_INV_WA->GetDBValue(true);
        $this->UpdateFields["OT_INV_TR"]["Value"] = $this->OT_INV_TR->GetDBValue(true);
        $this->UpdateFields["OT_TEC_WO"]["Value"] = $this->OT_TEC_WO->GetDBValue(true);
        $this->UpdateFields["OT_TEC_WA"]["Value"] = $this->OT_TEC_WA->GetDBValue(true);
        $this->UpdateFields["OT_TEC_TR"]["Value"] = $this->OT_TEC_TR->GetDBValue(true);
        $this->UpdateFields["ND_WO"]["Value"] = $this->ND_WO->GetDBValue(true);
        $this->UpdateFields["ND_WA"]["Value"] = $this->ND_WA->GetDBValue(true);
        $this->UpdateFields["ND_TR"]["Value"] = $this->ND_TR->GetDBValue(true);
        $this->UpdateFields["WE_WA"]["Value"] = $this->WE_WA->GetDBValue(true);
        $this->UpdateFields["WE_TR"]["Value"] = $this->WE_TR->GetDBValue(true);
        $this->UpdateFields["NT_INV_WO"]["Value"] = $this->NT_INV_WO->GetDBValue(true);
        $this->UpdateFields["NT_INV_WA"]["Value"] = $this->NT_INV_WA->GetDBValue(true);
        $this->UpdateFields["NT_INV_TR"]["Value"] = $this->NT_INV_TR->GetDBValue(true);
        $this->UpdateFields["NT_APP_BY"]["Value"] = $this->NT_APP_BY->GetDBValue(true);
        $this->UpdateFields["OT_APP_BY"]["Value"] = $this->OT_APP_BY->GetDBValue(true);
        $this->SQL = CCBuildUpdate("after_service_tbl", $this->UpdateFields, $this);
        $this->SQL .= strlen($this->Where) ? " WHERE " . $this->Where : $this->Where;
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End after_service_tblDataSource Class @2-FCB6E20C

//Initialize Page @1-DDD8FB25
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
$TemplateFileName = "page9.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-A8F8D809
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$after_service_tbl = new clsRecordafter_service_tbl("", $MainPage);
$MainPage->after_service_tbl = & $after_service_tbl;
$after_service_tbl->Initialize();

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

//Execute Components @1-69F03B37
$after_service_tbl->Operation();
//End Execute Components

//Go to destination page @1-75EB73D5
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($after_service_tbl);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-1DC2861E
$after_service_tbl->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-D025FEEB
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($after_service_tbl);
unset($Tpl);
//End Unload Page


?>
