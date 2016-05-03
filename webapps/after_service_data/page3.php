<?php
//Include Common Files @1-D03BE905
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page3.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordafter_service_tbl { //after_service_tbl Class @2-5925C991

//Variables @2-D6FF3E86

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

//Class_Initialize Event @2-C67A16F8
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
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = & new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = & new clsButton("Button_Update", $Method, $this);
            $this->Button_Cancel = & new clsButton("Button_Cancel", $Method, $this);
            $this->record_id = & new clsControl(ccsHidden, "record_id", "Record Id", ccsInteger, "", CCGetRequestParam("record_id", $Method, NULL), $this);
            $this->emp_id = & new clsControl(ccsListBox, "emp_id", "Emp Id", ccsInteger, "", CCGetRequestParam("emp_id", $Method, NULL), $this);
            $this->emp_id->DSType = dsTable;
            $this->emp_id->DataSource = new clsDBhss_db();
            $this->emp_id->ds = & $this->emp_id->DataSource;
            $this->emp_id->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->emp_id->BoundColumn, $this->emp_id->TextColumn, $this->emp_id->DBFormat) = array("emp_id", "emp_login", "");
            $this->emp_id->Required = true;
            $this->service_date_day = & new clsControl(ccsListBox, "service_date_day", "Service Date Day", ccsText, "", CCGetRequestParam("service_date_day", $Method, NULL), $this);
            $this->service_date_day->DSType = dsTable;
            $this->service_date_day->DataSource = new clsDBhss_db();
            $this->service_date_day->ds = & $this->service_date_day->DataSource;
            $this->service_date_day->DataSource->SQL = "SELECT * \n" .
"FROM days_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->service_date_day->BoundColumn, $this->service_date_day->TextColumn, $this->service_date_day->DBFormat) = array("days", "days", "");
            $this->service_date_day->Required = true;
            $this->TIME_OFF = & new clsControl(ccsTextBox, "TIME_OFF", "TIME OFF", ccsText, "", CCGetRequestParam("TIME_OFF", $Method, NULL), $this);
            $this->TIME_OFF->Required = true;
            $this->SICKNESS_TIME_OFF = & new clsControl(ccsTextBox, "SICKNESS_TIME_OFF", "SICKNESS TIME OFF", ccsText, "", CCGetRequestParam("SICKNESS_TIME_OFF", $Method, NULL), $this);
            $this->SICKNESS_TIME_OFF->Required = true;
            $this->service_date_month = & new clsControl(ccsListBox, "service_date_month", "Service Date Month", ccsText, "", CCGetRequestParam("service_date_month", $Method, NULL), $this);
            $this->service_date_month->DSType = dsTable;
            $this->service_date_month->DataSource = new clsDBhss_db();
            $this->service_date_month->ds = & $this->service_date_month->DataSource;
            $this->service_date_month->DataSource->SQL = "SELECT * \n" .
