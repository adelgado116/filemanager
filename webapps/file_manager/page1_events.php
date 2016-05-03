<?php
//BindEvents Method @1-A94AB6FA
function BindEvents()
{
    global $ships_tblSearch;
    global $CCSEvents;
    $ships_tblSearch->s_SHIP_NAME->CCSEvents["BeforeShow"] = "ships_tblSearch_s_SHIP_NAME_BeforeShow";
    $ships_tblSearch->s_IMO_NUMBER->CCSEvents["BeforeShow"] = "ships_tblSearch_s_IMO_NUMBER_BeforeShow";
}
//End BindEvents Method

//ships_tblSearch_s_SHIP_NAME_BeforeShow @5-4C8ACAC2
function ships_tblSearch_s_SHIP_NAME_BeforeShow(& $sender)
{
    $ships_tblSearch_s_SHIP_NAME_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $ships_tblSearch; //Compatibility
//End ships_tblSearch_s_SHIP_NAME_BeforeShow

//PTAutocomplete1 BeforeShow @15-40F32FE7
    $Component->Attributes->SetValue('id', 'ships_tblSearchs_SHIP_NAME');
//End PTAutocomplete1 BeforeShow

//Close ships_tblSearch_s_SHIP_NAME_BeforeShow @5-CFEA5C1E
    return $ships_tblSearch_s_SHIP_NAME_BeforeShow;
}
//End Close ships_tblSearch_s_SHIP_NAME_BeforeShow

//ships_tblSearch_s_IMO_NUMBER_BeforeShow @6-9F7442CA
function ships_tblSearch_s_IMO_NUMBER_BeforeShow(& $sender)
{
    $ships_tblSearch_s_IMO_NUMBER_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $ships_tblSearch; //Compatibility
//End ships_tblSearch_s_IMO_NUMBER_BeforeShow

//PTAutocomplete2 BeforeShow @17-D0750AE6
    $Component->Attributes->SetValue('id', 'ships_tblSearchs_IMO_NUMBER');
//End PTAutocomplete2 BeforeShow

//Close ships_tblSearch_s_IMO_NUMBER_BeforeShow @6-1C7836CE
    return $ships_tblSearch_s_IMO_NUMBER_BeforeShow;
}
//End Close ships_tblSearch_s_IMO_NUMBER_BeforeShow

//Page_BeforeInitialize @1-F73928AD
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $page1; //Compatibility
//End Page_BeforeInitialize

//PTAutocomplete1 Initialization @15-49135B9D
    global $Charset;
    if ('ships_tblSearchs_SHIP_NAMEPTAutocomplete1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete1 Initialization

//PTAutocomplete1 DataSource @15-63D40112
        $Service->DataSource = new clsDBhss_db();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM ships_tbl {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["posts_SHIP_NAME"] = CCGetFromPost("s_SHIP_NAME", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "posts_SHIP_NAME", ccsText, "", "", $Service->DataSource->Parameters["posts_SHIP_NAME"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "SHIP_NAME", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete1 DataSource

//PTAutocomplete1 Charset @15-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete1 Charset

//PTAutocomplete1 DataFields @15-998BF8B1
        $Service->AddDataSourceField('SHIP_NAME');
//End PTAutocomplete1 DataFields

//PTAutocomplete1 Execution @15-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete1 Execution

//PTAutocomplete1 Tail @15-27890EF8
        exit;
    }
//End PTAutocomplete1 Tail

//PTAutocomplete2 Initialization @17-F674D84E
    global $Charset;
    if ('ships_tblSearchs_IMO_NUMBERPTAutocomplete2' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete2 Initialization

//PTAutocomplete2 DataSource @17-46F1B2A6
        $Service->DataSource = new clsDBhss_db();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM ships_tbl {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["posts_IMO_NUMBER"] = CCGetFromPost("s_IMO_NUMBER", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "posts_IMO_NUMBER", ccsText, "", "", $Service->DataSource->Parameters["posts_IMO_NUMBER"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "IMO_NUMBER", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete2 DataSource

//PTAutocomplete2 Charset @17-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete2 Charset

//PTAutocomplete2 DataFields @17-52A486F0
        $Service->AddDataSourceField('IMO_NUMBER');
//End PTAutocomplete2 DataFields

//PTAutocomplete2 Execution @17-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete2 Execution

//PTAutocomplete2 Tail @17-27890EF8
        exit;
    }
//End PTAutocomplete2 Tail

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
