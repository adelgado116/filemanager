<?php
//BindEvents Method @1-5D110341
function BindEvents()
{
    global $equipment_manufacturer_tb;
    global $CCSEvents;
    $equipment_manufacturer_tb->s_EQUIP_MODEL->CCSEvents["BeforeShow"] = "equipment_manufacturer_tb_s_EQUIP_MODEL_BeforeShow";
}
//End BindEvents Method

//equipment_manufacturer_tb_s_EQUIP_MODEL_BeforeShow @21-4956AB98
function equipment_manufacturer_tb_s_EQUIP_MODEL_BeforeShow(& $sender)
{
    $equipment_manufacturer_tb_s_EQUIP_MODEL_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $equipment_manufacturer_tb; //Compatibility
//End equipment_manufacturer_tb_s_EQUIP_MODEL_BeforeShow

//PTAutocomplete1 BeforeShow @36-6D344D1D
    $Component->Attributes->SetValue('id', 'equipment_manufacturer_tbs_EQUIP_MODEL');
//End PTAutocomplete1 BeforeShow

//PTAutocomplete2 BeforeShow @38-6D344D1D
    $Component->Attributes->SetValue('id', 'equipment_manufacturer_tbs_EQUIP_MODEL');
//End PTAutocomplete2 BeforeShow

//Close equipment_manufacturer_tb_s_EQUIP_MODEL_BeforeShow @21-F334EE4A
    return $equipment_manufacturer_tb_s_EQUIP_MODEL_BeforeShow;
}
//End Close equipment_manufacturer_tb_s_EQUIP_MODEL_BeforeShow

//Page_BeforeInitialize @1-2305B86A
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $page3; //Compatibility
//End Page_BeforeInitialize

//PTAutocomplete1 Initialization @36-10B3EA08
    global $Charset;
    if ('equipment_manufacturer_tbs_EQUIP_MODELPTAutocomplete1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete1 Initialization

//PTAutocomplete1 DataSource @36-9FD0495F
        $Service->DataSource = new clsDBhss_db();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM equipment_model_tbl {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["posts_EQUIP_MODEL"] = CCGetFromPost("s_EQUIP_MODEL", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "posts_EQUIP_MODEL", ccsText, "", "", $Service->DataSource->Parameters["posts_EQUIP_MODEL"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "EQUIP_MODEL", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete1 DataSource

//PTAutocomplete1 Charset @36-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete1 Charset

//PTAutocomplete1 DataFields @36-308D3AC3
        $Service->AddDataSourceField('EQUIP_MODEL');
//End PTAutocomplete1 DataFields

//PTAutocomplete1 Execution @36-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete1 Execution

//PTAutocomplete1 Tail @36-27890EF8
        exit;
    }
//End PTAutocomplete1 Tail

//PTAutocomplete2 Initialization @38-8E13A1AF
    global $Charset;
    if ('equipment_manufacturer_tbs_EQUIP_MODELPTAutocomplete2' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete2 Initialization

//PTAutocomplete2 DataSource @38-9FD0495F
        $Service->DataSource = new clsDBhss_db();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM equipment_model_tbl {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["posts_EQUIP_MODEL"] = CCGetFromPost("s_EQUIP_MODEL", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "posts_EQUIP_MODEL", ccsText, "", "", $Service->DataSource->Parameters["posts_EQUIP_MODEL"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "EQUIP_MODEL", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete2 DataSource

//PTAutocomplete2 Charset @38-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete2 Charset

//PTAutocomplete2 DataFields @38-308D3AC3
        $Service->AddDataSourceField('EQUIP_MODEL');
//End PTAutocomplete2 DataFields

//PTAutocomplete2 Execution @38-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete2 Execution

//PTAutocomplete2 Tail @38-27890EF8
        exit;
    }
//End PTAutocomplete2 Tail

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
