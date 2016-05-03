<?php
//Include Common Files @1-685E58BA
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page0_2_1.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordtools_accessories { //tools_accessories Class @2-88F5506C

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

//Class_Initialize Event @2-8829D454
    function clsRecordtools_accessories($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record tools_accessories/Error";
        $this->DataSource = new clstools_accessoriesDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "tools_accessories";
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
            $this->accessory_description = & new clsControl(ccsTextBox, "accessory_description", "Accessory Description", ccsText, "", CCGetRequestParam("accessory_description", $Method, NULL), $this);
            $this->accessory_description->Required = true;
            $this->manufacturer_id = & new clsControl(ccsListBox, "manufacturer_id", "Manufacturer Id", ccsInteger, "", CCGetRequestParam("manufacturer_id", $Method, NULL), $this);
            $this->manufacturer_id->DSType = dsTable;
            $this->manufacturer_id->DataSource = new clsDBhss_db();
            $this->manufacturer_id->ds = & $this->manufacturer_id->DataSource;
            $this->manufacturer_id->DataSource->SQL = "SELECT * \n" .
"FROM tools_manufacturers {SQL_Where} {SQL_OrderBy}";
            list($this->manufacturer_id->BoundColumn, $this->manufacturer_id->TextColumn, $this->manufacturer_id->DBFormat) = array("manufacturer_id", "manufacturer_name", "");
            $this->manufacturer_id->Required = true;
            $this->supplier_id = & new clsControl(ccsListBox, "supplier_id", "Supplier Id", ccsInteger, "", CCGetRequestParam("supplier_id", $Method, NULL), $this);
            $this->supplier_id->DSType = dsTable;
            $this->supplier_id->DataSource = new clsDBhss_db();
            $this->supplier_id->ds = & $this->supplier_id->DataSource;
            $this->supplier_id->DataSource->SQL = "SELECT * \n" .
"FROM tools_suppliers {SQL_Where} {SQL_OrderBy}";
            list($this->supplier_id->BoundColumn, $this->supplier_id->TextColumn, $this->supplier_id->DBFormat) = array("supplier_id", "supplier_name", "");
            $this->supplier_id->Required = true;
            $this->part_number = & new clsControl(ccsTextBox, "part_number", "Part Number", ccsText, "", CCGetRequestParam("part_number", $Method, NULL), $this);
            $this->s_n = & new clsControl(ccsTextBox, "s_n", "S N", ccsText, "", CCGetRequestParam("s_n", $Method, NULL), $this);
            $this->location = & new clsControl(ccsTextBox, "location", "Location", ccsText, "", CCGetRequestParam("location", $Method, NULL), $this);
            $this->price = & new clsControl(ccsTextBox, "price", "Price", ccsSingle, "", CCGetRequestParam("price", $Method, NULL), $this);
            $this->Link4 = & new clsControl(ccsLink, "Link4", "Link4", ccsText, "", CCGetRequestParam("Link4", $Method, NULL), $this);
            $this->Link4->Page = "tools_manufacturers.php";
            $this->Link3 = & new clsControl(ccsLink, "Link3", "Link3", ccsText, "", CCGetRequestParam("Link3", $Method, NULL), $this);
            $this->Link3->Page = "tools_suppliers.php";
            $this->tool_id = & new clsControl(ccsListBox, "tool_id", "Tool Id", ccsInteger, "", CCGetRequestParam("tool_id", $Method, NULL), $this);
            $this->tool_id->DSType = dsTable;
            $this->tool_id->DataSource = new clsDBhss_db();
            $this->tool_id->ds = & $this->tool_id->DataSource;
            $this->tool_id->DataSource->SQL = "SELECT * \n" .
"FROM tools {SQL_Where} {SQL_OrderBy}";
            list($this->tool_id->BoundColumn, $this->tool_id->TextColumn, $this->tool_id->DBFormat) = array("tool_id", "tool_description", "");
            $this->tool_id->Required = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @2-76601A49
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlaccessory_id"] = CCGetFromGet("accessory_id", NULL);
    }
//End Initialize Method

//Validate Method @2-8A41A795
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->accessory_description->Validate() && $Validation);
        $Validation = ($this->manufacturer_id->Validate() && $Validation);
        $Validation = ($this->supplier_id->Validate() && $Validation);
        $Validation = ($this->part_number->Validate() && $Validation);
        $Validation = ($this->s_n->Validate() && $Validation);
        $Validation = ($this->location->Validate() && $Validation);
        $Validation = ($this->price->Validate() && $Validation);
        $Validation = ($this->tool_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->accessory_description->Errors->Count() == 0);
        $Validation =  $Validation && ($this->manufacturer_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->supplier_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->part_number->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_n->Errors->Count() == 0);
        $Validation =  $Validation && ($this->location->Errors->Count() == 0);
        $Validation =  $Validation && ($this->price->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tool_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-ACA17940
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->accessory_description->Errors->Count());
        $errors = ($errors || $this->manufacturer_id->Errors->Count());
        $errors = ($errors || $this->supplier_id->Errors->Count());
        $errors = ($errors || $this->part_number->Errors->Count());
        $errors = ($errors || $this->s_n->Errors->Count());
        $errors = ($errors || $this->location->Errors->Count());
        $errors = ($errors || $this->price->Errors->Count());
        $errors = ($errors || $this->Link4->Errors->Count());
        $errors = ($errors || $this->Link3->Errors->Count());
        $errors = ($errors || $this->tool_id->Errors->Count());
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

