<?php
//Include Common Files @1-8E4752CA
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page5_1.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordservice_items_tbl { //service_items_tbl Class @5-9948EC80

//Variables @5-9E315808

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

//Class_Initialize Event @5-A2D18C5A
    function clsRecordservice_items_tbl($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record service_items_tbl/Error";
        $this->DataSource = new clsservice_items_tblDataSource($this);
        $this->ds = & $this->DataSource;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "service_items_tbl";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->ORDER_NO = new clsControl(ccsTextBox, "ORDER_NO", "ORDER NO", ccsText, "", CCGetRequestParam("ORDER_NO", $Method, NULL), $this);
            $this->ORDER_NO->Required = true;
            $this->SERVICE_TYPE_ID = new clsControl(ccsListBox, "SERVICE_TYPE_ID", "SERVICE TYPE ID", ccsInteger, "", CCGetRequestParam("SERVICE_TYPE_ID", $Method, NULL), $this);
            $this->SERVICE_TYPE_ID->DSType = dsTable;
            $this->SERVICE_TYPE_ID->DataSource = new clsDBhss_db();
            $this->SERVICE_TYPE_ID->ds = & $this->SERVICE_TYPE_ID->DataSource;
            $this->SERVICE_TYPE_ID->DataSource->SQL = "SELECT * \n" .
"FROM service_type_tbl {SQL_Where} {SQL_OrderBy}";
            $this->SERVICE_TYPE_ID->DataSource->Order = "SERVICE_TYPE";
            list($this->SERVICE_TYPE_ID->BoundColumn, $this->SERVICE_TYPE_ID->TextColumn, $this->SERVICE_TYPE_ID->DBFormat) = array("SERVICE_TYPE_ID", "SERVICE_TYPE", "");
            $this->SERVICE_TYPE_ID->DataSource->Order = "SERVICE_TYPE";
            $this->WARRANTY = new clsControl(ccsCheckBox, "WARRANTY", "WARRANTY", ccsText, "", CCGetRequestParam("WARRANTY", $Method, NULL), $this);
            $this->WARRANTY->CheckedValue = $this->WARRANTY->GetParsedValue(Yes);
            $this->WARRANTY->UncheckedValue = $this->WARRANTY->GetParsedValue(No);
            $this->emp_id = new clsControl(ccsListBox, "emp_id", "Emp Id", ccsInteger, "", CCGetRequestParam("emp_id", $Method, NULL), $this);
            $this->emp_id->DSType = dsTable;
            $this->emp_id->DataSource = new clsDBhss_db();
            $this->emp_id->ds = & $this->emp_id->DataSource;
            $this->emp_id->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            $this->emp_id->DataSource->Order = "emp_login";
            list($this->emp_id->BoundColumn, $this->emp_id->TextColumn, $this->emp_id->DBFormat) = array("emp_id", "emp_login", "");
            $this->emp_id->DataSource->Order = "emp_login";
            $this->ITEM_NO = new clsControl(ccsHidden, "ITEM_NO", "ITEM NO", ccsInteger, "", CCGetRequestParam("ITEM_NO", $Method, NULL), $this);
            $this->ITEM_NO->Required = true;
            $this->EQUIP_ID = new clsControl(ccsHidden, "EQUIP_ID", "EQUIP ID", ccsText, "", CCGetRequestParam("EQUIP_ID", $Method, NULL), $this);
            $this->FOLLOW_UP = new clsControl(ccsHidden, "FOLLOW_UP", "FOLLOW UP", ccsInteger, "", CCGetRequestParam("FOLLOW_UP", $Method, NULL), $this);
            $this->EQUIP_MODEL = new clsControl(ccsTextBox, "EQUIP_MODEL", "EQUIP_MODEL", ccsText, "", CCGetRequestParam("EQUIP_MODEL", $Method, NULL), $this);
            $this->REMARKS = new clsControl(ccsTextArea, "REMARKS", "REMARKS", ccsMemo, "", CCGetRequestParam("REMARKS", $Method, NULL), $this);
            $this->REQUEST = new clsControl(ccsTextArea, "REQUEST", "REQUEST", ccsText, "", CCGetRequestParam("REQUEST", $Method, NULL), $this);
            $this->assigned_emp_id = new clsControl(ccsListBox, "assigned_emp_id", "assigned_emp_id", ccsInteger, "", CCGetRequestParam("assigned_emp_id", $Method, NULL), $this);
            $this->assigned_emp_id->DSType = dsTable;
            $this->assigned_emp_id->DataSource = new clsDBhss_db();
            $this->assigned_emp_id->ds = & $this->assigned_emp_id->DataSource;
            $this->assigned_emp_id->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            $this->assigned_emp_id->DataSource->Order = "emp_login";
            list($this->assigned_emp_id->BoundColumn, $this->assigned_emp_id->TextColumn, $this->assigned_emp_id->DBFormat) = array("emp_id", "emp_login", "");
            $this->assigned_emp_id->DataSource->Order = "emp_login";
            $this->assigned_emp_id->Required = true;
            $this->coord_id = new clsControl(ccsListBox, "coord_id", "coord_id", ccsInteger, "", CCGetRequestParam("coord_id", $Method, NULL), $this);
            $this->coord_id->DSType = dsTable;
            $this->coord_id->DataSource = new clsDBhss_db();
            $this->coord_id->ds = & $this->coord_id->DataSource;
            $this->coord_id->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            $this->coord_id->DataSource->Order = "emp_login";
            list($this->coord_id->BoundColumn, $this->coord_id->TextColumn, $this->coord_id->DBFormat) = array("emp_id", "emp_login", "");
            $this->coord_id->DataSource->Order = "emp_login";
            $this->coord_id->Required = true;
            $this->TA1 = new clsControl(ccsListBox, "TA1", "TA1", ccsInteger, "", CCGetRequestParam("TA1", $Method, NULL), $this);
            $this->TA1->DSType = dsTable;
            $this->TA1->DataSource = new clsDBhss_db();
            $this->TA1->ds = & $this->TA1->DataSource;
            $this->TA1->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            $this->TA1->DataSource->Order = "emp_login";
            list($this->TA1->BoundColumn, $this->TA1->TextColumn, $this->TA1->DBFormat) = array("emp_id", "emp_login", "");
            $this->TA1->DataSource->Order = "emp_login";
            $this->TA2 = new clsControl(ccsListBox, "TA2", "TA2", ccsInteger, "", CCGetRequestParam("TA2", $Method, NULL), $this);
            $this->TA2->DSType = dsTable;
            $this->TA2->DataSource = new clsDBhss_db();
            $this->TA2->ds = & $this->TA2->DataSource;
            $this->TA2->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            $this->TA2->DataSource->Order = "emp_login";
            list($this->TA2->BoundColumn, $this->TA2->TextColumn, $this->TA2->DBFormat) = array("emp_id", "emp_login", "");
            $this->TA2->DataSource->Order = "emp_login";
        }
    }
