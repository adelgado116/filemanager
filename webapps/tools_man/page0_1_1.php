<?php
//Include Common Files @1-7713378D
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page0_1_1.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordtools { //tools Class @2-8CA86857

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

//Class_Initialize Event @2-C2DD048D
    function clsRecordtools($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record tools/Error";
        $this->DataSource = new clstoolsDataSource($this);
        $this->ds = & $this->DataSource;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "tools";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Update = & new clsButton("Button_Update", $Method, $this);
            $this->tool_description = & new clsControl(ccsTextBox, "tool_description", "Description", ccsText, "", CCGetRequestParam("tool_description", $Method, NULL), $this);
            $this->tool_description->Required = true;
            $this->tool_category_id = & new clsControl(ccsListBox, "tool_category_id", "Category Id", ccsInteger, "", CCGetRequestParam("tool_category_id", $Method, NULL), $this);
            $this->tool_category_id->DSType = dsTable;
            $this->tool_category_id->DataSource = new clsDBhss_db();
            $this->tool_category_id->ds = & $this->tool_category_id->DataSource;
            $this->tool_category_id->DataSource->SQL = "SELECT * \n" .
"FROM tools_categories {SQL_Where} {SQL_OrderBy}";
            $this->tool_category_id->DataSource->Order = "tool_category";
            list($this->tool_category_id->BoundColumn, $this->tool_category_id->TextColumn, $this->tool_category_id->DBFormat) = array("tool_category_id", "tool_category", "");
            $this->tool_category_id->DataSource->Order = "tool_category";
            $this->tool_category_id->Required = true;
            $this->tool_type_id = & new clsControl(ccsListBox, "tool_type_id", "Type Id", ccsInteger, "", CCGetRequestParam("tool_type_id", $Method, NULL), $this);
            $this->tool_type_id->DSType = dsTable;
            $this->tool_type_id->DataSource = new clsDBhss_db();
            $this->tool_type_id->ds = & $this->tool_type_id->DataSource;
            $this->tool_type_id->DataSource->SQL = "SELECT * \n" .
"FROM tools_types {SQL_Where} {SQL_OrderBy}";
            $this->tool_type_id->DataSource->Order = "tool_type";
            list($this->tool_type_id->BoundColumn, $this->tool_type_id->TextColumn, $this->tool_type_id->DBFormat) = array("tool_type_id", "tool_type", "");
            $this->tool_type_id->DataSource->Parameters["urltool_category_id"] = CCGetFromGet("tool_category_id", NULL);
            $this->tool_type_id->DataSource->wp = new clsSQLParameters();
            $this->tool_type_id->DataSource->wp->AddParameter("1", "urltool_category_id", ccsInteger, "", "", $this->tool_type_id->DataSource->Parameters["urltool_category_id"], "", false);
            $this->tool_type_id->DataSource->wp->Criterion[1] = $this->tool_type_id->DataSource->wp->Operation(opEqual, "tool_category_id", $this->tool_type_id->DataSource->wp->GetDBValue("1"), $this->tool_type_id->DataSource->ToSQL($this->tool_type_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->tool_type_id->DataSource->Where = 
                 $this->tool_type_id->DataSource->wp->Criterion[1];
            $this->tool_type_id->DataSource->Order = "tool_type";
            $this->tool_type_id->Required = true;
            $this->supplier_id = & new clsControl(ccsListBox, "supplier_id", "Supplier Id", ccsInteger, "", CCGetRequestParam("supplier_id", $Method, NULL), $this);
            $this->supplier_id->DSType = dsTable;
            $this->supplier_id->DataSource = new clsDBhss_db();
            $this->supplier_id->ds = & $this->supplier_id->DataSource;
            $this->supplier_id->DataSource->SQL = "SELECT * \n" .
"FROM tools_suppliers {SQL_Where} {SQL_OrderBy}";
            $this->supplier_id->DataSource->Order = "supplier_name";
            list($this->supplier_id->BoundColumn, $this->supplier_id->TextColumn, $this->supplier_id->DBFormat) = array("supplier_id", "supplier_name", "");
            $this->supplier_id->DataSource->Order = "supplier_name";
            $this->supplier_id->Required = true;
            $this->manufacturer_id = & new clsControl(ccsListBox, "manufacturer_id", "Manufacturer Id", ccsInteger, "", CCGetRequestParam("manufacturer_id", $Method, NULL), $this);
            $this->manufacturer_id->DSType = dsTable;
            $this->manufacturer_id->DataSource = new clsDBhss_db();
            $this->manufacturer_id->ds = & $this->manufacturer_id->DataSource;
            $this->manufacturer_id->DataSource->SQL = "SELECT * \n" .
"FROM tools_manufacturers {SQL_Where} {SQL_OrderBy}";
            $this->manufacturer_id->DataSource->Order = "manufacturer_name";
            list($this->manufacturer_id->BoundColumn, $this->manufacturer_id->TextColumn, $this->manufacturer_id->DBFormat) = array("manufacturer_id", "manufacturer_name", "");
            $this->manufacturer_id->DataSource->Order = "manufacturer_name";
            $this->manufacturer_id->Required = true;
            $this->date_of_purchase = & new clsControl(ccsTextBox, "date_of_purchase", "Date Of Purchase", ccsText, "", CCGetRequestParam("date_of_purchase", $Method, NULL), $this);
            $this->date_of_purchase->Required = true;
            $this->s_n = & new clsControl(ccsTextBox, "s_n", "S N", ccsText, "", CCGetRequestParam("s_n", $Method, NULL), $this);
            $this->voltage = & new clsControl(ccsTextBox, "voltage", "Voltage", ccsText, "", CCGetRequestParam("voltage", $Method, NULL), $this);
            $this->last_calibration_date = & new clsControl(ccsTextBox, "last_calibration_date", "Last Calibration Date", ccsText, "", CCGetRequestParam("last_calibration_date", $Method, NULL), $this);
            $this->regular_user_id = & new clsControl(ccsListBox, "regular_user_id", "Regular User Id", ccsInteger, "", CCGetRequestParam("regular_user_id", $Method, NULL), $this);
            $this->regular_user_id->DSType = dsTable;
            $this->regular_user_id->DataSource = new clsDBhss_db();
            $this->regular_user_id->ds = & $this->regular_user_id->DataSource;
            $this->regular_user_id->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            $this->regular_user_id->DataSource->Order = "emp_login";
            list($this->regular_user_id->BoundColumn, $this->regular_user_id->TextColumn, $this->regular_user_id->DBFormat) = array("emp_id", "emp_login", "");
            $this->regular_user_id->DataSource->Order = "emp_login";
            $this->regular_user_id->Required = true;
            $this->Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", $Method, NULL), $this);
            $this->Link1->Page = "tools_categories.php";
            $this->location = & new clsControl(ccsTextBox, "location", "Location", ccsText, "", CCGetRequestParam("location", $Method, NULL), $this);
            $this->price = & new clsControl(ccsTextBox, "price", "Price", ccsSingle, "", CCGetRequestParam("price", $Method, NULL), $this);
            $this->price->Required = true;
            $this->next_calibration_date = & new clsControl(ccsTextBox, "next_calibration_date", "Next Calibration Date", ccsText, "", CCGetRequestParam("next_calibration_date", $Method, NULL), $this);
            $this->current_user_id = & new clsControl(ccsListBox, "current_user_id", "Current User Id", ccsInteger, "", CCGetRequestParam("current_user_id", $Method, NULL), $this);
            $this->current_user_id->DSType = dsTable;
            $this->current_user_id->DataSource = new clsDBhss_db();
            $this->current_user_id->ds = & $this->current_user_id->DataSource;
            $this->current_user_id->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            $this->current_user_id->DataSource->Order = "emp_login";
            list($this->current_user_id->BoundColumn, $this->current_user_id->TextColumn, $this->current_user_id->DBFormat) = array("emp_id", "emp_login", "");
            $this->current_user_id->DataSource->Order = "emp_login";
            $this->current_user_id->Required = true;
            $this->tool_status_id = & new clsControl(ccsListBox, "tool_status_id", "Status Id", ccsInteger, "", CCGetRequestParam("tool_status_id", $Method, NULL), $this);
            $this->tool_status_id->DSType = dsTable;
            $this->tool_status_id->DataSource = new clsDBhss_db();
            $this->tool_status_id->ds = & $this->tool_status_id->DataSource;
            $this->tool_status_id->DataSource->SQL = "SELECT * \n" .
"FROM tools_status {SQL_Where} {SQL_OrderBy}";
            $this->tool_status_id->DataSource->Order = "tool_status";
            list($this->tool_status_id->BoundColumn, $this->tool_status_id->TextColumn, $this->tool_status_id->DBFormat) = array("tool_status_id", "tool_status", "");
            $this->tool_status_id->DataSource->Order = "tool_status";
            $this->tool_status_id->Required = true;
            $this->Link2 = & new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", $Method, NULL), $this);
            $this->Link2->Page = "tools_types.php";
            $this->Link3 = & new clsControl(ccsLink, "Link3", "Link3", ccsText, "", CCGetRequestParam("Link3", $Method, NULL), $this);
            $this->Link3->Page = "tools_suppliers.php";
            $this->Link4 = & new clsControl(ccsLink, "Link4", "Link4", ccsText, "", CCGetRequestParam("Link4", $Method, NULL), $this);
            $this->Link4->Page = "tools_manufacturers.php";
            $this->DatePicker_date_of_purchase1 = & new clsDatePicker("DatePicker_date_of_purchase1", "tools", "date_of_purchase", $this);
            $this->DatePicker_last_calibration_date1 = & new clsDatePicker("DatePicker_last_calibration_date1", "tools", "last_calibration_date", $this);
            $this->DatePicker_next_calibration_date1 = & new clsDatePicker("DatePicker_next_calibration_date1", "tools", "next_calibration_date", $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @2-79AF4415
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urltool_id"] = CCGetFromGet("tool_id", NULL);
    }
//End Initialize Method

//Validate Method @2-3A927120
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->tool_description->Validate() && $Validation);
        $Validation = ($this->tool_category_id->Validate() && $Validation);
        $Validation = ($this->tool_type_id->Validate() && $Validation);
        $Validation = ($this->supplier_id->Validate() && $Validation);
        $Validation = ($this->manufacturer_id->Validate() && $Validation);
        $Validation = ($this->date_of_purchase->Validate() && $Validation);
        $Validation = ($this->s_n->Validate() && $Validation);
        $Validation = ($this->voltage->Validate() && $Validation);
        $Validation = ($this->last_calibration_date->Validate() && $Validation);
        $Validation = ($this->regular_user_id->Validate() && $Validation);
        $Validation = ($this->location->Validate() && $Validation);
        $Validation = ($this->price->Validate() && $Validation);
        $Validation = ($this->next_calibration_date->Validate() && $Validation);
        $Validation = ($this->current_user_id->Validate() && $Validation);
        $Validation = ($this->tool_status_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->tool_description->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tool_category_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tool_type_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->supplier_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->manufacturer_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date_of_purchase->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_n->Errors->Count() == 0);
        $Validation =  $Validation && ($this->voltage->Errors->Count() == 0);
        $Validation =  $Validation && ($this->last_calibration_date->Errors->Count() == 0);
        $Validation =  $Validation && ($this->regular_user_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->location->Errors->Count() == 0);
        $Validation =  $Validation && ($this->price->Errors->Count() == 0);
        $Validation =  $Validation && ($this->next_calibration_date->Errors->Count() == 0);
        $Validation =  $Validation && ($this->current_user_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tool_status_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-D40A08A0
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tool_description->Errors->Count());
        $errors = ($errors || $this->tool_category_id->Errors->Count());
        $errors = ($errors || $this->tool_type_id->Errors->Count());
        $errors = ($errors || $this->supplier_id->Errors->Count());
        $errors = ($errors || $this->manufacturer_id->Errors->Count());
        $errors = ($errors || $this->date_of_purchase->Errors->Count());
        $errors = ($errors || $this->s_n->Errors->Count());
        $errors = ($errors || $this->voltage->Errors->Count());
        $errors = ($errors || $this->last_calibration_date->Errors->Count());
        $errors = ($errors || $this->regular_user_id->Errors->Count());
        $errors = ($errors || $this->Link1->Errors->Count());
        $errors = ($errors || $this->location->Errors->Count());
        $errors = ($errors || $this->price->Errors->Count());
        $errors = ($errors || $this->next_calibration_date->Errors->Count());
        $errors = ($errors || $this->current_user_id->Errors->Count());
        $errors = ($errors || $this->tool_status_id->Errors->Count());
        $errors = ($errors || $this->Link2->Errors->Count());
        $errors = ($errors || $this->Link3->Errors->Count());
        $errors = ($errors || $this->Link4->Errors->Count());
        $errors = ($errors || $this->DatePicker_date_of_purchase1->Errors->Count());
        $errors = ($errors || $this->DatePicker_last_calibration_date1->Errors->Count());
        $errors = ($errors || $this->DatePicker_next_calibration_date1->Errors->Count());
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

//Operation Method @2-C170117D
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
            $this->PressedButton = $this->EditMode ? "Button_Update" : "";
            if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            }
        }
        $Redirect = $FileName;
        if($this->Validate()) {
            if($this->PressedButton == "Button_Update") {
                $Redirect = "page0_1_1_close_handler.php";
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

//UpdateRow Method @2-07B5185E
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tool_description->SetValue($this->tool_description->GetValue(true));
        $this->DataSource->tool_category_id->SetValue($this->tool_category_id->GetValue(true));
        $this->DataSource->tool_type_id->SetValue($this->tool_type_id->GetValue(true));
        $this->DataSource->supplier_id->SetValue($this->supplier_id->GetValue(true));
        $this->DataSource->manufacturer_id->SetValue($this->manufacturer_id->GetValue(true));
        $this->DataSource->date_of_purchase->SetValue($this->date_of_purchase->GetValue(true));
        $this->DataSource->s_n->SetValue($this->s_n->GetValue(true));
        $this->DataSource->voltage->SetValue($this->voltage->GetValue(true));
        $this->DataSource->last_calibration_date->SetValue($this->last_calibration_date->GetValue(true));
        $this->DataSource->regular_user_id->SetValue($this->regular_user_id->GetValue(true));
        $this->DataSource->Link1->SetValue($this->Link1->GetValue(true));
        $this->DataSource->location->SetValue($this->location->GetValue(true));
        $this->DataSource->price->SetValue($this->price->GetValue(true));
        $this->DataSource->next_calibration_date->SetValue($this->next_calibration_date->GetValue(true));
        $this->DataSource->current_user_id->SetValue($this->current_user_id->GetValue(true));
        $this->DataSource->tool_status_id->SetValue($this->tool_status_id->GetValue(true));
        $this->DataSource->Link2->SetValue($this->Link2->GetValue(true));
        $this->DataSource->Link3->SetValue($this->Link3->GetValue(true));
        $this->DataSource->Link4->SetValue($this->Link4->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-B8A245C2
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

        $this->tool_category_id->Prepare();
        $this->tool_type_id->Prepare();
        $this->supplier_id->Prepare();
        $this->manufacturer_id->Prepare();
        $this->regular_user_id->Prepare();
        $this->current_user_id->Prepare();
        $this->tool_status_id->Prepare();

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
                    $this->tool_description->SetValue($this->DataSource->tool_description->GetValue());
                    $this->tool_category_id->SetValue($this->DataSource->tool_category_id->GetValue());
                    $this->tool_type_id->SetValue($this->DataSource->tool_type_id->GetValue());
                    $this->supplier_id->SetValue($this->DataSource->supplier_id->GetValue());
                    $this->manufacturer_id->SetValue($this->DataSource->manufacturer_id->GetValue());
                    $this->date_of_purchase->SetValue($this->DataSource->date_of_purchase->GetValue());
                    $this->s_n->SetValue($this->DataSource->s_n->GetValue());
                    $this->voltage->SetValue($this->DataSource->voltage->GetValue());
                    $this->last_calibration_date->SetValue($this->DataSource->last_calibration_date->GetValue());
                    $this->regular_user_id->SetValue($this->DataSource->regular_user_id->GetValue());
                    $this->location->SetValue($this->DataSource->location->GetValue());
                    $this->price->SetValue($this->DataSource->price->GetValue());
                    $this->next_calibration_date->SetValue($this->DataSource->next_calibration_date->GetValue());
                    $this->current_user_id->SetValue($this->DataSource->current_user_id->GetValue());
                    $this->tool_status_id->SetValue($this->DataSource->tool_status_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tool_description->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tool_category_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tool_type_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->supplier_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->manufacturer_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date_of_purchase->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_n->Errors->ToString());
            $Error = ComposeStrings($Error, $this->voltage->Errors->ToString());
            $Error = ComposeStrings($Error, $this->last_calibration_date->Errors->ToString());
            $Error = ComposeStrings($Error, $this->regular_user_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Link1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->location->Errors->ToString());
            $Error = ComposeStrings($Error, $this->price->Errors->ToString());
            $Error = ComposeStrings($Error, $this->next_calibration_date->Errors->ToString());
            $Error = ComposeStrings($Error, $this->current_user_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tool_status_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Link2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Link3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Link4->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_date_of_purchase1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_last_calibration_date1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_next_calibration_date1->Errors->ToString());
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

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Update->Show();
        $this->tool_description->Show();
        $this->tool_category_id->Show();
        $this->tool_type_id->Show();
        $this->supplier_id->Show();
        $this->manufacturer_id->Show();
        $this->date_of_purchase->Show();
        $this->s_n->Show();
        $this->voltage->Show();
        $this->last_calibration_date->Show();
        $this->regular_user_id->Show();
        $this->Link1->Show();
        $this->location->Show();
        $this->price->Show();
        $this->next_calibration_date->Show();
        $this->current_user_id->Show();
        $this->tool_status_id->Show();
        $this->Link2->Show();
        $this->Link3->Show();
        $this->Link4->Show();
        $this->DatePicker_date_of_purchase1->Show();
        $this->DatePicker_last_calibration_date1->Show();
        $this->DatePicker_next_calibration_date1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End tools Class @2-FCB6E20C

class clstoolsDataSource extends clsDBhss_db {  //toolsDataSource Class @2-F2CF8EBD

//DataSource Variables @2-648CFBEC
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $UpdateParameters;
    var $wp;
    var $AllParametersSet;

    var $UpdateFields = array();

    // Datasource fields
    var $tool_description;
    var $tool_category_id;
    var $tool_type_id;
    var $supplier_id;
    var $manufacturer_id;
    var $date_of_purchase;
    var $s_n;
    var $voltage;
    var $last_calibration_date;
    var $regular_user_id;
    var $Link1;
    var $location;
    var $price;
    var $next_calibration_date;
    var $current_user_id;
    var $tool_status_id;
    var $Link2;
    var $Link3;
    var $Link4;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-38DA0E7C
    function clstoolsDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record tools/Error";
        $this->Initialize();
        $this->tool_description = new clsField("tool_description", ccsText, "");
        
        $this->tool_category_id = new clsField("tool_category_id", ccsInteger, "");
        
        $this->tool_type_id = new clsField("tool_type_id", ccsInteger, "");
        
        $this->supplier_id = new clsField("supplier_id", ccsInteger, "");
        
        $this->manufacturer_id = new clsField("manufacturer_id", ccsInteger, "");
        
        $this->date_of_purchase = new clsField("date_of_purchase", ccsText, "");
        
        $this->s_n = new clsField("s_n", ccsText, "");
        
        $this->voltage = new clsField("voltage", ccsText, "");
        
        $this->last_calibration_date = new clsField("last_calibration_date", ccsText, "");
        
        $this->regular_user_id = new clsField("regular_user_id", ccsInteger, "");
        
        $this->Link1 = new clsField("Link1", ccsText, "");
        
        $this->location = new clsField("location", ccsText, "");
        
        $this->price = new clsField("price", ccsSingle, "");
        
        $this->next_calibration_date = new clsField("next_calibration_date", ccsText, "");
        
        $this->current_user_id = new clsField("current_user_id", ccsInteger, "");
        
        $this->tool_status_id = new clsField("tool_status_id", ccsInteger, "");
        
        $this->Link2 = new clsField("Link2", ccsText, "");
        
        $this->Link3 = new clsField("Link3", ccsText, "");
        
        $this->Link4 = new clsField("Link4", ccsText, "");
        

        $this->UpdateFields["tool_description"] = array("Name" => "tool_description", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tool_category_id"] = array("Name" => "tool_category_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tool_type_id"] = array("Name" => "tool_type_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["supplier_id"] = array("Name" => "supplier_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["manufacturer_id"] = array("Name" => "manufacturer_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["date_of_purchase"] = array("Name" => "date_of_purchase", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["s_n"] = array("Name" => "s_n", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["voltage"] = array("Name" => "voltage", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["last_calibration_date"] = array("Name" => "last_calibration_date", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["regular_user_id"] = array("Name" => "regular_user_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["location"] = array("Name" => "location", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["price"] = array("Name" => "price", "Value" => "", "DataType" => ccsSingle, "OmitIfEmpty" => 1);
        $this->UpdateFields["next_calibration_date"] = array("Name" => "next_calibration_date", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["current_user_id"] = array("Name" => "current_user_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tool_status_id"] = array("Name" => "tool_status_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-1906CD1E
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urltool_id", ccsInteger, "", "", $this->Parameters["urltool_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "tool_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-733B87AE
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM tools {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-6182989E
    function SetValues()
    {
        $this->tool_description->SetDBValue($this->f("tool_description"));
        $this->tool_category_id->SetDBValue(trim($this->f("tool_category_id")));
        $this->tool_type_id->SetDBValue(trim($this->f("tool_type_id")));
        $this->supplier_id->SetDBValue(trim($this->f("supplier_id")));
        $this->manufacturer_id->SetDBValue(trim($this->f("manufacturer_id")));
        $this->date_of_purchase->SetDBValue($this->f("date_of_purchase"));
        $this->s_n->SetDBValue($this->f("s_n"));
        $this->voltage->SetDBValue($this->f("voltage"));
        $this->last_calibration_date->SetDBValue($this->f("last_calibration_date"));
        $this->regular_user_id->SetDBValue(trim($this->f("regular_user_id")));
        $this->location->SetDBValue($this->f("location"));
        $this->price->SetDBValue(trim($this->f("price")));
        $this->next_calibration_date->SetDBValue($this->f("next_calibration_date"));
        $this->current_user_id->SetDBValue(trim($this->f("current_user_id")));
        $this->tool_status_id->SetDBValue(trim($this->f("tool_status_id")));
    }
//End SetValues Method

//Update Method @2-E3F039AF
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["tool_description"]["Value"] = $this->tool_description->GetDBValue(true);
        $this->UpdateFields["tool_category_id"]["Value"] = $this->tool_category_id->GetDBValue(true);
        $this->UpdateFields["tool_type_id"]["Value"] = $this->tool_type_id->GetDBValue(true);
        $this->UpdateFields["supplier_id"]["Value"] = $this->supplier_id->GetDBValue(true);
        $this->UpdateFields["manufacturer_id"]["Value"] = $this->manufacturer_id->GetDBValue(true);
        $this->UpdateFields["date_of_purchase"]["Value"] = $this->date_of_purchase->GetDBValue(true);
        $this->UpdateFields["s_n"]["Value"] = $this->s_n->GetDBValue(true);
        $this->UpdateFields["voltage"]["Value"] = $this->voltage->GetDBValue(true);
        $this->UpdateFields["last_calibration_date"]["Value"] = $this->last_calibration_date->GetDBValue(true);
        $this->UpdateFields["regular_user_id"]["Value"] = $this->regular_user_id->GetDBValue(true);
        $this->UpdateFields["location"]["Value"] = $this->location->GetDBValue(true);
        $this->UpdateFields["price"]["Value"] = $this->price->GetDBValue(true);
        $this->UpdateFields["next_calibration_date"]["Value"] = $this->next_calibration_date->GetDBValue(true);
        $this->UpdateFields["current_user_id"]["Value"] = $this->current_user_id->GetDBValue(true);
        $this->UpdateFields["tool_status_id"]["Value"] = $this->tool_status_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tools", $this->UpdateFields, $this);
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

} //End toolsDataSource Class @2-FCB6E20C

//Initialize Page @1-D25AD5EB
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
$TemplateFileName = "page0_1_1.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-E85F26C2
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tools = & new clsRecordtools("", $MainPage);
$MainPage->tools = & $tools;
$tools->Initialize();

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

//Execute Components @1-1DA9D6CF
$tools->Operation();
//End Execute Components

//Go to destination page @1-15471CC8
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($tools);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-097FF6E8
$tools->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-2EE9E300
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($tools);
unset($Tpl);
//End Unload Page


?>
