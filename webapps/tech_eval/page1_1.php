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

class clsRecordtech_eval { //tech_eval Class @2-23240E51

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

//Class_Initialize Event @2-83DBADAC
    function clsRecordtech_eval($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record tech_eval/Error";
        $this->DataSource = new clstech_evalDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "tech_eval";
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
            $this->Button_Delete = & new clsButton("Button_Delete", $Method, $this);
            $this->Button_Cancel = & new clsButton("Button_Cancel", $Method, $this);
            $this->ORDER_NO = & new clsControl(ccsTextBox, "ORDER_NO", "ORDER NO", ccsText, "", CCGetRequestParam("ORDER_NO", $Method, NULL), $this);
            $this->ORDER_NO->Required = true;
            $this->tech_id = & new clsControl(ccsListBox, "tech_id", "Tech Id", ccsInteger, "", CCGetRequestParam("tech_id", $Method, NULL), $this);
            $this->tech_id->DSType = dsTable;
            $this->tech_id->DataSource = new clsDBhss_db();
            $this->tech_id->ds = & $this->tech_id->DataSource;
            $this->tech_id->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->tech_id->BoundColumn, $this->tech_id->TextColumn, $this->tech_id->DBFormat) = array("emp_id", "emp_login", "");
            $this->tech_id->Required = true;
            $this->service_date_day = & new clsControl(ccsListBox, "service_date_day", "Service Date Day", ccsText, "", CCGetRequestParam("service_date_day", $Method, NULL), $this);
            $this->service_date_day->DSType = dsTable;
            $this->service_date_day->DataSource = new clsDBhss_db();
            $this->service_date_day->ds = & $this->service_date_day->DataSource;
            $this->service_date_day->DataSource->SQL = "SELECT * \n" .
"FROM days_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->service_date_day->BoundColumn, $this->service_date_day->TextColumn, $this->service_date_day->DBFormat) = array("days", "days", "");
            $this->service_date_day->Required = true;
            $this->performance = & new clsControl(ccsListBox, "performance", "Performance", ccsInteger, "", CCGetRequestParam("performance", $Method, NULL), $this);
            $this->performance->DSType = dsTable;
            $this->performance->DataSource = new clsDBhss_db();
            $this->performance->ds = & $this->performance->DataSource;
            $this->performance->DataSource->SQL = "SELECT * \n" .
"FROM tech_eval_values {SQL_Where} {SQL_OrderBy}";
            list($this->performance->BoundColumn, $this->performance->TextColumn, $this->performance->DBFormat) = array("tech_eval_value_id", "tech_eval_value", "");
            $this->performance->Required = true;
            $this->coordination = & new clsControl(ccsListBox, "coordination", "Coordination", ccsInteger, "", CCGetRequestParam("coordination", $Method, NULL), $this);
            $this->coordination->DSType = dsTable;
            $this->coordination->DataSource = new clsDBhss_db();
            $this->coordination->ds = & $this->coordination->DataSource;
            $this->coordination->DataSource->SQL = "SELECT * \n" .
"FROM tech_eval_values {SQL_Where} {SQL_OrderBy}";
            list($this->coordination->BoundColumn, $this->coordination->TextColumn, $this->coordination->DBFormat) = array("tech_eval_value_id", "tech_eval_value", "");
            $this->coordination->Required = true;
            $this->accomplishment = & new clsControl(ccsListBox, "accomplishment", "Accomplishment", ccsInteger, "", CCGetRequestParam("accomplishment", $Method, NULL), $this);
            $this->accomplishment->DSType = dsTable;
            $this->accomplishment->DataSource = new clsDBhss_db();
            $this->accomplishment->ds = & $this->accomplishment->DataSource;
            $this->accomplishment->DataSource->SQL = "SELECT * \n" .
"FROM tech_eval_values {SQL_Where} {SQL_OrderBy}";
            list($this->accomplishment->BoundColumn, $this->accomplishment->TextColumn, $this->accomplishment->DBFormat) = array("tech_eval_value_id", "tech_eval_value", "");
            $this->accomplishment->Required = true;
            $this->quality = & new clsControl(ccsListBox, "quality", "Quality", ccsInteger, "", CCGetRequestParam("quality", $Method, NULL), $this);
            $this->quality->DSType = dsTable;
            $this->quality->DataSource = new clsDBhss_db();
            $this->quality->ds = & $this->quality->DataSource;
            $this->quality->DataSource->SQL = "SELECT * \n" .
"FROM tech_eval_values {SQL_Where} {SQL_OrderBy}";
            list($this->quality->BoundColumn, $this->quality->TextColumn, $this->quality->DBFormat) = array("tech_eval_value_id", "tech_eval_value", "");
            $this->quality->Required = true;
            $this->comments = & new clsControl(ccsTextArea, "comments", "Comments", ccsMemo, "", CCGetRequestParam("comments", $Method, NULL), $this);
            $this->service_date_month = & new clsControl(ccsListBox, "service_date_month", "Service Date Month", ccsText, "", CCGetRequestParam("service_date_month", $Method, NULL), $this);
            $this->service_date_month->DSType = dsTable;
            $this->service_date_month->DataSource = new clsDBhss_db();
            $this->service_date_month->ds = & $this->service_date_month->DataSource;
            $this->service_date_month->DataSource->SQL = "SELECT * \n" .
"FROM months_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->service_date_month->BoundColumn, $this->service_date_month->TextColumn, $this->service_date_month->DBFormat) = array("months", "months", "");
            $this->service_date_month->Required = true;
            $this->service_date_year = & new clsControl(ccsListBox, "service_date_year", "Service Date Year", ccsText, "", CCGetRequestParam("service_date_year", $Method, NULL), $this);
            $this->service_date_year->DSType = dsTable;
            $this->service_date_year->DataSource = new clsDBhss_db();
            $this->service_date_year->ds = & $this->service_date_year->DataSource;
            $this->service_date_year->DataSource->SQL = "SELECT * \n" .
"FROM years_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->service_date_year->BoundColumn, $this->service_date_year->TextColumn, $this->service_date_year->DBFormat) = array("years", "years", "");
            $this->service_date_year->Required = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @2-5E30CF83
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlevaluation_id"] = CCGetFromGet("evaluation_id", NULL);
    }
