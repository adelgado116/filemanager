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

class clsRecordservice_failed_tbl { //service_failed_tbl Class @2-26D82045

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

//Class_Initialize Event @2-52EB4B45
    function clsRecordservice_failed_tbl($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record service_failed_tbl/Error";
        $this->DataSource = new clsservice_failed_tblDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "service_failed_tbl";
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
            $this->ORDER_NO = & new clsControl(ccsTextBox, "ORDER_NO", "ORDER NO", ccsText, "", CCGetRequestParam("ORDER_NO", $Method, NULL), $this);
            $this->ORDER_NO->Required = true;
            $this->emp_id = & new clsControl(ccsListBox, "emp_id", "Emp Id", ccsInteger, "", CCGetRequestParam("emp_id", $Method, NULL), $this);
            $this->emp_id->DSType = dsTable;
            $this->emp_id->DataSource = new clsDBhss_db();
            $this->emp_id->ds = & $this->emp_id->DataSource;
            $this->emp_id->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->emp_id->BoundColumn, $this->emp_id->TextColumn, $this->emp_id->DBFormat) = array("emp_id", "emp_login", "");
            $this->emp_id->Required = true;
            $this->fault_after_service = & new clsControl(ccsTextArea, "fault_after_service", "Fault After Service", ccsMemo, "", CCGetRequestParam("fault_after_service", $Method, NULL), $this);
            $this->fault_after_service->Required = true;
            $this->failed_service_reason = & new clsControl(ccsListBox, "failed_service_reason", "Failed Service Reason", ccsInteger, "", CCGetRequestParam("failed_service_reason", $Method, NULL), $this);
            $this->failed_service_reason->DSType = dsTable;
            $this->failed_service_reason->DataSource = new clsDBhss_db();
            $this->failed_service_reason->ds = & $this->failed_service_reason->DataSource;
            $this->failed_service_reason->DataSource->SQL = "SELECT * \n" .
"FROM service_failed_reasons_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->failed_service_reason->BoundColumn, $this->failed_service_reason->TextColumn, $this->failed_service_reason->DBFormat) = array("failed_service_reason_id", "failed_service_reason", "");
            $this->failed_service_reason->Required = true;
            $this->action_to_finish = & new clsControl(ccsTextArea, "action_to_finish", "Action To Finish", ccsMemo, "", CCGetRequestParam("action_to_finish", $Method, NULL), $this);
            $this->action_to_finish->Required = true;
            $this->received_by = & new clsControl(ccsListBox, "received_by", "Received By", ccsInteger, "", CCGetRequestParam("received_by", $Method, NULL), $this);
            $this->received_by->DSType = dsTable;
            $this->received_by->DataSource = new clsDBhss_db();
            $this->received_by->ds = & $this->received_by->DataSource;
            $this->received_by->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->received_by->BoundColumn, $this->received_by->TextColumn, $this->received_by->DBFormat) = array("emp_id", "emp_login", "");
            $this->received_by->Required = true;
            $this->other_reason = & new clsControl(ccsTextArea, "other_reason", "Other Reason", ccsMemo, "", CCGetRequestParam("other_reason", $Method, NULL), $this);
            $this->ITEM_NO = & new clsControl(ccsHidden, "ITEM_NO", "ITEM_NO", ccsInteger, "", CCGetRequestParam("ITEM_NO", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @2-2954BAE5
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlORDER_NO"] = CCGetFromGet("ORDER_NO", NULL);
    }
//End Initialize Method

//Validate Method @2-90B54010
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->ORDER_NO->Validate() && $Validation);
        $Validation = ($this->emp_id->Validate() && $Validation);
        $Validation = ($this->fault_after_service->Validate() && $Validation);
        $Validation = ($this->failed_service_reason->Validate() && $Validation);
        $Validation = ($this->action_to_finish->Validate() && $Validation);
        $Validation = ($this->received_by->Validate() && $Validation);
        $Validation = ($this->other_reason->Validate() && $Validation);
        $Validation = ($this->ITEM_NO->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->ORDER_NO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->emp_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->fault_after_service->Errors->Count() == 0);
        $Validation =  $Validation && ($this->failed_service_reason->Errors->Count() == 0);
        $Validation =  $Validation && ($this->action_to_finish->Errors->Count() == 0);
        $Validation =  $Validation && ($this->received_by->Errors->Count() == 0);
        $Validation =  $Validation && ($this->other_reason->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ITEM_NO->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-66A9D63D
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->ORDER_NO->Errors->Count());
        $errors = ($errors || $this->emp_id->Errors->Count());
        $errors = ($errors || $this->fault_after_service->Errors->Count());
        $errors = ($errors || $this->failed_service_reason->Errors->Count());
        $errors = ($errors || $this->action_to_finish->Errors->Count());
        $errors = ($errors || $this->received_by->Errors->Count());
        $errors = ($errors || $this->other_reason->Errors->Count());
        $errors = ($errors || $this->ITEM_NO->Errors->Count());
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

