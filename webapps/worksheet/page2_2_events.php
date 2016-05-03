<?php
//BindEvents Method @1-F5DA36BF
function BindEvents()
{
    global $agents_tbl1;
    global $CCSEvents;
    $agents_tbl1->s_AGENT_NAME->CCSEvents["BeforeShow"] = "agents_tbl1_s_AGENT_NAME_BeforeShow";
}
//End BindEvents Method

//agents_tbl1_s_AGENT_NAME_BeforeShow @28-88507F2C
function agents_tbl1_s_AGENT_NAME_BeforeShow(& $sender)
{
    $agents_tbl1_s_AGENT_NAME_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $agents_tbl1; //Compatibility
//End agents_tbl1_s_AGENT_NAME_BeforeShow

//PTAutocomplete1 BeforeShow @30-BD2FF6FC
    $Component->Attributes->SetValue('id', 'agents_tbl1s_AGENT_NAME');
//End PTAutocomplete1 BeforeShow

//Close agents_tbl1_s_AGENT_NAME_BeforeShow @28-8C0FD5D0
    return $agents_tbl1_s_AGENT_NAME_BeforeShow;
}
//End Close agents_tbl1_s_AGENT_NAME_BeforeShow

//Page_BeforeInitialize @1-B599103C
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $page2_2; //Compatibility
//End Page_BeforeInitialize

//PTAutocomplete1 Initialization @30-2D38C07B
    global $Charset;
    if ('agents_tbl1s_AGENT_NAMEPTAutocomplete1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete1 Initialization

//PTAutocomplete1 DataSource @30-74B6B4F8
        $Service->DataSource = new clsDBhss_db();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM agents_tbl {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["posts_AGENT_NAME"] = CCGetFromPost("s_AGENT_NAME", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "posts_AGENT_NAME", ccsText, "", "", $Service->DataSource->Parameters["posts_AGENT_NAME"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "AGENT_NAME", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete1 DataSource

//PTAutocomplete1 Charset @30-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete1 Charset

//PTAutocomplete1 DataFields @30-2ABF975D
        $Service->AddDataSourceField('AGENT_NAME');
//End PTAutocomplete1 DataFields

//PTAutocomplete1 Execution @30-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete1 Execution

//PTAutocomplete1 Tail @30-27890EF8
        exit;
    }
//End PTAutocomplete1 Tail

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
