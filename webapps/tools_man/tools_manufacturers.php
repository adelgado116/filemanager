<?php
//Include Common Files @1-3D21D743
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "tools_manufacturers.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
include_once(RelativePath . "/Services.php");
//End Include Common Files

class clsEditableGridtools_manufacturers { //tools_manufacturers Class @3-AE625E73

//Variables @3-F667987F

    // Public variables
    var $ComponentType = "EditableGrid";
    var $ComponentName;
    var $HTMLFormAction;
    var $PressedButton;
    var $Errors;
    var $ErrorBlock;
    var $FormSubmitted;
    var $FormParameters;
    var $FormState;
    var $FormEnctype;
    var $CachedColumns;
    var $TotalRows;
    var $UpdatedRows;
    var $EmptyRows;
    var $Visible;
    var $RowsErrors;
    var $ds;
    var $DataSource;
    var $PageSize;
    var $IsEmpty;
    var $SorterName = "";
    var $SorterDirection = "";
    var $PageNumber;
    var $ControlsVisible = array();

    var $CCSEvents = "";
    var $CCSEventResult;

    var $RelativePath = "";

    var $InsertAllowed = false;
    var $UpdateAllowed = false;
    var $DeleteAllowed = false;
    var $ReadAllowed   = false;
    var $EditMode;
    var $ValidatingControls;
    var $Controls;
    var $ControlsErrors;
    var $RowNumber;
    var $Attributes;
    var $PrimaryKeys;

    // Class variables
//End Variables

//Class_Initialize Event @3-A2679169
    function clsEditableGridtools_manufacturers($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid tools_manufacturers/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "tools_manufacturers";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["manufacturer_id"][0] = "manufacturer_id";
        $this->DataSource = new clstools_manufacturersDataSource($this);
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

        $this->EmptyRows = 1;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
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

        $this->manufacturer_name = & new clsControl(ccsTextBox, "manufacturer_name", "Manufacturer Name", ccsText, "", NULL, $this);
        $this->manufacturer_name->Required = true;
        $this->manufacturer_address = & new clsControl(ccsTextBox, "manufacturer_address", "Manufacturer Address", ccsText, "", NULL, $this);
        $this->manufacturer_website = & new clsControl(ccsTextBox, "manufacturer_website", "Manufacturer Website", ccsText, "", NULL, $this);
        $this->manufacturer_email = & new clsControl(ccsTextBox, "manufacturer_email", "Manufacturer Email", ccsText, "", NULL, $this);
        $this->manufacturer_phone = & new clsControl(ccsTextBox, "manufacturer_phone", "Manufacturer Phone", ccsText, "", NULL, $this);
        $this->Navigator = & new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = & new clsButton("Button_Submit", $Method, $this);
    }
//End Class_Initialize Event

//Initialize Method @3-8F9070D8
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urls_manufacturer_name"] = CCGetFromGet("s_manufacturer_name", NULL);
    }
//End Initialize Method