"FROM months_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->service_date_month->BoundColumn, $this->service_date_month->TextColumn, $this->service_date_month->DBFormat) = array("months", "months", "");
            $this->service_date_month->Required = true;
            $this->service_date_year = & new clsControl(ccsTextBox, "service_date_year", "Service Date Year", ccsText, "", CCGetRequestParam("service_date_year", $Method, NULL), $this);
            $this->service_date_year->Required = true;
            $this->ORDER_NO = & new clsControl(ccsHidden, "ORDER_NO", "ORDER_NO", ccsText, "", CCGetRequestParam("ORDER_NO", $Method, NULL), $this);
            $this->PORT_ID = & new clsControl(ccsHidden, "PORT_ID", "PORT_ID", ccsText, "", CCGetRequestParam("PORT_ID", $Method, NULL), $this);
            $this->FOLLOW_UP = & new clsControl(ccsHidden, "FOLLOW_UP", "FOLLOW_UP", ccsText, "", CCGetRequestParam("FOLLOW_UP", $Method, NULL), $this);
            $this->AGENT_EVAL_TECH = & new clsControl(ccsHidden, "AGENT_EVAL_TECH", "AGENT_EVAL_TECH", ccsText, "", CCGetRequestParam("AGENT_EVAL_TECH", $Method, NULL), $this);
            $this->PORT_FEE_ID = & new clsControl(ccsHidden, "PORT_FEE_ID", "PORT_FEE_ID", ccsText, "", CCGetRequestParam("PORT_FEE_ID", $Method, NULL), $this);
            $this->TRANSPORT_FEE_ID = & new clsControl(ccsHidden, "TRANSPORT_FEE_ID", "TRANSPORT_FEE_ID", ccsText, "", CCGetRequestParam("TRANSPORT_FEE_ID", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->TIME_OFF->Value) && !strlen($this->TIME_OFF->Value) && $this->TIME_OFF->Value !== false)
                    $this->TIME_OFF->SetText(0);
                if(!is_array($this->SICKNESS_TIME_OFF->Value) && !strlen($this->SICKNESS_TIME_OFF->Value) && $this->SICKNESS_TIME_OFF->Value !== false)
                    $this->SICKNESS_TIME_OFF->SetText(0);
                if(!is_array($this->service_date_year->Value) && !strlen($this->service_date_year->Value) && $this->service_date_year->Value !== false)
                    $this->service_date_year->SetText(2009);
                if(!is_array($this->ORDER_NO->Value) && !strlen($this->ORDER_NO->Value) && $this->ORDER_NO->Value !== false)
                    $this->ORDER_NO->SetText(TO_SK);
                if(!is_array($this->PORT_ID->Value) && !strlen($this->PORT_ID->Value) && $this->PORT_ID->Value !== false)
                    $this->PORT_ID->SetText(68);
                if(!is_array($this->FOLLOW_UP->Value) && !strlen($this->FOLLOW_UP->Value) && $this->FOLLOW_UP->Value !== false)
                    $this->FOLLOW_UP->SetText(_);
                if(!is_array($this->AGENT_EVAL_TECH->Value) && !strlen($this->AGENT_EVAL_TECH->Value) && $this->AGENT_EVAL_TECH->Value !== false)
                    $this->AGENT_EVAL_TECH->SetText(_);
                if(!is_array($this->PORT_FEE_ID->Value) && !strlen($this->PORT_FEE_ID->Value) && $this->PORT_FEE_ID->Value !== false)
                    $this->PORT_FEE_ID->SetText(1);
                if(!is_array($this->TRANSPORT_FEE_ID->Value) && !strlen($this->TRANSPORT_FEE_ID->Value) && $this->TRANSPORT_FEE_ID->Value !== false)
                    $this->TRANSPORT_FEE_ID->SetText(9);
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