//End Initialize Method

//Validate Method @2-8B905DF4
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->ORDER_NO->Validate() && $Validation);
        $Validation = ($this->tech_id->Validate() && $Validation);
        $Validation = ($this->service_date_day->Validate() && $Validation);
        $Validation = ($this->performance->Validate() && $Validation);
        $Validation = ($this->coordination->Validate() && $Validation);
        $Validation = ($this->accomplishment->Validate() && $Validation);
        $Validation = ($this->quality->Validate() && $Validation);
        $Validation = ($this->comments->Validate() && $Validation);
        $Validation = ($this->service_date_month->Validate() && $Validation);
        $Validation = ($this->service_date_year->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->ORDER_NO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tech_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->service_date_day->Errors->Count() == 0);
        $Validation =  $Validation && ($this->performance->Errors->Count() == 0);
        $Validation =  $Validation && ($this->coordination->Errors->Count() == 0);
        $Validation =  $Validation && ($this->accomplishment->Errors->Count() == 0);
        $Validation =  $Validation && ($this->quality->Errors->Count() == 0);
        $Validation =  $Validation && ($this->comments->Errors->Count() == 0);
        $Validation =  $Validation && ($this->service_date_month->Errors->Count() == 0);
        $Validation =  $Validation && ($this->service_date_year->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-7D7464B9
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->ORDER_NO->Errors->Count());
        $errors = ($errors || $this->tech_id->Errors->Count());
        $errors = ($errors || $this->service_date_day->Errors->Count());
        $errors = ($errors || $this->performance->Errors->Count());
        $errors = ($errors || $this->coordination->Errors->Count());
        $errors = ($errors || $this->accomplishment->Errors->Count());
        $errors = ($errors || $this->quality->Errors->Count());
        $errors = ($errors || $this->comments->Errors->Count());
        $errors = ($errors || $this->service_date_month->Errors->Count());
        $errors = ($errors || $this->service_date_year->Errors->Count());
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

