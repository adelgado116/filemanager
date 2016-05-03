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

class clsRecordservice_tbl { //service_tbl Class @23-EED398F1

//Variables @23-9E315808

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

//Class_Initialize Event @23-779802E7
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
        $this->InsertAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "service_tbl";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->ORDER_NO = new clsControl(ccsTextBox, "ORDER_NO", "ORDER NO", ccsText, "", CCGetRequestParam("ORDER_NO", $Method, NULL), $this);
            $this->ORDER_NO->Required = true;
            $this->IMO_NUMBER = new clsControl(ccsTextBox, "IMO_NUMBER", "IMO NUMBER", ccsText, "", CCGetRequestParam("IMO_NUMBER", $Method, NULL), $this);
            $this->REQUISNUMBER = new clsControl(ccsTextBox, "REQUISNUMBER", "REQUISNUMBER", ccsText, "", CCGetRequestParam("REQUISNUMBER", $Method, NULL), $this);
            $this->country_id = new clsControl(ccsListBox, "country_id", "Country Id", ccsInteger, "", CCGetRequestParam("country_id", $Method, NULL), $this);
            $this->country_id->DSType = dsTable;
            $this->country_id->DataSource = new clsDBhss_db();
            $this->country_id->ds = & $this->country_id->DataSource;
            $this->country_id->DataSource->SQL = "SELECT * \n" .
"FROM countries_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->country_id->BoundColumn, $this->country_id->TextColumn, $this->country_id->DBFormat) = array("country_id", "country_name", "");
            $this->country_id->Required = true;
            $this->city_id = new clsControl(ccsListBox, "city_id", "City Id", ccsInteger, "", CCGetRequestParam("city_id", $Method, NULL), $this);
            $this->city_id->DSType = dsTable;
            $this->city_id->DataSource = new clsDBhss_db();
            $this->city_id->ds = & $this->city_id->DataSource;
            $this->city_id->DataSource->SQL = "SELECT * \n" .
"FROM cities_tbl {SQL_Where} {SQL_OrderBy}";
            $this->city_id->DataSource->Order = "city_name";
            list($this->city_id->BoundColumn, $this->city_id->TextColumn, $this->city_id->DBFormat) = array("city_id", "city_name", "");
            $this->city_id->DataSource->Parameters["urlcountry_id"] = CCGetFromGet("country_id", NULL);
            $this->city_id->DataSource->wp = new clsSQLParameters();
            $this->city_id->DataSource->wp->AddParameter("1", "urlcountry_id", ccsInteger, "", "", $this->city_id->DataSource->Parameters["urlcountry_id"], "", false);
            $this->city_id->DataSource->wp->Criterion[1] = $this->city_id->DataSource->wp->Operation(opEqual, "country_id", $this->city_id->DataSource->wp->GetDBValue("1"), $this->city_id->DataSource->ToSQL($this->city_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->city_id->DataSource->Where = 
                 $this->city_id->DataSource->wp->Criterion[1];
            $this->city_id->DataSource->Order = "city_name";
            $this->city_id->Required = true;
            $this->PORT_ID = new clsControl(ccsListBox, "PORT_ID", "PORT ID", ccsInteger, "", CCGetRequestParam("PORT_ID", $Method, NULL), $this);
            $this->PORT_ID->DSType = dsTable;
            $this->PORT_ID->DataSource = new clsDBhss_db();
            $this->PORT_ID->ds = & $this->PORT_ID->DataSource;
            $this->PORT_ID->DataSource->SQL = "SELECT * \n" .
"FROM ports_tbl {SQL_Where} {SQL_OrderBy}";
            $this->PORT_ID->DataSource->Order = "PORT_NAME";
            list($this->PORT_ID->BoundColumn, $this->PORT_ID->TextColumn, $this->PORT_ID->DBFormat) = array("PORT_ID", "PORT_NAME", "");
            $this->PORT_ID->DataSource->Parameters["urlcountry_id"] = CCGetFromGet("country_id", NULL);
            $this->PORT_ID->DataSource->Parameters["urlcity_id"] = CCGetFromGet("city_id", NULL);
            $this->PORT_ID->DataSource->wp = new clsSQLParameters();
            $this->PORT_ID->DataSource->wp->AddParameter("1", "urlcountry_id", ccsInteger, "", "", $this->PORT_ID->DataSource->Parameters["urlcountry_id"], "", false);
            $this->PORT_ID->DataSource->wp->AddParameter("2", "urlcity_id", ccsInteger, "", "", $this->PORT_ID->DataSource->Parameters["urlcity_id"], "", false);
            $this->PORT_ID->DataSource->wp->Criterion[1] = $this->PORT_ID->DataSource->wp->Operation(opEqual, "country_id", $this->PORT_ID->DataSource->wp->GetDBValue("1"), $this->PORT_ID->DataSource->ToSQL($this->PORT_ID->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->PORT_ID->DataSource->wp->Criterion[2] = $this->PORT_ID->DataSource->wp->Operation(opEqual, "city_id", $this->PORT_ID->DataSource->wp->GetDBValue("2"), $this->PORT_ID->DataSource->ToSQL($this->PORT_ID->DataSource->wp->GetDBValue("2"), ccsInteger),false);
            $this->PORT_ID->DataSource->Where = $this->PORT_ID->DataSource->wp->opAND(
                 false, 
                 $this->PORT_ID->DataSource->wp->Criterion[1], 
                 $this->PORT_ID->DataSource->wp->Criterion[2]);
            $this->PORT_ID->DataSource->Order = "PORT_NAME";
            $this->PORT_ID->Required = true;
            $this->AGENT_ID = new clsControl(ccsListBox, "AGENT_ID", "AGENT ID", ccsInteger, "", CCGetRequestParam("AGENT_ID", $Method, NULL), $this);
            $this->AGENT_ID->DSType = dsTable;
            $this->AGENT_ID->DataSource = new clsDBhss_db();
            $this->AGENT_ID->ds = & $this->AGENT_ID->DataSource;
            $this->AGENT_ID->DataSource->SQL = "SELECT * \n" .
"FROM agents_tbl {SQL_Where} {SQL_OrderBy}";
            $this->AGENT_ID->DataSource->Order = "AGENT_NAME";
            list($this->AGENT_ID->BoundColumn, $this->AGENT_ID->TextColumn, $this->AGENT_ID->DBFormat) = array("AGENT_ID", "AGENT_NAME", "");
            $this->AGENT_ID->DataSource->Parameters["urlcountry_id"] = CCGetFromGet("country_id", NULL);
            $this->AGENT_ID->DataSource->Parameters["urlcity_id"] = CCGetFromGet("city_id", NULL);
            $this->AGENT_ID->DataSource->wp = new clsSQLParameters();
            $this->AGENT_ID->DataSource->wp->AddParameter("1", "urlcountry_id", ccsInteger, "", "", $this->AGENT_ID->DataSource->Parameters["urlcountry_id"], "", false);
            $this->AGENT_ID->DataSource->wp->AddParameter("2", "urlcity_id", ccsInteger, "", "", $this->AGENT_ID->DataSource->Parameters["urlcity_id"], "", false);
            $this->AGENT_ID->DataSource->wp->Criterion[1] = $this->AGENT_ID->DataSource->wp->Operation(opEqual, "country_id", $this->AGENT_ID->DataSource->wp->GetDBValue("1"), $this->AGENT_ID->DataSource->ToSQL($this->AGENT_ID->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->AGENT_ID->DataSource->wp->Criterion[2] = $this->AGENT_ID->DataSource->wp->Operation(opEqual, "city_id", $this->AGENT_ID->DataSource->wp->GetDBValue("2"), $this->AGENT_ID->DataSource->ToSQL($this->AGENT_ID->DataSource->wp->GetDBValue("2"), ccsInteger),false);
            $this->AGENT_ID->DataSource->Where = $this->AGENT_ID->DataSource->wp->opAND(
                 false, 
                 $this->AGENT_ID->DataSource->wp->Criterion[1], 
                 $this->AGENT_ID->DataSource->wp->Criterion[2]);
            $this->AGENT_ID->DataSource->Order = "AGENT_NAME";
            $this->AGENT_ID->Required = true;
            $this->AGENT_DUTY = new clsControl(ccsTextBox, "AGENT_DUTY", "AGENT DUTY", ccsText, "", CCGetRequestParam("AGENT_DUTY", $Method, NULL), $this);
            $this->STATUS_ID = new clsControl(ccsHidden, "STATUS_ID", "STATUS ID", ccsInteger, "", CCGetRequestParam("STATUS_ID", $Method, NULL), $this);
            $this->STATUS_ID->Required = true;
            $this->SALESNAME = new clsControl(ccsHidden, "SALESNAME", "SALESNAME", ccsText, "", CCGetRequestParam("SALESNAME", $Method, NULL), $this);
            $this->DEBTORACCOUNT = new clsControl(ccsHidden, "DEBTORACCOUNT", "DEBTORACCOUNT", ccsText, "", CCGetRequestParam("DEBTORACCOUNT", $Method, NULL), $this);
            $this->SHIPNAME = new clsControl(ccsTextBox, "SHIPNAME", "SHIPNAME", ccsText, "", CCGetRequestParam("SHIPNAME", $Method, NULL), $this);
            $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", $Method, NULL), $this);
            $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
            $this->Link1->Page = "database_edition.php?destination=page2_1";
            $this->Link2 = new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", $Method, NULL), $this);
            $this->Link2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
            $this->Link2->Page = "database_edition.php?destination=page2_2";
            $this->ETA_DATE_DAY = new clsControl(ccsListBox, "ETA_DATE_DAY", "ETA_DATE_DAY", ccsText, "", CCGetRequestParam("ETA_DATE_DAY", $Method, NULL), $this);
            $this->ETA_DATE_DAY->DSType = dsTable;
            $this->ETA_DATE_DAY->DataSource = new clsDBhss_db();
            $this->ETA_DATE_DAY->ds = & $this->ETA_DATE_DAY->DataSource;
            $this->ETA_DATE_DAY->DataSource->SQL = "SELECT * \n" .
"FROM days_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->ETA_DATE_DAY->BoundColumn, $this->ETA_DATE_DAY->TextColumn, $this->ETA_DATE_DAY->DBFormat) = array("days", "days", "");
            $this->ETA_DATE_DAY->Required = true;
            $this->ETA_DATE_MONTH = new clsControl(ccsListBox, "ETA_DATE_MONTH", "ETA_DATE_MONTH", ccsText, "", CCGetRequestParam("ETA_DATE_MONTH", $Method, NULL), $this);
            $this->ETA_DATE_MONTH->DSType = dsTable;
            $this->ETA_DATE_MONTH->DataSource = new clsDBhss_db();
            $this->ETA_DATE_MONTH->ds = & $this->ETA_DATE_MONTH->DataSource;
            $this->ETA_DATE_MONTH->DataSource->SQL = "SELECT * \n" .
"FROM months_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->ETA_DATE_MONTH->BoundColumn, $this->ETA_DATE_MONTH->TextColumn, $this->ETA_DATE_MONTH->DBFormat) = array("months", "months", "");
            $this->ETA_DATE_MONTH->Required = true;
            $this->ETA_DATE_YEAR = new clsControl(ccsListBox, "ETA_DATE_YEAR", "ETA_DATE_YEAR", ccsText, "", CCGetRequestParam("ETA_DATE_YEAR", $Method, NULL), $this);
            $this->ETA_DATE_YEAR->DSType = dsTable;
            $this->ETA_DATE_YEAR->DataSource = new clsDBhss_db();
            $this->ETA_DATE_YEAR->ds = & $this->ETA_DATE_YEAR->DataSource;
            $this->ETA_DATE_YEAR->DataSource->SQL = "SELECT * \n" .
"FROM years_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->ETA_DATE_YEAR->BoundColumn, $this->ETA_DATE_YEAR->TextColumn, $this->ETA_DATE_YEAR->DBFormat) = array("years", "years", "");
            $this->ETA_DATE_YEAR->Required = true;
            $this->ETA_HOUR = new clsControl(ccsTextBox, "ETA_HOUR", "ETA HOUR", ccsText, "", CCGetRequestParam("ETA_HOUR", $Method, NULL), $this);
            $this->ETA_HOUR->Required = true;
            $this->RETURN_REPORT_TO = new clsControl(ccsTextBox, "RETURN_REPORT_TO", "RETURN_REPORT_TO", ccsText, "", CCGetRequestParam("RETURN_REPORT_TO", $Method, NULL), $this);
            $this->ORDER_PARTS_FROM = new clsControl(ccsTextBox, "ORDER_PARTS_FROM", "ORDER_PARTS_FROM", ccsText, "", CCGetRequestParam("ORDER_PARTS_FROM", $Method, NULL), $this);
            $this->RETURN_PARTS_TO = new clsControl(ccsTextBox, "RETURN_PARTS_TO", "RETURN_PARTS_TO", ccsText, "", CCGetRequestParam("RETURN_PARTS_TO", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->STATUS_ID->Value) && !strlen($this->STATUS_ID->Value) && $this->STATUS_ID->Value !== false)
                    $this->STATUS_ID->SetText(1);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @23-2954BAE5
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlORDER_NO"] = CCGetFromGet("ORDER_NO", NULL);
    }
//End Initialize Method

//Validate Method @23-37CF0344
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->ORDER_NO->Validate() && $Validation);
        $Validation = ($this->IMO_NUMBER->Validate() && $Validation);
        $Validation = ($this->REQUISNUMBER->Validate() && $Validation);
        $Validation = ($this->country_id->Validate() && $Validation);
        $Validation = ($this->city_id->Validate() && $Validation);
        $Validation = ($this->PORT_ID->Validate() && $Validation);
        $Validation = ($this->AGENT_ID->Validate() && $Validation);
        $Validation = ($this->AGENT_DUTY->Validate() && $Validation);
        $Validation = ($this->STATUS_ID->Validate() && $Validation);
        $Validation = ($this->SALESNAME->Validate() && $Validation);
        $Validation = ($this->DEBTORACCOUNT->Validate() && $Validation);
        $Validation = ($this->SHIPNAME->Validate() && $Validation);
        $Validation = ($this->ETA_DATE_DAY->Validate() && $Validation);
        $Validation = ($this->ETA_DATE_MONTH->Validate() && $Validation);
        $Validation = ($this->ETA_DATE_YEAR->Validate() && $Validation);
        $Validation = ($this->ETA_HOUR->Validate() && $Validation);
        $Validation = ($this->RETURN_REPORT_TO->Validate() && $Validation);
        $Validation = ($this->ORDER_PARTS_FROM->Validate() && $Validation);
        $Validation = ($this->RETURN_PARTS_TO->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->ORDER_NO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->IMO_NUMBER->Errors->Count() == 0);
        $Validation =  $Validation && ($this->REQUISNUMBER->Errors->Count() == 0);
        $Validation =  $Validation && ($this->country_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->city_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->PORT_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->AGENT_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->AGENT_DUTY->Errors->Count() == 0);
        $Validation =  $Validation && ($this->STATUS_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->SALESNAME->Errors->Count() == 0);
        $Validation =  $Validation && ($this->DEBTORACCOUNT->Errors->Count() == 0);
        $Validation =  $Validation && ($this->SHIPNAME->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ETA_DATE_DAY->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ETA_DATE_MONTH->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ETA_DATE_YEAR->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ETA_HOUR->Errors->Count() == 0);
        $Validation =  $Validation && ($this->RETURN_REPORT_TO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ORDER_PARTS_FROM->Errors->Count() == 0);
        $Validation =  $Validation && ($this->RETURN_PARTS_TO->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @23-50466B93
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->ORDER_NO->Errors->Count());
        $errors = ($errors || $this->IMO_NUMBER->Errors->Count());
        $errors = ($errors || $this->REQUISNUMBER->Errors->Count());
        $errors = ($errors || $this->country_id->Errors->Count());
        $errors = ($errors || $this->city_id->Errors->Count());
        $errors = ($errors || $this->PORT_ID->Errors->Count());
        $errors = ($errors || $this->AGENT_ID->Errors->Count());
        $errors = ($errors || $this->AGENT_DUTY->Errors->Count());
        $errors = ($errors || $this->STATUS_ID->Errors->Count());
        $errors = ($errors || $this->SALESNAME->Errors->Count());
        $errors = ($errors || $this->DEBTORACCOUNT->Errors->Count());
        $errors = ($errors || $this->SHIPNAME->Errors->Count());
        $errors = ($errors || $this->Link1->Errors->Count());
        $errors = ($errors || $this->Link2->Errors->Count());
        $errors = ($errors || $this->ETA_DATE_DAY->Errors->Count());
        $errors = ($errors || $this->ETA_DATE_MONTH->Errors->Count());
        $errors = ($errors || $this->ETA_DATE_YEAR->Errors->Count());
        $errors = ($errors || $this->ETA_HOUR->Errors->Count());
        $errors = ($errors || $this->RETURN_REPORT_TO->Errors->Count());
        $errors = ($errors || $this->ORDER_PARTS_FROM->Errors->Count());
        $errors = ($errors || $this->RETURN_PARTS_TO->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @23-ED598703
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

//Operation Method @23-DAEE9B31
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
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = "page3.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
            $Redirect = "page1.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
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

//InsertRow Method @23-E2436180
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->ORDER_NO->SetValue($this->ORDER_NO->GetValue(true));
        $this->DataSource->IMO_NUMBER->SetValue($this->IMO_NUMBER->GetValue(true));
        $this->DataSource->REQUISNUMBER->SetValue($this->REQUISNUMBER->GetValue(true));
        $this->DataSource->country_id->SetValue($this->country_id->GetValue(true));
        $this->DataSource->city_id->SetValue($this->city_id->GetValue(true));
        $this->DataSource->PORT_ID->SetValue($this->PORT_ID->GetValue(true));
        $this->DataSource->AGENT_ID->SetValue($this->AGENT_ID->GetValue(true));
        $this->DataSource->AGENT_DUTY->SetValue($this->AGENT_DUTY->GetValue(true));
        $this->DataSource->STATUS_ID->SetValue($this->STATUS_ID->GetValue(true));
        $this->DataSource->SALESNAME->SetValue($this->SALESNAME->GetValue(true));
        $this->DataSource->DEBTORACCOUNT->SetValue($this->DEBTORACCOUNT->GetValue(true));
        $this->DataSource->SHIPNAME->SetValue($this->SHIPNAME->GetValue(true));
        $this->DataSource->Link1->SetValue($this->Link1->GetValue(true));
        $this->DataSource->Link2->SetValue($this->Link2->GetValue(true));
        $this->DataSource->ETA_DATE_DAY->SetValue($this->ETA_DATE_DAY->GetValue(true));
        $this->DataSource->ETA_DATE_MONTH->SetValue($this->ETA_DATE_MONTH->GetValue(true));
        $this->DataSource->ETA_DATE_YEAR->SetValue($this->ETA_DATE_YEAR->GetValue(true));
        $this->DataSource->ETA_HOUR->SetValue($this->ETA_HOUR->GetValue(true));
        $this->DataSource->RETURN_REPORT_TO->SetValue($this->RETURN_REPORT_TO->GetValue(true));
        $this->DataSource->ORDER_PARTS_FROM->SetValue($this->ORDER_PARTS_FROM->GetValue(true));
        $this->DataSource->RETURN_PARTS_TO->SetValue($this->RETURN_PARTS_TO->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//Show Method @23-F6D6BA88
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

        $this->country_id->Prepare();
        $this->city_id->Prepare();
        $this->PORT_ID->Prepare();
        $this->AGENT_ID->Prepare();
        $this->ETA_DATE_DAY->Prepare();
        $this->ETA_DATE_MONTH->Prepare();
        $this->ETA_DATE_YEAR->Prepare();

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
                    $this->ORDER_NO->SetValue($this->DataSource->ORDER_NO->GetValue());
                    $this->IMO_NUMBER->SetValue($this->DataSource->IMO_NUMBER->GetValue());
                    $this->REQUISNUMBER->SetValue($this->DataSource->REQUISNUMBER->GetValue());
                    $this->country_id->SetValue($this->DataSource->country_id->GetValue());
                    $this->city_id->SetValue($this->DataSource->city_id->GetValue());
                    $this->PORT_ID->SetValue($this->DataSource->PORT_ID->GetValue());
                    $this->AGENT_ID->SetValue($this->DataSource->AGENT_ID->GetValue());
                    $this->AGENT_DUTY->SetValue($this->DataSource->AGENT_DUTY->GetValue());
                    $this->STATUS_ID->SetValue($this->DataSource->STATUS_ID->GetValue());
                    $this->SALESNAME->SetValue($this->DataSource->SALESNAME->GetValue());
                    $this->DEBTORACCOUNT->SetValue($this->DataSource->DEBTORACCOUNT->GetValue());
                    $this->ETA_DATE_DAY->SetValue($this->DataSource->ETA_DATE_DAY->GetValue());
                    $this->ETA_DATE_MONTH->SetValue($this->DataSource->ETA_DATE_MONTH->GetValue());
                    $this->ETA_DATE_YEAR->SetValue($this->DataSource->ETA_DATE_YEAR->GetValue());
                    $this->ETA_HOUR->SetValue($this->DataSource->ETA_HOUR->GetValue());
                    $this->RETURN_REPORT_TO->SetValue($this->DataSource->RETURN_REPORT_TO->GetValue());
                    $this->ORDER_PARTS_FROM->SetValue($this->DataSource->ORDER_PARTS_FROM->GetValue());
                    $this->RETURN_PARTS_TO->SetValue($this->DataSource->RETURN_PARTS_TO->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->ORDER_NO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->IMO_NUMBER->Errors->ToString());
            $Error = ComposeStrings($Error, $this->REQUISNUMBER->Errors->ToString());
            $Error = ComposeStrings($Error, $this->country_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->city_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->PORT_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->AGENT_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->AGENT_DUTY->Errors->ToString());
            $Error = ComposeStrings($Error, $this->STATUS_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->SALESNAME->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DEBTORACCOUNT->Errors->ToString());
            $Error = ComposeStrings($Error, $this->SHIPNAME->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Link1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Link2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ETA_DATE_DAY->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ETA_DATE_MONTH->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ETA_DATE_YEAR->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ETA_HOUR->Errors->ToString());
            $Error = ComposeStrings($Error, $this->RETURN_REPORT_TO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ORDER_PARTS_FROM->Errors->ToString());
            $Error = ComposeStrings($Error, $this->RETURN_PARTS_TO->Errors->ToString());
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
        $this->Button_Cancel->Show();
        $this->ORDER_NO->Show();
        $this->IMO_NUMBER->Show();
        $this->REQUISNUMBER->Show();
        $this->country_id->Show();
        $this->city_id->Show();
        $this->PORT_ID->Show();
        $this->AGENT_ID->Show();
        $this->AGENT_DUTY->Show();
        $this->STATUS_ID->Show();
        $this->SALESNAME->Show();
        $this->DEBTORACCOUNT->Show();
        $this->SHIPNAME->Show();
        $this->Link1->Show();
        $this->Link2->Show();
        $this->ETA_DATE_DAY->Show();
        $this->ETA_DATE_MONTH->Show();
        $this->ETA_DATE_YEAR->Show();
        $this->ETA_HOUR->Show();
        $this->RETURN_REPORT_TO->Show();
        $this->ORDER_PARTS_FROM->Show();
        $this->RETURN_PARTS_TO->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End service_tbl Class @23-FCB6E20C

class clsservice_tblDataSource extends clsDBhss_db {  //service_tblDataSource Class @23-3DA74026

//DataSource Variables @23-398A2398
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();

    // Datasource fields
    public $ORDER_NO;
    public $IMO_NUMBER;
    public $REQUISNUMBER;
    public $country_id;
    public $city_id;
    public $PORT_ID;
    public $AGENT_ID;
    public $AGENT_DUTY;
    public $STATUS_ID;
    public $SALESNAME;
    public $DEBTORACCOUNT;
    public $SHIPNAME;
    public $Link1;
    public $Link2;
    public $ETA_DATE_DAY;
    public $ETA_DATE_MONTH;
    public $ETA_DATE_YEAR;
    public $ETA_HOUR;
    public $RETURN_REPORT_TO;
    public $ORDER_PARTS_FROM;
    public $RETURN_PARTS_TO;
//End DataSource Variables

//DataSourceClass_Initialize Event @23-4756E3B1
    function clsservice_tblDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record service_tbl/Error";
        $this->Initialize();
        $this->ORDER_NO = new clsField("ORDER_NO", ccsText, "");
        
        $this->IMO_NUMBER = new clsField("IMO_NUMBER", ccsText, "");
        
        $this->REQUISNUMBER = new clsField("REQUISNUMBER", ccsText, "");
        
        $this->country_id = new clsField("country_id", ccsInteger, "");
        
        $this->city_id = new clsField("city_id", ccsInteger, "");
        
        $this->PORT_ID = new clsField("PORT_ID", ccsInteger, "");
        
        $this->AGENT_ID = new clsField("AGENT_ID", ccsInteger, "");
        
        $this->AGENT_DUTY = new clsField("AGENT_DUTY", ccsText, "");
        
        $this->STATUS_ID = new clsField("STATUS_ID", ccsInteger, "");
        
        $this->SALESNAME = new clsField("SALESNAME", ccsText, "");
        
        $this->DEBTORACCOUNT = new clsField("DEBTORACCOUNT", ccsText, "");
        
        $this->SHIPNAME = new clsField("SHIPNAME", ccsText, "");
        
        $this->Link1 = new clsField("Link1", ccsText, "");
        
        $this->Link2 = new clsField("Link2", ccsText, "");
        
        $this->ETA_DATE_DAY = new clsField("ETA_DATE_DAY", ccsText, "");
        
        $this->ETA_DATE_MONTH = new clsField("ETA_DATE_MONTH", ccsText, "");
        
        $this->ETA_DATE_YEAR = new clsField("ETA_DATE_YEAR", ccsText, "");
        
        $this->ETA_HOUR = new clsField("ETA_HOUR", ccsText, "");
        
        $this->RETURN_REPORT_TO = new clsField("RETURN_REPORT_TO", ccsText, "");
        
        $this->ORDER_PARTS_FROM = new clsField("ORDER_PARTS_FROM", ccsText, "");
        
        $this->RETURN_PARTS_TO = new clsField("RETURN_PARTS_TO", ccsText, "");
        

        $this->InsertFields["ORDER_NO"] = array("Name" => "ORDER_NO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["IMO_NUMBER"] = array("Name" => "IMO_NUMBER", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["REQUISNUMBER"] = array("Name" => "REQUISNUMBER", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["country_id"] = array("Name" => "country_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["city_id"] = array("Name" => "city_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["PORT_ID"] = array("Name" => "PORT_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["AGENT_ID"] = array("Name" => "AGENT_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["AGENT_DUTY"] = array("Name" => "AGENT_DUTY", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["STATUS_ID"] = array("Name" => "STATUS_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["SALESNAME"] = array("Name" => "SALESNAME", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["DEBTORACCOUNT"] = array("Name" => "DEBTORACCOUNT", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["ETA_DATE_DAY"] = array("Name" => "ETA_DATE_DAY", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["ETA_DATE_MONTH"] = array("Name" => "ETA_DATE_MONTH", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["ETA_DATE_YEAR"] = array("Name" => "ETA_DATE_YEAR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["ETA_HOUR"] = array("Name" => "ETA_HOUR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["RETURN_REPORT_TO"] = array("Name" => "RETURN_REPORT_TO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["ORDER_PARTS_FROM"] = array("Name" => "ORDER_PARTS_FROM", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["RETURN_PARTS_TO"] = array("Name" => "RETURN_PARTS_TO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @23-1263266B
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlORDER_NO", ccsText, "", "", $this->Parameters["urlORDER_NO"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "ORDER_NO", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @23-4CA0018A
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

//SetValues Method @23-E2527DBF
    function SetValues()
    {
        $this->ORDER_NO->SetDBValue($this->f("ORDER_NO"));
        $this->IMO_NUMBER->SetDBValue($this->f("IMO_NUMBER"));
        $this->REQUISNUMBER->SetDBValue($this->f("REQUISNUMBER"));
        $this->country_id->SetDBValue(trim($this->f("country_id")));
        $this->city_id->SetDBValue(trim($this->f("city_id")));
        $this->PORT_ID->SetDBValue(trim($this->f("PORT_ID")));
        $this->AGENT_ID->SetDBValue(trim($this->f("AGENT_ID")));
        $this->AGENT_DUTY->SetDBValue($this->f("AGENT_DUTY"));
        $this->STATUS_ID->SetDBValue(trim($this->f("STATUS_ID")));
        $this->SALESNAME->SetDBValue($this->f("SALESNAME"));
        $this->DEBTORACCOUNT->SetDBValue($this->f("DEBTORACCOUNT"));
        $this->ETA_DATE_DAY->SetDBValue($this->f("ETA_DATE_DAY"));
        $this->ETA_DATE_MONTH->SetDBValue($this->f("ETA_DATE_MONTH"));
        $this->ETA_DATE_YEAR->SetDBValue($this->f("ETA_DATE_YEAR"));
        $this->ETA_HOUR->SetDBValue($this->f("ETA_HOUR"));
        $this->RETURN_REPORT_TO->SetDBValue($this->f("RETURN_REPORT_TO"));
        $this->ORDER_PARTS_FROM->SetDBValue($this->f("ORDER_PARTS_FROM"));
        $this->RETURN_PARTS_TO->SetDBValue($this->f("RETURN_PARTS_TO"));
    }
//End SetValues Method

//Insert Method @23-0ED84C89
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["ORDER_NO"]["Value"] = $this->ORDER_NO->GetDBValue(true);
        $this->InsertFields["IMO_NUMBER"]["Value"] = $this->IMO_NUMBER->GetDBValue(true);
        $this->InsertFields["REQUISNUMBER"]["Value"] = $this->REQUISNUMBER->GetDBValue(true);
        $this->InsertFields["country_id"]["Value"] = $this->country_id->GetDBValue(true);
        $this->InsertFields["city_id"]["Value"] = $this->city_id->GetDBValue(true);
        $this->InsertFields["PORT_ID"]["Value"] = $this->PORT_ID->GetDBValue(true);
        $this->InsertFields["AGENT_ID"]["Value"] = $this->AGENT_ID->GetDBValue(true);
        $this->InsertFields["AGENT_DUTY"]["Value"] = $this->AGENT_DUTY->GetDBValue(true);
        $this->InsertFields["STATUS_ID"]["Value"] = $this->STATUS_ID->GetDBValue(true);
        $this->InsertFields["SALESNAME"]["Value"] = $this->SALESNAME->GetDBValue(true);
        $this->InsertFields["DEBTORACCOUNT"]["Value"] = $this->DEBTORACCOUNT->GetDBValue(true);
        $this->InsertFields["ETA_DATE_DAY"]["Value"] = $this->ETA_DATE_DAY->GetDBValue(true);
        $this->InsertFields["ETA_DATE_MONTH"]["Value"] = $this->ETA_DATE_MONTH->GetDBValue(true);
        $this->InsertFields["ETA_DATE_YEAR"]["Value"] = $this->ETA_DATE_YEAR->GetDBValue(true);
        $this->InsertFields["ETA_HOUR"]["Value"] = $this->ETA_HOUR->GetDBValue(true);
        $this->InsertFields["RETURN_REPORT_TO"]["Value"] = $this->RETURN_REPORT_TO->GetDBValue(true);
        $this->InsertFields["ORDER_PARTS_FROM"]["Value"] = $this->ORDER_PARTS_FROM->GetDBValue(true);
        $this->InsertFields["RETURN_PARTS_TO"]["Value"] = $this->RETURN_PARTS_TO->GetDBValue(true);
        $this->SQL = CCBuildInsert("service_tbl", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

} //End service_tblDataSource Class @23-FCB6E20C

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

//Include events file @1-72C83CC4
include_once("./page2_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-3B263BD4
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Link2 = new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $MainPage);
$Link2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link2->Page = "page1.php";
$service_tbl = new clsRecordservice_tbl("", $MainPage);
$MainPage->Link2 = & $Link2;
$MainPage->service_tbl = & $service_tbl;
$service_tbl->Initialize();

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