//Validate Method @2-F16161C3
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->record_id->Validate() && $Validation);
        $Validation = ($this->emp_id->Validate() && $Validation);
        $Validation = ($this->service_date_day->Validate() && $Validation);
        $Validation = ($this->TIME_OFF->Validate() && $Validation);
        $Validation = ($this->SICKNESS_TIME_OFF->Validate() && $Validation);
        $Validation = ($this->service_date_month->Validate() && $Validation);
        $Validation = ($this->service_date_year->Validate() && $Validation);
        $Validation = ($this->ORDER_NO->Validate() && $Validation);
        $Validation = ($this->PORT_ID->Validate() && $Validation);
        $Validation = ($this->FOLLOW_UP->Validate() && $Validation);
        $Validation = ($this->AGENT_EVAL_TECH->Validate() && $Validation);
        $Validation = ($this->PORT_FEE_ID->Validate() && $Validation);
        $Validation = ($this->TRANSPORT_FEE_ID->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->record_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->emp_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->service_date_day->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TIME_OFF->Errors->Count() == 0);
        $Validation =  $Validation && ($this->SICKNESS_TIME_OFF->Errors->Count() == 0);
        $Validation =  $Validation && ($this->service_date_month->Errors->Count() == 0);
        $Validation =  $Validation && ($this->service_date_year->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ORDER_NO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->PORT_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->FOLLOW_UP->Errors->Count() == 0);
        $Validation =  $Validation && ($this->AGENT_EVAL_TECH->Errors->Count() == 0);
        $Validation =  $Validation && ($this->PORT_FEE_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TRANSPORT_FEE_ID->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-11ED3016
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->record_id->Errors->Count());
        $errors = ($errors || $this->emp_id->Errors->Count());
        $errors = ($errors || $this->service_date_day->Errors->Count());
        $errors = ($errors || $this->TIME_OFF->Errors->Count());
        $errors = ($errors || $this->SICKNESS_TIME_OFF->Errors->Count());
        $errors = ($errors || $this->service_date_month->Errors->Count());
        $errors = ($errors || $this->service_date_year->Errors->Count());
        $errors = ($errors || $this->ORDER_NO->Errors->Count());
        $errors = ($errors || $this->PORT_ID->Errors->Count());
        $errors = ($errors || $this->FOLLOW_UP->Errors->Count());
        $errors = ($errors || $this->AGENT_EVAL_TECH->Errors->Count());
        $errors = ($errors || $this->PORT_FEE_ID->Errors->Count());
        $errors = ($errors || $this->TRANSPORT_FEE_ID->Errors->Count());
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

//Operation Method @2-F6E3F136
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
            $Redirect = "page0.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
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

