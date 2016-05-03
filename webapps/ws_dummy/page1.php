<?php
//Include Common Files @1-FB3B84F7
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page1.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordws_dummy { //ws_dummy Class @2-3625DBDB

//Variables @2-D6FF3E86

    // Public variables
    var $ComponentType = "Record";
    var $ComponentName;
    var $Parent;
    var $HTMLFormAction;
    var $PressedButton;
    var $Errors;
    var $ErrorBlock;
    var $FormSubmitted;
    var $FormEnctype;
    var $Visible;
    var $IsEmpty;

    var $CCSEvents = "";
    var $CCSEventResult;

    var $RelativePath = "";

    var $InsertAllowed = false;
    var $UpdateAllowed = false;
    var $DeleteAllowed = false;
    var $ReadAllowed   = false;
    var $EditMode      = false;
    var $ds;
    var $DataSource;
    var $ValidatingControls;
    var $Controls;
    var $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @2-B7F7B0EA
    function clsRecordws_dummy($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record ws_dummy/Error";
        $this->DataSource = new clsws_dummyDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "ws_dummy";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = & new clsButton("Button_Insert", $Method, $this);
            $this->order_no = & new clsControl(ccsTextBox, "order_no", "Order No", ccsText, "", CCGetRequestParam("order_no", $Method, NULL), $this);
            $this->shipname = & new clsControl(ccsTextBox, "shipname", "Shipname", ccsText, "", CCGetRequestParam("shipname", $Method, NULL), $this);
            $this->imo_number = & new clsControl(ccsTextBox, "imo_number", "Imo Number", ccsText, "", CCGetRequestParam("imo_number", $Method, NULL), $this);
            $this->equipment = & new clsControl(ccsTextBox, "equipment", "Equipment", ccsText, "", CCGetRequestParam("equipment", $Method, NULL), $this);
            $this->service_type = & new clsControl(ccsTextBox, "service_type", "Service Type", ccsText, "", CCGetRequestParam("service_type", $Method, NULL), $this);
            $this->warranty = & new clsControl(ccsCheckBox, "warranty", "Warranty", ccsText, "", CCGetRequestParam("warranty", $Method, NULL), $this);
            $this->warranty->CheckedValue = $this->warranty->GetParsedValue(Yes);
            $this->warranty->UncheckedValue = $this->warranty->GetParsedValue(No);
            $this->approved_by = & new clsControl(ccsTextBox, "approved_by", "Approved By", ccsText, "", CCGetRequestParam("approved_by", $Method, NULL), $this);
            $this->remarks = & new clsControl(ccsTextArea, "remarks", "Remarks", ccsMemo, "", CCGetRequestParam("remarks", $Method, NULL), $this);
            $this->country = & new clsControl(ccsTextBox, "country", "Country", ccsText, "", CCGetRequestParam("country", $Method, NULL), $this);
            $this->port = & new clsControl(ccsTextBox, "port", "Port", ccsText, "", CCGetRequestParam("port", $Method, NULL), $this);
            $this->agent = & new clsControl(ccsTextBox, "agent", "Agent", ccsText, "", CCGetRequestParam("agent", $Method, NULL), $this);
            $this->eta_date = & new clsControl(ccsTextBox, "eta_date", "Eta Date", ccsText, "", CCGetRequestParam("eta_date", $Method, NULL), $this);
            $this->eta_time = & new clsControl(ccsTextBox, "eta_time", "Eta Time", ccsText, "", CCGetRequestParam("eta_time", $Method, NULL), $this);
            $this->ref_called_on = & new clsControl(ccsTextBox, "ref_called_on", "Ref Called On", ccsText, "", CCGetRequestParam("ref_called_on", $Method, NULL), $this);
            $this->ref_time = & new clsControl(ccsTextBox, "ref_time", "Ref Time", ccsText, "", CCGetRequestParam("ref_time", $Method, NULL), $this);
            $this->ref_talked_to = & new clsControl(ccsTextBox, "ref_talked_to", "Ref Talked To", ccsText, "", CCGetRequestParam("ref_talked_to", $Method, NULL), $this);
            $this->invoice_to = & new clsControl(ccsTextBox, "invoice_to", "Invoice To", ccsText, "", CCGetRequestParam("invoice_to", $Method, NULL), $this);
            $this->po_no = & new clsControl(ccsTextBox, "po_no", "Po No", ccsText, "", CCGetRequestParam("po_no", $Method, NULL), $this);
            $this->debtor_account = & new clsControl(ccsTextBox, "debtor_account", "Debtor Account", ccsText, "", CCGetRequestParam("debtor_account", $Method, NULL), $this);
            $this->DatePicker_eta_date1 = & new clsDatePicker("DatePicker_eta_date1", "ws_dummy", "eta_date", $this);
            $this->DatePicker_ref_called_on1 = & new clsDatePicker("DatePicker_ref_called_on1", "ws_dummy", "ref_called_on", $this);
            $this->agent_phone_1 = & new clsControl(ccsTextBox, "agent_phone_1", "Agent Phone 1", ccsText, "", CCGetRequestParam("agent_phone_1", $Method, NULL), $this);
            $this->agent_phone_2 = & new clsControl(ccsTextBox, "agent_phone_2", "Agent Phone 2", ccsText, "", CCGetRequestParam("agent_phone_2", $Method, NULL), $this);
            $this->agent_fax = & new clsControl(ccsTextBox, "agent_fax", "Agent Fax", ccsText, "", CCGetRequestParam("agent_fax", $Method, NULL), $this);
            $this->agent_email = & new clsControl(ccsTextBox, "agent_email", "Agent Email", ccsText, "", CCGetRequestParam("agent_email", $Method, NULL), $this);
            $this->agent_mobile = & new clsControl(ccsTextBox, "agent_mobile", "Agent Mobile", ccsText, "", CCGetRequestParam("agent_mobile", $Method, NULL), $this);
            $this->agent_boarding = & new clsControl(ccsTextBox, "agent_boarding", "Agent Mobile", ccsText, "", CCGetRequestParam("agent_boarding", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->warranty->Value) && !strlen($this->warranty->Value) && $this->warranty->Value !== false)
                    $this->warranty->SetValue(false);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @2-0B9B5DAA
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlworksheet_id"] = CCGetFromGet("worksheet_id", NULL);
    }
//End Initialize Method

//Validate Method @2-B472FA75
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->order_no->Validate() && $Validation);
        $Validation = ($this->shipname->Validate() && $Validation);
        $Validation = ($this->imo_number->Validate() && $Validation);
        $Validation = ($this->equipment->Validate() && $Validation);
        $Validation = ($this->service_type->Validate() && $Validation);
        $Validation = ($this->warranty->Validate() && $Validation);
        $Validation = ($this->approved_by->Validate() && $Validation);
        $Validation = ($this->remarks->Validate() && $Validation);
        $Validation = ($this->country->Validate() && $Validation);
        $Validation = ($this->port->Validate() && $Validation);
        $Validation = ($this->agent->Validate() && $Validation);
        $Validation = ($this->eta_date->Validate() && $Validation);
        $Validation = ($this->eta_time->Validate() && $Validation);
        $Validation = ($this->ref_called_on->Validate() && $Validation);
        $Validation = ($this->ref_time->Validate() && $Validation);
        $Validation = ($this->ref_talked_to->Validate() && $Validation);
        $Validation = ($this->invoice_to->Validate() && $Validation);
        $Validation = ($this->po_no->Validate() && $Validation);
        $Validation = ($this->debtor_account->Validate() && $Validation);
        $Validation = ($this->agent_phone_1->Validate() && $Validation);
        $Validation = ($this->agent_phone_2->Validate() && $Validation);
        $Validation = ($this->agent_fax->Validate() && $Validation);
        $Validation = ($this->agent_email->Validate() && $Validation);
        $Validation = ($this->agent_mobile->Validate() && $Validation);
        $Validation = ($this->agent_boarding->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->order_no->Errors->Count() == 0);
        $Validation =  $Validation && ($this->shipname->Errors->Count() == 0);
        $Validation =  $Validation && ($this->imo_number->Errors->Count() == 0);
        $Validation =  $Validation && ($this->equipment->Errors->Count() == 0);
        $Validation =  $Validation && ($this->service_type->Errors->Count() == 0);
        $Validation =  $Validation && ($this->warranty->Errors->Count() == 0);
        $Validation =  $Validation && ($this->approved_by->Errors->Count() == 0);
        $Validation =  $Validation && ($this->remarks->Errors->Count() == 0);
        $Validation =  $Validation && ($this->country->Errors->Count() == 0);
        $Validation =  $Validation && ($this->port->Errors->Count() == 0);
        $Validation =  $Validation && ($this->agent->Errors->Count() == 0);
        $Validation =  $Validation && ($this->eta_date->Errors->Count() == 0);
        $Validation =  $Validation && ($this->eta_time->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ref_called_on->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ref_time->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ref_talked_to->Errors->Count() == 0);
        $Validation =  $Validation && ($this->invoice_to->Errors->Count() == 0);
        $Validation =  $Validation && ($this->po_no->Errors->Count() == 0);
        $Validation =  $Validation && ($this->debtor_account->Errors->Count() == 0);
        $Validation =  $Validation && ($this->agent_phone_1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->agent_phone_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->agent_fax->Errors->Count() == 0);
        $Validation =  $Validation && ($this->agent_email->Errors->Count() == 0);
        $Validation =  $Validation && ($this->agent_mobile->Errors->Count() == 0);
        $Validation =  $Validation && ($this->agent_boarding->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-3BA506F0
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->order_no->Errors->Count());
        $errors = ($errors || $this->shipname->Errors->Count());
        $errors = ($errors || $this->imo_number->Errors->Count());
        $errors = ($errors || $this->equipment->Errors->Count());
        $errors = ($errors || $this->service_type->Errors->Count());
        $errors = ($errors || $this->warranty->Errors->Count());
        $errors = ($errors || $this->approved_by->Errors->Count());
        $errors = ($errors || $this->remarks->Errors->Count());
        $errors = ($errors || $this->country->Errors->Count());
        $errors = ($errors || $this->port->Errors->Count());
        $errors = ($errors || $this->agent->Errors->Count());
        $errors = ($errors || $this->eta_date->Errors->Count());
        $errors = ($errors || $this->eta_time->Errors->Count());
        $errors = ($errors || $this->ref_called_on->Errors->Count());
        $errors = ($errors || $this->ref_time->Errors->Count());
        $errors = ($errors || $this->ref_talked_to->Errors->Count());
        $errors = ($errors || $this->invoice_to->Errors->Count());
        $errors = ($errors || $this->po_no->Errors->Count());
        $errors = ($errors || $this->debtor_account->Errors->Count());
        $errors = ($errors || $this->DatePicker_eta_date1->Errors->Count());
        $errors = ($errors || $this->DatePicker_ref_called_on1->Errors->Count());
        $errors = ($errors || $this->agent_phone_1->Errors->Count());
        $errors = ($errors || $this->agent_phone_2->Errors->Count());
        $errors = ($errors || $this->agent_fax->Errors->Count());
        $errors = ($errors || $this->agent_email->Errors->Count());
        $errors = ($errors || $this->agent_mobile->Errors->Count());
        $errors = ($errors || $this->agent_boarding->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @2-ED598703
function SetPrimaryKeys($keyArray)
{
    $this->PrimaryKeys = $keyArray;
}
function GetPrimaryKeys()
{
    return $this->PrimaryKeys;
}
function GetPrimaryKey($keyName)
{
    return $this->PrimaryKeys[$keyName];
}
//End MasterDetail

//Operation Method @2-327C0C16
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted) {
            $this->EditMode = $this->DataSource->AllParametersSet;
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            }
        }
        $Redirect = "page2.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//InsertRow Method @2-271018D3
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->order_no->SetValue($this->order_no->GetValue(true));
        $this->DataSource->shipname->SetValue($this->shipname->GetValue(true));
        $this->DataSource->imo_number->SetValue($this->imo_number->GetValue(true));
        $this->DataSource->equipment->SetValue($this->equipment->GetValue(true));
        $this->DataSource->service_type->SetValue($this->service_type->GetValue(true));
        $this->DataSource->warranty->SetValue($this->warranty->GetValue(true));
        $this->DataSource->approved_by->SetValue($this->approved_by->GetValue(true));
        $this->DataSource->remarks->SetValue($this->remarks->GetValue(true));
        $this->DataSource->country->SetValue($this->country->GetValue(true));
        $this->DataSource->port->SetValue($this->port->GetValue(true));
        $this->DataSource->agent->SetValue($this->agent->GetValue(true));
        $this->DataSource->eta_date->SetValue($this->eta_date->GetValue(true));
        $this->DataSource->eta_time->SetValue($this->eta_time->GetValue(true));
        $this->DataSource->ref_called_on->SetValue($this->ref_called_on->GetValue(true));
        $this->DataSource->ref_time->SetValue($this->ref_time->GetValue(true));
        $this->DataSource->ref_talked_to->SetValue($this->ref_talked_to->GetValue(true));
        $this->DataSource->invoice_to->SetValue($this->invoice_to->GetValue(true));
        $this->DataSource->po_no->SetValue($this->po_no->GetValue(true));
        $this->DataSource->debtor_account->SetValue($this->debtor_account->GetValue(true));
        $this->DataSource->agent_phone_1->SetValue($this->agent_phone_1->GetValue(true));
        $this->DataSource->agent_phone_2->SetValue($this->agent_phone_2->GetValue(true));
        $this->DataSource->agent_fax->SetValue($this->agent_fax->GetValue(true));
        $this->DataSource->agent_email->SetValue($this->agent_email->GetValue(true));
        $this->DataSource->agent_mobile->SetValue($this->agent_mobile->GetValue(true));
        $this->DataSource->agent_boarding->SetValue($this->agent_boarding->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//Show Method @2-89742CC5
    function Show()
    {
        global $CCSUseAmp;
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                if(!$this->FormSubmitted){
                    $this->order_no->SetValue($this->DataSource->order_no->GetValue());
                    $this->shipname->SetValue($this->DataSource->shipname->GetValue());
                    $this->imo_number->SetValue($this->DataSource->imo_number->GetValue());
                    $this->equipment->SetValue($this->DataSource->equipment->GetValue());
                    $this->service_type->SetValue($this->DataSource->service_type->GetValue());
                    $this->warranty->SetValue($this->DataSource->warranty->GetValue());
                    $this->approved_by->SetValue($this->DataSource->approved_by->GetValue());
                    $this->remarks->SetValue($this->DataSource->remarks->GetValue());
                    $this->country->SetValue($this->DataSource->country->GetValue());
                    $this->port->SetValue($this->DataSource->port->GetValue());
                    $this->agent->SetValue($this->DataSource->agent->GetValue());
                    $this->eta_date->SetValue($this->DataSource->eta_date->GetValue());
                    $this->eta_time->SetValue($this->DataSource->eta_time->GetValue());
                    $this->ref_called_on->SetValue($this->DataSource->ref_called_on->GetValue());
                    $this->ref_time->SetValue($this->DataSource->ref_time->GetValue());
                    $this->ref_talked_to->SetValue($this->DataSource->ref_talked_to->GetValue());
                    $this->invoice_to->SetValue($this->DataSource->invoice_to->GetValue());
                    $this->po_no->SetValue($this->DataSource->po_no->GetValue());
                    $this->debtor_account->SetValue($this->DataSource->debtor_account->GetValue());
                    $this->agent_phone_1->SetValue($this->DataSource->agent_phone_1->GetValue());
                    $this->agent_phone_2->SetValue($this->DataSource->agent_phone_2->GetValue());
                    $this->agent_fax->SetValue($this->DataSource->agent_fax->GetValue());
                    $this->agent_email->SetValue($this->DataSource->agent_email->GetValue());
                    $this->agent_mobile->SetValue($this->DataSource->agent_mobile->GetValue());
                    $this->agent_boarding->SetValue($this->DataSource->agent_boarding->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->order_no->Errors->ToString());
            $Error = ComposeStrings($Error, $this->shipname->Errors->ToString());
            $Error = ComposeStrings($Error, $this->imo_number->Errors->ToString());
            $Error = ComposeStrings($Error, $this->equipment->Errors->ToString());
            $Error = ComposeStrings($Error, $this->service_type->Errors->ToString());
            $Error = ComposeStrings($Error, $this->warranty->Errors->ToString());
            $Error = ComposeStrings($Error, $this->approved_by->Errors->ToString());
            $Error = ComposeStrings($Error, $this->remarks->Errors->ToString());
            $Error = ComposeStrings($Error, $this->country->Errors->ToString());
            $Error = ComposeStrings($Error, $this->port->Errors->ToString());
            $Error = ComposeStrings($Error, $this->agent->Errors->ToString());
            $Error = ComposeStrings($Error, $this->eta_date->Errors->ToString());
            $Error = ComposeStrings($Error, $this->eta_time->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ref_called_on->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ref_time->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ref_talked_to->Errors->ToString());
            $Error = ComposeStrings($Error, $this->invoice_to->Errors->ToString());
            $Error = ComposeStrings($Error, $this->po_no->Errors->ToString());
            $Error = ComposeStrings($Error, $this->debtor_account->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_eta_date1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_ref_called_on1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->agent_phone_1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->agent_phone_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->agent_fax->Errors->ToString());
            $Error = ComposeStrings($Error, $this->agent_email->Errors->ToString());
            $Error = ComposeStrings($Error, $this->agent_mobile->Errors->ToString());
            $Error = ComposeStrings($Error, $this->agent_boarding->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
        $this->Button_Insert->Visible = !$this->EditMode && $this->InsertAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->order_no->Show();
        $this->shipname->Show();
        $this->imo_number->Show();
        $this->equipment->Show();
        $this->service_type->Show();
        $this->warranty->Show();
        $this->approved_by->Show();
        $this->remarks->Show();
        $this->country->Show();
        $this->port->Show();
        $this->agent->Show();
        $this->eta_date->Show();
        $this->eta_time->Show();
        $this->ref_called_on->Show();
        $this->ref_time->Show();
        $this->ref_talked_to->Show();
        $this->invoice_to->Show();
        $this->po_no->Show();
        $this->debtor_account->Show();
        $this->DatePicker_eta_date1->Show();
        $this->DatePicker_ref_called_on1->Show();
        $this->agent_phone_1->Show();
        $this->agent_phone_2->Show();
        $this->agent_fax->Show();
        $this->agent_email->Show();
        $this->agent_mobile->Show();
        $this->agent_boarding->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End ws_dummy Class @2-FCB6E20C

class clsws_dummyDataSource extends clsDBhss_db {  //ws_dummyDataSource Class @2-006ABB0F

//DataSource Variables @2-90F20B81
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $InsertParameters;
    var $wp;
    var $AllParametersSet;

    var $InsertFields = array();

    // Datasource fields
    var $order_no;
    var $shipname;
    var $imo_number;
    var $equipment;
    var $service_type;
    var $warranty;
    var $approved_by;
    var $remarks;
    var $country;
    var $port;
    var $agent;
    var $eta_date;
    var $eta_time;
    var $ref_called_on;
    var $ref_time;
    var $ref_talked_to;
    var $invoice_to;
    var $po_no;
    var $debtor_account;
    var $agent_phone_1;
    var $agent_phone_2;
    var $agent_fax;
    var $agent_email;
    var $agent_mobile;
    var $agent_boarding;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-1EC925A7
    function clsws_dummyDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record ws_dummy/Error";
        $this->Initialize();
        $this->order_no = new clsField("order_no", ccsText, "");
        
        $this->shipname = new clsField("shipname", ccsText, "");
        
        $this->imo_number = new clsField("imo_number", ccsText, "");
        
        $this->equipment = new clsField("equipment", ccsText, "");
        
        $this->service_type = new clsField("service_type", ccsText, "");
        
        $this->warranty = new clsField("warranty", ccsText, "");
        
        $this->approved_by = new clsField("approved_by", ccsText, "");
        
        $this->remarks = new clsField("remarks", ccsMemo, "");
        
        $this->country = new clsField("country", ccsText, "");
        
        $this->port = new clsField("port", ccsText, "");
        
        $this->agent = new clsField("agent", ccsText, "");
        
        $this->eta_date = new clsField("eta_date", ccsText, "");
        
        $this->eta_time = new clsField("eta_time", ccsText, "");
        
        $this->ref_called_on = new clsField("ref_called_on", ccsText, "");
        
        $this->ref_time = new clsField("ref_time", ccsText, "");
        
        $this->ref_talked_to = new clsField("ref_talked_to", ccsText, "");
        
        $this->invoice_to = new clsField("invoice_to", ccsText, "");
        
        $this->po_no = new clsField("po_no", ccsText, "");
        
        $this->debtor_account = new clsField("debtor_account", ccsText, "");
        
        $this->agent_phone_1 = new clsField("agent_phone_1", ccsText, "");
        
        $this->agent_phone_2 = new clsField("agent_phone_2", ccsText, "");
        
        $this->agent_fax = new clsField("agent_fax", ccsText, "");
        
        $this->agent_email = new clsField("agent_email", ccsText, "");
        
        $this->agent_mobile = new clsField("agent_mobile", ccsText, "");
        
        $this->agent_boarding = new clsField("agent_boarding", ccsText, "");
        

        $this->InsertFields["order_no"] = array("Name" => "order_no", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["shipname"] = array("Name" => "shipname", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["imo_number"] = array("Name" => "imo_number", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["equipment"] = array("Name" => "equipment", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["service_type"] = array("Name" => "service_type", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["warranty"] = array("Name" => "warranty", "Value" => "", "DataType" => ccsText);
        $this->InsertFields["approved_by"] = array("Name" => "approved_by", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["remarks"] = array("Name" => "remarks", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->InsertFields["country"] = array("Name" => "country", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["port"] = array("Name" => "port", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["agent"] = array("Name" => "agent", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["eta_date"] = array("Name" => "eta_date", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["eta_time"] = array("Name" => "eta_time", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["ref_called_on"] = array("Name" => "ref_called_on", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["ref_time"] = array("Name" => "ref_time", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["ref_talked_to"] = array("Name" => "ref_talked_to", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["invoice_to"] = array("Name" => "invoice_to", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["po_no"] = array("Name" => "po_no", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["debtor_account"] = array("Name" => "debtor_account", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["agent_phone_1"] = array("Name" => "agent_phone_1", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["agent_phone_2"] = array("Name" => "agent_phone_2", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["agent_fax"] = array("Name" => "agent_fax", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["agent_email"] = array("Name" => "agent_email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["agent_mobile"] = array("Name" => "agent_mobile", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["agent_boarding"] = array("Name" => "agent_boarding", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-D1201BC4
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlworksheet_id", ccsInteger, "", "", $this->Parameters["urlworksheet_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "worksheet_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-948F10C6
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM ws_dummy {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-C810AB6A
    function SetValues()
    {
        $this->order_no->SetDBValue($this->f("order_no"));
        $this->shipname->SetDBValue($this->f("shipname"));
        $this->imo_number->SetDBValue($this->f("imo_number"));
        $this->equipment->SetDBValue($this->f("equipment"));
        $this->service_type->SetDBValue($this->f("service_type"));
        $this->warranty->SetDBValue($this->f("warranty"));
        $this->approved_by->SetDBValue($this->f("approved_by"));
        $this->remarks->SetDBValue($this->f("remarks"));
        $this->country->SetDBValue($this->f("country"));
        $this->port->SetDBValue($this->f("port"));
        $this->agent->SetDBValue($this->f("agent"));
        $this->eta_date->SetDBValue($this->f("eta_date"));
        $this->eta_time->SetDBValue($this->f("eta_time"));
        $this->ref_called_on->SetDBValue($this->f("ref_called_on"));
        $this->ref_time->SetDBValue($this->f("ref_time"));
        $this->ref_talked_to->SetDBValue($this->f("ref_talked_to"));
        $this->invoice_to->SetDBValue($this->f("invoice_to"));
        $this->po_no->SetDBValue($this->f("po_no"));
        $this->debtor_account->SetDBValue($this->f("debtor_account"));
        $this->agent_phone_1->SetDBValue($this->f("agent_phone_1"));
        $this->agent_phone_2->SetDBValue($this->f("agent_phone_2"));
        $this->agent_fax->SetDBValue($this->f("agent_fax"));
        $this->agent_email->SetDBValue($this->f("agent_email"));
        $this->agent_mobile->SetDBValue($this->f("agent_mobile"));
        $this->agent_boarding->SetDBValue($this->f("agent_boarding"));
    }
//End SetValues Method

//Insert Method @2-F826E873
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["order_no"]["Value"] = $this->order_no->GetDBValue(true);
        $this->InsertFields["shipname"]["Value"] = $this->shipname->GetDBValue(true);
        $this->InsertFields["imo_number"]["Value"] = $this->imo_number->GetDBValue(true);
        $this->InsertFields["equipment"]["Value"] = $this->equipment->GetDBValue(true);
        $this->InsertFields["service_type"]["Value"] = $this->service_type->GetDBValue(true);
        $this->InsertFields["warranty"]["Value"] = $this->warranty->GetDBValue(true);
        $this->InsertFields["approved_by"]["Value"] = $this->approved_by->GetDBValue(true);
        $this->InsertFields["remarks"]["Value"] = $this->remarks->GetDBValue(true);
        $this->InsertFields["country"]["Value"] = $this->country->GetDBValue(true);
        $this->InsertFields["port"]["Value"] = $this->port->GetDBValue(true);
        $this->InsertFields["agent"]["Value"] = $this->agent->GetDBValue(true);
        $this->InsertFields["eta_date"]["Value"] = $this->eta_date->GetDBValue(true);
        $this->InsertFields["eta_time"]["Value"] = $this->eta_time->GetDBValue(true);
        $this->InsertFields["ref_called_on"]["Value"] = $this->ref_called_on->GetDBValue(true);
        $this->InsertFields["ref_time"]["Value"] = $this->ref_time->GetDBValue(true);
        $this->InsertFields["ref_talked_to"]["Value"] = $this->ref_talked_to->GetDBValue(true);
        $this->InsertFields["invoice_to"]["Value"] = $this->invoice_to->GetDBValue(true);
        $this->InsertFields["po_no"]["Value"] = $this->po_no->GetDBValue(true);
        $this->InsertFields["debtor_account"]["Value"] = $this->debtor_account->GetDBValue(true);
        $this->InsertFields["agent_phone_1"]["Value"] = $this->agent_phone_1->GetDBValue(true);
        $this->InsertFields["agent_phone_2"]["Value"] = $this->agent_phone_2->GetDBValue(true);
        $this->InsertFields["agent_fax"]["Value"] = $this->agent_fax->GetDBValue(true);
        $this->InsertFields["agent_email"]["Value"] = $this->agent_email->GetDBValue(true);
        $this->InsertFields["agent_mobile"]["Value"] = $this->agent_mobile->GetDBValue(true);
        $this->InsertFields["agent_boarding"]["Value"] = $this->agent_boarding->GetDBValue(true);
        $this->SQL = CCBuildInsert("ws_dummy", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

} //End ws_dummyDataSource Class @2-FCB6E20C



//Initialize Page @1-05FAD16F
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
$TemplateFileName = "page1.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-63B556BD
include_once("./page1_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-D0A09783
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$ws_dummy = & new clsRecordws_dummy("", $MainPage);
$MainPage->ws_dummy = & $ws_dummy;
$ws_dummy->Initialize();

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

//Execute Components @1-70C6E7B3
$ws_dummy->Operation();
//End Execute Components

//Go to destination page @1-4221969C
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($ws_dummy);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-14ABCEBA
$ws_dummy->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-E3F1772E
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($ws_dummy);
unset($Tpl);
//End Unload Page


?>
