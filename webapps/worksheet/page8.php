<?php
//Include Common Files @1-42BA05C6
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page8.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsEditableGridafter_service_tbl { //after_service_tbl Class @2-B852AC4A

//Variables @2-002492B3

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
    public $Sorter_ORDER_NO;
    public $Sorter_emp_id;
    public $Sorter_service_date_day;
    public $Sorter_service_date_month;
    public $Sorter_service_date_year;
    public $Sorter_FOLLOW_UP;
    public $Sorter_AGENT_EVAL_TECH;
    public $Sorter_PORT_FEE_ID;
    public $Sorter_NT_INV_WO;
    public $Sorter_NT_INV_WA;
    public $Sorter_NT_INV_TR;
    public $Sorter_NT_TEC_WO;
    public $Sorter_NT_TEC_WA;
    public $Sorter_NT_TEC_TR;
    public $Sorter_OT_INV_WO;
    public $Sorter_OT_INV_WA;
    public $Sorter_OT_INV_TR;
    public $Sorter_OT_TEC_WO;
    public $Sorter_OT_TEC_WA;
    public $Sorter_OT_TEC_TR;
    public $Sorter_ND_WO;
    public $Sorter_ND_WA;
    public $Sorter_ND_TR;
    public $Sorter_WE_WO;
    public $Sorter_WE_WA;
    public $Sorter_WE_TR;
//End Variables

//Class_Initialize Event @2-5B377003
    function clsEditableGridafter_service_tbl($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid after_service_tbl/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "after_service_tbl";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsafter_service_tblDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 15;
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

        $this->SorterName = CCGetParam("after_service_tblOrder", "");
        $this->SorterDirection = CCGetParam("after_service_tblDir", "");

        $this->Sorter_ORDER_NO = new clsSorter($this->ComponentName, "Sorter_ORDER_NO", $FileName, $this);
        $this->Sorter_emp_id = new clsSorter($this->ComponentName, "Sorter_emp_id", $FileName, $this);
        $this->Sorter_service_date_day = new clsSorter($this->ComponentName, "Sorter_service_date_day", $FileName, $this);
        $this->Sorter_service_date_month = new clsSorter($this->ComponentName, "Sorter_service_date_month", $FileName, $this);
        $this->Sorter_service_date_year = new clsSorter($this->ComponentName, "Sorter_service_date_year", $FileName, $this);
        $this->Sorter_FOLLOW_UP = new clsSorter($this->ComponentName, "Sorter_FOLLOW_UP", $FileName, $this);
        $this->Sorter_AGENT_EVAL_TECH = new clsSorter($this->ComponentName, "Sorter_AGENT_EVAL_TECH", $FileName, $this);
        $this->Sorter_PORT_FEE_ID = new clsSorter($this->ComponentName, "Sorter_PORT_FEE_ID", $FileName, $this);
        $this->Sorter_NT_INV_WO = new clsSorter($this->ComponentName, "Sorter_NT_INV_WO", $FileName, $this);
        $this->Sorter_NT_INV_WA = new clsSorter($this->ComponentName, "Sorter_NT_INV_WA", $FileName, $this);
        $this->Sorter_NT_INV_TR = new clsSorter($this->ComponentName, "Sorter_NT_INV_TR", $FileName, $this);
        $this->Sorter_NT_TEC_WO = new clsSorter($this->ComponentName, "Sorter_NT_TEC_WO", $FileName, $this);
        $this->Sorter_NT_TEC_WA = new clsSorter($this->ComponentName, "Sorter_NT_TEC_WA", $FileName, $this);
        $this->Sorter_NT_TEC_TR = new clsSorter($this->ComponentName, "Sorter_NT_TEC_TR", $FileName, $this);
        $this->Sorter_OT_INV_WO = new clsSorter($this->ComponentName, "Sorter_OT_INV_WO", $FileName, $this);
        $this->Sorter_OT_INV_WA = new clsSorter($this->ComponentName, "Sorter_OT_INV_WA", $FileName, $this);
        $this->Sorter_OT_INV_TR = new clsSorter($this->ComponentName, "Sorter_OT_INV_TR", $FileName, $this);
        $this->Sorter_OT_TEC_WO = new clsSorter($this->ComponentName, "Sorter_OT_TEC_WO", $FileName, $this);
        $this->Sorter_OT_TEC_WA = new clsSorter($this->ComponentName, "Sorter_OT_TEC_WA", $FileName, $this);
        $this->Sorter_OT_TEC_TR = new clsSorter($this->ComponentName, "Sorter_OT_TEC_TR", $FileName, $this);
        $this->Sorter_ND_WO = new clsSorter($this->ComponentName, "Sorter_ND_WO", $FileName, $this);
        $this->Sorter_ND_WA = new clsSorter($this->ComponentName, "Sorter_ND_WA", $FileName, $this);
        $this->Sorter_ND_TR = new clsSorter($this->ComponentName, "Sorter_ND_TR", $FileName, $this);
        $this->Sorter_WE_WO = new clsSorter($this->ComponentName, "Sorter_WE_WO", $FileName, $this);
        $this->Sorter_WE_WA = new clsSorter($this->ComponentName, "Sorter_WE_WA", $FileName, $this);
        $this->Sorter_WE_TR = new clsSorter($this->ComponentName, "Sorter_WE_TR", $FileName, $this);
        $this->ORDER_NO = new clsControl(ccsTextBox, "ORDER_NO", "ORDER NO", ccsText, "", NULL, $this);
        $this->ORDER_NO->Required = true;
        $this->emp_id = new clsControl(ccsListBox, "emp_id", "Emp Id", ccsInteger, "", NULL, $this);
        $this->emp_id->DSType = dsTable;
        $this->emp_id->DataSource = new clsDBhss_db();
        $this->emp_id->ds = & $this->emp_id->DataSource;
        $this->emp_id->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
        list($this->emp_id->BoundColumn, $this->emp_id->TextColumn, $this->emp_id->DBFormat) = array("emp_id", "emp_login", "");
        $this->emp_id->Required = true;
        $this->service_date_day = new clsControl(ccsListBox, "service_date_day", "Service Date Day", ccsText, "", NULL, $this);
        $this->service_date_day->DSType = dsTable;
        $this->service_date_day->DataSource = new clsDBhss_db();
        $this->service_date_day->ds = & $this->service_date_day->DataSource;
        $this->service_date_day->DataSource->SQL = "SELECT * \n" .
"FROM days_tbl {SQL_Where} {SQL_OrderBy}";
        list($this->service_date_day->BoundColumn, $this->service_date_day->TextColumn, $this->service_date_day->DBFormat) = array("days", "days", "");
        $this->service_date_day->Required = true;
        $this->service_date_month = new clsControl(ccsListBox, "service_date_month", "Service Date Month", ccsText, "", NULL, $this);
        $this->service_date_month->DSType = dsTable;
        $this->service_date_month->DataSource = new clsDBhss_db();
        $this->service_date_month->ds = & $this->service_date_month->DataSource;
        $this->service_date_month->DataSource->SQL = "SELECT * \n" .
"FROM months_tbl {SQL_Where} {SQL_OrderBy}";
        list($this->service_date_month->BoundColumn, $this->service_date_month->TextColumn, $this->service_date_month->DBFormat) = array("months", "months", "");
        $this->service_date_month->Required = true;
        $this->service_date_year = new clsControl(ccsTextBox, "service_date_year", "Service Date Year", ccsText, "", NULL, $this);
        $this->service_date_year->Required = true;
        $this->FOLLOW_UP = new clsControl(ccsListBox, "FOLLOW_UP", "FOLLOW UP", ccsText, "", NULL, $this);
        $this->FOLLOW_UP->DSType = dsTable;
        $this->FOLLOW_UP->DataSource = new clsDBhss_db();
        $this->FOLLOW_UP->ds = & $this->FOLLOW_UP->DataSource;
        $this->FOLLOW_UP->DataSource->SQL = "SELECT * \n" .
"FROM closed_answer_tbl {SQL_Where} {SQL_OrderBy}";
        list($this->FOLLOW_UP->BoundColumn, $this->FOLLOW_UP->TextColumn, $this->FOLLOW_UP->DBFormat) = array("answer", "answer", "");
        $this->FOLLOW_UP->Required = true;
        $this->AGENT_EVAL_TECH = new clsControl(ccsListBox, "AGENT_EVAL_TECH", "AGENT EVAL TECH", ccsText, "", NULL, $this);
        $this->AGENT_EVAL_TECH->DSType = dsTable;
        $this->AGENT_EVAL_TECH->DataSource = new clsDBhss_db();
        $this->AGENT_EVAL_TECH->ds = & $this->AGENT_EVAL_TECH->DataSource;
        $this->AGENT_EVAL_TECH->DataSource->SQL = "SELECT * \n" .
"FROM evaluation_values_tbl {SQL_Where} {SQL_OrderBy}";
        list($this->AGENT_EVAL_TECH->BoundColumn, $this->AGENT_EVAL_TECH->TextColumn, $this->AGENT_EVAL_TECH->DBFormat) = array("grades", "grades", "");
        $this->AGENT_EVAL_TECH->Required = true;
        $this->PORT_FEE_ID = new clsControl(ccsListBox, "PORT_FEE_ID", "PORT FEE ID", ccsInteger, "", NULL, $this);
        $this->PORT_FEE_ID->DSType = dsTable;
        $this->PORT_FEE_ID->DataSource = new clsDBhss_db();
        $this->PORT_FEE_ID->ds = & $this->PORT_FEE_ID->DataSource;
        $this->PORT_FEE_ID->DataSource->SQL = "SELECT * \n" .
"FROM port_fees_tbl {SQL_Where} {SQL_OrderBy}";
        list($this->PORT_FEE_ID->BoundColumn, $this->PORT_FEE_ID->TextColumn, $this->PORT_FEE_ID->DBFormat) = array("PORT_FEE_ID", "PORT_FEE_VALUE", "");
        $this->PORT_FEE_ID->Required = true;
        $this->NT_INV_WO = new clsControl(ccsTextBox, "NT_INV_WO", "NT INV WO", ccsText, "", NULL, $this);
        $this->NT_INV_WO->Required = true;
        $this->NT_INV_WA = new clsControl(ccsTextBox, "NT_INV_WA", "NT INV WA", ccsText, "", NULL, $this);
        $this->NT_INV_WA->Required = true;
        $this->NT_INV_TR = new clsControl(ccsTextBox, "NT_INV_TR", "NT INV TR", ccsText, "", NULL, $this);
        $this->NT_INV_TR->Required = true;
        $this->NT_TEC_WO = new clsControl(ccsTextBox, "NT_TEC_WO", "NT TEC WO", ccsText, "", NULL, $this);
        $this->NT_TEC_WO->Required = true;
        $this->NT_TEC_WA = new clsControl(ccsTextBox, "NT_TEC_WA", "NT TEC WA", ccsText, "", NULL, $this);
        $this->NT_TEC_WA->Required = true;
        $this->NT_TEC_TR = new clsControl(ccsTextBox, "NT_TEC_TR", "NT TEC TR", ccsText, "", NULL, $this);
        $this->NT_TEC_TR->Required = true;
        $this->OT_INV_WO = new clsControl(ccsTextBox, "OT_INV_WO", "OT INV WO", ccsText, "", NULL, $this);
        $this->OT_INV_WO->Required = true;
        $this->OT_INV_WA = new clsControl(ccsTextBox, "OT_INV_WA", "OT INV WA", ccsText, "", NULL, $this);
        $this->OT_INV_WA->Required = true;
        $this->OT_INV_TR = new clsControl(ccsTextBox, "OT_INV_TR", "OT INV TR", ccsText, "", NULL, $this);
        $this->OT_INV_TR->Required = true;
        $this->OT_TEC_WO = new clsControl(ccsTextBox, "OT_TEC_WO", "OT TEC WO", ccsText, "", NULL, $this);
        $this->OT_TEC_WO->Required = true;
        $this->OT_TEC_WA = new clsControl(ccsTextBox, "OT_TEC_WA", "OT TEC WA", ccsText, "", NULL, $this);
        $this->OT_TEC_WA->Required = true;
        $this->OT_TEC_TR = new clsControl(ccsTextBox, "OT_TEC_TR", "OT TEC TR", ccsText, "", NULL, $this);
        $this->OT_TEC_TR->Required = true;
        $this->ND_WO = new clsControl(ccsTextBox, "ND_WO", "ND WO", ccsText, "", NULL, $this);
        $this->ND_WO->Required = true;
        $this->ND_WA = new clsControl(ccsTextBox, "ND_WA", "ND WA", ccsText, "", NULL, $this);
        $this->ND_WA->Required = true;
        $this->ND_TR = new clsControl(ccsTextBox, "ND_TR", "ND TR", ccsText, "", NULL, $this);
        $this->ND_TR->Required = true;
        $this->WE_WO = new clsControl(ccsTextBox, "WE_WO", "WE WO", ccsText, "", NULL, $this);
        $this->WE_WO->Required = true;
        $this->WE_WA = new clsControl(ccsTextBox, "WE_WA", "WE WA", ccsText, "", NULL, $this);
        $this->WE_WA->Required = true;
        $this->WE_TR = new clsControl(ccsTextBox, "WE_TR", "WE TR", ccsText, "", NULL, $this);
        $this->WE_TR->Required = true;
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->Cancel = new clsButton("Cancel", $Method, $this);
    }
//End Class_Initialize Event

//Initialize Method @2-CF7DF8C7
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urls_ORDER_NO"] = CCGetFromGet("s_ORDER_NO", NULL);
        $this->DataSource->Parameters["urls_emp_id"] = CCGetFromGet("s_emp_id", NULL);
        $this->DataSource->Parameters["urls_service_date_day"] = CCGetFromGet("s_service_date_day", NULL);
        $this->DataSource->Parameters["urls_service_date_month"] = CCGetFromGet("s_service_date_month", NULL);
        $this->DataSource->Parameters["urls_service_date_year"] = CCGetFromGet("s_service_date_year", NULL);
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

//GetFormParameters Method @2-2EEE4CBF
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["ORDER_NO"][$RowNumber] = CCGetFromPost("ORDER_NO_" . $RowNumber, NULL);
            $this->FormParameters["emp_id"][$RowNumber] = CCGetFromPost("emp_id_" . $RowNumber, NULL);
            $this->FormParameters["service_date_day"][$RowNumber] = CCGetFromPost("service_date_day_" . $RowNumber, NULL);
            $this->FormParameters["service_date_month"][$RowNumber] = CCGetFromPost("service_date_month_" . $RowNumber, NULL);
            $this->FormParameters["service_date_year"][$RowNumber] = CCGetFromPost("service_date_year_" . $RowNumber, NULL);
            $this->FormParameters["FOLLOW_UP"][$RowNumber] = CCGetFromPost("FOLLOW_UP_" . $RowNumber, NULL);
            $this->FormParameters["AGENT_EVAL_TECH"][$RowNumber] = CCGetFromPost("AGENT_EVAL_TECH_" . $RowNumber, NULL);
            $this->FormParameters["PORT_FEE_ID"][$RowNumber] = CCGetFromPost("PORT_FEE_ID_" . $RowNumber, NULL);
            $this->FormParameters["NT_INV_WO"][$RowNumber] = CCGetFromPost("NT_INV_WO_" . $RowNumber, NULL);
            $this->FormParameters["NT_INV_WA"][$RowNumber] = CCGetFromPost("NT_INV_WA_" . $RowNumber, NULL);
            $this->FormParameters["NT_INV_TR"][$RowNumber] = CCGetFromPost("NT_INV_TR_" . $RowNumber, NULL);
            $this->FormParameters["NT_TEC_WO"][$RowNumber] = CCGetFromPost("NT_TEC_WO_" . $RowNumber, NULL);
            $this->FormParameters["NT_TEC_WA"][$RowNumber] = CCGetFromPost("NT_TEC_WA_" . $RowNumber, NULL);
            $this->FormParameters["NT_TEC_TR"][$RowNumber] = CCGetFromPost("NT_TEC_TR_" . $RowNumber, NULL);
            $this->FormParameters["OT_INV_WO"][$RowNumber] = CCGetFromPost("OT_INV_WO_" . $RowNumber, NULL);
            $this->FormParameters["OT_INV_WA"][$RowNumber] = CCGetFromPost("OT_INV_WA_" . $RowNumber, NULL);
            $this->FormParameters["OT_INV_TR"][$RowNumber] = CCGetFromPost("OT_INV_TR_" . $RowNumber, NULL);
            $this->FormParameters["OT_TEC_WO"][$RowNumber] = CCGetFromPost("OT_TEC_WO_" . $RowNumber, NULL);
            $this->FormParameters["OT_TEC_WA"][$RowNumber] = CCGetFromPost("OT_TEC_WA_" . $RowNumber, NULL);
            $this->FormParameters["OT_TEC_TR"][$RowNumber] = CCGetFromPost("OT_TEC_TR_" . $RowNumber, NULL);
            $this->FormParameters["ND_WO"][$RowNumber] = CCGetFromPost("ND_WO_" . $RowNumber, NULL);
            $this->FormParameters["ND_WA"][$RowNumber] = CCGetFromPost("ND_WA_" . $RowNumber, NULL);
            $this->FormParameters["ND_TR"][$RowNumber] = CCGetFromPost("ND_TR_" . $RowNumber, NULL);
            $this->FormParameters["WE_WO"][$RowNumber] = CCGetFromPost("WE_WO_" . $RowNumber, NULL);
            $this->FormParameters["WE_WA"][$RowNumber] = CCGetFromPost("WE_WA_" . $RowNumber, NULL);
            $this->FormParameters["WE_TR"][$RowNumber] = CCGetFromPost("WE_TR_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @2-25EE5A40
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->ORDER_NO->SetText($this->FormParameters["ORDER_NO"][$this->RowNumber], $this->RowNumber);
            $this->emp_id->SetText($this->FormParameters["emp_id"][$this->RowNumber], $this->RowNumber);
            $this->service_date_day->SetText($this->FormParameters["service_date_day"][$this->RowNumber], $this->RowNumber);
            $this->service_date_month->SetText($this->FormParameters["service_date_month"][$this->RowNumber], $this->RowNumber);
            $this->service_date_year->SetText($this->FormParameters["service_date_year"][$this->RowNumber], $this->RowNumber);
            $this->FOLLOW_UP->SetText($this->FormParameters["FOLLOW_UP"][$this->RowNumber], $this->RowNumber);
            $this->AGENT_EVAL_TECH->SetText($this->FormParameters["AGENT_EVAL_TECH"][$this->RowNumber], $this->RowNumber);
            $this->PORT_FEE_ID->SetText($this->FormParameters["PORT_FEE_ID"][$this->RowNumber], $this->RowNumber);
            $this->NT_INV_WO->SetText($this->FormParameters["NT_INV_WO"][$this->RowNumber], $this->RowNumber);
            $this->NT_INV_WA->SetText($this->FormParameters["NT_INV_WA"][$this->RowNumber], $this->RowNumber);
            $this->NT_INV_TR->SetText($this->FormParameters["NT_INV_TR"][$this->RowNumber], $this->RowNumber);
            $this->NT_TEC_WO->SetText($this->FormParameters["NT_TEC_WO"][$this->RowNumber], $this->RowNumber);
            $this->NT_TEC_WA->SetText($this->FormParameters["NT_TEC_WA"][$this->RowNumber], $this->RowNumber);
            $this->NT_TEC_TR->SetText($this->FormParameters["NT_TEC_TR"][$this->RowNumber], $this->RowNumber);
            $this->OT_INV_WO->SetText($this->FormParameters["OT_INV_WO"][$this->RowNumber], $this->RowNumber);
            $this->OT_INV_WA->SetText($this->FormParameters["OT_INV_WA"][$this->RowNumber], $this->RowNumber);
            $this->OT_INV_TR->SetText($this->FormParameters["OT_INV_TR"][$this->RowNumber], $this->RowNumber);
            $this->OT_TEC_WO->SetText($this->FormParameters["OT_TEC_WO"][$this->RowNumber], $this->RowNumber);
            $this->OT_TEC_WA->SetText($this->FormParameters["OT_TEC_WA"][$this->RowNumber], $this->RowNumber);
            $this->OT_TEC_TR->SetText($this->FormParameters["OT_TEC_TR"][$this->RowNumber], $this->RowNumber);
            $this->ND_WO->SetText($this->FormParameters["ND_WO"][$this->RowNumber], $this->RowNumber);
            $this->ND_WA->SetText($this->FormParameters["ND_WA"][$this->RowNumber], $this->RowNumber);
            $this->ND_TR->SetText($this->FormParameters["ND_TR"][$this->RowNumber], $this->RowNumber);
            $this->WE_WO->SetText($this->FormParameters["WE_WO"][$this->RowNumber], $this->RowNumber);
            $this->WE_WA->SetText($this->FormParameters["WE_WA"][$this->RowNumber], $this->RowNumber);
            $this->WE_TR->SetText($this->FormParameters["WE_TR"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @2-387C3409
    function ValidateRow()
    {
        global $CCSLocales;
        $this->ORDER_NO->Validate();
        $this->emp_id->Validate();
        $this->service_date_day->Validate();
        $this->service_date_month->Validate();
        $this->service_date_year->Validate();
        $this->FOLLOW_UP->Validate();
        $this->AGENT_EVAL_TECH->Validate();
        $this->PORT_FEE_ID->Validate();
        $this->NT_INV_WO->Validate();
        $this->NT_INV_WA->Validate();
        $this->NT_INV_TR->Validate();
        $this->NT_TEC_WO->Validate();
        $this->NT_TEC_WA->Validate();
        $this->NT_TEC_TR->Validate();
        $this->OT_INV_WO->Validate();
        $this->OT_INV_WA->Validate();
        $this->OT_INV_TR->Validate();
        $this->OT_TEC_WO->Validate();
        $this->OT_TEC_WA->Validate();
        $this->OT_TEC_TR->Validate();
        $this->ND_WO->Validate();
        $this->ND_WA->Validate();
        $this->ND_TR->Validate();
        $this->WE_WO->Validate();
        $this->WE_WA->Validate();
        $this->WE_TR->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->ORDER_NO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->emp_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->service_date_day->Errors->ToString());
        $errors = ComposeStrings($errors, $this->service_date_month->Errors->ToString());
        $errors = ComposeStrings($errors, $this->service_date_year->Errors->ToString());
        $errors = ComposeStrings($errors, $this->FOLLOW_UP->Errors->ToString());
        $errors = ComposeStrings($errors, $this->AGENT_EVAL_TECH->Errors->ToString());
        $errors = ComposeStrings($errors, $this->PORT_FEE_ID->Errors->ToString());
        $errors = ComposeStrings($errors, $this->NT_INV_WO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->NT_INV_WA->Errors->ToString());
        $errors = ComposeStrings($errors, $this->NT_INV_TR->Errors->ToString());
        $errors = ComposeStrings($errors, $this->NT_TEC_WO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->NT_TEC_WA->Errors->ToString());
        $errors = ComposeStrings($errors, $this->NT_TEC_TR->Errors->ToString());
        $errors = ComposeStrings($errors, $this->OT_INV_WO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->OT_INV_WA->Errors->ToString());
        $errors = ComposeStrings($errors, $this->OT_INV_TR->Errors->ToString());
        $errors = ComposeStrings($errors, $this->OT_TEC_WO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->OT_TEC_WA->Errors->ToString());
        $errors = ComposeStrings($errors, $this->OT_TEC_TR->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ND_WO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ND_WA->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ND_TR->Errors->ToString());
        $errors = ComposeStrings($errors, $this->WE_WO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->WE_WA->Errors->ToString());
        $errors = ComposeStrings($errors, $this->WE_TR->Errors->ToString());
        $this->ORDER_NO->Errors->Clear();
        $this->emp_id->Errors->Clear();
        $this->service_date_day->Errors->Clear();
        $this->service_date_month->Errors->Clear();
        $this->service_date_year->Errors->Clear();
        $this->FOLLOW_UP->Errors->Clear();
        $this->AGENT_EVAL_TECH->Errors->Clear();
        $this->PORT_FEE_ID->Errors->Clear();
        $this->NT_INV_WO->Errors->Clear();
        $this->NT_INV_WA->Errors->Clear();
        $this->NT_INV_TR->Errors->Clear();
        $this->NT_TEC_WO->Errors->Clear();
        $this->NT_TEC_WA->Errors->Clear();
        $this->NT_TEC_TR->Errors->Clear();
        $this->OT_INV_WO->Errors->Clear();
        $this->OT_INV_WA->Errors->Clear();
        $this->OT_INV_TR->Errors->Clear();
        $this->OT_TEC_WO->Errors->Clear();
        $this->OT_TEC_WA->Errors->Clear();
        $this->OT_TEC_TR->Errors->Clear();
        $this->ND_WO->Errors->Clear();
        $this->ND_WA->Errors->Clear();
        $this->ND_TR->Errors->Clear();
        $this->WE_WO->Errors->Clear();
        $this->WE_WA->Errors->Clear();
        $this->WE_TR->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @2-96CF7D92
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["ORDER_NO"][$this->RowNumber]) && count($this->FormParameters["ORDER_NO"][$this->RowNumber])) || strlen($this->FormParameters["ORDER_NO"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["emp_id"][$this->RowNumber]) && count($this->FormParameters["emp_id"][$this->RowNumber])) || strlen($this->FormParameters["emp_id"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["service_date_day"][$this->RowNumber]) && count($this->FormParameters["service_date_day"][$this->RowNumber])) || strlen($this->FormParameters["service_date_day"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["service_date_month"][$this->RowNumber]) && count($this->FormParameters["service_date_month"][$this->RowNumber])) || strlen($this->FormParameters["service_date_month"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["service_date_year"][$this->RowNumber]) && count($this->FormParameters["service_date_year"][$this->RowNumber])) || strlen($this->FormParameters["service_date_year"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["FOLLOW_UP"][$this->RowNumber]) && count($this->FormParameters["FOLLOW_UP"][$this->RowNumber])) || strlen($this->FormParameters["FOLLOW_UP"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["AGENT_EVAL_TECH"][$this->RowNumber]) && count($this->FormParameters["AGENT_EVAL_TECH"][$this->RowNumber])) || strlen($this->FormParameters["AGENT_EVAL_TECH"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["PORT_FEE_ID"][$this->RowNumber]) && count($this->FormParameters["PORT_FEE_ID"][$this->RowNumber])) || strlen($this->FormParameters["PORT_FEE_ID"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["NT_INV_WO"][$this->RowNumber]) && count($this->FormParameters["NT_INV_WO"][$this->RowNumber])) || strlen($this->FormParameters["NT_INV_WO"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["NT_INV_WA"][$this->RowNumber]) && count($this->FormParameters["NT_INV_WA"][$this->RowNumber])) || strlen($this->FormParameters["NT_INV_WA"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["NT_INV_TR"][$this->RowNumber]) && count($this->FormParameters["NT_INV_TR"][$this->RowNumber])) || strlen($this->FormParameters["NT_INV_TR"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["NT_TEC_WO"][$this->RowNumber]) && count($this->FormParameters["NT_TEC_WO"][$this->RowNumber])) || strlen($this->FormParameters["NT_TEC_WO"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["NT_TEC_WA"][$this->RowNumber]) && count($this->FormParameters["NT_TEC_WA"][$this->RowNumber])) || strlen($this->FormParameters["NT_TEC_WA"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["NT_TEC_TR"][$this->RowNumber]) && count($this->FormParameters["NT_TEC_TR"][$this->RowNumber])) || strlen($this->FormParameters["NT_TEC_TR"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["OT_INV_WO"][$this->RowNumber]) && count($this->FormParameters["OT_INV_WO"][$this->RowNumber])) || strlen($this->FormParameters["OT_INV_WO"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["OT_INV_WA"][$this->RowNumber]) && count($this->FormParameters["OT_INV_WA"][$this->RowNumber])) || strlen($this->FormParameters["OT_INV_WA"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["OT_INV_TR"][$this->RowNumber]) && count($this->FormParameters["OT_INV_TR"][$this->RowNumber])) || strlen($this->FormParameters["OT_INV_TR"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["OT_TEC_WO"][$this->RowNumber]) && count($this->FormParameters["OT_TEC_WO"][$this->RowNumber])) || strlen($this->FormParameters["OT_TEC_WO"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["OT_TEC_WA"][$this->RowNumber]) && count($this->FormParameters["OT_TEC_WA"][$this->RowNumber])) || strlen($this->FormParameters["OT_TEC_WA"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["OT_TEC_TR"][$this->RowNumber]) && count($this->FormParameters["OT_TEC_TR"][$this->RowNumber])) || strlen($this->FormParameters["OT_TEC_TR"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["ND_WO"][$this->RowNumber]) && count($this->FormParameters["ND_WO"][$this->RowNumber])) || strlen($this->FormParameters["ND_WO"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["ND_WA"][$this->RowNumber]) && count($this->FormParameters["ND_WA"][$this->RowNumber])) || strlen($this->FormParameters["ND_WA"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["ND_TR"][$this->RowNumber]) && count($this->FormParameters["ND_TR"][$this->RowNumber])) || strlen($this->FormParameters["ND_TR"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["WE_WO"][$this->RowNumber]) && count($this->FormParameters["WE_WO"][$this->RowNumber])) || strlen($this->FormParameters["WE_WO"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["WE_WA"][$this->RowNumber]) && count($this->FormParameters["WE_WA"][$this->RowNumber])) || strlen($this->FormParameters["WE_WA"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["WE_TR"][$this->RowNumber]) && count($this->FormParameters["WE_TR"][$this->RowNumber])) || strlen($this->FormParameters["WE_TR"][$this->RowNumber]));
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

//Operation Method @2-6B923CC2
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
        } else if($this->Cancel->Pressed) {
            $this->PressedButton = "Cancel";
        }

        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Submit") {
            if(!CCGetEvent($this->Button_Submit->CCSEvents, "OnClick", $this->Button_Submit) || !$this->UpdateGrid()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Cancel") {
            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick", $this->Cancel)) {
                $Redirect = "";
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateGrid Method @2-617C905C
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->ORDER_NO->SetText($this->FormParameters["ORDER_NO"][$this->RowNumber], $this->RowNumber);
            $this->emp_id->SetText($this->FormParameters["emp_id"][$this->RowNumber], $this->RowNumber);
            $this->service_date_day->SetText($this->FormParameters["service_date_day"][$this->RowNumber], $this->RowNumber);
            $this->service_date_month->SetText($this->FormParameters["service_date_month"][$this->RowNumber], $this->RowNumber);
            $this->service_date_year->SetText($this->FormParameters["service_date_year"][$this->RowNumber], $this->RowNumber);
            $this->FOLLOW_UP->SetText($this->FormParameters["FOLLOW_UP"][$this->RowNumber], $this->RowNumber);
            $this->AGENT_EVAL_TECH->SetText($this->FormParameters["AGENT_EVAL_TECH"][$this->RowNumber], $this->RowNumber);
            $this->PORT_FEE_ID->SetText($this->FormParameters["PORT_FEE_ID"][$this->RowNumber], $this->RowNumber);
            $this->NT_INV_WO->SetText($this->FormParameters["NT_INV_WO"][$this->RowNumber], $this->RowNumber);
            $this->NT_INV_WA->SetText($this->FormParameters["NT_INV_WA"][$this->RowNumber], $this->RowNumber);
            $this->NT_INV_TR->SetText($this->FormParameters["NT_INV_TR"][$this->RowNumber], $this->RowNumber);
            $this->NT_TEC_WO->SetText($this->FormParameters["NT_TEC_WO"][$this->RowNumber], $this->RowNumber);
            $this->NT_TEC_WA->SetText($this->FormParameters["NT_TEC_WA"][$this->RowNumber], $this->RowNumber);
            $this->NT_TEC_TR->SetText($this->FormParameters["NT_TEC_TR"][$this->RowNumber], $this->RowNumber);
            $this->OT_INV_WO->SetText($this->FormParameters["OT_INV_WO"][$this->RowNumber], $this->RowNumber);
            $this->OT_INV_WA->SetText($this->FormParameters["OT_INV_WA"][$this->RowNumber], $this->RowNumber);
            $this->OT_INV_TR->SetText($this->FormParameters["OT_INV_TR"][$this->RowNumber], $this->RowNumber);
            $this->OT_TEC_WO->SetText($this->FormParameters["OT_TEC_WO"][$this->RowNumber], $this->RowNumber);
            $this->OT_TEC_WA->SetText($this->FormParameters["OT_TEC_WA"][$this->RowNumber], $this->RowNumber);
            $this->OT_TEC_TR->SetText($this->FormParameters["OT_TEC_TR"][$this->RowNumber], $this->RowNumber);
            $this->ND_WO->SetText($this->FormParameters["ND_WO"][$this->RowNumber], $this->RowNumber);
            $this->ND_WA->SetText($this->FormParameters["ND_WA"][$this->RowNumber], $this->RowNumber);
            $this->ND_TR->SetText($this->FormParameters["ND_TR"][$this->RowNumber], $this->RowNumber);
            $this->WE_WO->SetText($this->FormParameters["WE_WO"][$this->RowNumber], $this->RowNumber);
            $this->WE_WA->SetText($this->FormParameters["WE_WA"][$this->RowNumber], $this->RowNumber);
            $this->WE_TR->SetText($this->FormParameters["WE_TR"][$this->RowNumber], $this->RowNumber);
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

//InsertRow Method @2-48455B6E
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->ORDER_NO->SetValue($this->ORDER_NO->GetValue(true));
        $this->DataSource->emp_id->SetValue($this->emp_id->GetValue(true));
        $this->DataSource->service_date_day->SetValue($this->service_date_day->GetValue(true));
        $this->DataSource->service_date_month->SetValue($this->service_date_month->GetValue(true));
        $this->DataSource->service_date_year->SetValue($this->service_date_year->GetValue(true));
        $this->DataSource->FOLLOW_UP->SetValue($this->FOLLOW_UP->GetValue(true));
        $this->DataSource->AGENT_EVAL_TECH->SetValue($this->AGENT_EVAL_TECH->GetValue(true));
        $this->DataSource->PORT_FEE_ID->SetValue($this->PORT_FEE_ID->GetValue(true));
        $this->DataSource->NT_INV_WO->SetValue($this->NT_INV_WO->GetValue(true));
        $this->DataSource->NT_INV_WA->SetValue($this->NT_INV_WA->GetValue(true));
        $this->DataSource->NT_INV_TR->SetValue($this->NT_INV_TR->GetValue(true));
        $this->DataSource->NT_TEC_WO->SetValue($this->NT_TEC_WO->GetValue(true));
        $this->DataSource->NT_TEC_WA->SetValue($this->NT_TEC_WA->GetValue(true));
        $this->DataSource->NT_TEC_TR->SetValue($this->NT_TEC_TR->GetValue(true));
        $this->DataSource->OT_INV_WO->SetValue($this->OT_INV_WO->GetValue(true));
        $this->DataSource->OT_INV_WA->SetValue($this->OT_INV_WA->GetValue(true));
        $this->DataSource->OT_INV_TR->SetValue($this->OT_INV_TR->GetValue(true));
        $this->DataSource->OT_TEC_WO->SetValue($this->OT_TEC_WO->GetValue(true));
        $this->DataSource->OT_TEC_WA->SetValue($this->OT_TEC_WA->GetValue(true));
        $this->DataSource->OT_TEC_TR->SetValue($this->OT_TEC_TR->GetValue(true));
        $this->DataSource->ND_WO->SetValue($this->ND_WO->GetValue(true));
        $this->DataSource->ND_WA->SetValue($this->ND_WA->GetValue(true));
        $this->DataSource->ND_TR->SetValue($this->ND_TR->GetValue(true));
        $this->DataSource->WE_WO->SetValue($this->WE_WO->GetValue(true));
        $this->DataSource->WE_WA->SetValue($this->WE_WA->GetValue(true));
        $this->DataSource->WE_TR->SetValue($this->WE_TR->GetValue(true));
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

//UpdateRow Method @2-2B2B905E
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->ORDER_NO->SetValue($this->ORDER_NO->GetValue(true));
        $this->DataSource->emp_id->SetValue($this->emp_id->GetValue(true));
        $this->DataSource->service_date_day->SetValue($this->service_date_day->GetValue(true));
        $this->DataSource->service_date_month->SetValue($this->service_date_month->GetValue(true));
        $this->DataSource->service_date_year->SetValue($this->service_date_year->GetValue(true));
        $this->DataSource->FOLLOW_UP->SetValue($this->FOLLOW_UP->GetValue(true));
        $this->DataSource->AGENT_EVAL_TECH->SetValue($this->AGENT_EVAL_TECH->GetValue(true));
        $this->DataSource->PORT_FEE_ID->SetValue($this->PORT_FEE_ID->GetValue(true));
        $this->DataSource->NT_INV_WO->SetValue($this->NT_INV_WO->GetValue(true));
        $this->DataSource->NT_INV_WA->SetValue($this->NT_INV_WA->GetValue(true));
        $this->DataSource->NT_INV_TR->SetValue($this->NT_INV_TR->GetValue(true));
        $this->DataSource->NT_TEC_WO->SetValue($this->NT_TEC_WO->GetValue(true));
        $this->DataSource->NT_TEC_WA->SetValue($this->NT_TEC_WA->GetValue(true));
        $this->DataSource->NT_TEC_TR->SetValue($this->NT_TEC_TR->GetValue(true));
        $this->DataSource->OT_INV_WO->SetValue($this->OT_INV_WO->GetValue(true));
        $this->DataSource->OT_INV_WA->SetValue($this->OT_INV_WA->GetValue(true));
        $this->DataSource->OT_INV_TR->SetValue($this->OT_INV_TR->GetValue(true));
        $this->DataSource->OT_TEC_WO->SetValue($this->OT_TEC_WO->GetValue(true));
        $this->DataSource->OT_TEC_WA->SetValue($this->OT_TEC_WA->GetValue(true));
        $this->DataSource->OT_TEC_TR->SetValue($this->OT_TEC_TR->GetValue(true));
        $this->DataSource->ND_WO->SetValue($this->ND_WO->GetValue(true));
        $this->DataSource->ND_WA->SetValue($this->ND_WA->GetValue(true));
        $this->DataSource->ND_TR->SetValue($this->ND_TR->GetValue(true));
        $this->DataSource->WE_WO->SetValue($this->WE_WO->GetValue(true));
        $this->DataSource->WE_WA->SetValue($this->WE_WA->GetValue(true));
        $this->DataSource->WE_TR->SetValue($this->WE_TR->GetValue(true));
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

//FormScript Method @2-D2510431
    function FormScript($TotalRows)
    {
        $script = "";
        $script .= "\n<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n";
        $script .= "var after_service_tblElements;\n";
        $script .= "var after_service_tblEmptyRows = 3;\n";
        $script .= "var " . $this->ComponentName . "ORDER_NOID = 0;\n";
        $script .= "var " . $this->ComponentName . "emp_idID = 1;\n";
        $script .= "var " . $this->ComponentName . "service_date_dayID = 2;\n";
        $script .= "var " . $this->ComponentName . "service_date_monthID = 3;\n";
        $script .= "var " . $this->ComponentName . "service_date_yearID = 4;\n";
        $script .= "var " . $this->ComponentName . "FOLLOW_UPID = 5;\n";
        $script .= "var " . $this->ComponentName . "AGENT_EVAL_TECHID = 6;\n";
        $script .= "var " . $this->ComponentName . "PORT_FEE_IDID = 7;\n";
        $script .= "var " . $this->ComponentName . "NT_INV_WOID = 8;\n";
        $script .= "var " . $this->ComponentName . "NT_INV_WAID = 9;\n";
        $script .= "var " . $this->ComponentName . "NT_INV_TRID = 10;\n";
        $script .= "var " . $this->ComponentName . "NT_TEC_WOID = 11;\n";
        $script .= "var " . $this->ComponentName . "NT_TEC_WAID = 12;\n";
        $script .= "var " . $this->ComponentName . "NT_TEC_TRID = 13;\n";
        $script .= "var " . $this->ComponentName . "OT_INV_WOID = 14;\n";
        $script .= "var " . $this->ComponentName . "OT_INV_WAID = 15;\n";
        $script .= "var " . $this->ComponentName . "OT_INV_TRID = 16;\n";
        $script .= "var " . $this->ComponentName . "OT_TEC_WOID = 17;\n";
        $script .= "var " . $this->ComponentName . "OT_TEC_WAID = 18;\n";
        $script .= "var " . $this->ComponentName . "OT_TEC_TRID = 19;\n";
        $script .= "var " . $this->ComponentName . "ND_WOID = 20;\n";
        $script .= "var " . $this->ComponentName . "ND_WAID = 21;\n";
        $script .= "var " . $this->ComponentName . "ND_TRID = 22;\n";
        $script .= "var " . $this->ComponentName . "WE_WOID = 23;\n";
        $script .= "var " . $this->ComponentName . "WE_WAID = 24;\n";
        $script .= "var " . $this->ComponentName . "WE_TRID = 25;\n";
        $script .= "\nfunction initafter_service_tblElements() {\n";
        $script .= "\tvar ED = document.forms[\"after_service_tbl\"];\n";
        $script .= "\tafter_service_tblElements = new Array (\n";
        for($i = 1; $i <= $TotalRows; $i++) {
            $script .= "\t\tnew Array(" . "ED.ORDER_NO_" . $i . ", " . "ED.emp_id_" . $i . ", " . "ED.service_date_day_" . $i . ", " . "ED.service_date_month_" . $i . ", " . "ED.service_date_year_" . $i . ", " . "ED.FOLLOW_UP_" . $i . ", " . "ED.AGENT_EVAL_TECH_" . $i . ", " . "ED.PORT_FEE_ID_" . $i . ", " . "ED.NT_INV_WO_" . $i . ", " . "ED.NT_INV_WA_" . $i . ", " . "ED.NT_INV_TR_" . $i . ", " . "ED.NT_TEC_WO_" . $i . ", " . "ED.NT_TEC_WA_" . $i . ", " . "ED.NT_TEC_TR_" . $i . ", " . "ED.OT_INV_WO_" . $i . ", " . "ED.OT_INV_WA_" . $i . ", " . "ED.OT_INV_TR_" . $i . ", " . "ED.OT_TEC_WO_" . $i . ", " . "ED.OT_TEC_WA_" . $i . ", " . "ED.OT_TEC_TR_" . $i . ", " . "ED.ND_WO_" . $i . ", " . "ED.ND_WA_" . $i . ", " . "ED.ND_TR_" . $i . ", " . "ED.WE_WO_" . $i . ", " . "ED.WE_WA_" . $i . ", " . "ED.WE_TR_" . $i . ")";
            if($i != $TotalRows) $script .= ",\n";
        }
        $script .= ");\n";
        $script .= "}\n";
        $script .= "\n//-->\n</script>";
        return $script;
    }
//End FormScript Method

//SetFormState Method @2-69E01441
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
            for($i = 2; $i < sizeof($pieces); $i = $i + 0)  {
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @2-BF9CEBD0
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @2-FA1B4F8A
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->emp_id->Prepare();
        $this->service_date_day->Prepare();
        $this->service_date_month->Prepare();
        $this->FOLLOW_UP->Prepare();
        $this->AGENT_EVAL_TECH->Prepare();
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
        $this->ControlsVisible["ORDER_NO"] = $this->ORDER_NO->Visible;
        $this->ControlsVisible["emp_id"] = $this->emp_id->Visible;
        $this->ControlsVisible["service_date_day"] = $this->service_date_day->Visible;
        $this->ControlsVisible["service_date_month"] = $this->service_date_month->Visible;
        $this->ControlsVisible["service_date_year"] = $this->service_date_year->Visible;
        $this->ControlsVisible["FOLLOW_UP"] = $this->FOLLOW_UP->Visible;
        $this->ControlsVisible["AGENT_EVAL_TECH"] = $this->AGENT_EVAL_TECH->Visible;
        $this->ControlsVisible["PORT_FEE_ID"] = $this->PORT_FEE_ID->Visible;
        $this->ControlsVisible["NT_INV_WO"] = $this->NT_INV_WO->Visible;
        $this->ControlsVisible["NT_INV_WA"] = $this->NT_INV_WA->Visible;
        $this->ControlsVisible["NT_INV_TR"] = $this->NT_INV_TR->Visible;
        $this->ControlsVisible["NT_TEC_WO"] = $this->NT_TEC_WO->Visible;
        $this->ControlsVisible["NT_TEC_WA"] = $this->NT_TEC_WA->Visible;
        $this->ControlsVisible["NT_TEC_TR"] = $this->NT_TEC_TR->Visible;
        $this->ControlsVisible["OT_INV_WO"] = $this->OT_INV_WO->Visible;
        $this->ControlsVisible["OT_INV_WA"] = $this->OT_INV_WA->Visible;
        $this->ControlsVisible["OT_INV_TR"] = $this->OT_INV_TR->Visible;
        $this->ControlsVisible["OT_TEC_WO"] = $this->OT_TEC_WO->Visible;
        $this->ControlsVisible["OT_TEC_WA"] = $this->OT_TEC_WA->Visible;
        $this->ControlsVisible["OT_TEC_TR"] = $this->OT_TEC_TR->Visible;
        $this->ControlsVisible["ND_WO"] = $this->ND_WO->Visible;
        $this->ControlsVisible["ND_WA"] = $this->ND_WA->Visible;
        $this->ControlsVisible["ND_TR"] = $this->ND_TR->Visible;
        $this->ControlsVisible["WE_WO"] = $this->WE_WO->Visible;
        $this->ControlsVisible["WE_WA"] = $this->WE_WA->Visible;
        $this->ControlsVisible["WE_TR"] = $this->WE_TR->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->ORDER_NO->SetValue($this->DataSource->ORDER_NO->GetValue());
                    $this->emp_id->SetValue($this->DataSource->emp_id->GetValue());
                    $this->service_date_day->SetValue($this->DataSource->service_date_day->GetValue());
                    $this->service_date_month->SetValue($this->DataSource->service_date_month->GetValue());
                    $this->service_date_year->SetValue($this->DataSource->service_date_year->GetValue());
                    $this->FOLLOW_UP->SetValue($this->DataSource->FOLLOW_UP->GetValue());
                    $this->AGENT_EVAL_TECH->SetValue($this->DataSource->AGENT_EVAL_TECH->GetValue());
                    $this->PORT_FEE_ID->SetValue($this->DataSource->PORT_FEE_ID->GetValue());
                    $this->NT_INV_WO->SetValue($this->DataSource->NT_INV_WO->GetValue());
                    $this->NT_INV_WA->SetValue($this->DataSource->NT_INV_WA->GetValue());
                    $this->NT_INV_TR->SetValue($this->DataSource->NT_INV_TR->GetValue());
                    $this->NT_TEC_WO->SetValue($this->DataSource->NT_TEC_WO->GetValue());
                    $this->NT_TEC_WA->SetValue($this->DataSource->NT_TEC_WA->GetValue());
                    $this->NT_TEC_TR->SetValue($this->DataSource->NT_TEC_TR->GetValue());
                    $this->OT_INV_WO->SetValue($this->DataSource->OT_INV_WO->GetValue());
                    $this->OT_INV_WA->SetValue($this->DataSource->OT_INV_WA->GetValue());
                    $this->OT_INV_TR->SetValue($this->DataSource->OT_INV_TR->GetValue());
                    $this->OT_TEC_WO->SetValue($this->DataSource->OT_TEC_WO->GetValue());
                    $this->OT_TEC_WA->SetValue($this->DataSource->OT_TEC_WA->GetValue());
                    $this->OT_TEC_TR->SetValue($this->DataSource->OT_TEC_TR->GetValue());
                    $this->ND_WO->SetValue($this->DataSource->ND_WO->GetValue());
                    $this->ND_WA->SetValue($this->DataSource->ND_WA->GetValue());
                    $this->ND_TR->SetValue($this->DataSource->ND_TR->GetValue());
                    $this->WE_WO->SetValue($this->DataSource->WE_WO->GetValue());
                    $this->WE_WA->SetValue($this->DataSource->WE_WA->GetValue());
                    $this->WE_TR->SetValue($this->DataSource->WE_TR->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->ORDER_NO->SetText($this->FormParameters["ORDER_NO"][$this->RowNumber], $this->RowNumber);
                    $this->emp_id->SetText($this->FormParameters["emp_id"][$this->RowNumber], $this->RowNumber);
                    $this->service_date_day->SetText($this->FormParameters["service_date_day"][$this->RowNumber], $this->RowNumber);
                    $this->service_date_month->SetText($this->FormParameters["service_date_month"][$this->RowNumber], $this->RowNumber);
                    $this->service_date_year->SetText($this->FormParameters["service_date_year"][$this->RowNumber], $this->RowNumber);
                    $this->FOLLOW_UP->SetText($this->FormParameters["FOLLOW_UP"][$this->RowNumber], $this->RowNumber);
                    $this->AGENT_EVAL_TECH->SetText($this->FormParameters["AGENT_EVAL_TECH"][$this->RowNumber], $this->RowNumber);
                    $this->PORT_FEE_ID->SetText($this->FormParameters["PORT_FEE_ID"][$this->RowNumber], $this->RowNumber);
                    $this->NT_INV_WO->SetText($this->FormParameters["NT_INV_WO"][$this->RowNumber], $this->RowNumber);
                    $this->NT_INV_WA->SetText($this->FormParameters["NT_INV_WA"][$this->RowNumber], $this->RowNumber);
                    $this->NT_INV_TR->SetText($this->FormParameters["NT_INV_TR"][$this->RowNumber], $this->RowNumber);
                    $this->NT_TEC_WO->SetText($this->FormParameters["NT_TEC_WO"][$this->RowNumber], $this->RowNumber);
                    $this->NT_TEC_WA->SetText($this->FormParameters["NT_TEC_WA"][$this->RowNumber], $this->RowNumber);
                    $this->NT_TEC_TR->SetText($this->FormParameters["NT_TEC_TR"][$this->RowNumber], $this->RowNumber);
                    $this->OT_INV_WO->SetText($this->FormParameters["OT_INV_WO"][$this->RowNumber], $this->RowNumber);
                    $this->OT_INV_WA->SetText($this->FormParameters["OT_INV_WA"][$this->RowNumber], $this->RowNumber);
                    $this->OT_INV_TR->SetText($this->FormParameters["OT_INV_TR"][$this->RowNumber], $this->RowNumber);
                    $this->OT_TEC_WO->SetText($this->FormParameters["OT_TEC_WO"][$this->RowNumber], $this->RowNumber);
                    $this->OT_TEC_WA->SetText($this->FormParameters["OT_TEC_WA"][$this->RowNumber], $this->RowNumber);
                    $this->OT_TEC_TR->SetText($this->FormParameters["OT_TEC_TR"][$this->RowNumber], $this->RowNumber);
                    $this->ND_WO->SetText($this->FormParameters["ND_WO"][$this->RowNumber], $this->RowNumber);
                    $this->ND_WA->SetText($this->FormParameters["ND_WA"][$this->RowNumber], $this->RowNumber);
                    $this->ND_TR->SetText($this->FormParameters["ND_TR"][$this->RowNumber], $this->RowNumber);
                    $this->WE_WO->SetText($this->FormParameters["WE_WO"][$this->RowNumber], $this->RowNumber);
                    $this->WE_WA->SetText($this->FormParameters["WE_WA"][$this->RowNumber], $this->RowNumber);
                    $this->WE_TR->SetText($this->FormParameters["WE_TR"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->ORDER_NO->SetText("");
                    $this->emp_id->SetText("");
                    $this->service_date_day->SetText("");
                    $this->service_date_month->SetText("");
                    $this->service_date_year->SetText("");
                    $this->FOLLOW_UP->SetText("");
                    $this->AGENT_EVAL_TECH->SetText("");
                    $this->PORT_FEE_ID->SetText("");
                    $this->NT_INV_WO->SetText("");
                    $this->NT_INV_WA->SetText("");
                    $this->NT_INV_TR->SetText("");
                    $this->NT_TEC_WO->SetText("");
                    $this->NT_TEC_WA->SetText("");
                    $this->NT_TEC_TR->SetText("");
                    $this->OT_INV_WO->SetText("");
                    $this->OT_INV_WA->SetText("");
                    $this->OT_INV_TR->SetText("");
                    $this->OT_TEC_WO->SetText("");
                    $this->OT_TEC_WA->SetText("");
                    $this->OT_TEC_TR->SetText("");
                    $this->ND_WO->SetText("");
                    $this->ND_WA->SetText("");
                    $this->ND_TR->SetText("");
                    $this->WE_WO->SetText("");
                    $this->WE_WA->SetText("");
                    $this->WE_TR->SetText("");
                } else {
                    $this->ORDER_NO->SetText($this->FormParameters["ORDER_NO"][$this->RowNumber], $this->RowNumber);
                    $this->emp_id->SetText($this->FormParameters["emp_id"][$this->RowNumber], $this->RowNumber);
                    $this->service_date_day->SetText($this->FormParameters["service_date_day"][$this->RowNumber], $this->RowNumber);
                    $this->service_date_month->SetText($this->FormParameters["service_date_month"][$this->RowNumber], $this->RowNumber);
                    $this->service_date_year->SetText($this->FormParameters["service_date_year"][$this->RowNumber], $this->RowNumber);
                    $this->FOLLOW_UP->SetText($this->FormParameters["FOLLOW_UP"][$this->RowNumber], $this->RowNumber);
                    $this->AGENT_EVAL_TECH->SetText($this->FormParameters["AGENT_EVAL_TECH"][$this->RowNumber], $this->RowNumber);
                    $this->PORT_FEE_ID->SetText($this->FormParameters["PORT_FEE_ID"][$this->RowNumber], $this->RowNumber);
                    $this->NT_INV_WO->SetText($this->FormParameters["NT_INV_WO"][$this->RowNumber], $this->RowNumber);
                    $this->NT_INV_WA->SetText($this->FormParameters["NT_INV_WA"][$this->RowNumber], $this->RowNumber);
                    $this->NT_INV_TR->SetText($this->FormParameters["NT_INV_TR"][$this->RowNumber], $this->RowNumber);
                    $this->NT_TEC_WO->SetText($this->FormParameters["NT_TEC_WO"][$this->RowNumber], $this->RowNumber);
                    $this->NT_TEC_WA->SetText($this->FormParameters["NT_TEC_WA"][$this->RowNumber], $this->RowNumber);
                    $this->NT_TEC_TR->SetText($this->FormParameters["NT_TEC_TR"][$this->RowNumber], $this->RowNumber);
                    $this->OT_INV_WO->SetText($this->FormParameters["OT_INV_WO"][$this->RowNumber], $this->RowNumber);
                    $this->OT_INV_WA->SetText($this->FormParameters["OT_INV_WA"][$this->RowNumber], $this->RowNumber);
                    $this->OT_INV_TR->SetText($this->FormParameters["OT_INV_TR"][$this->RowNumber], $this->RowNumber);
                    $this->OT_TEC_WO->SetText($this->FormParameters["OT_TEC_WO"][$this->RowNumber], $this->RowNumber);
                    $this->OT_TEC_WA->SetText($this->FormParameters["OT_TEC_WA"][$this->RowNumber], $this->RowNumber);
                    $this->OT_TEC_TR->SetText($this->FormParameters["OT_TEC_TR"][$this->RowNumber], $this->RowNumber);
                    $this->ND_WO->SetText($this->FormParameters["ND_WO"][$this->RowNumber], $this->RowNumber);
                    $this->ND_WA->SetText($this->FormParameters["ND_WA"][$this->RowNumber], $this->RowNumber);
                    $this->ND_TR->SetText($this->FormParameters["ND_TR"][$this->RowNumber], $this->RowNumber);
                    $this->WE_WO->SetText($this->FormParameters["WE_WO"][$this->RowNumber], $this->RowNumber);
                    $this->WE_WA->SetText($this->FormParameters["WE_WA"][$this->RowNumber], $this->RowNumber);
                    $this->WE_TR->SetText($this->FormParameters["WE_TR"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->ORDER_NO->Show($this->RowNumber);
                $this->emp_id->Show($this->RowNumber);
                $this->service_date_day->Show($this->RowNumber);
                $this->service_date_month->Show($this->RowNumber);
                $this->service_date_year->Show($this->RowNumber);
                $this->FOLLOW_UP->Show($this->RowNumber);
                $this->AGENT_EVAL_TECH->Show($this->RowNumber);
                $this->PORT_FEE_ID->Show($this->RowNumber);
                $this->NT_INV_WO->Show($this->RowNumber);
                $this->NT_INV_WA->Show($this->RowNumber);
                $this->NT_INV_TR->Show($this->RowNumber);
                $this->NT_TEC_WO->Show($this->RowNumber);
                $this->NT_TEC_WA->Show($this->RowNumber);
                $this->NT_TEC_TR->Show($this->RowNumber);
                $this->OT_INV_WO->Show($this->RowNumber);
                $this->OT_INV_WA->Show($this->RowNumber);
                $this->OT_INV_TR->Show($this->RowNumber);
                $this->OT_TEC_WO->Show($this->RowNumber);
                $this->OT_TEC_WA->Show($this->RowNumber);
                $this->OT_TEC_TR->Show($this->RowNumber);
                $this->ND_WO->Show($this->RowNumber);
                $this->ND_WA->Show($this->RowNumber);
                $this->ND_TR->Show($this->RowNumber);
                $this->WE_WO->Show($this->RowNumber);
                $this->WE_WA->Show($this->RowNumber);
                $this->WE_TR->Show($this->RowNumber);
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
                        $is_next_record =  $this->ReadAllowed && $this->DataSource->next_record() && $this->RowNumber < $this->UpdatedRows;
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
        $this->Sorter_ORDER_NO->Show();
        $this->Sorter_emp_id->Show();
        $this->Sorter_service_date_day->Show();
        $this->Sorter_service_date_month->Show();
        $this->Sorter_service_date_year->Show();
        $this->Sorter_FOLLOW_UP->Show();
        $this->Sorter_AGENT_EVAL_TECH->Show();
        $this->Sorter_PORT_FEE_ID->Show();
        $this->Sorter_NT_INV_WO->Show();
        $this->Sorter_NT_INV_WA->Show();
        $this->Sorter_NT_INV_TR->Show();
        $this->Sorter_NT_TEC_WO->Show();
        $this->Sorter_NT_TEC_WA->Show();
        $this->Sorter_NT_TEC_TR->Show();
        $this->Sorter_OT_INV_WO->Show();
        $this->Sorter_OT_INV_WA->Show();
        $this->Sorter_OT_INV_TR->Show();
        $this->Sorter_OT_TEC_WO->Show();
        $this->Sorter_OT_TEC_WA->Show();
        $this->Sorter_OT_TEC_TR->Show();
        $this->Sorter_ND_WO->Show();
        $this->Sorter_ND_WA->Show();
        $this->Sorter_ND_TR->Show();
        $this->Sorter_WE_WO->Show();
        $this->Sorter_WE_WA->Show();
        $this->Sorter_WE_TR->Show();
        $this->Navigator->Show();
        $this->Button_Submit->Show();
        $this->Cancel->Show();

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

} //End after_service_tbl Class @2-FCB6E20C

class clsafter_service_tblDataSource extends clsDBhss_db {  //after_service_tblDataSource Class @2-A5ADE14F

//DataSource Variables @2-6CB6A4F1
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $CountSQL;
    public $wp;
    public $AllParametersSet;

    public $CurrentRow;
    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $ORDER_NO;
    public $emp_id;
    public $service_date_day;
    public $service_date_month;
    public $service_date_year;
    public $FOLLOW_UP;
    public $AGENT_EVAL_TECH;
    public $PORT_FEE_ID;
    public $NT_INV_WO;
    public $NT_INV_WA;
    public $NT_INV_TR;
    public $NT_TEC_WO;
    public $NT_TEC_WA;
    public $NT_TEC_TR;
    public $OT_INV_WO;
    public $OT_INV_WA;
    public $OT_INV_TR;
    public $OT_TEC_WO;
    public $OT_TEC_WA;
    public $OT_TEC_TR;
    public $ND_WO;
    public $ND_WA;
    public $ND_TR;
    public $WE_WO;
    public $WE_WA;
    public $WE_TR;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-E8AB22D9
    function clsafter_service_tblDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid after_service_tbl/Error";
        $this->Initialize();
        $this->ORDER_NO = new clsField("ORDER_NO", ccsText, "");
        
        $this->emp_id = new clsField("emp_id", ccsInteger, "");
        
        $this->service_date_day = new clsField("service_date_day", ccsText, "");
        
        $this->service_date_month = new clsField("service_date_month", ccsText, "");
        
        $this->service_date_year = new clsField("service_date_year", ccsText, "");
        
        $this->FOLLOW_UP = new clsField("FOLLOW_UP", ccsText, "");
        
        $this->AGENT_EVAL_TECH = new clsField("AGENT_EVAL_TECH", ccsText, "");
        
        $this->PORT_FEE_ID = new clsField("PORT_FEE_ID", ccsInteger, "");
        
        $this->NT_INV_WO = new clsField("NT_INV_WO", ccsText, "");
        
        $this->NT_INV_WA = new clsField("NT_INV_WA", ccsText, "");
        
        $this->NT_INV_TR = new clsField("NT_INV_TR", ccsText, "");
        
        $this->NT_TEC_WO = new clsField("NT_TEC_WO", ccsText, "");
        
        $this->NT_TEC_WA = new clsField("NT_TEC_WA", ccsText, "");
        
        $this->NT_TEC_TR = new clsField("NT_TEC_TR", ccsText, "");
        
        $this->OT_INV_WO = new clsField("OT_INV_WO", ccsText, "");
        
        $this->OT_INV_WA = new clsField("OT_INV_WA", ccsText, "");
        
        $this->OT_INV_TR = new clsField("OT_INV_TR", ccsText, "");
        
        $this->OT_TEC_WO = new clsField("OT_TEC_WO", ccsText, "");
        
        $this->OT_TEC_WA = new clsField("OT_TEC_WA", ccsText, "");
        
        $this->OT_TEC_TR = new clsField("OT_TEC_TR", ccsText, "");
        
        $this->ND_WO = new clsField("ND_WO", ccsText, "");
        
        $this->ND_WA = new clsField("ND_WA", ccsText, "");
        
        $this->ND_TR = new clsField("ND_TR", ccsText, "");
        
        $this->WE_WO = new clsField("WE_WO", ccsText, "");
        
        $this->WE_WA = new clsField("WE_WA", ccsText, "");
        
        $this->WE_TR = new clsField("WE_TR", ccsText, "");
        

        $this->InsertFields["ORDER_NO"] = array("Name" => "ORDER_NO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["emp_id"] = array("Name" => "emp_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["service_date_day"] = array("Name" => "service_date_day", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["service_date_month"] = array("Name" => "service_date_month", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["service_date_year"] = array("Name" => "service_date_year", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["FOLLOW_UP"] = array("Name" => "FOLLOW_UP", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["AGENT_EVAL_TECH"] = array("Name" => "AGENT_EVAL_TECH", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["PORT_FEE_ID"] = array("Name" => "PORT_FEE_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["NT_INV_WO"] = array("Name" => "NT_INV_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["NT_INV_WA"] = array("Name" => "NT_INV_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["NT_INV_TR"] = array("Name" => "NT_INV_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["NT_TEC_WO"] = array("Name" => "NT_TEC_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["NT_TEC_WA"] = array("Name" => "NT_TEC_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["NT_TEC_TR"] = array("Name" => "NT_TEC_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["OT_INV_WO"] = array("Name" => "OT_INV_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["OT_INV_WA"] = array("Name" => "OT_INV_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["OT_INV_TR"] = array("Name" => "OT_INV_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["OT_TEC_WO"] = array("Name" => "OT_TEC_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["OT_TEC_WA"] = array("Name" => "OT_TEC_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["OT_TEC_TR"] = array("Name" => "OT_TEC_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["ND_WO"] = array("Name" => "ND_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["ND_WA"] = array("Name" => "ND_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["ND_TR"] = array("Name" => "ND_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["WE_WO"] = array("Name" => "WE_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["WE_WA"] = array("Name" => "WE_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["WE_TR"] = array("Name" => "WE_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["ORDER_NO"] = array("Name" => "ORDER_NO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["emp_id"] = array("Name" => "emp_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["service_date_day"] = array("Name" => "service_date_day", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["service_date_month"] = array("Name" => "service_date_month", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["service_date_year"] = array("Name" => "service_date_year", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["FOLLOW_UP"] = array("Name" => "FOLLOW_UP", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["AGENT_EVAL_TECH"] = array("Name" => "AGENT_EVAL_TECH", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["PORT_FEE_ID"] = array("Name" => "PORT_FEE_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["NT_INV_WO"] = array("Name" => "NT_INV_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["NT_INV_WA"] = array("Name" => "NT_INV_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["NT_INV_TR"] = array("Name" => "NT_INV_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["NT_TEC_WO"] = array("Name" => "NT_TEC_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["NT_TEC_WA"] = array("Name" => "NT_TEC_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["NT_TEC_TR"] = array("Name" => "NT_TEC_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["OT_INV_WO"] = array("Name" => "OT_INV_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["OT_INV_WA"] = array("Name" => "OT_INV_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["OT_INV_TR"] = array("Name" => "OT_INV_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["OT_TEC_WO"] = array("Name" => "OT_TEC_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["OT_TEC_WA"] = array("Name" => "OT_TEC_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["OT_TEC_TR"] = array("Name" => "OT_TEC_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["ND_WO"] = array("Name" => "ND_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["ND_WA"] = array("Name" => "ND_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["ND_TR"] = array("Name" => "ND_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["WE_WO"] = array("Name" => "WE_WO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["WE_WA"] = array("Name" => "WE_WA", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["WE_TR"] = array("Name" => "WE_TR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-663997C2
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "ORDER_NO";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_ORDER_NO" => array("ORDER_NO", ""), 
            "Sorter_emp_id" => array("emp_id", ""), 
            "Sorter_service_date_day" => array("service_date_day", ""), 
            "Sorter_service_date_month" => array("service_date_month", ""), 
            "Sorter_service_date_year" => array("service_date_year", ""), 
            "Sorter_FOLLOW_UP" => array("FOLLOW_UP", ""), 
            "Sorter_AGENT_EVAL_TECH" => array("AGENT_EVAL_TECH", ""), 
            "Sorter_PORT_FEE_ID" => array("PORT_FEE_ID", ""), 
            "Sorter_NT_INV_WO" => array("NT_INV_WO", ""), 
            "Sorter_NT_INV_WA" => array("NT_INV_WA", ""), 
            "Sorter_NT_INV_TR" => array("NT_INV_TR", ""), 
            "Sorter_NT_TEC_WO" => array("NT_TEC_WO", ""), 
            "Sorter_NT_TEC_WA" => array("NT_TEC_WA", ""), 
            "Sorter_NT_TEC_TR" => array("NT_TEC_TR", ""), 
            "Sorter_OT_INV_WO" => array("OT_INV_WO", ""), 
            "Sorter_OT_INV_WA" => array("OT_INV_WA", ""), 
            "Sorter_OT_INV_TR" => array("OT_INV_TR", ""), 
            "Sorter_OT_TEC_WO" => array("OT_TEC_WO", ""), 
            "Sorter_OT_TEC_WA" => array("OT_TEC_WA", ""), 
            "Sorter_OT_TEC_TR" => array("OT_TEC_TR", ""), 
            "Sorter_ND_WO" => array("ND_WO", ""), 
            "Sorter_ND_WA" => array("ND_WA", ""), 
            "Sorter_ND_TR" => array("ND_TR", ""), 
            "Sorter_WE_WO" => array("WE_WO", ""), 
            "Sorter_WE_WA" => array("WE_WA", ""), 
            "Sorter_WE_TR" => array("WE_TR", "")));
    }
//End SetOrder Method

//Prepare Method @2-A3787C53
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_ORDER_NO", ccsText, "", "", $this->Parameters["urls_ORDER_NO"], "", false);
        $this->wp->AddParameter("2", "urls_emp_id", ccsInteger, "", "", $this->Parameters["urls_emp_id"], "", false);
        $this->wp->AddParameter("3", "urls_service_date_day", ccsText, "", "", $this->Parameters["urls_service_date_day"], "", false);
        $this->wp->AddParameter("4", "urls_service_date_month", ccsText, "", "", $this->Parameters["urls_service_date_month"], "", false);
        $this->wp->AddParameter("5", "urls_service_date_year", ccsText, "", "", $this->Parameters["urls_service_date_year"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "ORDER_NO", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "emp_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "service_date_day", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opContains, "service_date_month", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opContains, "service_date_year", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]), 
             $this->wp->Criterion[4]), 
             $this->wp->Criterion[5]);
    }
//End Prepare Method

//Open Method @2-CE505389
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM after_service_tbl";
        $this->SQL = "SELECT * \n\n" .
        "FROM after_service_tbl {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-E774FA32
    function SetValues()
    {
        $this->ORDER_NO->SetDBValue($this->f("ORDER_NO"));
        $this->emp_id->SetDBValue(trim($this->f("emp_id")));
        $this->service_date_day->SetDBValue($this->f("service_date_day"));
        $this->service_date_month->SetDBValue($this->f("service_date_month"));
        $this->service_date_year->SetDBValue($this->f("service_date_year"));
        $this->FOLLOW_UP->SetDBValue($this->f("FOLLOW_UP"));
        $this->AGENT_EVAL_TECH->SetDBValue($this->f("AGENT_EVAL_TECH"));
        $this->PORT_FEE_ID->SetDBValue(trim($this->f("PORT_FEE_ID")));
        $this->NT_INV_WO->SetDBValue($this->f("NT_INV_WO"));
        $this->NT_INV_WA->SetDBValue($this->f("NT_INV_WA"));
        $this->NT_INV_TR->SetDBValue($this->f("NT_INV_TR"));
        $this->NT_TEC_WO->SetDBValue($this->f("NT_TEC_WO"));
        $this->NT_TEC_WA->SetDBValue($this->f("NT_TEC_WA"));
        $this->NT_TEC_TR->SetDBValue($this->f("NT_TEC_TR"));
        $this->OT_INV_WO->SetDBValue($this->f("OT_INV_WO"));
        $this->OT_INV_WA->SetDBValue($this->f("OT_INV_WA"));
        $this->OT_INV_TR->SetDBValue($this->f("OT_INV_TR"));
        $this->OT_TEC_WO->SetDBValue($this->f("OT_TEC_WO"));
        $this->OT_TEC_WA->SetDBValue($this->f("OT_TEC_WA"));
        $this->OT_TEC_TR->SetDBValue($this->f("OT_TEC_TR"));
        $this->ND_WO->SetDBValue($this->f("ND_WO"));
        $this->ND_WA->SetDBValue($this->f("ND_WA"));
        $this->ND_TR->SetDBValue($this->f("ND_TR"));
        $this->WE_WO->SetDBValue($this->f("WE_WO"));
        $this->WE_WA->SetDBValue($this->f("WE_WA"));
        $this->WE_TR->SetDBValue($this->f("WE_TR"));
    }
//End SetValues Method

//Insert Method @2-90C96298
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["ORDER_NO"]["Value"] = $this->ORDER_NO->GetDBValue(true);
        $this->InsertFields["emp_id"]["Value"] = $this->emp_id->GetDBValue(true);
        $this->InsertFields["service_date_day"]["Value"] = $this->service_date_day->GetDBValue(true);
        $this->InsertFields["service_date_month"]["Value"] = $this->service_date_month->GetDBValue(true);
        $this->InsertFields["service_date_year"]["Value"] = $this->service_date_year->GetDBValue(true);
        $this->InsertFields["FOLLOW_UP"]["Value"] = $this->FOLLOW_UP->GetDBValue(true);
        $this->InsertFields["AGENT_EVAL_TECH"]["Value"] = $this->AGENT_EVAL_TECH->GetDBValue(true);
        $this->InsertFields["PORT_FEE_ID"]["Value"] = $this->PORT_FEE_ID->GetDBValue(true);
        $this->InsertFields["NT_INV_WO"]["Value"] = $this->NT_INV_WO->GetDBValue(true);
        $this->InsertFields["NT_INV_WA"]["Value"] = $this->NT_INV_WA->GetDBValue(true);
        $this->InsertFields["NT_INV_TR"]["Value"] = $this->NT_INV_TR->GetDBValue(true);
        $this->InsertFields["NT_TEC_WO"]["Value"] = $this->NT_TEC_WO->GetDBValue(true);
        $this->InsertFields["NT_TEC_WA"]["Value"] = $this->NT_TEC_WA->GetDBValue(true);
        $this->InsertFields["NT_TEC_TR"]["Value"] = $this->NT_TEC_TR->GetDBValue(true);
        $this->InsertFields["OT_INV_WO"]["Value"] = $this->OT_INV_WO->GetDBValue(true);
        $this->InsertFields["OT_INV_WA"]["Value"] = $this->OT_INV_WA->GetDBValue(true);
        $this->InsertFields["OT_INV_TR"]["Value"] = $this->OT_INV_TR->GetDBValue(true);
        $this->InsertFields["OT_TEC_WO"]["Value"] = $this->OT_TEC_WO->GetDBValue(true);
        $this->InsertFields["OT_TEC_WA"]["Value"] = $this->OT_TEC_WA->GetDBValue(true);
        $this->InsertFields["OT_TEC_TR"]["Value"] = $this->OT_TEC_TR->GetDBValue(true);
        $this->InsertFields["ND_WO"]["Value"] = $this->ND_WO->GetDBValue(true);
        $this->InsertFields["ND_WA"]["Value"] = $this->ND_WA->GetDBValue(true);
        $this->InsertFields["ND_TR"]["Value"] = $this->ND_TR->GetDBValue(true);
        $this->InsertFields["WE_WO"]["Value"] = $this->WE_WO->GetDBValue(true);
        $this->InsertFields["WE_WA"]["Value"] = $this->WE_WA->GetDBValue(true);
        $this->InsertFields["WE_TR"]["Value"] = $this->WE_TR->GetDBValue(true);
        $this->SQL = CCBuildInsert("after_service_tbl", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-DB1E5C99
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "";
        $this->UpdateFields["ORDER_NO"]["Value"] = $this->ORDER_NO->GetDBValue(true);
        $this->UpdateFields["emp_id"]["Value"] = $this->emp_id->GetDBValue(true);
        $this->UpdateFields["service_date_day"]["Value"] = $this->service_date_day->GetDBValue(true);
        $this->UpdateFields["service_date_month"]["Value"] = $this->service_date_month->GetDBValue(true);
        $this->UpdateFields["service_date_year"]["Value"] = $this->service_date_year->GetDBValue(true);
        $this->UpdateFields["FOLLOW_UP"]["Value"] = $this->FOLLOW_UP->GetDBValue(true);
        $this->UpdateFields["AGENT_EVAL_TECH"]["Value"] = $this->AGENT_EVAL_TECH->GetDBValue(true);
        $this->UpdateFields["PORT_FEE_ID"]["Value"] = $this->PORT_FEE_ID->GetDBValue(true);
        $this->UpdateFields["NT_INV_WO"]["Value"] = $this->NT_INV_WO->GetDBValue(true);
        $this->UpdateFields["NT_INV_WA"]["Value"] = $this->NT_INV_WA->GetDBValue(true);
        $this->UpdateFields["NT_INV_TR"]["Value"] = $this->NT_INV_TR->GetDBValue(true);
        $this->UpdateFields["NT_TEC_WO"]["Value"] = $this->NT_TEC_WO->GetDBValue(true);
        $this->UpdateFields["NT_TEC_WA"]["Value"] = $this->NT_TEC_WA->GetDBValue(true);
        $this->UpdateFields["NT_TEC_TR"]["Value"] = $this->NT_TEC_TR->GetDBValue(true);
        $this->UpdateFields["OT_INV_WO"]["Value"] = $this->OT_INV_WO->GetDBValue(true);
        $this->UpdateFields["OT_INV_WA"]["Value"] = $this->OT_INV_WA->GetDBValue(true);
        $this->UpdateFields["OT_INV_TR"]["Value"] = $this->OT_INV_TR->GetDBValue(true);
        $this->UpdateFields["OT_TEC_WO"]["Value"] = $this->OT_TEC_WO->GetDBValue(true);
        $this->UpdateFields["OT_TEC_WA"]["Value"] = $this->OT_TEC_WA->GetDBValue(true);
        $this->UpdateFields["OT_TEC_TR"]["Value"] = $this->OT_TEC_TR->GetDBValue(true);
        $this->UpdateFields["ND_WO"]["Value"] = $this->ND_WO->GetDBValue(true);
        $this->UpdateFields["ND_WA"]["Value"] = $this->ND_WA->GetDBValue(true);
        $this->UpdateFields["ND_TR"]["Value"] = $this->ND_TR->GetDBValue(true);
        $this->UpdateFields["WE_WO"]["Value"] = $this->WE_WO->GetDBValue(true);
        $this->UpdateFields["WE_WA"]["Value"] = $this->WE_WA->GetDBValue(true);
        $this->UpdateFields["WE_TR"]["Value"] = $this->WE_TR->GetDBValue(true);
        $this->SQL = CCBuildUpdate("after_service_tbl", $this->UpdateFields, $this);
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

} //End after_service_tblDataSource Class @2-FCB6E20C

class clsRecordafter_service_tblSearch { //after_service_tblSearch Class @3-96114746

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

//Class_Initialize Event @3-D6A4C4E2
    function clsRecordafter_service_tblSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record after_service_tblSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "after_service_tblSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_ORDER_NO = new clsControl(ccsTextBox, "s_ORDER_NO", "s_ORDER_NO", ccsText, "", CCGetRequestParam("s_ORDER_NO", $Method, NULL), $this);
            $this->s_emp_id = new clsControl(ccsListBox, "s_emp_id", "s_emp_id", ccsInteger, "", CCGetRequestParam("s_emp_id", $Method, NULL), $this);
            $this->s_emp_id->DSType = dsTable;
            $this->s_emp_id->DataSource = new clsDBhss_db();
            $this->s_emp_id->ds = & $this->s_emp_id->DataSource;
            $this->s_emp_id->DataSource->SQL = "SELECT * \n" .
"FROM employees_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->s_emp_id->BoundColumn, $this->s_emp_id->TextColumn, $this->s_emp_id->DBFormat) = array("emp_id", "emp_login", "");
            $this->s_service_date_day = new clsControl(ccsListBox, "s_service_date_day", "s_service_date_day", ccsText, "", CCGetRequestParam("s_service_date_day", $Method, NULL), $this);
            $this->s_service_date_day->DSType = dsTable;
            $this->s_service_date_day->DataSource = new clsDBhss_db();
            $this->s_service_date_day->ds = & $this->s_service_date_day->DataSource;
            $this->s_service_date_day->DataSource->SQL = "SELECT * \n" .
"FROM days_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->s_service_date_day->BoundColumn, $this->s_service_date_day->TextColumn, $this->s_service_date_day->DBFormat) = array("days", "days", "");
            $this->s_service_date_month = new clsControl(ccsListBox, "s_service_date_month", "s_service_date_month", ccsText, "", CCGetRequestParam("s_service_date_month", $Method, NULL), $this);
            $this->s_service_date_month->DSType = dsTable;
            $this->s_service_date_month->DataSource = new clsDBhss_db();
            $this->s_service_date_month->ds = & $this->s_service_date_month->DataSource;
            $this->s_service_date_month->DataSource->SQL = "SELECT * \n" .
"FROM months_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->s_service_date_month->BoundColumn, $this->s_service_date_month->TextColumn, $this->s_service_date_month->DBFormat) = array("months", "", "");
            $this->s_service_date_year = new clsControl(ccsTextBox, "s_service_date_year", "s_service_date_year", ccsText, "", CCGetRequestParam("s_service_date_year", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @3-8A16131D
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_ORDER_NO->Validate() && $Validation);
        $Validation = ($this->s_emp_id->Validate() && $Validation);
        $Validation = ($this->s_service_date_day->Validate() && $Validation);
        $Validation = ($this->s_service_date_month->Validate() && $Validation);
        $Validation = ($this->s_service_date_year->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_ORDER_NO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_emp_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_service_date_day->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_service_date_month->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_service_date_year->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @3-8F91A5D1
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_ORDER_NO->Errors->Count());
        $errors = ($errors || $this->s_emp_id->Errors->Count());
        $errors = ($errors || $this->s_service_date_day->Errors->Count());
        $errors = ($errors || $this->s_service_date_month->Errors->Count());
        $errors = ($errors || $this->s_service_date_year->Errors->Count());
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

//Operation Method @3-C1C80A24
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
        $Redirect = "page8.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "page8.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @3-168890F2
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

        $this->s_emp_id->Prepare();
        $this->s_service_date_day->Prepare();
        $this->s_service_date_month->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_ORDER_NO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_emp_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_service_date_day->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_service_date_month->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_service_date_year->Errors->ToString());
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
        $this->s_ORDER_NO->Show();
        $this->s_emp_id->Show();
        $this->s_service_date_day->Show();
        $this->s_service_date_month->Show();
        $this->s_service_date_year->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End after_service_tblSearch Class @3-FCB6E20C

//Initialize Page @1-B000FFFC
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
$TemplateFileName = "page8.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-F33FE1A6
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$after_service_tbl = new clsEditableGridafter_service_tbl("", $MainPage);
$after_service_tblSearch = new clsRecordafter_service_tblSearch("", $MainPage);
$MainPage->after_service_tbl = & $after_service_tbl;
$MainPage->after_service_tblSearch = & $after_service_tblSearch;
$after_service_tbl->Initialize();

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

//Execute Components @1-C118E607
$after_service_tbl->Operation();
$after_service_tblSearch->Operation();
//End Execute Components

//Go to destination page @1-34385FB5
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($after_service_tbl);
    unset($after_service_tblSearch);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-EDEA173E
$after_service_tbl->Show();
$after_service_tblSearch->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-7087A05B
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($after_service_tbl);
unset($after_service_tblSearch);
unset($Tpl);
//End Unload Page


?>
