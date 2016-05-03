<?php
//Include Common Files @1-AF90E393
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page0_1.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridsales_table_imported_non1 { //sales_table_imported_non1 class @3-CDECE2D7

//Variables @3-6E51DF5A

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

//Class_Initialize Event @3-9E4F3CB6
    function clsGridsales_table_imported_non1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "sales_table_imported_non1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid sales_table_imported_non1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clssales_table_imported_non1DataSource($this);
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

        $this->CREATEDATE = new clsControl(ccsLabel, "CREATEDATE", "CREATEDATE", ccsText, "", CCGetRequestParam("CREATEDATE", ccsGet, NULL), $this);
        $this->SALESNUMBER = new clsControl(ccsLabel, "SALESNUMBER", "SALESNUMBER", ccsText, "", CCGetRequestParam("SALESNUMBER", ccsGet, NULL), $this);
        $this->IMOnumber = new clsControl(ccsLabel, "IMOnumber", "IMOnumber", ccsText, "", CCGetRequestParam("IMOnumber", ccsGet, NULL), $this);
        $this->CUSTOMERREF = new clsControl(ccsLabel, "CUSTOMERREF", "CUSTOMERREF", ccsText, "", CCGetRequestParam("CUSTOMERREF", ccsGet, NULL), $this);
        $this->DELMODE = new clsControl(ccsLabel, "DELMODE", "DELMODE", ccsText, "", CCGetRequestParam("DELMODE", ccsGet, NULL), $this);
        $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "page0_2.php";
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @3-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @3-CFD3147C
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_CREATEDATE"] = CCGetFromGet("s_CREATEDATE", NULL);
        $this->DataSource->Parameters["urls_SALESNUMBER"] = CCGetFromGet("s_SALESNUMBER", NULL);

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
            $this->ControlsVisible["CREATEDATE"] = $this->CREATEDATE->Visible;
            $this->ControlsVisible["SALESNUMBER"] = $this->SALESNUMBER->Visible;
            $this->ControlsVisible["IMOnumber"] = $this->IMOnumber->Visible;
            $this->ControlsVisible["CUSTOMERREF"] = $this->CUSTOMERREF->Visible;
            $this->ControlsVisible["DELMODE"] = $this->DELMODE->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->CREATEDATE->SetValue($this->DataSource->CREATEDATE->GetValue());
                $this->SALESNUMBER->SetValue($this->DataSource->SALESNUMBER->GetValue());
                $this->IMOnumber->SetValue($this->DataSource->IMOnumber->GetValue());
                $this->CUSTOMERREF->SetValue($this->DataSource->CUSTOMERREF->GetValue());
                $this->DELMODE->SetValue($this->DataSource->DELMODE->GetValue());
                $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "SALESNUMBER", $this->DataSource->f("SALESNUMBER"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->CREATEDATE->Show();
                $this->SALESNUMBER->Show();
                $this->IMOnumber->Show();
                $this->CUSTOMERREF->Show();
                $this->DELMODE->Show();
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

//GetErrors Method @3-FF209DE3
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->CREATEDATE->Errors->ToString());
        $errors = ComposeStrings($errors, $this->SALESNUMBER->Errors->ToString());
        $errors = ComposeStrings($errors, $this->IMOnumber->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CUSTOMERREF->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DELMODE->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End sales_table_imported_non1 Class @3-FCB6E20C

class clssales_table_imported_non1DataSource extends clsDBhss_db {  //sales_table_imported_non1DataSource Class @3-C7BE3371

//DataSource Variables @3-3BE6677D
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $CREATEDATE;
    public $SALESNUMBER;
    public $IMOnumber;
    public $CUSTOMERREF;
    public $DELMODE;
//End DataSource Variables

//DataSourceClass_Initialize Event @3-116E73C3
    function clssales_table_imported_non1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid sales_table_imported_non1";
        $this->Initialize();
        $this->CREATEDATE = new clsField("CREATEDATE", ccsText, "");
        
        $this->SALESNUMBER = new clsField("SALESNUMBER", ccsText, "");
        
        $this->IMOnumber = new clsField("IMOnumber", ccsText, "");
        
        $this->CUSTOMERREF = new clsField("CUSTOMERREF", ccsText, "");
        
        $this->DELMODE = new clsField("DELMODE", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @3-EEDD2785
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "SALESNUMBER desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @3-03878E25
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_CREATEDATE", ccsText, "", "", $this->Parameters["urls_CREATEDATE"], "", false);
        $this->wp->AddParameter("2", "urls_SALESNUMBER", ccsText, "", "", $this->Parameters["urls_SALESNUMBER"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "CREATEDATE", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "SALESNUMBER", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @3-C080F24E
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM sales_table_imported_non_obs";
        $this->SQL = "SELECT * \n\n" .
        "FROM sales_table_imported_non_obs {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @3-2F69AB9C
    function SetValues()
    {
        $this->CREATEDATE->SetDBValue($this->f("CREATEDATE"));
        $this->SALESNUMBER->SetDBValue($this->f("SALESNUMBER"));
        $this->IMOnumber->SetDBValue($this->f("IMOnumber"));
        $this->CUSTOMERREF->SetDBValue($this->f("CUSTOMERREF"));
        $this->DELMODE->SetDBValue($this->f("DELMODE"));
    }
//End SetValues Method

} //End sales_table_imported_non1DataSource Class @3-FCB6E20C

class clsRecordsales_table_imported_non { //sales_table_imported_non Class @4-7433B620

//Variables @4-9E315808

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

//Class_Initialize Event @4-8B376CF2
    function clsRecordsales_table_imported_non($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record sales_table_imported_non/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "sales_table_imported_non";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_CREATEDATE = new clsControl(ccsTextBox, "s_CREATEDATE", "s_CREATEDATE", ccsText, "", CCGetRequestParam("s_CREATEDATE", $Method, NULL), $this);
            $this->s_SALESNUMBER = new clsControl(ccsTextBox, "s_SALESNUMBER", "s_SALESNUMBER", ccsText, "", CCGetRequestParam("s_SALESNUMBER", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @4-8D82325D
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_CREATEDATE->Validate() && $Validation);
        $Validation = ($this->s_SALESNUMBER->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_CREATEDATE->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_SALESNUMBER->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @4-7953ACAD
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_CREATEDATE->Errors->Count());
        $errors = ($errors || $this->s_SALESNUMBER->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @4-ED598703
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

//Operation Method @4-D759D934
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
        $Redirect = "page0_1.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "page0_1.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @4-D2088091
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


        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_CREATEDATE->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_SALESNUMBER->Errors->ToString());
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
        $this->s_CREATEDATE->Show();
        $this->s_SALESNUMBER->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End sales_table_imported_non Class @4-FCB6E20C

//Initialize Page @1-04357CC0
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
$TemplateFileName = "page0_1.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-500D7B6D
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Link2 = new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $MainPage);
$Link2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link2->Page = "../file_manager/page0.php";
$sales_table_imported_non1 = new clsGridsales_table_imported_non1("", $MainPage);
$sales_table_imported_non = new clsRecordsales_table_imported_non("", $MainPage);
$MainPage->Link2 = & $Link2;
$MainPage->sales_table_imported_non1 = & $sales_table_imported_non1;
$MainPage->sales_table_imported_non = & $sales_table_imported_non;
$sales_table_imported_non1->Initialize();

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

//Execute Components @1-1DC0F8F2
$sales_table_imported_non->Operation();
//End Execute Components

//Go to destination page @1-26C2CE9A
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($sales_table_imported_non1);
    unset($sales_table_imported_non);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-B133589D
$sales_table_imported_non1->Show();
$sales_table_imported_non->Show();
$Link2->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-BE7CD989
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($sales_table_imported_non1);
unset($sales_table_imported_non);
unset($Tpl);
//End Unload Page


?>
