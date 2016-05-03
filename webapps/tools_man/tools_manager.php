<?php
//Include Common Files @1-2F747FC3
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "tools_manager.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridemployees_tbl_employees_t1 { //employees_tbl_employees_t1 class @2-CDC763AB

//Variables @2-AC1EDBB9

    // Public variables
    var $ComponentType = "Grid";
    var $ComponentName;
    var $Visible;
    var $Errors;
    var $ErrorBlock;
    var $ds;
    var $DataSource;
    var $PageSize;
    var $IsEmpty;
    var $ForceIteration = false;
    var $HasRecord = false;
    var $SorterName = "";
    var $SorterDirection = "";
    var $PageNumber;
    var $RowNumber;
    var $ControlsVisible = array();

    var $CCSEvents = "";
    var $CCSEventResult;

    var $RelativePath = "";
    var $Attributes;

    // Grid Controls
    var $StaticControls;
    var $RowControls;
//End Variables

//Class_Initialize Event @2-45BC2A57
    function clsGridemployees_tbl_employees_t1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "employees_tbl_employees_t1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid employees_tbl_employees_t1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsemployees_tbl_employees_t1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->tool_description = & new clsControl(ccsLabel, "tool_description", "tool_description", ccsText, "", CCGetRequestParam("tool_description", ccsGet, NULL), $this);
        $this->tool_id = & new clsControl(ccsLabel, "tool_id", "tool_id", ccsInteger, "", CCGetRequestParam("tool_id", ccsGet, NULL), $this);
        $this->supplier_name = & new clsControl(ccsLabel, "supplier_name", "supplier_name", ccsText, "", CCGetRequestParam("supplier_name", ccsGet, NULL), $this);
        $this->manufacturer_name = & new clsControl(ccsLabel, "manufacturer_name", "manufacturer_name", ccsText, "", CCGetRequestParam("manufacturer_name", ccsGet, NULL), $this);
        $this->employees_tbl_emp_login = & new clsControl(ccsLabel, "employees_tbl_emp_login", "employees_tbl_emp_login", ccsText, "", CCGetRequestParam("employees_tbl_emp_login", ccsGet, NULL), $this);
        $this->employees_tbl1_emp_login = & new clsControl(ccsLabel, "employees_tbl1_emp_login", "employees_tbl1_emp_login", ccsText, "", CCGetRequestParam("employees_tbl1_emp_login", ccsGet, NULL), $this);
        $this->tool_status = & new clsControl(ccsLabel, "tool_status", "tool_status", ccsText, "", CCGetRequestParam("tool_status", ccsGet, NULL), $this);
        $this->Navigator = & new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @2-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @2-5B5DEE28
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_tool_category_id"] = CCGetFromGet("s_tool_category_id", NULL);
        $this->DataSource->Parameters["urls_tool_type_id"] = CCGetFromGet("s_tool_type_id", NULL);
        $this->DataSource->Parameters["urls_tool_description"] = CCGetFromGet("s_tool_description", NULL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->Prepare();
        $this->DataSource->Open();
        $this->HasRecord = $this->DataSource->has_next_record();
        $this->IsEmpty = ! $this->HasRecord;
        $this->Attributes->Show();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $GridBlock = "Grid " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $GridBlock;


        if (!$this->IsEmpty) {
            $this->ControlsVisible["tool_description"] = $this->tool_description->Visible;
            $this->ControlsVisible["tool_id"] = $this->tool_id->Visible;
            $this->ControlsVisible["supplier_name"] = $this->supplier_name->Visible;
            $this->ControlsVisible["manufacturer_name"] = $this->manufacturer_name->Visible;
            $this->ControlsVisible["employees_tbl_emp_login"] = $this->employees_tbl_emp_login->Visible;
            $this->ControlsVisible["employees_tbl1_emp_login"] = $this->employees_tbl1_emp_login->Visible;
            $this->ControlsVisible["tool_status"] = $this->tool_status->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->tool_description->SetValue($this->DataSource->tool_description->GetValue());
                $this->tool_id->SetValue($this->DataSource->tool_id->GetValue());
                $this->supplier_name->SetValue($this->DataSource->supplier_name->GetValue());
                $this->manufacturer_name->SetValue($this->DataSource->manufacturer_name->GetValue());
                $this->employees_tbl_emp_login->SetValue($this->DataSource->employees_tbl_emp_login->GetValue());
                $this->employees_tbl1_emp_login->SetValue($this->DataSource->employees_tbl1_emp_login->GetValue());
                $this->tool_status->SetValue($this->DataSource->tool_status->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tool_description->Show();
                $this->tool_id->Show();
                $this->supplier_name->Show();
                $this->manufacturer_name->Show();
                $this->employees_tbl_emp_login->Show();
                $this->employees_tbl1_emp_login->Show();
                $this->tool_status->Show();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
            }
        }
        else { // Show NoRecords block if no records are found
            $this->Attributes->Show();
            $Tpl->parse("NoRecords", false);
        }

        $errors = $this->GetErrors();
        if(strlen($errors))
        {
            $Tpl->replaceblock("", $errors);
            $Tpl->block_path = $ParentPath;
            return;
        }
        $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator->TotalPages = $this->DataSource->PageCount();
        if ($this->Navigator->TotalPages <= 1) {
            $this->Navigator->Visible = false;
        }
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-066665CC
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->tool_description->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tool_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->supplier_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->manufacturer_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->employees_tbl_emp_login->Errors->ToString());
        $errors = ComposeStrings($errors, $this->employees_tbl1_emp_login->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tool_status->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End employees_tbl_employees_t1 Class @2-FCB6E20C

class clsemployees_tbl_employees_t1DataSource extends clsDBhss_db {  //employees_tbl_employees_t1DataSource Class @2-63EDD76A

//DataSource Variables @2-D90B3D18
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $CountSQL;
    var $wp;


    // Datasource fields
    var $tool_description;
    var $tool_id;
    var $supplier_name;
    var $manufacturer_name;
    var $employees_tbl_emp_login;
    var $employees_tbl1_emp_login;
    var $tool_status;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-919E44A0
    function clsemployees_tbl_employees_t1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid employees_tbl_employees_t1";
        $this->Initialize();
        $this->tool_description = new clsField("tool_description", ccsText, "");
        
        $this->tool_id = new clsField("tool_id", ccsInteger, "");
        
        $this->supplier_name = new clsField("supplier_name", ccsText, "");
        
        $this->manufacturer_name = new clsField("manufacturer_name", ccsText, "");
        
        $this->employees_tbl_emp_login = new clsField("employees_tbl_emp_login", ccsText, "");
        
        $this->employees_tbl1_emp_login = new clsField("employees_tbl1_emp_login", ccsText, "");
        
        $this->tool_status = new clsField("tool_status", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-8D84A893
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "tool_description";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-F45E68C0
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_tool_category_id", ccsInteger, "", "", $this->Parameters["urls_tool_category_id"], "", false);
        $this->wp->AddParameter("2", "urls_tool_type_id", ccsInteger, "", "", $this->Parameters["urls_tool_type_id"], "", false);
        $this->wp->AddParameter("3", "urls_tool_description", ccsText, "", "", $this->Parameters["urls_tool_description"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "tools.tool_category_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "tools.tool_type_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "tools.tool_description", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]);
    }
//End Prepare Method

//Open Method @2-34B99C47
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((((tools INNER JOIN tools_suppliers ON\n\n" .
        "tools.supplier_id = tools_suppliers.supplier_id) INNER JOIN tools_manufacturers ON\n\n" .
        "tools.manufacturer_id = tools_manufacturers.manufacturer_id) INNER JOIN tools_status ON\n\n" .
        "tools.tool_status_id = tools_status.tool_status_id) INNER JOIN employees_tbl ON\n\n" .
        "employees_tbl.emp_id = tools.regular_user_id) INNER JOIN employees_tbl employees_tbl1 ON\n\n" .
        "employees_tbl1.emp_id = tools.current_user_id";
        $this->SQL = "SELECT tools.*, supplier_name, manufacturer_name, tool_status, employees_tbl.emp_login AS employees_tbl_emp_login, employees_tbl1.emp_login AS employees_tbl1_emp_login \n\n" .
        "FROM ((((tools INNER JOIN tools_suppliers ON\n\n" .
        "tools.supplier_id = tools_suppliers.supplier_id) INNER JOIN tools_manufacturers ON\n\n" .
        "tools.manufacturer_id = tools_manufacturers.manufacturer_id) INNER JOIN tools_status ON\n\n" .
        "tools.tool_status_id = tools_status.tool_status_id) INNER JOIN employees_tbl ON\n\n" .
        "employees_tbl.emp_id = tools.regular_user_id) INNER JOIN employees_tbl employees_tbl1 ON\n\n" .
        "employees_tbl1.emp_id = tools.current_user_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-15528FDC
    function SetValues()
    {
        $this->tool_description->SetDBValue($this->f("tool_description"));
        $this->tool_id->SetDBValue(trim($this->f("tool_id")));
        $this->supplier_name->SetDBValue($this->f("supplier_name"));
        $this->manufacturer_name->SetDBValue($this->f("manufacturer_name"));
        $this->employees_tbl_emp_login->SetDBValue($this->f("employees_tbl_emp_login"));
        $this->employees_tbl1_emp_login->SetDBValue($this->f("employees_tbl1_emp_login"));
        $this->tool_status->SetDBValue($this->f("tool_status"));
    }
//End SetValues Method

} //End employees_tbl_employees_t1DataSource Class @2-FCB6E20C

class clsRecordemployees_tbl_employees_t { //employees_tbl_employees_t Class @26-60B3F139

//Variables @26-D6FF3E86

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

//Class_Initialize Event @26-A6B4F1C1
    function clsRecordemployees_tbl_employees_t($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record employees_tbl_employees_t/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "employees_tbl_employees_t";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = & new clsButton("Button_DoSearch", $Method, $this);
            $this->s_tool_category_id = & new clsControl(ccsListBox, "s_tool_category_id", "s_tool_category_id", ccsInteger, "", CCGetRequestParam("s_tool_category_id", $Method, NULL), $this);
            $this->s_tool_type_id = & new clsControl(ccsListBox, "s_tool_type_id", "s_tool_type_id", ccsInteger, "", CCGetRequestParam("s_tool_type_id", $Method, NULL), $this);
            $this->s_tool_description = & new clsControl(ccsTextBox, "s_tool_description", "s_tool_description", ccsText, "", CCGetRequestParam("s_tool_description", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @26-1C0562B8
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_tool_category_id->Validate() && $Validation);
        $Validation = ($this->s_tool_type_id->Validate() && $Validation);
        $Validation = ($this->s_tool_description->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_tool_category_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tool_type_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tool_description->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @26-E429C04B
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_tool_category_id->Errors->Count());
        $errors = ($errors || $this->s_tool_type_id->Errors->Count());
        $errors = ($errors || $this->s_tool_description->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @26-ED598703
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

//Operation Method @26-3F5A43D1
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        if(!$this->FormSubmitted) {
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = "Button_DoSearch";
            if($this->Button_DoSearch->Pressed) {
                $this->PressedButton = "Button_DoSearch";
            }
        }
        $Redirect = "tools_manager.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "tools_manager.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @26-BDA6F5B9
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

        $this->s_tool_category_id->Prepare();
        $this->s_tool_type_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_tool_category_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tool_type_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tool_description->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_DoSearch->Show();
        $this->s_tool_category_id->Show();
        $this->s_tool_type_id->Show();
        $this->s_tool_description->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End employees_tbl_employees_t Class @26-FCB6E20C

//Initialize Page @1-2B851321
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
$TemplateFileName = "tools_manager.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-39294120
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$employees_tbl_employees_t1 = & new clsGridemployees_tbl_employees_t1("", $MainPage);
$employees_tbl_employees_t = & new clsRecordemployees_tbl_employees_t("", $MainPage);
$MainPage->employees_tbl_employees_t1 = & $employees_tbl_employees_t1;
$MainPage->employees_tbl_employees_t = & $employees_tbl_employees_t;
$employees_tbl_employees_t1->Initialize();

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

//Execute Components @1-C278AD3C
$employees_tbl_employees_t->Operation();
//End Execute Components

//Go to destination page @1-73E37CAD
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($employees_tbl_employees_t1);
    unset($employees_tbl_employees_t);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-BE3CBCA3
$employees_tbl_employees_t1->Show();
$employees_tbl_employees_t->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-DE441662
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($employees_tbl_employees_t1);
unset($employees_tbl_employees_t);
unset($Tpl);
//End Unload Page


?>