//Operation Method @2-40AEA7F5
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
        $Redirect = "page0_2.php";
        if($this->Validate()) {
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

//InsertRow Method @2-27258BC6
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->manufacturer_id->SetValue($this->manufacturer_id->GetValue(true));
        $this->DataSource->supplier_id->SetValue($this->supplier_id->GetValue(true));
        $this->DataSource->part_number->SetValue($this->part_number->GetValue(true));
        $this->DataSource->s_n->SetValue($this->s_n->GetValue(true));
        $this->DataSource->location->SetValue($this->location->GetValue(true));
        $this->DataSource->price->SetValue($this->price->GetValue(true));
        $this->DataSource->quantity->SetValue($this->quantity->GetValue(true));
        $this->DataSource->tool_id->SetValue($this->tool_id->GetValue(true));
        $this->DataSource->accessory_description->SetValue($this->accessory_description->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-45B1FA0A
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->manufacturer_id->SetValue($this->manufacturer_id->GetValue(true));
        $this->DataSource->supplier_id->SetValue($this->supplier_id->GetValue(true));
        $this->DataSource->part_number->SetValue($this->part_number->GetValue(true));
        $this->DataSource->s_n->SetValue($this->s_n->GetValue(true));
        $this->DataSource->location->SetValue($this->location->GetValue(true));
        $this->DataSource->price->SetValue($this->price->GetValue(true));
        $this->DataSource->quantity->SetValue($this->quantity->GetValue(true));
        $this->DataSource->tool_id->SetValue($this->tool_id->GetValue(true));
        $this->DataSource->accessory_description->SetValue($this->accessory_description->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-68529044
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

        $this->manufacturer_id->Prepare();
        $this->supplier_id->Prepare();
        $this->tool_id->Prepare();

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
                    $this->accessory_description->SetValue($this->DataSource->accessory_description->GetValue());
                    $this->manufacturer_id->SetValue($this->DataSource->manufacturer_id->GetValue());
                    $this->supplier_id->SetValue($this->DataSource->supplier_id->GetValue());
                    $this->part_number->SetValue($this->DataSource->part_number->GetValue());
                    $this->s_n->SetValue($this->DataSource->s_n->GetValue());
                    $this->location->SetValue($this->DataSource->location->GetValue());
                    $this->price->SetValue($this->DataSource->price->GetValue());
                    $this->tool_id->SetValue($this->DataSource->tool_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->accessory_description->Errors->ToString());
            $Error = ComposeStrings($Error, $this->manufacturer_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->supplier_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->part_number->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_n->Errors->ToString());
            $Error = ComposeStrings($Error, $this->location->Errors->ToString());
            $Error = ComposeStrings($Error, $this->price->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Link4->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Link3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tool_id->Errors->ToString());
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
        $this->accessory_description->Show();
        $this->manufacturer_id->Show();
        $this->supplier_id->Show();
        $this->part_number->Show();
        $this->s_n->Show();
        $this->location->Show();
        $this->price->Show();
        $this->Link4->Show();
        $this->Link3->Show();
        $this->tool_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End tools_accessories Class @2-FCB6E20C

class clstools_accessoriesDataSource extends clsDBhss_db {  //tools_accessoriesDataSource Class @2-8E9B64FD

//DataSource Variables @2-4B811542
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
    var $accessory_description;
    var $manufacturer_id;
    var $supplier_id;
    var $part_number;
    var $s_n;
    var $location;
    var $price;
    var $Link4;
    var $Link3;
    var $tool_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-10B892CB
    function clstools_accessoriesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record tools_accessories/Error";
        $this->Initialize();
        $this->accessory_description = new clsField("accessory_description", ccsText, "");
        
        $this->manufacturer_id = new clsField("manufacturer_id", ccsInteger, "");
        
        $this->supplier_id = new clsField("supplier_id", ccsInteger, "");
        
        $this->part_number = new clsField("part_number", ccsText, "");
        
        $this->s_n = new clsField("s_n", ccsText, "");
        
        $this->location = new clsField("location", ccsText, "");
        
        $this->price = new clsField("price", ccsSingle, "");
        
        $this->Link4 = new clsField("Link4", ccsText, "");
        
        $this->Link3 = new clsField("Link3", ccsText, "");
        
        $this->tool_id = new clsField("tool_id", ccsInteger, "");
        

        $this->InsertFields["manufacturer_id"] = array("Name" => "manufacturer_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["supplier_id"] = array("Name" => "supplier_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["part_number"] = array("Name" => "part_number", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["s_n"] = array("Name" => "s_n", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["location"] = array("Name" => "location", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["price"] = array("Name" => "price", "Value" => "", "DataType" => ccsSingle, "OmitIfEmpty" => 1);
        $this->InsertFields["quantity"] = array("Name" => "quantity", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tool_id"] = array("Name" => "tool_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["accessory_description"] = array("Name" => "accessory_description", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["manufacturer_id"] = array("Name" => "manufacturer_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["supplier_id"] = array("Name" => "supplier_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["part_number"] = array("Name" => "part_number", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["s_n"] = array("Name" => "s_n", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["location"] = array("Name" => "location", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["price"] = array("Name" => "price", "Value" => "", "DataType" => ccsSingle, "OmitIfEmpty" => 1);
        $this->UpdateFields["quantity"] = array("Name" => "quantity", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tool_id"] = array("Name" => "tool_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["accessory_description"] = array("Name" => "accessory_description", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-6BA69886
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlaccessory_id", ccsInteger, "", "", $this->Parameters["urlaccessory_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "tools_accessories.accessory_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-22F630CA
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT tools_accessories.*, tool_description \n\n" .
        "FROM tools_accessories INNER JOIN tools ON\n\n" .
        "tools_accessories.tool_id = tools.tool_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-144334A9
    function SetValues()
    {
        $this->accessory_description->SetDBValue($this->f("accessory_description"));
        $this->manufacturer_id->SetDBValue(trim($this->f("manufacturer_id")));
        $this->supplier_id->SetDBValue(trim($this->f("supplier_id")));
        $this->part_number->SetDBValue($this->f("part_number"));
        $this->s_n->SetDBValue($this->f("s_n"));
        $this->location->SetDBValue($this->f("location"));
        $this->price->SetDBValue(trim($this->f("price")));
        $this->tool_id->SetDBValue(trim($this->f("tool_id")));
    }
//End SetValues Method

//Insert Method @2-5DBEDAFF
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["manufacturer_id"] = new clsSQLParameter("ctrlmanufacturer_id", ccsInteger, "", "", $this->manufacturer_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["supplier_id"] = new clsSQLParameter("ctrlsupplier_id", ccsInteger, "", "", $this->supplier_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["part_number"] = new clsSQLParameter("ctrlpart_number", ccsText, "", "", $this->part_number->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["s_n"] = new clsSQLParameter("ctrls_n", ccsText, "", "", $this->s_n->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["location"] = new clsSQLParameter("ctrllocation", ccsText, "", "", $this->location->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["price"] = new clsSQLParameter("ctrlprice", ccsSingle, "", "", $this->price->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["quantity"] = new clsSQLParameter("ctrlquantity", ccsInteger, "", "", $this->quantity->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tool_id"] = new clsSQLParameter("ctrltool_id", ccsInteger, "", "", $this->tool_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["accessory_description"] = new clsSQLParameter("ctrlaccessory_description", ccsText, "", "", $this->accessory_description->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        if (!is_null($this->cp["manufacturer_id"]->GetValue()) and !strlen($this->cp["manufacturer_id"]->GetText()) and !is_bool($this->cp["manufacturer_id"]->GetValue())) 
            $this->cp["manufacturer_id"]->SetValue($this->manufacturer_id->GetValue(true));
        if (!is_null($this->cp["supplier_id"]->GetValue()) and !strlen($this->cp["supplier_id"]->GetText()) and !is_bool($this->cp["supplier_id"]->GetValue())) 
            $this->cp["supplier_id"]->SetValue($this->supplier_id->GetValue(true));
        if (!is_null($this->cp["part_number"]->GetValue()) and !strlen($this->cp["part_number"]->GetText()) and !is_bool($this->cp["part_number"]->GetValue())) 
            $this->cp["part_number"]->SetValue($this->part_number->GetValue(true));
        if (!is_null($this->cp["s_n"]->GetValue()) and !strlen($this->cp["s_n"]->GetText()) and !is_bool($this->cp["s_n"]->GetValue())) 
            $this->cp["s_n"]->SetValue($this->s_n->GetValue(true));
        if (!is_null($this->cp["location"]->GetValue()) and !strlen($this->cp["location"]->GetText()) and !is_bool($this->cp["location"]->GetValue())) 
            $this->cp["location"]->SetValue($this->location->GetValue(true));
        if (!is_null($this->cp["price"]->GetValue()) and !strlen($this->cp["price"]->GetText()) and !is_bool($this->cp["price"]->GetValue())) 
            $this->cp["price"]->SetValue($this->price->GetValue(true));
        if (!is_null($this->cp["quantity"]->GetValue()) and !strlen($this->cp["quantity"]->GetText()) and !is_bool($this->cp["quantity"]->GetValue())) 
            $this->cp["quantity"]->SetValue($this->quantity->GetValue(true));
        if (!is_null($this->cp["tool_id"]->GetValue()) and !strlen($this->cp["tool_id"]->GetText()) and !is_bool($this->cp["tool_id"]->GetValue())) 
            $this->cp["tool_id"]->SetValue($this->tool_id->GetValue(true));
        if (!is_null($this->cp["accessory_description"]->GetValue()) and !strlen($this->cp["accessory_description"]->GetText()) and !is_bool($this->cp["accessory_description"]->GetValue())) 
            $this->cp["accessory_description"]->SetValue($this->accessory_description->GetValue(true));
        $this->InsertFields["manufacturer_id"]["Value"] = $this->cp["manufacturer_id"]->GetDBValue(true);
        $this->InsertFields["supplier_id"]["Value"] = $this->cp["supplier_id"]->GetDBValue(true);
        $this->InsertFields["part_number"]["Value"] = $this->cp["part_number"]->GetDBValue(true);
        $this->InsertFields["s_n"]["Value"] = $this->cp["s_n"]->GetDBValue(true);
        $this->InsertFields["location"]["Value"] = $this->cp["location"]->GetDBValue(true);
        $this->InsertFields["price"]["Value"] = $this->cp["price"]->GetDBValue(true);
        $this->InsertFields["quantity"]["Value"] = $this->cp["quantity"]->GetDBValue(true);
        $this->InsertFields["tool_id"]["Value"] = $this->cp["tool_id"]->GetDBValue(true);
        $this->InsertFields["accessory_description"]["Value"] = $this->cp["accessory_description"]->GetDBValue(true);
        $this->SQL = CCBuildInsert("tools_accessories", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-CA16CFCD
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["manufacturer_id"] = new clsSQLParameter("ctrlmanufacturer_id", ccsInteger, "", "", $this->manufacturer_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["supplier_id"] = new clsSQLParameter("ctrlsupplier_id", ccsInteger, "", "", $this->supplier_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["part_number"] = new clsSQLParameter("ctrlpart_number", ccsText, "", "", $this->part_number->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["s_n"] = new clsSQLParameter("ctrls_n", ccsText, "", "", $this->s_n->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["location"] = new clsSQLParameter("ctrllocation", ccsText, "", "", $this->location->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["price"] = new clsSQLParameter("ctrlprice", ccsSingle, "", "", $this->price->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["quantity"] = new clsSQLParameter("ctrlquantity", ccsInteger, "", "", $this->quantity->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tool_id"] = new clsSQLParameter("ctrltool_id", ccsInteger, "", "", $this->tool_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["accessory_description"] = new clsSQLParameter("ctrlaccessory_description", ccsText, "", "", $this->accessory_description->GetValue(true), NULL, false, $this->ErrorBlock);
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "urlaccessory_id", ccsInteger, "", "", CCGetFromGet("accessory_id", NULL), "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        if (!is_null($this->cp["manufacturer_id"]->GetValue()) and !strlen($this->cp["manufacturer_id"]->GetText()) and !is_bool($this->cp["manufacturer_id"]->GetValue())) 
            $this->cp["manufacturer_id"]->SetValue($this->manufacturer_id->GetValue(true));
        if (!is_null($this->cp["supplier_id"]->GetValue()) and !strlen($this->cp["supplier_id"]->GetText()) and !is_bool($this->cp["supplier_id"]->GetValue())) 
            $this->cp["supplier_id"]->SetValue($this->supplier_id->GetValue(true));
        if (!is_null($this->cp["part_number"]->GetValue()) and !strlen($this->cp["part_number"]->GetText()) and !is_bool($this->cp["part_number"]->GetValue())) 
            $this->cp["part_number"]->SetValue($this->part_number->GetValue(true));
        if (!is_null($this->cp["s_n"]->GetValue()) and !strlen($this->cp["s_n"]->GetText()) and !is_bool($this->cp["s_n"]->GetValue())) 
            $this->cp["s_n"]->SetValue($this->s_n->GetValue(true));
        if (!is_null($this->cp["location"]->GetValue()) and !strlen($this->cp["location"]->GetText()) and !is_bool($this->cp["location"]->GetValue())) 
            $this->cp["location"]->SetValue($this->location->GetValue(true));
        if (!is_null($this->cp["price"]->GetValue()) and !strlen($this->cp["price"]->GetText()) and !is_bool($this->cp["price"]->GetValue())) 
            $this->cp["price"]->SetValue($this->price->GetValue(true));
        if (!is_null($this->cp["quantity"]->GetValue()) and !strlen($this->cp["quantity"]->GetText()) and !is_bool($this->cp["quantity"]->GetValue())) 
            $this->cp["quantity"]->SetValue($this->quantity->GetValue(true));
        if (!is_null($this->cp["tool_id"]->GetValue()) and !strlen($this->cp["tool_id"]->GetText()) and !is_bool($this->cp["tool_id"]->GetValue())) 
            $this->cp["tool_id"]->SetValue($this->tool_id->GetValue(true));
        if (!is_null($this->cp["accessory_description"]->GetValue()) and !strlen($this->cp["accessory_description"]->GetText()) and !is_bool($this->cp["accessory_description"]->GetValue())) 
            $this->cp["accessory_description"]->SetValue($this->accessory_description->GetValue(true));
        $wp->Criterion[1] = $wp->Operation(opEqual, "tools_accessories.accessory_id", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsInteger),false);
        $Where = 
             $wp->Criterion[1];
        $this->UpdateFields["manufacturer_id"]["Value"] = $this->cp["manufacturer_id"]->GetDBValue(true);
        $this->UpdateFields["supplier_id"]["Value"] = $this->cp["supplier_id"]->GetDBValue(true);
        $this->UpdateFields["part_number"]["Value"] = $this->cp["part_number"]->GetDBValue(true);
        $this->UpdateFields["s_n"]["Value"] = $this->cp["s_n"]->GetDBValue(true);
        $this->UpdateFields["location"]["Value"] = $this->cp["location"]->GetDBValue(true);
        $this->UpdateFields["price"]["Value"] = $this->cp["price"]->GetDBValue(true);
        $this->UpdateFields["quantity"]["Value"] = $this->cp["quantity"]->GetDBValue(true);
        $this->UpdateFields["tool_id"]["Value"] = $this->cp["tool_id"]->GetDBValue(true);
        $this->UpdateFields["accessory_description"]["Value"] = $this->cp["accessory_description"]->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tools_accessories", $this->UpdateFields, $this);
        $this->SQL .= strlen($Where) ? " WHERE " . $Where : $Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End tools_accessoriesDataSource Class @2-FCB6E20C

//Initialize Page @1-2AE2AD52
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
$TemplateFileName = "page0_2_1.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-D6339072
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tools_accessories = & new clsRecordtools_accessories("", $MainPage);
$MainPage->tools_accessories = & $tools_accessories;
$tools_accessories->Initialize();

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

//Execute Components @1-7AB8B69B
$tools_accessories->Operation();
//End Execute Components

//Go to destination page @1-1283BB98
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($tools_accessories);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-A7A00433
$tools_accessories->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-C36D7347
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($tools_accessories);
unset($Tpl);
//End Unload Page


?>
