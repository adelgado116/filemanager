<?php
//Include Common Files @1-EEBBB20E
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page0.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridequipment_manufacturer_tb1 { //equipment_manufacturer_tb1 class @25-16FC1DF1

//Variables @25-AC1EDBB9

    // Public variables
    var $ComponentType = "Grid";
    var $ComponentName;
    var $Visible;
    var $Errors;
    var $ErrorBlock;
    var $ds;
    var $DataSource;
    var $PageSize;
    var $IsEmpty;
    var $ForceIteration = false;
    var $HasRecord = false;
    var $SorterName = "";
    var $SorterDirection = "";
    var $PageNumber;
    var $RowNumber;
    var $ControlsVisible = array();

    var $CCSEvents = "";
    var $CCSEventResult;

    var $RelativePath = "";
    var $Attributes;

    // Grid Controls
    var $StaticControls;
    var $RowControls;
//End Variables

//Class_Initialize Event @25-6DB61D21
    function clsGridequipment_manufacturer_tb1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "equipment_manufacturer_tb1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid equipment_manufacturer_tb1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsequipment_manufacturer_tb1DataSource($this);
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

        $this->ORDER_NO = & new clsControl(ccsLabel, "ORDER_NO", "ORDER_NO", ccsText, "", CCGetRequestParam("ORDER_NO", ccsGet, NULL), $this);
        $this->SERVICE_TYPE = & new clsControl(ccsLabel, "SERVICE_TYPE", "SERVICE_TYPE", ccsText, "", CCGetRequestParam("SERVICE_TYPE", ccsGet, NULL), $this);
        $this->MANUF_NAME = & new clsControl(ccsLabel, "MANUF_NAME", "MANUF_NAME", ccsText, "", CCGetRequestParam("MANUF_NAME", ccsGet, NULL), $this);
        $this->EQUIP_TYPE = & new clsControl(ccsLabel, "EQUIP_TYPE", "EQUIP_TYPE", ccsText, "", CCGetRequestParam("EQUIP_TYPE", ccsGet, NULL), $this);
        $this->EQUIP_MODEL = & new clsControl(ccsLink, "EQUIP_MODEL", "EQUIP_MODEL", ccsText, "", CCGetRequestParam("EQUIP_MODEL", ccsGet, NULL), $this);
        $this->EQUIP_MODEL->Page = "page1.php";
    }
//End Class_Initialize Event

