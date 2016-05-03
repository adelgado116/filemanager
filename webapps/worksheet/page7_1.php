<?php
//Include Common Files @1-9BCEE710
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page7_1.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordservice_tbl { //service_tbl Class @2-EED398F1

//Variables @2-9E315808

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

//Class_Initialize Event @2-8E181CD1
    function clsRecordservice_tbl($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record service_tbl/Error";
        $this->DataSource = new clsservice_tblDataSource($this);
        $this->ds = & $this->DataSource;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "service_tbl";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->AGENT_EVAL_TECH = new clsControl(ccsListBox, "AGENT_EVAL_TECH", "AGENT EVAL TECH", ccsText, "", CCGetRequestParam("AGENT_EVAL_TECH", $Method, NULL), $this);
            $this->AGENT_EVAL_TECH->DSType = dsTable;
            $this->AGENT_EVAL_TECH->DataSource = new clsDBhss_db();
            $this->AGENT_EVAL_TECH->ds = & $this->AGENT_EVAL_TECH->DataSource;
            $this->AGENT_EVAL_TECH->DataSource->SQL = "SELECT * \n" .
"FROM evaluation_values_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->AGENT_EVAL_TECH->BoundColumn, $this->AGENT_EVAL_TECH->TextColumn, $this->AGENT_EVAL_TECH->DBFormat) = array("grades", "grades", "");
            $this->AGENT_EVAL_TECH->Required = true;
            $this->RETURN_PARTS_TO = new clsControl(ccsListBox, "RETURN_PARTS_TO", "RETURN PARTS TO", ccsInteger, "", CCGetRequestParam("RETURN_PARTS_TO", $Method, NULL), $this);
            $this->RETURN_PARTS_TO->DSType = dsTable;
            $this->RETURN_PARTS_TO->DataSource = new clsDBhss_db();
            $this->RETURN_PARTS_TO->ds = & $this->RETURN_PARTS_TO->DataSource;
            $this->RETURN_PARTS_TO->DataSource->SQL = "SELECT * \n" .
"FROM equipment_manufacturer_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->RETURN_PARTS_TO->BoundColumn, $this->RETURN_PARTS_TO->TextColumn, $this->RETURN_PARTS_TO->DBFormat) = array("MANUF_ID", "MANUF_NAME", "");
            $this->ORDER_PARTS_FROM = new clsControl(ccsListBox, "ORDER_PARTS_FROM", "ORDER PARTS FROM", ccsInteger, "", CCGetRequestParam("ORDER_PARTS_FROM", $Method, NULL), $this);
            $this->ORDER_PARTS_FROM->DSType = dsTable;
            $this->ORDER_PARTS_FROM->DataSource = new clsDBhss_db();
            $this->ORDER_PARTS_FROM->ds = & $this->ORDER_PARTS_FROM->DataSource;
            $this->ORDER_PARTS_FROM->DataSource->SQL = "SELECT * \n" .
"FROM equipment_manufacturer_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->ORDER_PARTS_FROM->BoundColumn, $this->ORDER_PARTS_FROM->TextColumn, $this->ORDER_PARTS_FROM->DBFormat) = array("MANUF_ID", "MANUF_NAME", "");
        }
    }
//End Class_Initialize Event

//Initialize Method @2-08CA07B5
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["sesORDER"] = CCGetSession("ORDER", NULL);
    }
//End Initialize Method

//Validate Method @2-034BE86E
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->AGENT_EVAL_TECH->Validate() && $Validation);
        $Validation = ($this->RETURN_PARTS_TO->Validate() && $Validation);
        $Validation = ($this->ORDER_PARTS_FROM->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->AGENT_EVAL_TECH->Errors->Count() == 0);
        $Validation =  $Validation && ($this->RETURN_PARTS_TO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ORDER_PARTS_FROM->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-FAD8D1EE
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->AGENT_EVAL_TECH->Errors->Count());
        $errors = ($errors || $this->RETURN_PARTS_TO->Errors->Count());
        $errors = ($errors || $this->ORDER_PARTS_FROM->Errors->Count());
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

