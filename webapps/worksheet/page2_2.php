<?php
//Include Common Files @1-6F7F8BD8
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page2_2.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
include_once(RelativePath . "/Services.php");
//End Include Common Files

class clsEditableGridagents_tbl { //agents_tbl Class @2-8E27DCF3

//Variables @2-F9538F3C

    // Public variables
    public $ComponentType = "EditableGrid";
    public $ComponentName;
    public $HTMLFormAction;
    public $PressedButton;
    public $Errors;
    public $ErrorBlock;
    public $FormSubmitted;
    public $FormParameters;
    public $FormState;
    public $FormEnctype;
    public $CachedColumns;
    public $TotalRows;
    public $UpdatedRows;
    public $EmptyRows;
    public $Visible;
    public $RowsErrors;
    public $ds;
    public $DataSource;
    public $PageSize;
    public $IsEmpty;
    public $SorterName = "";
    public $SorterDirection = "";
    public $PageNumber;
    public $ControlsVisible = array();

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";

    public $InsertAllowed = false;
    public $UpdateAllowed = false;
    public $DeleteAllowed = false;
    public $ReadAllowed   = false;
    public $EditMode;
    public $ValidatingControls;
    public $Controls;
    public $ControlsErrors;
    public $RowNumber;
    public $Attributes;
    public $PrimaryKeys;

    // Class variables
//End Variables

//Class_Initialize Event @2-8A90D6B2
    function clsEditableGridagents_tbl($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid agents_tbl/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "agents_tbl";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["AGENT_ID"][0] = "AGENT_ID";
        $this->DataSource = new clsagents_tblDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: EditableGrid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->EmptyRows = 3;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if(!$this->Visible) return;

        $CCSForm = CCGetFromGet("ccsForm", "");
        $this->FormEnctype = "application/x-www-form-urlencoded";
        $this->FormSubmitted = ($CCSForm == $this->ComponentName);
        if($this->FormSubmitted) {
            $this->FormState = CCGetFromPost("FormState", "");
            $this->SetFormState($this->FormState);
        } else {
            $this->FormState = "";
        }
        $Method = $this->FormSubmitted ? ccsPost : ccsGet;

        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->AGENT_NAME = new clsControl(ccsTextBox, "AGENT_NAME", "AGENT NAME", ccsText, "", NULL, $this);
        $this->AGENT_NAME->Required = true;
        $this->country_id = new clsControl(ccsListBox, "country_id", "Country Id", ccsInteger, "", NULL, $this);
        $this->country_id->DSType = dsTable;
        $this->country_id->DataSource = new clsDBhss_db();
        $this->country_id->ds = & $this->country_id->DataSource;
        $this->country_id->DataSource->SQL = "SELECT * \n" .
"FROM countries_tbl {SQL_Where} {SQL_OrderBy}";
        list($this->country_id->BoundColumn, $this->country_id->TextColumn, $this->country_id->DBFormat) = array("country_id", "country_name", "");
        $this->city_id = new clsControl(ccsListBox, "city_id", "city_id", ccsInteger, "", NULL, $this);
        $this->city_id->DSType = dsTable;
        $this->city_id->DataSource = new clsDBhss_db();
        $this->city_id->ds = & $this->city_id->DataSource;
        $this->city_id->DataSource->SQL = "SELECT * \n" .
"FROM cities_tbl {SQL_Where} {SQL_OrderBy}";
        $this->city_id->DataSource->Order = "city_name";
        list($this->city_id->BoundColumn, $this->city_id->TextColumn, $this->city_id->DBFormat) = array("city_id", "city_name", "");
        $this->city_id->DataSource->Order = "city_name";
        $this->AGENT_ADDRESS = new clsControl(ccsTextBox, "AGENT_ADDRESS", "AGENT ADDRESS", ccsText, "", NULL, $this);
        $this->AGENT_EMAIL = new clsControl(ccsTextBox, "AGENT_EMAIL", "AGENT EMAIL", ccsText, "", NULL, $this);
        $this->AGENT_OFFICE_PHONE_1 = new clsControl(ccsTextBox, "AGENT_OFFICE_PHONE_1", "AGENT OFFICE PHONE 1", ccsText, "", NULL, $this);
        $this->AGENT_DUTY_PHONE = new clsControl(ccsTextBox, "AGENT_DUTY_PHONE", "AGENT DUTY PHONE", ccsText, "", NULL, $this);
        $this->AGENT_OFFICE_PHONE_2 = new clsControl(ccsTextBox, "AGENT_OFFICE_PHONE_2", "AGENT OFFICE PHONE 2", ccsText, "", NULL, $this);
        $this->AGENT_FAX = new clsControl(ccsTextBox, "AGENT_FAX", "AGENT FAX", ccsText, "", NULL, $this);
    }
//End Class_Initialize Event

//Initialize Method @2-1B2BE0CD
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urls_country_id"] = CCGetFromGet("s_country_id", NULL);
        $this->DataSource->Parameters["urls_AGENT_NAME"] = CCGetFromGet("s_AGENT_NAME", NULL);
    }