//Operation Method @2-9082BA45
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
            } else if($this->Button_Delete->Pressed) {
                $this->PressedButton = "Button_Delete";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = "page1.php" . "?" . CCGetQueryString("All", array("ccsForm"));
        if($this->PressedButton == "Button_Delete") {
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
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

//InsertRow Method @2-F36D59EF
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->ORDER_NO->SetValue($this->ORDER_NO->GetValue(true));
        $this->DataSource->tech_id->SetValue($this->tech_id->GetValue(true));
        $this->DataSource->service_date_day->SetValue($this->service_date_day->GetValue(true));
        $this->DataSource->performance->SetValue($this->performance->GetValue(true));
        $this->DataSource->coordination->SetValue($this->coordination->GetValue(true));
        $this->DataSource->accomplishment->SetValue($this->accomplishment->GetValue(true));
        $this->DataSource->quality->SetValue($this->quality->GetValue(true));
        $this->DataSource->comments->SetValue($this->comments->GetValue(true));
        $this->DataSource->service_date_month->SetValue($this->service_date_month->GetValue(true));
        $this->DataSource->service_date_year->SetValue($this->service_date_year->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-86DBCB58
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->ORDER_NO->SetValue($this->ORDER_NO->GetValue(true));
        $this->DataSource->tech_id->SetValue($this->tech_id->GetValue(true));
        $this->DataSource->service_date_day->SetValue($this->service_date_day->GetValue(true));
        $this->DataSource->performance->SetValue($this->performance->GetValue(true));
        $this->DataSource->coordination->SetValue($this->coordination->GetValue(true));
        $this->DataSource->accomplishment->SetValue($this->accomplishment->GetValue(true));
        $this->DataSource->quality->SetValue($this->quality->GetValue(true));
        $this->DataSource->comments->SetValue($this->comments->GetValue(true));
        $this->DataSource->service_date_month->SetValue($this->service_date_month->GetValue(true));
        $this->DataSource->service_date_year->SetValue($this->service_date_year->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @2-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @2-D51F4F4C
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

        $this->tech_id->Prepare();
        $this->service_date_day->Prepare();
        $this->performance->Prepare();
        $this->coordination->Prepare();
        $this->accomplishment->Prepare();
        $this->quality->Prepare();
        $this->service_date_month->Prepare();
        $this->service_date_year->Prepare();

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
                    $this->ORDER_NO->SetValue($this->DataSource->ORDER_NO->GetValue());
                    $this->tech_id->SetValue($this->DataSource->tech_id->GetValue());
                    $this->service_date_day->SetValue($this->DataSource->service_date_day->GetValue());
                    $this->performance->SetValue($this->DataSource->performance->GetValue());
                    $this->coordination->SetValue($this->DataSource->coordination->GetValue());
                    $this->accomplishment->SetValue($this->DataSource->accomplishment->GetValue());
                    $this->quality->SetValue($this->DataSource->quality->GetValue());
                    $this->comments->SetValue($this->DataSource->comments->GetValue());
                    $this->service_date_month->SetValue($this->DataSource->service_date_month->GetValue());
                    $this->service_date_year->SetValue($this->DataSource->service_date_year->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->ORDER_NO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tech_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->service_date_day->Errors->ToString());
            $Error = ComposeStrings($Error, $this->performance->Errors->ToString());
            $Error = ComposeStrings($Error, $this->coordination->Errors->ToString());
            $Error = ComposeStrings($Error, $this->accomplishment->Errors->ToString());
            $Error = ComposeStrings($Error, $this->quality->Errors->ToString());
            $Error = ComposeStrings($Error, $this->comments->Errors->ToString());
            $Error = ComposeStrings($Error, $this->service_date_month->Errors->ToString());
            $Error = ComposeStrings($Error, $this->service_date_year->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        if($this->FormSubmitted || CCGetFromGet("ccsForm")) {
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        } else {
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("All", ""), "ccsForm", $CCSForm);
        }
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
        $this->Button_Insert->Visible = !$this->EditMode && $this->InsertAllowed;
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;
        $this->Button_Delete->Visible = $this->EditMode && $this->DeleteAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Delete->Show();
        $this->Button_Cancel->Show();
        $this->ORDER_NO->Show();
        $this->tech_id->Show();
        $this->service_date_day->Show();
        $this->performance->Show();
        $this->coordination->Show();
        $this->accomplishment->Show();
        $this->quality->Show();
        $this->comments->Show();
        $this->service_date_month->Show();
        $this->service_date_year->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End tech_eval Class @2-FCB6E20C

class clstech_evalDataSource extends clsDBhss_db {  //tech_evalDataSource Class @2-C566368A

//DataSource Variables @2-E50266DE
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $InsertParameters;
    var $UpdateParameters;
    var $DeleteParameters;
    var $wp;
    var $AllParametersSet;

    var $InsertFields = array();
    var $UpdateFields = array();

    // Datasource fields
    var $ORDER_NO;
    var $tech_id;
    var $service_date_day;
    var $performance;
    var $coordination;
    var $accomplishment;
    var $quality;
    var $comments;
    var $service_date_month;
    var $service_date_year;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-47B28DD4
    function clstech_evalDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record tech_eval/Error";
        $this->Initialize();
        $this->ORDER_NO = new clsField("ORDER_NO", ccsText, "");
        
        $this->tech_id = new clsField("tech_id", ccsInteger, "");
        
        $this->service_date_day = new clsField("service_date_day", ccsText, "");
        
        $this->performance = new clsField("performance", ccsInteger, "");
        
        $this->coordination = new clsField("coordination", ccsInteger, "");
        
        $this->accomplishment = new clsField("accomplishment", ccsInteger, "");
        
        $this->quality = new clsField("quality", ccsInteger, "");
        
        $this->comments = new clsField("comments", ccsMemo, "");
        
        $this->service_date_month = new clsField("service_date_month", ccsText, "");
        
        $this->service_date_year = new clsField("service_date_year", ccsText, "");
        

        $this->InsertFields["ORDER_NO"] = array("Name" => "ORDER_NO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tech_id"] = array("Name" => "tech_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["service_date_day"] = array("Name" => "service_date_day", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["performance"] = array("Name" => "performance", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["coordination"] = array("Name" => "coordination", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["accomplishment"] = array("Name" => "accomplishment", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["quality"] = array("Name" => "quality", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["comments"] = array("Name" => "comments", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->InsertFields["service_date_month"] = array("Name" => "service_date_month", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["service_date_year"] = array("Name" => "service_date_year", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["ORDER_NO"] = array("Name" => "ORDER_NO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tech_id"] = array("Name" => "tech_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["service_date_day"] = array("Name" => "service_date_day", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["performance"] = array("Name" => "performance", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["coordination"] = array("Name" => "coordination", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["accomplishment"] = array("Name" => "accomplishment", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["quality"] = array("Name" => "quality", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["comments"] = array("Name" => "comments", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->UpdateFields["service_date_month"] = array("Name" => "service_date_month", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["service_date_year"] = array("Name" => "service_date_year", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-3E841ED4
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlevaluation_id", ccsInteger, "", "", $this->Parameters["urlevaluation_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "evaluation_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-B1D9A7F9
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM tech_eval {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-B050C3B1
    function SetValues()
    {
        $this->ORDER_NO->SetDBValue($this->f("ORDER_NO"));
        $this->tech_id->SetDBValue(trim($this->f("tech_id")));
        $this->service_date_day->SetDBValue($this->f("service_date_day"));
        $this->performance->SetDBValue(trim($this->f("performance")));
        $this->coordination->SetDBValue(trim($this->f("coordination")));
        $this->accomplishment->SetDBValue(trim($this->f("accomplishment")));
        $this->quality->SetDBValue(trim($this->f("quality")));
        $this->comments->SetDBValue($this->f("comments"));
        $this->service_date_month->SetDBValue($this->f("service_date_month"));
        $this->service_date_year->SetDBValue($this->f("service_date_year"));
    }
//End SetValues Method

//Insert Method @2-253B62E2
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["ORDER_NO"]["Value"] = $this->ORDER_NO->GetDBValue(true);
        $this->InsertFields["tech_id"]["Value"] = $this->tech_id->GetDBValue(true);
        $this->InsertFields["service_date_day"]["Value"] = $this->service_date_day->GetDBValue(true);
        $this->InsertFields["performance"]["Value"] = $this->performance->GetDBValue(true);
        $this->InsertFields["coordination"]["Value"] = $this->coordination->GetDBValue(true);
        $this->InsertFields["accomplishment"]["Value"] = $this->accomplishment->GetDBValue(true);
        $this->InsertFields["quality"]["Value"] = $this->quality->GetDBValue(true);
        $this->InsertFields["comments"]["Value"] = $this->comments->GetDBValue(true);
        $this->InsertFields["service_date_month"]["Value"] = $this->service_date_month->GetDBValue(true);
        $this->InsertFields["service_date_year"]["Value"] = $this->service_date_year->GetDBValue(true);
        $this->SQL = CCBuildInsert("tech_eval", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-A63FB3F8
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["ORDER_NO"]["Value"] = $this->ORDER_NO->GetDBValue(true);
        $this->UpdateFields["tech_id"]["Value"] = $this->tech_id->GetDBValue(true);
        $this->UpdateFields["service_date_day"]["Value"] = $this->service_date_day->GetDBValue(true);
        $this->UpdateFields["performance"]["Value"] = $this->performance->GetDBValue(true);
        $this->UpdateFields["coordination"]["Value"] = $this->coordination->GetDBValue(true);
        $this->UpdateFields["accomplishment"]["Value"] = $this->accomplishment->GetDBValue(true);
        $this->UpdateFields["quality"]["Value"] = $this->quality->GetDBValue(true);
        $this->UpdateFields["comments"]["Value"] = $this->comments->GetDBValue(true);
        $this->UpdateFields["service_date_month"]["Value"] = $this->service_date_month->GetDBValue(true);
        $this->UpdateFields["service_date_year"]["Value"] = $this->service_date_year->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tech_eval", $this->UpdateFields, $this);
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

//Delete Method @2-6A2FE9ED
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM tech_eval";
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End tech_evalDataSource Class @2-FCB6E20C

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

//Initialize Objects @1-9CEDC737
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tech_eval = & new clsRecordtech_eval("", $MainPage);
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

//Execute Components @1-267CCF5F
$tech_eval->Operation();
//End Execute Components

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
