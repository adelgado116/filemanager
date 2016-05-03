<?php
//Include Common Files @1-BA195649
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page2_1.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsEditableGridports_tbl1 { //ports_tbl1 Class @13-A47366D1

//Variables @13-F9538F3C

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

//Class_Initialize Event @13-658A2E14
    function clsEditableGridports_tbl1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid ports_tbl1/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "ports_tbl1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["PORT_ID"][0] = "PORT_ID";
        $this->DataSource = new clsports_tbl1DataSource($this);
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

        $this->country_id = new clsControl(ccsListBox, "country_id", "Country Id", ccsInteger, "", NULL, $this);
        $this->country_id->DSType = dsTable;
        $this->country_id->DataSource = new clsDBhss_db();
        $this->country_id->ds = & $this->country_id->DataSource;
        $this->country_id->DataSource->SQL = "SELECT * \n" .
"FROM countries_tbl {SQL_Where} {SQL_OrderBy}";
        list($this->country_id->BoundColumn, $this->country_id->TextColumn, $this->country_id->DBFormat) = array("country_id", "country_name", "");
        $this->country_id->Required = true;
        $this->PORT_NAME = new clsControl(ccsTextBox, "PORT_NAME", "PORT NAME", ccsText, "", NULL, $this);
        $this->PORT_NAME->Required = true;
        $this->CheckBox_Delete_Panel = new clsPanel("CheckBox_Delete_Panel", $this);
        $this->CheckBox_Delete = new clsControl(ccsCheckBox, "CheckBox_Delete", "CheckBox_Delete", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->CheckBox_Delete->CheckedValue = true;
        $this->CheckBox_Delete->UncheckedValue = false;
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->city_id = new clsControl(ccsListBox, "city_id", "city_id", ccsInteger, "", NULL, $this);
        $this->city_id->DSType = dsTable;
        $this->city_id->DataSource = new clsDBhss_db();
        $this->city_id->ds = & $this->city_id->DataSource;
        $this->city_id->DataSource->SQL = "SELECT * \n" .
"FROM cities_tbl {SQL_Where} {SQL_OrderBy}";
        list($this->city_id->BoundColumn, $this->city_id->TextColumn, $this->city_id->DBFormat) = array("city_id", "city_name", "");
        $this->city_id->Required = true;
        $this->PORT_FEE_ID = new clsControl(ccsListBox, "PORT_FEE_ID", "PORT_FEE_ID", ccsInteger, "", NULL, $this);
        $this->PORT_FEE_ID->DSType = dsTable;
        $this->PORT_FEE_ID->DataSource = new clsDBhss_db();
        $this->PORT_FEE_ID->ds = & $this->PORT_FEE_ID->DataSource;
        $this->PORT_FEE_ID->DataSource->SQL = "SELECT * \n" .
"FROM port_fees_tbl {SQL_Where} {SQL_OrderBy}";
        list($this->PORT_FEE_ID->BoundColumn, $this->PORT_FEE_ID->TextColumn, $this->PORT_FEE_ID->DBFormat) = array("PORT_FEE_ID", "PORT_FEE_VALUE", "");
        $this->CheckBox_Delete_Panel->AddComponent("CheckBox_Delete", $this->CheckBox_Delete);
    }
//End Class_Initialize Event

//Initialize Method @13-09E597F7
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urls_country_id"] = CCGetFromGet("s_country_id", NULL);
        $this->DataSource->Parameters["urls_PORT_NAME"] = CCGetFromGet("s_PORT_NAME", NULL);
    }
//End Initialize Method