//End Initialize Method

//SetPrimaryKeys Method @2-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @2-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @2-9161D578
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["AGENT_NAME"][$RowNumber] = CCGetFromPost("AGENT_NAME_" . $RowNumber, NULL);
            $this->FormParameters["country_id"][$RowNumber] = CCGetFromPost("country_id_" . $RowNumber, NULL);
            $this->FormParameters["city_id"][$RowNumber] = CCGetFromPost("city_id_" . $RowNumber, NULL);
            $this->FormParameters["AGENT_ADDRESS"][$RowNumber] = CCGetFromPost("AGENT_ADDRESS_" . $RowNumber, NULL);
            $this->FormParameters["AGENT_EMAIL"][$RowNumber] = CCGetFromPost("AGENT_EMAIL_" . $RowNumber, NULL);
            $this->FormParameters["AGENT_OFFICE_PHONE_1"][$RowNumber] = CCGetFromPost("AGENT_OFFICE_PHONE_1_" . $RowNumber, NULL);
            $this->FormParameters["AGENT_DUTY_PHONE"][$RowNumber] = CCGetFromPost("AGENT_DUTY_PHONE_" . $RowNumber, NULL);
            $this->FormParameters["AGENT_OFFICE_PHONE_2"][$RowNumber] = CCGetFromPost("AGENT_OFFICE_PHONE_2_" . $RowNumber, NULL);
            $this->FormParameters["AGENT_FAX"][$RowNumber] = CCGetFromPost("AGENT_FAX_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @2-EB526789
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["AGENT_ID"] = $this->CachedColumns["AGENT_ID"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->AGENT_NAME->SetText($this->FormParameters["AGENT_NAME"][$this->RowNumber], $this->RowNumber);
            $this->country_id->SetText($this->FormParameters["country_id"][$this->RowNumber], $this->RowNumber);
            $this->city_id->SetText($this->FormParameters["city_id"][$this->RowNumber], $this->RowNumber);
            $this->AGENT_ADDRESS->SetText($this->FormParameters["AGENT_ADDRESS"][$this->RowNumber], $this->RowNumber);
            $this->AGENT_EMAIL->SetText($this->FormParameters["AGENT_EMAIL"][$this->RowNumber], $this->RowNumber);
            $this->AGENT_OFFICE_PHONE_1->SetText($this->FormParameters["AGENT_OFFICE_PHONE_1"][$this->RowNumber], $this->RowNumber);
            $this->AGENT_DUTY_PHONE->SetText($this->FormParameters["AGENT_DUTY_PHONE"][$this->RowNumber], $this->RowNumber);
            $this->AGENT_OFFICE_PHONE_2->SetText($this->FormParameters["AGENT_OFFICE_PHONE_2"][$this->RowNumber], $this->RowNumber);
            $this->AGENT_FAX->SetText($this->FormParameters["AGENT_FAX"][$this->RowNumber], $this->RowNumber);
            if ($this->UpdatedRows >= $this->RowNumber) {
                $Validation = ($this->ValidateRow($this->RowNumber) && $Validation);
            }
            else if($this->CheckInsert())
            {
                $Validation = ($this->ValidateRow() && $Validation);
            }
        }
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//ValidateRow Method @2-CE1E3A1D
    function ValidateRow()
    {
        global $CCSLocales;
        $this->AGENT_NAME->Validate();
        $this->country_id->Validate();
        $this->city_id->Validate();
        $this->AGENT_ADDRESS->Validate();
        $this->AGENT_EMAIL->Validate();
        $this->AGENT_OFFICE_PHONE_1->Validate();
        $this->AGENT_DUTY_PHONE->Validate();
        $this->AGENT_OFFICE_PHONE_2->Validate();
        $this->AGENT_FAX->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->AGENT_NAME->Errors->ToString());
        $errors = ComposeStrings($errors, $this->country_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->city_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->AGENT_ADDRESS->Errors->ToString());
        $errors = ComposeStrings($errors, $this->AGENT_EMAIL->Errors->ToString());
        $errors = ComposeStrings($errors, $this->AGENT_OFFICE_PHONE_1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->AGENT_DUTY_PHONE->Errors->ToString());
        $errors = ComposeStrings($errors, $this->AGENT_OFFICE_PHONE_2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->AGENT_FAX->Errors->ToString());
        $this->AGENT_NAME->Errors->Clear();
        $this->country_id->Errors->Clear();
        $this->city_id->Errors->Clear();
        $this->AGENT_ADDRESS->Errors->Clear();
        $this->AGENT_EMAIL->Errors->Clear();
        $this->AGENT_OFFICE_PHONE_1->Errors->Clear();
        $this->AGENT_DUTY_PHONE->Errors->Clear();
        $this->AGENT_OFFICE_PHONE_2->Errors->Clear();
        $this->AGENT_FAX->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @2-058BC4F5
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["AGENT_NAME"][$this->RowNumber]) && count($this->FormParameters["AGENT_NAME"][$this->RowNumber])) || strlen($this->FormParameters["AGENT_NAME"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["country_id"][$this->RowNumber]) && count($this->FormParameters["country_id"][$this->RowNumber])) || strlen($this->FormParameters["country_id"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["city_id"][$this->RowNumber]) && count($this->FormParameters["city_id"][$this->RowNumber])) || strlen($this->FormParameters["city_id"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["AGENT_ADDRESS"][$this->RowNumber]) && count($this->FormParameters["AGENT_ADDRESS"][$this->RowNumber])) || strlen($this->FormParameters["AGENT_ADDRESS"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["AGENT_EMAIL"][$this->RowNumber]) && count($this->FormParameters["AGENT_EMAIL"][$this->RowNumber])) || strlen($this->FormParameters["AGENT_EMAIL"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["AGENT_OFFICE_PHONE_1"][$this->RowNumber]) && count($this->FormParameters["AGENT_OFFICE_PHONE_1"][$this->RowNumber])) || strlen($this->FormParameters["AGENT_OFFICE_PHONE_1"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["AGENT_DUTY_PHONE"][$this->RowNumber]) && count($this->FormParameters["AGENT_DUTY_PHONE"][$this->RowNumber])) || strlen($this->FormParameters["AGENT_DUTY_PHONE"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["AGENT_OFFICE_PHONE_2"][$this->RowNumber]) && count($this->FormParameters["AGENT_OFFICE_PHONE_2"][$this->RowNumber])) || strlen($this->FormParameters["AGENT_OFFICE_PHONE_2"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["AGENT_FAX"][$this->RowNumber]) && count($this->FormParameters["AGENT_FAX"][$this->RowNumber])) || strlen($this->FormParameters["AGENT_FAX"][$this->RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @2-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @2-909F269B
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted)
            return;

        $this->GetFormParameters();
        $this->PressedButton = "Button_Submit";
        if($this->Button_Submit->Pressed) {
            $this->PressedButton = "Button_Submit";
        }

        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Submit") {
            if(!CCGetEvent($this->Button_Submit->CCSEvents, "OnClick", $this->Button_Submit) || !$this->UpdateGrid()) {
                $Redirect = "";
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateGrid Method @2-0D929CCD
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["AGENT_ID"] = $this->CachedColumns["AGENT_ID"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->AGENT_NAME->SetText($this->FormParameters["AGENT_NAME"][$this->RowNumber], $this->RowNumber);
            $this->country_id->SetText($this->FormParameters["country_id"][$this->RowNumber], $this->RowNumber);
            $this->city_id->SetText($this->FormParameters["city_id"][$this->RowNumber], $this->RowNumber);
            $this->AGENT_ADDRESS->SetText($this->FormParameters["AGENT_ADDRESS"][$this->RowNumber], $this->RowNumber);
            $this->AGENT_EMAIL->SetText($this->FormParameters["AGENT_EMAIL"][$this->RowNumber], $this->RowNumber);
            $this->AGENT_OFFICE_PHONE_1->SetText($this->FormParameters["AGENT_OFFICE_PHONE_1"][$this->RowNumber], $this->RowNumber);
            $this->AGENT_DUTY_PHONE->SetText($this->FormParameters["AGENT_DUTY_PHONE"][$this->RowNumber], $this->RowNumber);
            $this->AGENT_OFFICE_PHONE_2->SetText($this->FormParameters["AGENT_OFFICE_PHONE_2"][$this->RowNumber], $this->RowNumber);
            $this->AGENT_FAX->SetText($this->FormParameters["AGENT_FAX"][$this->RowNumber], $this->RowNumber);
            if ($this->UpdatedRows >= $this->RowNumber) {
                if($this->UpdateAllowed) { $Validation = ($this->UpdateRow() && $Validation); }
            }
            else if($this->CheckInsert() && $this->InsertAllowed)
            {
                $Validation = ($Validation && $this->InsertRow());
            }
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterSubmit", $this);
        if ($this->Errors->Count() == 0 && $Validation){
            $this->DataSource->close();
            return true;
        }
        return false;
    }
//End UpdateGrid Method

//InsertRow Method @2-5D623E5D
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->AGENT_NAME->SetValue($this->AGENT_NAME->GetValue(true));
        $this->DataSource->country_id->SetValue($this->country_id->GetValue(true));
        $this->DataSource->city_id->SetValue($this->city_id->GetValue(true));
        $this->DataSource->AGENT_ADDRESS->SetValue($this->AGENT_ADDRESS->GetValue(true));
        $this->DataSource->AGENT_EMAIL->SetValue($this->AGENT_EMAIL->GetValue(true));
        $this->DataSource->AGENT_OFFICE_PHONE_1->SetValue($this->AGENT_OFFICE_PHONE_1->GetValue(true));
        $this->DataSource->AGENT_DUTY_PHONE->SetValue($this->AGENT_DUTY_PHONE->GetValue(true));
        $this->DataSource->AGENT_OFFICE_PHONE_2->SetValue($this->AGENT_OFFICE_PHONE_2->GetValue(true));
        $this->DataSource->AGENT_FAX->SetValue($this->AGENT_FAX->GetValue(true));
        $this->DataSource->Insert();
        $errors = "";
        if($this->DataSource->Errors->Count() > 0) {
            $errors = $this->DataSource->Errors->ToString();
            $this->RowsErrors[$this->RowNumber] = $errors;
            $this->DataSource->Errors->Clear();
        }
        return (($this->Errors->Count() == 0) && !strlen($errors));
    }
//End InsertRow Method

//UpdateRow Method @2-24AE081A
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->AGENT_NAME->SetValue($this->AGENT_NAME->GetValue(true));
        $this->DataSource->country_id->SetValue($this->country_id->GetValue(true));
        $this->DataSource->city_id->SetValue($this->city_id->GetValue(true));
        $this->DataSource->AGENT_ADDRESS->SetValue($this->AGENT_ADDRESS->GetValue(true));
        $this->DataSource->AGENT_EMAIL->SetValue($this->AGENT_EMAIL->GetValue(true));
        $this->DataSource->AGENT_OFFICE_PHONE_1->SetValue($this->AGENT_OFFICE_PHONE_1->GetValue(true));
        $this->DataSource->AGENT_DUTY_PHONE->SetValue($this->AGENT_DUTY_PHONE->GetValue(true));
        $this->DataSource->AGENT_OFFICE_PHONE_2->SetValue($this->AGENT_OFFICE_PHONE_2->GetValue(true));
        $this->DataSource->AGENT_FAX->SetValue($this->AGENT_FAX->GetValue(true));
        $this->DataSource->Update();
        $errors = "";
        if($this->DataSource->Errors->Count() > 0) {
            $errors = $this->DataSource->Errors->ToString();
            $this->RowsErrors[$this->RowNumber] = $errors;
            $this->DataSource->Errors->Clear();
        }
        return (($this->Errors->Count() == 0) && !strlen($errors));
    }