//Initialize Method @25-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @25-664F0BA7
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlORDER_NO"] = CCGetFromGet("ORDER_NO", NULL);

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
            $this->ControlsVisible["ORDER_NO"] = $this->ORDER_NO->Visible;
            $this->ControlsVisible["SERVICE_TYPE"] = $this->SERVICE_TYPE->Visible;
            $this->ControlsVisible["MANUF_NAME"] = $this->MANUF_NAME->Visible;
            $this->ControlsVisible["EQUIP_TYPE"] = $this->EQUIP_TYPE->Visible;
            $this->ControlsVisible["EQUIP_MODEL"] = $this->EQUIP_MODEL->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->ORDER_NO->SetValue($this->DataSource->ORDER_NO->GetValue());
                $this->SERVICE_TYPE->SetValue($this->DataSource->SERVICE_TYPE->GetValue());
                $this->MANUF_NAME->SetValue($this->DataSource->MANUF_NAME->GetValue());
                $this->EQUIP_TYPE->SetValue($this->DataSource->EQUIP_TYPE->GetValue());
                $this->EQUIP_MODEL->SetValue($this->DataSource->EQUIP_MODEL->GetValue());
                $this->EQUIP_MODEL->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->EQUIP_MODEL->Parameters = CCAddParam($this->EQUIP_MODEL->Parameters, "ORDER_NO", $this->DataSource->f("ORDER_NO"));
                $this->EQUIP_MODEL->Parameters = CCAddParam($this->EQUIP_MODEL->Parameters, "SERVICE_TYPE", $this->DataSource->f("SERVICE_TYPE"));
                $this->EQUIP_MODEL->Parameters = CCAddParam($this->EQUIP_MODEL->Parameters, "MANUF_NAME", $this->DataSource->f("MANUF_NAME"));
                $this->EQUIP_MODEL->Parameters = CCAddParam($this->EQUIP_MODEL->Parameters, "EQUIP_TYPE", $this->DataSource->f("EQUIP_TYPE"));
                $this->EQUIP_MODEL->Parameters = CCAddParam($this->EQUIP_MODEL->Parameters, "EQUIP_MODEL", $this->DataSource->f("EQUIP_MODEL"));
                $this->EQUIP_MODEL->Parameters = CCAddParam($this->EQUIP_MODEL->Parameters, "ITEM_NO", $this->DataSource->f("ITEM_NO"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->ORDER_NO->Show();
                $this->SERVICE_TYPE->Show();
                $this->MANUF_NAME->Show();
                $this->EQUIP_TYPE->Show();
                $this->EQUIP_MODEL->Show();
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

//GetErrors Method @25-733A79C0
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->ORDER_NO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->SERVICE_TYPE->Errors->ToString());
        $errors = ComposeStrings($errors, $this->MANUF_NAME->Errors->ToString());
        $errors = ComposeStrings($errors, $this->EQUIP_TYPE->Errors->ToString());
        $errors = ComposeStrings($errors, $this->EQUIP_MODEL->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End equipment_manufacturer_tb1 Class @25-FCB6E20C

class clsequipment_manufacturer_tb1DataSource extends clsDBhss_db {  //equipment_manufacturer_tb1DataSource Class @25-F0E30DC2

//DataSource Variables @25-3C858839
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $CountSQL;
    var $wp;


    // Datasource fields
    var $ORDER_NO;
    var $SERVICE_TYPE;
    var $MANUF_NAME;
    var $EQUIP_TYPE;
    var $EQUIP_MODEL;
//End DataSource Variables

//DataSourceClass_Initialize Event @25-1311F737
    function clsequipment_manufacturer_tb1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid equipment_manufacturer_tb1";
        $this->Initialize();
        $this->ORDER_NO = new clsField("ORDER_NO", ccsText, "");
        
        $this->SERVICE_TYPE = new clsField("SERVICE_TYPE", ccsText, "");
        
        $this->MANUF_NAME = new clsField("MANUF_NAME", ccsText, "");
        
        $this->EQUIP_TYPE = new clsField("EQUIP_TYPE", ccsText, "");
        
        $this->EQUIP_MODEL = new clsField("EQUIP_MODEL", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @25-108A1936
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "MANUF_NAME";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @25-59C96786
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlORDER_NO", ccsText, "", "", $this->Parameters["urlORDER_NO"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "service_items_tbl.ORDER_NO", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @25-5522C327
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((service_items_tbl INNER JOIN service_type_tbl ON\n\n" .
        "service_items_tbl.SERVICE_TYPE_ID = service_type_tbl.SERVICE_TYPE_ID) INNER JOIN equipment_model_tbl ON\n\n" .
        "service_items_tbl.EQUIP_ID = equipment_model_tbl.EQUIP_ID) INNER JOIN equipment_manufacturer_tbl ON\n\n" .
        "equipment_model_tbl.MANUF_ID = equipment_manufacturer_tbl.MANUF_ID) INNER JOIN equipment_type_tbl ON\n\n" .
        "equipment_model_tbl.EQUIP_TYPE_ID = equipment_type_tbl.EQUIP_TYPE_ID";
        $this->SQL = "SELECT service_items_tbl.*, EQUIP_MODEL, MANUF_NAME, SERVICE_TYPE, EQUIP_TYPE \n\n" .
        "FROM (((service_items_tbl INNER JOIN service_type_tbl ON\n\n" .
        "service_items_tbl.SERVICE_TYPE_ID = service_type_tbl.SERVICE_TYPE_ID) INNER JOIN equipment_model_tbl ON\n\n" .
        "service_items_tbl.EQUIP_ID = equipment_model_tbl.EQUIP_ID) INNER JOIN equipment_manufacturer_tbl ON\n\n" .
        "equipment_model_tbl.MANUF_ID = equipment_manufacturer_tbl.MANUF_ID) INNER JOIN equipment_type_tbl ON\n\n" .
        "equipment_model_tbl.EQUIP_TYPE_ID = equipment_type_tbl.EQUIP_TYPE_ID {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @25-E0F36FA4
    function SetValues()
    {
        $this->ORDER_NO->SetDBValue($this->f("ORDER_NO"));
        $this->SERVICE_TYPE->SetDBValue($this->f("SERVICE_TYPE"));
        $this->MANUF_NAME->SetDBValue($this->f("MANUF_NAME"));
        $this->EQUIP_TYPE->SetDBValue($this->f("EQUIP_TYPE"));
        $this->EQUIP_MODEL->SetDBValue($this->f("EQUIP_MODEL"));
    }
//End SetValues Method

} //End equipment_manufacturer_tb1DataSource Class @25-FCB6E20C

//Initialize Page @1-6822D5B6
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
$TemplateFileName = "page0.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-FBB93176
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$equipment_manufacturer_tb1 = & new clsGridequipment_manufacturer_tb1("", $MainPage);
$MainPage->equipment_manufacturer_tb1 = & $equipment_manufacturer_tb1;
$equipment_manufacturer_tb1->Initialize();

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

//Go to destination page @1-16FDD6BF
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($equipment_manufacturer_tb1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-7D9BDA73
$equipment_manufacturer_tb1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-CA65BDA1
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($equipment_manufacturer_tb1);
unset($Tpl);
//End Unload Page


?>