//SetPrimaryKeys Method @3-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @3-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @3-08ADEEFD
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["manufacturer_name"][$RowNumber] = CCGetFromPost("manufacturer_name_" . $RowNumber, NULL);
            $this->FormParameters["manufacturer_address"][$RowNumber] = CCGetFromPost("manufacturer_address_" . $RowNumber, NULL);
            $this->FormParameters["manufacturer_website"][$RowNumber] = CCGetFromPost("manufacturer_website_" . $RowNumber, NULL);
            $this->FormParameters["manufacturer_email"][$RowNumber] = CCGetFromPost("manufacturer_email_" . $RowNumber, NULL);
            $this->FormParameters["manufacturer_phone"][$RowNumber] = CCGetFromPost("manufacturer_phone_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @3-472CD275
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["manufacturer_id"] = $this->CachedColumns["manufacturer_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->manufacturer_name->SetText($this->FormParameters["manufacturer_name"][$this->RowNumber], $this->RowNumber);
            $this->manufacturer_address->SetText($this->FormParameters["manufacturer_address"][$this->RowNumber], $this->RowNumber);
            $this->manufacturer_website->SetText($this->FormParameters["manufacturer_website"][$this->RowNumber], $this->RowNumber);
            $this->manufacturer_email->SetText($this->FormParameters["manufacturer_email"][$this->RowNumber], $this->RowNumber);
            $this->manufacturer_phone->SetText($this->FormParameters["manufacturer_phone"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @3-ED1D4FA1
    function ValidateRow()
    {
        global $CCSLocales;
        $this->manufacturer_name->Validate();
        $this->manufacturer_address->Validate();
        $this->manufacturer_website->Validate();
        $this->manufacturer_email->Validate();
        $this->manufacturer_phone->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->manufacturer_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->manufacturer_address->Errors->ToString());
        $errors = ComposeStrings($errors, $this->manufacturer_website->Errors->ToString());
        $errors = ComposeStrings($errors, $this->manufacturer_email->Errors->ToString());
        $errors = ComposeStrings($errors, $this->manufacturer_phone->Errors->ToString());
        $this->manufacturer_name->Errors->Clear();
        $this->manufacturer_address->Errors->Clear();
        $this->manufacturer_website->Errors->Clear();
        $this->manufacturer_email->Errors->Clear();
        $this->manufacturer_phone->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @3-FC3F7370
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["manufacturer_name"][$this->RowNumber]) && count($this->FormParameters["manufacturer_name"][$this->RowNumber])) || strlen($this->FormParameters["manufacturer_name"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["manufacturer_address"][$this->RowNumber]) && count($this->FormParameters["manufacturer_address"][$this->RowNumber])) || strlen($this->FormParameters["manufacturer_address"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["manufacturer_website"][$this->RowNumber]) && count($this->FormParameters["manufacturer_website"][$this->RowNumber])) || strlen($this->FormParameters["manufacturer_website"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["manufacturer_email"][$this->RowNumber]) && count($this->FormParameters["manufacturer_email"][$this->RowNumber])) || strlen($this->FormParameters["manufacturer_email"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["manufacturer_phone"][$this->RowNumber]) && count($this->FormParameters["manufacturer_phone"][$this->RowNumber])) || strlen($this->FormParameters["manufacturer_phone"][$this->RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @3-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @3-1944CD48
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

        $Redirect = $FileName;
        if($this->PressedButton == "Button_Submit") {
            if(!CCGetEvent($this->Button_Submit->CCSEvents, "OnClick", $this->Button_Submit) || !$this->UpdateGrid()) {
                $Redirect = "";
            } else {
                $Redirect = "page0_1_1_close_handler.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateGrid Method @3-C051D15D
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["manufacturer_id"] = $this->CachedColumns["manufacturer_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->manufacturer_name->SetText($this->FormParameters["manufacturer_name"][$this->RowNumber], $this->RowNumber);
            $this->manufacturer_address->SetText($this->FormParameters["manufacturer_address"][$this->RowNumber], $this->RowNumber);
            $this->manufacturer_website->SetText($this->FormParameters["manufacturer_website"][$this->RowNumber], $this->RowNumber);
            $this->manufacturer_email->SetText($this->FormParameters["manufacturer_email"][$this->RowNumber], $this->RowNumber);
            $this->manufacturer_phone->SetText($this->FormParameters["manufacturer_phone"][$this->RowNumber], $this->RowNumber);
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

//InsertRow Method @3-0EA25BE4
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->manufacturer_name->SetValue($this->manufacturer_name->GetValue(true));
        $this->DataSource->manufacturer_address->SetValue($this->manufacturer_address->GetValue(true));
        $this->DataSource->manufacturer_website->SetValue($this->manufacturer_website->GetValue(true));
        $this->DataSource->manufacturer_email->SetValue($this->manufacturer_email->GetValue(true));
        $this->DataSource->manufacturer_phone->SetValue($this->manufacturer_phone->GetValue(true));
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

//UpdateRow Method @3-0340C6DA
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->manufacturer_name->SetValue($this->manufacturer_name->GetValue(true));
        $this->DataSource->manufacturer_address->SetValue($this->manufacturer_address->GetValue(true));
        $this->DataSource->manufacturer_website->SetValue($this->manufacturer_website->GetValue(true));
        $this->DataSource->manufacturer_email->SetValue($this->manufacturer_email->GetValue(true));
        $this->DataSource->manufacturer_phone->SetValue($this->manufacturer_phone->GetValue(true));
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

//FormScript Method @3-44050EAF
    function FormScript($TotalRows)
    {
        $script = "";
        $script .= "\n<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n";
        $script .= "var tools_manufacturersElements;\n";
        $script .= "var tools_manufacturersEmptyRows = 1;\n";
        $script .= "var " . $this->ComponentName . "manufacturer_nameID = 0;\n";
        $script .= "var " . $this->ComponentName . "manufacturer_addressID = 1;\n";
        $script .= "var " . $this->ComponentName . "manufacturer_websiteID = 2;\n";
        $script .= "var " . $this->ComponentName . "manufacturer_emailID = 3;\n";
        $script .= "var " . $this->ComponentName . "manufacturer_phoneID = 4;\n";
        $script .= "\nfunction inittools_manufacturersElements() {\n";
        $script .= "\tvar ED = document.forms[\"tools_manufacturers\"];\n";
        $script .= "\ttools_manufacturersElements = new Array (\n";
        for($i = 1; $i <= $TotalRows; $i++) {
            $script .= "\t\tnew Array(" . "ED.manufacturer_name_" . $i . ", " . "ED.manufacturer_address_" . $i . ", " . "ED.manufacturer_website_" . $i . ", " . "ED.manufacturer_email_" . $i . ", " . "ED.manufacturer_phone_" . $i . ")";
            if($i != $TotalRows) $script .= ",\n";
        }
        $script .= ");\n";
        $script .= "}\n";
        $script .= "\n//-->\n</script>";
        return $script;
    }
//End FormScript Method

//SetFormState Method @3-2F1F12B0
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
                $this->CachedColumns["manufacturer_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["manufacturer_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @3-C066A13C
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["manufacturer_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @3-6A87DFC4
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


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
        $this->ControlsVisible["manufacturer_name"] = $this->manufacturer_name->Visible;
        $this->ControlsVisible["manufacturer_address"] = $this->manufacturer_address->Visible;
        $this->ControlsVisible["manufacturer_website"] = $this->manufacturer_website->Visible;
        $this->ControlsVisible["manufacturer_email"] = $this->manufacturer_email->Visible;
        $this->ControlsVisible["manufacturer_phone"] = $this->manufacturer_phone->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["manufacturer_id"][$this->RowNumber] = $this->DataSource->CachedColumns["manufacturer_id"];
                    $this->manufacturer_name->SetValue($this->DataSource->manufacturer_name->GetValue());
                    $this->manufacturer_address->SetValue($this->DataSource->manufacturer_address->GetValue());
                    $this->manufacturer_website->SetValue($this->DataSource->manufacturer_website->GetValue());
                    $this->manufacturer_email->SetValue($this->DataSource->manufacturer_email->GetValue());
                    $this->manufacturer_phone->SetValue($this->DataSource->manufacturer_phone->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->manufacturer_name->SetText($this->FormParameters["manufacturer_name"][$this->RowNumber], $this->RowNumber);
                    $this->manufacturer_address->SetText($this->FormParameters["manufacturer_address"][$this->RowNumber], $this->RowNumber);
                    $this->manufacturer_website->SetText($this->FormParameters["manufacturer_website"][$this->RowNumber], $this->RowNumber);
                    $this->manufacturer_email->SetText($this->FormParameters["manufacturer_email"][$this->RowNumber], $this->RowNumber);
                    $this->manufacturer_phone->SetText($this->FormParameters["manufacturer_phone"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["manufacturer_id"][$this->RowNumber] = "";
                    $this->manufacturer_name->SetText("");
                    $this->manufacturer_address->SetText("");
                    $this->manufacturer_website->SetText("");
                    $this->manufacturer_email->SetText("");
                    $this->manufacturer_phone->SetText("");
                } else {
                    $this->manufacturer_name->SetText($this->FormParameters["manufacturer_name"][$this->RowNumber], $this->RowNumber);
                    $this->manufacturer_address->SetText($this->FormParameters["manufacturer_address"][$this->RowNumber], $this->RowNumber);
                    $this->manufacturer_website->SetText($this->FormParameters["manufacturer_website"][$this->RowNumber], $this->RowNumber);
                    $this->manufacturer_email->SetText($this->FormParameters["manufacturer_email"][$this->RowNumber], $this->RowNumber);
                    $this->manufacturer_phone->SetText($this->FormParameters["manufacturer_phone"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->manufacturer_name->Show($this->RowNumber);
                $this->manufacturer_address->Show($this->RowNumber);
                $this->manufacturer_website->Show($this->RowNumber);
                $this->manufacturer_email->Show($this->RowNumber);
                $this->manufacturer_phone->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["manufacturer_id"] == $this->CachedColumns["manufacturer_id"][$this->RowNumber])) {
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

} //End tools_manufacturers Class @3-FCB6E20C

class clstools_manufacturersDataSource extends clsDBhss_db {  //tools_manufacturersDataSource Class @3-E477678D

//DataSource Variables @3-FBA3B8C5
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $InsertParameters;
    var $UpdateParameters;
    var $CountSQL;
    var $wp;
    var $AllParametersSet;

    var $CachedColumns;
    var $CurrentRow;
    var $InsertFields = array();
    var $UpdateFields = array();

    // Datasource fields
    var $manufacturer_name;
    var $manufacturer_address;
    var $manufacturer_website;
    var $manufacturer_email;
    var $manufacturer_phone;
//End DataSource Variables

//DataSourceClass_Initialize Event @3-D9C5D2FB
    function clstools_manufacturersDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid tools_manufacturers/Error";
        $this->Initialize();
        $this->manufacturer_name = new clsField("manufacturer_name", ccsText, "");
        
        $this->manufacturer_address = new clsField("manufacturer_address", ccsText, "");
        
        $this->manufacturer_website = new clsField("manufacturer_website", ccsText, "");
        
        $this->manufacturer_email = new clsField("manufacturer_email", ccsText, "");
        
        $this->manufacturer_phone = new clsField("manufacturer_phone", ccsText, "");
        

        $this->InsertFields["manufacturer_name"] = array("Name" => "manufacturer_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["manufacturer_address"] = array("Name" => "manufacturer_address", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["manufacturer_website"] = array("Name" => "manufacturer_website", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["manufacturer_email"] = array("Name" => "manufacturer_email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["manufacturer_phone"] = array("Name" => "manufacturer_phone", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["manufacturer_name"] = array("Name" => "manufacturer_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["manufacturer_address"] = array("Name" => "manufacturer_address", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["manufacturer_website"] = array("Name" => "manufacturer_website", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["manufacturer_email"] = array("Name" => "manufacturer_email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["manufacturer_phone"] = array("Name" => "manufacturer_phone", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @3-B1EECA64
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "manufacturer_id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @3-7FFB776E
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_manufacturer_name", ccsText, "", "", $this->Parameters["urls_manufacturer_name"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "manufacturer_name", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @3-2D7F6546
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tools_manufacturers";
        $this->SQL = "SELECT * \n\n" .
        "FROM tools_manufacturers {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @3-3CB55E2D
    function SetValues()
    {
        $this->CachedColumns["manufacturer_id"] = $this->f("manufacturer_id");
        $this->manufacturer_name->SetDBValue($this->f("manufacturer_name"));
        $this->manufacturer_address->SetDBValue($this->f("manufacturer_address"));
        $this->manufacturer_website->SetDBValue($this->f("manufacturer_website"));
        $this->manufacturer_email->SetDBValue($this->f("manufacturer_email"));
        $this->manufacturer_phone->SetDBValue($this->f("manufacturer_phone"));
    }
//End SetValues Method

//Insert Method @3-F4BCACE0
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["manufacturer_name"]["Value"] = $this->manufacturer_name->GetDBValue(true);
        $this->InsertFields["manufacturer_address"]["Value"] = $this->manufacturer_address->GetDBValue(true);
        $this->InsertFields["manufacturer_website"]["Value"] = $this->manufacturer_website->GetDBValue(true);
        $this->InsertFields["manufacturer_email"]["Value"] = $this->manufacturer_email->GetDBValue(true);
        $this->InsertFields["manufacturer_phone"]["Value"] = $this->manufacturer_phone->GetDBValue(true);
        $this->SQL = CCBuildInsert("tools_manufacturers", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @3-D94AD55D
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "manufacturer_id=" . $this->ToSQL($this->CachedColumns["manufacturer_id"], ccsInteger);
        $this->UpdateFields["manufacturer_name"]["Value"] = $this->manufacturer_name->GetDBValue(true);
        $this->UpdateFields["manufacturer_address"]["Value"] = $this->manufacturer_address->GetDBValue(true);
        $this->UpdateFields["manufacturer_website"]["Value"] = $this->manufacturer_website->GetDBValue(true);
        $this->UpdateFields["manufacturer_email"]["Value"] = $this->manufacturer_email->GetDBValue(true);
        $this->UpdateFields["manufacturer_phone"]["Value"] = $this->manufacturer_phone->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tools_manufacturers", $this->UpdateFields, $this);
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

} //End tools_manufacturersDataSource Class @3-FCB6E20C

class clsRecordtools_manufacturersSearch { //tools_manufacturersSearch Class @4-9999D900

//Variables @4-D6FF3E86

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

//Class_Initialize Event @4-577D8D18
    function clsRecordtools_manufacturersSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record tools_manufacturersSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "tools_manufacturersSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = & new clsButton("Button_DoSearch", $Method, $this);
            $this->s_manufacturer_name = & new clsControl(ccsTextBox, "s_manufacturer_name", "s_manufacturer_name", ccsText, "", CCGetRequestParam("s_manufacturer_name", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @4-FD8EFC9C
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_manufacturer_name->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_manufacturer_name->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @4-7AF3EC5C
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_manufacturer_name->Errors->Count());
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

//Operation Method @4-B53C1D09
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
        $Redirect = "tools_manufacturers.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "tools_manufacturers.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @4-65C1EE9F
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
            $Error = ComposeStrings($Error, $this->s_manufacturer_name->Errors->ToString());
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
        $this->s_manufacturer_name->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End tools_manufacturersSearch Class @4-FCB6E20C

//Initialize Page @1-23F921B9
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
$TemplateFileName = "tools_manufacturers.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-CE2C864C
include_once("./tools_manufacturers_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-C706F471
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tools_manufacturers = & new clsEditableGridtools_manufacturers("", $MainPage);
$tools_manufacturersSearch = & new clsRecordtools_manufacturersSearch("", $MainPage);
$MainPage->tools_manufacturers = & $tools_manufacturers;
$MainPage->tools_manufacturersSearch = & $tools_manufacturersSearch;
$tools_manufacturers->Initialize();

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

//Execute Components @1-15BC3209
$tools_manufacturers->Operation();
$tools_manufacturersSearch->Operation();
//End Execute Components

//Go to destination page @1-0EF0958B
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($tools_manufacturers);
    unset($tools_manufacturersSearch);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-C72E5F21
$tools_manufacturers->Show();
$tools_manufacturersSearch->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-F674A5FD
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($tools_manufacturers);
unset($tools_manufacturersSearch);
unset($Tpl);
//End Unload Page


?>
