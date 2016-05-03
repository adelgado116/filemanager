<?php
//BindEvents Method @1-2EED739D
function BindEvents()
{
    global $sales_table_importedSearch;
    global $CCSEvents;
    $sales_table_importedSearch->s_CUSTOMERREF->CCSEvents["BeforeShow"] = "sales_table_importedSearch_s_CUSTOMERREF_BeforeShow";
}
//End BindEvents Method

//sales_table_importedSearch_s_CUSTOMERREF_BeforeShow @7-1EBD6DDD
function sales_table_importedSearch_s_CUSTOMERREF_BeforeShow(& $sender)
{
    $sales_table_importedSearch_s_CUSTOMERREF_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $sales_table_importedSearch; //Compatibility
//End sales_table_importedSearch_s_CUSTOMERREF_BeforeShow

//PTAutocomplete2 BeforeShow @27-5013243A
    $Component->Attributes->SetValue('id', 'sales_table_importedSearchs_CUSTOMERREF');
//End PTAutocomplete2 BeforeShow

//Close sales_table_importedSearch_s_CUSTOMERREF_BeforeShow @7-529F231B
    return $sales_table_importedSearch_s_CUSTOMERREF_BeforeShow;
}
//End Close sales_table_importedSearch_s_CUSTOMERREF_BeforeShow

//Page_BeforeInitialize @1-F73928AD
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $page1; //Compatibility
//End Page_BeforeInitialize

//PTAutocomplete2 Initialization @27-8149557F
    global $Charset;
    if ('sales_table_importedSearchs_CUSTOMERREFPTAutocomplete2' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete2 Initialization

//PTAutocomplete2 DataSource @27-EFFE6A60
        $Service->DataSource = new clsDBhss_db();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM ships_tbl {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["posts_CUSTOMERREF"] = CCGetFromPost("s_CUSTOMERREF", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "posts_CUSTOMERREF", ccsText, "", "", $Service->DataSource->Parameters["posts_CUSTOMERREF"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "SHIP_NAME", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete2 DataSource

//PTAutocomplete2 Charset @27-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete2 Charset

//PTAutocomplete2 DataFields @27-998BF8B1
        $Service->AddDataSourceField('SHIP_NAME');
//End PTAutocomplete2 DataFields

//PTAutocomplete2 Execution @27-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete2 Execution

//PTAutocomplete2 Tail @27-27890EF8
        exit;
    }
//End PTAutocomplete2 Tail

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
