<?php
//Include Common Files @1-5A71A9CC
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page0.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
include_once(RelativePath . "/Services.php");
//End Include Common Files

class clsGridtools { //tools class @65-1BFEA0A1

//Variables @65-AC1EDBB9

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

//Class_Initialize Event @65-6F1F5E34
    function clsGridtools($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "tools";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid tools";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clstoolsDataSource($this);
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
        $this->tool_status = & new clsControl(ccsLabel, "tool_status", "tool_status", ccsText, "", CCGetRequestParam("tool_status", ccsGet, NULL), $this);
        $this->employees_tbl1_emp_login = & new clsControl(ccsLabel, "employees_tbl1_emp_login", "employees_tbl1_emp_login", ccsText, "", CCGetRequestParam("employees_tbl1_emp_login", ccsGet, NULL), $this);
        $this->Link4 = & new clsControl(ccsLink, "Link4", "Link4", ccsText, "", CCGetRequestParam("Link4", ccsGet, NULL), $this);
        $this->Link4->Page = "barcode_gen/barcode.php";
        $this->Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "page0_1_1.php";
        $this->Link2 = & new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $this);
        $this->Link2->Page = "page0_2.php";
        $this->Navigator = & new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @65-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @65-FEB10166
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
            $this->ControlsVisible["tool_status"] = $this->tool_status->Visible;
            $this->ControlsVisible["employees_tbl1_emp_login"] = $this->employees_tbl1_emp_login->Visible;
            $this->ControlsVisible["Link4"] = $this->Link4->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            $this->ControlsVisible["Link2"] = $this->Link2->Visible;
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
                $this->tool_status->SetValue($this->DataSource->tool_status->GetValue());
                $this->employees_tbl1_emp_login->SetValue($this->DataSource->employees_tbl1_emp_login->GetValue());
                $this->Link4->Parameters = "";
                $this->Link4->Parameters = CCAddParam($this->Link4->Parameters, "tool_id", $this->DataSource->f("tool_id"));
                $this->Link1->Parameters = "";
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "tool_id", $this->DataSource->f("tool_id"));
                $this->Link2->Parameters = "";
                $this->Link2->Parameters = CCAddParam($this->Link2->Parameters, "tool_id", $this->DataSource->f("tool_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tool_description->Show();
                $this->tool_id->Show();
                $this->supplier_name->Show();
                $this->manufacturer_name->Show();
                $this->employees_tbl_emp_login->Show();
                $this->tool_status->Show();
                $this->employees_tbl1_emp_login->Show();
                $this->Link4->Show();
                $this->Link1->Show();
                $this->Link2->Show();
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

//GetErrors Method @65-06823D4C
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->tool_description->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tool_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->supplier_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->manufacturer_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->employees_tbl_emp_login->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tool_status->Errors->ToString());
        $errors = ComposeStrings($errors, $this->employees_tbl1_emp_login->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link4->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End tools Class @65-FCB6E20C

class clstoolsDataSource extends clsDBhss_db {  //toolsDataSource Class @65-F2CF8EBD

//DataSource Variables @65-0276D2DE
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
    var $tool_status;
    var $employees_tbl1_emp_login;
//End DataSource Variables

//DataSourceClass_Initialize Event @65-EA9259A5
    function clstoolsDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid tools";
        $this->Initialize();
        $this->tool_description = new clsField("tool_description", ccsText, "");
        
        $this->tool_id = new clsField("tool_id", ccsInteger, "");
        
        $this->supplier_name = new clsField("supplier_name", ccsText, "");
        
        $this->manufacturer_name = new clsField("manufacturer_name", ccsText, "");
        
        $this->employees_tbl_emp_login = new clsField("employees_tbl_emp_login", ccsText, "");
        
        $this->tool_status = new clsField("tool_status", ccsText, "");
        
        $this->employees_tbl1_emp_login = new clsField("employees_tbl1_emp_login", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @65-E602C178
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "tools.tool_description";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @65-F45E68C0
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

//Open Method @65-F1FAA757
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((((tools INNER JOIN tools_suppliers ON\n\n" .
        "tools.supplier_id = tools_suppliers.supplier_id) INNER JOIN tools_manufacturers ON\n\n" .
        "tools.manufacturer_id = tools_manufacturers.manufacturer_id) INNER JOIN tools_status ON\n\n" .
        "tools.tool_status_id = tools_status.tool_status_id) INNER JOIN employees_tbl ON\n\n" .
        "tools.regular_user_id = employees_tbl.emp_id) INNER JOIN employees_tbl employees_tbl1 ON\n\n" .
        "employees_tbl1.emp_id = tools.current_user_id";
        $this->SQL = "SELECT supplier_name, manufacturer_name, tool_status, employees_tbl.emp_login AS employees_tbl_emp_login, tools.*, employees_tbl1.emp_login AS employees_tbl1_emp_login \n\n" .
        "FROM ((((tools INNER JOIN tools_suppliers ON\n\n" .
        "tools.supplier_id = tools_suppliers.supplier_id) INNER JOIN tools_manufacturers ON\n\n" .
        "tools.manufacturer_id = tools_manufacturers.manufacturer_id) INNER JOIN tools_status ON\n\n" .
        "tools.tool_status_id = tools_status.tool_status_id) INNER JOIN employees_tbl ON\n\n" .
        "tools.regular_user_id = employees_tbl.emp_id) INNER JOIN employees_tbl employees_tbl1 ON\n\n" .
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

//SetValues Method @65-7694454C
    function SetValues()
    {
        $this->tool_description->SetDBValue($this->f("tool_description"));
        $this->tool_id->SetDBValue(trim($this->f("tool_id")));
        $this->supplier_name->SetDBValue($this->f("supplier_name"));
        $this->manufacturer_name->SetDBValue($this->f("manufacturer_name"));
        $this->employees_tbl_emp_login->SetDBValue($this->f("employees_tbl_emp_login"));
        $this->tool_status->SetDBValue($this->f("tool_status"));
        $this->employees_tbl1_emp_login->SetDBValue($this->f("employees_tbl1_emp_login"));
    }
//End SetValues Method

} //End toolsDataSource Class @65-FCB6E20C

class clsRecordtoolsSearch { //toolsSearch Class @66-889695F4

//Variables @66-D6FF3E86

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

//Class_Initialize Event @66-A7C529A6
    function clsRecordtoolsSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record toolsSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "toolsSearch";
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
            $this->s_tool_category_id->DSType = dsTable;
            $this->s_tool_category_id->DataSource = new clsDBhss_db();
            $this->s_tool_category_id->ds = & $this->s_tool_category_id->DataSource;
            $this->s_tool_category_id->DataSource->SQL = "SELECT * \n" .
"FROM tools_categories {SQL_Where} {SQL_OrderBy}";
            list($this->s_tool_category_id->BoundColumn, $this->s_tool_category_id->TextColumn, $this->s_tool_category_id->DBFormat) = array("tool_category_id", "tool_category", "");
            $this->s_tool_type_id = & new clsControl(ccsListBox, "s_tool_type_id", "s_tool_type_id", ccsInteger, "", CCGetRequestParam("s_tool_type_id", $Method, NULL), $this);
            $this->s_tool_type_id->DSType = dsTable;
            $this->s_tool_type_id->DataSource = new clsDBhss_db();
            $this->s_tool_type_id->ds = & $this->s_tool_type_id->DataSource;
            $this->s_tool_type_id->DataSource->SQL = "SELECT * \n" .
"FROM tools_types {SQL_Where} {SQL_OrderBy}";
            $this->s_tool_type_id->DataSource->Order = "tool_type";
            list($this->s_tool_type_id->BoundColumn, $this->s_tool_type_id->TextColumn, $this->s_tool_type_id->DBFormat) = array("tool_type_id", "tool_type", "");
            $this->s_tool_type_id->DataSource->Parameters["urls_tool_category_id"] = CCGetFromGet("s_tool_category_id", NULL);
            $this->s_tool_type_id->DataSource->wp = new clsSQLParameters();
            $this->s_tool_type_id->DataSource->wp->AddParameter("1", "urls_tool_category_id", ccsInteger, "", "", $this->s_tool_type_id->DataSource->Parameters["urls_tool_category_id"], "", false);
            $this->s_tool_type_id->DataSource->wp->Criterion[1] = $this->s_tool_type_id->DataSource->wp->Operation(opEqual, "tool_category_id", $this->s_tool_type_id->DataSource->wp->GetDBValue("1"), $this->s_tool_type_id->DataSource->ToSQL($this->s_tool_type_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->s_tool_type_id->DataSource->Where = 
                 $this->s_tool_type_id->DataSource->wp->Criterion[1];
            $this->s_tool_type_id->DataSource->Order = "tool_type";
            $this->s_tool_description = & new clsControl(ccsTextBox, "s_tool_description", "s_tool_description", ccsText, "", CCGetRequestParam("s_tool_description", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @66-1C0562B8
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

//CheckErrors Method @66-E429C04B
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

//MasterDetail @66-ED598703
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

//Operation Method @66-7765A60C
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
        $Redirect = "page0.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "page0.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @66-BDA6F5B9
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

} //End toolsSearch Class @66-FCB6E20C

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

//Include events file @1-DA4E8D55
include_once("./page0_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-97A6D577
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tools = & new clsGridtools("", $MainPage);
$toolsSearch = & new clsRecordtoolsSearch("", $MainPage);
$Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $MainPage);
$Link1->Page = "page0_1.php";
$Link2 = & new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $MainPage);
$Link2->Page = "barcode_gen/barcodes_all.php";
$MainPage->tools = & $tools;
$MainPage->toolsSearch = & $toolsSearch;
$MainPage->Link1 = & $Link1;
$MainPage->Link2 = & $Link2;
$tools->Initialize();

BindEvents();

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

//Execute Components @1-EC30603F
$toolsSearch->Operation();
//End Execute Components

//Go to destination page @1-7B8A7DFA
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($tools);
    unset($toolsSearch);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-69B0DEE6
$tools->Show();
$toolsSearch->Show();
$Link1->Show();
$Link2->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-EFFFB7F5
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($tools);
unset($toolsSearch);
unset($Tpl);
//End Unload Page


?>
