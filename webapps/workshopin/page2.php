<?php
//Include Common Files @1-C5BBDFFC
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page2.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordworkshop_repair { //workshop_repair Class @19-4317E77C

//Variables @19-D6FF3E86

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

//Class_Initialize Event @19-0E7D5DC3
    function clsRecordworkshop_repair($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record workshop_repair/Error";
        $this->DataSource = new clsworkshop_repairDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "workshop_repair";
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
            $this->workshop_in_id = & new clsControl(ccsHidden, "workshop_in_id", "Workshop In Id", ccsInteger, "", CCGetRequestParam("workshop_in_id", $Method, NULL), $this);
            $this->ship_name = & new clsControl(ccsTextBox, "ship_name", "Ship Name", ccsText, "", CCGetRequestParam("ship_name", $Method, NULL), $this);
            $this->imo = & new clsControl(ccsTextBox, "imo", "Imo", ccsText, "", CCGetRequestParam("imo", $Method, NULL), $this);
            $this->customer = & new clsControl(ccsTextBox, "customer", "Customer", ccsText, "", CCGetRequestParam("customer", $Method, NULL), $this);
            $this->customer->Required = true;
            $this->customer_phone = & new clsControl(ccsTextBox, "customer_phone", "Customer Phone", ccsText, "", CCGetRequestParam("customer_phone", $Method, NULL), $this);
            $this->customer_phone->Required = true;
            $this->customer_email = & new clsControl(ccsTextBox, "customer_email", "Customer Email", ccsText, "", CCGetRequestParam("customer_email", $Method, NULL), $this);
            $this->EQUIP_TYPE = & new clsControl(ccsTextBox, "EQUIP_TYPE", "EQUIP TYPE", ccsText, "", CCGetRequestParam("EQUIP_TYPE", $Method, NULL), $this);
            $this->MANUF_NAME = & new clsControl(ccsTextBox, "MANUF_NAME", "MANUF NAME", ccsText, "", CCGetRequestParam("MANUF_NAME", $Method, NULL), $this);
            $this->MANUF_NAME->Required = true;
            $this->EQUIP_MODEL = & new clsControl(ccsTextBox, "EQUIP_MODEL", "EQUIP MODEL", ccsText, "", CCGetRequestParam("EQUIP_MODEL", $Method, NULL), $this);
            $this->EQUIP_MODEL->Required = true;
            $this->part_no = & new clsControl(ccsTextBox, "part_no", "Part No", ccsText, "", CCGetRequestParam("part_no", $Method, NULL), $this);
            $this->sn = & new clsControl(ccsTextBox, "sn", "Sn", ccsText, "", CCGetRequestParam("sn", $Method, NULL), $this);
            $this->notes = & new clsControl(ccsTextArea, "notes", "Notes", ccsMemo, "", CCGetRequestParam("notes", $Method, NULL), $this);
            $this->emp_id = & new clsControl(ccsListBox, "emp_id", "Emp Id", ccsInteger, "", CCGetRequestParam("emp_id", $Method, NULL), $this);
            $this->emp_id->DSType = dsTable;
            $this->emp_id->DataSource = new clsDBhss_db();
            $this->emp_id->ds = & $this->emp_id->DataSource;
            $this->emp_id->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->emp_id->BoundColumn, $this->emp_id->TextColumn, $this->emp_id->DBFormat) = array("emp_id", "emp_login", "");
            $this->emp_id->Required = true;
            if(!$this->FormSubmitted) {
                if(!is_array($this->emp_id->Value) && !strlen($this->emp_id->Value) && $this->emp_id->Value !== false)
                    $this->emp_id->SetText(11);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @19-E67462DD
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlworkshop_in_id"] = CCGetFromGet("workshop_in_id", NULL);
    }
//End Initialize Method

//Validate Method @19-C7A90570
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->workshop_in_id->Validate() && $Validation);
        $Validation = ($this->ship_name->Validate() && $Validation);
        $Validation = ($this->imo->Validate() && $Validation);
        $Validation = ($this->customer->Validate() && $Validation);
        $Validation = ($this->customer_phone->Validate() && $Validation);
        $Validation = ($this->customer_email->Validate() && $Validation);
        $Validation = ($this->EQUIP_TYPE->Validate() && $Validation);
        $Validation = ($this->MANUF_NAME->Validate() && $Validation);
        $Validation = ($this->EQUIP_MODEL->Validate() && $Validation);
        $Validation = ($this->part_no->Validate() && $Validation);
        $Validation = ($this->sn->Validate() && $Validation);
        $Validation = ($this->notes->Validate() && $Validation);
        $Validation = ($this->emp_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->workshop_in_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ship_name->Errors->Count() == 0);
        $Validation =  $Validation && ($this->imo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->customer->Errors->Count() == 0);
        $Validation =  $Validation && ($this->customer_phone->Errors->Count() == 0);
        $Validation =  $Validation && ($this->customer_email->Errors->Count() == 0);
        $Validation =  $Validation && ($this->EQUIP_TYPE->Errors->Count() == 0);
        $Validation =  $Validation && ($this->MANUF_NAME->Errors->Count() == 0);
        $Validation =  $Validation && ($this->EQUIP_MODEL->Errors->Count() == 0);
        $Validation =  $Validation && ($this->part_no->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sn->Errors->Count() == 0);
        $Validation =  $Validation && ($this->notes->Errors->Count() == 0);
        $Validation =  $Validation && ($this->emp_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @19-AF572722
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->workshop_in_id->Errors->Count());
        $errors = ($errors || $this->ship_name->Errors->Count());
        $errors = ($errors || $this->imo->Errors->Count());
        $errors = ($errors || $this->customer->Errors->Count());
        $errors = ($errors || $this->customer_phone->Errors->Count());
        $errors = ($errors || $this->customer_email->Errors->Count());
        $errors = ($errors || $this->EQUIP_TYPE->Errors->Count());
        $errors = ($errors || $this->MANUF_NAME->Errors->Count());
        $errors = ($errors || $this->EQUIP_MODEL->Errors->Count());
        $errors = ($errors || $this->part_no->Errors->Count());
        $errors = ($errors || $this->sn->Errors->Count());
        $errors = ($errors || $this->notes->Errors->Count());
        $errors = ($errors || $this->emp_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @19-ED598703
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

//Operation Method @19-895779AA
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
        $Redirect = "page3.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
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

//InsertRow Method @19-3750F756
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->workshop_in_id->SetValue($this->workshop_in_id->GetValue(true));
        $this->DataSource->ship_name->SetValue($this->ship_name->GetValue(true));
        $this->DataSource->imo->SetValue($this->imo->GetValue(true));
        $this->DataSource->customer->SetValue($this->customer->GetValue(true));
        $this->DataSource->customer_phone->SetValue($this->customer_phone->GetValue(true));
        $this->DataSource->customer_email->SetValue($this->customer_email->GetValue(true));
        $this->DataSource->EQUIP_TYPE->SetValue($this->EQUIP_TYPE->GetValue(true));
        $this->DataSource->MANUF_NAME->SetValue($this->MANUF_NAME->GetValue(true));
        $this->DataSource->EQUIP_MODEL->SetValue($this->EQUIP_MODEL->GetValue(true));
        $this->DataSource->part_no->SetValue($this->part_no->GetValue(true));
        $this->DataSource->sn->SetValue($this->sn->GetValue(true));
        $this->DataSource->notes->SetValue($this->notes->GetValue(true));
        $this->DataSource->emp_id->SetValue($this->emp_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//Show Method @19-767C4EEA
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
                    $this->workshop_in_id->SetValue($this->DataSource->workshop_in_id->GetValue());
                    $this->ship_name->SetValue($this->DataSource->ship_name->GetValue());
                    $this->imo->SetValue($this->DataSource->imo->GetValue());
                    $this->customer->SetValue($this->DataSource->customer->GetValue());
                    $this->customer_phone->SetValue($this->DataSource->customer_phone->GetValue());
                    $this->customer_email->SetValue($this->DataSource->customer_email->GetValue());
                    $this->EQUIP_TYPE->SetValue($this->DataSource->EQUIP_TYPE->GetValue());
                    $this->MANUF_NAME->SetValue($this->DataSource->MANUF_NAME->GetValue());
                    $this->EQUIP_MODEL->SetValue($this->DataSource->EQUIP_MODEL->GetValue());
                    $this->part_no->SetValue($this->DataSource->part_no->GetValue());
                    $this->sn->SetValue($this->DataSource->sn->GetValue());
                    $this->notes->SetValue($this->DataSource->notes->GetValue());
                    $this->emp_id->SetValue($this->DataSource->emp_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->workshop_in_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ship_name->Errors->ToString());
            $Error = ComposeStrings($Error, $this->imo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->customer->Errors->ToString());
            $Error = ComposeStrings($Error, $this->customer_phone->Errors->ToString());
            $Error = ComposeStrings($Error, $this->customer_email->Errors->ToString());
            $Error = ComposeStrings($Error, $this->EQUIP_TYPE->Errors->ToString());
            $Error = ComposeStrings($Error, $this->MANUF_NAME->Errors->ToString());
            $Error = ComposeStrings($Error, $this->EQUIP_MODEL->Errors->ToString());
            $Error = ComposeStrings($Error, $this->part_no->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sn->Errors->ToString());
            $Error = ComposeStrings($Error, $this->notes->Errors->ToString());
            $Error = ComposeStrings($Error, $this->emp_id->Errors->ToString());
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
        $this->workshop_in_id->Show();
        $this->ship_name->Show();
        $this->imo->Show();
        $this->customer->Show();
        $this->customer_phone->Show();
        $this->customer_email->Show();
        $this->EQUIP_TYPE->Show();
        $this->MANUF_NAME->Show();
        $this->EQUIP_MODEL->Show();
        $this->part_no->Show();
        $this->sn->Show();
        $this->notes->Show();
        $this->emp_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End workshop_repair Class @19-FCB6E20C

class clsworkshop_repairDataSource extends clsDBhss_db {  //workshop_repairDataSource Class @19-ACAA58D1

//DataSource Variables @19-36D8211F
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
    var $workshop_in_id;
    var $ship_name;
    var $imo;
    var $customer;
    var $customer_phone;
    var $customer_email;
    var $EQUIP_TYPE;
    var $MANUF_NAME;
    var $EQUIP_MODEL;
    var $part_no;
    var $sn;
    var $notes;
    var $emp_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @19-B862DAE8
    function clsworkshop_repairDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record workshop_repair/Error";
        $this->Initialize();
        $this->workshop_in_id = new clsField("workshop_in_id", ccsInteger, "");
        
        $this->ship_name = new clsField("ship_name", ccsText, "");
        
        $this->imo = new clsField("imo", ccsText, "");
        
        $this->customer = new clsField("customer", ccsText, "");
        
        $this->customer_phone = new clsField("customer_phone", ccsText, "");
        
        $this->customer_email = new clsField("customer_email", ccsText, "");
        
        $this->EQUIP_TYPE = new clsField("EQUIP_TYPE", ccsText, "");
        
        $this->MANUF_NAME = new clsField("MANUF_NAME", ccsText, "");
        
        $this->EQUIP_MODEL = new clsField("EQUIP_MODEL", ccsText, "");
        
        $this->part_no = new clsField("part_no", ccsText, "");
        
        $this->sn = new clsField("sn", ccsText, "");
        
        $this->notes = new clsField("notes", ccsMemo, "");
        
        $this->emp_id = new clsField("emp_id", ccsInteger, "");
        

        $this->InsertFields["workshop_in_id"] = array("Name" => "workshop_in_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["ship_name"] = array("Name" => "ship_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["imo"] = array("Name" => "imo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["customer"] = array("Name" => "customer", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["customer_phone"] = array("Name" => "customer_phone", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["customer_email"] = array("Name" => "customer_email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["EQUIP_TYPE"] = array("Name" => "EQUIP_TYPE", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["MANUF_NAME"] = array("Name" => "MANUF_NAME", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["EQUIP_MODEL"] = array("Name" => "EQUIP_MODEL", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["part_no"] = array("Name" => "part_no", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["sn"] = array("Name" => "sn", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["notes"] = array("Name" => "notes", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->InsertFields["emp_id"] = array("Name" => "emp_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @19-2246217C
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlworkshop_in_id", ccsInteger, "", "", $this->Parameters["urlworkshop_in_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "workshop_in_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @19-41858D2F
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM workshop_repair {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @19-C4D36FFD
    function SetValues()
    {
        $this->workshop_in_id->SetDBValue(trim($this->f("workshop_in_id")));
        $this->ship_name->SetDBValue($this->f("ship_name"));
        $this->imo->SetDBValue($this->f("imo"));
        $this->customer->SetDBValue($this->f("customer"));
        $this->customer_phone->SetDBValue($this->f("customer_phone"));
        $this->customer_email->SetDBValue($this->f("customer_email"));
        $this->EQUIP_TYPE->SetDBValue($this->f("EQUIP_TYPE"));
        $this->MANUF_NAME->SetDBValue($this->f("MANUF_NAME"));
        $this->EQUIP_MODEL->SetDBValue($this->f("EQUIP_MODEL"));
        $this->part_no->SetDBValue($this->f("part_no"));
        $this->sn->SetDBValue($this->f("sn"));
        $this->notes->SetDBValue($this->f("notes"));
        $this->emp_id->SetDBValue(trim($this->f("emp_id")));
    }
//End SetValues Method

//Insert Method @19-4F114621
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["workshop_in_id"]["Value"] = $this->workshop_in_id->GetDBValue(true);
        $this->InsertFields["ship_name"]["Value"] = $this->ship_name->GetDBValue(true);
        $this->InsertFields["imo"]["Value"] = $this->imo->GetDBValue(true);
        $this->InsertFields["customer"]["Value"] = $this->customer->GetDBValue(true);
        $this->InsertFields["customer_phone"]["Value"] = $this->customer_phone->GetDBValue(true);
        $this->InsertFields["customer_email"]["Value"] = $this->customer_email->GetDBValue(true);
        $this->InsertFields["EQUIP_TYPE"]["Value"] = $this->EQUIP_TYPE->GetDBValue(true);
        $this->InsertFields["MANUF_NAME"]["Value"] = $this->MANUF_NAME->GetDBValue(true);
        $this->InsertFields["EQUIP_MODEL"]["Value"] = $this->EQUIP_MODEL->GetDBValue(true);
        $this->InsertFields["part_no"]["Value"] = $this->part_no->GetDBValue(true);
        $this->InsertFields["sn"]["Value"] = $this->sn->GetDBValue(true);
        $this->InsertFields["notes"]["Value"] = $this->notes->GetDBValue(true);
        $this->InsertFields["emp_id"]["Value"] = $this->emp_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("workshop_repair", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

} //End workshop_repairDataSource Class @19-FCB6E20C

//Initialize Page @1-B392DC04
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
$TemplateFileName = "page2.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-2D24D056
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Link2 = & new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $MainPage);
$Link2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link2->Page = "page1.php";
$workshop_repair = & new clsRecordworkshop_repair("", $MainPage);
$MainPage->Link2 = & $Link2;
$MainPage->workshop_repair = & $workshop_repair;
$workshop_repair->Initialize();

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

//Execute Components @1-3FED1B81
$workshop_repair->Operation();
//End Execute Components

//Go to destination page @1-AB3877A1
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($workshop_repair);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-04343E53
$workshop_repair->Show();
$Link2->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-E565BE31
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($workshop_repair);
unset($Tpl);
//End Unload Page


?>
