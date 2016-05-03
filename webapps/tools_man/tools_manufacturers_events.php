<?php
//BindEvents Method @1-C3D12DCD
function BindEvents()
{
    global $tools_manufacturersSearch;
    global $CCSEvents;
    $tools_manufacturersSearch->s_manufacturer_name->CCSEvents["BeforeShow"] = "tools_manufacturersSearch_s_manufacturer_name_BeforeShow";
}
//End BindEvents Method

//tools_manufacturersSearch_s_manufacturer_name_BeforeShow @6-0FB2E033
function tools_manufacturersSearch_s_manufacturer_name_BeforeShow(& $sender)
{
    $tools_manufacturersSearch_s_manufacturer_name_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tools_manufacturersSearch; //Compatibility
//End tools_manufacturersSearch_s_manufacturer_name_BeforeShow

//PTAutocomplete1 BeforeShow @20-9CB2E222
    $Component->Attributes->SetValue('id', 'tools_manufacturersSearchs_manufacturer_name');
//End PTAutocomplete1 BeforeShow

//Close tools_manufacturersSearch_s_manufacturer_name_BeforeShow @6-FA85979B
    return $tools_manufacturersSearch_s_manufacturer_name_BeforeShow;
}
//End Close tools_manufacturersSearch_s_manufacturer_name_BeforeShow

//Page_BeforeInitialize @1-5268F183
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tools_manufacturers; //Compatibility
//End Page_BeforeInitialize

//PTAutocomplete1 Initialization @20-9D7A8773
    global $Charset;
    if ('tools_manufacturersSearchs_manufacturer_namePTAutocomplete1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete1 Initialization

//PTAutocomplete1 DataSource @20-B8C2CCF6
        $Service->DataSource = new clsDBhss_db();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM tools_manufacturers {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["posts_manufacturer_name"] = CCGetFromPost("s_manufacturer_name", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "posts_manufacturer_name", ccsText, "", "", $Service->DataSource->Parameters["posts_manufacturer_name"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "manufacturer_name", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete1 DataSource

//PTAutocomplete1 Charset @20-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete1 Charset

//PTAutocomplete1 DataFields @20-7B638BE0
        $Service->AddDataSourceField('manufacturer_name');
//End PTAutocomplete1 DataFields

//PTAutocomplete1 Execution @20-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete1 Execution

//PTAutocomplete1 Tail @20-27890EF8
        exit;
    }
//End PTAutocomplete1 Tail

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
