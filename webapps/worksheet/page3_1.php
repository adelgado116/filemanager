<?php
//Include Common Files @1-B0DD8CA4
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page3_1.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files



class clsEditableGridequipment_model_tbl1 { //equipment_model_tbl1 Class @14-0B220B49

//Variables @14-F9538F3C

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

//Class_Initialize Event @14-D0606EB1
    function clsEditableGridequipment_model_tbl1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid equipment_model_tbl1/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "equipment_model_tbl1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["EQUIP_ID"][0] = "EQUIP_ID";
        $this->DataSource = new clsequipment_model_tbl1DataSource($this);
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

        $this->MANUF_ID = new clsControl(ccsListBox, "MANUF_ID", "MANUF ID", ccsInteger, "", NULL, $this);
        $this->MANUF_ID->DSType = dsTable;
        $this->MANUF_ID->DataSource = new clsDBhss_db();
        $this->MANUF_ID->ds = & $this->MANUF_ID->DataSource;
        $this->MANUF_ID->DataSource->SQL = "SELECT * \n" .
"FROM equipment_manufacturer_tbl {SQL_Where} {SQL_OrderBy}";
        $this->MANUF_ID->DataSource->Order = "MANUF_NAME";
        list($this->MANUF_ID->BoundColumn, $this->MANUF_ID->TextColumn, $this->MANUF_ID->DBFormat) = array("MANUF_ID", "MANUF_NAME", "");
        $this->MANUF_ID->DataSource->Order = "MANUF_NAME";
        $this->EQUIP_TYPE_ID = new clsControl(ccsListBox, "EQUIP_TYPE_ID", "EQUIP TYPE ID", ccsInteger, "", NULL, $this);
        $this->EQUIP_TYPE_ID->DSType = dsTable;
        $this->EQUIP_TYPE_ID->DataSource = new clsDBhss_db();
        $this->EQUIP_TYPE_ID->ds = & $this->EQUIP_TYPE_ID->DataSource;
        $this->EQUIP_TYPE_ID->DataSource->SQL = "SELECT * \n" .
"FROM equipment_type_tbl {SQL_Where} {SQL_OrderBy}";
        $this->EQUIP_TYPE_ID->DataSource->Order = "EQUIP_TYPE";
        list($this->EQUIP_TYPE_ID->BoundColumn, $this->EQUIP_TYPE_ID->TextColumn, $this->EQUIP_TYPE_ID->DBFormat) = array("EQUIP_TYPE_ID", "EQUIP_TYPE", "");
        $this->EQUIP_TYPE_ID->DataSource->Order = "EQUIP_TYPE";
        $this->EQUIP_MODEL = new clsControl(ccsTextBox, "EQUIP_MODEL", "EQUIP MODEL", ccsText, "", NULL, $this);
        $this->EQUIP_MODEL->Required = true;
        $this->extended_info = new clsControl(ccsTextBox, "extended_info", "Extended Info", ccsText, "", NULL, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
    }
//End Class_Initialize Event

//Initialize Method @14-34AEF889
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urls_MANUF_ID"] = CCGetFromGet("s_MANUF_ID", NULL);
        $this->DataSource->Parameters["urls_EQUIP_TYPE_ID"] = CCGetFromGet("s_EQUIP_TYPE_ID", NULL);
    }
//End Initialize Method

