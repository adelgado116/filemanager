<?php
//Include Common Files @1-9110B898
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page0_2.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridtools_accessories_tools_m1 { //tools_accessories_tools_m1 class @5-CC5FAC20

//Variables @5-AC1EDBB9

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

//Class_Initialize Event @5-A58D70BF
    function clsGridtools_accessories_tools_m1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "tools_accessories_tools_m1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid tools_accessories_tools_m1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clstools_accessories_tools_m1DataSource($this);
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

        $this->accessory_description = & new clsControl(ccsLabel, "accessory_description", "accessory_description", ccsText, "", CCGetRequestParam("accessory_description", ccsGet, NULL), $this);
        $this->manufacturer_name = & new clsControl(ccsLabel, "manufacturer_name", "manufacturer_name", ccsText, "", CCGetRequestParam("manufacturer_name", ccsGet, NULL), $this);
        $this->part_number = & new clsControl(ccsLabel, "part_number", "part_number", ccsText, "", CCGetRequestParam("part_number", ccsGet, NULL), $this);
        $this->s_n = & new clsControl(ccsLabel, "s_n", "s_n", ccsText, "", CCGetRequestParam("s_n", ccsGet, NULL), $this);
        $this->location = & new clsControl(ccsLabel, "location", "location", ccsText, "", CCGetRequestParam("location", ccsGet, NULL), $this);
        $this->Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "page0_2_1.php";
        $this->supplier_name = & new clsControl(ccsLabel, "supplier_name", "supplier_name", ccsText, "", CCGetRequestParam("supplier_name", ccsGet, NULL), $this);
        $this->Navigator = & new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @5-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @5-B7B44325
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_tool_id"] = CCGetFromGet("s_tool_id", NULL);
        $this->DataSource->Parameters["urls_manufacturer_id"] = CCGetFromGet("s_manufacturer_id", NULL);
        $this->DataSource->Parameters["urls_supplier_id"] = CCGetFromGet("s_supplier_id", NULL);
        $this->DataSource->Parameters["urltool_id"] = CCGetFromGet("tool_id", NULL);

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
            $this->ControlsVisible["accessory_description"] = $this->accessory_description->Visible;
            $this->ControlsVisible["manufacturer_name"] = $this->manufacturer_name->Visible;
            $this->ControlsVisible["part_number"] = $this->part_number->Visible;
            $this->ControlsVisible["s_n"] = $this->s_n->Visible;
            $this->ControlsVisible["location"] = $this->location->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            $this->ControlsVisible["supplier_name"] = $this->supplier_name->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->accessory_description->SetValue($this->DataSource->accessory_description->GetValue());
                $this->manufacturer_name->SetValue($this->DataSource->manufacturer_name->GetValue());
                $this->part_number->SetValue($this->DataSource->part_number->GetValue());
                $this->s_n->SetValue($this->DataSource->s_n->GetValue());
                $this->location->SetValue($this->DataSource->location->GetValue());
                $this->Link1->Parameters = "";
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "accessory_id", $this->DataSource->f("accessory_id"));
                $this->supplier_name->SetValue($this->DataSource->supplier_name->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->accessory_description->Show();
                $this->manufacturer_name->Show();
                $this->part_number->Show();
                $this->s_n->Show();
                $this->location->Show();
                $this->Link1->Show();
                $this->supplier_name->Show();
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

//GetErrors Method @5-61D26670
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->accessory_description->Errors->ToString());
        $errors = ComposeStrings($errors, $this->manufacturer_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->part_number->Errors->ToString());
        $errors = ComposeStrings($errors, $this->s_n->Errors->ToString());
        $errors = ComposeStrings($errors, $this->location->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->supplier_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End tools_accessories_tools_m1 Class @5-FCB6E20C

class clstools_accessories_tools_m1DataSource extends clsDBhss_db {  //tools_accessories_tools_m1DataSource Class @5-9295F39A

//DataSource Variables @5-CDAE3881
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $CountSQL;
    var $wp;


    // Datasource fields
    var $accessory_description;
    var $manufacturer_name;
    var $part_number;
    var $s_n;
    var $location;
    var $supplier_name;
//End DataSource Variables

//DataSourceClass_Initialize Event @5-225E55C2
    function clstools_accessories_tools_m1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid tools_accessories_tools_m1";
        $this->Initialize();
        $this->accessory_description = new clsField("accessory_description", ccsText, "");
        
        $this->manufacturer_name = new clsField("manufacturer_name", ccsText, "");
        
        $this->part_number = new clsField("part_number", ccsText, "");
        
        $this->s_n = new clsField("s_n", ccsText, "");
        
        $this->location = new clsField("location", ccsText, "");
        
        $this->supplier_name = new clsField("supplier_name", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @5-7A6BCD5B
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "tools_accessories.accessory_description";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @5-68661C34
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_tool_id", ccsInteger, "", "", $this->Parameters["urls_tool_id"], "", false);
        $this->wp->AddParameter("2", "urls_manufacturer_id", ccsInteger, "", "", $this->Parameters["urls_manufacturer_id"], "", false);
        $this->wp->AddParameter("3", "urls_supplier_id", ccsInteger, "", "", $this->Parameters["urls_supplier_id"], "", false);
        $this->wp->AddParameter("4", "urltool_id", ccsInteger, "", "", $this->Parameters["urltool_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "tools_accessories.tool_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "tools_accessories.manufacturer_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "tools_accessories.supplier_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "tools_accessories.tool_id", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]), 
             $this->wp->Criterion[4]);
    }
//End Prepare Method

//Open Method @5-5BCEEE7F
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((tools_accessories INNER JOIN tools_manufacturers ON\n\n" .
        "tools_accessories.manufacturer_id = tools_manufacturers.manufacturer_id) INNER JOIN tools_suppliers ON\n\n" .
        "tools_accessories.supplier_id = tools_suppliers.supplier_id) INNER JOIN tools ON\n\n" .
        "tools_accessories.tool_id = tools.tool_id";
        $this->SQL = "SELECT manufacturer_name, supplier_name, tool_description, tools_accessories.* \n\n" .
        "FROM ((tools_accessories INNER JOIN tools_manufacturers ON\n\n" .
        "tools_accessories.manufacturer_id = tools_manufacturers.manufacturer_id) INNER JOIN tools_suppliers ON\n\n" .
        "tools_accessories.supplier_id = tools_suppliers.supplier_id) INNER JOIN tools ON\n\n" .
        "tools_accessories.tool_id = tools.tool_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @5-E8813EC1
    function SetValues()
    {
        $this->accessory_description->SetDBValue($this->f("accessory_description"));
        $this->manufacturer_name->SetDBValue($this->f("manufacturer_name"));
        $this->part_number->SetDBValue($this->f("part_number"));
        $this->s_n->SetDBValue($this->f("s_n"));
        $this->location->SetDBValue($this->f("location"));
        $this->supplier_name->SetDBValue($this->f("supplier_name"));
    }
//End SetValues Method

} //End tools_accessories_tools_m1DataSource Class @5-FCB6E20C





//Initialize Page @1-B25D71AB
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
$TemplateFileName = "page0_2.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-D85E1A64
include_once("./page0_2_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-A0F3BEFF
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tools_accessories_tools_m1 = & new clsGridtools_accessories_tools_m1("", $MainPage);
$Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $MainPage);
$Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link1->Parameters = CCAddParam($Link1->Parameters, "tool_id", CCGetFromGet("tool_id", NULL));
$Link1->Page = "page0_2_1.php";
$MainPage->tools_accessories_tools_m1 = & $tools_accessories_tools_m1;
$MainPage->Link1 = & $Link1;
$tools_accessories_tools_m1->Initialize();

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

//Go to destination page @1-903AD0F7
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($tools_accessories_tools_m1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-B6F52751
$tools_accessories_tools_m1->Show();
$Link1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-71F4A000
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($tools_accessories_tools_m1);
unset($Tpl);
//End Unload Page


?>
