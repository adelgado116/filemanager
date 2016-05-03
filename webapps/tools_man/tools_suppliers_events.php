<?php
//BindEvents Method @1-9ED415EF
function BindEvents()
{
    global $tools_suppliersSearch;
    global $CCSEvents;
    $tools_suppliersSearch->s_supplier_name->CCSEvents["BeforeShow"] = "tools_suppliersSearch_s_supplier_name_BeforeShow";
}
//End BindEvents Method

//tools_suppliersSearch_s_supplier_name_BeforeShow @6-FA0BEECF
function tools_suppliersSearch_s_supplier_name_BeforeShow(& $sender)
{
    $tools_suppliersSearch_s_supplier_name_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tools_suppliersSearch; //Compatibility
//End tools_suppliersSearch_s_supplier_name_BeforeShow

//PTAutocomplete1 BeforeShow @21-D900C38E
    $Component->Attributes->SetValue('id', 'tools_suppliersSearchs_supplier_name');
//End PTAutocomplete1 BeforeShow

//Close tools_suppliersSearch_s_supplier_name_BeforeShow @6-900BD38F
    return $tools_suppliersSearch_s_supplier_name_BeforeShow;
}
//End Close tools_suppliersSearch_s_supplier_name_BeforeShow

//Page_BeforeInitialize @1-8CB02515
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tools_suppliers; //Compatibility
//End Page_BeforeInitialize

//PTAutocomplete1 Initialization @21-777FA54C
    global $Charset;
    if ('tools_suppliersSearchs_supplier_namePTAutocomplete1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete1 Initialization

//PTAutocomplete1 DataSource @21-FE4A0F65
        $Service->DataSource = new clsDBhss_db();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM tools_suppliers {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["posts_supplier_name"] = CCGetFromPost("s_supplier_name", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "posts_supplier_name", ccsText, "", "", $Service->DataSource->Parameters["posts_supplier_name"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "supplier_name", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete1 DataSource

//PTAutocomplete1 Charset @21-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete1 Charset

//PTAutocomplete1 DataFields @21-28B8BAFB
        $Service->AddDataSourceField('supplier_name');
//End PTAutocomplete1 DataFields

//PTAutocomplete1 Execution @21-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete1 Execution

//PTAutocomplete1 Tail @21-27890EF8
        exit;
    }
//End PTAutocomplete1 Tail

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
