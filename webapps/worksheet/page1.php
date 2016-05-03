<?php
//Include Common Files @1-8C4BFF6A
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page1.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
include_once(RelativePath . "/Services.php");
//End Include Common Files

class clsRecordsales_table_importedSearch { //sales_table_importedSearch Class @3-860123F5

//Variables @3-9E315808

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

//Class_Initialize Event @3-C6D6AD60
    function clsRecordsales_table_importedSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record sales_table_importedSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "sales_table_importedSearch";
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
            $this->s_CUSTOMERREF = new clsControl(ccsTextBox, "s_CUSTOMERREF", "s_CUSTOMERREF", ccsText, "", CCGetRequestParam("s_CUSTOMERREF", $Method, NULL), $this);
            $this->s_IMOnumber = new clsControl(ccsTextBox, "s_IMOnumber", "s_IMOnumber", ccsText, "", CCGetRequestParam("s_IMOnumber", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @3-31E9E765
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_CREATEDATE->Validate() && $Validation);
        $Validation = ($this->s_SALESNUMBER->Validate() && $Validation);
        $Validation = ($this->s_CUSTOMERREF->Validate() && $Validation);
        $Validation = ($this->s_IMOnumber->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_CREATEDATE->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_SALESNUMBER->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_CUSTOMERREF->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_IMOnumber->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @3-2F20E9DB
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_CREATEDATE->Errors->Count());
        $errors = ($errors || $this->s_SALESNUMBER->Errors->Count());
        $errors = ($errors || $this->s_CUSTOMERREF->Errors->Count());
        $errors = ($errors || $this->s_IMOnumber->Errors->Count());
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

//Operation Method @3-61B01389
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
        $Redirect = "page1.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "page1.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @3-F2DC2406
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
            $Error = ComposeStrings($Error, $this->s_CUSTOMERREF->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_IMOnumber->Errors->ToString());
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
        $this->s_CUSTOMERREF->Show();
        $this->s_IMOnumber->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End sales_table_importedSearch Class @3-FCB6E20C

class clsGridsales_table_imported { //sales_table_imported class @2-65A3E57A

//Variables @2-6E51DF5A

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

//Class_Initialize Event @2-7297040F
    function clsGridsales_table_imported($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "sales_table_imported";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid sales_table_imported";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clssales_table_importedDataSource($this);
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
        $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "page2.php";
        $this->Link2 = new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $this);
        $this->Link2->Page = "../file_manager/page2.php";
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
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

//Show Method @2-506E72DF
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_CREATEDATE"] = CCGetFromGet("s_CREATEDATE", NULL);
        $this->DataSource->Parameters["urls_SALESNUMBER"] = CCGetFromGet("s_SALESNUMBER", NULL);
        $this->DataSource->Parameters["urls_CUSTOMERREF"] = CCGetFromGet("s_CUSTOMERREF", NULL);
        $this->DataSource->Parameters["urls_IMOnumber"] = CCGetFromGet("s_IMOnumber", NULL);

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
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            $this->ControlsVisible["Link2"] = $this->Link2->Visible;
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
                $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "ORDER_NO", $this->DataSource->f("SALESNUMBER"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "IMO_NUMBER", $this->DataSource->f("IMOnumber"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "SHIPNAME", $this->DataSource->f("CUSTOMERREF"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "REQUISNUMBER", $this->DataSource->f("REQUISNUMBER"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "SALESNAME", $this->DataSource->f("SALESNAME"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "DEBTORACCOUNT", $this->DataSource->f("DEBTORACCOUNT"));
                $this->Link2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link2->Parameters = CCAddParam($this->Link2->Parameters, "ORDER_NO", $this->DataSource->f("SALESNUMBER"));
                $this->Link2->Parameters = CCAddParam($this->Link2->Parameters, "IMO_NUMBER", $this->DataSource->f("IMOnumber"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->CREATEDATE->Show();
                $this->SALESNUMBER->Show();
                $this->IMOnumber->Show();
                $this->CUSTOMERREF->Show();
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

//GetErrors Method @2-2267125A
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->CREATEDATE->Errors->ToString());
        $errors = ComposeStrings($errors, $this->SALESNUMBER->Errors->ToString());
        $errors = ComposeStrings($errors, $this->IMOnumber->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CUSTOMERREF->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End sales_table_imported Class @2-FCB6E20C

class clssales_table_importedDataSource extends clsDBhss_db {  //sales_table_importedDataSource Class @2-2CFD8F8B

//DataSource Variables @2-085DDB58
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
//End DataSource Variables

//DataSourceClass_Initialize Event @2-2B31ADFA
    function clssales_table_importedDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid sales_table_imported";
        $this->Initialize();
        $this->CREATEDATE = new clsField("CREATEDATE", ccsText, "");
        
        $this->SALESNUMBER = new clsField("SALESNUMBER", ccsText, "");
        
        $this->IMOnumber = new clsField("IMOnumber", ccsText, "");
        
        $this->CUSTOMERREF = new clsField("CUSTOMERREF", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-7B73B689
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "CREATEDATE desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-88D5613B
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_CREATEDATE", ccsText, "", "", $this->Parameters["urls_CREATEDATE"], "", false);
        $this->wp->AddParameter("2", "urls_SALESNUMBER", ccsText, "", "", $this->Parameters["urls_SALESNUMBER"], "", false);
        $this->wp->AddParameter("3", "urls_CUSTOMERREF", ccsText, "", "", $this->Parameters["urls_CUSTOMERREF"], "", false);
        $this->wp->AddParameter("4", "urls_IMOnumber", ccsText, "", "", $this->Parameters["urls_IMOnumber"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "CREATEDATE", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "SALESNUMBER", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "CUSTOMERREF", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opContains, "IMOnumber", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText),false);
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

//Open Method @2-0D0F0AAC
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM sales_table_imported";
        $this->SQL = "SELECT * \n\n" .
        "FROM sales_table_imported {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-910A4027
    function SetValues()
    {
        $this->CREATEDATE->SetDBValue($this->f("CREATEDATE"));
        $this->SALESNUMBER->SetDBValue($this->f("SALESNUMBER"));
        $this->IMOnumber->SetDBValue($this->f("IMOnumber"));
        $this->CUSTOMERREF->SetDBValue($this->f("CUSTOMERREF"));
    }
//End SetValues Method

} //End sales_table_importedDataSource Class @2-FCB6E20C



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

//Include events file @1-63B556BD
include_once("./page1_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-46C9C2D9
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $MainPage);
$Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link1->Page = "page0_1.php";
$sales_table_importedSearch = new clsRecordsales_table_importedSearch("", $MainPage);
$sales_table_imported = new clsGridsales_table_imported("", $MainPage);
$MainPage->Link1 = & $Link1;
$MainPage->sales_table_importedSearch = & $sales_table_importedSearch;
$MainPage->sales_table_imported = & $sales_table_imported;
$sales_table_imported->Initialize();

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

//Execute Components @1-C2486AE8
$sales_table_importedSearch->Operation();
//End Execute Components

//Go to destination page @1-4AD86474
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($sales_table_importedSearch);
    unset($sales_table_imported);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-23B5B6CD
$sales_table_importedSearch->Show();
$sales_table_imported->Show();
$Link1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-788992A5
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($sales_table_importedSearch);
unset($sales_table_imported);
unset($Tpl);
//End Unload Page


?>
