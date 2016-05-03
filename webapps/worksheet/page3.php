<?php
//Include Common Files @1-FB4E5467
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page3.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
include_once(RelativePath . "/Services.php");
//End Include Common Files

class clsGridequipment_manufacturer_tb1 { //equipment_manufacturer_tb1 class @7-16FC1DF1

//Variables @7-6E51DF5A

    // Public variables
    public $ComponentType = "Grid";
    public $ComponentName;
    public $Visible;
    public $Errors;
    public $ErrorBlock;
    public $ds;
    public $DataSource;
    public $PageSize;
    public $IsEmpty;
    public $ForceIteration = false;
    public $HasRecord = false;
    public $SorterName = "";
    public $SorterDirection = "";
    public $PageNumber;
    public $RowNumber;
    public $ControlsVisible = array();

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";
    public $Attributes;

    // Grid Controls
    public $StaticControls;
    public $RowControls;
//End Variables

//Class_Initialize Event @7-50292BB3
    function clsGridequipment_manufacturer_tb1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "equipment_manufacturer_tb1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid equipment_manufacturer_tb1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsequipment_manufacturer_tb1DataSource($this);
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

        $this->MANUF_NAME = new clsControl(ccsLabel, "MANUF_NAME", "MANUF_NAME", ccsText, "", CCGetRequestParam("MANUF_NAME", ccsGet, NULL), $this);
        $this->EQUIP_TYPE = new clsControl(ccsLabel, "EQUIP_TYPE", "EQUIP_TYPE", ccsText, "", CCGetRequestParam("EQUIP_TYPE", ccsGet, NULL), $this);
        $this->EQUIP_MODEL = new clsControl(ccsLabel, "EQUIP_MODEL", "EQUIP_MODEL", ccsText, "", CCGetRequestParam("EQUIP_MODEL", ccsGet, NULL), $this);
        $this->extended_info = new clsControl(ccsLabel, "extended_info", "extended_info", ccsText, "", CCGetRequestParam("extended_info", ccsGet, NULL), $this);
        $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "page3_0.php";
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @7-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @7-A07EE1CF
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_MANUF_ID"] = CCGetFromGet("s_MANUF_ID", NULL);
        $this->DataSource->Parameters["urls_EQUIP_TYPE_ID"] = CCGetFromGet("s_EQUIP_TYPE_ID", NULL);
        $this->DataSource->Parameters["urls_EQUIP_MODEL"] = CCGetFromGet("s_EQUIP_MODEL", NULL);

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
            $this->ControlsVisible["MANUF_NAME"] = $this->MANUF_NAME->Visible;
            $this->ControlsVisible["EQUIP_TYPE"] = $this->EQUIP_TYPE->Visible;
            $this->ControlsVisible["EQUIP_MODEL"] = $this->EQUIP_MODEL->Visible;
            $this->ControlsVisible["extended_info"] = $this->extended_info->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->MANUF_NAME->SetValue($this->DataSource->MANUF_NAME->GetValue());
                $this->EQUIP_TYPE->SetValue($this->DataSource->EQUIP_TYPE->GetValue());
                $this->EQUIP_MODEL->SetValue($this->DataSource->EQUIP_MODEL->GetValue());
                $this->extended_info->SetValue($this->DataSource->extended_info->GetValue());
                $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "EQUIP_MODEL", $this->DataSource->f("EQUIP_MODEL"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "ORDER_NO", CCGetSession("ORDER", NULL));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "EQUIP_ID", $this->DataSource->f("EQUIP_ID"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->MANUF_NAME->Show();
                $this->EQUIP_TYPE->Show();
                $this->EQUIP_MODEL->Show();
                $this->extended_info->Show();
                $this->Link1->Show();
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

//GetErrors Method @7-007660C2
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->MANUF_NAME->Errors->ToString());
        $errors = ComposeStrings($errors, $this->EQUIP_TYPE->Errors->ToString());
        $errors = ComposeStrings($errors, $this->EQUIP_MODEL->Errors->ToString());
        $errors = ComposeStrings($errors, $this->extended_info->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End equipment_manufacturer_tb1 Class @7-FCB6E20C

class clsequipment_manufacturer_tb1DataSource extends clsDBhss_db {  //equipment_manufacturer_tb1DataSource Class @7-F0E30DC2

//DataSource Variables @7-345CBB9D
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $MANUF_NAME;
    public $EQUIP_TYPE;
    public $EQUIP_MODEL;
    public $extended_info;
//End DataSource Variables

//DataSourceClass_Initialize Event @7-E8BD957C
    function clsequipment_manufacturer_tb1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid equipment_manufacturer_tb1";
        $this->Initialize();
        $this->MANUF_NAME = new clsField("MANUF_NAME", ccsText, "");
        
        $this->EQUIP_TYPE = new clsField("EQUIP_TYPE", ccsText, "");
        
        $this->EQUIP_MODEL = new clsField("EQUIP_MODEL", ccsText, "");
        
        $this->extended_info = new clsField("extended_info", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @7-108A1936
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "MANUF_NAME";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @7-3312237A
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_MANUF_ID", ccsInteger, "", "", $this->Parameters["urls_MANUF_ID"], "", false);
        $this->wp->AddParameter("2", "urls_EQUIP_TYPE_ID", ccsInteger, "", "", $this->Parameters["urls_EQUIP_TYPE_ID"], "", false);
        $this->wp->AddParameter("3", "urls_EQUIP_MODEL", ccsText, "", "", $this->Parameters["urls_EQUIP_MODEL"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "equipment_model_tbl.MANUF_ID", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "equipment_model_tbl.EQUIP_TYPE_ID", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "equipment_model_tbl.EQUIP_MODEL", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]);
    }
//End Prepare Method

//Open Method @7-0A5165CE
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (equipment_model_tbl INNER JOIN equipment_manufacturer_tbl ON\n\n" .
        "equipment_model_tbl.MANUF_ID = equipment_manufacturer_tbl.MANUF_ID) INNER JOIN equipment_type_tbl ON\n\n" .
        "equipment_model_tbl.EQUIP_TYPE_ID = equipment_type_tbl.EQUIP_TYPE_ID";
        $this->SQL = "SELECT MANUF_NAME, equipment_model_tbl.*, EQUIP_TYPE \n\n" .
        "FROM (equipment_model_tbl INNER JOIN equipment_manufacturer_tbl ON\n\n" .
        "equipment_model_tbl.MANUF_ID = equipment_manufacturer_tbl.MANUF_ID) INNER JOIN equipment_type_tbl ON\n\n" .
        "equipment_model_tbl.EQUIP_TYPE_ID = equipment_type_tbl.EQUIP_TYPE_ID {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @7-5D9DB320
    function SetValues()
    {
        $this->MANUF_NAME->SetDBValue($this->f("MANUF_NAME"));
        $this->EQUIP_TYPE->SetDBValue($this->f("EQUIP_TYPE"));
        $this->EQUIP_MODEL->SetDBValue($this->f("EQUIP_MODEL"));
        $this->extended_info->SetDBValue($this->f("extended_info"));
    }
//End SetValues Method

} //End equipment_manufacturer_tb1DataSource Class @7-FCB6E20C

class clsRecordequipment_manufacturer_tb { //equipment_manufacturer_tb Class @17-E0047D13

//Variables @17-9E315808

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

//Class_Initialize Event @17-7D1CCB78
    function clsRecordequipment_manufacturer_tb($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record equipment_manufacturer_tb/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "equipment_manufacturer_tb";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_MANUF_ID = new clsControl(ccsListBox, "s_MANUF_ID", "s_MANUF_ID", ccsInteger, "", CCGetRequestParam("s_MANUF_ID", $Method, NULL), $this);
            $this->s_MANUF_ID->DSType = dsTable;
            $this->s_MANUF_ID->DataSource = new clsDBhss_db();
            $this->s_MANUF_ID->ds = & $this->s_MANUF_ID->DataSource;
            $this->s_MANUF_ID->DataSource->SQL = "SELECT * \n" .
"FROM equipment_manufacturer_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->s_MANUF_ID->BoundColumn, $this->s_MANUF_ID->TextColumn, $this->s_MANUF_ID->DBFormat) = array("MANUF_ID", "MANUF_NAME", "");
            $this->s_EQUIP_TYPE_ID = new clsControl(ccsListBox, "s_EQUIP_TYPE_ID", "s_EQUIP_TYPE_ID", ccsInteger, "", CCGetRequestParam("s_EQUIP_TYPE_ID", $Method, NULL), $this);
            $this->s_EQUIP_TYPE_ID->DSType = dsTable;
            $this->s_EQUIP_TYPE_ID->DataSource = new clsDBhss_db();
            $this->s_EQUIP_TYPE_ID->ds = & $this->s_EQUIP_TYPE_ID->DataSource;
            $this->s_EQUIP_TYPE_ID->DataSource->SQL = "SELECT * \n" .
"FROM equipment_type_tbl {SQL_Where} {SQL_OrderBy}";
            $this->s_EQUIP_TYPE_ID->DataSource->Order = "EQUIP_TYPE";
            list($this->s_EQUIP_TYPE_ID->BoundColumn, $this->s_EQUIP_TYPE_ID->TextColumn, $this->s_EQUIP_TYPE_ID->DBFormat) = array("EQUIP_TYPE_ID", "EQUIP_TYPE", "");
            $this->s_EQUIP_TYPE_ID->DataSource->Order = "EQUIP_TYPE";
            $this->s_EQUIP_MODEL = new clsControl(ccsTextBox, "s_EQUIP_MODEL", "s_EQUIP_MODEL", ccsText, "", CCGetRequestParam("s_EQUIP_MODEL", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @17-086334F8
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_MANUF_ID->Validate() && $Validation);
        $Validation = ($this->s_EQUIP_TYPE_ID->Validate() && $Validation);
        $Validation = ($this->s_EQUIP_MODEL->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_MANUF_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_EQUIP_TYPE_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_EQUIP_MODEL->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @17-D21CDE9C
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_MANUF_ID->Errors->Count());
        $errors = ($errors || $this->s_EQUIP_TYPE_ID->Errors->Count());
        $errors = ($errors || $this->s_EQUIP_MODEL->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @17-ED598703
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

//Operation Method @17-4C1B7883
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
        $Redirect = "page3.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "page3.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @17-AE9F4F22
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

        $this->s_MANUF_ID->Prepare();
        $this->s_EQUIP_TYPE_ID->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_MANUF_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_EQUIP_TYPE_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_EQUIP_MODEL->Errors->ToString());
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
        $this->s_MANUF_ID->Show();
        $this->s_EQUIP_TYPE_ID->Show();
        $this->s_EQUIP_MODEL->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End equipment_manufacturer_tb Class @17-FCB6E20C

//Initialize Page @1-DE4AD8DD
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
$TemplateFileName = "page3.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-CB33E72C
include_once("./page3_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-7F2C9D87
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $MainPage);
$Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link1->Page = "page1.php";
$Link2 = new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $MainPage);
$Link2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link2->Page = "page5.php";
$equipment_manufacturer_tb1 = new clsGridequipment_manufacturer_tb1("", $MainPage);
$equipment_manufacturer_tb = new clsRecordequipment_manufacturer_tb("", $MainPage);
$Link3 = new clsControl(ccsLink, "Link3", "Link3", ccsText, "", CCGetRequestParam("Link3", ccsGet, NULL), $MainPage);
$Link3->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link3->Page = "database_edition.php?destination=page3_1";
$MainPage->Link1 = & $Link1;
$MainPage->Link2 = & $Link2;
$MainPage->equipment_manufacturer_tb1 = & $equipment_manufacturer_tb1;
$MainPage->equipment_manufacturer_tb = & $equipment_manufacturer_tb;
$MainPage->Link3 = & $Link3;
$equipment_manufacturer_tb1->Initialize();

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

//Execute Components @1-BE21C08F
$equipment_manufacturer_tb->Operation();
//End Execute Components

//Go to destination page @1-79D7848F
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($equipment_manufacturer_tb1);
    unset($equipment_manufacturer_tb);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-7A1FD859
$equipment_manufacturer_tb1->Show();
$equipment_manufacturer_tb->Show();
$Link1->Show();
$Link2->Show();
$Link3->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-EDDF5868
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($equipment_manufacturer_tb1);
unset($equipment_manufacturer_tb);
unset($Tpl);
//End Unload Page


?>