//End UpdateRow Method

//DeleteRow Method @2-A4A656F6
    function DeleteRow()
    {
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $errors = "";
        if($this->DataSource->Errors->Count() > 0) {
            $errors = $this->DataSource->Errors->ToString();
            $this->RowsErrors[$this->RowNumber] = $errors;
            $this->DataSource->Errors->Clear();
        }
        return (($this->Errors->Count() == 0) && !strlen($errors));
    }
//End DeleteRow Method

//FormScript Method @2-536F7AD7
    function FormScript($TotalRows)
    {
        $script = "";
        $script .= "\n<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n";
        $script .= "var agents_tblElements;\n";
        $script .= "var agents_tblEmptyRows = 3;\n";
        $script .= "var " . $this->ComponentName . "AGENT_NAMEID = 0;\n";
        $script .= "var " . $this->ComponentName . "country_idID = 1;\n";
        $script .= "var " . $this->ComponentName . "city_idID = 2;\n";
        $script .= "var " . $this->ComponentName . "AGENT_ADDRESSID = 3;\n";
        $script .= "var " . $this->ComponentName . "AGENT_EMAILID = 4;\n";
        $script .= "var " . $this->ComponentName . "AGENT_OFFICE_PHONE_1ID = 5;\n";
        $script .= "var " . $this->ComponentName . "AGENT_DUTY_PHONEID = 6;\n";
        $script .= "var " . $this->ComponentName . "AGENT_OFFICE_PHONE_2ID = 7;\n";
        $script .= "var " . $this->ComponentName . "AGENT_FAXID = 8;\n";
        $script .= "\nfunction initagents_tblElements() {\n";
        $script .= "\tvar ED = document.forms[\"agents_tbl\"];\n";
        $script .= "\tagents_tblElements = new Array (\n";
        for($i = 1; $i <= $TotalRows; $i++) {
            $script .= "\t\tnew Array(" . "ED.AGENT_NAME_" . $i . ", " . "ED.country_id_" . $i . ", " . "ED.city_id_" . $i . ", " . "ED.AGENT_ADDRESS_" . $i . ", " . "ED.AGENT_EMAIL_" . $i . ", " . "ED.AGENT_OFFICE_PHONE_1_" . $i . ", " . "ED.AGENT_DUTY_PHONE_" . $i . ", " . "ED.AGENT_OFFICE_PHONE_2_" . $i . ", " . "ED.AGENT_FAX_" . $i . ")";
            if($i != $TotalRows) $script .= ",\n";
        }
        $script .= ");\n";
        $script .= "}\n";
        $script .= "\n//-->\n</script>";
        return $script;
    }
