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

class clsGridemployees_tbl { //employees_tbl class @2-5D2E28A1

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

//Class_Initialize Event @2-771A604C
    function clsGridemployees_tbl($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "employees_tbl";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid employees_tbl";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsemployees_tblDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->emp_id = & new clsControl(ccsLabel, "emp_id", "emp_id", ccsInteger, "", CCGetRequestParam("emp_id", ccsGet, NULL), $this);
        $this->emp_name = & new clsControl(ccsLink, "emp_name", "emp_name", ccsText, "", CCGetRequestParam("emp_name", ccsGet, NULL), $this);
        $this->emp_name->Page = "page0.php";
        $this->emp_login = & new clsControl(ccsLabel, "emp_login", "emp_login", ccsText, "", CCGetRequestParam("emp_login", ccsGet, NULL), $this);
        $this->phone_home = & new clsControl(ccsLabel, "phone_home", "phone_home", ccsText, "", CCGetRequestParam("phone_home", ccsGet, NULL), $this);
        $this->phone_cell = & new clsControl(ccsLabel, "phone_cell", "phone_cell", ccsText, "", CCGetRequestParam("phone_cell", ccsGet, NULL), $this);
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

//Show Method @2-F2943CB5
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_emp_name"] = CCGetFromGet("s_emp_name", NULL);
        $this->DataSource->Parameters["urls_emp_id"] = CCGetFromGet("s_emp_id", NULL);
        $this->DataSource->Parameters["urls_group_id"] = CCGetFromGet("s_group_id", NULL);
        $this->DataSource->Parameters["urls_department_id"] = CCGetFromGet("s_department_id", NULL);

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
            $this->ControlsVisible["emp_id"] = $this->emp_id->Visible;
            $this->ControlsVisible["emp_name"] = $this->emp_name->Visible;
            $this->ControlsVisible["emp_login"] = $this->emp_login->Visible;
            $this->ControlsVisible["phone_home"] = $this->phone_home->Visible;
            $this->ControlsVisible["phone_cell"] = $this->phone_cell->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->emp_id->SetValue($this->DataSource->emp_id->GetValue());
                $this->emp_name->SetValue($this->DataSource->emp_name->GetValue());
                $this->emp_name->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->emp_name->Parameters = CCAddParam($this->emp_name->Parameters, "emp_id", $this->DataSource->f("emp_id"));
                $this->emp_login->SetValue($this->DataSource->emp_login->GetValue());
                $this->phone_home->SetValue($this->DataSource->phone_home->GetValue());
                $this->phone_cell->SetValue($this->DataSource->phone_cell->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->emp_id->Show();
                $this->emp_name->Show();
                $this->emp_login->Show();
                $this->phone_home->Show();
                $this->phone_cell->Show();
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

//GetErrors Method @2-41B2C397
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->emp_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->emp_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->emp_login->Errors->ToString());
        $errors = ComposeStrings($errors, $this->phone_home->Errors->ToString());
        $errors = ComposeStrings($errors, $this->phone_cell->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End employees_tbl Class @2-FCB6E20C

class clsemployees_tblDataSource extends clsDBhss_db {  //employees_tblDataSource Class @2-82429F6B

//DataSource Variables @2-E7BC1C37
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $CountSQL;
    var $wp;


    // Datasource fields
    var $emp_id;
    var $emp_name;
    var $emp_login;
    var $phone_home;
    var $phone_cell;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-C3E7A8BD
    function clsemployees_tblDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid employees_tbl";
        $this->Initialize();
        $this->emp_id = new clsField("emp_id", ccsInteger, "");
        
        $this->emp_name = new clsField("emp_name", ccsText, "");
        
        $this->emp_login = new clsField("emp_login", ccsText, "");
        
        $this->phone_home = new clsField("phone_home", ccsText, "");
        
        $this->phone_cell = new clsField("phone_cell", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-8262A7E3
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "emp_id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-56266B78
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_emp_name", ccsText, "", "", $this->Parameters["urls_emp_name"], "", false);
        $this->wp->AddParameter("2", "urls_emp_id", ccsInteger, "", "", $this->Parameters["urls_emp_id"], "", false);
        $this->wp->AddParameter("3", "urls_group_id", ccsInteger, "", "", $this->Parameters["urls_group_id"], "", false);
        $this->wp->AddParameter("4", "urls_department_id", ccsInteger, "", "", $this->Parameters["urls_department_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "emp_name", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "emp_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "group_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "department_id", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]), 
             $this->wp->Criterion[4]);
    }
//End Prepare Method

//Open Method @2-BDC921E9
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM employees_tbl";
        $this->SQL = "SELECT * \n\n" .
        "FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-9AC94342
    function SetValues()
    {
        $this->emp_id->SetDBValue(trim($this->f("emp_id")));
        $this->emp_name->SetDBValue($this->f("emp_name"));
        $this->emp_login->SetDBValue($this->f("emp_login"));
        $this->phone_home->SetDBValue($this->f("phone_home"));
        $this->phone_cell->SetDBValue($this->f("phone_cell"));
    }
//End SetValues Method

} //End employees_tblDataSource Class @2-FCB6E20C

class clsRecordemployees_tblSearch { //employees_tblSearch Class @3-A287EAA2

//Variables @3-D6FF3E86

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

//Class_Initialize Event @3-D33E7E72
    function clsRecordemployees_tblSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record employees_tblSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "employees_tblSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = & new clsButton("Button_DoSearch", $Method, $this);
            $this->s_emp_name = & new clsControl(ccsTextBox, "s_emp_name", "s_emp_name", ccsText, "", CCGetRequestParam("s_emp_name", $Method, NULL), $this);
            $this->s_group_id = & new clsControl(ccsListBox, "s_group_id", "s_group_id", ccsInteger, "", CCGetRequestParam("s_group_id", $Method, NULL), $this);
            $this->s_group_id->DSType = dsTable;
            $this->s_group_id->DataSource = new clsDBhss_db();
            $this->s_group_id->ds = & $this->s_group_id->DataSource;
            $this->s_group_id->DataSource->SQL = "SELECT * \n" .
"FROM groups_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->s_group_id->BoundColumn, $this->s_group_id->TextColumn, $this->s_group_id->DBFormat) = array("group_id", "group_name", "");
            $this->s_department_id = & new clsControl(ccsListBox, "s_department_id", "s_department_id", ccsInteger, "", CCGetRequestParam("s_department_id", $Method, NULL), $this);
            $this->s_department_id->DSType = dsTable;
            $this->s_department_id->DataSource = new clsDBhss_db();
            $this->s_department_id->ds = & $this->s_department_id->DataSource;
            $this->s_department_id->DataSource->SQL = "SELECT * \n" .
"FROM departments_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->s_department_id->BoundColumn, $this->s_department_id->TextColumn, $this->s_department_id->DBFormat) = array("department_id", "department_name", "");
            $this->Button1 = & new clsButton("Button1", $Method, $this);
        }
    }
//End Class_Initialize Event

//Validate Method @3-A8C0B824
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_emp_name->Validate() && $Validation);
        $Validation = ($this->s_group_id->Validate() && $Validation);
        $Validation = ($this->s_department_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_emp_name->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_group_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_department_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @3-A258D24C
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_emp_name->Errors->Count());
        $errors = ($errors || $this->s_group_id->Errors->Count());
        $errors = ($errors || $this->s_department_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @3-ED598703
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

//Operation Method @3-E6A5E256
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
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = "page1.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "page1.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button1", "Button1_x", "Button1_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button1") {
                $Redirect = "index.html";
                if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @3-2C1793F4
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

        $this->s_group_id->Prepare();
        $this->s_department_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_emp_name->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_group_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_department_id->Errors->ToString());
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
        $this->s_emp_name->Show();
        $this->s_group_id->Show();
        $this->s_department_id->Show();
        $this->Button1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End employees_tblSearch Class @3-FCB6E20C

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

//Initialize Objects @1-C1EE9F6C
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$employees_tbl = & new clsGridemployees_tbl("", $MainPage);
$employees_tblSearch = & new clsRecordemployees_tblSearch("", $MainPage);
$MainPage->employees_tbl = & $employees_tbl;
$MainPage->employees_tblSearch = & $employees_tblSearch;
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

//Execute Components @1-03E20F27
$employees_tblSearch->Operation();
//End Execute Components

//Go to destination page @1-5686D128
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($employees_tbl);
    unset($employees_tblSearch);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-5E662CE2
$employees_tbl->Show();
$employees_tblSearch->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-28E40882
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($employees_tbl);
unset($employees_tblSearch);
unset($Tpl);
//End Unload Page


?>
