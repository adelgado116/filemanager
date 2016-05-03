<?php
//BindEvents Method @1-97EADAD0
function BindEvents()
{
    global $toolsSearch;
    global $CCSEvents;
    $toolsSearch->s_tool_description->CCSEvents["BeforeShow"] = "toolsSearch_s_tool_description_BeforeShow";
}
//End BindEvents Method

//toolsSearch_s_tool_description_BeforeShow @70-32D32181
function toolsSearch_s_tool_description_BeforeShow(& $sender)
{
    $toolsSearch_s_tool_description_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $toolsSearch; //Compatibility
//End toolsSearch_s_tool_description_BeforeShow

//PTAutocomplete1 BeforeShow @88-9E47F887
    $Component->Attributes->SetValue('id', 'toolsSearchs_tool_description');
//End PTAutocomplete1 BeforeShow

//Close toolsSearch_s_tool_description_BeforeShow @70-9620B047
    return $toolsSearch_s_tool_description_BeforeShow;
}
//End Close toolsSearch_s_tool_description_BeforeShow

//Page_BeforeInitialize @1-709FE3EE
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $page0; //Compatibility
//End Page_BeforeInitialize

//PTAutocomplete1 Initialization @88-53D7E9D7
    global $Charset;
    if ('toolsSearchs_tool_descriptionPTAutocomplete1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete1 Initialization

//PTAutocomplete1 DataSource @88-608A2AC4
        $Service->DataSource = new clsDBhss_db();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM tools {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["posts_tool_description"] = CCGetFromPost("s_tool_description", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "posts_tool_description", ccsText, "", "", $Service->DataSource->Parameters["posts_tool_description"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "tool_description", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete1 DataSource

//PTAutocomplete1 Charset @88-4F7C968C
        $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete1 Charset

//PTAutocomplete1 DataFields @88-DE5B2CD3
        $Service->AddDataSourceField('tool_description');
//End PTAutocomplete1 DataFields

//PTAutocomplete1 Execution @88-D749E478
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End PTAutocomplete1 Execution

//PTAutocomplete1 Tail @88-27890EF8
        exit;
    }
//End PTAutocomplete1 Tail

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