//Operation Method @2-517B5C36
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
            $this->PressedButton = $this->EditMode ? "Button_Update" : "";
            if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
            if($this->PressedButton == "Button_Update") {
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

//UpdateRow Method @2-F64157C5
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->AGENT_EVAL_TECH->SetValue($this->AGENT_EVAL_TECH->GetValue(true));
        $this->DataSource->RETURN_PARTS_TO->SetValue($this->RETURN_PARTS_TO->GetValue(true));
        $this->DataSource->ORDER_PARTS_FROM->SetValue($this->ORDER_PARTS_FROM->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-D1405782
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

        $this->AGENT_EVAL_TECH->Prepare();
        $this->RETURN_PARTS_TO->Prepare();
        $this->ORDER_PARTS_FROM->Prepare();

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
                    $this->AGENT_EVAL_TECH->SetValue($this->DataSource->AGENT_EVAL_TECH->GetValue());
                    $this->RETURN_PARTS_TO->SetValue($this->DataSource->RETURN_PARTS_TO->GetValue());
                    $this->ORDER_PARTS_FROM->SetValue($this->DataSource->ORDER_PARTS_FROM->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->AGENT_EVAL_TECH->Errors->ToString());
            $Error = ComposeStrings($Error, $this->RETURN_PARTS_TO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ORDER_PARTS_FROM->Errors->ToString());
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
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Update->Show();
        $this->AGENT_EVAL_TECH->Show();
        $this->RETURN_PARTS_TO->Show();
        $this->ORDER_PARTS_FROM->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End service_tbl Class @2-FCB6E20C

class clsservice_tblDataSource extends clsDBhss_db {  //service_tblDataSource Class @2-3DA74026

//DataSource Variables @2-A83FA798
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $UpdateFields = array();

    // Datasource fields
    public $AGENT_EVAL_TECH;
    public $RETURN_PARTS_TO;
    public $ORDER_PARTS_FROM;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-5C73F2DD
    function clsservice_tblDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record service_tbl/Error";
        $this->Initialize();
        $this->AGENT_EVAL_TECH = new clsField("AGENT_EVAL_TECH", ccsText, "");
        
        $this->RETURN_PARTS_TO = new clsField("RETURN_PARTS_TO", ccsInteger, "");
        
        $this->ORDER_PARTS_FROM = new clsField("ORDER_PARTS_FROM", ccsInteger, "");
        

        $this->UpdateFields["AGENT_EVAL_TECH"] = array("Name" => "AGENT_EVAL_TECH", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["RETURN_PARTS_TO"] = array("Name" => "RETURN_PARTS_TO", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["ORDER_PARTS_FROM"] = array("Name" => "ORDER_PARTS_FROM", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-194E0A45
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "sesORDER", ccsText, "", "", $this->Parameters["sesORDER"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "ORDER_NO", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-4CA0018A
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM service_tbl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-546532C0
    function SetValues()
    {
        $this->AGENT_EVAL_TECH->SetDBValue($this->f("AGENT_EVAL_TECH"));
        $this->RETURN_PARTS_TO->SetDBValue(trim($this->f("RETURN_PARTS_TO")));
        $this->ORDER_PARTS_FROM->SetDBValue(trim($this->f("ORDER_PARTS_FROM")));
    }
//End SetValues Method

//Update Method @2-F9AC703D
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["AGENT_EVAL_TECH"] = new clsSQLParameter("ctrlAGENT_EVAL_TECH", ccsText, "", "", $this->AGENT_EVAL_TECH->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["RETURN_PARTS_TO"] = new clsSQLParameter("ctrlRETURN_PARTS_TO", ccsInteger, "", "", $this->RETURN_PARTS_TO->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["ORDER_PARTS_FROM"] = new clsSQLParameter("ctrlORDER_PARTS_FROM", ccsInteger, "", "", $this->ORDER_PARTS_FROM->GetValue(true), NULL, false, $this->ErrorBlock);
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "sesORDER", ccsText, "", "", CCGetSession("ORDER", NULL), "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        if (!is_null($this->cp["AGENT_EVAL_TECH"]->GetValue()) and !strlen($this->cp["AGENT_EVAL_TECH"]->GetText()) and !is_bool($this->cp["AGENT_EVAL_TECH"]->GetValue())) 
            $this->cp["AGENT_EVAL_TECH"]->SetValue($this->AGENT_EVAL_TECH->GetValue(true));
        if (!is_null($this->cp["RETURN_PARTS_TO"]->GetValue()) and !strlen($this->cp["RETURN_PARTS_TO"]->GetText()) and !is_bool($this->cp["RETURN_PARTS_TO"]->GetValue())) 
            $this->cp["RETURN_PARTS_TO"]->SetValue($this->RETURN_PARTS_TO->GetValue(true));
        if (!is_null($this->cp["ORDER_PARTS_FROM"]->GetValue()) and !strlen($this->cp["ORDER_PARTS_FROM"]->GetText()) and !is_bool($this->cp["ORDER_PARTS_FROM"]->GetValue())) 
            $this->cp["ORDER_PARTS_FROM"]->SetValue($this->ORDER_PARTS_FROM->GetValue(true));
        $wp->Criterion[1] = $wp->Operation(opEqual, "ORDER_NO", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsText),false);
        $Where = 
             $wp->Criterion[1];
        $this->UpdateFields["AGENT_EVAL_TECH"]["Value"] = $this->cp["AGENT_EVAL_TECH"]->GetDBValue(true);
        $this->UpdateFields["RETURN_PARTS_TO"]["Value"] = $this->cp["RETURN_PARTS_TO"]->GetDBValue(true);
        $this->UpdateFields["ORDER_PARTS_FROM"]["Value"] = $this->cp["ORDER_PARTS_FROM"]->GetDBValue(true);
        $this->SQL = CCBuildUpdate("service_tbl", $this->UpdateFields, $this);
        $this->SQL .= strlen($Where) ? " WHERE " . $Where : $Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End service_tblDataSource Class @2-FCB6E20C

//Initialize Page @1-79A35C64
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
$TemplateFileName = "page7_1.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-AE84D647
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$service_tbl = new clsRecordservice_tbl("", $MainPage);
$Link2 = new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $MainPage);
$Link2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link2->Page = "http://localhost";
$MainPage->service_tbl = & $service_tbl;
$MainPage->Link2 = & $Link2;
$service_tbl->Initialize();

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

//Execute Components @1-14561358
$service_tbl->Operation();
//End Execute Components

//Go to destination page @1-E9E47825
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($service_tbl);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-BC6F9CF5
$service_tbl->Show();
$Link2->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-F548D588
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($service_tbl);
unset($Tpl);
//End Unload Page


?>
