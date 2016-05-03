<?php
//Include Common Files @1-39E79F0D
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "board_view.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridagents_tbl_countries_tbl { //agents_tbl_countries_tbl class @2-78AE5E28

//Variables @2-6E51DF5A

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

//Class_Initialize Event @2-C7D61526
    function clsGridagents_tbl_countries_tbl($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "agents_tbl_countries_tbl";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid agents_tbl_countries_tbl";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsagents_tbl_countries_tblDataSource($this);
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

        $this->ETA_DATE = new clsControl(ccsLabel, "ETA_DATE", "ETA_DATE", ccsText, "", CCGetRequestParam("ETA_DATE", ccsGet, NULL), $this);
        $this->ETA_HOUR = new clsControl(ccsLabel, "ETA_HOUR", "ETA_HOUR", ccsText, "", CCGetRequestParam("ETA_HOUR", ccsGet, NULL), $this);
        $this->SHIP_NAME = new clsControl(ccsLabel, "SHIP_NAME", "SHIP_NAME", ccsText, "", CCGetRequestParam("SHIP_NAME", ccsGet, NULL), $this);
        $this->EQUIP_MODEL = new clsControl(ccsLabel, "EQUIP_MODEL", "EQUIP_MODEL", ccsText, "", CCGetRequestParam("EQUIP_MODEL", ccsGet, NULL), $this);
        $this->AGENT_NAME = new clsControl(ccsLabel, "AGENT_NAME", "AGENT_NAME", ccsText, "", CCGetRequestParam("AGENT_NAME", ccsGet, NULL), $this);
        $this->emp_login = new clsControl(ccsLabel, "emp_login", "emp_login", ccsText, "", CCGetRequestParam("emp_login", ccsGet, NULL), $this);
        $this->country_name = new clsControl(ccsLabel, "country_name", "country_name", ccsText, "", CCGetRequestParam("country_name", ccsGet, NULL), $this);
        $this->AGENT_OFFICE_PHONE_1 = new clsControl(ccsLabel, "AGENT_OFFICE_PHONE_1", "AGENT_OFFICE_PHONE_1", ccsText, "", CCGetRequestParam("AGENT_OFFICE_PHONE_1", ccsGet, NULL), $this);
        $this->AGENT_OFFICE_PHONE_2 = new clsControl(ccsLabel, "AGENT_OFFICE_PHONE_2", "AGENT_OFFICE_PHONE_2", ccsText, "", CCGetRequestParam("AGENT_OFFICE_PHONE_2", ccsGet, NULL), $this);
        $this->AGENT_EMAIL = new clsControl(ccsLabel, "AGENT_EMAIL", "AGENT_EMAIL", ccsText, "", CCGetRequestParam("AGENT_EMAIL", ccsGet, NULL), $this);
        $this->AGENT_DUTY_PHONE = new clsControl(ccsLabel, "AGENT_DUTY_PHONE", "AGENT_DUTY_PHONE", ccsText, "", CCGetRequestParam("AGENT_DUTY_PHONE", ccsGet, NULL), $this);
        $this->PORT_NAME = new clsControl(ccsLabel, "PORT_NAME", "PORT_NAME", ccsText, "", CCGetRequestParam("PORT_NAME", ccsGet, NULL), $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @2-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @2-513DA35A
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;


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
            $this->ControlsVisible["ETA_DATE"] = $this->ETA_DATE->Visible;
            $this->ControlsVisible["ETA_HOUR"] = $this->ETA_HOUR->Visible;
            $this->ControlsVisible["SHIP_NAME"] = $this->SHIP_NAME->Visible;
            $this->ControlsVisible["EQUIP_MODEL"] = $this->EQUIP_MODEL->Visible;
            $this->ControlsVisible["AGENT_NAME"] = $this->AGENT_NAME->Visible;
            $this->ControlsVisible["emp_login"] = $this->emp_login->Visible;
            $this->ControlsVisible["country_name"] = $this->country_name->Visible;
            $this->ControlsVisible["AGENT_OFFICE_PHONE_1"] = $this->AGENT_OFFICE_PHONE_1->Visible;
            $this->ControlsVisible["AGENT_OFFICE_PHONE_2"] = $this->AGENT_OFFICE_PHONE_2->Visible;
            $this->ControlsVisible["AGENT_EMAIL"] = $this->AGENT_EMAIL->Visible;
            $this->ControlsVisible["AGENT_DUTY_PHONE"] = $this->AGENT_DUTY_PHONE->Visible;
            $this->ControlsVisible["PORT_NAME"] = $this->PORT_NAME->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->ETA_DATE->SetValue($this->DataSource->ETA_DATE->GetValue());
                $this->ETA_HOUR->SetValue($this->DataSource->ETA_HOUR->GetValue());
                $this->SHIP_NAME->SetValue($this->DataSource->SHIP_NAME->GetValue());
                $this->EQUIP_MODEL->SetValue($this->DataSource->EQUIP_MODEL->GetValue());
                $this->AGENT_NAME->SetValue($this->DataSource->AGENT_NAME->GetValue());
                $this->emp_login->SetValue($this->DataSource->emp_login->GetValue());
                $this->country_name->SetValue($this->DataSource->country_name->GetValue());
                $this->AGENT_OFFICE_PHONE_1->SetValue($this->DataSource->AGENT_OFFICE_PHONE_1->GetValue());
                $this->AGENT_OFFICE_PHONE_2->SetValue($this->DataSource->AGENT_OFFICE_PHONE_2->GetValue());
                $this->AGENT_EMAIL->SetValue($this->DataSource->AGENT_EMAIL->GetValue());
                $this->AGENT_DUTY_PHONE->SetValue($this->DataSource->AGENT_DUTY_PHONE->GetValue());
                $this->PORT_NAME->SetValue($this->DataSource->PORT_NAME->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->ETA_DATE->Show();
                $this->ETA_HOUR->Show();
                $this->SHIP_NAME->Show();
                $this->EQUIP_MODEL->Show();
                $this->AGENT_NAME->Show();
                $this->emp_login->Show();
                $this->country_name->Show();
                $this->AGENT_OFFICE_PHONE_1->Show();
                $this->AGENT_OFFICE_PHONE_2->Show();
                $this->AGENT_EMAIL->Show();
                $this->AGENT_DUTY_PHONE->Show();
                $this->PORT_NAME->Show();
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

//GetErrors Method @2-E5AE0BC5
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->ETA_DATE->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ETA_HOUR->Errors->ToString());
        $errors = ComposeStrings($errors, $this->SHIP_NAME->Errors->ToString());
        $errors = ComposeStrings($errors, $this->EQUIP_MODEL->Errors->ToString());
        $errors = ComposeStrings($errors, $this->AGENT_NAME->Errors->ToString());
        $errors = ComposeStrings($errors, $this->emp_login->Errors->ToString());
        $errors = ComposeStrings($errors, $this->country_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->AGENT_OFFICE_PHONE_1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->AGENT_OFFICE_PHONE_2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->AGENT_EMAIL->Errors->ToString());
        $errors = ComposeStrings($errors, $this->AGENT_DUTY_PHONE->Errors->ToString());
        $errors = ComposeStrings($errors, $this->PORT_NAME->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End agents_tbl_countries_tbl Class @2-FCB6E20C

class clsagents_tbl_countries_tblDataSource extends clsDBhss_db {  //agents_tbl_countries_tblDataSource Class @2-3C69B572

//DataSource Variables @2-B71208F0
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $ETA_DATE;
    public $ETA_HOUR;
    public $SHIP_NAME;
    public $EQUIP_MODEL;
    public $AGENT_NAME;
    public $emp_login;
    public $country_name;
    public $AGENT_OFFICE_PHONE_1;
    public $AGENT_OFFICE_PHONE_2;
    public $AGENT_EMAIL;
    public $AGENT_DUTY_PHONE;
    public $PORT_NAME;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-0E0F1C49
    function clsagents_tbl_countries_tblDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid agents_tbl_countries_tbl";
        $this->Initialize();
        $this->ETA_DATE = new clsField("ETA_DATE", ccsText, "");
        
        $this->ETA_HOUR = new clsField("ETA_HOUR", ccsText, "");
        
        $this->SHIP_NAME = new clsField("SHIP_NAME", ccsText, "");
        
        $this->EQUIP_MODEL = new clsField("EQUIP_MODEL", ccsText, "");
        
        $this->AGENT_NAME = new clsField("AGENT_NAME", ccsText, "");
        
        $this->emp_login = new clsField("emp_login", ccsText, "");
        
        $this->country_name = new clsField("country_name", ccsText, "");
        
        $this->AGENT_OFFICE_PHONE_1 = new clsField("AGENT_OFFICE_PHONE_1", ccsText, "");
        
        $this->AGENT_OFFICE_PHONE_2 = new clsField("AGENT_OFFICE_PHONE_2", ccsText, "");
        
        $this->AGENT_EMAIL = new clsField("AGENT_EMAIL", ccsText, "");
        
        $this->AGENT_DUTY_PHONE = new clsField("AGENT_DUTY_PHONE", ccsText, "");
        
        $this->PORT_NAME = new clsField("PORT_NAME", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-7CD0C891
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "service_tbl.ETA_DATE";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @2-79256CB3
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((((((service_tbl INNER JOIN ships_tbl ON\n\n" .
        "service_tbl.IMO_NUMBER = ships_tbl.IMO_NUMBER) INNER JOIN countries_tbl ON\n\n" .
        "service_tbl.country_id = countries_tbl.country_id) INNER JOIN agents_tbl ON\n\n" .
        "service_tbl.AGENT_ID = agents_tbl.AGENT_ID) INNER JOIN ports_tbl ON\n\n" .
        "service_tbl.PORT_ID = ports_tbl.PORT_ID) INNER JOIN service_items_tbl ON\n\n" .
        "service_items_tbl.ORDER_NO = service_tbl.ORDER_NO) INNER JOIN equipment_model_tbl ON\n\n" .
        "service_items_tbl.EQUIP_ID = equipment_model_tbl.EQUIP_ID) INNER JOIN employees_tbl ON\n\n" .
        "service_items_tbl.assigned_emp_id = employees_tbl.emp_id";
        $this->SQL = "SELECT service_tbl.*, SHIP_NAME, countries_tbl.*, agents_tbl.*, PORT_NAME, service_items_tbl.*, EQUIP_MODEL, emp_login \n\n" .
        "FROM ((((((service_tbl INNER JOIN ships_tbl ON\n\n" .
        "service_tbl.IMO_NUMBER = ships_tbl.IMO_NUMBER) INNER JOIN countries_tbl ON\n\n" .
        "service_tbl.country_id = countries_tbl.country_id) INNER JOIN agents_tbl ON\n\n" .
        "service_tbl.AGENT_ID = agents_tbl.AGENT_ID) INNER JOIN ports_tbl ON\n\n" .
        "service_tbl.PORT_ID = ports_tbl.PORT_ID) INNER JOIN service_items_tbl ON\n\n" .
        "service_items_tbl.ORDER_NO = service_tbl.ORDER_NO) INNER JOIN equipment_model_tbl ON\n\n" .
        "service_items_tbl.EQUIP_ID = equipment_model_tbl.EQUIP_ID) INNER JOIN employees_tbl ON\n\n" .
        "service_items_tbl.assigned_emp_id = employees_tbl.emp_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-6692D967
    function SetValues()
    {
        $this->ETA_DATE->SetDBValue($this->f("ETA_DATE"));
        $this->ETA_HOUR->SetDBValue($this->f("ETA_HOUR"));
        $this->SHIP_NAME->SetDBValue($this->f("SHIP_NAME"));
        $this->EQUIP_MODEL->SetDBValue($this->f("EQUIP_MODEL"));
        $this->AGENT_NAME->SetDBValue($this->f("AGENT_NAME"));
        $this->emp_login->SetDBValue($this->f("emp_login"));
        $this->country_name->SetDBValue($this->f("country_name"));
        $this->AGENT_OFFICE_PHONE_1->SetDBValue($this->f("AGENT_OFFICE_PHONE_1"));
        $this->AGENT_OFFICE_PHONE_2->SetDBValue($this->f("AGENT_OFFICE_PHONE_2"));
        $this->AGENT_EMAIL->SetDBValue($this->f("AGENT_EMAIL"));
        $this->AGENT_DUTY_PHONE->SetDBValue($this->f("AGENT_DUTY_PHONE"));
        $this->PORT_NAME->SetDBValue($this->f("PORT_NAME"));
    }
//End SetValues Method

} //End agents_tbl_countries_tblDataSource Class @2-FCB6E20C

//Initialize Page @1-BEF17E04
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
$TemplateFileName = "board_view.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-55E93196
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$agents_tbl_countries_tbl = new clsGridagents_tbl_countries_tbl("", $MainPage);
$MainPage->agents_tbl_countries_tbl = & $agents_tbl_countries_tbl;
$agents_tbl_countries_tbl->Initialize();

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

//Go to destination page @1-F16404AB
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($agents_tbl_countries_tbl);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-4D21019A
$agents_tbl_countries_tbl->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-177785C3
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($agents_tbl_countries_tbl);
unset($Tpl);
//End Unload Page


?>
