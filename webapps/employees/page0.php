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

class clsRecordemployees_tbl { //employees_tbl Class @2-2229F46A

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

//Class_Initialize Event @2-BA491336
    function clsRecordemployees_tbl($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record employees_tbl/Error";
        $this->DataSource = new clsemployees_tblDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "employees_tbl";
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
            $this->emp_login = & new clsControl(ccsTextBox, "emp_login", "Emp Login", ccsText, "", CCGetRequestParam("emp_login", $Method, NULL), $this);
            $this->emp_password = & new clsControl(ccsTextBox, "emp_password", "Emp Password", ccsText, "", CCGetRequestParam("emp_password", $Method, NULL), $this);
            $this->emp_name = & new clsControl(ccsTextBox, "emp_name", "Emp Name", ccsText, "", CCGetRequestParam("emp_name", $Method, NULL), $this);
            $this->group_id = & new clsControl(ccsListBox, "group_id", "Group Id", ccsInteger, "", CCGetRequestParam("group_id", $Method, NULL), $this);
            $this->group_id->DSType = dsTable;
            $this->group_id->DataSource = new clsDBhss_db();
            $this->group_id->ds = & $this->group_id->DataSource;
            $this->group_id->DataSource->SQL = "SELECT * \n" .
"FROM groups_tbl {SQL_Where} {SQL_OrderBy}";
            $this->group_id->DataSource->Order = "group_name";
            list($this->group_id->BoundColumn, $this->group_id->TextColumn, $this->group_id->DBFormat) = array("group_id", "group_name", "");
            $this->group_id->DataSource->Order = "group_name";
            $this->department_id = & new clsControl(ccsListBox, "department_id", "Department Id", ccsInteger, "", CCGetRequestParam("department_id", $Method, NULL), $this);
            $this->department_id->DSType = dsTable;
            $this->department_id->DataSource = new clsDBhss_db();
            $this->department_id->ds = & $this->department_id->DataSource;
            $this->department_id->DataSource->SQL = "SELECT * \n" .
"FROM departments_tbl {SQL_Where} {SQL_OrderBy}";
            $this->department_id->DataSource->Order = "department_name";
            list($this->department_id->BoundColumn, $this->department_id->TextColumn, $this->department_id->DBFormat) = array("department_id", "department_name", "");
            $this->department_id->DataSource->Order = "department_name";
            $this->phone_home = & new clsControl(ccsTextBox, "phone_home", "Phone Home", ccsText, "", CCGetRequestParam("phone_home", $Method, NULL), $this);
            $this->phone_work = & new clsControl(ccsTextBox, "phone_work", "Phone Work", ccsText, "", CCGetRequestParam("phone_work", $Method, NULL), $this);
            $this->phone_cell = & new clsControl(ccsTextBox, "phone_cell", "Phone Cell", ccsText, "", CCGetRequestParam("phone_cell", $Method, NULL), $this);
            $this->fax = & new clsControl(ccsTextBox, "fax", "Fax", ccsText, "", CCGetRequestParam("fax", $Method, NULL), $this);
            $this->email = & new clsControl(ccsTextBox, "email", "Email", ccsText, "", CCGetRequestParam("email", $Method, NULL), $this);
            $this->city = & new clsControl(ccsListBox, "city", "City", ccsText, "", CCGetRequestParam("city", $Method, NULL), $this);
            $this->city->DSType = dsTable;
            $this->city->DataSource = new clsDBhss_db();
            $this->city->ds = & $this->city->DataSource;
            $this->city->DataSource->SQL = "SELECT * \n" .
"FROM cities_tbl {SQL_Where} {SQL_OrderBy}";
            $this->city->DataSource->Order = "city_name";
            list($this->city->BoundColumn, $this->city->TextColumn, $this->city->DBFormat) = array("city_id", "city_name", "");
            $this->city->DataSource->Order = "city_name";
            $this->zip = & new clsControl(ccsTextBox, "zip", "Zip", ccsText, "", CCGetRequestParam("zip", $Method, NULL), $this);
            $this->address = & new clsControl(ccsTextBox, "address", "Address", ccsText, "", CCGetRequestParam("address", $Method, NULL), $this);
            $this->picture = & new clsControl(ccsTextBox, "picture", "Picture", ccsText, "", CCGetRequestParam("picture", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @2-5B4B7CB3
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlemp_id"] = CCGetFromGet("emp_id", NULL);
    }
//End Initialize Method

//Validate Method @2-DF8425F6
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->emp_login->Validate() && $Validation);
        $Validation = ($this->emp_password->Validate() && $Validation);
        $Validation = ($this->emp_name->Validate() && $Validation);
        $Validation = ($this->group_id->Validate() && $Validation);
        $Validation = ($this->department_id->Validate() && $Validation);
        $Validation = ($this->phone_home->Validate() && $Validation);
        $Validation = ($this->phone_work->Validate() && $Validation);
        $Validation = ($this->phone_cell->Validate() && $Validation);
        $Validation = ($this->fax->Validate() && $Validation);
        $Validation = ($this->email->Validate() && $Validation);
        $Validation = ($this->city->Validate() && $Validation);
        $Validation = ($this->zip->Validate() && $Validation);
        $Validation = ($this->address->Validate() && $Validation);
        $Validation = ($this->picture->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->emp_login->Errors->Count() == 0);
        $Validation =  $Validation && ($this->emp_password->Errors->Count() == 0);
        $Validation =  $Validation && ($this->emp_name->Errors->Count() == 0);
        $Validation =  $Validation && ($this->group_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->department_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->phone_home->Errors->Count() == 0);
        $Validation =  $Validation && ($this->phone_work->Errors->Count() == 0);
        $Validation =  $Validation && ($this->phone_cell->Errors->Count() == 0);
        $Validation =  $Validation && ($this->fax->Errors->Count() == 0);
        $Validation =  $Validation && ($this->email->Errors->Count() == 0);
        $Validation =  $Validation && ($this->city->Errors->Count() == 0);
        $Validation =  $Validation && ($this->zip->Errors->Count() == 0);
        $Validation =  $Validation && ($this->address->Errors->Count() == 0);
        $Validation =  $Validation && ($this->picture->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-A531B9D5
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->emp_login->Errors->Count());
        $errors = ($errors || $this->emp_password->Errors->Count());
        $errors = ($errors || $this->emp_name->Errors->Count());
        $errors = ($errors || $this->group_id->Errors->Count());
        $errors = ($errors || $this->department_id->Errors->Count());
        $errors = ($errors || $this->phone_home->Errors->Count());
        $errors = ($errors || $this->phone_work->Errors->Count());
        $errors = ($errors || $this->phone_cell->Errors->Count());
        $errors = ($errors || $this->fax->Errors->Count());
        $errors = ($errors || $this->email->Errors->Count());
        $errors = ($errors || $this->city->Errors->Count());
        $errors = ($errors || $this->zip->Errors->Count());
        $errors = ($errors || $this->address->Errors->Count());
        $errors = ($errors || $this->picture->Errors->Count());
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

//Operation Method @2-A2FB6656
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
            $Redirect = "index.html" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
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

//InsertRow Method @2-8FE01E69
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->emp_login->SetValue($this->emp_login->GetValue(true));
        $this->DataSource->emp_password->SetValue($this->emp_password->GetValue(true));
        $this->DataSource->emp_name->SetValue($this->emp_name->GetValue(true));
        $this->DataSource->group_id->SetValue($this->group_id->GetValue(true));
        $this->DataSource->department_id->SetValue($this->department_id->GetValue(true));
        $this->DataSource->phone_home->SetValue($this->phone_home->GetValue(true));
        $this->DataSource->phone_work->SetValue($this->phone_work->GetValue(true));
        $this->DataSource->phone_cell->SetValue($this->phone_cell->GetValue(true));
        $this->DataSource->fax->SetValue($this->fax->GetValue(true));
        $this->DataSource->email->SetValue($this->email->GetValue(true));
        $this->DataSource->city->SetValue($this->city->GetValue(true));
        $this->DataSource->zip->SetValue($this->zip->GetValue(true));
        $this->DataSource->address->SetValue($this->address->GetValue(true));
        $this->DataSource->picture->SetValue($this->picture->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-6ABD7508
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->emp_login->SetValue($this->emp_login->GetValue(true));
        $this->DataSource->emp_password->SetValue($this->emp_password->GetValue(true));
        $this->DataSource->emp_name->SetValue($this->emp_name->GetValue(true));
        $this->DataSource->group_id->SetValue($this->group_id->GetValue(true));
        $this->DataSource->department_id->SetValue($this->department_id->GetValue(true));
        $this->DataSource->phone_home->SetValue($this->phone_home->GetValue(true));
        $this->DataSource->phone_work->SetValue($this->phone_work->GetValue(true));
        $this->DataSource->phone_cell->SetValue($this->phone_cell->GetValue(true));
        $this->DataSource->fax->SetValue($this->fax->GetValue(true));
        $this->DataSource->email->SetValue($this->email->GetValue(true));
        $this->DataSource->city->SetValue($this->city->GetValue(true));
        $this->DataSource->zip->SetValue($this->zip->GetValue(true));
        $this->DataSource->address->SetValue($this->address->GetValue(true));
        $this->DataSource->picture->SetValue($this->picture->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-37DDE342
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

        $this->group_id->Prepare();
        $this->department_id->Prepare();
        $this->city->Prepare();

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
                    $this->emp_login->SetValue($this->DataSource->emp_login->GetValue());
                    $this->emp_password->SetValue($this->DataSource->emp_password->GetValue());
                    $this->emp_name->SetValue($this->DataSource->emp_name->GetValue());
                    $this->group_id->SetValue($this->DataSource->group_id->GetValue());
                    $this->department_id->SetValue($this->DataSource->department_id->GetValue());
                    $this->phone_home->SetValue($this->DataSource->phone_home->GetValue());
                    $this->phone_work->SetValue($this->DataSource->phone_work->GetValue());
                    $this->phone_cell->SetValue($this->DataSource->phone_cell->GetValue());
                    $this->fax->SetValue($this->DataSource->fax->GetValue());
                    $this->email->SetValue($this->DataSource->email->GetValue());
                    $this->city->SetValue($this->DataSource->city->GetValue());
                    $this->zip->SetValue($this->DataSource->zip->GetValue());
                    $this->address->SetValue($this->DataSource->address->GetValue());
                    $this->picture->SetValue($this->DataSource->picture->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->emp_login->Errors->ToString());
            $Error = ComposeStrings($Error, $this->emp_password->Errors->ToString());
            $Error = ComposeStrings($Error, $this->emp_name->Errors->ToString());
            $Error = ComposeStrings($Error, $this->group_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->department_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->phone_home->Errors->ToString());
            $Error = ComposeStrings($Error, $this->phone_work->Errors->ToString());
            $Error = ComposeStrings($Error, $this->phone_cell->Errors->ToString());
            $Error = ComposeStrings($Error, $this->fax->Errors->ToString());
            $Error = ComposeStrings($Error, $this->email->Errors->ToString());
            $Error = ComposeStrings($Error, $this->city->Errors->ToString());
            $Error = ComposeStrings($Error, $this->zip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->address->Errors->ToString());
            $Error = ComposeStrings($Error, $this->picture->Errors->ToString());
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
        $this->emp_login->Show();
        $this->emp_password->Show();
        $this->emp_name->Show();
        $this->group_id->Show();
        $this->department_id->Show();
        $this->phone_home->Show();
        $this->phone_work->Show();
        $this->phone_cell->Show();
        $this->fax->Show();
        $this->email->Show();
        $this->city->Show();
        $this->zip->Show();
        $this->address->Show();
        $this->picture->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End employees_tbl Class @2-FCB6E20C

class clsemployees_tblDataSource extends clsDBhss_db {  //employees_tblDataSource Class @2-82429F6B

//DataSource Variables @2-4AA8D372
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
    var $emp_login;
    var $emp_password;
    var $emp_name;
    var $group_id;
    var $department_id;
    var $phone_home;
    var $phone_work;
    var $phone_cell;
    var $fax;
    var $email;
    var $city;
    var $zip;
    var $address;
    var $picture;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-51BE7D47
    function clsemployees_tblDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record employees_tbl/Error";
        $this->Initialize();
        $this->emp_login = new clsField("emp_login", ccsText, "");
        
        $this->emp_password = new clsField("emp_password", ccsText, "");
        
        $this->emp_name = new clsField("emp_name", ccsText, "");
        
        $this->group_id = new clsField("group_id", ccsInteger, "");
        
        $this->department_id = new clsField("department_id", ccsInteger, "");
        
        $this->phone_home = new clsField("phone_home", ccsText, "");
        
        $this->phone_work = new clsField("phone_work", ccsText, "");
        
        $this->phone_cell = new clsField("phone_cell", ccsText, "");
        
        $this->fax = new clsField("fax", ccsText, "");
        
        $this->email = new clsField("email", ccsText, "");
        
        $this->city = new clsField("city", ccsText, "");
        
        $this->zip = new clsField("zip", ccsText, "");
        
        $this->address = new clsField("address", ccsText, "");
        
        $this->picture = new clsField("picture", ccsText, "");
        

        $this->InsertFields["emp_login"] = array("Name" => "emp_login", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["emp_password"] = array("Name" => "emp_password", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["emp_name"] = array("Name" => "emp_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["group_id"] = array("Name" => "group_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["department_id"] = array("Name" => "department_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["phone_home"] = array("Name" => "phone_home", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["phone_work"] = array("Name" => "phone_work", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["phone_cell"] = array("Name" => "phone_cell", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["fax"] = array("Name" => "fax", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["email"] = array("Name" => "email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["city"] = array("Name" => "city", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["zip"] = array("Name" => "zip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["address"] = array("Name" => "address", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["picture"] = array("Name" => "picture", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["emp_login"] = array("Name" => "emp_login", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["emp_password"] = array("Name" => "emp_password", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["emp_name"] = array("Name" => "emp_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["group_id"] = array("Name" => "group_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["department_id"] = array("Name" => "department_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["phone_home"] = array("Name" => "phone_home", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["phone_work"] = array("Name" => "phone_work", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["phone_cell"] = array("Name" => "phone_cell", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["fax"] = array("Name" => "fax", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["email"] = array("Name" => "email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["city"] = array("Name" => "city", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["zip"] = array("Name" => "zip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["address"] = array("Name" => "address", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["picture"] = array("Name" => "picture", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-1A451117
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlemp_id", ccsInteger, "", "", $this->Parameters["urlemp_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "emp_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-56F6DC51
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-587115C2
    function SetValues()
    {
        $this->emp_login->SetDBValue($this->f("emp_login"));
        $this->emp_password->SetDBValue($this->f("emp_password"));
        $this->emp_name->SetDBValue($this->f("emp_name"));
        $this->group_id->SetDBValue(trim($this->f("group_id")));
        $this->department_id->SetDBValue(trim($this->f("department_id")));
        $this->phone_home->SetDBValue($this->f("phone_home"));
        $this->phone_work->SetDBValue($this->f("phone_work"));
        $this->phone_cell->SetDBValue($this->f("phone_cell"));
        $this->fax->SetDBValue($this->f("fax"));
        $this->email->SetDBValue($this->f("email"));
        $this->city->SetDBValue($this->f("city"));
        $this->zip->SetDBValue($this->f("zip"));
        $this->address->SetDBValue($this->f("address"));
        $this->picture->SetDBValue($this->f("picture"));
    }
//End SetValues Method

//Insert Method @2-D3C6FED1
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["emp_login"]["Value"] = $this->emp_login->GetDBValue(true);
        $this->InsertFields["emp_password"]["Value"] = $this->emp_password->GetDBValue(true);
        $this->InsertFields["emp_name"]["Value"] = $this->emp_name->GetDBValue(true);
        $this->InsertFields["group_id"]["Value"] = $this->group_id->GetDBValue(true);
        $this->InsertFields["department_id"]["Value"] = $this->department_id->GetDBValue(true);
        $this->InsertFields["phone_home"]["Value"] = $this->phone_home->GetDBValue(true);
        $this->InsertFields["phone_work"]["Value"] = $this->phone_work->GetDBValue(true);
        $this->InsertFields["phone_cell"]["Value"] = $this->phone_cell->GetDBValue(true);
        $this->InsertFields["fax"]["Value"] = $this->fax->GetDBValue(true);
        $this->InsertFields["email"]["Value"] = $this->email->GetDBValue(true);
        $this->InsertFields["city"]["Value"] = $this->city->GetDBValue(true);
        $this->InsertFields["zip"]["Value"] = $this->zip->GetDBValue(true);
        $this->InsertFields["address"]["Value"] = $this->address->GetDBValue(true);
        $this->InsertFields["picture"]["Value"] = $this->picture->GetDBValue(true);
        $this->SQL = CCBuildInsert("employees_tbl", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-AFB1FD7C
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["emp_login"]["Value"] = $this->emp_login->GetDBValue(true);
        $this->UpdateFields["emp_password"]["Value"] = $this->emp_password->GetDBValue(true);
        $this->UpdateFields["emp_name"]["Value"] = $this->emp_name->GetDBValue(true);
        $this->UpdateFields["group_id"]["Value"] = $this->group_id->GetDBValue(true);
        $this->UpdateFields["department_id"]["Value"] = $this->department_id->GetDBValue(true);
        $this->UpdateFields["phone_home"]["Value"] = $this->phone_home->GetDBValue(true);
        $this->UpdateFields["phone_work"]["Value"] = $this->phone_work->GetDBValue(true);
        $this->UpdateFields["phone_cell"]["Value"] = $this->phone_cell->GetDBValue(true);
        $this->UpdateFields["fax"]["Value"] = $this->fax->GetDBValue(true);
        $this->UpdateFields["email"]["Value"] = $this->email->GetDBValue(true);
        $this->UpdateFields["city"]["Value"] = $this->city->GetDBValue(true);
        $this->UpdateFields["zip"]["Value"] = $this->zip->GetDBValue(true);
        $this->UpdateFields["address"]["Value"] = $this->address->GetDBValue(true);
        $this->UpdateFields["picture"]["Value"] = $this->picture->GetDBValue(true);
        $this->SQL = CCBuildUpdate("employees_tbl", $this->UpdateFields, $this);
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

} //End employees_tblDataSource Class @2-FCB6E20C

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

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-046D393B
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$employees_tbl = & new clsRecordemployees_tbl("", $MainPage);
$MainPage->employees_tbl = & $employees_tbl;
$employees_tbl->Initialize();

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

//Execute Components @1-71C63542
$employees_tbl->Operation();
//End Execute Components

//Go to destination page @1-75B0D882
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($employees_tbl);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-B727ECBA
$employees_tbl->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-7955904D
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($employees_tbl);
unset($Tpl);
//End Unload Page


?>