//End FormScript Method

//SetFormState Method @2-2B60D2B6
    function SetFormState($FormState)
    {
        if(strlen($FormState)) {
            $FormState = str_replace("\\\\", "\\" . ord("\\"), $FormState);
            $FormState = str_replace("\\;", "\\" . ord(";"), $FormState);
            $pieces = explode(";", $FormState);
            $this->UpdatedRows = $pieces[0];
            $this->EmptyRows   = $pieces[1];
            $this->TotalRows = $this->UpdatedRows + $this->EmptyRows;
            $RowNumber = 0;
            for($i = 2; $i < sizeof($pieces); $i = $i + 1)  {
                $piece = $pieces[$i + 0];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["AGENT_ID"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["AGENT_ID"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @2-192CBE21
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["AGENT_ID"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @2-DC2BB30E
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->country_id->Prepare();
        $this->city_id->Prepare();

        $this->DataSource->open();
        $is_next_record = ($this->ReadAllowed && $this->DataSource->next_record());
        $this->IsEmpty = ! $is_next_record;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) { return; }

        $this->Attributes->Show();
        $this->Button_Submit->Visible = $this->Button_Submit->Visible && ($this->InsertAllowed || $this->UpdateAllowed || $this->DeleteAllowed);
        $ParentPath = $Tpl->block_path;
        $EditableGridPath = $ParentPath . "/EditableGrid " . $this->ComponentName;
        $EditableGridRowPath = $ParentPath . "/EditableGrid " . $this->ComponentName . "/Row";
        $Tpl->block_path = $EditableGridRowPath;
        $this->RowNumber = 0;
        $NonEmptyRows = 0;
        $EmptyRowsLeft = $this->EmptyRows;
        $this->ControlsVisible["AGENT_NAME"] = $this->AGENT_NAME->Visible;
        $this->ControlsVisible["country_id"] = $this->country_id->Visible;
        $this->ControlsVisible["city_id"] = $this->city_id->Visible;
        $this->ControlsVisible["AGENT_ADDRESS"] = $this->AGENT_ADDRESS->Visible;
        $this->ControlsVisible["AGENT_EMAIL"] = $this->AGENT_EMAIL->Visible;
        $this->ControlsVisible["AGENT_OFFICE_PHONE_1"] = $this->AGENT_OFFICE_PHONE_1->Visible;
        $this->ControlsVisible["AGENT_DUTY_PHONE"] = $this->AGENT_DUTY_PHONE->Visible;
        $this->ControlsVisible["AGENT_OFFICE_PHONE_2"] = $this->AGENT_OFFICE_PHONE_2->Visible;
        $this->ControlsVisible["AGENT_FAX"] = $this->AGENT_FAX->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["AGENT_ID"][$this->RowNumber] = $this->DataSource->CachedColumns["AGENT_ID"];
                    $this->AGENT_NAME->SetValue($this->DataSource->AGENT_NAME->GetValue());
                    $this->country_id->SetValue($this->DataSource->country_id->GetValue());
                    $this->city_id->SetValue($this->DataSource->city_id->GetValue());
                    $this->AGENT_ADDRESS->SetValue($this->DataSource->AGENT_ADDRESS->GetValue());
                    $this->AGENT_EMAIL->SetValue($this->DataSource->AGENT_EMAIL->GetValue());
                    $this->AGENT_OFFICE_PHONE_1->SetValue($this->DataSource->AGENT_OFFICE_PHONE_1->GetValue());
                    $this->AGENT_DUTY_PHONE->SetValue($this->DataSource->AGENT_DUTY_PHONE->GetValue());
                    $this->AGENT_OFFICE_PHONE_2->SetValue($this->DataSource->AGENT_OFFICE_PHONE_2->GetValue());
                    $this->AGENT_FAX->SetValue($this->DataSource->AGENT_FAX->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->AGENT_NAME->SetText($this->FormParameters["AGENT_NAME"][$this->RowNumber], $this->RowNumber);
                    $this->country_id->SetText($this->FormParameters["country_id"][$this->RowNumber], $this->RowNumber);
                    $this->city_id->SetText($this->FormParameters["city_id"][$this->RowNumber], $this->RowNumber);
                    $this->AGENT_ADDRESS->SetText($this->FormParameters["AGENT_ADDRESS"][$this->RowNumber], $this->RowNumber);
                    $this->AGENT_EMAIL->SetText($this->FormParameters["AGENT_EMAIL"][$this->RowNumber], $this->RowNumber);
                    $this->AGENT_OFFICE_PHONE_1->SetText($this->FormParameters["AGENT_OFFICE_PHONE_1"][$this->RowNumber], $this->RowNumber);
                    $this->AGENT_DUTY_PHONE->SetText($this->FormParameters["AGENT_DUTY_PHONE"][$this->RowNumber], $this->RowNumber);
                    $this->AGENT_OFFICE_PHONE_2->SetText($this->FormParameters["AGENT_OFFICE_PHONE_2"][$this->RowNumber], $this->RowNumber);
                    $this->AGENT_FAX->SetText($this->FormParameters["AGENT_FAX"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["AGENT_ID"][$this->RowNumber] = "";
                    $this->AGENT_NAME->SetText("");
                    $this->country_id->SetText("");
                    $this->city_id->SetText("");
                    $this->AGENT_ADDRESS->SetText("");
                    $this->AGENT_EMAIL->SetText("");
                    $this->AGENT_OFFICE_PHONE_1->SetText("");
                    $this->AGENT_DUTY_PHONE->SetText("");
                    $this->AGENT_OFFICE_PHONE_2->SetText("");
                    $this->AGENT_FAX->SetText("");
                } else {
                    $this->AGENT_NAME->SetText($this->FormParameters["AGENT_NAME"][$this->RowNumber], $this->RowNumber);
                    $this->country_id->SetText($this->FormParameters["country_id"][$this->RowNumber], $this->RowNumber);
                    $this->city_id->SetText($this->FormParameters["city_id"][$this->RowNumber], $this->RowNumber);
                    $this->AGENT_ADDRESS->SetText($this->FormParameters["AGENT_ADDRESS"][$this->RowNumber], $this->RowNumber);
                    $this->AGENT_EMAIL->SetText($this->FormParameters["AGENT_EMAIL"][$this->RowNumber], $this->RowNumber);
                    $this->AGENT_OFFICE_PHONE_1->SetText($this->FormParameters["AGENT_OFFICE_PHONE_1"][$this->RowNumber], $this->RowNumber);
                    $this->AGENT_DUTY_PHONE->SetText($this->FormParameters["AGENT_DUTY_PHONE"][$this->RowNumber], $this->RowNumber);
                    $this->AGENT_OFFICE_PHONE_2->SetText($this->FormParameters["AGENT_OFFICE_PHONE_2"][$this->RowNumber], $this->RowNumber);
                    $this->AGENT_FAX->SetText($this->FormParameters["AGENT_FAX"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->AGENT_NAME->Show($this->RowNumber);
                $this->country_id->Show($this->RowNumber);
                $this->city_id->Show($this->RowNumber);
                $this->AGENT_ADDRESS->Show($this->RowNumber);
                $this->AGENT_EMAIL->Show($this->RowNumber);
                $this->AGENT_OFFICE_PHONE_1->Show($this->RowNumber);
                $this->AGENT_DUTY_PHONE->Show($this->RowNumber);
                $this->AGENT_OFFICE_PHONE_2->Show($this->RowNumber);
                $this->AGENT_FAX->Show($this->RowNumber);
                if (isset($this->RowsErrors[$this->RowNumber]) && ($this->RowsErrors[$this->RowNumber] != "")) {
                    $Tpl->setblockvar("RowError", "");
                    $Tpl->setvar("Error", $this->RowsErrors[$this->RowNumber]);
                    $this->Attributes->Show();
                    $Tpl->parse("RowError", false);
                } else {
                    $Tpl->setblockvar("RowError", "");
                }
                $Tpl->setvar("FormScript", $this->FormScript($this->RowNumber));
                $Tpl->parse();
                if ($is_next_record) {
                    if ($this->FormSubmitted) {
                        $is_next_record = $this->RowNumber < $this->UpdatedRows;
                        if (($this->DataSource->CachedColumns["AGENT_ID"] == $this->CachedColumns["AGENT_ID"][$this->RowNumber])) {
                            if ($this->ReadAllowed) $this->DataSource->next_record();
                        }
                    }else{
                        $is_next_record = ($this->RowNumber < $this->PageSize) &&  $this->ReadAllowed && $this->DataSource->next_record();
                    }
                } else { 
                    $EmptyRowsLeft--;
                }
            } while($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed));
        } else {
            $Tpl->block_path = $EditableGridPath;
            $this->Attributes->Show();
            $Tpl->parse("NoRecords", false);
        }

        $Tpl->block_path = $EditableGridPath;
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
        $this->Button_Submit->Show();

        if($this->CheckErrors()) {
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
        if (!$CCSUseAmp) {
            $Tpl->SetVar("HTMLFormProperties", "method=\"POST\" action=\"" . $this->HTMLFormAction . "\" name=\"" . $this->ComponentName . "\"");
        } else {
            $Tpl->SetVar("HTMLFormProperties", "method=\"post\" action=\"" . str_replace("&", "&amp;", $this->HTMLFormAction) . "\" id=\"" . $this->ComponentName . "\"");
        }
        $Tpl->SetVar("FormState", CCToHTML($this->GetFormState($NonEmptyRows)));
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End agents_tbl Class @2-FCB6E20C

class clsagents_tblDataSource extends clsDBhss_db {  //agents_tblDataSource Class @2-F14097E7

//DataSource Variables @2-B17CFDE7
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $DeleteParameters;
    public $CountSQL;
    public $wp;
    public $AllParametersSet;

    public $CachedColumns;
    public $CurrentRow;
    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $AGENT_NAME;
    public $country_id;
    public $city_id;
    public $AGENT_ADDRESS;
    public $AGENT_EMAIL;
    public $AGENT_OFFICE_PHONE_1;
    public $AGENT_DUTY_PHONE;
    public $AGENT_OFFICE_PHONE_2;
    public $AGENT_FAX;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-BE581B7D
    function clsagents_tblDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid agents_tbl/Error";
        $this->Initialize();
        $this->AGENT_NAME = new clsField("AGENT_NAME", ccsText, "");
        
        $this->country_id = new clsField("country_id", ccsInteger, "");
        
        $this->city_id = new clsField("city_id", ccsInteger, "");
        
        $this->AGENT_ADDRESS = new clsField("AGENT_ADDRESS", ccsText, "");
        
        $this->AGENT_EMAIL = new clsField("AGENT_EMAIL", ccsText, "");
        
        $this->AGENT_OFFICE_PHONE_1 = new clsField("AGENT_OFFICE_PHONE_1", ccsText, "");
        
        $this->AGENT_DUTY_PHONE = new clsField("AGENT_DUTY_PHONE", ccsText, "");
        
        $this->AGENT_OFFICE_PHONE_2 = new clsField("AGENT_OFFICE_PHONE_2", ccsText, "");
        
        $this->AGENT_FAX = new clsField("AGENT_FAX", ccsText, "");
        

        $this->InsertFields["AGENT_NAME"] = array("Name" => "AGENT_NAME", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["country_id"] = array("Name" => "country_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["city_id"] = array("Name" => "city_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["AGENT_ADDRESS"] = array("Name" => "AGENT_ADDRESS", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["AGENT_EMAIL"] = array("Name" => "AGENT_EMAIL", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["AGENT_OFFICE_PHONE_1"] = array("Name" => "AGENT_OFFICE_PHONE_1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["AGENT_DUTY_PHONE"] = array("Name" => "AGENT_DUTY_PHONE", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["AGENT_OFFICE_PHONE_2"] = array("Name" => "AGENT_OFFICE_PHONE_2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["AGENT_FAX"] = array("Name" => "AGENT_FAX", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["AGENT_NAME"] = array("Name" => "AGENT_NAME", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["country_id"] = array("Name" => "country_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["city_id"] = array("Name" => "city_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["AGENT_ADDRESS"] = array("Name" => "AGENT_ADDRESS", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["AGENT_EMAIL"] = array("Name" => "AGENT_EMAIL", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["AGENT_OFFICE_PHONE_1"] = array("Name" => "AGENT_OFFICE_PHONE_1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["AGENT_DUTY_PHONE"] = array("Name" => "AGENT_DUTY_PHONE", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["AGENT_OFFICE_PHONE_2"] = array("Name" => "AGENT_OFFICE_PHONE_2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["AGENT_FAX"] = array("Name" => "AGENT_FAX", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-0525FB8F
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "country_id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-0EA32545
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_country_id", ccsInteger, "", "", $this->Parameters["urls_country_id"], "", false);
        $this->wp->AddParameter("2", "urls_AGENT_NAME", ccsText, "", "", $this->Parameters["urls_AGENT_NAME"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "country_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "AGENT_NAME", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @2-377CA4CD
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM agents_tbl";
        $this->SQL = "SELECT * \n\n" .
        "FROM agents_tbl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-1BE026AA
    function SetValues()
    {
        $this->CachedColumns["AGENT_ID"] = $this->f("AGENT_ID");
        $this->AGENT_NAME->SetDBValue($this->f("AGENT_NAME"));
        $this->country_id->SetDBValue(trim($this->f("country_id")));
        $this->city_id->SetDBValue(trim($this->f("city_id")));
        $this->AGENT_ADDRESS->SetDBValue($this->f("AGENT_ADDRESS"));
        $this->AGENT_EMAIL->SetDBValue($this->f("AGENT_EMAIL"));
        $this->AGENT_OFFICE_PHONE_1->SetDBValue($this->f("AGENT_OFFICE_PHONE_1"));
        $this->AGENT_DUTY_PHONE->SetDBValue($this->f("AGENT_DUTY_PHONE"));
        $this->AGENT_OFFICE_PHONE_2->SetDBValue($this->f("AGENT_OFFICE_PHONE_2"));
        $this->AGENT_FAX->SetDBValue($this->f("AGENT_FAX"));
    }
//End SetValues Method

//Insert Method @2-1118AE7B
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["AGENT_NAME"]["Value"] = $this->AGENT_NAME->GetDBValue(true);
        $this->InsertFields["country_id"]["Value"] = $this->country_id->GetDBValue(true);
        $this->InsertFields["city_id"]["Value"] = $this->city_id->GetDBValue(true);
        $this->InsertFields["AGENT_ADDRESS"]["Value"] = $this->AGENT_ADDRESS->GetDBValue(true);
        $this->InsertFields["AGENT_EMAIL"]["Value"] = $this->AGENT_EMAIL->GetDBValue(true);
        $this->InsertFields["AGENT_OFFICE_PHONE_1"]["Value"] = $this->AGENT_OFFICE_PHONE_1->GetDBValue(true);
        $this->InsertFields["AGENT_DUTY_PHONE"]["Value"] = $this->AGENT_DUTY_PHONE->GetDBValue(true);
        $this->InsertFields["AGENT_OFFICE_PHONE_2"]["Value"] = $this->AGENT_OFFICE_PHONE_2->GetDBValue(true);
        $this->InsertFields["AGENT_FAX"]["Value"] = $this->AGENT_FAX->GetDBValue(true);
        $this->SQL = CCBuildInsert("agents_tbl", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-02F1FE89
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "AGENT_ID=" . $this->ToSQL($this->CachedColumns["AGENT_ID"], ccsInteger);
        $this->UpdateFields["AGENT_NAME"]["Value"] = $this->AGENT_NAME->GetDBValue(true);
        $this->UpdateFields["country_id"]["Value"] = $this->country_id->GetDBValue(true);
        $this->UpdateFields["city_id"]["Value"] = $this->city_id->GetDBValue(true);
        $this->UpdateFields["AGENT_ADDRESS"]["Value"] = $this->AGENT_ADDRESS->GetDBValue(true);
        $this->UpdateFields["AGENT_EMAIL"]["Value"] = $this->AGENT_EMAIL->GetDBValue(true);
        $this->UpdateFields["AGENT_OFFICE_PHONE_1"]["Value"] = $this->AGENT_OFFICE_PHONE_1->GetDBValue(true);
        $this->UpdateFields["AGENT_DUTY_PHONE"]["Value"] = $this->AGENT_DUTY_PHONE->GetDBValue(true);
        $this->UpdateFields["AGENT_OFFICE_PHONE_2"]["Value"] = $this->AGENT_OFFICE_PHONE_2->GetDBValue(true);
        $this->UpdateFields["AGENT_FAX"]["Value"] = $this->AGENT_FAX->GetDBValue(true);
        $this->SQL = CCBuildUpdate("agents_tbl", $this->UpdateFields, $this);
        $this->SQL .= strlen($this->Where) ? " WHERE " . $this->Where : $this->Where;
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
        $this->Where = $SelectWhere;
    }
//End Update Method

//Delete Method @2-FA128C5A
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "AGENT_ID=" . $this->ToSQL($this->CachedColumns["AGENT_ID"], ccsInteger);
        $this->SQL = "DELETE FROM agents_tbl";
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
        $this->Where = $SelectWhere;
    }
//End Delete Method

} //End agents_tblDataSource Class @2-FCB6E20C



class clsRecordagents_tbl1 { //agents_tbl1 Class @24-679FAC11

//Variables @24-9E315808

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

//Class_Initialize Event @24-15547699
    function clsRecordagents_tbl1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record agents_tbl1/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "agents_tbl1";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_country_id = new clsControl(ccsListBox, "s_country_id", "s_country_id", ccsInteger, "", CCGetRequestParam("s_country_id", $Method, NULL), $this);
            $this->s_country_id->DSType = dsTable;
            $this->s_country_id->DataSource = new clsDBhss_db();
            $this->s_country_id->ds = & $this->s_country_id->DataSource;
            $this->s_country_id->DataSource->SQL = "SELECT * \n" .
"FROM countries_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->s_country_id->BoundColumn, $this->s_country_id->TextColumn, $this->s_country_id->DBFormat) = array("country_id", "country_name", "");
            $this->s_AGENT_NAME = new clsControl(ccsTextBox, "s_AGENT_NAME", "s_AGENT_NAME", ccsText, "", CCGetRequestParam("s_AGENT_NAME", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->s_country_id->Value) && !strlen($this->s_country_id->Value) && $this->s_country_id->Value !== false)
                    $this->s_country_id->SetText(186);
            }
        }
    }
//End Class_Initialize Event

//Validate Method @24-893102D7
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_country_id->Validate() && $Validation);
        $Validation = ($this->s_AGENT_NAME->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_country_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_AGENT_NAME->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @24-14728A71
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_country_id->Errors->Count());
        $errors = ($errors || $this->s_AGENT_NAME->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @24-ED598703
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

//Operation Method @24-125B03F5
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
        $Redirect = "page2_2.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "page2_2.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @24-98E2524B
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

        $this->s_country_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_country_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_AGENT_NAME->Errors->ToString());
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
        $this->s_country_id->Show();
        $this->s_AGENT_NAME->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End agents_tbl1 Class @24-FCB6E20C





//Initialize Page @1-1D72DE85
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
$TemplateFileName = "page2_2.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-0C628AA3
include_once("./page2_2_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-2D19F6AE
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$agents_tbl = new clsEditableGridagents_tbl("", $MainPage);
$agents_tbl1 = new clsRecordagents_tbl1("", $MainPage);
$MainPage->agents_tbl = & $agents_tbl;
$MainPage->agents_tbl1 = & $agents_tbl1;
$agents_tbl->Initialize();

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

//Execute Components @1-E7A52D56
$agents_tbl->Operation();
$agents_tbl1->Operation();
//End Execute Components

//Go to destination page @1-A954C637
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($agents_tbl);
    unset($agents_tbl1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-5BE3708F
$agents_tbl->Show();
$agents_tbl1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-08FBA1C7
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($agents_tbl);
unset($agents_tbl1);
unset($Tpl);
//End Unload Page


?>
