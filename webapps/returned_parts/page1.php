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

class clsRecordservice_returned_parts_tb { //service_returned_parts_tb Class @2-6DA709D3

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

//Class_Initialize Event @2-F4B9BDF3
    function clsRecordservice_returned_parts_tb($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record service_returned_parts_tb/Error";
        $this->DataSource = new clsservice_returned_parts_tbDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "service_returned_parts_tb";
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
            $this->sequence_no = & new clsControl(ccsHidden, "sequence_no", "Sequence No", ccsInteger, "", CCGetRequestParam("sequence_no", $Method, NULL), $this);
            $this->part_description = & new clsControl(ccsTextBox, "part_description", "Part Description", ccsText, "", CCGetRequestParam("part_description", $Method, NULL), $this);
            $this->part_description->Required = true;
            $this->stock_no = & new clsControl(ccsTextBox, "stock_no", "Stock No", ccsText, "", CCGetRequestParam("stock_no", $Method, NULL), $this);
            $this->stock_no->Required = true;
            $this->sn_defective_part = & new clsControl(ccsTextBox, "sn_defective_part", "Sn Defective Part", ccsText, "", CCGetRequestParam("sn_defective_part", $Method, NULL), $this);
            $this->sn_defective_part->Required = true;
            $this->sn_new_part = & new clsControl(ccsTextBox, "sn_new_part", "Sn New Part", ccsText, "", CCGetRequestParam("sn_new_part", $Method, NULL), $this);
            $this->sn_new_part->Required = true;
            $this->MANUF_ID = & new clsControl(ccsListBox, "MANUF_ID", "MANUF ID", ccsInteger, "", CCGetRequestParam("MANUF_ID", $Method, NULL), $this);
            $this->MANUF_ID->DSType = dsTable;
            $this->MANUF_ID->DataSource = new clsDBhss_db();
            $this->MANUF_ID->ds = & $this->MANUF_ID->DataSource;
            $this->MANUF_ID->DataSource->SQL = "SELECT * \n" .
"FROM equipment_manufacturer_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->MANUF_ID->BoundColumn, $this->MANUF_ID->TextColumn, $this->MANUF_ID->DBFormat) = array("MANUF_ID", "MANUF_NAME", "");
            $this->MANUF_ID->Required = true;
            $this->return_type_id = & new clsControl(ccsListBox, "return_type_id", "Return type id", ccsInteger, "", CCGetRequestParam("return_type_id", $Method, NULL), $this);
            $this->return_type_id->DSType = dsTable;
            $this->return_type_id->DataSource = new clsDBhss_db();
            $this->return_type_id->ds = & $this->return_type_id->DataSource;
            $this->return_type_id->DataSource->SQL = "SELECT * \n" .
"FROM service_return_type_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->return_type_id->BoundColumn, $this->return_type_id->TextColumn, $this->return_type_id->DBFormat) = array("return_type_id", "return_type", "");
            $this->return_type_id->Required = true;
            $this->supplier_order_no = & new clsControl(ccsTextBox, "supplier_order_no", "Supplier Order No", ccsText, "", CCGetRequestParam("supplier_order_no", $Method, NULL), $this);
            $this->emp_id = & new clsControl(ccsListBox, "emp_id", "Emp Id", ccsInteger, "", CCGetRequestParam("emp_id", $Method, NULL), $this);
            $this->emp_id->DSType = dsTable;
            $this->emp_id->DataSource = new clsDBhss_db();
            $this->emp_id->ds = & $this->emp_id->DataSource;
            $this->emp_id->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->emp_id->BoundColumn, $this->emp_id->TextColumn, $this->emp_id->DBFormat) = array("emp_id", "emp_login", "");
            $this->emp_id->Required = true;
            $this->ORDER_NO = & new clsControl(ccsTextBox, "ORDER_NO", "ORDER NO", ccsText, "", CCGetRequestParam("ORDER_NO", $Method, NULL), $this);
            $this->ORDER_NO->Required = true;
            $this->fault_description = & new clsControl(ccsTextArea, "fault_description", "fault_description", ccsText, "", CCGetRequestParam("fault_description", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @2-81E752D7
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlsequence_no"] = CCGetFromGet("sequence_no", NULL);
    }
//End Initialize Method

//Validate Method @2-3D67226F
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->sequence_no->Validate() && $Validation);
        $Validation = ($this->part_description->Validate() && $Validation);
        $Validation = ($this->stock_no->Validate() && $Validation);
        $Validation = ($this->sn_defective_part->Validate() && $Validation);
        $Validation = ($this->sn_new_part->Validate() && $Validation);
        $Validation = ($this->MANUF_ID->Validate() && $Validation);
        $Validation = ($this->return_type_id->Validate() && $Validation);
        $Validation = ($this->supplier_order_no->Validate() && $Validation);
        $Validation = ($this->emp_id->Validate() && $Validation);
        $Validation = ($this->ORDER_NO->Validate() && $Validation);
        $Validation = ($this->fault_description->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->sequence_no->Errors->Count() == 0);
        $Validation =  $Validation && ($this->part_description->Errors->Count() == 0);
        $Validation =  $Validation && ($this->stock_no->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sn_defective_part->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sn_new_part->Errors->Count() == 0);
        $Validation =  $Validation && ($this->MANUF_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->return_type_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->supplier_order_no->Errors->Count() == 0);
        $Validation =  $Validation && ($this->emp_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ORDER_NO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->fault_description->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-A0D17DBF
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->sequence_no->Errors->Count());
        $errors = ($errors || $this->part_description->Errors->Count());
        $errors = ($errors || $this->stock_no->Errors->Count());
        $errors = ($errors || $this->sn_defective_part->Errors->Count());
        $errors = ($errors || $this->sn_new_part->Errors->Count());
        $errors = ($errors || $this->MANUF_ID->Errors->Count());
        $errors = ($errors || $this->return_type_id->Errors->Count());
        $errors = ($errors || $this->supplier_order_no->Errors->Count());
        $errors = ($errors || $this->emp_id->Errors->Count());
        $errors = ($errors || $this->ORDER_NO->Errors->Count());
        $errors = ($errors || $this->fault_description->Errors->Count());
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

//Operation Method @2-327C0C16
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
            $this->PressedButton = "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            }
        }
        $Redirect = "page2.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
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