//SetPrimaryKeys Method @13-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @13-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @13-01018F3D
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["country_id"][$RowNumber] = CCGetFromPost("country_id_" . $RowNumber, NULL);
            $this->FormParameters["PORT_NAME"][$RowNumber] = CCGetFromPost("PORT_NAME_" . $RowNumber, NULL);
            $this->FormParameters["city_id"][$RowNumber] = CCGetFromPost("city_id_" . $RowNumber, NULL);
            $this->FormParameters["PORT_FEE_ID"][$RowNumber] = CCGetFromPost("PORT_FEE_ID_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @13-54AEECDC
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["PORT_ID"] = $this->CachedColumns["PORT_ID"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->country_id->SetText($this->FormParameters["country_id"][$this->RowNumber], $this->RowNumber);
            $this->PORT_NAME->SetText($this->FormParameters["PORT_NAME"][$this->RowNumber], $this->RowNumber);
            $this->city_id->SetText($this->FormParameters["city_id"][$this->RowNumber], $this->RowNumber);
            $this->PORT_FEE_ID->SetText($this->FormParameters["PORT_FEE_ID"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @13-9773F723
    function ValidateRow()
    {
        global $CCSLocales;
        $this->country_id->Validate();
        $this->PORT_NAME->Validate();
        $this->city_id->Validate();
        $this->PORT_FEE_ID->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->country_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->PORT_NAME->Errors->ToString());
        $errors = ComposeStrings($errors, $this->city_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->PORT_FEE_ID->Errors->ToString());
        $this->country_id->Errors->Clear();
        $this->PORT_NAME->Errors->Clear();
        $this->city_id->Errors->Clear();
        $this->PORT_FEE_ID->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @13-480E99FC
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["country_id"][$this->RowNumber]) && count($this->FormParameters["country_id"][$this->RowNumber])) || strlen($this->FormParameters["country_id"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["PORT_NAME"][$this->RowNumber]) && count($this->FormParameters["PORT_NAME"][$this->RowNumber])) || strlen($this->FormParameters["PORT_NAME"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["city_id"][$this->RowNumber]) && count($this->FormParameters["city_id"][$this->RowNumber])) || strlen($this->FormParameters["city_id"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["PORT_FEE_ID"][$this->RowNumber]) && count($this->FormParameters["PORT_FEE_ID"][$this->RowNumber])) || strlen($this->FormParameters["PORT_FEE_ID"][$this->RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @13-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @13-909F269B
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

//UpdateGrid Method @13-1B9545D5
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["PORT_ID"] = $this->CachedColumns["PORT_ID"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->country_id->SetText($this->FormParameters["country_id"][$this->RowNumber], $this->RowNumber);
            $this->PORT_NAME->SetText($this->FormParameters["PORT_NAME"][$this->RowNumber], $this->RowNumber);
            $this->city_id->SetText($this->FormParameters["city_id"][$this->RowNumber], $this->RowNumber);
            $this->PORT_FEE_ID->SetText($this->FormParameters["PORT_FEE_ID"][$this->RowNumber], $this->RowNumber);
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

//InsertRow Method @13-6BB79F1D
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->country_id->SetValue($this->country_id->GetValue(true));
        $this->DataSource->PORT_NAME->SetValue($this->PORT_NAME->GetValue(true));
        $this->DataSource->city_id->SetValue($this->city_id->GetValue(true));
        $this->DataSource->PORT_FEE_ID->SetValue($this->PORT_FEE_ID->GetValue(true));
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

//UpdateRow Method @13-3D39C506
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->country_id->SetValue($this->country_id->GetValue(true));
        $this->DataSource->PORT_NAME->SetValue($this->PORT_NAME->GetValue(true));
        $this->DataSource->city_id->SetValue($this->city_id->GetValue(true));
        $this->DataSource->PORT_FEE_ID->SetValue($this->PORT_FEE_ID->GetValue(true));
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

//DeleteRow Method @13-A4A656F6
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

//FormScript Method @13-9EF9D9DA
    function FormScript($TotalRows)
    {
        $script = "";
        $script .= "\n<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n";
        $script .= "var ports_tbl1Elements;\n";
        $script .= "var ports_tbl1EmptyRows = 3;\n";
        $script .= "var " . $this->ComponentName . "country_idID = 0;\n";
        $script .= "var " . $this->ComponentName . "PORT_NAMEID = 1;\n";
        $script .= "var " . $this->ComponentName . "city_idID = 2;\n";
        $script .= "var " . $this->ComponentName . "PORT_FEE_IDID = 3;\n";
        $script .= "\nfunction initports_tbl1Elements() {\n";
        $script .= "\tvar ED = document.forms[\"ports_tbl1\"];\n";
        $script .= "\tports_tbl1Elements = new Array (\n";
        for($i = 1; $i <= $TotalRows; $i++) {
            $script .= "\t\tnew Array(" . "ED.country_id_" . $i . ", " . "ED.PORT_NAME_" . $i . ", " . "ED.city_id_" . $i . ", " . "ED.PORT_FEE_ID_" . $i . ")";
            if($i != $TotalRows) $script .= ",\n";
        }
        $script .= ");\n";
        $script .= "}\n";
        $script .= "\n//-->\n</script>";
        return $script;
    }
//End FormScript Method

//SetFormState Method @13-B1A2410B
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
                $this->CachedColumns["PORT_ID"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["PORT_ID"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @13-2F276289
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["PORT_ID"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @13-6816F2AD
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
        $this->PORT_FEE_ID->Prepare();

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
        $this->ControlsVisible["country_id"] = $this->country_id->Visible;
        $this->ControlsVisible["PORT_NAME"] = $this->PORT_NAME->Visible;
        $this->ControlsVisible["city_id"] = $this->city_id->Visible;
        $this->ControlsVisible["PORT_FEE_ID"] = $this->PORT_FEE_ID->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($is_next_record) || !($this->DeleteAllowed)) {
                    $this->CheckBox_Delete->Visible = false;
                    $this->CheckBox_Delete_Panel->Visible = false;
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["PORT_ID"][$this->RowNumber] = $this->DataSource->CachedColumns["PORT_ID"];
                    $this->country_id->SetValue($this->DataSource->country_id->GetValue());
                    $this->PORT_NAME->SetValue($this->DataSource->PORT_NAME->GetValue());
                    $this->city_id->SetValue($this->DataSource->city_id->GetValue());
                    $this->PORT_FEE_ID->SetValue($this->DataSource->PORT_FEE_ID->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->country_id->SetText($this->FormParameters["country_id"][$this->RowNumber], $this->RowNumber);
                    $this->PORT_NAME->SetText($this->FormParameters["PORT_NAME"][$this->RowNumber], $this->RowNumber);
                    $this->city_id->SetText($this->FormParameters["city_id"][$this->RowNumber], $this->RowNumber);
                    $this->PORT_FEE_ID->SetText($this->FormParameters["PORT_FEE_ID"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["PORT_ID"][$this->RowNumber] = "";
                    $this->country_id->SetText("");
                    $this->PORT_NAME->SetText("");
                    $this->city_id->SetText("");
                    $this->PORT_FEE_ID->SetText("");
                } else {
                    $this->country_id->SetText($this->FormParameters["country_id"][$this->RowNumber], $this->RowNumber);
                    $this->PORT_NAME->SetText($this->FormParameters["PORT_NAME"][$this->RowNumber], $this->RowNumber);
                    $this->city_id->SetText($this->FormParameters["city_id"][$this->RowNumber], $this->RowNumber);
                    $this->PORT_FEE_ID->SetText($this->FormParameters["PORT_FEE_ID"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->country_id->Show($this->RowNumber);
                $this->PORT_NAME->Show($this->RowNumber);
                $this->city_id->Show($this->RowNumber);
                $this->PORT_FEE_ID->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["PORT_ID"] == $this->CachedColumns["PORT_ID"][$this->RowNumber])) {
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
        if(!is_array($this->PORT_FEE->Value) && !strlen($this->PORT_FEE->Value) && $this->PORT_FEE->Value !== false)
        $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator->TotalPages = $this->DataSource->PageCount();
        if ($this->Navigator->TotalPages <= 1) {
            $this->Navigator->Visible = false;
        }
        $this->CheckBox_Delete_Panel->Show();
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

} //End ports_tbl1 Class @13-FCB6E20C

class clsports_tbl1DataSource extends clsDBhss_db {  //ports_tbl1DataSource Class @13-EFFAD252

//DataSource Variables @13-EC29EE7C
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
    public $country_id;
    public $PORT_NAME;
    public $city_id;
    public $PORT_FEE_ID;
//End DataSource Variables

//DataSourceClass_Initialize Event @13-B493B38C
    function clsports_tbl1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid ports_tbl1/Error";
        $this->Initialize();
        $this->country_id = new clsField("country_id", ccsInteger, "");
        
        $this->PORT_NAME = new clsField("PORT_NAME", ccsText, "");
        
        $this->city_id = new clsField("city_id", ccsInteger, "");
        
        $this->PORT_FEE_ID = new clsField("PORT_FEE_ID", ccsInteger, "");
        

        $this->InsertFields["country_id"] = array("Name" => "country_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["PORT_NAME"] = array("Name" => "PORT_NAME", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["city_id"] = array("Name" => "city_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["PORT_FEE_ID"] = array("Name" => "PORT_FEE_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["country_id"] = array("Name" => "country_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["PORT_NAME"] = array("Name" => "PORT_NAME", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["city_id"] = array("Name" => "city_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["PORT_FEE_ID"] = array("Name" => "PORT_FEE_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @13-0525FB8F
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "country_id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @13-560C4183
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_country_id", ccsInteger, "", "", $this->Parameters["urls_country_id"], "", false);
        $this->wp->AddParameter("2", "urls_PORT_NAME", ccsText, "", "", $this->Parameters["urls_PORT_NAME"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "country_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "PORT_NAME", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @13-0E9BE02D
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ports_tbl";
        $this->SQL = "SELECT * \n\n" .
        "FROM ports_tbl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @13-FBD3E051
    function SetValues()
    {
        $this->CachedColumns["PORT_ID"] = $this->f("PORT_ID");
        $this->country_id->SetDBValue(trim($this->f("country_id")));
        $this->PORT_NAME->SetDBValue($this->f("PORT_NAME"));
        $this->city_id->SetDBValue(trim($this->f("city_id")));
        $this->PORT_FEE_ID->SetDBValue(trim($this->f("PORT_FEE_ID")));
    }
//End SetValues Method

//Insert Method @13-3CCDEBC9
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["country_id"]["Value"] = $this->country_id->GetDBValue(true);
        $this->InsertFields["PORT_NAME"]["Value"] = $this->PORT_NAME->GetDBValue(true);
        $this->InsertFields["city_id"]["Value"] = $this->city_id->GetDBValue(true);
        $this->InsertFields["PORT_FEE_ID"]["Value"] = $this->PORT_FEE_ID->GetDBValue(true);
        $this->SQL = CCBuildInsert("ports_tbl", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @13-1758BDA0
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "PORT_ID=" . $this->ToSQL($this->CachedColumns["PORT_ID"], ccsInteger);
        $this->UpdateFields["country_id"]["Value"] = $this->country_id->GetDBValue(true);
        $this->UpdateFields["PORT_NAME"]["Value"] = $this->PORT_NAME->GetDBValue(true);
        $this->UpdateFields["city_id"]["Value"] = $this->city_id->GetDBValue(true);
        $this->UpdateFields["PORT_FEE_ID"]["Value"] = $this->PORT_FEE_ID->GetDBValue(true);
        $this->SQL = CCBuildUpdate("ports_tbl", $this->UpdateFields, $this);
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

//Delete Method @13-0FE62652
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "PORT_ID=" . $this->ToSQL($this->CachedColumns["PORT_ID"], ccsInteger);
        $this->SQL = "DELETE FROM ports_tbl";
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

} //End ports_tbl1DataSource Class @13-FCB6E20C

class clsRecordports_tblSearch { //ports_tblSearch Class @14-B1AE7D69

//Variables @14-9E315808

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

//Class_Initialize Event @14-8EB5EA23
    function clsRecordports_tblSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record ports_tblSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "ports_tblSearch";
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
            if(!$this->FormSubmitted) {
                if(!is_array($this->s_country_id->Value) && !strlen($this->s_country_id->Value) && $this->s_country_id->Value !== false)
                    $this->s_country_id->SetText(186);
            }
        }
    }
//End Class_Initialize Event

//Validate Method @14-F3032748
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_country_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_country_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @14-C7C049F7
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_country_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @14-ED598703
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

//Operation Method @14-BF6F1BF2
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
        $Redirect = "page2_1.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "page2_1.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @14-95601C24
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
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End ports_tblSearch Class @14-FCB6E20C

//Initialize Page @1-AB1AD3EE
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
$TemplateFileName = "page2_1.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-3AAB8C66
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$ports_tbl1 = new clsEditableGridports_tbl1("", $MainPage);
$ports_tblSearch = new clsRecordports_tblSearch("", $MainPage);
$MainPage->ports_tbl1 = & $ports_tbl1;
$MainPage->ports_tblSearch = & $ports_tblSearch;
$ports_tbl1->Initialize();

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

//Execute Components @1-B7EE67DE
$ports_tbl1->Operation();
$ports_tblSearch->Operation();
//End Execute Components

//Go to destination page @1-788AE532
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($ports_tbl1);
    unset($ports_tblSearch);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-E4962B08
$ports_tbl1->Show();
$ports_tblSearch->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-F68D4BFD
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($ports_tbl1);
unset($ports_tblSearch);
unset($Tpl);
//End Unload Page


?>
