<?php
//Include Common Files @1-C58426AE
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "tools_suppliers.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
include_once(RelativePath . "/Services.php");
//End Include Common Files

class clsEditableGridtools_suppliers { //tools_suppliers Class @3-EAF7A331

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

//Class_Initialize Event @3-F23A9AB5
    function clsEditableGridtools_suppliers($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid tools_suppliers/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "tools_suppliers";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["supplier_id"][0] = "supplier_id";
        $this->DataSource = new clstools_suppliersDataSource($this);
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

        $this->supplier_source = & new clsControl(ccsListBox, "supplier_source", "supplier_source", ccsText, "", NULL, $this);
        $this->supplier_source->DSType = dsTable;
        $this->supplier_source->DataSource = new clsDBhss_db();
        $this->supplier_source->ds = & $this->supplier_source->DataSource;
        $this->supplier_source->DataSource->SQL = "SELECT * \n" .
"FROM supplier_source_tbl {SQL_Where} {SQL_OrderBy}";
        list($this->supplier_source->BoundColumn, $this->supplier_source->TextColumn, $this->supplier_source->DBFormat) = array("supplier_source", "supplier_source", "");
        $this->supplier_source->Required = true;
        $this->supplier_name = & new clsControl(ccsTextBox, "supplier_name", "Supplier Name", ccsText, "", NULL, $this);
        $this->supplier_name->Required = true;
        $this->supplier_address = & new clsControl(ccsTextBox, "supplier_address", "Supplier Address", ccsText, "", NULL, $this);
        $this->supplier_website = & new clsControl(ccsTextBox, "supplier_website", "Supplier Website", ccsText, "", NULL, $this);
        $this->supplier_email = & new clsControl(ccsTextBox, "supplier_email", "Supplier Email", ccsText, "", NULL, $this);
        $this->supplier_phone = & new clsControl(ccsTextBox, "supplier_phone", "Supplier Phone", ccsText, "", NULL, $this);
        $this->Navigator = & new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = & new clsButton("Button_Submit", $Method, $this);
    }
//End Class_Initialize Event

//Initialize Method @3-DF336323
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urls_supplier_name"] = CCGetFromGet("s_supplier_name", NULL);
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

//GetFormParameters Method @3-1011E656
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["supplier_source"][$RowNumber] = CCGetFromPost("supplier_source_" . $RowNumber, NULL);
            $this->FormParameters["supplier_name"][$RowNumber] = CCGetFromPost("supplier_name_" . $RowNumber, NULL);
            $this->FormParameters["supplier_address"][$RowNumber] = CCGetFromPost("supplier_address_" . $RowNumber, NULL);
            $this->FormParameters["supplier_website"][$RowNumber] = CCGetFromPost("supplier_website_" . $RowNumber, NULL);
            $this->FormParameters["supplier_email"][$RowNumber] = CCGetFromPost("supplier_email_" . $RowNumber, NULL);
            $this->FormParameters["supplier_phone"][$RowNumber] = CCGetFromPost("supplier_phone_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @3-8C62D129
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["supplier_id"] = $this->CachedColumns["supplier_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->supplier_source->SetText($this->FormParameters["supplier_source"][$this->RowNumber], $this->RowNumber);
            $this->supplier_name->SetText($this->FormParameters["supplier_name"][$this->RowNumber], $this->RowNumber);
            $this->supplier_address->SetText($this->FormParameters["supplier_address"][$this->RowNumber], $this->RowNumber);
            $this->supplier_website->SetText($this->FormParameters["supplier_website"][$this->RowNumber], $this->RowNumber);
            $this->supplier_email->SetText($this->FormParameters["supplier_email"][$this->RowNumber], $this->RowNumber);
            $this->supplier_phone->SetText($this->FormParameters["supplier_phone"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @3-7CBA7FA9
    function ValidateRow()
    {
        global $CCSLocales;
        $this->supplier_source->Validate();
        $this->supplier_name->Validate();
        $this->supplier_address->Validate();
        $this->supplier_website->Validate();
        $this->supplier_email->Validate();
        $this->supplier_phone->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->supplier_source->Errors->ToString());
        $errors = ComposeStrings($errors, $this->supplier_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->supplier_address->Errors->ToString());
        $errors = ComposeStrings($errors, $this->supplier_website->Errors->ToString());
        $errors = ComposeStrings($errors, $this->supplier_email->Errors->ToString());
        $errors = ComposeStrings($errors, $this->supplier_phone->Errors->ToString());
        $this->supplier_source->Errors->Clear();
        $this->supplier_name->Errors->Clear();
        $this->supplier_address->Errors->Clear();
        $this->supplier_website->Errors->Clear();
        $this->supplier_email->Errors->Clear();
        $this->supplier_phone->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @3-C938ED69
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["supplier_source"][$this->RowNumber]) && count($this->FormParameters["supplier_source"][$this->RowNumber])) || strlen($this->FormParameters["supplier_source"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["supplier_name"][$this->RowNumber]) && count($this->FormParameters["supplier_name"][$this->RowNumber])) || strlen($this->FormParameters["supplier_name"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["supplier_address"][$this->RowNumber]) && count($this->FormParameters["supplier_address"][$this->RowNumber])) || strlen($this->FormParameters["supplier_address"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["supplier_website"][$this->RowNumber]) && count($this->FormParameters["supplier_website"][$this->RowNumber])) || strlen($this->FormParameters["supplier_website"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["supplier_email"][$this->RowNumber]) && count($this->FormParameters["supplier_email"][$this->RowNumber])) || strlen($this->FormParameters["supplier_email"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["supplier_phone"][$this->RowNumber]) && count($this->FormParameters["supplier_phone"][$this->RowNumber])) || strlen($this->FormParameters["supplier_phone"][$this->RowNumber]));
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

//UpdateGrid Method @3-91C5076A
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["supplier_id"] = $this->CachedColumns["supplier_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->supplier_source->SetText($this->FormParameters["supplier_source"][$this->RowNumber], $this->RowNumber);
            $this->supplier_name->SetText($this->FormParameters["supplier_name"][$this->RowNumber], $this->RowNumber);
            $this->supplier_address->SetText($this->FormParameters["supplier_address"][$this->RowNumber], $this->RowNumber);
            $this->supplier_website->SetText($this->FormParameters["supplier_website"][$this->RowNumber], $this->RowNumber);
            $this->supplier_email->SetText($this->FormParameters["supplier_email"][$this->RowNumber], $this->RowNumber);
            $this->supplier_phone->SetText($this->FormParameters["supplier_phone"][$this->RowNumber], $this->RowNumber);
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

//InsertRow Method @3-85A95FE7
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->supplier_source->SetValue($this->supplier_source->GetValue(true));
        $this->DataSource->supplier_name->SetValue($this->supplier_name->GetValue(true));
        $this->DataSource->supplier_address->SetValue($this->supplier_address->GetValue(true));
        $this->DataSource->supplier_website->SetValue($this->supplier_website->GetValue(true));
        $this->DataSource->supplier_email->SetValue($this->supplier_email->GetValue(true));
        $this->DataSource->supplier_phone->SetValue($this->supplier_phone->GetValue(true));
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

//UpdateRow Method @3-D537A6D1
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->supplier_source->SetValue($this->supplier_source->GetValue(true));
        $this->DataSource->supplier_name->SetValue($this->supplier_name->GetValue(true));
        $this->DataSource->supplier_address->SetValue($this->supplier_address->GetValue(true));
        $this->DataSource->supplier_website->SetValue($this->supplier_website->GetValue(true));
        $this->DataSource->supplier_email->SetValue($this->supplier_email->GetValue(true));
        $this->DataSource->supplier_phone->SetValue($this->supplier_phone->GetValue(true));
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

//FormScript Method @3-12208828
    function FormScript($TotalRows)
    {
        $script = "";
        $script .= "\n<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n";
        $script .= "var tools_suppliersElements;\n";
        $script .= "var tools_suppliersEmptyRows = 1;\n";
        $script .= "var " . $this->ComponentName . "supplier_sourceID = 0;\n";
        $script .= "var " . $this->ComponentName . "supplier_nameID = 1;\n";
        $script .= "var " . $this->ComponentName . "supplier_addressID = 2;\n";
        $script .= "var " . $this->ComponentName . "supplier_websiteID = 3;\n";
        $script .= "var " . $this->ComponentName . "supplier_emailID = 4;\n";
        $script .= "var " . $this->ComponentName . "supplier_phoneID = 5;\n";
        $script .= "\nfunction inittools_suppliersElements() {\n";
        $script .= "\tvar ED = document.forms[\"tools_suppliers\"];\n";
        $script .= "\ttools_suppliersElements = new Array (\n";
        for($i = 1; $i <= $TotalRows; $i++) {
            $script .= "\t\tnew Array(" . "ED.supplier_source_" . $i . ", " . "ED.supplier_name_" . $i . ", " . "ED.supplier_address_" . $i . ", " . "ED.supplier_website_" . $i . ", " . "ED.supplier_email_" . $i . ", " . "ED.supplier_phone_" . $i . ")";
            if($i != $TotalRows) $script .= ",\n";
        }
        $script .= ");\n";
        $script .= "}\n";
        $script .= "\n//-->\n</script>";
        return $script;
    }
//End FormScript Method

//SetFormState Method @3-76156ED1
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
                $this->CachedColumns["supplier_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["supplier_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @3-2638B0B4
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["supplier_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @3-5C192AAA
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->supplier_source->Prepare();

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
        $this->ControlsVisible["supplier_source"] = $this->supplier_source->Visible;
        $this->ControlsVisible["supplier_name"] = $this->supplier_name->Visible;
        $this->ControlsVisible["supplier_address"] = $this->supplier_address->Visible;
        $this->ControlsVisible["supplier_website"] = $this->supplier_website->Visible;
        $this->ControlsVisible["supplier_email"] = $this->supplier_email->Visible;
        $this->ControlsVisible["supplier_phone"] = $this->supplier_phone->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["supplier_id"][$this->RowNumber] = $this->DataSource->CachedColumns["supplier_id"];
                    $this->supplier_source->SetValue($this->DataSource->supplier_source->GetValue());
                    $this->supplier_name->SetValue($this->DataSource->supplier_name->GetValue());
                    $this->supplier_address->SetValue($this->DataSource->supplier_address->GetValue());
                    $this->supplier_website->SetValue($this->DataSource->supplier_website->GetValue());
                    $this->supplier_email->SetValue($this->DataSource->supplier_email->GetValue());
                    $this->supplier_phone->SetValue($this->DataSource->supplier_phone->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->supplier_source->SetText($this->FormParameters["supplier_source"][$this->RowNumber], $this->RowNumber);
                    $this->supplier_name->SetText($this->FormParameters["supplier_name"][$this->RowNumber], $this->RowNumber);
                    $this->supplier_address->SetText($this->FormParameters["supplier_address"][$this->RowNumber], $this->RowNumber);
                    $this->supplier_website->SetText($this->FormParameters["supplier_website"][$this->RowNumber], $this->RowNumber);
                    $this->supplier_email->SetText($this->FormParameters["supplier_email"][$this->RowNumber], $this->RowNumber);
                    $this->supplier_phone->SetText($this->FormParameters["supplier_phone"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["supplier_id"][$this->RowNumber] = "";
                    $this->supplier_source->SetText("");
                    $this->supplier_name->SetText("");
                    $this->supplier_address->SetText("");
                    $this->supplier_website->SetText("");
                    $this->supplier_email->SetText("");
                    $this->supplier_phone->SetText("");
                } else {
                    $this->supplier_source->SetText($this->FormParameters["supplier_source"][$this->RowNumber], $this->RowNumber);
                    $this->supplier_name->SetText($this->FormParameters["supplier_name"][$this->RowNumber], $this->RowNumber);
                    $this->supplier_address->SetText($this->FormParameters["supplier_address"][$this->RowNumber], $this->RowNumber);
                    $this->supplier_website->SetText($this->FormParameters["supplier_website"][$this->RowNumber], $this->RowNumber);
                    $this->supplier_email->SetText($this->FormParameters["supplier_email"][$this->RowNumber], $this->RowNumber);
                    $this->supplier_phone->SetText($this->FormParameters["supplier_phone"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->supplier_source->Show($this->RowNumber);
                $this->supplier_name->Show($this->RowNumber);
                $this->supplier_address->Show($this->RowNumber);
                $this->supplier_website->Show($this->RowNumber);
                $this->supplier_email->Show($this->RowNumber);
                $this->supplier_phone->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["supplier_id"] == $this->CachedColumns["supplier_id"][$this->RowNumber])) {
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

} //End tools_suppliers Class @3-FCB6E20C

class clstools_suppliersDataSource extends clsDBhss_db {  //tools_suppliersDataSource Class @3-4A03E752

//DataSource Variables @3-6B77E470
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
    var $supplier_source;
    var $supplier_name;
    var $supplier_address;
    var $supplier_website;
    var $supplier_email;
    var $supplier_phone;
//End DataSource Variables

//DataSourceClass_Initialize Event @3-CD58BF92
    function clstools_suppliersDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid tools_suppliers/Error";
        $this->Initialize();
        $this->supplier_source = new clsField("supplier_source", ccsText, "");
        
        $this->supplier_name = new clsField("supplier_name", ccsText, "");
        
        $this->supplier_address = new clsField("supplier_address", ccsText, "");
        
        $this->supplier_website = new clsField("supplier_website", ccsText, "");
        
        $this->supplier_email = new clsField("supplier_email", ccsText, "");
        
        $this->supplier_phone = new clsField("supplier_phone", ccsText, "");
        

        $this->InsertFields["supplier_source"] = array("Name" => "supplier_source", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["supplier_name"] = array("Name" => "supplier_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["supplier_address"] = array("Name" => "supplier_address", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["supplier_website"] = array("Name" => "supplier_website", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["supplier_email"] = array("Name" => "supplier_email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["supplier_phone"] = array("Name" => "supplier_phone", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["supplier_source"] = array("Name" => "supplier_source", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["supplier_name"] = array("Name" => "supplier_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["supplier_address"] = array("Name" => "supplier_address", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["supplier_website"] = array("Name" => "supplier_website", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["supplier_email"] = array("Name" => "supplier_email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["supplier_phone"] = array("Name" => "supplier_phone", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @3-23DA5199
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "supplier_id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @3-96B61883
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_supplier_name", ccsText, "", "", $this->Parameters["urls_supplier_name"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "supplier_name", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @3-6F30FF46
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tools_suppliers";
        $this->SQL = "SELECT * \n\n" .
        "FROM tools_suppliers {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @3-19384A30
    function SetValues()
    {
        $this->CachedColumns["supplier_id"] = $this->f("supplier_id");
        $this->supplier_source->SetDBValue($this->f("supplier_source"));
        $this->supplier_name->SetDBValue($this->f("supplier_name"));
        $this->supplier_address->SetDBValue($this->f("supplier_address"));
        $this->supplier_website->SetDBValue($this->f("supplier_website"));
        $this->supplier_email->SetDBValue($this->f("supplier_email"));
        $this->supplier_phone->SetDBValue($this->f("supplier_phone"));
    }
//End SetValues Method

//Insert Method @3-EFF8D8A0
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["supplier_source"]["Value"] = $this->supplier_source->GetDBValue(true);
        $this->InsertFields["supplier_name"]["Value"] = $this->supplier_name->GetDBValue(true);
        $this->InsertFields["supplier_address"]["Value"] = $this->supplier_address->GetDBValue(true);
        $this->InsertFields["supplier_website"]["Value"] = $this->supplier_website->GetDBValue(true);
        $this->InsertFields["supplier_email"]["Value"] = $this->supplier_email->GetDBValue(true);
        $this->InsertFields["supplier_phone"]["Value"] = $this->supplier_phone->GetDBValue(true);
        $this->SQL = CCBuildInsert("tools_suppliers", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @3-CB85D5B2
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "supplier_id=" . $this->ToSQL($this->CachedColumns["supplier_id"], ccsInteger);
        $this->UpdateFields["supplier_source"]["Value"] = $this->supplier_source->GetDBValue(true);
        $this->UpdateFields["supplier_name"]["Value"] = $this->supplier_name->GetDBValue(true);
        $this->UpdateFields["supplier_address"]["Value"] = $this->supplier_address->GetDBValue(true);
        $this->UpdateFields["supplier_website"]["Value"] = $this->supplier_website->GetDBValue(true);
        $this->UpdateFields["supplier_email"]["Value"] = $this->supplier_email->GetDBValue(true);
        $this->UpdateFields["supplier_phone"]["Value"] = $this->supplier_phone->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tools_suppliers", $this->UpdateFields, $this);
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

} //End tools_suppliersDataSource Class @3-FCB6E20C

class clsRecordtools_suppliersSearch { //tools_suppliersSearch Class @4-1FF00293

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

//Class_Initialize Event @4-5AFBC33E
    function clsRecordtools_suppliersSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record tools_suppliersSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "tools_suppliersSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = & new clsButton("Button_DoSearch", $Method, $this);
            $this->s_supplier_name = & new clsControl(ccsTextBox, "s_supplier_name", "s_supplier_name", ccsText, "", CCGetRequestParam("s_supplier_name", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @4-3975BE8E
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_supplier_name->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_supplier_name->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @4-988E8D08
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_supplier_name->Errors->Count());
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

//Operation Method @4-8F013099
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
        $Redirect = "tools_suppliers.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "tools_suppliers.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @4-A302CBCE
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
            $Error = ComposeStrings($Error, $this->s_supplier_name->Errors->ToString());
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
        $this->s_supplier_name->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End tools_suppliersSearch Class @4-FCB6E20C

//Initialize Page @1-FCBC04DC
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
$TemplateFileName = "tools_suppliers.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-67CA2BA9
include_once("./tools_suppliers_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-A7034CBE
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tools_suppliers = & new clsEditableGridtools_suppliers("", $MainPage);
$tools_suppliersSearch = & new clsRecordtools_suppliersSearch("", $MainPage);
$MainPage->tools_suppliers = & $tools_suppliers;
$MainPage->tools_suppliersSearch = & $tools_suppliersSearch;
$tools_suppliers->Initialize();

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

//Execute Components @1-38D2861F
$tools_suppliers->Operation();
$tools_suppliersSearch->Operation();
//End Execute Components

//Go to destination page @1-0B1087B6
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($tools_suppliers);
    unset($tools_suppliersSearch);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-02B22CEB
$tools_suppliers->Show();
$tools_suppliersSearch->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-391DC8F1
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($tools_suppliers);
unset($tools_suppliersSearch);
unset($Tpl);
//End Unload Page


?>