//SetPrimaryKeys Method @14-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @14-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @14-04D9F512
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["MANUF_ID"][$RowNumber] = CCGetFromPost("MANUF_ID_" . $RowNumber, NULL);
            $this->FormParameters["EQUIP_TYPE_ID"][$RowNumber] = CCGetFromPost("EQUIP_TYPE_ID_" . $RowNumber, NULL);
            $this->FormParameters["EQUIP_MODEL"][$RowNumber] = CCGetFromPost("EQUIP_MODEL_" . $RowNumber, NULL);
            $this->FormParameters["extended_info"][$RowNumber] = CCGetFromPost("extended_info_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @14-3E62BF40
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["EQUIP_ID"] = $this->CachedColumns["EQUIP_ID"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->MANUF_ID->SetText($this->FormParameters["MANUF_ID"][$this->RowNumber], $this->RowNumber);
            $this->EQUIP_TYPE_ID->SetText($this->FormParameters["EQUIP_TYPE_ID"][$this->RowNumber], $this->RowNumber);
            $this->EQUIP_MODEL->SetText($this->FormParameters["EQUIP_MODEL"][$this->RowNumber], $this->RowNumber);
            $this->extended_info->SetText($this->FormParameters["extended_info"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @14-574FC533
    function ValidateRow()
    {
        global $CCSLocales;
        $this->MANUF_ID->Validate();
        $this->EQUIP_TYPE_ID->Validate();
        $this->EQUIP_MODEL->Validate();
        $this->extended_info->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->MANUF_ID->Errors->ToString());
        $errors = ComposeStrings($errors, $this->EQUIP_TYPE_ID->Errors->ToString());
        $errors = ComposeStrings($errors, $this->EQUIP_MODEL->Errors->ToString());
        $errors = ComposeStrings($errors, $this->extended_info->Errors->ToString());
        $this->MANUF_ID->Errors->Clear();
        $this->EQUIP_TYPE_ID->Errors->Clear();
        $this->EQUIP_MODEL->Errors->Clear();
        $this->extended_info->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @14-EFA62252
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["MANUF_ID"][$this->RowNumber]) && count($this->FormParameters["MANUF_ID"][$this->RowNumber])) || strlen($this->FormParameters["MANUF_ID"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["EQUIP_TYPE_ID"][$this->RowNumber]) && count($this->FormParameters["EQUIP_TYPE_ID"][$this->RowNumber])) || strlen($this->FormParameters["EQUIP_TYPE_ID"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["EQUIP_MODEL"][$this->RowNumber]) && count($this->FormParameters["EQUIP_MODEL"][$this->RowNumber])) || strlen($this->FormParameters["EQUIP_MODEL"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["extended_info"][$this->RowNumber]) && count($this->FormParameters["extended_info"][$this->RowNumber])) || strlen($this->FormParameters["extended_info"][$this->RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @14-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @14-909F269B
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

//UpdateGrid Method @14-45D3EF1C
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["EQUIP_ID"] = $this->CachedColumns["EQUIP_ID"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->MANUF_ID->SetText($this->FormParameters["MANUF_ID"][$this->RowNumber], $this->RowNumber);
            $this->EQUIP_TYPE_ID->SetText($this->FormParameters["EQUIP_TYPE_ID"][$this->RowNumber], $this->RowNumber);
            $this->EQUIP_MODEL->SetText($this->FormParameters["EQUIP_MODEL"][$this->RowNumber], $this->RowNumber);
            $this->extended_info->SetText($this->FormParameters["extended_info"][$this->RowNumber], $this->RowNumber);
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

//InsertRow Method @14-9C24B99E
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->MANUF_ID->SetValue($this->MANUF_ID->GetValue(true));
        $this->DataSource->EQUIP_TYPE_ID->SetValue($this->EQUIP_TYPE_ID->GetValue(true));
        $this->DataSource->EQUIP_MODEL->SetValue($this->EQUIP_MODEL->GetValue(true));
        $this->DataSource->extended_info->SetValue($this->extended_info->GetValue(true));
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

//UpdateRow Method @14-46E8C719
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->MANUF_ID->SetValue($this->MANUF_ID->GetValue(true));
        $this->DataSource->EQUIP_TYPE_ID->SetValue($this->EQUIP_TYPE_ID->GetValue(true));
        $this->DataSource->EQUIP_MODEL->SetValue($this->EQUIP_MODEL->GetValue(true));
        $this->DataSource->extended_info->SetValue($this->extended_info->GetValue(true));
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

//DeleteRow Method @14-A4A656F6
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

//FormScript Method @14-52A1FCB4
    function FormScript($TotalRows)
    {
        $script = "";
        $script .= "\n<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n";
        $script .= "var equipment_model_tbl1Elements;\n";
        $script .= "var equipment_model_tbl1EmptyRows = 3;\n";
        $script .= "var " . $this->ComponentName . "MANUF_IDID = 0;\n";
        $script .= "var " . $this->ComponentName . "EQUIP_TYPE_IDID = 1;\n";
        $script .= "var " . $this->ComponentName . "EQUIP_MODELID = 2;\n";
        $script .= "var " . $this->ComponentName . "extended_infoID = 3;\n";
        $script .= "\nfunction initequipment_model_tbl1Elements() {\n";
        $script .= "\tvar ED = document.forms[\"equipment_model_tbl1\"];\n";
        $script .= "\tequipment_model_tbl1Elements = new Array (\n";
        for($i = 1; $i <= $TotalRows; $i++) {
            $script .= "\t\tnew Array(" . "ED.MANUF_ID_" . $i . ", " . "ED.EQUIP_TYPE_ID_" . $i . ", " . "ED.EQUIP_MODEL_" . $i . ", " . "ED.extended_info_" . $i . ")";
            if($i != $TotalRows) $script .= ",\n";
        }
        $script .= ");\n";
        $script .= "}\n";
        $script .= "\n//-->\n</script>";
        return $script;
    }
//End FormScript Method

//SetFormState Method @14-2EB3F8A3
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
                $this->CachedColumns["EQUIP_ID"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["EQUIP_ID"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @14-64CEC6D1
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["EQUIP_ID"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @14-075AEBD8
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->MANUF_ID->Prepare();
        $this->EQUIP_TYPE_ID->Prepare();

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
        $this->ControlsVisible["MANUF_ID"] = $this->MANUF_ID->Visible;
        $this->ControlsVisible["EQUIP_TYPE_ID"] = $this->EQUIP_TYPE_ID->Visible;
        $this->ControlsVisible["EQUIP_MODEL"] = $this->EQUIP_MODEL->Visible;
        $this->ControlsVisible["extended_info"] = $this->extended_info->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["EQUIP_ID"][$this->RowNumber] = $this->DataSource->CachedColumns["EQUIP_ID"];
                    $this->MANUF_ID->SetValue($this->DataSource->MANUF_ID->GetValue());
                    $this->EQUIP_TYPE_ID->SetValue($this->DataSource->EQUIP_TYPE_ID->GetValue());
                    $this->EQUIP_MODEL->SetValue($this->DataSource->EQUIP_MODEL->GetValue());
                    $this->extended_info->SetValue($this->DataSource->extended_info->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->MANUF_ID->SetText($this->FormParameters["MANUF_ID"][$this->RowNumber], $this->RowNumber);
                    $this->EQUIP_TYPE_ID->SetText($this->FormParameters["EQUIP_TYPE_ID"][$this->RowNumber], $this->RowNumber);
                    $this->EQUIP_MODEL->SetText($this->FormParameters["EQUIP_MODEL"][$this->RowNumber], $this->RowNumber);
                    $this->extended_info->SetText($this->FormParameters["extended_info"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["EQUIP_ID"][$this->RowNumber] = "";
                    $this->MANUF_ID->SetText("");
                    $this->EQUIP_TYPE_ID->SetText("");
                    $this->EQUIP_MODEL->SetText("");
                    $this->extended_info->SetText("");
                } else {
                    $this->MANUF_ID->SetText($this->FormParameters["MANUF_ID"][$this->RowNumber], $this->RowNumber);
                    $this->EQUIP_TYPE_ID->SetText($this->FormParameters["EQUIP_TYPE_ID"][$this->RowNumber], $this->RowNumber);
                    $this->EQUIP_MODEL->SetText($this->FormParameters["EQUIP_MODEL"][$this->RowNumber], $this->RowNumber);
                    $this->extended_info->SetText($this->FormParameters["extended_info"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->MANUF_ID->Show($this->RowNumber);
                $this->EQUIP_TYPE_ID->Show($this->RowNumber);
                $this->EQUIP_MODEL->Show($this->RowNumber);
                $this->extended_info->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["EQUIP_ID"] == $this->CachedColumns["EQUIP_ID"][$this->RowNumber])) {
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

} //End equipment_model_tbl1 Class @14-FCB6E20C

class clsequipment_model_tbl1DataSource extends clsDBhss_db {  //equipment_model_tbl1DataSource Class @14-E9F8F042

//DataSource Variables @14-A1E45330
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
    public $MANUF_ID;
    public $EQUIP_TYPE_ID;
    public $EQUIP_MODEL;
    public $extended_info;
//End DataSource Variables

//DataSourceClass_Initialize Event @14-8938C493
    function clsequipment_model_tbl1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid equipment_model_tbl1/Error";
        $this->Initialize();
        $this->MANUF_ID = new clsField("MANUF_ID", ccsInteger, "");
        
        $this->EQUIP_TYPE_ID = new clsField("EQUIP_TYPE_ID", ccsInteger, "");
        
        $this->EQUIP_MODEL = new clsField("EQUIP_MODEL", ccsText, "");
        
        $this->extended_info = new clsField("extended_info", ccsText, "");
        

        $this->InsertFields["MANUF_ID"] = array("Name" => "MANUF_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["EQUIP_TYPE_ID"] = array("Name" => "EQUIP_TYPE_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["EQUIP_MODEL"] = array("Name" => "EQUIP_MODEL", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["extended_info"] = array("Name" => "extended_info", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["MANUF_ID"] = array("Name" => "MANUF_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["EQUIP_TYPE_ID"] = array("Name" => "EQUIP_TYPE_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["EQUIP_MODEL"] = array("Name" => "EQUIP_MODEL", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["extended_info"] = array("Name" => "extended_info", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @14-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @14-C9A209EA
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_MANUF_ID", ccsInteger, "", "", $this->Parameters["urls_MANUF_ID"], "", false);
        $this->wp->AddParameter("2", "urls_EQUIP_TYPE_ID", ccsInteger, "", "", $this->Parameters["urls_EQUIP_TYPE_ID"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "MANUF_ID", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "EQUIP_TYPE_ID", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @14-ED1BD9C3
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM equipment_model_tbl";
        $this->SQL = "SELECT * \n\n" .
        "FROM equipment_model_tbl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @14-EF91383E
    function SetValues()
    {
        $this->CachedColumns["EQUIP_ID"] = $this->f("EQUIP_ID");
        $this->MANUF_ID->SetDBValue(trim($this->f("MANUF_ID")));
        $this->EQUIP_TYPE_ID->SetDBValue(trim($this->f("EQUIP_TYPE_ID")));
        $this->EQUIP_MODEL->SetDBValue($this->f("EQUIP_MODEL"));
        $this->extended_info->SetDBValue($this->f("extended_info"));
    }
//End SetValues Method

//Insert Method @14-A556ED11
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["MANUF_ID"]["Value"] = $this->MANUF_ID->GetDBValue(true);
        $this->InsertFields["EQUIP_TYPE_ID"]["Value"] = $this->EQUIP_TYPE_ID->GetDBValue(true);
        $this->InsertFields["EQUIP_MODEL"]["Value"] = $this->EQUIP_MODEL->GetDBValue(true);
        $this->InsertFields["extended_info"]["Value"] = $this->extended_info->GetDBValue(true);
        $this->SQL = CCBuildInsert("equipment_model_tbl", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @14-A30F8B92
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "EQUIP_ID=" . $this->ToSQL($this->CachedColumns["EQUIP_ID"], ccsInteger);
        $this->UpdateFields["MANUF_ID"]["Value"] = $this->MANUF_ID->GetDBValue(true);
        $this->UpdateFields["EQUIP_TYPE_ID"]["Value"] = $this->EQUIP_TYPE_ID->GetDBValue(true);
        $this->UpdateFields["EQUIP_MODEL"]["Value"] = $this->EQUIP_MODEL->GetDBValue(true);
        $this->UpdateFields["extended_info"]["Value"] = $this->extended_info->GetDBValue(true);
        $this->SQL = CCBuildUpdate("equipment_model_tbl", $this->UpdateFields, $this);
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

//Delete Method @14-6BD47478
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "EQUIP_ID=" . $this->ToSQL($this->CachedColumns["EQUIP_ID"], ccsInteger);
        $this->SQL = "DELETE FROM equipment_model_tbl";
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

} //End equipment_model_tbl1DataSource Class @14-FCB6E20C

class clsRecordequipment_manufacturer_tb { //equipment_manufacturer_tb Class @32-E0047D13

//Variables @32-9E315808

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

//Class_Initialize Event @32-52DC2D89
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
        $this->DataSource = new clsequipment_manufacturer_tbDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "equipment_manufacturer_tb";
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
            $this->MANUF_NAME = new clsControl(ccsTextBox, "MANUF_NAME", "MANUF NAME", ccsText, "", CCGetRequestParam("MANUF_NAME", $Method, NULL), $this);
            $this->MANUF_NAME->Required = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @32-89FCFD5E
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlMANUF_ID"] = CCGetFromGet("MANUF_ID", NULL);
    }
//End Initialize Method

//Validate Method @32-B483D503
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->MANUF_NAME->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->MANUF_NAME->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @32-BC290CC7
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->MANUF_NAME->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @32-ED598703
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

//Operation Method @32-EFC50250
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
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
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

//InsertRow Method @32-0BD841EE
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->MANUF_NAME->SetValue($this->MANUF_NAME->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//Show Method @32-47A8E716
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
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                if(!$this->FormSubmitted){
                    $this->MANUF_NAME->SetValue($this->DataSource->MANUF_NAME->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->MANUF_NAME->Errors->ToString());
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
        $this->MANUF_NAME->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End equipment_manufacturer_tb Class @32-FCB6E20C

class clsequipment_manufacturer_tbDataSource extends clsDBhss_db {  //equipment_manufacturer_tbDataSource Class @32-9F6EDE97

//DataSource Variables @32-89A2426F
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
    public $MANUF_NAME;
//End DataSource Variables

//DataSourceClass_Initialize Event @32-D681C896
    function clsequipment_manufacturer_tbDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record equipment_manufacturer_tb/Error";
        $this->Initialize();
        $this->MANUF_NAME = new clsField("MANUF_NAME", ccsText, "");
        

        $this->InsertFields["MANUF_NAME"] = array("Name" => "MANUF_NAME", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @32-786B209F
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlMANUF_ID", ccsInteger, "", "", $this->Parameters["urlMANUF_ID"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "MANUF_ID", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @32-A59A8052
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM equipment_manufacturer_tbl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @32-9FC0E53F
    function SetValues()
    {
        $this->MANUF_NAME->SetDBValue($this->f("MANUF_NAME"));
    }
//End SetValues Method

//Insert Method @32-628B79F7
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["MANUF_NAME"]["Value"] = $this->MANUF_NAME->GetDBValue(true);
        $this->SQL = CCBuildInsert("equipment_manufacturer_tbl", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

} //End equipment_manufacturer_tbDataSource Class @32-FCB6E20C

class clsRecordequipment_type_tbl { //equipment_type_tbl Class @36-A4DB2C42

//Variables @36-9E315808

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

//Class_Initialize Event @36-6DF42553
    function clsRecordequipment_type_tbl($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record equipment_type_tbl/Error";
        $this->DataSource = new clsequipment_type_tblDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "equipment_type_tbl";
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
            $this->EQUIP_TYPE = new clsControl(ccsTextBox, "EQUIP_TYPE", "EQUIP TYPE", ccsText, "", CCGetRequestParam("EQUIP_TYPE", $Method, NULL), $this);
            $this->EQUIP_TYPE->Required = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @36-739308B5
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlEQUIP_TYPE_ID"] = CCGetFromGet("EQUIP_TYPE_ID", NULL);
    }
//End Initialize Method

//Validate Method @36-C5B1960E
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->EQUIP_TYPE->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->EQUIP_TYPE->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @36-203C060A
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->EQUIP_TYPE->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @36-ED598703
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

//Operation Method @36-EFC50250
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
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
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

//InsertRow Method @36-C25DD514
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->EQUIP_TYPE->SetValue($this->EQUIP_TYPE->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//Show Method @36-1DDE9027
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
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                if(!$this->FormSubmitted){
                    $this->EQUIP_TYPE->SetValue($this->DataSource->EQUIP_TYPE->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->EQUIP_TYPE->Errors->ToString());
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
        $this->EQUIP_TYPE->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End equipment_type_tbl Class @36-FCB6E20C

class clsequipment_type_tblDataSource extends clsDBhss_db {  //equipment_type_tblDataSource Class @36-56D43A2C

//DataSource Variables @36-BE43B38E
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
    public $EQUIP_TYPE;
//End DataSource Variables

//DataSourceClass_Initialize Event @36-2B5781F1
    function clsequipment_type_tblDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record equipment_type_tbl/Error";
        $this->Initialize();
        $this->EQUIP_TYPE = new clsField("EQUIP_TYPE", ccsText, "");
        

        $this->InsertFields["EQUIP_TYPE"] = array("Name" => "EQUIP_TYPE", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @36-3F6C5B44
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlEQUIP_TYPE_ID", ccsInteger, "", "", $this->Parameters["urlEQUIP_TYPE_ID"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "EQUIP_TYPE_ID", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @36-F1ADB312
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM equipment_type_tbl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @36-04D94974
    function SetValues()
    {
        $this->EQUIP_TYPE->SetDBValue($this->f("EQUIP_TYPE"));
    }
//End SetValues Method

//Insert Method @36-2600BA7D
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["EQUIP_TYPE"]["Value"] = $this->EQUIP_TYPE->GetDBValue(true);
        $this->SQL = CCBuildInsert("equipment_type_tbl", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

} //End equipment_type_tblDataSource Class @36-FCB6E20C

class clsRecordequipment_model_tblSearch { //equipment_model_tblSearch Class @15-7D64EFD0

//Variables @15-9E315808

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

//Class_Initialize Event @15-A6B1FCE8
    function clsRecordequipment_model_tblSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record equipment_model_tblSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "equipment_model_tblSearch";
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
            $this->s_MANUF_ID->DataSource->Order = "MANUF_NAME";
            list($this->s_MANUF_ID->BoundColumn, $this->s_MANUF_ID->TextColumn, $this->s_MANUF_ID->DBFormat) = array("MANUF_ID", "MANUF_NAME", "");
            $this->s_MANUF_ID->DataSource->Order = "MANUF_NAME";
            $this->s_EQUIP_TYPE_ID = new clsControl(ccsListBox, "s_EQUIP_TYPE_ID", "s_EQUIP_TYPE_ID", ccsInteger, "", CCGetRequestParam("s_EQUIP_TYPE_ID", $Method, NULL), $this);
            $this->s_EQUIP_TYPE_ID->DSType = dsTable;
            $this->s_EQUIP_TYPE_ID->DataSource = new clsDBhss_db();
            $this->s_EQUIP_TYPE_ID->ds = & $this->s_EQUIP_TYPE_ID->DataSource;
            $this->s_EQUIP_TYPE_ID->DataSource->SQL = "SELECT * \n" .
"FROM equipment_type_tbl {SQL_Where} {SQL_OrderBy}";
            $this->s_EQUIP_TYPE_ID->DataSource->Order = "EQUIP_TYPE";
            list($this->s_EQUIP_TYPE_ID->BoundColumn, $this->s_EQUIP_TYPE_ID->TextColumn, $this->s_EQUIP_TYPE_ID->DBFormat) = array("EQUIP_TYPE_ID", "EQUIP_TYPE", "");
            $this->s_EQUIP_TYPE_ID->DataSource->Order = "EQUIP_TYPE";
        }
    }
//End Class_Initialize Event

//Validate Method @15-8BFDD735
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_MANUF_ID->Validate() && $Validation);
        $Validation = ($this->s_EQUIP_TYPE_ID->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_MANUF_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_EQUIP_TYPE_ID->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @15-3E6AA19A
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_MANUF_ID->Errors->Count());
        $errors = ($errors || $this->s_EQUIP_TYPE_ID->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @15-ED598703
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

//Operation Method @15-8B747A91
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
        $Redirect = "page3_1.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "page3_1.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @15-B9B270AD
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
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End equipment_model_tblSearch Class @15-FCB6E20C

//Initialize Page @1-FC8D0479
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
$TemplateFileName = "page3_1.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-69992986
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$equipment_model_tbl1 = new clsEditableGridequipment_model_tbl1("", $MainPage);
$equipment_manufacturer_tb = new clsRecordequipment_manufacturer_tb("", $MainPage);
$equipment_type_tbl = new clsRecordequipment_type_tbl("", $MainPage);
$equipment_model_tblSearch = new clsRecordequipment_model_tblSearch("", $MainPage);
$MainPage->equipment_model_tbl1 = & $equipment_model_tbl1;
$MainPage->equipment_manufacturer_tb = & $equipment_manufacturer_tb;
$MainPage->equipment_type_tbl = & $equipment_type_tbl;
$MainPage->equipment_model_tblSearch = & $equipment_model_tblSearch;
$equipment_model_tbl1->Initialize();
$equipment_manufacturer_tb->Initialize();
$equipment_type_tbl->Initialize();

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

//Execute Components @1-DA77974F
$equipment_model_tbl1->Operation();
$equipment_manufacturer_tb->Operation();
$equipment_type_tbl->Operation();
$equipment_model_tblSearch->Operation();
//End Execute Components

//Go to destination page @1-5A223D1A
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($equipment_model_tbl1);
    unset($equipment_manufacturer_tb);
    unset($equipment_type_tbl);
    unset($equipment_model_tblSearch);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-C78AAE2F
$equipment_model_tbl1->Show();
$equipment_manufacturer_tb->Show();
$equipment_type_tbl->Show();
$equipment_model_tblSearch->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-B0D8089E
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($equipment_model_tbl1);
unset($equipment_manufacturer_tb);
unset($equipment_type_tbl);
unset($equipment_model_tblSearch);
unset($Tpl);
//End Unload Page


?>
