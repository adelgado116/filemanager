<?php
//Include Common Files @1-B8BB69EA
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page4.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files



class clsGridequipment_model_tbl { //equipment_model_tbl class @70-CAF3B393

//Variables @70-6E51DF5A

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

//Class_Initialize Event @70-D7AD683E
    function clsGridequipment_model_tbl($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "equipment_model_tbl";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid equipment_model_tbl";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsequipment_model_tblDataSource($this);
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

        $this->EQUIP_MODEL = new clsControl(ccsLabel, "EQUIP_MODEL", "EQUIP_MODEL", ccsText, "", CCGetRequestParam("EQUIP_MODEL", ccsGet, NULL), $this);
        $this->extended_info = new clsControl(ccsLabel, "extended_info", "extended_info", ccsText, "", CCGetRequestParam("extended_info", ccsGet, NULL), $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @70-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @70-8138B6E4
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["sesORDER"] = CCGetSession("ORDER", NULL);

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
            $this->ControlsVisible["EQUIP_MODEL"] = $this->EQUIP_MODEL->Visible;
            $this->ControlsVisible["extended_info"] = $this->extended_info->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->EQUIP_MODEL->SetValue($this->DataSource->EQUIP_MODEL->GetValue());
                $this->extended_info->SetValue($this->DataSource->extended_info->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->EQUIP_MODEL->Show();
                $this->extended_info->Show();
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

//GetErrors Method @70-65916296
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->EQUIP_MODEL->Errors->ToString());
        $errors = ComposeStrings($errors, $this->extended_info->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End equipment_model_tbl Class @70-FCB6E20C

class clsequipment_model_tblDataSource extends clsDBhss_db {  //equipment_model_tblDataSource Class @70-E8A52F01

//DataSource Variables @70-6617C905
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $EQUIP_MODEL;
    public $extended_info;
//End DataSource Variables

//DataSourceClass_Initialize Event @70-32A92908
    function clsequipment_model_tblDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid equipment_model_tbl";
        $this->Initialize();
        $this->EQUIP_MODEL = new clsField("EQUIP_MODEL", ccsText, "");
        
        $this->extended_info = new clsField("extended_info", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @70-5599E8C1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "service_items_tbl.ITEM_NO";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @70-A1B06F1B
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "sesORDER", ccsText, "", "", $this->Parameters["sesORDER"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "service_items_tbl.ORDER_NO", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @70-62F7F19F
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM service_items_tbl INNER JOIN equipment_model_tbl ON\n\n" .
        "service_items_tbl.EQUIP_ID = equipment_model_tbl.EQUIP_ID";
        $this->SQL = "SELECT ITEM_NO, EQUIP_MODEL, extended_info \n\n" .
        "FROM service_items_tbl INNER JOIN equipment_model_tbl ON\n\n" .
        "service_items_tbl.EQUIP_ID = equipment_model_tbl.EQUIP_ID {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @70-71426A83
    function SetValues()
    {
        $this->EQUIP_MODEL->SetDBValue($this->f("EQUIP_MODEL"));
        $this->extended_info->SetDBValue($this->f("extended_info"));
    }
//End SetValues Method

} //End equipment_model_tblDataSource Class @70-FCB6E20C

class clsRecordservice_items_tbl1 { //service_items_tbl1 Class @91-F2622B7A

//Variables @91-9E315808

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

//Class_Initialize Event @91-32D5C270
    function clsRecordservice_items_tbl1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record service_items_tbl1/Error";
        $this->DataSource = new clsservice_items_tbl1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "service_items_tbl1";
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
            $this->ORDER_NO = new clsControl(ccsTextBox, "ORDER_NO", "ORDER NO", ccsText, "", CCGetRequestParam("ORDER_NO", $Method, NULL), $this);
            $this->ORDER_NO->Required = true;
            $this->SERVICE_TYPE_ID = new clsControl(ccsListBox, "SERVICE_TYPE_ID", "SERVICE TYPE ID", ccsInteger, "", CCGetRequestParam("SERVICE_TYPE_ID", $Method, NULL), $this);
            $this->SERVICE_TYPE_ID->DSType = dsTable;
            $this->SERVICE_TYPE_ID->DataSource = new clsDBhss_db();
            $this->SERVICE_TYPE_ID->ds = & $this->SERVICE_TYPE_ID->DataSource;
            $this->SERVICE_TYPE_ID->DataSource->SQL = "SELECT * \n" .
"FROM service_type_tbl {SQL_Where} {SQL_OrderBy}";
            $this->SERVICE_TYPE_ID->DataSource->Order = "SERVICE_TYPE";
            list($this->SERVICE_TYPE_ID->BoundColumn, $this->SERVICE_TYPE_ID->TextColumn, $this->SERVICE_TYPE_ID->DBFormat) = array("SERVICE_TYPE_ID", "SERVICE_TYPE", "");
            $this->SERVICE_TYPE_ID->DataSource->Order = "SERVICE_TYPE";
            $this->SERVICE_TYPE_ID->Required = true;
            $this->WARRANTY = new clsControl(ccsCheckBox, "WARRANTY", "WARRANTY", ccsText, "", CCGetRequestParam("WARRANTY", $Method, NULL), $this);
            $this->WARRANTY->CheckedValue = $this->WARRANTY->GetParsedValue(Yes);
            $this->WARRANTY->UncheckedValue = $this->WARRANTY->GetParsedValue(No);
            $this->emp_id = new clsControl(ccsListBox, "emp_id", "Emp Id", ccsInteger, "", CCGetRequestParam("emp_id", $Method, NULL), $this);
            $this->emp_id->DSType = dsTable;
            $this->emp_id->DataSource = new clsDBhss_db();
            $this->emp_id->ds = & $this->emp_id->DataSource;
            $this->emp_id->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            $this->emp_id->DataSource->Order = "emp_login";
            list($this->emp_id->BoundColumn, $this->emp_id->TextColumn, $this->emp_id->DBFormat) = array("emp_id", "emp_login", "");
            $this->emp_id->DataSource->Order = "emp_login";
            $this->emp_id->Required = true;
            $this->REMARKS = new clsControl(ccsTextArea, "REMARKS", "REMARKS", ccsMemo, "", CCGetRequestParam("REMARKS", $Method, NULL), $this);
            $this->ITEM_NO = new clsControl(ccsHidden, "ITEM_NO", "ITEM NO", ccsInteger, "", CCGetRequestParam("ITEM_NO", $Method, NULL), $this);
            $this->EQUIP_ID = new clsControl(ccsHidden, "EQUIP_ID", "EQUIP ID", ccsText, "", CCGetRequestParam("EQUIP_ID", $Method, NULL), $this);
            $this->EQUIP_MODEL = new clsControl(ccsTextBox, "EQUIP_MODEL", "EQUIP_MODEL", ccsText, "", CCGetRequestParam("EQUIP_MODEL", $Method, NULL), $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->REQUEST = new clsControl(ccsTextArea, "REQUEST", "REQUEST", ccsText, "", CCGetRequestParam("REQUEST", $Method, NULL), $this);
            $this->assign_emp_id = new clsControl(ccsListBox, "assign_emp_id", "assign_emp_id", ccsInteger, "", CCGetRequestParam("assign_emp_id", $Method, NULL), $this);
            $this->assign_emp_id->DSType = dsTable;
            $this->assign_emp_id->DataSource = new clsDBhss_db();
            $this->assign_emp_id->ds = & $this->assign_emp_id->DataSource;
            $this->assign_emp_id->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            $this->assign_emp_id->DataSource->Order = "emp_login";
            list($this->assign_emp_id->BoundColumn, $this->assign_emp_id->TextColumn, $this->assign_emp_id->DBFormat) = array("emp_id", "emp_login", "");
            $this->assign_emp_id->DataSource->Order = "emp_login";
            $this->assign_emp_id->Required = true;
            $this->coord_id = new clsControl(ccsListBox, "coord_id", "coord_id", ccsInteger, "", CCGetRequestParam("coord_id", $Method, NULL), $this);
            $this->coord_id->DSType = dsTable;
            $this->coord_id->DataSource = new clsDBhss_db();
            $this->coord_id->ds = & $this->coord_id->DataSource;
            $this->coord_id->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            $this->coord_id->DataSource->Order = "emp_login";
            list($this->coord_id->BoundColumn, $this->coord_id->TextColumn, $this->coord_id->DBFormat) = array("emp_id", "emp_login", "");
            $this->coord_id->DataSource->Order = "emp_login";
            $this->coord_id->Required = true;
            if(!$this->FormSubmitted) {
                if(!is_array($this->WARRANTY->Value) && !strlen($this->WARRANTY->Value) && $this->WARRANTY->Value !== false)
                    $this->WARRANTY->SetValue(false);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @91-61D31D83
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlITEM_NO"] = CCGetFromGet("ITEM_NO", NULL);
    }
//End Initialize Method

//Validate Method @91-CF8F6518
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->ORDER_NO->Validate() && $Validation);
        $Validation = ($this->SERVICE_TYPE_ID->Validate() && $Validation);
        $Validation = ($this->WARRANTY->Validate() && $Validation);
        $Validation = ($this->emp_id->Validate() && $Validation);
        $Validation = ($this->REMARKS->Validate() && $Validation);
        $Validation = ($this->ITEM_NO->Validate() && $Validation);
        $Validation = ($this->EQUIP_ID->Validate() && $Validation);
        $Validation = ($this->EQUIP_MODEL->Validate() && $Validation);
        $Validation = ($this->REQUEST->Validate() && $Validation);
        $Validation = ($this->assign_emp_id->Validate() && $Validation);
        $Validation = ($this->coord_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->ORDER_NO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->SERVICE_TYPE_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->WARRANTY->Errors->Count() == 0);
        $Validation =  $Validation && ($this->emp_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->REMARKS->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ITEM_NO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->EQUIP_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->EQUIP_MODEL->Errors->Count() == 0);
        $Validation =  $Validation && ($this->REQUEST->Errors->Count() == 0);
        $Validation =  $Validation && ($this->assign_emp_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->coord_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @91-C7C7D786
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->ORDER_NO->Errors->Count());
        $errors = ($errors || $this->SERVICE_TYPE_ID->Errors->Count());
        $errors = ($errors || $this->WARRANTY->Errors->Count());
        $errors = ($errors || $this->emp_id->Errors->Count());
        $errors = ($errors || $this->REMARKS->Errors->Count());
        $errors = ($errors || $this->ITEM_NO->Errors->Count());
        $errors = ($errors || $this->EQUIP_ID->Errors->Count());
        $errors = ($errors || $this->EQUIP_MODEL->Errors->Count());
        $errors = ($errors || $this->REQUEST->Errors->Count());
        $errors = ($errors || $this->assign_emp_id->Errors->Count());
        $errors = ($errors || $this->coord_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @91-ED598703
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

//Operation Method @91-829815EF
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
        $Redirect = "page2.php" . "?" . CCGetQueryString("All", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
            $Redirect = "page3.php" . "?" . CCGetQueryString("All", array("ccsForm"));
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

//InsertRow Method @91-BD08CBDA
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->ORDER_NO->SetValue($this->ORDER_NO->GetValue(true));
        $this->DataSource->SERVICE_TYPE_ID->SetValue($this->SERVICE_TYPE_ID->GetValue(true));
        $this->DataSource->WARRANTY->SetValue($this->WARRANTY->GetValue(true));
        $this->DataSource->emp_id->SetValue($this->emp_id->GetValue(true));
        $this->DataSource->REMARKS->SetValue($this->REMARKS->GetValue(true));
        $this->DataSource->ITEM_NO->SetValue($this->ITEM_NO->GetValue(true));
        $this->DataSource->EQUIP_ID->SetValue($this->EQUIP_ID->GetValue(true));
        $this->DataSource->EQUIP_MODEL->SetValue($this->EQUIP_MODEL->GetValue(true));
        $this->DataSource->REQUEST->SetValue($this->REQUEST->GetValue(true));
        $this->DataSource->assign_emp_id->SetValue($this->assign_emp_id->GetValue(true));
        $this->DataSource->coord_id->SetValue($this->coord_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//Show Method @91-46E31A1C
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

        $this->SERVICE_TYPE_ID->Prepare();
        $this->emp_id->Prepare();
        $this->assign_emp_id->Prepare();
        $this->coord_id->Prepare();

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
                    $this->SERVICE_TYPE_ID->SetValue($this->DataSource->SERVICE_TYPE_ID->GetValue());
                    $this->WARRANTY->SetValue($this->DataSource->WARRANTY->GetValue());
                    $this->emp_id->SetValue($this->DataSource->emp_id->GetValue());
                    $this->REMARKS->SetValue($this->DataSource->REMARKS->GetValue());
                    $this->ITEM_NO->SetValue($this->DataSource->ITEM_NO->GetValue());
                    $this->EQUIP_ID->SetValue($this->DataSource->EQUIP_ID->GetValue());
                    $this->REQUEST->SetValue($this->DataSource->REQUEST->GetValue());
                    $this->assign_emp_id->SetValue($this->DataSource->assign_emp_id->GetValue());
                    $this->coord_id->SetValue($this->DataSource->coord_id->GetValue());
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
            $Error = ComposeStrings($Error, $this->SERVICE_TYPE_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->WARRANTY->Errors->ToString());
            $Error = ComposeStrings($Error, $this->emp_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->REMARKS->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ITEM_NO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->EQUIP_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->EQUIP_MODEL->Errors->ToString());
            $Error = ComposeStrings($Error, $this->REQUEST->Errors->ToString());
            $Error = ComposeStrings($Error, $this->assign_emp_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->coord_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        if($this->FormSubmitted || CCGetFromGet("ccsForm")) {
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        } else {
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("All", ""), "ccsForm", $CCSForm);
        }
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
        $this->ORDER_NO->Show();
        $this->SERVICE_TYPE_ID->Show();
        $this->WARRANTY->Show();
        $this->emp_id->Show();
        $this->REMARKS->Show();
        $this->ITEM_NO->Show();
        $this->EQUIP_ID->Show();
        $this->EQUIP_MODEL->Show();
        $this->Button_Cancel->Show();
        $this->REQUEST->Show();
        $this->assign_emp_id->Show();
        $this->coord_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End service_items_tbl1 Class @91-FCB6E20C

class clsservice_items_tbl1DataSource extends clsDBhss_db {  //service_items_tbl1DataSource Class @91-E9D99EE6

//DataSource Variables @91-FA190435
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
    public $SERVICE_TYPE_ID;
    public $WARRANTY;
    public $emp_id;
    public $REMARKS;
    public $ITEM_NO;
    public $EQUIP_ID;
    public $EQUIP_MODEL;
    public $REQUEST;
    public $assign_emp_id;
    public $coord_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @91-8A157E65
    function clsservice_items_tbl1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record service_items_tbl1/Error";
        $this->Initialize();
        $this->ORDER_NO = new clsField("ORDER_NO", ccsText, "");
        
        $this->SERVICE_TYPE_ID = new clsField("SERVICE_TYPE_ID", ccsInteger, "");
        
        $this->WARRANTY = new clsField("WARRANTY", ccsText, "");
        
        $this->emp_id = new clsField("emp_id", ccsInteger, "");
        
        $this->REMARKS = new clsField("REMARKS", ccsMemo, "");
        
        $this->ITEM_NO = new clsField("ITEM_NO", ccsInteger, "");
        
        $this->EQUIP_ID = new clsField("EQUIP_ID", ccsText, "");
        
        $this->EQUIP_MODEL = new clsField("EQUIP_MODEL", ccsText, "");
        
        $this->REQUEST = new clsField("REQUEST", ccsText, "");
        
        $this->assign_emp_id = new clsField("assign_emp_id", ccsInteger, "");
        
        $this->coord_id = new clsField("coord_id", ccsInteger, "");
        

        $this->InsertFields["ORDER_NO"] = array("Name" => "ORDER_NO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["SERVICE_TYPE_ID"] = array("Name" => "SERVICE_TYPE_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["WARRANTY"] = array("Name" => "WARRANTY", "Value" => "", "DataType" => ccsText);
        $this->InsertFields["emp_id"] = array("Name" => "emp_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["REMARKS"] = array("Name" => "REMARKS", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->InsertFields["ITEM_NO"] = array("Name" => "ITEM_NO", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["EQUIP_ID"] = array("Name" => "EQUIP_ID", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["REQUEST"] = array("Name" => "REQUEST", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["assigned_emp_id"] = array("Name" => "assigned_emp_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["coord_id"] = array("Name" => "coord_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @91-8468FC85
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlITEM_NO", ccsInteger, "", "", $this->Parameters["urlITEM_NO"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "ITEM_NO", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @91-EDAA2773
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM service_items_tbl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @91-ADB00CEE
    function SetValues()
    {
        $this->ORDER_NO->SetDBValue($this->f("ORDER_NO"));
        $this->SERVICE_TYPE_ID->SetDBValue(trim($this->f("SERVICE_TYPE_ID")));
        $this->WARRANTY->SetDBValue($this->f("WARRANTY"));
        $this->emp_id->SetDBValue(trim($this->f("emp_id")));
        $this->REMARKS->SetDBValue($this->f("REMARKS"));
        $this->ITEM_NO->SetDBValue(trim($this->f("ITEM_NO")));
        $this->EQUIP_ID->SetDBValue($this->f("EQUIP_ID"));
        $this->REQUEST->SetDBValue($this->f("REQUEST"));
        $this->assign_emp_id->SetDBValue(trim($this->f("assigned_emp_id")));
        $this->coord_id->SetDBValue(trim($this->f("coord_id")));
    }
//End SetValues Method

//Insert Method @91-91A8D2F3
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["ORDER_NO"]["Value"] = $this->ORDER_NO->GetDBValue(true);
        $this->InsertFields["SERVICE_TYPE_ID"]["Value"] = $this->SERVICE_TYPE_ID->GetDBValue(true);
        $this->InsertFields["WARRANTY"]["Value"] = $this->WARRANTY->GetDBValue(true);
        $this->InsertFields["emp_id"]["Value"] = $this->emp_id->GetDBValue(true);
        $this->InsertFields["REMARKS"]["Value"] = $this->REMARKS->GetDBValue(true);
        $this->InsertFields["ITEM_NO"]["Value"] = $this->ITEM_NO->GetDBValue(true);
        $this->InsertFields["EQUIP_ID"]["Value"] = $this->EQUIP_ID->GetDBValue(true);
        $this->InsertFields["REQUEST"]["Value"] = $this->REQUEST->GetDBValue(true);
        $this->InsertFields["assigned_emp_id"]["Value"] = $this->assign_emp_id->GetDBValue(true);
        $this->InsertFields["coord_id"]["Value"] = $this->coord_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("service_items_tbl", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

} //End service_items_tbl1DataSource Class @91-FCB6E20C

class clsRecordservice_type_tbl { //service_type_tbl Class @103-2711561C

//Variables @103-9E315808

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

//Class_Initialize Event @103-A3E2EE3E
    function clsRecordservice_type_tbl($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record service_type_tbl/Error";
        $this->DataSource = new clsservice_type_tblDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "service_type_tbl";
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
            $this->SERVICE_TYPE = new clsControl(ccsTextBox, "SERVICE_TYPE", "SERVICE TYPE", ccsText, "", CCGetRequestParam("SERVICE_TYPE", $Method, NULL), $this);
            $this->SERVICE_TYPE->Required = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @103-04AD5D59
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlSERVICE_TYPE_ID"] = CCGetFromGet("SERVICE_TYPE_ID", NULL);
    }
//End Initialize Method

//Validate Method @103-95D4F348
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->SERVICE_TYPE->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->SERVICE_TYPE->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @103-ABE03D11
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->SERVICE_TYPE->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @103-ED598703
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

//Operation Method @103-EFC50250
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

//InsertRow Method @103-ACEC210B
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->SERVICE_TYPE->SetValue($this->SERVICE_TYPE->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//Show Method @103-68B3C6BC
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
                    $this->SERVICE_TYPE->SetValue($this->DataSource->SERVICE_TYPE->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->SERVICE_TYPE->Errors->ToString());
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
        $this->SERVICE_TYPE->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End service_type_tbl Class @103-FCB6E20C

class clsservice_type_tblDataSource extends clsDBhss_db {  //service_type_tblDataSource Class @103-12D899A0

//DataSource Variables @103-F99C0746
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
    public $SERVICE_TYPE;
//End DataSource Variables

//DataSourceClass_Initialize Event @103-07FBC7DE
    function clsservice_type_tblDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record service_type_tbl/Error";
        $this->Initialize();
        $this->SERVICE_TYPE = new clsField("SERVICE_TYPE", ccsText, "");
        

        $this->InsertFields["SERVICE_TYPE"] = array("Name" => "SERVICE_TYPE", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @103-F048A868
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlSERVICE_TYPE_ID", ccsInteger, "", "", $this->Parameters["urlSERVICE_TYPE_ID"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "SERVICE_TYPE_ID", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @103-124077C6
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM service_type_tbl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @103-1A1FFB13
    function SetValues()
    {
        $this->SERVICE_TYPE->SetDBValue($this->f("SERVICE_TYPE"));
    }
//End SetValues Method

//Insert Method @103-601AF64C
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["SERVICE_TYPE"]["Value"] = $this->SERVICE_TYPE->GetDBValue(true);
        $this->SQL = CCBuildInsert("service_type_tbl", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

} //End service_type_tblDataSource Class @103-FCB6E20C





//Initialize Page @1-0433C093
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
$TemplateFileName = "page4.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-45CC2CA7
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$equipment_model_tbl = new clsGridequipment_model_tbl("", $MainPage);
$service_items_tbl1 = new clsRecordservice_items_tbl1("", $MainPage);
$service_type_tbl = new clsRecordservice_type_tbl("", $MainPage);
$MainPage->equipment_model_tbl = & $equipment_model_tbl;
$MainPage->service_items_tbl1 = & $service_items_tbl1;
$MainPage->service_type_tbl = & $service_type_tbl;
$equipment_model_tbl->Initialize();
$service_items_tbl1->Initialize();
$service_type_tbl->Initialize();

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

//Execute Components @1-46A07996
$service_items_tbl1->Operation();
$service_type_tbl->Operation();
//End Execute Components

//Go to destination page @1-83C78A1C
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($equipment_model_tbl);
    unset($service_items_tbl1);
    unset($service_type_tbl);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-C041DA04
$equipment_model_tbl->Show();
$service_items_tbl1->Show();
$service_type_tbl->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-73C623F8
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($equipment_model_tbl);
unset($service_items_tbl1);
unset($service_type_tbl);
unset($Tpl);
//End Unload Page


?>
