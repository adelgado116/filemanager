<?php
//Include Common Files @1-863B32E1
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page7.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridemployees_tbl_service_don { //employees_tbl_service_don class @4-5A234BE0

//Variables @4-6E51DF5A

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

//Class_Initialize Event @4-BF5D9751
    function clsGridemployees_tbl_service_don($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "employees_tbl_service_don";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid employees_tbl_service_don";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsemployees_tbl_service_donDataSource($this);
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

        $this->SHIP_NAME = new clsControl(ccsLabel, "SHIP_NAME", "SHIP_NAME", ccsText, "", CCGetRequestParam("SHIP_NAME", ccsGet, NULL), $this);
        $this->SERVICE_DATE_DAY = new clsControl(ccsLabel, "SERVICE_DATE_DAY", "SERVICE_DATE_DAY", ccsText, "", CCGetRequestParam("SERVICE_DATE_DAY", ccsGet, NULL), $this);
        $this->EQUIP_MODEL = new clsControl(ccsLabel, "EQUIP_MODEL", "EQUIP_MODEL", ccsText, "", CCGetRequestParam("EQUIP_MODEL", ccsGet, NULL), $this);
        $this->emp_name = new clsControl(ccsLink, "emp_name", "emp_name", ccsText, "", CCGetRequestParam("emp_name", ccsGet, NULL), $this);
        $this->emp_name->Page = "page7.php";
        $this->ORDER_NO = new clsControl(ccsLabel, "ORDER_NO", "ORDER_NO", ccsText, "", CCGetRequestParam("ORDER_NO", ccsGet, NULL), $this);
        $this->SERVICE_DATE_MONTH = new clsControl(ccsLabel, "SERVICE_DATE_MONTH", "SERVICE_DATE_MONTH", ccsText, "", CCGetRequestParam("SERVICE_DATE_MONTH", ccsGet, NULL), $this);
        $this->SERVICE_DATE_YEAR = new clsControl(ccsLabel, "SERVICE_DATE_YEAR", "SERVICE_DATE_YEAR", ccsText, "", CCGetRequestParam("SERVICE_DATE_YEAR", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @4-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @4-E7D243F6
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlORDER_NO"] = CCGetFromGet("ORDER_NO", NULL);
        $this->DataSource->Parameters["urlITEM_NO"] = CCGetFromGet("ITEM_NO", NULL);

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
            $this->ControlsVisible["SHIP_NAME"] = $this->SHIP_NAME->Visible;
            $this->ControlsVisible["SERVICE_DATE_DAY"] = $this->SERVICE_DATE_DAY->Visible;
            $this->ControlsVisible["EQUIP_MODEL"] = $this->EQUIP_MODEL->Visible;
            $this->ControlsVisible["emp_name"] = $this->emp_name->Visible;
            $this->ControlsVisible["ORDER_NO"] = $this->ORDER_NO->Visible;
            $this->ControlsVisible["SERVICE_DATE_MONTH"] = $this->SERVICE_DATE_MONTH->Visible;
            $this->ControlsVisible["SERVICE_DATE_YEAR"] = $this->SERVICE_DATE_YEAR->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->SHIP_NAME->SetValue($this->DataSource->SHIP_NAME->GetValue());
                $this->SERVICE_DATE_DAY->SetValue($this->DataSource->SERVICE_DATE_DAY->GetValue());
                $this->EQUIP_MODEL->SetValue($this->DataSource->EQUIP_MODEL->GetValue());
                $this->emp_name->SetValue($this->DataSource->emp_name->GetValue());
                $this->emp_name->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->emp_name->Parameters = CCAddParam($this->emp_name->Parameters, "ITEM_NO", $this->DataSource->f("ITEM_NO"));
                $this->ORDER_NO->SetValue($this->DataSource->ORDER_NO->GetValue());
                $this->SERVICE_DATE_MONTH->SetValue($this->DataSource->SERVICE_DATE_MONTH->GetValue());
                $this->SERVICE_DATE_YEAR->SetValue($this->DataSource->SERVICE_DATE_YEAR->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->SHIP_NAME->Show();
                $this->SERVICE_DATE_DAY->Show();
                $this->EQUIP_MODEL->Show();
                $this->emp_name->Show();
                $this->ORDER_NO->Show();
                $this->SERVICE_DATE_MONTH->Show();
                $this->SERVICE_DATE_YEAR->Show();
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
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @4-F4BD2D12
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->SHIP_NAME->Errors->ToString());
        $errors = ComposeStrings($errors, $this->SERVICE_DATE_DAY->Errors->ToString());
        $errors = ComposeStrings($errors, $this->EQUIP_MODEL->Errors->ToString());
        $errors = ComposeStrings($errors, $this->emp_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ORDER_NO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->SERVICE_DATE_MONTH->Errors->ToString());
        $errors = ComposeStrings($errors, $this->SERVICE_DATE_YEAR->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End employees_tbl_service_don Class @4-FCB6E20C

class clsemployees_tbl_service_donDataSource extends clsDBhss_db {  //employees_tbl_service_donDataSource Class @4-401E6A93

//DataSource Variables @4-2273968E
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $SHIP_NAME;
    public $SERVICE_DATE_DAY;
    public $EQUIP_MODEL;
    public $emp_name;
    public $ORDER_NO;
    public $SERVICE_DATE_MONTH;
    public $SERVICE_DATE_YEAR;
//End DataSource Variables

//DataSourceClass_Initialize Event @4-7D86106F
    function clsemployees_tbl_service_donDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid employees_tbl_service_don";
        $this->Initialize();
        $this->SHIP_NAME = new clsField("SHIP_NAME", ccsText, "");
        
        $this->SERVICE_DATE_DAY = new clsField("SERVICE_DATE_DAY", ccsText, "");
        
        $this->EQUIP_MODEL = new clsField("EQUIP_MODEL", ccsText, "");
        
        $this->emp_name = new clsField("emp_name", ccsText, "");
        
        $this->ORDER_NO = new clsField("ORDER_NO", ccsText, "");
        
        $this->SERVICE_DATE_MONTH = new clsField("SERVICE_DATE_MONTH", ccsText, "");
        
        $this->SERVICE_DATE_YEAR = new clsField("SERVICE_DATE_YEAR", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @4-96B674A8
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "employees_tbl.emp_name";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @4-389B2199
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlORDER_NO", ccsText, "", "", $this->Parameters["urlORDER_NO"], "", false);
        $this->wp->AddParameter("2", "urlITEM_NO", ccsInteger, "", "", $this->Parameters["urlITEM_NO"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "service_done_by_tbl.ORDER_NO", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "service_done_by_tbl.ITEM_NO", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @4-ABB47BA4
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((((service_tbl INNER JOIN service_done_by_tbl ON\n\n" .
        "service_done_by_tbl.ORDER_NO = service_tbl.ORDER_NO) INNER JOIN ships_tbl ON\n\n" .
        "service_tbl.IMO_NUMBER = ships_tbl.IMO_NUMBER) INNER JOIN employees_tbl ON\n\n" .
        "service_done_by_tbl.emp_id = employees_tbl.emp_id) INNER JOIN service_items_tbl ON\n\n" .
        "service_done_by_tbl.ITEM_NO = service_items_tbl.ITEM_NO) INNER JOIN equipment_model_tbl ON\n\n" .
        "service_items_tbl.EQUIP_ID = equipment_model_tbl.EQUIP_ID";
        $this->SQL = "SELECT service_done_by_tbl.*, service_tbl.IMO_NUMBER AS service_tbl_IMO_NUMBER, SHIP_NAME, emp_name, EQUIP_MODEL, service_items_tbl.EQUIP_ID AS service_items_tbl_EQUIP_ID \n\n" .
        "FROM ((((service_tbl INNER JOIN service_done_by_tbl ON\n\n" .
        "service_done_by_tbl.ORDER_NO = service_tbl.ORDER_NO) INNER JOIN ships_tbl ON\n\n" .
        "service_tbl.IMO_NUMBER = ships_tbl.IMO_NUMBER) INNER JOIN employees_tbl ON\n\n" .
        "service_done_by_tbl.emp_id = employees_tbl.emp_id) INNER JOIN service_items_tbl ON\n\n" .
        "service_done_by_tbl.ITEM_NO = service_items_tbl.ITEM_NO) INNER JOIN equipment_model_tbl ON\n\n" .
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

//SetValues Method @4-A7FACE5F
    function SetValues()
    {
        $this->SHIP_NAME->SetDBValue($this->f("SHIP_NAME"));
        $this->SERVICE_DATE_DAY->SetDBValue($this->f("SERVICE_DATE_DAY"));
        $this->EQUIP_MODEL->SetDBValue($this->f("EQUIP_MODEL"));
        $this->emp_name->SetDBValue($this->f("emp_name"));
        $this->ORDER_NO->SetDBValue($this->f("ORDER_NO"));
        $this->SERVICE_DATE_MONTH->SetDBValue($this->f("SERVICE_DATE_MONTH"));
        $this->SERVICE_DATE_YEAR->SetDBValue($this->f("SERVICE_DATE_YEAR"));
    }
//End SetValues Method

} //End employees_tbl_service_donDataSource Class @4-FCB6E20C

class clsRecordservice_done_by_tbl { //service_done_by_tbl Class @28-892111D3

//Variables @28-9E315808

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

//Class_Initialize Event @28-6A9F5339
    function clsRecordservice_done_by_tbl($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record service_done_by_tbl/Error";
        $this->DataSource = new clsservice_done_by_tblDataSource($this);
        $this->ds = & $this->DataSource;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "service_done_by_tbl";
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
            $this->WORK_TIME_NORMAL = new clsControl(ccsTextBox, "WORK_TIME_NORMAL", "WORK TIME NORMAL", ccsText, "", CCGetRequestParam("WORK_TIME_NORMAL", $Method, NULL), $this);
            $this->WAITED_TIME_NORMAL = new clsControl(ccsTextBox, "WAITED_TIME_NORMAL", "WAITED TIME NORMAL", ccsText, "", CCGetRequestParam("WAITED_TIME_NORMAL", $Method, NULL), $this);
            $this->TRAVEL_TIME_NORMAL = new clsControl(ccsTextBox, "TRAVEL_TIME_NORMAL", "TRAVEL TIME NORMAL", ccsText, "", CCGetRequestParam("TRAVEL_TIME_NORMAL", $Method, NULL), $this);
            $this->NORMAL_DAYS_WORKING = new clsControl(ccsTextBox, "NORMAL_DAYS_WORKING", "NORMAL DAYS WORKING", ccsText, "", CCGetRequestParam("NORMAL_DAYS_WORKING", $Method, NULL), $this);
            $this->NORMAL_DAYS_TRAVELLING = new clsControl(ccsTextBox, "NORMAL_DAYS_TRAVELLING", "NORMAL DAYS TRAVELLING", ccsText, "", CCGetRequestParam("NORMAL_DAYS_TRAVELLING", $Method, NULL), $this);
            $this->NORMAL_DAYS_WAITING = new clsControl(ccsTextBox, "NORMAL_DAYS_WAITING", "NORMAL DAYS WAITING", ccsText, "", CCGetRequestParam("NORMAL_DAYS_WAITING", $Method, NULL), $this);
            $this->WORK_TIME_OVERTIME = new clsControl(ccsTextBox, "WORK_TIME_OVERTIME", "WORK TIME OVERTIME", ccsText, "", CCGetRequestParam("WORK_TIME_OVERTIME", $Method, NULL), $this);
            $this->WAITED_TIME_OVERTIME = new clsControl(ccsTextBox, "WAITED_TIME_OVERTIME", "WAITED TIME OVERTIME", ccsText, "", CCGetRequestParam("WAITED_TIME_OVERTIME", $Method, NULL), $this);
            $this->TRAVEL_TIME_OVERTIME = new clsControl(ccsTextBox, "TRAVEL_TIME_OVERTIME", "TRAVEL TIME OVERTIME", ccsText, "", CCGetRequestParam("TRAVEL_TIME_OVERTIME", $Method, NULL), $this);
            $this->WEEKEND_DAYS_TRAVELLING = new clsControl(ccsTextBox, "WEEKEND_DAYS_TRAVELLING", "WEEKEND DAYS TRAVELLING", ccsText, "", CCGetRequestParam("WEEKEND_DAYS_TRAVELLING", $Method, NULL), $this);
            $this->WEEKEND_DAYS_WAITING = new clsControl(ccsTextBox, "WEEKEND_DAYS_WAITING", "WEEKEND DAYS WAITING", ccsText, "", CCGetRequestParam("WEEKEND_DAYS_WAITING", $Method, NULL), $this);
            $this->WORK_TIME_TECH_NORMAL = new clsControl(ccsTextBox, "WORK_TIME_TECH_NORMAL", "WORK_TIME_TECH_NORMAL", ccsText, "", CCGetRequestParam("WORK_TIME_TECH_NORMAL", $Method, NULL), $this);
            $this->WEEKEND_DAYS_WORKING = new clsControl(ccsTextBox, "WEEKEND_DAYS_WORKING", "WEEKEND DAYS WORKING", ccsText, "", CCGetRequestParam("WEEKEND_DAYS_WORKING", $Method, NULL), $this);
            $this->WAIT_TIME_TECH_NORMAL = new clsControl(ccsTextBox, "WAIT_TIME_TECH_NORMAL", "WAIT_TIME_TECH_NORMAL", ccsText, "", CCGetRequestParam("WAIT_TIME_TECH_NORMAL", $Method, NULL), $this);
            $this->TRAVEL_TIME_TECH_NORMAL = new clsControl(ccsTextBox, "TRAVEL_TIME_TECH_NORMAL", "TRAVEL_TIME_TECH_NORMAL", ccsText, "", CCGetRequestParam("TRAVEL_TIME_TECH_NORMAL", $Method, NULL), $this);
            $this->WORK_TIME_TECH_OVERTIME = new clsControl(ccsTextBox, "WORK_TIME_TECH_OVERTIME", "WORK_TIME_TECH_OVERTIME", ccsText, "", CCGetRequestParam("WORK_TIME_TECH_OVERTIME", $Method, NULL), $this);
            $this->WAIT_TIME_TECH_OVERTIME = new clsControl(ccsTextBox, "WAIT_TIME_TECH_OVERTIME", "WAIT_TIME_TECH_OVERTIME", ccsText, "", CCGetRequestParam("WAIT_TIME_TECH_OVERTIME", $Method, NULL), $this);
            $this->TRAVEL_TIME_TECH_OVERTIME = new clsControl(ccsTextBox, "TRAVEL_TIME_TECH_OVERTIME", "TRAVEL_TIME_TECH_OVERTIME", ccsText, "", CCGetRequestParam("TRAVEL_TIME_TECH_OVERTIME", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->WORK_TIME_NORMAL->Value) && !strlen($this->WORK_TIME_NORMAL->Value) && $this->WORK_TIME_NORMAL->Value !== false)
                    $this->WORK_TIME_NORMAL->SetText(0);
                if(!is_array($this->WAITED_TIME_NORMAL->Value) && !strlen($this->WAITED_TIME_NORMAL->Value) && $this->WAITED_TIME_NORMAL->Value !== false)
                    $this->WAITED_TIME_NORMAL->SetText(0);
                if(!is_array($this->TRAVEL_TIME_NORMAL->Value) && !strlen($this->TRAVEL_TIME_NORMAL->Value) && $this->TRAVEL_TIME_NORMAL->Value !== false)
                    $this->TRAVEL_TIME_NORMAL->SetText(0);
                if(!is_array($this->NORMAL_DAYS_WORKING->Value) && !strlen($this->NORMAL_DAYS_WORKING->Value) && $this->NORMAL_DAYS_WORKING->Value !== false)
                    $this->NORMAL_DAYS_WORKING->SetText(0);
                if(!is_array($this->NORMAL_DAYS_TRAVELLING->Value) && !strlen($this->NORMAL_DAYS_TRAVELLING->Value) && $this->NORMAL_DAYS_TRAVELLING->Value !== false)
                    $this->NORMAL_DAYS_TRAVELLING->SetText(0);
                if(!is_array($this->NORMAL_DAYS_WAITING->Value) && !strlen($this->NORMAL_DAYS_WAITING->Value) && $this->NORMAL_DAYS_WAITING->Value !== false)
                    $this->NORMAL_DAYS_WAITING->SetText(0);
                if(!is_array($this->WORK_TIME_OVERTIME->Value) && !strlen($this->WORK_TIME_OVERTIME->Value) && $this->WORK_TIME_OVERTIME->Value !== false)
                    $this->WORK_TIME_OVERTIME->SetText(0);
                if(!is_array($this->WAITED_TIME_OVERTIME->Value) && !strlen($this->WAITED_TIME_OVERTIME->Value) && $this->WAITED_TIME_OVERTIME->Value !== false)
                    $this->WAITED_TIME_OVERTIME->SetText(0);
                if(!is_array($this->TRAVEL_TIME_OVERTIME->Value) && !strlen($this->TRAVEL_TIME_OVERTIME->Value) && $this->TRAVEL_TIME_OVERTIME->Value !== false)
                    $this->TRAVEL_TIME_OVERTIME->SetText(0);
                if(!is_array($this->WEEKEND_DAYS_TRAVELLING->Value) && !strlen($this->WEEKEND_DAYS_TRAVELLING->Value) && $this->WEEKEND_DAYS_TRAVELLING->Value !== false)
                    $this->WEEKEND_DAYS_TRAVELLING->SetText(0);
                if(!is_array($this->WEEKEND_DAYS_WAITING->Value) && !strlen($this->WEEKEND_DAYS_WAITING->Value) && $this->WEEKEND_DAYS_WAITING->Value !== false)
                    $this->WEEKEND_DAYS_WAITING->SetText(0);
                if(!is_array($this->WEEKEND_DAYS_WORKING->Value) && !strlen($this->WEEKEND_DAYS_WORKING->Value) && $this->WEEKEND_DAYS_WORKING->Value !== false)
                    $this->WEEKEND_DAYS_WORKING->SetText(0);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @28-61D31D83
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlITEM_NO"] = CCGetFromGet("ITEM_NO", NULL);
    }
//End Initialize Method

//Validate Method @28-3A649176
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->WORK_TIME_NORMAL->Validate() && $Validation);
        $Validation = ($this->WAITED_TIME_NORMAL->Validate() && $Validation);
        $Validation = ($this->TRAVEL_TIME_NORMAL->Validate() && $Validation);
        $Validation = ($this->NORMAL_DAYS_WORKING->Validate() && $Validation);
        $Validation = ($this->NORMAL_DAYS_TRAVELLING->Validate() && $Validation);
        $Validation = ($this->NORMAL_DAYS_WAITING->Validate() && $Validation);
        $Validation = ($this->WORK_TIME_OVERTIME->Validate() && $Validation);
        $Validation = ($this->WAITED_TIME_OVERTIME->Validate() && $Validation);
        $Validation = ($this->TRAVEL_TIME_OVERTIME->Validate() && $Validation);
        $Validation = ($this->WEEKEND_DAYS_TRAVELLING->Validate() && $Validation);
        $Validation = ($this->WEEKEND_DAYS_WAITING->Validate() && $Validation);
        $Validation = ($this->WORK_TIME_TECH_NORMAL->Validate() && $Validation);
        $Validation = ($this->WEEKEND_DAYS_WORKING->Validate() && $Validation);
        $Validation = ($this->WAIT_TIME_TECH_NORMAL->Validate() && $Validation);
        $Validation = ($this->TRAVEL_TIME_TECH_NORMAL->Validate() && $Validation);
        $Validation = ($this->WORK_TIME_TECH_OVERTIME->Validate() && $Validation);
        $Validation = ($this->WAIT_TIME_TECH_OVERTIME->Validate() && $Validation);
        $Validation = ($this->TRAVEL_TIME_TECH_OVERTIME->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->WORK_TIME_NORMAL->Errors->Count() == 0);
        $Validation =  $Validation && ($this->WAITED_TIME_NORMAL->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TRAVEL_TIME_NORMAL->Errors->Count() == 0);
        $Validation =  $Validation && ($this->NORMAL_DAYS_WORKING->Errors->Count() == 0);
        $Validation =  $Validation && ($this->NORMAL_DAYS_TRAVELLING->Errors->Count() == 0);
        $Validation =  $Validation && ($this->NORMAL_DAYS_WAITING->Errors->Count() == 0);
        $Validation =  $Validation && ($this->WORK_TIME_OVERTIME->Errors->Count() == 0);
        $Validation =  $Validation && ($this->WAITED_TIME_OVERTIME->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TRAVEL_TIME_OVERTIME->Errors->Count() == 0);
        $Validation =  $Validation && ($this->WEEKEND_DAYS_TRAVELLING->Errors->Count() == 0);
        $Validation =  $Validation && ($this->WEEKEND_DAYS_WAITING->Errors->Count() == 0);
        $Validation =  $Validation && ($this->WORK_TIME_TECH_NORMAL->Errors->Count() == 0);
        $Validation =  $Validation && ($this->WEEKEND_DAYS_WORKING->Errors->Count() == 0);
        $Validation =  $Validation && ($this->WAIT_TIME_TECH_NORMAL->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TRAVEL_TIME_TECH_NORMAL->Errors->Count() == 0);
        $Validation =  $Validation && ($this->WORK_TIME_TECH_OVERTIME->Errors->Count() == 0);
        $Validation =  $Validation && ($this->WAIT_TIME_TECH_OVERTIME->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TRAVEL_TIME_TECH_OVERTIME->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @28-1729D033
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->WORK_TIME_NORMAL->Errors->Count());
        $errors = ($errors || $this->WAITED_TIME_NORMAL->Errors->Count());
        $errors = ($errors || $this->TRAVEL_TIME_NORMAL->Errors->Count());
        $errors = ($errors || $this->NORMAL_DAYS_WORKING->Errors->Count());
        $errors = ($errors || $this->NORMAL_DAYS_TRAVELLING->Errors->Count());
        $errors = ($errors || $this->NORMAL_DAYS_WAITING->Errors->Count());
        $errors = ($errors || $this->WORK_TIME_OVERTIME->Errors->Count());
        $errors = ($errors || $this->WAITED_TIME_OVERTIME->Errors->Count());
        $errors = ($errors || $this->TRAVEL_TIME_OVERTIME->Errors->Count());
        $errors = ($errors || $this->WEEKEND_DAYS_TRAVELLING->Errors->Count());
        $errors = ($errors || $this->WEEKEND_DAYS_WAITING->Errors->Count());
        $errors = ($errors || $this->WORK_TIME_TECH_NORMAL->Errors->Count());
        $errors = ($errors || $this->WEEKEND_DAYS_WORKING->Errors->Count());
        $errors = ($errors || $this->WAIT_TIME_TECH_NORMAL->Errors->Count());
        $errors = ($errors || $this->TRAVEL_TIME_TECH_NORMAL->Errors->Count());
        $errors = ($errors || $this->WORK_TIME_TECH_OVERTIME->Errors->Count());
        $errors = ($errors || $this->WAIT_TIME_TECH_OVERTIME->Errors->Count());
        $errors = ($errors || $this->TRAVEL_TIME_TECH_OVERTIME->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @28-ED598703
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

//Operation Method @28-ED77118B
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
        $Redirect = $FileName . "?" . CCGetQueryString("All", array("ccsForm"));
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

//UpdateRow Method @28-DEA0EC97
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->WORK_TIME_NORMAL->SetValue($this->WORK_TIME_NORMAL->GetValue(true));
        $this->DataSource->WAITED_TIME_NORMAL->SetValue($this->WAITED_TIME_NORMAL->GetValue(true));
        $this->DataSource->TRAVEL_TIME_NORMAL->SetValue($this->TRAVEL_TIME_NORMAL->GetValue(true));
        $this->DataSource->NORMAL_DAYS_WORKING->SetValue($this->NORMAL_DAYS_WORKING->GetValue(true));
        $this->DataSource->NORMAL_DAYS_TRAVELLING->SetValue($this->NORMAL_DAYS_TRAVELLING->GetValue(true));
        $this->DataSource->NORMAL_DAYS_WAITING->SetValue($this->NORMAL_DAYS_WAITING->GetValue(true));
        $this->DataSource->WORK_TIME_OVERTIME->SetValue($this->WORK_TIME_OVERTIME->GetValue(true));
        $this->DataSource->WAITED_TIME_OVERTIME->SetValue($this->WAITED_TIME_OVERTIME->GetValue(true));
        $this->DataSource->TRAVEL_TIME_OVERTIME->SetValue($this->TRAVEL_TIME_OVERTIME->GetValue(true));
        $this->DataSource->WEEKEND_DAYS_TRAVELLING->SetValue($this->WEEKEND_DAYS_TRAVELLING->GetValue(true));
        $this->DataSource->WEEKEND_DAYS_WAITING->SetValue($this->WEEKEND_DAYS_WAITING->GetValue(true));
        $this->DataSource->WORK_TIME_TECH_NORMAL->SetValue($this->WORK_TIME_TECH_NORMAL->GetValue(true));
        $this->DataSource->WEEKEND_DAYS_WORKING->SetValue($this->WEEKEND_DAYS_WORKING->GetValue(true));
        $this->DataSource->WAIT_TIME_TECH_NORMAL->SetValue($this->WAIT_TIME_TECH_NORMAL->GetValue(true));
        $this->DataSource->TRAVEL_TIME_TECH_NORMAL->SetValue($this->TRAVEL_TIME_TECH_NORMAL->GetValue(true));
        $this->DataSource->WORK_TIME_TECH_OVERTIME->SetValue($this->WORK_TIME_TECH_OVERTIME->GetValue(true));
        $this->DataSource->WAIT_TIME_TECH_OVERTIME->SetValue($this->WAIT_TIME_TECH_OVERTIME->GetValue(true));
        $this->DataSource->TRAVEL_TIME_TECH_OVERTIME->SetValue($this->TRAVEL_TIME_TECH_OVERTIME->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @28-CE3683B7
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
                    $this->WORK_TIME_NORMAL->SetValue($this->DataSource->WORK_TIME_NORMAL->GetValue());
                    $this->WAITED_TIME_NORMAL->SetValue($this->DataSource->WAITED_TIME_NORMAL->GetValue());
                    $this->TRAVEL_TIME_NORMAL->SetValue($this->DataSource->TRAVEL_TIME_NORMAL->GetValue());
                    $this->NORMAL_DAYS_WORKING->SetValue($this->DataSource->NORMAL_DAYS_WORKING->GetValue());
                    $this->NORMAL_DAYS_TRAVELLING->SetValue($this->DataSource->NORMAL_DAYS_TRAVELLING->GetValue());
                    $this->NORMAL_DAYS_WAITING->SetValue($this->DataSource->NORMAL_DAYS_WAITING->GetValue());
                    $this->WORK_TIME_OVERTIME->SetValue($this->DataSource->WORK_TIME_OVERTIME->GetValue());
                    $this->WAITED_TIME_OVERTIME->SetValue($this->DataSource->WAITED_TIME_OVERTIME->GetValue());
                    $this->TRAVEL_TIME_OVERTIME->SetValue($this->DataSource->TRAVEL_TIME_OVERTIME->GetValue());
                    $this->WEEKEND_DAYS_TRAVELLING->SetValue($this->DataSource->WEEKEND_DAYS_TRAVELLING->GetValue());
                    $this->WEEKEND_DAYS_WAITING->SetValue($this->DataSource->WEEKEND_DAYS_WAITING->GetValue());
                    $this->WORK_TIME_TECH_NORMAL->SetValue($this->DataSource->WORK_TIME_TECH_NORMAL->GetValue());
                    $this->WEEKEND_DAYS_WORKING->SetValue($this->DataSource->WEEKEND_DAYS_WORKING->GetValue());
                    $this->WAIT_TIME_TECH_NORMAL->SetValue($this->DataSource->WAIT_TIME_TECH_NORMAL->GetValue());
                    $this->TRAVEL_TIME_TECH_NORMAL->SetValue($this->DataSource->TRAVEL_TIME_TECH_NORMAL->GetValue());
                    $this->WORK_TIME_TECH_OVERTIME->SetValue($this->DataSource->WORK_TIME_TECH_OVERTIME->GetValue());
                    $this->WAIT_TIME_TECH_OVERTIME->SetValue($this->DataSource->WAIT_TIME_TECH_OVERTIME->GetValue());
                    $this->TRAVEL_TIME_TECH_OVERTIME->SetValue($this->DataSource->TRAVEL_TIME_TECH_OVERTIME->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->WORK_TIME_NORMAL->Errors->ToString());
            $Error = ComposeStrings($Error, $this->WAITED_TIME_NORMAL->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TRAVEL_TIME_NORMAL->Errors->ToString());
            $Error = ComposeStrings($Error, $this->NORMAL_DAYS_WORKING->Errors->ToString());
            $Error = ComposeStrings($Error, $this->NORMAL_DAYS_TRAVELLING->Errors->ToString());
            $Error = ComposeStrings($Error, $this->NORMAL_DAYS_WAITING->Errors->ToString());
            $Error = ComposeStrings($Error, $this->WORK_TIME_OVERTIME->Errors->ToString());
            $Error = ComposeStrings($Error, $this->WAITED_TIME_OVERTIME->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TRAVEL_TIME_OVERTIME->Errors->ToString());
            $Error = ComposeStrings($Error, $this->WEEKEND_DAYS_TRAVELLING->Errors->ToString());
            $Error = ComposeStrings($Error, $this->WEEKEND_DAYS_WAITING->Errors->ToString());
            $Error = ComposeStrings($Error, $this->WORK_TIME_TECH_NORMAL->Errors->ToString());
            $Error = ComposeStrings($Error, $this->WEEKEND_DAYS_WORKING->Errors->ToString());
            $Error = ComposeStrings($Error, $this->WAIT_TIME_TECH_NORMAL->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TRAVEL_TIME_TECH_NORMAL->Errors->ToString());
            $Error = ComposeStrings($Error, $this->WORK_TIME_TECH_OVERTIME->Errors->ToString());
            $Error = ComposeStrings($Error, $this->WAIT_TIME_TECH_OVERTIME->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TRAVEL_TIME_TECH_OVERTIME->Errors->ToString());
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
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Update->Show();
        $this->WORK_TIME_NORMAL->Show();
        $this->WAITED_TIME_NORMAL->Show();
        $this->TRAVEL_TIME_NORMAL->Show();
        $this->NORMAL_DAYS_WORKING->Show();
        $this->NORMAL_DAYS_TRAVELLING->Show();
        $this->NORMAL_DAYS_WAITING->Show();
        $this->WORK_TIME_OVERTIME->Show();
        $this->WAITED_TIME_OVERTIME->Show();
        $this->TRAVEL_TIME_OVERTIME->Show();
        $this->WEEKEND_DAYS_TRAVELLING->Show();
        $this->WEEKEND_DAYS_WAITING->Show();
        $this->WORK_TIME_TECH_NORMAL->Show();
        $this->WEEKEND_DAYS_WORKING->Show();
        $this->WAIT_TIME_TECH_NORMAL->Show();
        $this->TRAVEL_TIME_TECH_NORMAL->Show();
        $this->WORK_TIME_TECH_OVERTIME->Show();
        $this->WAIT_TIME_TECH_OVERTIME->Show();
        $this->TRAVEL_TIME_TECH_OVERTIME->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End service_done_by_tbl Class @28-FCB6E20C

class clsservice_done_by_tblDataSource extends clsDBhss_db {  //service_done_by_tblDataSource Class @28-E916BD44

//DataSource Variables @28-D973CF6A
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
    public $WORK_TIME_NORMAL;
    public $WAITED_TIME_NORMAL;
    public $TRAVEL_TIME_NORMAL;
    public $NORMAL_DAYS_WORKING;
    public $NORMAL_DAYS_TRAVELLING;
    public $NORMAL_DAYS_WAITING;
    public $WORK_TIME_OVERTIME;
    public $WAITED_TIME_OVERTIME;
    public $TRAVEL_TIME_OVERTIME;
    public $WEEKEND_DAYS_TRAVELLING;
    public $WEEKEND_DAYS_WAITING;
    public $WORK_TIME_TECH_NORMAL;
    public $WEEKEND_DAYS_WORKING;
    public $WAIT_TIME_TECH_NORMAL;
    public $TRAVEL_TIME_TECH_NORMAL;
    public $WORK_TIME_TECH_OVERTIME;
    public $WAIT_TIME_TECH_OVERTIME;
    public $TRAVEL_TIME_TECH_OVERTIME;
//End DataSource Variables

//DataSourceClass_Initialize Event @28-BCEE49E9
    function clsservice_done_by_tblDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record service_done_by_tbl/Error";
        $this->Initialize();
        $this->WORK_TIME_NORMAL = new clsField("WORK_TIME_NORMAL", ccsText, "");
        
        $this->WAITED_TIME_NORMAL = new clsField("WAITED_TIME_NORMAL", ccsText, "");
        
        $this->TRAVEL_TIME_NORMAL = new clsField("TRAVEL_TIME_NORMAL", ccsText, "");
        
        $this->NORMAL_DAYS_WORKING = new clsField("NORMAL_DAYS_WORKING", ccsText, "");
        
        $this->NORMAL_DAYS_TRAVELLING = new clsField("NORMAL_DAYS_TRAVELLING", ccsText, "");
        
        $this->NORMAL_DAYS_WAITING = new clsField("NORMAL_DAYS_WAITING", ccsText, "");
        
        $this->WORK_TIME_OVERTIME = new clsField("WORK_TIME_OVERTIME", ccsText, "");
        
        $this->WAITED_TIME_OVERTIME = new clsField("WAITED_TIME_OVERTIME", ccsText, "");
        
        $this->TRAVEL_TIME_OVERTIME = new clsField("TRAVEL_TIME_OVERTIME", ccsText, "");
        
        $this->WEEKEND_DAYS_TRAVELLING = new clsField("WEEKEND_DAYS_TRAVELLING", ccsText, "");
        
        $this->WEEKEND_DAYS_WAITING = new clsField("WEEKEND_DAYS_WAITING", ccsText, "");
        
        $this->WORK_TIME_TECH_NORMAL = new clsField("WORK_TIME_TECH_NORMAL", ccsText, "");
        
        $this->WEEKEND_DAYS_WORKING = new clsField("WEEKEND_DAYS_WORKING", ccsText, "");
        
        $this->WAIT_TIME_TECH_NORMAL = new clsField("WAIT_TIME_TECH_NORMAL", ccsText, "");
        
        $this->TRAVEL_TIME_TECH_NORMAL = new clsField("TRAVEL_TIME_TECH_NORMAL", ccsText, "");
        
        $this->WORK_TIME_TECH_OVERTIME = new clsField("WORK_TIME_TECH_OVERTIME", ccsText, "");
        
        $this->WAIT_TIME_TECH_OVERTIME = new clsField("WAIT_TIME_TECH_OVERTIME", ccsText, "");
        
        $this->TRAVEL_TIME_TECH_OVERTIME = new clsField("TRAVEL_TIME_TECH_OVERTIME", ccsText, "");
        

        $this->UpdateFields["WORK_TIME_NORMAL"] = array("Name" => "WORK_TIME_NORMAL", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["WAITED_TIME_NORMAL"] = array("Name" => "WAITED_TIME_NORMAL", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["TRAVEL_TIME_NORMAL"] = array("Name" => "TRAVEL_TIME_NORMAL", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["NORMAL_DAYS_WORKING"] = array("Name" => "NORMAL_DAYS_WORKING", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["NORMAL_DAYS_TRAVELLING"] = array("Name" => "NORMAL_DAYS_TRAVELLING", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["NORMAL_DAYS_WAITING"] = array("Name" => "NORMAL_DAYS_WAITING", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["WORK_TIME_OVERTIME"] = array("Name" => "WORK_TIME_OVERTIME", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["WAITED_TIME_OVERTIME"] = array("Name" => "WAITED_TIME_OVERTIME", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["TRAVEL_TIME_OVERTIME"] = array("Name" => "TRAVEL_TIME_OVERTIME", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["WEEKEND_DAYS_TRAVELLING"] = array("Name" => "WEEKEND_DAYS_TRAVELLING", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["WEEKEND_DAYS_WAITING"] = array("Name" => "WEEKEND_DAYS_WAITING", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["WORK_TIME_TECH_NORMAL"] = array("Name" => "WORK_TIME_TECH_NORMAL", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["WEEKEND_DAYS_WORKING"] = array("Name" => "WEEKEND_DAYS_WORKING", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["WAIT_TIME_TECH_NORMAL"] = array("Name" => "WAIT_TIME_TECH_NORMAL", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["TRAVEL_TIME_TECH_NORMAL"] = array("Name" => "TRAVEL_TIME_TECH_NORMAL", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["WORK_TIME_TECH_OVERTIME"] = array("Name" => "WORK_TIME_TECH_OVERTIME", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["WAIT_TIME_TECH_OVERTIME"] = array("Name" => "WAIT_TIME_TECH_OVERTIME", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["TRAVEL_TIME_TECH_OVERTIME"] = array("Name" => "TRAVEL_TIME_TECH_OVERTIME", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @28-8468FC85
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

//Open Method @28-31EB6A55
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM service_done_by_tbl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @28-E9BD43E3
    function SetValues()
    {
        $this->WORK_TIME_NORMAL->SetDBValue($this->f("WORK_TIME_NORMAL"));
        $this->WAITED_TIME_NORMAL->SetDBValue($this->f("WAITED_TIME_NORMAL"));
        $this->TRAVEL_TIME_NORMAL->SetDBValue($this->f("TRAVEL_TIME_NORMAL"));
        $this->NORMAL_DAYS_WORKING->SetDBValue($this->f("NORMAL_DAYS_WORKING"));
        $this->NORMAL_DAYS_TRAVELLING->SetDBValue($this->f("NORMAL_DAYS_TRAVELLING"));
        $this->NORMAL_DAYS_WAITING->SetDBValue($this->f("NORMAL_DAYS_WAITING"));
        $this->WORK_TIME_OVERTIME->SetDBValue($this->f("WORK_TIME_OVERTIME"));
        $this->WAITED_TIME_OVERTIME->SetDBValue($this->f("WAITED_TIME_OVERTIME"));
        $this->TRAVEL_TIME_OVERTIME->SetDBValue($this->f("TRAVEL_TIME_OVERTIME"));
        $this->WEEKEND_DAYS_TRAVELLING->SetDBValue($this->f("WEEKEND_DAYS_TRAVELLING"));
        $this->WEEKEND_DAYS_WAITING->SetDBValue($this->f("WEEKEND_DAYS_WAITING"));
        $this->WORK_TIME_TECH_NORMAL->SetDBValue($this->f("WORK_TIME_TECH_NORMAL"));
        $this->WEEKEND_DAYS_WORKING->SetDBValue($this->f("WEEKEND_DAYS_WORKING"));
        $this->WAIT_TIME_TECH_NORMAL->SetDBValue($this->f("WAIT_TIME_TECH_NORMAL"));
        $this->TRAVEL_TIME_TECH_NORMAL->SetDBValue($this->f("TRAVEL_TIME_TECH_NORMAL"));
        $this->WORK_TIME_TECH_OVERTIME->SetDBValue($this->f("WORK_TIME_TECH_OVERTIME"));
        $this->WAIT_TIME_TECH_OVERTIME->SetDBValue($this->f("WAIT_TIME_TECH_OVERTIME"));
        $this->TRAVEL_TIME_TECH_OVERTIME->SetDBValue($this->f("TRAVEL_TIME_TECH_OVERTIME"));
    }
//End SetValues Method

//Update Method @28-1CC8C3ED
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["WORK_TIME_NORMAL"] = new clsSQLParameter("ctrlWORK_TIME_NORMAL", ccsText, "", "", $this->WORK_TIME_NORMAL->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["WAITED_TIME_NORMAL"] = new clsSQLParameter("ctrlWAITED_TIME_NORMAL", ccsText, "", "", $this->WAITED_TIME_NORMAL->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["TRAVEL_TIME_NORMAL"] = new clsSQLParameter("ctrlTRAVEL_TIME_NORMAL", ccsText, "", "", $this->TRAVEL_TIME_NORMAL->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["NORMAL_DAYS_WORKING"] = new clsSQLParameter("ctrlNORMAL_DAYS_WORKING", ccsText, "", "", $this->NORMAL_DAYS_WORKING->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["NORMAL_DAYS_TRAVELLING"] = new clsSQLParameter("ctrlNORMAL_DAYS_TRAVELLING", ccsText, "", "", $this->NORMAL_DAYS_TRAVELLING->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["NORMAL_DAYS_WAITING"] = new clsSQLParameter("ctrlNORMAL_DAYS_WAITING", ccsText, "", "", $this->NORMAL_DAYS_WAITING->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["WORK_TIME_OVERTIME"] = new clsSQLParameter("ctrlWORK_TIME_OVERTIME", ccsText, "", "", $this->WORK_TIME_OVERTIME->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["WAITED_TIME_OVERTIME"] = new clsSQLParameter("ctrlWAITED_TIME_OVERTIME", ccsText, "", "", $this->WAITED_TIME_OVERTIME->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["TRAVEL_TIME_OVERTIME"] = new clsSQLParameter("ctrlTRAVEL_TIME_OVERTIME", ccsText, "", "", $this->TRAVEL_TIME_OVERTIME->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["WEEKEND_DAYS_TRAVELLING"] = new clsSQLParameter("ctrlWEEKEND_DAYS_TRAVELLING", ccsText, "", "", $this->WEEKEND_DAYS_TRAVELLING->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["WEEKEND_DAYS_WAITING"] = new clsSQLParameter("ctrlWEEKEND_DAYS_WAITING", ccsText, "", "", $this->WEEKEND_DAYS_WAITING->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["WORK_TIME_TECH_NORMAL"] = new clsSQLParameter("ctrlWORK_TIME_TECH_NORMAL", ccsText, "", "", $this->WORK_TIME_TECH_NORMAL->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["WEEKEND_DAYS_WORKING"] = new clsSQLParameter("ctrlWEEKEND_DAYS_WORKING", ccsText, "", "", $this->WEEKEND_DAYS_WORKING->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["WAIT_TIME_TECH_NORMAL"] = new clsSQLParameter("ctrlWAIT_TIME_TECH_NORMAL", ccsText, "", "", $this->WAIT_TIME_TECH_NORMAL->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["TRAVEL_TIME_TECH_NORMAL"] = new clsSQLParameter("ctrlTRAVEL_TIME_TECH_NORMAL", ccsText, "", "", $this->TRAVEL_TIME_TECH_NORMAL->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["WORK_TIME_TECH_OVERTIME"] = new clsSQLParameter("ctrlWORK_TIME_TECH_OVERTIME", ccsText, "", "", $this->WORK_TIME_TECH_OVERTIME->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["WAIT_TIME_TECH_OVERTIME"] = new clsSQLParameter("ctrlWAIT_TIME_TECH_OVERTIME", ccsText, "", "", $this->WAIT_TIME_TECH_OVERTIME->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["TRAVEL_TIME_TECH_OVERTIME"] = new clsSQLParameter("ctrlTRAVEL_TIME_TECH_OVERTIME", ccsText, "", "", $this->TRAVEL_TIME_TECH_OVERTIME->GetValue(true), NULL, false, $this->ErrorBlock);
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "urlITEM_NO", ccsInteger, "", "", CCGetFromGet("ITEM_NO", NULL), "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $wp->AddParameter("2", "urlemp_id", ccsInteger, "", "", CCGetFromGet("emp_id", NULL), "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        if (!is_null($this->cp["WORK_TIME_NORMAL"]->GetValue()) and !strlen($this->cp["WORK_TIME_NORMAL"]->GetText()) and !is_bool($this->cp["WORK_TIME_NORMAL"]->GetValue())) 
            $this->cp["WORK_TIME_NORMAL"]->SetValue($this->WORK_TIME_NORMAL->GetValue(true));
        if (!is_null($this->cp["WAITED_TIME_NORMAL"]->GetValue()) and !strlen($this->cp["WAITED_TIME_NORMAL"]->GetText()) and !is_bool($this->cp["WAITED_TIME_NORMAL"]->GetValue())) 
            $this->cp["WAITED_TIME_NORMAL"]->SetValue($this->WAITED_TIME_NORMAL->GetValue(true));
        if (!is_null($this->cp["TRAVEL_TIME_NORMAL"]->GetValue()) and !strlen($this->cp["TRAVEL_TIME_NORMAL"]->GetText()) and !is_bool($this->cp["TRAVEL_TIME_NORMAL"]->GetValue())) 
            $this->cp["TRAVEL_TIME_NORMAL"]->SetValue($this->TRAVEL_TIME_NORMAL->GetValue(true));
        if (!is_null($this->cp["NORMAL_DAYS_WORKING"]->GetValue()) and !strlen($this->cp["NORMAL_DAYS_WORKING"]->GetText()) and !is_bool($this->cp["NORMAL_DAYS_WORKING"]->GetValue())) 
            $this->cp["NORMAL_DAYS_WORKING"]->SetValue($this->NORMAL_DAYS_WORKING->GetValue(true));
        if (!is_null($this->cp["NORMAL_DAYS_TRAVELLING"]->GetValue()) and !strlen($this->cp["NORMAL_DAYS_TRAVELLING"]->GetText()) and !is_bool($this->cp["NORMAL_DAYS_TRAVELLING"]->GetValue())) 
            $this->cp["NORMAL_DAYS_TRAVELLING"]->SetValue($this->NORMAL_DAYS_TRAVELLING->GetValue(true));
        if (!is_null($this->cp["NORMAL_DAYS_WAITING"]->GetValue()) and !strlen($this->cp["NORMAL_DAYS_WAITING"]->GetText()) and !is_bool($this->cp["NORMAL_DAYS_WAITING"]->GetValue())) 
            $this->cp["NORMAL_DAYS_WAITING"]->SetValue($this->NORMAL_DAYS_WAITING->GetValue(true));
        if (!is_null($this->cp["WORK_TIME_OVERTIME"]->GetValue()) and !strlen($this->cp["WORK_TIME_OVERTIME"]->GetText()) and !is_bool($this->cp["WORK_TIME_OVERTIME"]->GetValue())) 
            $this->cp["WORK_TIME_OVERTIME"]->SetValue($this->WORK_TIME_OVERTIME->GetValue(true));
        if (!is_null($this->cp["WAITED_TIME_OVERTIME"]->GetValue()) and !strlen($this->cp["WAITED_TIME_OVERTIME"]->GetText()) and !is_bool($this->cp["WAITED_TIME_OVERTIME"]->GetValue())) 
            $this->cp["WAITED_TIME_OVERTIME"]->SetValue($this->WAITED_TIME_OVERTIME->GetValue(true));
        if (!is_null($this->cp["TRAVEL_TIME_OVERTIME"]->GetValue()) and !strlen($this->cp["TRAVEL_TIME_OVERTIME"]->GetText()) and !is_bool($this->cp["TRAVEL_TIME_OVERTIME"]->GetValue())) 
            $this->cp["TRAVEL_TIME_OVERTIME"]->SetValue($this->TRAVEL_TIME_OVERTIME->GetValue(true));
        if (!is_null($this->cp["WEEKEND_DAYS_TRAVELLING"]->GetValue()) and !strlen($this->cp["WEEKEND_DAYS_TRAVELLING"]->GetText()) and !is_bool($this->cp["WEEKEND_DAYS_TRAVELLING"]->GetValue())) 
            $this->cp["WEEKEND_DAYS_TRAVELLING"]->SetValue($this->WEEKEND_DAYS_TRAVELLING->GetValue(true));
        if (!is_null($this->cp["WEEKEND_DAYS_WAITING"]->GetValue()) and !strlen($this->cp["WEEKEND_DAYS_WAITING"]->GetText()) and !is_bool($this->cp["WEEKEND_DAYS_WAITING"]->GetValue())) 
            $this->cp["WEEKEND_DAYS_WAITING"]->SetValue($this->WEEKEND_DAYS_WAITING->GetValue(true));
        if (!is_null($this->cp["WORK_TIME_TECH_NORMAL"]->GetValue()) and !strlen($this->cp["WORK_TIME_TECH_NORMAL"]->GetText()) and !is_bool($this->cp["WORK_TIME_TECH_NORMAL"]->GetValue())) 
            $this->cp["WORK_TIME_TECH_NORMAL"]->SetValue($this->WORK_TIME_TECH_NORMAL->GetValue(true));
        if (!is_null($this->cp["WEEKEND_DAYS_WORKING"]->GetValue()) and !strlen($this->cp["WEEKEND_DAYS_WORKING"]->GetText()) and !is_bool($this->cp["WEEKEND_DAYS_WORKING"]->GetValue())) 
            $this->cp["WEEKEND_DAYS_WORKING"]->SetValue($this->WEEKEND_DAYS_WORKING->GetValue(true));
        if (!is_null($this->cp["WAIT_TIME_TECH_NORMAL"]->GetValue()) and !strlen($this->cp["WAIT_TIME_TECH_NORMAL"]->GetText()) and !is_bool($this->cp["WAIT_TIME_TECH_NORMAL"]->GetValue())) 
            $this->cp["WAIT_TIME_TECH_NORMAL"]->SetValue($this->WAIT_TIME_TECH_NORMAL->GetValue(true));
        if (!is_null($this->cp["TRAVEL_TIME_TECH_NORMAL"]->GetValue()) and !strlen($this->cp["TRAVEL_TIME_TECH_NORMAL"]->GetText()) and !is_bool($this->cp["TRAVEL_TIME_TECH_NORMAL"]->GetValue())) 
            $this->cp["TRAVEL_TIME_TECH_NORMAL"]->SetValue($this->TRAVEL_TIME_TECH_NORMAL->GetValue(true));
        if (!is_null($this->cp["WORK_TIME_TECH_OVERTIME"]->GetValue()) and !strlen($this->cp["WORK_TIME_TECH_OVERTIME"]->GetText()) and !is_bool($this->cp["WORK_TIME_TECH_OVERTIME"]->GetValue())) 
            $this->cp["WORK_TIME_TECH_OVERTIME"]->SetValue($this->WORK_TIME_TECH_OVERTIME->GetValue(true));
        if (!is_null($this->cp["WAIT_TIME_TECH_OVERTIME"]->GetValue()) and !strlen($this->cp["WAIT_TIME_TECH_OVERTIME"]->GetText()) and !is_bool($this->cp["WAIT_TIME_TECH_OVERTIME"]->GetValue())) 
            $this->cp["WAIT_TIME_TECH_OVERTIME"]->SetValue($this->WAIT_TIME_TECH_OVERTIME->GetValue(true));
        if (!is_null($this->cp["TRAVEL_TIME_TECH_OVERTIME"]->GetValue()) and !strlen($this->cp["TRAVEL_TIME_TECH_OVERTIME"]->GetText()) and !is_bool($this->cp["TRAVEL_TIME_TECH_OVERTIME"]->GetValue())) 
            $this->cp["TRAVEL_TIME_TECH_OVERTIME"]->SetValue($this->TRAVEL_TIME_TECH_OVERTIME->GetValue(true));
        $wp->Criterion[1] = $wp->Operation(opEqual, "ITEM_NO", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsInteger),false);
        $wp->Criterion[2] = $wp->Operation(opEqual, "emp_id", $wp->GetDBValue("2"), $this->ToSQL($wp->GetDBValue("2"), ccsInteger),false);
        $Where = $wp->opAND(
             false, 
             $wp->Criterion[1], 
             $wp->Criterion[2]);
        $this->UpdateFields["WORK_TIME_NORMAL"]["Value"] = $this->cp["WORK_TIME_NORMAL"]->GetDBValue(true);
        $this->UpdateFields["WAITED_TIME_NORMAL"]["Value"] = $this->cp["WAITED_TIME_NORMAL"]->GetDBValue(true);
        $this->UpdateFields["TRAVEL_TIME_NORMAL"]["Value"] = $this->cp["TRAVEL_TIME_NORMAL"]->GetDBValue(true);
        $this->UpdateFields["NORMAL_DAYS_WORKING"]["Value"] = $this->cp["NORMAL_DAYS_WORKING"]->GetDBValue(true);
        $this->UpdateFields["NORMAL_DAYS_TRAVELLING"]["Value"] = $this->cp["NORMAL_DAYS_TRAVELLING"]->GetDBValue(true);
        $this->UpdateFields["NORMAL_DAYS_WAITING"]["Value"] = $this->cp["NORMAL_DAYS_WAITING"]->GetDBValue(true);
        $this->UpdateFields["WORK_TIME_OVERTIME"]["Value"] = $this->cp["WORK_TIME_OVERTIME"]->GetDBValue(true);
        $this->UpdateFields["WAITED_TIME_OVERTIME"]["Value"] = $this->cp["WAITED_TIME_OVERTIME"]->GetDBValue(true);
        $this->UpdateFields["TRAVEL_TIME_OVERTIME"]["Value"] = $this->cp["TRAVEL_TIME_OVERTIME"]->GetDBValue(true);
        $this->UpdateFields["WEEKEND_DAYS_TRAVELLING"]["Value"] = $this->cp["WEEKEND_DAYS_TRAVELLING"]->GetDBValue(true);
        $this->UpdateFields["WEEKEND_DAYS_WAITING"]["Value"] = $this->cp["WEEKEND_DAYS_WAITING"]->GetDBValue(true);
        $this->UpdateFields["WORK_TIME_TECH_NORMAL"]["Value"] = $this->cp["WORK_TIME_TECH_NORMAL"]->GetDBValue(true);
        $this->UpdateFields["WEEKEND_DAYS_WORKING"]["Value"] = $this->cp["WEEKEND_DAYS_WORKING"]->GetDBValue(true);
        $this->UpdateFields["WAIT_TIME_TECH_NORMAL"]["Value"] = $this->cp["WAIT_TIME_TECH_NORMAL"]->GetDBValue(true);
        $this->UpdateFields["TRAVEL_TIME_TECH_NORMAL"]["Value"] = $this->cp["TRAVEL_TIME_TECH_NORMAL"]->GetDBValue(true);
        $this->UpdateFields["WORK_TIME_TECH_OVERTIME"]["Value"] = $this->cp["WORK_TIME_TECH_OVERTIME"]->GetDBValue(true);
        $this->UpdateFields["WAIT_TIME_TECH_OVERTIME"]["Value"] = $this->cp["WAIT_TIME_TECH_OVERTIME"]->GetDBValue(true);
        $this->UpdateFields["TRAVEL_TIME_TECH_OVERTIME"]["Value"] = $this->cp["TRAVEL_TIME_TECH_OVERTIME"]->GetDBValue(true);
        $this->SQL = CCBuildUpdate("service_done_by_tbl", $this->UpdateFields, $this);
        $this->SQL .= strlen($Where) ? " WHERE " . $Where : $Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End service_done_by_tblDataSource Class @28-FCB6E20C

class clsRecordservice_tbl { //service_tbl Class @53-EED398F1

//Variables @53-9E315808

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

//Class_Initialize Event @53-EA08AF47
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
            if(!$this->FormSubmitted) {
                if(!is_array($this->AGENT_EVAL_TECH->Value) && !strlen($this->AGENT_EVAL_TECH->Value) && $this->AGENT_EVAL_TECH->Value !== false)
                    $this->AGENT_EVAL_TECH->SetText(0);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @53-2954BAE5
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlORDER_NO"] = CCGetFromGet("ORDER_NO", NULL);
    }
//End Initialize Method

//Validate Method @53-034BE86E
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

//CheckErrors Method @53-FAD8D1EE
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

//MasterDetail @53-ED598703
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

//Operation Method @53-517B5C36
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

//UpdateRow Method @53-F64157C5
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

//Show Method @53-D1405782
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

} //End service_tbl Class @53-FCB6E20C

class clsservice_tblDataSource extends clsDBhss_db {  //service_tblDataSource Class @53-3DA74026

//DataSource Variables @53-A83FA798
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

//DataSourceClass_Initialize Event @53-5C73F2DD
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

//Prepare Method @53-1263266B
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

//Open Method @53-4CA0018A
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

//SetValues Method @53-546532C0
    function SetValues()
    {
        $this->AGENT_EVAL_TECH->SetDBValue($this->f("AGENT_EVAL_TECH"));
        $this->RETURN_PARTS_TO->SetDBValue(trim($this->f("RETURN_PARTS_TO")));
        $this->ORDER_PARTS_FROM->SetDBValue(trim($this->f("ORDER_PARTS_FROM")));
    }
//End SetValues Method

//Update Method @53-AB1FDF40
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["AGENT_EVAL_TECH"] = new clsSQLParameter("ctrlAGENT_EVAL_TECH", ccsText, "", "", $this->AGENT_EVAL_TECH->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["RETURN_PARTS_TO"] = new clsSQLParameter("ctrlRETURN_PARTS_TO", ccsInteger, "", "", $this->RETURN_PARTS_TO->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["ORDER_PARTS_FROM"] = new clsSQLParameter("ctrlORDER_PARTS_FROM", ccsInteger, "", "", $this->ORDER_PARTS_FROM->GetValue(true), NULL, false, $this->ErrorBlock);
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "urlORDER_NO", ccsText, "", "", CCGetFromGet("ORDER_NO", NULL), "", false);
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

} //End service_tblDataSource Class @53-FCB6E20C

//Initialize Page @1-B25BCDF8
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
$TemplateFileName = "page7.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-414F824F
include_once("./page7_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-BAB583DB
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Link2 = new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $MainPage);
$Link2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link2->Page = "";
$employees_tbl_service_don = new clsGridemployees_tbl_service_don("", $MainPage);
$service_done_by_tbl = new clsRecordservice_done_by_tbl("", $MainPage);
$service_tbl = new clsRecordservice_tbl("", $MainPage);
$MainPage->Link2 = & $Link2;
$MainPage->employees_tbl_service_don = & $employees_tbl_service_don;
$MainPage->service_done_by_tbl = & $service_done_by_tbl;
$MainPage->service_tbl = & $service_tbl;
$employees_tbl_service_don->Initialize();
$service_done_by_tbl->Initialize();
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

//Execute Components @1-7C4075AA
$service_done_by_tbl->Operation();
$service_tbl->Operation();
//End Execute Components

//Go to destination page @1-2893A834
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($employees_tbl_service_don);
    unset($service_done_by_tbl);
    unset($service_tbl);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-4B4AD49C
$employees_tbl_service_don->Show();
$service_done_by_tbl->Show();
$service_tbl->Show();
$Link2->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-42E05968
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($employees_tbl_service_don);
unset($service_done_by_tbl);
unset($service_tbl);
unset($Tpl);
//End Unload Page


?>
