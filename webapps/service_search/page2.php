<?php
//Include Common Files @1-C5BBDFFC
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page2.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridagents_tbl_ports_tbl_serv { //agents_tbl_ports_tbl_serv class @2-37FE7E0B

//Variables @2-AC1EDBB9

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

//Class_Initialize Event @2-6B715FAD
    function clsGridagents_tbl_ports_tbl_serv($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "agents_tbl_ports_tbl_serv";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid agents_tbl_ports_tbl_serv";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsagents_tbl_ports_tbl_servDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->service_items_tbl_ORDER_NO = & new clsControl(ccsLabel, "service_items_tbl_ORDER_NO", "service_items_tbl_ORDER_NO", ccsText, "", CCGetRequestParam("service_items_tbl_ORDER_NO", ccsGet, NULL), $this);
        $this->SHIP_NAME = & new clsControl(ccsLabel, "SHIP_NAME", "SHIP_NAME", ccsText, "", CCGetRequestParam("SHIP_NAME", ccsGet, NULL), $this);
        $this->IMO_NUMBER = & new clsControl(ccsLabel, "IMO_NUMBER", "IMO_NUMBER", ccsText, "", CCGetRequestParam("IMO_NUMBER", ccsGet, NULL), $this);
        $this->PORT_NAME = & new clsControl(ccsLabel, "PORT_NAME", "PORT_NAME", ccsText, "", CCGetRequestParam("PORT_NAME", ccsGet, NULL), $this);
        $this->AGENT_NAME = & new clsControl(ccsLabel, "AGENT_NAME", "AGENT_NAME", ccsText, "", CCGetRequestParam("AGENT_NAME", ccsGet, NULL), $this);
        $this->Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "../file_manager/page2.php";
        $this->Navigator = & new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
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

//Show Method @2-2D34DB04
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlEQUIP_ID"] = CCGetFromGet("EQUIP_ID", NULL);

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
            $this->ControlsVisible["service_items_tbl_ORDER_NO"] = $this->service_items_tbl_ORDER_NO->Visible;
            $this->ControlsVisible["SHIP_NAME"] = $this->SHIP_NAME->Visible;
            $this->ControlsVisible["IMO_NUMBER"] = $this->IMO_NUMBER->Visible;
            $this->ControlsVisible["PORT_NAME"] = $this->PORT_NAME->Visible;
            $this->ControlsVisible["AGENT_NAME"] = $this->AGENT_NAME->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->service_items_tbl_ORDER_NO->SetValue($this->DataSource->service_items_tbl_ORDER_NO->GetValue());
                $this->SHIP_NAME->SetValue($this->DataSource->SHIP_NAME->GetValue());
                $this->IMO_NUMBER->SetValue($this->DataSource->IMO_NUMBER->GetValue());
                $this->PORT_NAME->SetValue($this->DataSource->PORT_NAME->GetValue());
                $this->AGENT_NAME->SetValue($this->DataSource->AGENT_NAME->GetValue());
                $this->Link1->Parameters = "";
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "ORDER_NO", $this->DataSource->f("ORDER_NO"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "IMO_NUMBER", $this->DataSource->f("IMO_NUMBER"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->service_items_tbl_ORDER_NO->Show();
                $this->SHIP_NAME->Show();
                $this->IMO_NUMBER->Show();
                $this->PORT_NAME->Show();
                $this->AGENT_NAME->Show();
                $this->Link1->Show();
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

//GetErrors Method @2-9CD83C49
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->service_items_tbl_ORDER_NO->Errors->ToString());
        $errors = ComposeStrings($errors, $this->SHIP_NAME->Errors->ToString());
        $errors = ComposeStrings($errors, $this->IMO_NUMBER->Errors->ToString());
        $errors = ComposeStrings($errors, $this->PORT_NAME->Errors->ToString());
        $errors = ComposeStrings($errors, $this->AGENT_NAME->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End agents_tbl_ports_tbl_serv Class @2-FCB6E20C

class clsagents_tbl_ports_tbl_servDataSource extends clsDBhss_db {  //agents_tbl_ports_tbl_servDataSource Class @2-FED21709

//DataSource Variables @2-C46BE221
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $CountSQL;
    var $wp;


    // Datasource fields
    var $service_items_tbl_ORDER_NO;
    var $SHIP_NAME;
    var $IMO_NUMBER;
    var $PORT_NAME;
    var $AGENT_NAME;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-E89628BC
    function clsagents_tbl_ports_tbl_servDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid agents_tbl_ports_tbl_serv";
        $this->Initialize();
        $this->service_items_tbl_ORDER_NO = new clsField("service_items_tbl_ORDER_NO", ccsText, "");
        
        $this->SHIP_NAME = new clsField("SHIP_NAME", ccsText, "");
        
        $this->IMO_NUMBER = new clsField("IMO_NUMBER", ccsText, "");
        
        $this->PORT_NAME = new clsField("PORT_NAME", ccsText, "");
        
        $this->AGENT_NAME = new clsField("AGENT_NAME", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-AA6FD4DB
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "service_items_tbl.ORDER_NO desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-47318061
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlEQUIP_ID", ccsText, "", "", $this->Parameters["urlEQUIP_ID"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "service_items_tbl.EQUIP_ID", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-E9FCA8AF
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((service_tbl INNER JOIN service_items_tbl ON\n\n" .
        "service_items_tbl.ORDER_NO = service_tbl.ORDER_NO) INNER JOIN ships_tbl ON\n\n" .
        "service_tbl.IMO_NUMBER = ships_tbl.IMO_NUMBER) INNER JOIN agents_tbl ON\n\n" .
        "service_tbl.AGENT_ID = agents_tbl.AGENT_ID) INNER JOIN ports_tbl ON\n\n" .
        "service_tbl.PORT_ID = ports_tbl.PORT_ID";
        $this->SQL = "SELECT SHIP_NAME, AGENT_NAME, PORT_NAME, service_tbl.*, service_items_tbl.* \n\n" .
        "FROM (((service_tbl INNER JOIN service_items_tbl ON\n\n" .
        "service_items_tbl.ORDER_NO = service_tbl.ORDER_NO) INNER JOIN ships_tbl ON\n\n" .
        "service_tbl.IMO_NUMBER = ships_tbl.IMO_NUMBER) INNER JOIN agents_tbl ON\n\n" .
        "service_tbl.AGENT_ID = agents_tbl.AGENT_ID) INNER JOIN ports_tbl ON\n\n" .
        "service_tbl.PORT_ID = ports_tbl.PORT_ID {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-9D49B331
    function SetValues()
    {
        $this->service_items_tbl_ORDER_NO->SetDBValue($this->f("ORDER_NO"));
        $this->SHIP_NAME->SetDBValue($this->f("SHIP_NAME"));
        $this->IMO_NUMBER->SetDBValue($this->f("IMO_NUMBER"));
        $this->PORT_NAME->SetDBValue($this->f("PORT_NAME"));
        $this->AGENT_NAME->SetDBValue($this->f("AGENT_NAME"));
    }
//End SetValues Method

} //End agents_tbl_ports_tbl_servDataSource Class @2-FCB6E20C

//Initialize Page @1-B392DC04
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
$TemplateFileName = "page2.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-72C83CC4
include_once("./page2_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-6CB32BDE
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$agents_tbl_ports_tbl_serv = & new clsGridagents_tbl_ports_tbl_serv("", $MainPage);
$MainPage->agents_tbl_ports_tbl_serv = & $agents_tbl_ports_tbl_serv;
$agents_tbl_ports_tbl_serv->Initialize();

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

//Go to destination page @1-932BD9E4
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($agents_tbl_ports_tbl_serv);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-E8DEF70E
$agents_tbl_ports_tbl_serv->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-38DF6CCB
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($agents_tbl_ports_tbl_serv);
unset($Tpl);
//End Unload Page


?>