//End Class_Initialize Event

//Initialize Method @5-2D84DED2
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["sesORDER"] = CCGetSession("ORDER", NULL);
        $this->DataSource->Parameters["urlITEM_NO"] = CCGetFromGet("ITEM_NO", NULL);
    }
//End Initialize Method

//Validate Method @5-CA155F48
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->ORDER_NO->Validate() && $Validation);
        $Validation = ($this->SERVICE_TYPE_ID->Validate() && $Validation);
        $Validation = ($this->WARRANTY->Validate() && $Validation);
        $Validation = ($this->emp_id->Validate() && $Validation);
        $Validation = ($this->ITEM_NO->Validate() && $Validation);
        $Validation = ($this->EQUIP_ID->Validate() && $Validation);
        $Validation = ($this->FOLLOW_UP->Validate() && $Validation);
        $Validation = ($this->EQUIP_MODEL->Validate() && $Validation);
        $Validation = ($this->REMARKS->Validate() && $Validation);
        $Validation = ($this->REQUEST->Validate() && $Validation);
        $Validation = ($this->assigned_emp_id->Validate() && $Validation);
        $Validation = ($this->coord_id->Validate() && $Validation);
        $Validation = ($this->TA1->Validate() && $Validation);
        $Validation = ($this->TA2->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->ORDER_NO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->SERVICE_TYPE_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->WARRANTY->Errors->Count() == 0);
        $Validation =  $Validation && ($this->emp_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ITEM_NO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->EQUIP_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->FOLLOW_UP->Errors->Count() == 0);
        $Validation =  $Validation && ($this->EQUIP_MODEL->Errors->Count() == 0);
        $Validation =  $Validation && ($this->REMARKS->Errors->Count() == 0);
        $Validation =  $Validation && ($this->REQUEST->Errors->Count() == 0);
        $Validation =  $Validation && ($this->assigned_emp_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->coord_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TA1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TA2->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @5-BF634386
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->ORDER_NO->Errors->Count());
        $errors = ($errors || $this->SERVICE_TYPE_ID->Errors->Count());
        $errors = ($errors || $this->WARRANTY->Errors->Count());
        $errors = ($errors || $this->emp_id->Errors->Count());
        $errors = ($errors || $this->ITEM_NO->Errors->Count());
        $errors = ($errors || $this->EQUIP_ID->Errors->Count());
        $errors = ($errors || $this->FOLLOW_UP->Errors->Count());
        $errors = ($errors || $this->EQUIP_MODEL->Errors->Count());
        $errors = ($errors || $this->REMARKS->Errors->Count());
        $errors = ($errors || $this->REQUEST->Errors->Count());
        $errors = ($errors || $this->assigned_emp_id->Errors->Count());
        $errors = ($errors || $this->coord_id->Errors->Count());
        $errors = ($errors || $this->TA1->Errors->Count());
        $errors = ($errors || $this->TA2->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @5-ED598703
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

//Operation Method @5-2A5D334D
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
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Cancel";
            if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Delete->Pressed) {
                $this->PressedButton = "Button_Delete";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = "page5.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Delete") {
            $Redirect = "page5.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
            $Redirect = "page5.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Update") {
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

//UpdateRow Method @5-83012B2D
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->ORDER_NO->SetValue($this->ORDER_NO->GetValue(true));
        $this->DataSource->SERVICE_TYPE_ID->SetValue($this->SERVICE_TYPE_ID->GetValue(true));
        $this->DataSource->WARRANTY->SetValue($this->WARRANTY->GetValue(true));
        $this->DataSource->emp_id->SetValue($this->emp_id->GetValue(true));
        $this->DataSource->REMARKS->SetValue($this->REMARKS->GetValue(true));
        $this->DataSource->ITEM_NO->SetValue($this->ITEM_NO->GetValue(true));
        $this->DataSource->EQUIP_ID->SetValue($this->EQUIP_ID->GetValue(true));
        $this->DataSource->FOLLOW_UP->SetValue($this->FOLLOW_UP->GetValue(true));
        $this->DataSource->assigned_emp_id->SetValue($this->assigned_emp_id->GetValue(true));
        $this->DataSource->REQUEST->SetValue($this->REQUEST->GetValue(true));
        $this->DataSource->TA1->SetValue($this->TA1->GetValue(true));
        $this->DataSource->TA2->SetValue($this->TA2->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @5-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @5-79C0FCE5
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

        $this->SERVICE_TYPE_ID->Prepare();
        $this->emp_id->Prepare();
        $this->assigned_emp_id->Prepare();
        $this->coord_id->Prepare();
        $this->TA1->Prepare();
        $this->TA2->Prepare();

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
                    $this->SERVICE_TYPE_ID->SetValue($this->DataSource->SERVICE_TYPE_ID->GetValue());
                    $this->WARRANTY->SetValue($this->DataSource->WARRANTY->GetValue());
                    $this->emp_id->SetValue($this->DataSource->emp_id->GetValue());
                    $this->ITEM_NO->SetValue($this->DataSource->ITEM_NO->GetValue());
                    $this->EQUIP_ID->SetValue($this->DataSource->EQUIP_ID->GetValue());
                    $this->FOLLOW_UP->SetValue($this->DataSource->FOLLOW_UP->GetValue());
                    $this->EQUIP_MODEL->SetValue($this->DataSource->EQUIP_MODEL->GetValue());
                    $this->REMARKS->SetValue($this->DataSource->REMARKS->GetValue());
                    $this->REQUEST->SetValue($this->DataSource->REQUEST->GetValue());
                    $this->assigned_emp_id->SetValue($this->DataSource->assigned_emp_id->GetValue());
                    $this->coord_id->SetValue($this->DataSource->coord_id->GetValue());
                    $this->TA1->SetValue($this->DataSource->TA1->GetValue());
                    $this->TA2->SetValue($this->DataSource->TA2->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->ORDER_NO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->SERVICE_TYPE_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->WARRANTY->Errors->ToString());
            $Error = ComposeStrings($Error, $this->emp_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ITEM_NO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->EQUIP_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->FOLLOW_UP->Errors->ToString());
            $Error = ComposeStrings($Error, $this->EQUIP_MODEL->Errors->ToString());
            $Error = ComposeStrings($Error, $this->REMARKS->Errors->ToString());
            $Error = ComposeStrings($Error, $this->REQUEST->Errors->ToString());
            $Error = ComposeStrings($Error, $this->assigned_emp_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->coord_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TA1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TA2->Errors->ToString());
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
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;
        $this->Button_Delete->Visible = $this->EditMode && $this->DeleteAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Update->Show();
        $this->Button_Delete->Show();
        $this->Button_Cancel->Show();
        $this->ORDER_NO->Show();
        $this->SERVICE_TYPE_ID->Show();
        $this->WARRANTY->Show();
        $this->emp_id->Show();
        $this->ITEM_NO->Show();
        $this->EQUIP_ID->Show();
        $this->FOLLOW_UP->Show();
        $this->EQUIP_MODEL->Show();
        $this->REMARKS->Show();
        $this->REQUEST->Show();
        $this->assigned_emp_id->Show();
        $this->coord_id->Show();
        $this->TA1->Show();
        $this->TA2->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End service_items_tbl Class @5-FCB6E20C

class clsservice_items_tblDataSource extends clsDBhss_db {  //service_items_tblDataSource Class @5-C9CB8B01

//DataSource Variables @5-5FD29BC0
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $UpdateParameters;
    public $DeleteParameters;
    public $wp;
    public $AllParametersSet;

    public $UpdateFields = array();

    // Datasource fields
    public $ORDER_NO;
    public $SERVICE_TYPE_ID;
    public $WARRANTY;
    public $emp_id;
    public $ITEM_NO;
    public $EQUIP_ID;
    public $FOLLOW_UP;
    public $EQUIP_MODEL;
    public $REMARKS;
    public $REQUEST;
    public $assigned_emp_id;
    public $coord_id;
    public $TA1;
    public $TA2;
//End DataSource Variables

//DataSourceClass_Initialize Event @5-2131F6F7
    function clsservice_items_tblDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record service_items_tbl/Error";
        $this->Initialize();
        $this->ORDER_NO = new clsField("ORDER_NO", ccsText, "");
        
        $this->SERVICE_TYPE_ID = new clsField("SERVICE_TYPE_ID", ccsInteger, "");
        
        $this->WARRANTY = new clsField("WARRANTY", ccsText, "");
        
        $this->emp_id = new clsField("emp_id", ccsInteger, "");
        
        $this->ITEM_NO = new clsField("ITEM_NO", ccsInteger, "");
        
        $this->EQUIP_ID = new clsField("EQUIP_ID", ccsText, "");
        
        $this->FOLLOW_UP = new clsField("FOLLOW_UP", ccsInteger, "");
        
        $this->EQUIP_MODEL = new clsField("EQUIP_MODEL", ccsText, "");
        
        $this->REMARKS = new clsField("REMARKS", ccsMemo, "");
        
        $this->REQUEST = new clsField("REQUEST", ccsText, "");
        
        $this->assigned_emp_id = new clsField("assigned_emp_id", ccsInteger, "");
        
        $this->coord_id = new clsField("coord_id", ccsInteger, "");
        
        $this->TA1 = new clsField("TA1", ccsInteger, "");
        
        $this->TA2 = new clsField("TA2", ccsInteger, "");
        

        $this->UpdateFields["ORDER_NO"] = array("Name" => "ORDER_NO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["SERVICE_TYPE_ID"] = array("Name" => "SERVICE_TYPE_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["WARRANTY"] = array("Name" => "WARRANTY", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["emp_id"] = array("Name" => "emp_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["REMARKS"] = array("Name" => "REMARKS", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->UpdateFields["ITEM_NO"] = array("Name" => "ITEM_NO", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["EQUIP_ID"] = array("Name" => "EQUIP_ID", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["FOLLOW_UP"] = array("Name" => "FOLLOW_UP", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["assigned_emp_id"] = array("Name" => "assigned_emp_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["REQUEST"] = array("Name" => "REQUEST", "Value" => "", "DataType" => ccsMemo);
        $this->UpdateFields["TA1"] = array("Name" => "TA1", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["TA2"] = array("Name" => "TA2", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @5-6EEA0C75
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "sesORDER", ccsText, "", "", $this->Parameters["sesORDER"], "", false);
        $this->wp->AddParameter("2", "urlITEM_NO", ccsInteger, "", "", $this->Parameters["urlITEM_NO"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "service_items_tbl.ORDER_NO", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "service_items_tbl.ITEM_NO", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @5-B016B2D0
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT service_items_tbl.*, EQUIP_MODEL \n\n" .
        "FROM service_items_tbl INNER JOIN equipment_model_tbl ON\n\n" .
        "service_items_tbl.EQUIP_ID = equipment_model_tbl.EQUIP_ID {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @5-FB74186D
    function SetValues()
    {
        $this->ORDER_NO->SetDBValue($this->f("ORDER_NO"));
        $this->SERVICE_TYPE_ID->SetDBValue(trim($this->f("SERVICE_TYPE_ID")));
        $this->WARRANTY->SetDBValue($this->f("WARRANTY"));
        $this->emp_id->SetDBValue(trim($this->f("emp_id")));
        $this->ITEM_NO->SetDBValue(trim($this->f("ITEM_NO")));
        $this->EQUIP_ID->SetDBValue($this->f("EQUIP_ID"));
        $this->FOLLOW_UP->SetDBValue(trim($this->f("FOLLOW_UP")));
        $this->EQUIP_MODEL->SetDBValue($this->f("EQUIP_MODEL"));
        $this->REMARKS->SetDBValue($this->f("REMARKS"));
        $this->REQUEST->SetDBValue($this->f("REQUEST"));
        $this->assigned_emp_id->SetDBValue(trim($this->f("assigned_emp_id")));
        $this->coord_id->SetDBValue(trim($this->f("coord_id")));
        $this->TA1->SetDBValue(trim($this->f("TA1")));
        $this->TA2->SetDBValue(trim($this->f("TA2")));
    }
//End SetValues Method

//Update Method @5-7A6F8FF7
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["ORDER_NO"] = new clsSQLParameter("ctrlORDER_NO", ccsText, "", "", $this->ORDER_NO->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["SERVICE_TYPE_ID"] = new clsSQLParameter("ctrlSERVICE_TYPE_ID", ccsInteger, "", "", $this->SERVICE_TYPE_ID->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["WARRANTY"] = new clsSQLParameter("ctrlWARRANTY", ccsText, "", "", $this->WARRANTY->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["emp_id"] = new clsSQLParameter("ctrlemp_id", ccsInteger, "", "", $this->emp_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["REMARKS"] = new clsSQLParameter("ctrlREMARKS", ccsMemo, "", "", $this->REMARKS->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["ITEM_NO"] = new clsSQLParameter("ctrlITEM_NO", ccsInteger, "", "", $this->ITEM_NO->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["EQUIP_ID"] = new clsSQLParameter("ctrlEQUIP_ID", ccsText, "", "", $this->EQUIP_ID->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["FOLLOW_UP"] = new clsSQLParameter("ctrlFOLLOW_UP", ccsInteger, "", "", $this->FOLLOW_UP->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["assigned_emp_id"] = new clsSQLParameter("ctrlassigned_emp_id", ccsInteger, "", "", $this->assigned_emp_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["REQUEST"] = new clsSQLParameter("ctrlREQUEST", ccsMemo, "", "", $this->REQUEST->GetValue(true), "", false, $this->ErrorBlock);
        $this->cp["TA1"] = new clsSQLParameter("ctrlTA1", ccsInteger, "", "", $this->TA1->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["TA2"] = new clsSQLParameter("ctrlTA2", ccsInteger, "", "", $this->TA2->GetValue(true), NULL, false, $this->ErrorBlock);
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "sesORDER", ccsText, "", "", CCGetSession("ORDER", NULL), "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $wp->AddParameter("2", "urlITEM_NO", ccsInteger, "", "", CCGetFromGet("ITEM_NO", NULL), "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        if (!is_null($this->cp["ORDER_NO"]->GetValue()) and !strlen($this->cp["ORDER_NO"]->GetText()) and !is_bool($this->cp["ORDER_NO"]->GetValue())) 
            $this->cp["ORDER_NO"]->SetValue($this->ORDER_NO->GetValue(true));
        if (!is_null($this->cp["SERVICE_TYPE_ID"]->GetValue()) and !strlen($this->cp["SERVICE_TYPE_ID"]->GetText()) and !is_bool($this->cp["SERVICE_TYPE_ID"]->GetValue())) 
            $this->cp["SERVICE_TYPE_ID"]->SetValue($this->SERVICE_TYPE_ID->GetValue(true));
        if (!is_null($this->cp["WARRANTY"]->GetValue()) and !strlen($this->cp["WARRANTY"]->GetText()) and !is_bool($this->cp["WARRANTY"]->GetValue())) 
            $this->cp["WARRANTY"]->SetValue($this->WARRANTY->GetValue(true));
        if (!is_null($this->cp["emp_id"]->GetValue()) and !strlen($this->cp["emp_id"]->GetText()) and !is_bool($this->cp["emp_id"]->GetValue())) 
            $this->cp["emp_id"]->SetValue($this->emp_id->GetValue(true));
        if (!is_null($this->cp["REMARKS"]->GetValue()) and !strlen($this->cp["REMARKS"]->GetText()) and !is_bool($this->cp["REMARKS"]->GetValue())) 
            $this->cp["REMARKS"]->SetValue($this->REMARKS->GetValue(true));
        if (!is_null($this->cp["ITEM_NO"]->GetValue()) and !strlen($this->cp["ITEM_NO"]->GetText()) and !is_bool($this->cp["ITEM_NO"]->GetValue())) 
            $this->cp["ITEM_NO"]->SetValue($this->ITEM_NO->GetValue(true));
        if (!is_null($this->cp["EQUIP_ID"]->GetValue()) and !strlen($this->cp["EQUIP_ID"]->GetText()) and !is_bool($this->cp["EQUIP_ID"]->GetValue())) 
            $this->cp["EQUIP_ID"]->SetValue($this->EQUIP_ID->GetValue(true));
        if (!is_null($this->cp["FOLLOW_UP"]->GetValue()) and !strlen($this->cp["FOLLOW_UP"]->GetText()) and !is_bool($this->cp["FOLLOW_UP"]->GetValue())) 
            $this->cp["FOLLOW_UP"]->SetValue($this->FOLLOW_UP->GetValue(true));
        if (!is_null($this->cp["assigned_emp_id"]->GetValue()) and !strlen($this->cp["assigned_emp_id"]->GetText()) and !is_bool($this->cp["assigned_emp_id"]->GetValue())) 
            $this->cp["assigned_emp_id"]->SetValue($this->assigned_emp_id->GetValue(true));
        if (!is_null($this->cp["REQUEST"]->GetValue()) and !strlen($this->cp["REQUEST"]->GetText()) and !is_bool($this->cp["REQUEST"]->GetValue())) 
            $this->cp["REQUEST"]->SetValue($this->REQUEST->GetValue(true));
        if (!is_null($this->cp["TA1"]->GetValue()) and !strlen($this->cp["TA1"]->GetText()) and !is_bool($this->cp["TA1"]->GetValue())) 
            $this->cp["TA1"]->SetValue($this->TA1->GetValue(true));
        if (!is_null($this->cp["TA2"]->GetValue()) and !strlen($this->cp["TA2"]->GetText()) and !is_bool($this->cp["TA2"]->GetValue())) 
            $this->cp["TA2"]->SetValue($this->TA2->GetValue(true));
        $wp->Criterion[1] = $wp->Operation(opEqual, "service_items_tbl.ORDER_NO", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsText),false);
        $wp->Criterion[2] = $wp->Operation(opEqual, "ITEM_NO", $wp->GetDBValue("2"), $this->ToSQL($wp->GetDBValue("2"), ccsInteger),false);
        $Where = $wp->opAND(
             false, 
             $wp->Criterion[1], 
             $wp->Criterion[2]);
        $this->UpdateFields["ORDER_NO"]["Value"] = $this->cp["ORDER_NO"]->GetDBValue(true);
        $this->UpdateFields["SERVICE_TYPE_ID"]["Value"] = $this->cp["SERVICE_TYPE_ID"]->GetDBValue(true);
        $this->UpdateFields["WARRANTY"]["Value"] = $this->cp["WARRANTY"]->GetDBValue(true);
        $this->UpdateFields["emp_id"]["Value"] = $this->cp["emp_id"]->GetDBValue(true);
        $this->UpdateFields["REMARKS"]["Value"] = $this->cp["REMARKS"]->GetDBValue(true);
        $this->UpdateFields["ITEM_NO"]["Value"] = $this->cp["ITEM_NO"]->GetDBValue(true);
        $this->UpdateFields["EQUIP_ID"]["Value"] = $this->cp["EQUIP_ID"]->GetDBValue(true);
        $this->UpdateFields["FOLLOW_UP"]["Value"] = $this->cp["FOLLOW_UP"]->GetDBValue(true);
        $this->UpdateFields["assigned_emp_id"]["Value"] = $this->cp["assigned_emp_id"]->GetDBValue(true);
        $this->UpdateFields["REQUEST"]["Value"] = $this->cp["REQUEST"]->GetDBValue(true);
        $this->UpdateFields["TA1"]["Value"] = $this->cp["TA1"]->GetDBValue(true);
        $this->UpdateFields["TA2"]["Value"] = $this->cp["TA2"]->GetDBValue(true);
        $this->SQL = CCBuildUpdate("service_items_tbl", $this->UpdateFields, $this);
        $this->SQL .= strlen($Where) ? " WHERE " . $Where : $Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

//Delete Method @5-D1C21867
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "sesORDER", ccsText, "", "", CCGetSession("ORDER", NULL), "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $wp->AddParameter("2", "urlITEM_NO", ccsInteger, "", "", CCGetFromGet("ITEM_NO", NULL), "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $wp->Criterion[1] = $wp->Operation(opEqual, "service_items_tbl.ORDER_NO", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsText),false);
        $wp->Criterion[2] = $wp->Operation(opEqual, "ITEM_NO", $wp->GetDBValue("2"), $this->ToSQL($wp->GetDBValue("2"), ccsInteger),false);
        $Where = $wp->opAND(
             false, 
             $wp->Criterion[1], 
             $wp->Criterion[2]);
        $this->SQL = "DELETE FROM service_items_tbl";
        $this->SQL = CCBuildSQL($this->SQL, $Where, "");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End service_items_tblDataSource Class @5-FCB6E20C

//Initialize Page @1-D68CF34A
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
$TemplateFileName = "page5_1.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-F08EF652
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$service_items_tbl = new clsRecordservice_items_tbl("", $MainPage);
$MainPage->service_items_tbl = & $service_items_tbl;
$service_items_tbl->Initialize();

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

//Execute Components @1-630C3D1E
$service_items_tbl->Operation();
//End Execute Components

//Go to destination page @1-1B2FFE42
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($service_items_tbl);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-6FD80F94
$service_items_tbl->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-DAD9F8C2
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($service_items_tbl);
unset($Tpl);
//End Unload Page


?>