//InsertRow Method @2-131241D0
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->sequence_no->SetValue($this->sequence_no->GetValue(true));
        $this->DataSource->part_description->SetValue($this->part_description->GetValue(true));
        $this->DataSource->stock_no->SetValue($this->stock_no->GetValue(true));
        $this->DataSource->sn_defective_part->SetValue($this->sn_defective_part->GetValue(true));
        $this->DataSource->sn_new_part->SetValue($this->sn_new_part->GetValue(true));
        $this->DataSource->MANUF_ID->SetValue($this->MANUF_ID->GetValue(true));
        $this->DataSource->return_type_id->SetValue($this->return_type_id->GetValue(true));
        $this->DataSource->supplier_order_no->SetValue($this->supplier_order_no->GetValue(true));
        $this->DataSource->emp_id->SetValue($this->emp_id->GetValue(true));
        $this->DataSource->ORDER_NO->SetValue($this->ORDER_NO->GetValue(true));
        $this->DataSource->fault_description->SetValue($this->fault_description->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//Show Method @2-3E71ADCD
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

        $this->MANUF_ID->Prepare();
        $this->return_type_id->Prepare();
        $this->emp_id->Prepare();

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
                    $this->sequence_no->SetValue($this->DataSource->sequence_no->GetValue());
                    $this->part_description->SetValue($this->DataSource->part_description->GetValue());
                    $this->stock_no->SetValue($this->DataSource->stock_no->GetValue());
                    $this->sn_defective_part->SetValue($this->DataSource->sn_defective_part->GetValue());
                    $this->sn_new_part->SetValue($this->DataSource->sn_new_part->GetValue());
                    $this->MANUF_ID->SetValue($this->DataSource->MANUF_ID->GetValue());
                    $this->return_type_id->SetValue($this->DataSource->return_type_id->GetValue());
                    $this->supplier_order_no->SetValue($this->DataSource->supplier_order_no->GetValue());
                    $this->emp_id->SetValue($this->DataSource->emp_id->GetValue());
                    $this->ORDER_NO->SetValue($this->DataSource->ORDER_NO->GetValue());
                    $this->fault_description->SetValue($this->DataSource->fault_description->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->sequence_no->Errors->ToString());
            $Error = ComposeStrings($Error, $this->part_description->Errors->ToString());
            $Error = ComposeStrings($Error, $this->stock_no->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sn_defective_part->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sn_new_part->Errors->ToString());
            $Error = ComposeStrings($Error, $this->MANUF_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->return_type_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->supplier_order_no->Errors->ToString());
            $Error = ComposeStrings($Error, $this->emp_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ORDER_NO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->fault_description->Errors->ToString());
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

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->sequence_no->Show();
        $this->part_description->Show();
        $this->stock_no->Show();
        $this->sn_defective_part->Show();
        $this->sn_new_part->Show();
        $this->MANUF_ID->Show();
        $this->return_type_id->Show();
        $this->supplier_order_no->Show();
        $this->emp_id->Show();
        $this->ORDER_NO->Show();
        $this->fault_description->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End service_returned_parts_tb Class @2-FCB6E20C

class clsservice_returned_parts_tbDataSource extends clsDBhss_db {  //service_returned_parts_tbDataSource Class @2-F9C0C747

//DataSource Variables @2-12EE8575
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $InsertParameters;
    var $wp;
    var $AllParametersSet;

    var $InsertFields = array();

    // Datasource fields
    var $sequence_no;
    var $part_description;
    var $stock_no;
    var $sn_defective_part;
    var $sn_new_part;
    var $MANUF_ID;
    var $return_type_id;
    var $supplier_order_no;
    var $emp_id;
    var $ORDER_NO;
    var $fault_description;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-8BCF3B18
    function clsservice_returned_parts_tbDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record service_returned_parts_tb/Error";
        $this->Initialize();
        $this->sequence_no = new clsField("sequence_no", ccsInteger, "");
        
        $this->part_description = new clsField("part_description", ccsText, "");
        
        $this->stock_no = new clsField("stock_no", ccsText, "");
        
        $this->sn_defective_part = new clsField("sn_defective_part", ccsText, "");
        
        $this->sn_new_part = new clsField("sn_new_part", ccsText, "");
        
        $this->MANUF_ID = new clsField("MANUF_ID", ccsInteger, "");
        
        $this->return_type_id = new clsField("return_type_id", ccsInteger, "");
        
        $this->supplier_order_no = new clsField("supplier_order_no", ccsText, "");
        
        $this->emp_id = new clsField("emp_id", ccsInteger, "");
        
        $this->ORDER_NO = new clsField("ORDER_NO", ccsText, "");
        
        $this->fault_description = new clsField("fault_description", ccsText, "");
        

        $this->InsertFields["sequence_no"] = array("Name" => "sequence_no", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["part_description"] = array("Name" => "part_description", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["stock_no"] = array("Name" => "stock_no", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["sn_defective_part"] = array("Name" => "sn_defective_part", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["sn_new_part"] = array("Name" => "sn_new_part", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["MANUF_ID"] = array("Name" => "MANUF_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["return_type_id"] = array("Name" => "return_type_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["supplier_order_no"] = array("Name" => "supplier_order_no", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["emp_id"] = array("Name" => "emp_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["ORDER_NO"] = array("Name" => "ORDER_NO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["fault_description"] = array("Name" => "fault_description", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-C6256CA9
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlsequence_no", ccsInteger, "", "", $this->Parameters["urlsequence_no"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "sequence_no", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-2DB6BE8D
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM service_returned_parts_tbl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-9BCE1945
    function SetValues()
    {
        $this->sequence_no->SetDBValue(trim($this->f("sequence_no")));
        $this->part_description->SetDBValue($this->f("part_description"));
        $this->stock_no->SetDBValue($this->f("stock_no"));
        $this->sn_defective_part->SetDBValue($this->f("sn_defective_part"));
        $this->sn_new_part->SetDBValue($this->f("sn_new_part"));
        $this->MANUF_ID->SetDBValue(trim($this->f("MANUF_ID")));
        $this->return_type_id->SetDBValue(trim($this->f("return_type_id")));
        $this->supplier_order_no->SetDBValue($this->f("supplier_order_no"));
        $this->emp_id->SetDBValue(trim($this->f("emp_id")));
        $this->ORDER_NO->SetDBValue($this->f("ORDER_NO"));
        $this->fault_description->SetDBValue($this->f("fault_description"));
    }
//End SetValues Method

//Insert Method @2-6B6700FD
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["sequence_no"]["Value"] = $this->sequence_no->GetDBValue(true);
        $this->InsertFields["part_description"]["Value"] = $this->part_description->GetDBValue(true);
        $this->InsertFields["stock_no"]["Value"] = $this->stock_no->GetDBValue(true);
        $this->InsertFields["sn_defective_part"]["Value"] = $this->sn_defective_part->GetDBValue(true);
        $this->InsertFields["sn_new_part"]["Value"] = $this->sn_new_part->GetDBValue(true);
        $this->InsertFields["MANUF_ID"]["Value"] = $this->MANUF_ID->GetDBValue(true);
        $this->InsertFields["return_type_id"]["Value"] = $this->return_type_id->GetDBValue(true);
        $this->InsertFields["supplier_order_no"]["Value"] = $this->supplier_order_no->GetDBValue(true);
        $this->InsertFields["emp_id"]["Value"] = $this->emp_id->GetDBValue(true);
        $this->InsertFields["ORDER_NO"]["Value"] = $this->ORDER_NO->GetDBValue(true);
        $this->InsertFields["fault_description"]["Value"] = $this->fault_description->GetDBValue(true);
        $this->SQL = CCBuildInsert("service_returned_parts_tbl", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

} //End service_returned_parts_tbDataSource Class @2-FCB6E20C

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

//Initialize Objects @1-6CC69AD2
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$service_returned_parts_tb = & new clsRecordservice_returned_parts_tb("", $MainPage);
$MainPage->service_returned_parts_tb = & $service_returned_parts_tb;
$service_returned_parts_tb->Initialize();

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

//Execute Components @1-FFEE9040
$service_returned_parts_tb->Operation();
//End Execute Components

//Go to destination page @1-3FE7FA50
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($service_returned_parts_tb);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-50AFBA72
$service_returned_parts_tb->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-D7CA169D
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($service_returned_parts_tb);
unset($Tpl);
//End Unload Page


?>