//Operation Method @2-9870D644
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
            }
        }
        $Redirect = "page2.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update") {
                $Redirect = "page2.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
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

//InsertRow Method @2-2CDA032A
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->ORDER_NO->SetValue($this->ORDER_NO->GetValue(true));
        $this->DataSource->emp_id->SetValue($this->emp_id->GetValue(true));
        $this->DataSource->fault_after_service->SetValue($this->fault_after_service->GetValue(true));
        $this->DataSource->failed_service_reason->SetValue($this->failed_service_reason->GetValue(true));
        $this->DataSource->action_to_finish->SetValue($this->action_to_finish->GetValue(true));
        $this->DataSource->received_by->SetValue($this->received_by->GetValue(true));
        $this->DataSource->other_reason->SetValue($this->other_reason->GetValue(true));
        $this->DataSource->ITEM_NO->SetValue($this->ITEM_NO->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-695A4CB6
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->ORDER_NO->SetValue($this->ORDER_NO->GetValue(true));
        $this->DataSource->emp_id->SetValue($this->emp_id->GetValue(true));
        $this->DataSource->fault_after_service->SetValue($this->fault_after_service->GetValue(true));
        $this->DataSource->failed_service_reason->SetValue($this->failed_service_reason->GetValue(true));
        $this->DataSource->action_to_finish->SetValue($this->action_to_finish->GetValue(true));
        $this->DataSource->received_by->SetValue($this->received_by->GetValue(true));
        $this->DataSource->other_reason->SetValue($this->other_reason->GetValue(true));
        $this->DataSource->ITEM_NO->SetValue($this->ITEM_NO->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-235B5563
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
        $this->failed_service_reason->Prepare();
        $this->received_by->Prepare();

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
                    $this->emp_id->SetValue($this->DataSource->emp_id->GetValue());
                    $this->fault_after_service->SetValue($this->DataSource->fault_after_service->GetValue());
                    $this->failed_service_reason->SetValue($this->DataSource->failed_service_reason->GetValue());
                    $this->action_to_finish->SetValue($this->DataSource->action_to_finish->GetValue());
                    $this->received_by->SetValue($this->DataSource->received_by->GetValue());
                    $this->other_reason->SetValue($this->DataSource->other_reason->GetValue());
                    $this->ITEM_NO->SetValue($this->DataSource->ITEM_NO->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->ORDER_NO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->emp_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->fault_after_service->Errors->ToString());
            $Error = ComposeStrings($Error, $this->failed_service_reason->Errors->ToString());
            $Error = ComposeStrings($Error, $this->action_to_finish->Errors->ToString());
            $Error = ComposeStrings($Error, $this->received_by->Errors->ToString());
            $Error = ComposeStrings($Error, $this->other_reason->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ITEM_NO->Errors->ToString());
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
        $this->ORDER_NO->Show();
        $this->emp_id->Show();
        $this->fault_after_service->Show();
        $this->failed_service_reason->Show();
        $this->action_to_finish->Show();
        $this->received_by->Show();
        $this->other_reason->Show();
        $this->ITEM_NO->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End service_failed_tbl Class @2-FCB6E20C

class clsservice_failed_tblDataSource extends clsDBhss_db {  //service_failed_tblDataSource Class @2-3E058EA6

//DataSource Variables @2-0D103308
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
    var $ORDER_NO;
    var $emp_id;
    var $fault_after_service;
    var $failed_service_reason;
    var $action_to_finish;
    var $received_by;
    var $other_reason;
    var $ITEM_NO;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-9F05920F
    function clsservice_failed_tblDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record service_failed_tbl/Error";
        $this->Initialize();
        $this->ORDER_NO = new clsField("ORDER_NO", ccsText, "");
        
        $this->emp_id = new clsField("emp_id", ccsInteger, "");
        
        $this->fault_after_service = new clsField("fault_after_service", ccsMemo, "");
        
        $this->failed_service_reason = new clsField("failed_service_reason", ccsInteger, "");
        
        $this->action_to_finish = new clsField("action_to_finish", ccsMemo, "");
        
        $this->received_by = new clsField("received_by", ccsInteger, "");
        
        $this->other_reason = new clsField("other_reason", ccsMemo, "");
        
        $this->ITEM_NO = new clsField("ITEM_NO", ccsInteger, "");
        

        $this->InsertFields["ORDER_NO"] = array("Name" => "ORDER_NO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["emp_id"] = array("Name" => "emp_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["fault_after_service"] = array("Name" => "fault_after_service", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->InsertFields["failed_service_reason_id"] = array("Name" => "failed_service_reason_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["action_to_finish"] = array("Name" => "action_to_finish", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->InsertFields["received_by"] = array("Name" => "received_by", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["other_reason"] = array("Name" => "other_reason", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->InsertFields["ITEM_NO"] = array("Name" => "ITEM_NO", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["ORDER_NO"] = array("Name" => "ORDER_NO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["emp_id"] = array("Name" => "emp_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["fault_after_service"] = array("Name" => "fault_after_service", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->UpdateFields["failed_service_reason_id"] = array("Name" => "failed_service_reason_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["action_to_finish"] = array("Name" => "action_to_finish", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->UpdateFields["received_by"] = array("Name" => "received_by", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["other_reason"] = array("Name" => "other_reason", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->UpdateFields["ITEM_NO"] = array("Name" => "ITEM_NO", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-1263266B
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlORDER_NO", ccsText, "", "", $this->Parameters["urlORDER_NO"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "ORDER_NO", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-58513D6E
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM service_failed_tbl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-EF59CBE7
    function SetValues()
    {
        $this->ORDER_NO->SetDBValue($this->f("ORDER_NO"));
        $this->emp_id->SetDBValue(trim($this->f("emp_id")));
        $this->fault_after_service->SetDBValue($this->f("fault_after_service"));
        $this->failed_service_reason->SetDBValue(trim($this->f("failed_service_reason_id")));
        $this->action_to_finish->SetDBValue($this->f("action_to_finish"));
        $this->received_by->SetDBValue(trim($this->f("received_by")));
        $this->other_reason->SetDBValue($this->f("other_reason"));
        $this->ITEM_NO->SetDBValue(trim($this->f("ITEM_NO")));
    }
//End SetValues Method

//Insert Method @2-5907444F
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["ORDER_NO"]["Value"] = $this->ORDER_NO->GetDBValue(true);
        $this->InsertFields["emp_id"]["Value"] = $this->emp_id->GetDBValue(true);
        $this->InsertFields["fault_after_service"]["Value"] = $this->fault_after_service->GetDBValue(true);
        $this->InsertFields["failed_service_reason_id"]["Value"] = $this->failed_service_reason->GetDBValue(true);
        $this->InsertFields["action_to_finish"]["Value"] = $this->action_to_finish->GetDBValue(true);
        $this->InsertFields["received_by"]["Value"] = $this->received_by->GetDBValue(true);
        $this->InsertFields["other_reason"]["Value"] = $this->other_reason->GetDBValue(true);
        $this->InsertFields["ITEM_NO"]["Value"] = $this->ITEM_NO->GetDBValue(true);
        $this->SQL = CCBuildInsert("service_failed_tbl", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-0EF050A4
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["ORDER_NO"] = new clsSQLParameter("ctrlORDER_NO", ccsText, "", "", $this->ORDER_NO->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["emp_id"] = new clsSQLParameter("ctrlemp_id", ccsInteger, "", "", $this->emp_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["fault_after_service"] = new clsSQLParameter("ctrlfault_after_service", ccsMemo, "", "", $this->fault_after_service->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["failed_service_reason_id"] = new clsSQLParameter("ctrlfailed_service_reason", ccsInteger, "", "", $this->failed_service_reason->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["action_to_finish"] = new clsSQLParameter("ctrlaction_to_finish", ccsMemo, "", "", $this->action_to_finish->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["received_by"] = new clsSQLParameter("ctrlreceived_by", ccsInteger, "", "", $this->received_by->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["other_reason"] = new clsSQLParameter("ctrlother_reason", ccsMemo, "", "", $this->other_reason->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["ITEM_NO"] = new clsSQLParameter("ctrlITEM_NO", ccsInteger, "", "", $this->ITEM_NO->GetValue(true), NULL, false, $this->ErrorBlock);
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "urlORDER_NO", ccsText, "", "", CCGetFromGet("ORDER_NO", NULL), "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        if (!is_null($this->cp["ORDER_NO"]->GetValue()) and !strlen($this->cp["ORDER_NO"]->GetText()) and !is_bool($this->cp["ORDER_NO"]->GetValue())) 
            $this->cp["ORDER_NO"]->SetValue($this->ORDER_NO->GetValue(true));
        if (!is_null($this->cp["emp_id"]->GetValue()) and !strlen($this->cp["emp_id"]->GetText()) and !is_bool($this->cp["emp_id"]->GetValue())) 
            $this->cp["emp_id"]->SetValue($this->emp_id->GetValue(true));
        if (!is_null($this->cp["fault_after_service"]->GetValue()) and !strlen($this->cp["fault_after_service"]->GetText()) and !is_bool($this->cp["fault_after_service"]->GetValue())) 
            $this->cp["fault_after_service"]->SetValue($this->fault_after_service->GetValue(true));
        if (!is_null($this->cp["failed_service_reason_id"]->GetValue()) and !strlen($this->cp["failed_service_reason_id"]->GetText()) and !is_bool($this->cp["failed_service_reason_id"]->GetValue())) 
            $this->cp["failed_service_reason_id"]->SetValue($this->failed_service_reason->GetValue(true));
        if (!is_null($this->cp["action_to_finish"]->GetValue()) and !strlen($this->cp["action_to_finish"]->GetText()) and !is_bool($this->cp["action_to_finish"]->GetValue())) 
            $this->cp["action_to_finish"]->SetValue($this->action_to_finish->GetValue(true));
        if (!is_null($this->cp["received_by"]->GetValue()) and !strlen($this->cp["received_by"]->GetText()) and !is_bool($this->cp["received_by"]->GetValue())) 
            $this->cp["received_by"]->SetValue($this->received_by->GetValue(true));
        if (!is_null($this->cp["other_reason"]->GetValue()) and !strlen($this->cp["other_reason"]->GetText()) and !is_bool($this->cp["other_reason"]->GetValue())) 
            $this->cp["other_reason"]->SetValue($this->other_reason->GetValue(true));
        if (!is_null($this->cp["ITEM_NO"]->GetValue()) and !strlen($this->cp["ITEM_NO"]->GetText()) and !is_bool($this->cp["ITEM_NO"]->GetValue())) 
            $this->cp["ITEM_NO"]->SetValue($this->ITEM_NO->GetValue(true));
        $wp->Criterion[1] = $wp->Operation(opEqual, "ORDER_NO", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsText),false);
        $Where = 
             $wp->Criterion[1];
        $this->UpdateFields["ORDER_NO"]["Value"] = $this->cp["ORDER_NO"]->GetDBValue(true);
        $this->UpdateFields["emp_id"]["Value"] = $this->cp["emp_id"]->GetDBValue(true);
        $this->UpdateFields["fault_after_service"]["Value"] = $this->cp["fault_after_service"]->GetDBValue(true);
        $this->UpdateFields["failed_service_reason_id"]["Value"] = $this->cp["failed_service_reason_id"]->GetDBValue(true);
        $this->UpdateFields["action_to_finish"]["Value"] = $this->cp["action_to_finish"]->GetDBValue(true);
        $this->UpdateFields["received_by"]["Value"] = $this->cp["received_by"]->GetDBValue(true);
        $this->UpdateFields["other_reason"]["Value"] = $this->cp["other_reason"]->GetDBValue(true);
        $this->UpdateFields["ITEM_NO"]["Value"] = $this->cp["ITEM_NO"]->GetDBValue(true);
        $this->SQL = CCBuildUpdate("service_failed_tbl", $this->UpdateFields, $this);
        $this->SQL .= strlen($Where) ? " WHERE " . $Where : $Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End service_failed_tblDataSource Class @2-FCB6E20C

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

//Initialize Objects @1-64C00FE3
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$service_failed_tbl = & new clsRecordservice_failed_tbl("", $MainPage);
$MainPage->service_failed_tbl = & $service_failed_tbl;
$service_failed_tbl->Initialize();

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

//Execute Components @1-A80718FA
$service_failed_tbl->Operation();
//End Execute Components

//Go to destination page @1-E11FB6AB
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($service_failed_tbl);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-778B79ED
$service_failed_tbl->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-8063677B
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($service_failed_tbl);
unset($Tpl);
//End Unload Page


?>