//InsertRow Method @2-4E9CD957
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->record_id->SetValue($this->record_id->GetValue(true));
        $this->DataSource->emp_id->SetValue($this->emp_id->GetValue(true));
        $this->DataSource->service_date_day->SetValue($this->service_date_day->GetValue(true));
        $this->DataSource->TIME_OFF->SetValue($this->TIME_OFF->GetValue(true));
        $this->DataSource->SICKNESS_TIME_OFF->SetValue($this->SICKNESS_TIME_OFF->GetValue(true));
        $this->DataSource->service_date_month->SetValue($this->service_date_month->GetValue(true));
        $this->DataSource->service_date_year->SetValue($this->service_date_year->GetValue(true));
        $this->DataSource->ORDER_NO->SetValue($this->ORDER_NO->GetValue(true));
        $this->DataSource->PORT_ID->SetValue($this->PORT_ID->GetValue(true));
        $this->DataSource->FOLLOW_UP->SetValue($this->FOLLOW_UP->GetValue(true));
        $this->DataSource->AGENT_EVAL_TECH->SetValue($this->AGENT_EVAL_TECH->GetValue(true));
        $this->DataSource->PORT_FEE_ID->SetValue($this->PORT_FEE_ID->GetValue(true));
        $this->DataSource->TRANSPORT_FEE_ID->SetValue($this->TRANSPORT_FEE_ID->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-0C24D17B
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->record_id->SetValue($this->record_id->GetValue(true));
        $this->DataSource->emp_id->SetValue($this->emp_id->GetValue(true));
        $this->DataSource->service_date_day->SetValue($this->service_date_day->GetValue(true));
        $this->DataSource->TIME_OFF->SetValue($this->TIME_OFF->GetValue(true));
        $this->DataSource->SICKNESS_TIME_OFF->SetValue($this->SICKNESS_TIME_OFF->GetValue(true));
        $this->DataSource->service_date_month->SetValue($this->service_date_month->GetValue(true));
        $this->DataSource->service_date_year->SetValue($this->service_date_year->GetValue(true));
        $this->DataSource->ORDER_NO->SetValue($this->ORDER_NO->GetValue(true));
        $this->DataSource->PORT_ID->SetValue($this->PORT_ID->GetValue(true));
        $this->DataSource->FOLLOW_UP->SetValue($this->FOLLOW_UP->GetValue(true));
        $this->DataSource->AGENT_EVAL_TECH->SetValue($this->AGENT_EVAL_TECH->GetValue(true));
        $this->DataSource->PORT_FEE_ID->SetValue($this->PORT_FEE_ID->GetValue(true));
        $this->DataSource->TRANSPORT_FEE_ID->SetValue($this->TRANSPORT_FEE_ID->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-ECAC7189
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
        $this->service_date_month->Prepare();

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
                    $this->emp_id->SetValue($this->DataSource->emp_id->GetValue());
                    $this->service_date_day->SetValue($this->DataSource->service_date_day->GetValue());
                    $this->TIME_OFF->SetValue($this->DataSource->TIME_OFF->GetValue());
                    $this->SICKNESS_TIME_OFF->SetValue($this->DataSource->SICKNESS_TIME_OFF->GetValue());
                    $this->service_date_month->SetValue($this->DataSource->service_date_month->GetValue());
                    $this->service_date_year->SetValue($this->DataSource->service_date_year->GetValue());
                    $this->ORDER_NO->SetValue($this->DataSource->ORDER_NO->GetValue());
                    $this->PORT_ID->SetValue($this->DataSource->PORT_ID->GetValue());
                    $this->FOLLOW_UP->SetValue($this->DataSource->FOLLOW_UP->GetValue());
                    $this->AGENT_EVAL_TECH->SetValue($this->DataSource->AGENT_EVAL_TECH->GetValue());
                    $this->PORT_FEE_ID->SetValue($this->DataSource->PORT_FEE_ID->GetValue());
                    $this->TRANSPORT_FEE_ID->SetValue($this->DataSource->TRANSPORT_FEE_ID->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->record_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->emp_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->service_date_day->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TIME_OFF->Errors->ToString());
            $Error = ComposeStrings($Error, $this->SICKNESS_TIME_OFF->Errors->ToString());
            $Error = ComposeStrings($Error, $this->service_date_month->Errors->ToString());
            $Error = ComposeStrings($Error, $this->service_date_year->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ORDER_NO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->PORT_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->FOLLOW_UP->Errors->ToString());
            $Error = ComposeStrings($Error, $this->AGENT_EVAL_TECH->Errors->ToString());
            $Error = ComposeStrings($Error, $this->PORT_FEE_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TRANSPORT_FEE_ID->Errors->ToString());
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
        $this->emp_id->Show();
        $this->service_date_day->Show();
        $this->TIME_OFF->Show();
        $this->SICKNESS_TIME_OFF->Show();
        $this->service_date_month->Show();
        $this->service_date_year->Show();
        $this->ORDER_NO->Show();
        $this->PORT_ID->Show();
        $this->FOLLOW_UP->Show();
        $this->AGENT_EVAL_TECH->Show();
        $this->PORT_FEE_ID->Show();
        $this->TRANSPORT_FEE_ID->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End after_service_tbl Class @2-FCB6E20C

class clsafter_service_tblDataSource extends clsDBhss_db {  //after_service_tblDataSource Class @2-A5ADE14F

//DataSource Variables @2-EA787BE5
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $InsertParameters;
    var $UpdateParameters;
    var $wp;
    var $AllParametersSet;

    var $InsertFields = array();
    var $UpdateFields = array();

    // Datasource fields
    var $record_id;
    var $emp_id;
    var $service_date_day;
    var $TIME_OFF;
    var $SICKNESS_TIME_OFF;
    var $service_date_month;
    var $service_date_year;
    var $ORDER_NO;
    var $PORT_ID;
    var $FOLLOW_UP;
    var $AGENT_EVAL_TECH;
    var $PORT_FEE_ID;
    var $TRANSPORT_FEE_ID;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-38BA9536
    function clsafter_service_tblDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record after_service_tbl/Error";
        $this->Initialize();
        $this->record_id = new clsField("record_id", ccsInteger, "");
        
        $this->emp_id = new clsField("emp_id", ccsInteger, "");
        
        $this->service_date_day = new clsField("service_date_day", ccsText, "");
        
        $this->TIME_OFF = new clsField("TIME_OFF", ccsText, "");
        
        $this->SICKNESS_TIME_OFF = new clsField("SICKNESS_TIME_OFF", ccsText, "");
        
        $this->service_date_month = new clsField("service_date_month", ccsText, "");
        
        $this->service_date_year = new clsField("service_date_year", ccsText, "");
        
        $this->ORDER_NO = new clsField("ORDER_NO", ccsText, "");
        
        $this->PORT_ID = new clsField("PORT_ID", ccsText, "");
        
        $this->FOLLOW_UP = new clsField("FOLLOW_UP", ccsText, "");
        
        $this->AGENT_EVAL_TECH = new clsField("AGENT_EVAL_TECH", ccsText, "");
        
        $this->PORT_FEE_ID = new clsField("PORT_FEE_ID", ccsText, "");
        
        $this->TRANSPORT_FEE_ID = new clsField("TRANSPORT_FEE_ID", ccsText, "");
        

        $this->InsertFields["record_id"] = array("Name" => "record_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["emp_id"] = array("Name" => "emp_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["service_date_day"] = array("Name" => "service_date_day", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["TIME_OFF"] = array("Name" => "TIME_OFF", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["SICKNESS_TIME_OFF"] = array("Name" => "SICKNESS_TIME_OFF", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["service_date_month"] = array("Name" => "service_date_month", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["service_date_year"] = array("Name" => "service_date_year", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["ORDER_NO"] = array("Name" => "ORDER_NO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["PORT_ID"] = array("Name" => "PORT_ID", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["FOLLOW_UP"] = array("Name" => "FOLLOW_UP", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["AGENT_EVAL_TECH"] = array("Name" => "AGENT_EVAL_TECH", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["PORT_FEE_ID"] = array("Name" => "PORT_FEE_ID", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["TRANSPORT_FEE_ID"] = array("Name" => "TRANSPORT_FEE_ID", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["record_id"] = array("Name" => "record_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["emp_id"] = array("Name" => "emp_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["service_date_day"] = array("Name" => "service_date_day", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["TIME_OFF"] = array("Name" => "TIME_OFF", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["SICKNESS_TIME_OFF"] = array("Name" => "SICKNESS_TIME_OFF", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["service_date_month"] = array("Name" => "service_date_month", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["service_date_year"] = array("Name" => "service_date_year", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["ORDER_NO"] = array("Name" => "ORDER_NO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["PORT_ID"] = array("Name" => "PORT_ID", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["FOLLOW_UP"] = array("Name" => "FOLLOW_UP", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["AGENT_EVAL_TECH"] = array("Name" => "AGENT_EVAL_TECH", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["PORT_FEE_ID"] = array("Name" => "PORT_FEE_ID", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["TRANSPORT_FEE_ID"] = array("Name" => "TRANSPORT_FEE_ID", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
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

//SetValues Method @2-382EF982
    function SetValues()
    {
        $this->record_id->SetDBValue(trim($this->f("record_id")));
        $this->emp_id->SetDBValue(trim($this->f("emp_id")));
        $this->service_date_day->SetDBValue($this->f("service_date_day"));
        $this->TIME_OFF->SetDBValue($this->f("TIME_OFF"));
        $this->SICKNESS_TIME_OFF->SetDBValue($this->f("SICKNESS_TIME_OFF"));
        $this->service_date_month->SetDBValue($this->f("service_date_month"));
        $this->service_date_year->SetDBValue($this->f("service_date_year"));
        $this->ORDER_NO->SetDBValue($this->f("ORDER_NO"));
        $this->PORT_ID->SetDBValue($this->f("PORT_ID"));
        $this->FOLLOW_UP->SetDBValue($this->f("FOLLOW_UP"));
        $this->AGENT_EVAL_TECH->SetDBValue($this->f("AGENT_EVAL_TECH"));
        $this->PORT_FEE_ID->SetDBValue($this->f("PORT_FEE_ID"));
        $this->TRANSPORT_FEE_ID->SetDBValue($this->f("TRANSPORT_FEE_ID"));
    }
//End SetValues Method

//Insert Method @2-ED7E9CBC
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["record_id"]["Value"] = $this->record_id->GetDBValue(true);
        $this->InsertFields["emp_id"]["Value"] = $this->emp_id->GetDBValue(true);
        $this->InsertFields["service_date_day"]["Value"] = $this->service_date_day->GetDBValue(true);
        $this->InsertFields["TIME_OFF"]["Value"] = $this->TIME_OFF->GetDBValue(true);
        $this->InsertFields["SICKNESS_TIME_OFF"]["Value"] = $this->SICKNESS_TIME_OFF->GetDBValue(true);
        $this->InsertFields["service_date_month"]["Value"] = $this->service_date_month->GetDBValue(true);
        $this->InsertFields["service_date_year"]["Value"] = $this->service_date_year->GetDBValue(true);
        $this->InsertFields["ORDER_NO"]["Value"] = $this->ORDER_NO->GetDBValue(true);
        $this->InsertFields["PORT_ID"]["Value"] = $this->PORT_ID->GetDBValue(true);
        $this->InsertFields["FOLLOW_UP"]["Value"] = $this->FOLLOW_UP->GetDBValue(true);
        $this->InsertFields["AGENT_EVAL_TECH"]["Value"] = $this->AGENT_EVAL_TECH->GetDBValue(true);
        $this->InsertFields["PORT_FEE_ID"]["Value"] = $this->PORT_FEE_ID->GetDBValue(true);
        $this->InsertFields["TRANSPORT_FEE_ID"]["Value"] = $this->TRANSPORT_FEE_ID->GetDBValue(true);
        $this->SQL = CCBuildInsert("after_service_tbl", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-8320C8E3
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["record_id"]["Value"] = $this->record_id->GetDBValue(true);
        $this->UpdateFields["emp_id"]["Value"] = $this->emp_id->GetDBValue(true);
        $this->UpdateFields["service_date_day"]["Value"] = $this->service_date_day->GetDBValue(true);
        $this->UpdateFields["TIME_OFF"]["Value"] = $this->TIME_OFF->GetDBValue(true);
        $this->UpdateFields["SICKNESS_TIME_OFF"]["Value"] = $this->SICKNESS_TIME_OFF->GetDBValue(true);
        $this->UpdateFields["service_date_month"]["Value"] = $this->service_date_month->GetDBValue(true);
        $this->UpdateFields["service_date_year"]["Value"] = $this->service_date_year->GetDBValue(true);
        $this->UpdateFields["ORDER_NO"]["Value"] = $this->ORDER_NO->GetDBValue(true);
        $this->UpdateFields["PORT_ID"]["Value"] = $this->PORT_ID->GetDBValue(true);
        $this->UpdateFields["FOLLOW_UP"]["Value"] = $this->FOLLOW_UP->GetDBValue(true);
        $this->UpdateFields["AGENT_EVAL_TECH"]["Value"] = $this->AGENT_EVAL_TECH->GetDBValue(true);
        $this->UpdateFields["PORT_FEE_ID"]["Value"] = $this->PORT_FEE_ID->GetDBValue(true);
        $this->UpdateFields["TRANSPORT_FEE_ID"]["Value"] = $this->TRANSPORT_FEE_ID->GetDBValue(true);
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

//Initialize Page @1-DE4AD8DD
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
$TemplateFileName = "page3.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-F06F9F88
CCSecurityRedirect("1;2;3;4", "login.php");
//End Authenticate User

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-FDFBE0A0
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$after_service_tbl = & new clsRecordafter_service_tbl("", $MainPage);
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
