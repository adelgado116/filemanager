<?php
//Include Common Files @1-AD3B5F13
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "page5.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//DEL      function clsRecordservice_tbl1($RelativePath, & $Parent)
//DEL      {
//DEL  
//DEL          global $FileName;
//DEL          global $CCSLocales;
//DEL          global $DefaultDateFormat;
//DEL          $this->Visible = true;
//DEL          $this->Parent = & $Parent;
//DEL          $this->RelativePath = $RelativePath;
//DEL          $this->Errors = new clsErrors();
//DEL          $this->ErrorBlock = "Record service_tbl1/Error";
//DEL          $this->DataSource = new clsservice_tbl1DataSource($this);
//DEL          $this->ds = & $this->DataSource;
//DEL          $this->UpdateAllowed = true;
//DEL          $this->DeleteAllowed = true;
//DEL          $this->ReadAllowed = true;
//DEL          if($this->Visible)
//DEL          {
//DEL              $this->ComponentName = "service_tbl1";
//DEL              $this->Attributes = new clsAttributes($this->ComponentName . ":");
//DEL              $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
//DEL              if(sizeof($CCSForm) == 1)
//DEL                  $CCSForm[1] = "";
//DEL              list($FormName, $FormMethod) = $CCSForm;
//DEL              $this->EditMode = ($FormMethod == "Edit");
//DEL              $this->FormEnctype = "application/x-www-form-urlencoded";
//DEL              $this->FormSubmitted = ($FormName == $this->ComponentName);
//DEL              $Method = $this->FormSubmitted ? ccsPost : ccsGet;
//DEL              $this->Button_Update = new clsButton("Button_Update", $Method, $this);
//DEL              $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
//DEL              $this->ORDER_NO = new clsControl(ccsTextBox, "ORDER_NO", "ORDER NO", ccsText, "", CCGetRequestParam("ORDER_NO", $Method, NULL), $this);
//DEL              $this->ORDER_NO->Required = true;
//DEL              $this->IMO_NUMBER = new clsControl(ccsTextBox, "IMO_NUMBER", "IMO NUMBER", ccsText, "", CCGetRequestParam("IMO_NUMBER", $Method, NULL), $this);
//DEL              $this->IMO_NUMBER->Required = true;
//DEL              $this->REQUISNUMBER = new clsControl(ccsTextBox, "REQUISNUMBER", "REQUISNUMBER", ccsText, "", CCGetRequestParam("REQUISNUMBER", $Method, NULL), $this);
//DEL              $this->REQUISNUMBER->Required = true;
//DEL              $this->country_id = new clsControl(ccsListBox, "country_id", "country_id", ccsInteger, "", CCGetRequestParam("country_id", $Method, NULL), $this);
//DEL              $this->country_id->DSType = dsTable;
//DEL              $this->country_id->DataSource = new clsDBhss_db();
//DEL              $this->country_id->ds = & $this->country_id->DataSource;
//DEL              $this->country_id->DataSource->SQL = "SELECT * \n" .
//DEL  "FROM countries_tbl {SQL_Where} {SQL_OrderBy}";
//DEL              list($this->country_id->BoundColumn, $this->country_id->TextColumn, $this->country_id->DBFormat) = array("country_id", "country_name", "");
//DEL              $this->country_id->Required = true;
//DEL              $this->PORT_ID = new clsControl(ccsListBox, "PORT_ID", "PORT ID", ccsInteger, "", CCGetRequestParam("PORT_ID", $Method, NULL), $this);
//DEL              $this->PORT_ID->DSType = dsTable;
//DEL              $this->PORT_ID->DataSource = new clsDBhss_db();
//DEL              $this->PORT_ID->ds = & $this->PORT_ID->DataSource;
//DEL              $this->PORT_ID->DataSource->SQL = "SELECT * \n" .
//DEL  "FROM ports_tbl {SQL_Where} {SQL_OrderBy}";
//DEL              list($this->PORT_ID->BoundColumn, $this->PORT_ID->TextColumn, $this->PORT_ID->DBFormat) = array("PORT_ID", "PORT_NAME", "");
//DEL              $this->PORT_ID->Required = true;
//DEL              $this->AGENT_ID = new clsControl(ccsListBox, "AGENT_ID", "AGENT ID", ccsInteger, "", CCGetRequestParam("AGENT_ID", $Method, NULL), $this);
//DEL              $this->AGENT_ID->DSType = dsTable;
//DEL              $this->AGENT_ID->DataSource = new clsDBhss_db();
//DEL              $this->AGENT_ID->ds = & $this->AGENT_ID->DataSource;
//DEL              $this->AGENT_ID->DataSource->SQL = "SELECT * \n" .
//DEL  "FROM agents_tbl {SQL_Where} {SQL_OrderBy}";
//DEL              list($this->AGENT_ID->BoundColumn, $this->AGENT_ID->TextColumn, $this->AGENT_ID->DBFormat) = array("AGENT_ID", "AGENT_NAME", "");
//DEL              $this->AGENT_ID->Required = true;
//DEL              $this->ETA_DATE = new clsControl(ccsTextBox, "ETA_DATE", "ETA DATE", ccsText, "", CCGetRequestParam("ETA_DATE", $Method, NULL), $this);
//DEL              $this->ETA_DATE->Required = true;
//DEL              $this->DatePicker_ETA_DATE1 = new clsDatePicker("DatePicker_ETA_DATE1", "service_tbl1", "ETA_DATE", $this);
//DEL              $this->SHIPNAME = new clsControl(ccsTextBox, "SHIPNAME", "SHIPNAME", ccsText, "", CCGetRequestParam("SHIPNAME", $Method, NULL), $this);
//DEL              $this->SHIPNAME->Required = true;
//DEL              $this->ETA_HOUR = new clsControl(ccsTextBox, "ETA_HOUR", "ETA HOUR", ccsText, "", CCGetRequestParam("ETA_HOUR", $Method, NULL), $this);
//DEL              $this->ETA_HOUR->Required = true;
//DEL              $this->AGENT_DUTY = new clsControl(ccsTextBox, "AGENT_DUTY", "AGENT DUTY", ccsText, "", CCGetRequestParam("AGENT_DUTY", $Method, NULL), $this);
//DEL              $this->STATUS_ID = new clsControl(ccsListBox, "STATUS_ID", "STATUS_ID", ccsText, "", CCGetRequestParam("STATUS_ID", $Method, NULL), $this);
//DEL              $this->STATUS_ID->DSType = dsTable;
//DEL              $this->STATUS_ID->DataSource = new clsDBhss_db();
//DEL              $this->STATUS_ID->ds = & $this->STATUS_ID->DataSource;
//DEL              $this->STATUS_ID->DataSource->SQL = "SELECT * \n" .
//DEL  "FROM service_status_tbl {SQL_Where} {SQL_OrderBy}";
//DEL              list($this->STATUS_ID->BoundColumn, $this->STATUS_ID->TextColumn, $this->STATUS_ID->DBFormat) = array("STATUS_ID", "STATUS", "");
//DEL              $this->Button_Generate = new clsButton("Button_Generate", $Method, $this);
//DEL              $this->city_id = new clsControl(ccsListBox, "city_id", "city_id", ccsInteger, "", CCGetRequestParam("city_id", $Method, NULL), $this);
//DEL              $this->city_id->DSType = dsTable;
//DEL              $this->city_id->DataSource = new clsDBhss_db();
//DEL              $this->city_id->ds = & $this->city_id->DataSource;
//DEL              $this->city_id->DataSource->SQL = "SELECT * \n" .
//DEL  "FROM cities_tbl {SQL_Where} {SQL_OrderBy}";
//DEL              list($this->city_id->BoundColumn, $this->city_id->TextColumn, $this->city_id->DBFormat) = array("city_id", "city_name", "");
//DEL              $this->city_id->Required = true;
//DEL          }
//DEL      }

//DEL      function Validate()
//DEL      {
//DEL          global $CCSLocales;
//DEL          $Validation = true;
//DEL          $Where = "";
//DEL          $Validation = ($this->ORDER_NO->Validate() && $Validation);
//DEL          $Validation = ($this->IMO_NUMBER->Validate() && $Validation);
//DEL          $Validation = ($this->REQUISNUMBER->Validate() && $Validation);
//DEL          $Validation = ($this->country_id->Validate() && $Validation);
//DEL          $Validation = ($this->PORT_ID->Validate() && $Validation);
//DEL          $Validation = ($this->AGENT_ID->Validate() && $Validation);
//DEL          $Validation = ($this->ETA_DATE->Validate() && $Validation);
//DEL          $Validation = ($this->SHIPNAME->Validate() && $Validation);
//DEL          $Validation = ($this->ETA_HOUR->Validate() && $Validation);
//DEL          $Validation = ($this->AGENT_DUTY->Validate() && $Validation);
//DEL          $Validation = ($this->STATUS_ID->Validate() && $Validation);
//DEL          $Validation = ($this->city_id->Validate() && $Validation);
//DEL          $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
//DEL          $Validation =  $Validation && ($this->ORDER_NO->Errors->Count() == 0);
//DEL          $Validation =  $Validation && ($this->IMO_NUMBER->Errors->Count() == 0);
//DEL          $Validation =  $Validation && ($this->REQUISNUMBER->Errors->Count() == 0);
//DEL          $Validation =  $Validation && ($this->country_id->Errors->Count() == 0);
//DEL          $Validation =  $Validation && ($this->PORT_ID->Errors->Count() == 0);
//DEL          $Validation =  $Validation && ($this->AGENT_ID->Errors->Count() == 0);
//DEL          $Validation =  $Validation && ($this->ETA_DATE->Errors->Count() == 0);
//DEL          $Validation =  $Validation && ($this->SHIPNAME->Errors->Count() == 0);
//DEL          $Validation =  $Validation && ($this->ETA_HOUR->Errors->Count() == 0);
//DEL          $Validation =  $Validation && ($this->AGENT_DUTY->Errors->Count() == 0);
//DEL          $Validation =  $Validation && ($this->STATUS_ID->Errors->Count() == 0);
//DEL          $Validation =  $Validation && ($this->city_id->Errors->Count() == 0);
//DEL          return (($this->Errors->Count() == 0) && $Validation);
//DEL      }


//DEL      function CheckErrors()
//DEL      {
//DEL          $errors = false;
//DEL          $errors = ($errors || $this->ORDER_NO->Errors->Count());
//DEL          $errors = ($errors || $this->IMO_NUMBER->Errors->Count());
//DEL          $errors = ($errors || $this->REQUISNUMBER->Errors->Count());
//DEL          $errors = ($errors || $this->country_id->Errors->Count());
//DEL          $errors = ($errors || $this->PORT_ID->Errors->Count());
//DEL          $errors = ($errors || $this->AGENT_ID->Errors->Count());
//DEL          $errors = ($errors || $this->ETA_DATE->Errors->Count());
//DEL          $errors = ($errors || $this->DatePicker_ETA_DATE1->Errors->Count());
//DEL          $errors = ($errors || $this->SHIPNAME->Errors->Count());
//DEL          $errors = ($errors || $this->ETA_HOUR->Errors->Count());
//DEL          $errors = ($errors || $this->AGENT_DUTY->Errors->Count());
//DEL          $errors = ($errors || $this->STATUS_ID->Errors->Count());
//DEL          $errors = ($errors || $this->city_id->Errors->Count());
//DEL          $errors = ($errors || $this->Errors->Count());
//DEL          $errors = ($errors || $this->DataSource->Errors->Count());
//DEL          return $errors;
//DEL      }

//DEL      function Show()
//DEL      {
//DEL          global $CCSUseAmp;
//DEL          global $Tpl;
//DEL          global $FileName;
//DEL          global $CCSLocales;
//DEL          $Error = "";
//DEL  
//DEL          if(!$this->Visible)
//DEL              return;
//DEL  
//DEL          $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);
//DEL  
//DEL          $this->country_id->Prepare();
//DEL          $this->PORT_ID->Prepare();
//DEL          $this->AGENT_ID->Prepare();
//DEL          $this->STATUS_ID->Prepare();
//DEL          $this->city_id->Prepare();
//DEL  
//DEL          $RecordBlock = "Record " . $this->ComponentName;
//DEL          $ParentPath = $Tpl->block_path;
//DEL          $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
//DEL          $this->EditMode = $this->EditMode && $this->ReadAllowed;
//DEL          if($this->EditMode) {
//DEL              if($this->DataSource->Errors->Count()){
//DEL                  $this->Errors->AddErrors($this->DataSource->Errors);
//DEL                  $this->DataSource->Errors->clear();
//DEL              }
//DEL              $this->DataSource->Open();
//DEL              if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
//DEL                  $this->DataSource->SetValues();
//DEL                  if(!$this->FormSubmitted){
//DEL                      $this->ORDER_NO->SetValue($this->DataSource->ORDER_NO->GetValue());
//DEL                      $this->IMO_NUMBER->SetValue($this->DataSource->IMO_NUMBER->GetValue());
//DEL                      $this->REQUISNUMBER->SetValue($this->DataSource->REQUISNUMBER->GetValue());
//DEL                      $this->country_id->SetValue($this->DataSource->country_id->GetValue());
//DEL                      $this->PORT_ID->SetValue($this->DataSource->PORT_ID->GetValue());
//DEL                      $this->AGENT_ID->SetValue($this->DataSource->AGENT_ID->GetValue());
//DEL                      $this->ETA_DATE->SetValue($this->DataSource->ETA_DATE->GetValue());
//DEL                      $this->SHIPNAME->SetValue($this->DataSource->SHIPNAME->GetValue());
//DEL                      $this->ETA_HOUR->SetValue($this->DataSource->ETA_HOUR->GetValue());
//DEL                      $this->AGENT_DUTY->SetValue($this->DataSource->AGENT_DUTY->GetValue());
//DEL                      $this->STATUS_ID->SetValue($this->DataSource->STATUS_ID->GetValue());
//DEL                      $this->city_id->SetValue($this->DataSource->city_id->GetValue());
//DEL                  }
//DEL              } else {
//DEL                  $this->EditMode = false;
//DEL              }
//DEL          }
//DEL  
//DEL          if($this->FormSubmitted || $this->CheckErrors()) {
//DEL              $Error = "";
//DEL              $Error = ComposeStrings($Error, $this->ORDER_NO->Errors->ToString());
//DEL              $Error = ComposeStrings($Error, $this->IMO_NUMBER->Errors->ToString());
//DEL              $Error = ComposeStrings($Error, $this->REQUISNUMBER->Errors->ToString());
//DEL              $Error = ComposeStrings($Error, $this->country_id->Errors->ToString());
//DEL              $Error = ComposeStrings($Error, $this->PORT_ID->Errors->ToString());
//DEL              $Error = ComposeStrings($Error, $this->AGENT_ID->Errors->ToString());
//DEL              $Error = ComposeStrings($Error, $this->ETA_DATE->Errors->ToString());
//DEL              $Error = ComposeStrings($Error, $this->DatePicker_ETA_DATE1->Errors->ToString());
//DEL              $Error = ComposeStrings($Error, $this->SHIPNAME->Errors->ToString());
//DEL              $Error = ComposeStrings($Error, $this->ETA_HOUR->Errors->ToString());
//DEL              $Error = ComposeStrings($Error, $this->AGENT_DUTY->Errors->ToString());
//DEL              $Error = ComposeStrings($Error, $this->STATUS_ID->Errors->ToString());
//DEL              $Error = ComposeStrings($Error, $this->city_id->Errors->ToString());
//DEL              $Error = ComposeStrings($Error, $this->Errors->ToString());
//DEL              $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
//DEL              $Tpl->SetVar("Error", $Error);
//DEL              $Tpl->Parse("Error", false);
//DEL          }
//DEL          $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
//DEL          $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
//DEL          $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
//DEL          $Tpl->SetVar("HTMLFormName", $this->ComponentName);
//DEL          $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
//DEL          $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;
//DEL          $this->Button_Delete->Visible = $this->EditMode && $this->DeleteAllowed;
//DEL  
//DEL          $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
//DEL          $this->Attributes->Show();
//DEL          if(!$this->Visible) {
//DEL              $Tpl->block_path = $ParentPath;
//DEL              return;
//DEL          }
//DEL  
//DEL          $this->Button_Update->Show();
//DEL          $this->Button_Delete->Show();
//DEL          $this->ORDER_NO->Show();
//DEL          $this->IMO_NUMBER->Show();
//DEL          $this->REQUISNUMBER->Show();
//DEL          $this->country_id->Show();
//DEL          $this->PORT_ID->Show();
//DEL          $this->AGENT_ID->Show();
//DEL          $this->ETA_DATE->Show();
//DEL          $this->DatePicker_ETA_DATE1->Show();
//DEL          $this->SHIPNAME->Show();
//DEL          $this->ETA_HOUR->Show();
//DEL          $this->AGENT_DUTY->Show();
//DEL          $this->STATUS_ID->Show();
//DEL          $this->Button_Generate->Show();
//DEL          $this->city_id->Show();
//DEL          $Tpl->parse();
//DEL          $Tpl->block_path = $ParentPath;
//DEL          $this->DataSource->close();
//DEL      }


//DEL      public $Parent = "";
//DEL      public $CCSEvents = "";
//DEL      public $CCSEventResult;
//DEL      public $ErrorBlock;
//DEL      public $CmdExecution;
//DEL  
//DEL      public $UpdateParameters;
//DEL      public $DeleteParameters;
//DEL      public $wp;
//DEL      public $AllParametersSet;
//DEL  
//DEL      public $UpdateFields = array();
//DEL  
//DEL      // Datasource fields
//DEL      public $ORDER_NO;
//DEL      public $IMO_NUMBER;
//DEL      public $REQUISNUMBER;
//DEL      public $country_id;
//DEL      public $PORT_ID;
//DEL      public $AGENT_ID;
//DEL      public $ETA_DATE;
//DEL      public $SHIPNAME;
//DEL      public $ETA_HOUR;
//DEL      public $AGENT_DUTY;
//DEL      public $STATUS_ID;
//DEL      public $city_id;


//DEL      function clsservice_tbl1DataSource(& $Parent)
//DEL      {
//DEL          $this->Parent = & $Parent;
//DEL          $this->ErrorBlock = "Record service_tbl1/Error";
//DEL          $this->Initialize();
//DEL          $this->ORDER_NO = new clsField("ORDER_NO", ccsText, "");
//DEL          
//DEL          $this->IMO_NUMBER = new clsField("IMO_NUMBER", ccsText, "");
//DEL          
//DEL          $this->REQUISNUMBER = new clsField("REQUISNUMBER", ccsText, "");
//DEL          
//DEL          $this->country_id = new clsField("country_id", ccsInteger, "");
//DEL          
//DEL          $this->PORT_ID = new clsField("PORT_ID", ccsInteger, "");
//DEL          
//DEL          $this->AGENT_ID = new clsField("AGENT_ID", ccsInteger, "");
//DEL          
//DEL          $this->ETA_DATE = new clsField("ETA_DATE", ccsText, "");
//DEL          
//DEL          $this->SHIPNAME = new clsField("SHIPNAME", ccsText, "");
//DEL          
//DEL          $this->ETA_HOUR = new clsField("ETA_HOUR", ccsText, "");
//DEL          
//DEL          $this->AGENT_DUTY = new clsField("AGENT_DUTY", ccsText, "");
//DEL          
//DEL          $this->STATUS_ID = new clsField("STATUS_ID", ccsText, "");
//DEL          
//DEL          $this->city_id = new clsField("city_id", ccsInteger, "");
//DEL          
//DEL  
//DEL          $this->UpdateFields["ORDER_NO"] = array("Name" => "ORDER_NO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
//DEL          $this->UpdateFields["IMO_NUMBER"] = array("Name" => "IMO_NUMBER", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
//DEL          $this->UpdateFields["REQUISNUMBER"] = array("Name" => "REQUISNUMBER", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
//DEL          $this->UpdateFields["country_id"] = array("Name" => "country_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
//DEL          $this->UpdateFields["PORT_ID"] = array("Name" => "PORT_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
//DEL          $this->UpdateFields["AGENT_ID"] = array("Name" => "AGENT_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
//DEL          $this->UpdateFields["ETA_DATE"] = array("Name" => "ETA_DATE", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
//DEL          $this->UpdateFields["ETA_HOUR"] = array("Name" => "ETA_HOUR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
//DEL          $this->UpdateFields["city_id"] = array("Name" => "city_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
//DEL          $this->UpdateFields["STATUS_ID"] = array("Name" => "STATUS_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
//DEL          $this->UpdateFields["AGENT_DUTY"] = array("Name" => "AGENT_DUTY", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
//DEL      }

//DEL      function SetValues()
//DEL      {
//DEL          $this->ORDER_NO->SetDBValue($this->f("ORDER_NO"));
//DEL          $this->IMO_NUMBER->SetDBValue($this->f("IMO_NUMBER"));
//DEL          $this->REQUISNUMBER->SetDBValue($this->f("REQUISNUMBER"));
//DEL          $this->country_id->SetDBValue(trim($this->f("country_id")));
//DEL          $this->PORT_ID->SetDBValue(trim($this->f("PORT_ID")));
//DEL          $this->AGENT_ID->SetDBValue(trim($this->f("AGENT_ID")));
//DEL          $this->ETA_DATE->SetDBValue($this->f("ETA_DATE"));
//DEL          $this->SHIPNAME->SetDBValue($this->f("SHIP_NAME"));
//DEL          $this->ETA_HOUR->SetDBValue($this->f("ETA_HOUR"));
//DEL          $this->AGENT_DUTY->SetDBValue($this->f("AGENT_DUTY"));
//DEL          $this->STATUS_ID->SetDBValue($this->f("STATUS_ID"));
//DEL          $this->city_id->SetDBValue(trim($this->f("city_id")));
//DEL      }



//DEL      function Show()
//DEL      {
//DEL          global $Tpl;
//DEL          global $CCSLocales;
//DEL          if(!$this->Visible) return;
//DEL  
//DEL          $this->RowNumber = 0;
//DEL  
//DEL          $this->DataSource->Parameters["sesORDER"] = CCGetSession("ORDER", NULL);
//DEL  
//DEL          $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);
//DEL  
//DEL  
//DEL          $this->DataSource->Prepare();
//DEL          $this->DataSource->Open();
//DEL          $this->HasRecord = $this->DataSource->has_next_record();
//DEL          $this->IsEmpty = ! $this->HasRecord;
//DEL          $this->Attributes->Show();
//DEL  
//DEL          $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
//DEL          if(!$this->Visible) return;
//DEL  
//DEL          $GridBlock = "Grid " . $this->ComponentName;
//DEL          $ParentPath = $Tpl->block_path;
//DEL          $Tpl->block_path = $ParentPath . "/" . $GridBlock;
//DEL  
//DEL  
//DEL          if (!$this->IsEmpty) {
//DEL              $this->ControlsVisible["MANUF_NAME"] = $this->MANUF_NAME->Visible;
//DEL              $this->ControlsVisible["EQUIP_VERSION"] = $this->EQUIP_VERSION->Visible;
//DEL              $this->ControlsVisible["SERVICE_TYPE"] = $this->SERVICE_TYPE->Visible;
//DEL              $this->ControlsVisible["WARRANTY"] = $this->WARRANTY->Visible;
//DEL              $this->ControlsVisible["emp_login"] = $this->emp_login->Visible;
//DEL              $this->ControlsVisible["REMARKS"] = $this->REMARKS->Visible;
//DEL              $this->ControlsVisible["Link2"] = $this->Link2->Visible;
//DEL              $this->ControlsVisible["Link3"] = $this->Link3->Visible;
//DEL              while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
//DEL                  $this->RowNumber++;
//DEL                  if ($this->HasRecord) {
//DEL                      $this->DataSource->next_record();
//DEL                      $this->DataSource->SetValues();
//DEL                  }
//DEL                  $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
//DEL                  $this->MANUF_NAME->SetValue($this->DataSource->MANUF_NAME->GetValue());
//DEL                  $this->EQUIP_VERSION->SetValue($this->DataSource->EQUIP_VERSION->GetValue());
//DEL                  $this->SERVICE_TYPE->SetValue($this->DataSource->SERVICE_TYPE->GetValue());
//DEL                  $this->WARRANTY->SetValue($this->DataSource->WARRANTY->GetValue());
//DEL                  $this->emp_login->SetValue($this->DataSource->emp_login->GetValue());
//DEL                  $this->REMARKS->SetValue($this->DataSource->REMARKS->GetValue());
//DEL                  $this->Link2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
//DEL                  $this->Link2->Parameters = CCAddParam($this->Link2->Parameters, "ITEM_NO", $this->DataSource->f("ITEM_NO"));
//DEL                  $this->Attributes->SetValue("rowNumber", $this->RowNumber);
//DEL                  $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
//DEL                  $this->Attributes->Show();
//DEL                  $this->MANUF_NAME->Show();
//DEL                  $this->EQUIP_VERSION->Show();
//DEL                  $this->SERVICE_TYPE->Show();
//DEL                  $this->WARRANTY->Show();
//DEL                  $this->emp_login->Show();
//DEL                  $this->REMARKS->Show();
//DEL                  $Tpl->block_path = $ParentPath . "/" . $GridBlock;
//DEL                  $Tpl->parse("Row", true);
//DEL              }
//DEL          }
//DEL          else { // Show NoRecords block if no records are found
//DEL              $this->Attributes->Show();
//DEL              $Tpl->parse("NoRecords", false);
//DEL          }
//DEL  
//DEL          $errors = $this->GetErrors();
//DEL          if(strlen($errors))
//DEL          {
//DEL              $Tpl->replaceblock("", $errors);
//DEL              $Tpl->block_path = $ParentPath;
//DEL              return;
//DEL          }
//DEL          $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
//DEL          $this->Navigator->PageSize = $this->PageSize;
//DEL          if ($this->DataSource->RecordsCount == "CCS not counted")
//DEL              $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
//DEL          else
//DEL              $this->Navigator->TotalPages = $this->DataSource->PageCount();
//DEL          if ($this->Navigator->TotalPages <= 1) {
//DEL              $this->Navigator->Visible = false;
//DEL          }
//DEL          $this->Navigator->Show();
//DEL          $this->Link1->Show();
//DEL          $Tpl->parse();
//DEL          $Tpl->block_path = $ParentPath;
//DEL          $this->DataSource->close();
//DEL      }



class clsGridemployees_tbl_equipment_m1 { //employees_tbl_equipment_m1 class @123-1333A28D

//Variables @123-6E51DF5A

    // Public variables
    public $ComponentType = "Grid";
    public $ComponentName;
    public $Visible;
    public $Errors;
    public $ErrorBlock;
    public $ds;
    public $DataSource;
    public $PageSize;
    public $IsEmpty;
    public $ForceIteration = false;
    public $HasRecord = false;
    public $SorterName = "";
    public $SorterDirection = "";
    public $PageNumber;
    public $RowNumber;
    public $ControlsVisible = array();

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";
    public $Attributes;

    // Grid Controls
    public $StaticControls;
    public $RowControls;
//End Variables

//Class_Initialize Event @123-DD263178
    function clsGridemployees_tbl_equipment_m1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "employees_tbl_equipment_m1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid employees_tbl_equipment_m1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsemployees_tbl_equipment_m1DataSource($this);
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

        $this->MANUF_NAME = new clsControl(ccsLabel, "MANUF_NAME", "MANUF_NAME", ccsText, "", CCGetRequestParam("MANUF_NAME", ccsGet, NULL), $this);
        $this->EQUIP_MODEL = new clsControl(ccsLabel, "EQUIP_MODEL", "EQUIP_MODEL", ccsText, "", CCGetRequestParam("EQUIP_MODEL", ccsGet, NULL), $this);
        $this->SERVICE_TYPE = new clsControl(ccsLabel, "SERVICE_TYPE", "SERVICE_TYPE", ccsText, "", CCGetRequestParam("SERVICE_TYPE", ccsGet, NULL), $this);
        $this->WARRANTY = new clsControl(ccsLabel, "WARRANTY", "WARRANTY", ccsText, "", CCGetRequestParam("WARRANTY", ccsGet, NULL), $this);
        $this->employees_tbl_emp_login = new clsControl(ccsLabel, "employees_tbl_emp_login", "employees_tbl_emp_login", ccsText, "", CCGetRequestParam("employees_tbl_emp_login", ccsGet, NULL), $this);
        $this->REMARKS = new clsControl(ccsLabel, "REMARKS", "REMARKS", ccsMemo, "", CCGetRequestParam("REMARKS", ccsGet, NULL), $this);
        $this->Link2 = new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $this);
        $this->Link2->Page = "page5_1.php";
        $this->Link3 = new clsControl(ccsLink, "Link3", "Link3", ccsText, "", CCGetRequestParam("Link3", ccsGet, NULL), $this);
        $this->Link3->Page = "page7.php";
        $this->employees_tbl1_emp_login = new clsControl(ccsLabel, "employees_tbl1_emp_login", "employees_tbl1_emp_login", ccsText, "", CCGetRequestParam("employees_tbl1_emp_login", ccsGet, NULL), $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->Link1->Page = "page3.php";
    }
//End Class_Initialize Event

//Initialize Method @123-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @123-7FF02549
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["sesORDER"] = CCGetSession("ORDER", NULL);

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
            $this->ControlsVisible["MANUF_NAME"] = $this->MANUF_NAME->Visible;
            $this->ControlsVisible["EQUIP_MODEL"] = $this->EQUIP_MODEL->Visible;
            $this->ControlsVisible["SERVICE_TYPE"] = $this->SERVICE_TYPE->Visible;
            $this->ControlsVisible["WARRANTY"] = $this->WARRANTY->Visible;
            $this->ControlsVisible["employees_tbl_emp_login"] = $this->employees_tbl_emp_login->Visible;
            $this->ControlsVisible["REMARKS"] = $this->REMARKS->Visible;
            $this->ControlsVisible["Link2"] = $this->Link2->Visible;
            $this->ControlsVisible["Link3"] = $this->Link3->Visible;
            $this->ControlsVisible["employees_tbl1_emp_login"] = $this->employees_tbl1_emp_login->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->MANUF_NAME->SetValue($this->DataSource->MANUF_NAME->GetValue());
                $this->EQUIP_MODEL->SetValue($this->DataSource->EQUIP_MODEL->GetValue());
                $this->SERVICE_TYPE->SetValue($this->DataSource->SERVICE_TYPE->GetValue());
                $this->WARRANTY->SetValue($this->DataSource->WARRANTY->GetValue());
                $this->employees_tbl_emp_login->SetValue($this->DataSource->employees_tbl_emp_login->GetValue());
                $this->REMARKS->SetValue($this->DataSource->REMARKS->GetValue());
                $this->Link2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link2->Parameters = CCAddParam($this->Link2->Parameters, "ITEM_NO", $this->DataSource->f("ITEM_NO"));
                $this->Link3->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link3->Parameters = CCAddParam($this->Link3->Parameters, "ORDER_NO", $this->DataSource->f("ORDER_NO"));
                $this->Link3->Parameters = CCAddParam($this->Link3->Parameters, "ITEM_NO", $this->DataSource->f("ITEM_NO"));
                $this->employees_tbl1_emp_login->SetValue($this->DataSource->employees_tbl1_emp_login->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->MANUF_NAME->Show();
                $this->EQUIP_MODEL->Show();
                $this->SERVICE_TYPE->Show();
                $this->WARRANTY->Show();
                $this->employees_tbl_emp_login->Show();
                $this->REMARKS->Show();
                $this->Link2->Show();
                $this->Link3->Show();
                $this->employees_tbl1_emp_login->Show();
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
        $this->Link1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @123-68875C08
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->MANUF_NAME->Errors->ToString());
        $errors = ComposeStrings($errors, $this->EQUIP_MODEL->Errors->ToString());
        $errors = ComposeStrings($errors, $this->SERVICE_TYPE->Errors->ToString());
        $errors = ComposeStrings($errors, $this->WARRANTY->Errors->ToString());
        $errors = ComposeStrings($errors, $this->employees_tbl_emp_login->Errors->ToString());
        $errors = ComposeStrings($errors, $this->REMARKS->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link3->Errors->ToString());
        $errors = ComposeStrings($errors, $this->employees_tbl1_emp_login->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End employees_tbl_equipment_m1 Class @123-FCB6E20C

class clsemployees_tbl_equipment_m1DataSource extends clsDBhss_db {  //employees_tbl_equipment_m1DataSource Class @123-923B3ABD

//DataSource Variables @123-24A5D3EB
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $MANUF_NAME;
    public $EQUIP_MODEL;
    public $SERVICE_TYPE;
    public $WARRANTY;
    public $employees_tbl_emp_login;
    public $REMARKS;
    public $employees_tbl1_emp_login;
//End DataSource Variables

//DataSourceClass_Initialize Event @123-64B142CD
    function clsemployees_tbl_equipment_m1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid employees_tbl_equipment_m1";
        $this->Initialize();
        $this->MANUF_NAME = new clsField("MANUF_NAME", ccsText, "");
        
        $this->EQUIP_MODEL = new clsField("EQUIP_MODEL", ccsText, "");
        
        $this->SERVICE_TYPE = new clsField("SERVICE_TYPE", ccsText, "");
        
        $this->WARRANTY = new clsField("WARRANTY", ccsText, "");
        
        $this->employees_tbl_emp_login = new clsField("employees_tbl_emp_login", ccsText, "");
        
        $this->REMARKS = new clsField("REMARKS", ccsMemo, "");
        
        $this->employees_tbl1_emp_login = new clsField("employees_tbl1_emp_login", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @123-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @123-A1B06F1B
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "sesORDER", ccsText, "", "", $this->Parameters["sesORDER"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "service_items_tbl.ORDER_NO", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @123-C9230E78
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((((service_items_tbl INNER JOIN service_type_tbl ON\n\n" .
        "service_items_tbl.SERVICE_TYPE_ID = service_type_tbl.SERVICE_TYPE_ID) INNER JOIN employees_tbl ON\n\n" .
        "service_items_tbl.emp_id = employees_tbl.emp_id) INNER JOIN equipment_model_tbl ON\n\n" .
        "service_items_tbl.EQUIP_ID = equipment_model_tbl.EQUIP_ID) INNER JOIN employees_tbl employees_tbl1 ON\n\n" .
        "service_items_tbl.coord_id = employees_tbl1.emp_id) INNER JOIN equipment_manufacturer_tbl ON\n\n" .
        "equipment_model_tbl.MANUF_ID = equipment_manufacturer_tbl.MANUF_ID";
        $this->SQL = "SELECT service_items_tbl.*, SERVICE_TYPE, employees_tbl.emp_login AS employees_tbl_emp_login, EQUIP_MODEL, MANUF_NAME, employees_tbl1.emp_login AS employees_tbl1_emp_login \n\n" .
        "FROM ((((service_items_tbl INNER JOIN service_type_tbl ON\n\n" .
        "service_items_tbl.SERVICE_TYPE_ID = service_type_tbl.SERVICE_TYPE_ID) INNER JOIN employees_tbl ON\n\n" .
        "service_items_tbl.emp_id = employees_tbl.emp_id) INNER JOIN equipment_model_tbl ON\n\n" .
        "service_items_tbl.EQUIP_ID = equipment_model_tbl.EQUIP_ID) INNER JOIN employees_tbl employees_tbl1 ON\n\n" .
        "service_items_tbl.coord_id = employees_tbl1.emp_id) INNER JOIN equipment_manufacturer_tbl ON\n\n" .
        "equipment_model_tbl.MANUF_ID = equipment_manufacturer_tbl.MANUF_ID {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @123-04F3A77A
    function SetValues()
    {
        $this->MANUF_NAME->SetDBValue($this->f("MANUF_NAME"));
        $this->EQUIP_MODEL->SetDBValue($this->f("EQUIP_MODEL"));
        $this->SERVICE_TYPE->SetDBValue($this->f("SERVICE_TYPE"));
        $this->WARRANTY->SetDBValue($this->f("WARRANTY"));
        $this->employees_tbl_emp_login->SetDBValue($this->f("employees_tbl_emp_login"));
        $this->REMARKS->SetDBValue($this->f("REMARKS"));
        $this->employees_tbl1_emp_login->SetDBValue($this->f("employees_tbl1_emp_login"));
    }
//End SetValues Method

} //End employees_tbl_equipment_m1DataSource Class @123-FCB6E20C

class clsRecordservice_tbl { //service_tbl Class @170-EED398F1

//Variables @170-9E315808

    // Public variables
    public $ComponentType = "Record";
    public $ComponentName;
    public $Parent;
    public $HTMLFormAction;
    public $PressedButton;
    public $Errors;
    public $ErrorBlock;
    public $FormSubmitted;
    public $FormEnctype;
    public $Visible;
    public $IsEmpty;

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";

    public $InsertAllowed = false;
    public $UpdateAllowed = false;
    public $DeleteAllowed = false;
    public $ReadAllowed   = false;
    public $EditMode      = false;
    public $ds;
    public $DataSource;
    public $ValidatingControls;
    public $Controls;
    public $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @170-B2826807
    function clsRecordservice_tbl($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record service_tbl/Error";
        $this->DataSource = new clsservice_tblDataSource($this);
        $this->ds = & $this->DataSource;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "service_tbl";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
            $this->ORDER_NO = new clsControl(ccsTextBox, "ORDER_NO", "ORDER NO", ccsText, "", CCGetRequestParam("ORDER_NO", $Method, NULL), $this);
            $this->ORDER_NO->Required = true;
            $this->STATUS_ID = new clsControl(ccsListBox, "STATUS_ID", "STATUS ID", ccsInteger, "", CCGetRequestParam("STATUS_ID", $Method, NULL), $this);
            $this->STATUS_ID->DSType = dsTable;
            $this->STATUS_ID->DataSource = new clsDBhss_db();
            $this->STATUS_ID->ds = & $this->STATUS_ID->DataSource;
            $this->STATUS_ID->DataSource->SQL = "SELECT * \n" .
"FROM service_status_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->STATUS_ID->BoundColumn, $this->STATUS_ID->TextColumn, $this->STATUS_ID->DBFormat) = array("STATUS_ID", "STATUS", "");
            $this->IMO_NUMBER = new clsControl(ccsTextBox, "IMO_NUMBER", "IMO NUMBER", ccsText, "", CCGetRequestParam("IMO_NUMBER", $Method, NULL), $this);
            $this->REQUISNUMBER = new clsControl(ccsTextBox, "REQUISNUMBER", "REQUISNUMBER", ccsText, "", CCGetRequestParam("REQUISNUMBER", $Method, NULL), $this);
            $this->country_id = new clsControl(ccsListBox, "country_id", "Country Id", ccsInteger, "", CCGetRequestParam("country_id", $Method, NULL), $this);
            $this->country_id->DSType = dsTable;
            $this->country_id->DataSource = new clsDBhss_db();
            $this->country_id->ds = & $this->country_id->DataSource;
            $this->country_id->DataSource->SQL = "SELECT * \n" .
"FROM countries_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->country_id->BoundColumn, $this->country_id->TextColumn, $this->country_id->DBFormat) = array("country_id", "country_name", "");
            $this->country_id->Required = true;
            $this->city_id = new clsControl(ccsListBox, "city_id", "City Id", ccsInteger, "", CCGetRequestParam("city_id", $Method, NULL), $this);
            $this->city_id->DSType = dsTable;
            $this->city_id->DataSource = new clsDBhss_db();
            $this->city_id->ds = & $this->city_id->DataSource;
            $this->city_id->DataSource->SQL = "SELECT * \n" .
"FROM cities_tbl {SQL_Where} {SQL_OrderBy}";
            $this->city_id->DataSource->Order = "city_name";
            list($this->city_id->BoundColumn, $this->city_id->TextColumn, $this->city_id->DBFormat) = array("city_id", "city_name", "");
            $this->city_id->DataSource->Order = "city_name";
            $this->city_id->Required = true;
            $this->PORT_ID = new clsControl(ccsListBox, "PORT_ID", "PORT ID", ccsInteger, "", CCGetRequestParam("PORT_ID", $Method, NULL), $this);
            $this->PORT_ID->DSType = dsTable;
            $this->PORT_ID->DataSource = new clsDBhss_db();
            $this->PORT_ID->ds = & $this->PORT_ID->DataSource;
            $this->PORT_ID->DataSource->SQL = "SELECT * \n" .
"FROM ports_tbl {SQL_Where} {SQL_OrderBy}";
            $this->PORT_ID->DataSource->Order = "PORT_NAME";
            list($this->PORT_ID->BoundColumn, $this->PORT_ID->TextColumn, $this->PORT_ID->DBFormat) = array("PORT_ID", "PORT_NAME", "");
            $this->PORT_ID->DataSource->Order = "PORT_NAME";
            $this->PORT_ID->Required = true;
            $this->AGENT_ID = new clsControl(ccsListBox, "AGENT_ID", "AGENT ID", ccsInteger, "", CCGetRequestParam("AGENT_ID", $Method, NULL), $this);
            $this->AGENT_ID->DSType = dsTable;
            $this->AGENT_ID->DataSource = new clsDBhss_db();
            $this->AGENT_ID->ds = & $this->AGENT_ID->DataSource;
            $this->AGENT_ID->DataSource->SQL = "SELECT * \n" .
"FROM agents_tbl {SQL_Where} {SQL_OrderBy}";
            $this->AGENT_ID->DataSource->Order = "AGENT_NAME";
            list($this->AGENT_ID->BoundColumn, $this->AGENT_ID->TextColumn, $this->AGENT_ID->DBFormat) = array("AGENT_ID", "AGENT_NAME", "");
            $this->AGENT_ID->DataSource->Order = "AGENT_NAME";
            $this->AGENT_ID->Required = true;
            $this->AGENT_DUTY = new clsControl(ccsTextBox, "AGENT_DUTY", "AGENT DUTY", ccsText, "", CCGetRequestParam("AGENT_DUTY", $Method, NULL), $this);
            $this->ETA_HOUR = new clsControl(ccsTextBox, "ETA_HOUR", "ETA HOUR", ccsText, "", CCGetRequestParam("ETA_HOUR", $Method, NULL), $this);
            $this->AGENT_EVAL_OFFICE = new clsControl(ccsListBox, "AGENT_EVAL_OFFICE", "AGENT EVAL OFFICE", ccsText, "", CCGetRequestParam("AGENT_EVAL_OFFICE", $Method, NULL), $this);
            $this->AGENT_EVAL_OFFICE->DSType = dsTable;
            $this->AGENT_EVAL_OFFICE->DataSource = new clsDBhss_db();
            $this->AGENT_EVAL_OFFICE->ds = & $this->AGENT_EVAL_OFFICE->DataSource;
            $this->AGENT_EVAL_OFFICE->DataSource->SQL = "SELECT * \n" .
"FROM evaluation_values_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->AGENT_EVAL_OFFICE->BoundColumn, $this->AGENT_EVAL_OFFICE->TextColumn, $this->AGENT_EVAL_OFFICE->DBFormat) = array("grades", "grades", "");
            $this->RETURN_REPORT_TO = new clsControl(ccsTextBox, "RETURN_REPORT_TO", "RETURN REPORT TO", ccsText, "", CCGetRequestParam("RETURN_REPORT_TO", $Method, NULL), $this);
            $this->SHIP_NAME = new clsControl(ccsTextBox, "SHIP_NAME", "SHIP_NAME", ccsText, "", CCGetRequestParam("SHIP_NAME", $Method, NULL), $this);
            $this->SHIP_NAME->Required = true;
            $this->Button_Generate = new clsButton("Button_Generate", $Method, $this);
            $this->ETA_DATE_DAY = new clsControl(ccsListBox, "ETA_DATE_DAY", "ETA DATE DAY", ccsText, "", CCGetRequestParam("ETA_DATE_DAY", $Method, NULL), $this);
            $this->ETA_DATE_DAY->DSType = dsTable;
            $this->ETA_DATE_DAY->DataSource = new clsDBhss_db();
            $this->ETA_DATE_DAY->ds = & $this->ETA_DATE_DAY->DataSource;
            $this->ETA_DATE_DAY->DataSource->SQL = "SELECT * \n" .
"FROM days_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->ETA_DATE_DAY->BoundColumn, $this->ETA_DATE_DAY->TextColumn, $this->ETA_DATE_DAY->DBFormat) = array("days", "days", "");
            $this->ETA_DATE_DAY->Required = true;
            $this->ETA_DATE_MONTH = new clsControl(ccsListBox, "ETA_DATE_MONTH", "ETA DATE MONTH", ccsText, "", CCGetRequestParam("ETA_DATE_MONTH", $Method, NULL), $this);
            $this->ETA_DATE_MONTH->DSType = dsTable;
            $this->ETA_DATE_MONTH->DataSource = new clsDBhss_db();
            $this->ETA_DATE_MONTH->ds = & $this->ETA_DATE_MONTH->DataSource;
            $this->ETA_DATE_MONTH->DataSource->SQL = "SELECT * \n" .
"FROM months_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->ETA_DATE_MONTH->BoundColumn, $this->ETA_DATE_MONTH->TextColumn, $this->ETA_DATE_MONTH->DBFormat) = array("months", "months", "");
            $this->ETA_DATE_MONTH->Required = true;
            $this->ETA_DATE_YEAR = new clsControl(ccsListBox, "ETA_DATE_YEAR", "ETA DATE YEAR", ccsText, "", CCGetRequestParam("ETA_DATE_YEAR", $Method, NULL), $this);
            $this->ETA_DATE_YEAR->DSType = dsTable;
            $this->ETA_DATE_YEAR->DataSource = new clsDBhss_db();
            $this->ETA_DATE_YEAR->ds = & $this->ETA_DATE_YEAR->DataSource;
            $this->ETA_DATE_YEAR->DataSource->SQL = "SELECT * \n" .
"FROM years_tbl {SQL_Where} {SQL_OrderBy}";
            list($this->ETA_DATE_YEAR->BoundColumn, $this->ETA_DATE_YEAR->TextColumn, $this->ETA_DATE_YEAR->DBFormat) = array("years", "years", "");
            $this->ETA_DATE_YEAR->Required = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @170-08CA07B5
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["sesORDER"] = CCGetSession("ORDER", NULL);
    }
//End Initialize Method

//Validate Method @170-481D5247
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->ORDER_NO->Validate() && $Validation);
        $Validation = ($this->STATUS_ID->Validate() && $Validation);
        $Validation = ($this->IMO_NUMBER->Validate() && $Validation);
        $Validation = ($this->REQUISNUMBER->Validate() && $Validation);
        $Validation = ($this->country_id->Validate() && $Validation);
        $Validation = ($this->city_id->Validate() && $Validation);
        $Validation = ($this->PORT_ID->Validate() && $Validation);
        $Validation = ($this->AGENT_ID->Validate() && $Validation);
        $Validation = ($this->AGENT_DUTY->Validate() && $Validation);
        $Validation = ($this->ETA_HOUR->Validate() && $Validation);
        $Validation = ($this->AGENT_EVAL_OFFICE->Validate() && $Validation);
        $Validation = ($this->RETURN_REPORT_TO->Validate() && $Validation);
        $Validation = ($this->SHIP_NAME->Validate() && $Validation);
        $Validation = ($this->ETA_DATE_DAY->Validate() && $Validation);
        $Validation = ($this->ETA_DATE_MONTH->Validate() && $Validation);
        $Validation = ($this->ETA_DATE_YEAR->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->ORDER_NO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->STATUS_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->IMO_NUMBER->Errors->Count() == 0);
        $Validation =  $Validation && ($this->REQUISNUMBER->Errors->Count() == 0);
        $Validation =  $Validation && ($this->country_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->city_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->PORT_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->AGENT_ID->Errors->Count() == 0);
        $Validation =  $Validation && ($this->AGENT_DUTY->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ETA_HOUR->Errors->Count() == 0);
        $Validation =  $Validation && ($this->AGENT_EVAL_OFFICE->Errors->Count() == 0);
        $Validation =  $Validation && ($this->RETURN_REPORT_TO->Errors->Count() == 0);
        $Validation =  $Validation && ($this->SHIP_NAME->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ETA_DATE_DAY->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ETA_DATE_MONTH->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ETA_DATE_YEAR->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @170-B79B885F
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->ORDER_NO->Errors->Count());
        $errors = ($errors || $this->STATUS_ID->Errors->Count());
        $errors = ($errors || $this->IMO_NUMBER->Errors->Count());
        $errors = ($errors || $this->REQUISNUMBER->Errors->Count());
        $errors = ($errors || $this->country_id->Errors->Count());
        $errors = ($errors || $this->city_id->Errors->Count());
        $errors = ($errors || $this->PORT_ID->Errors->Count());
        $errors = ($errors || $this->AGENT_ID->Errors->Count());
        $errors = ($errors || $this->AGENT_DUTY->Errors->Count());
        $errors = ($errors || $this->ETA_HOUR->Errors->Count());
        $errors = ($errors || $this->AGENT_EVAL_OFFICE->Errors->Count());
        $errors = ($errors || $this->RETURN_REPORT_TO->Errors->Count());
        $errors = ($errors || $this->SHIP_NAME->Errors->Count());
        $errors = ($errors || $this->ETA_DATE_DAY->Errors->Count());
        $errors = ($errors || $this->ETA_DATE_MONTH->Errors->Count());
        $errors = ($errors || $this->ETA_DATE_YEAR->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @170-ED598703
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

//Operation Method @170-C1375AEE
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
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Generate";
            if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Delete->Pressed) {
                $this->PressedButton = "Button_Delete";
            } else if($this->Button_Generate->Pressed) {
                $this->PressedButton = "Button_Generate";
            }
        }
        $Redirect = "page5.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Delete") {
            $Redirect = "page1.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Update") {
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Generate") {
                $Redirect = "page6.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
                if(!CCGetEvent($this->Button_Generate->CCSEvents, "OnClick", $this->Button_Generate)) {
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

//UpdateRow Method @170-F99ECA03
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->ORDER_NO->SetValue($this->ORDER_NO->GetValue(true));
        $this->DataSource->STATUS_ID->SetValue($this->STATUS_ID->GetValue(true));
        $this->DataSource->IMO_NUMBER->SetValue($this->IMO_NUMBER->GetValue(true));
        $this->DataSource->REQUISNUMBER->SetValue($this->REQUISNUMBER->GetValue(true));
        $this->DataSource->country_id->SetValue($this->country_id->GetValue(true));
        $this->DataSource->city_id->SetValue($this->city_id->GetValue(true));
        $this->DataSource->PORT_ID->SetValue($this->PORT_ID->GetValue(true));
        $this->DataSource->AGENT_ID->SetValue($this->AGENT_ID->GetValue(true));
        $this->DataSource->AGENT_DUTY->SetValue($this->AGENT_DUTY->GetValue(true));
        $this->DataSource->ETA_DATE_DAY->SetValue($this->ETA_DATE_DAY->GetValue(true));
        $this->DataSource->ETA_HOUR->SetValue($this->ETA_HOUR->GetValue(true));
        $this->DataSource->AGENT_EVAL_OFFICE->SetValue($this->AGENT_EVAL_OFFICE->GetValue(true));
        $this->DataSource->RETURN_REPORT_TO->SetValue($this->RETURN_REPORT_TO->GetValue(true));
        $this->DataSource->ETA_DATE_MONTH->SetValue($this->ETA_DATE_MONTH->GetValue(true));
        $this->DataSource->ETA_DATE_YEAR->SetValue($this->ETA_DATE_YEAR->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @170-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @170-7DA2B55D
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

        $this->STATUS_ID->Prepare();
        $this->country_id->Prepare();
        $this->city_id->Prepare();
        $this->PORT_ID->Prepare();
        $this->AGENT_ID->Prepare();
        $this->AGENT_EVAL_OFFICE->Prepare();
        $this->ETA_DATE_DAY->Prepare();
        $this->ETA_DATE_MONTH->Prepare();
        $this->ETA_DATE_YEAR->Prepare();

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
                    $this->ORDER_NO->SetValue($this->DataSource->ORDER_NO->GetValue());
                    $this->STATUS_ID->SetValue($this->DataSource->STATUS_ID->GetValue());
                    $this->IMO_NUMBER->SetValue($this->DataSource->IMO_NUMBER->GetValue());
                    $this->REQUISNUMBER->SetValue($this->DataSource->REQUISNUMBER->GetValue());
                    $this->country_id->SetValue($this->DataSource->country_id->GetValue());
                    $this->city_id->SetValue($this->DataSource->city_id->GetValue());
                    $this->PORT_ID->SetValue($this->DataSource->PORT_ID->GetValue());
                    $this->AGENT_ID->SetValue($this->DataSource->AGENT_ID->GetValue());
                    $this->AGENT_DUTY->SetValue($this->DataSource->AGENT_DUTY->GetValue());
                    $this->ETA_HOUR->SetValue($this->DataSource->ETA_HOUR->GetValue());
                    $this->AGENT_EVAL_OFFICE->SetValue($this->DataSource->AGENT_EVAL_OFFICE->GetValue());
                    $this->RETURN_REPORT_TO->SetValue($this->DataSource->RETURN_REPORT_TO->GetValue());
                    $this->SHIP_NAME->SetValue($this->DataSource->SHIP_NAME->GetValue());
                    $this->ETA_DATE_DAY->SetValue($this->DataSource->ETA_DATE_DAY->GetValue());
                    $this->ETA_DATE_MONTH->SetValue($this->DataSource->ETA_DATE_MONTH->GetValue());
                    $this->ETA_DATE_YEAR->SetValue($this->DataSource->ETA_DATE_YEAR->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->ORDER_NO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->STATUS_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->IMO_NUMBER->Errors->ToString());
            $Error = ComposeStrings($Error, $this->REQUISNUMBER->Errors->ToString());
            $Error = ComposeStrings($Error, $this->country_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->city_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->PORT_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->AGENT_ID->Errors->ToString());
            $Error = ComposeStrings($Error, $this->AGENT_DUTY->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ETA_HOUR->Errors->ToString());
            $Error = ComposeStrings($Error, $this->AGENT_EVAL_OFFICE->Errors->ToString());
            $Error = ComposeStrings($Error, $this->RETURN_REPORT_TO->Errors->ToString());
            $Error = ComposeStrings($Error, $this->SHIP_NAME->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ETA_DATE_DAY->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ETA_DATE_MONTH->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ETA_DATE_YEAR->Errors->ToString());
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
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;
        $this->Button_Delete->Visible = $this->EditMode && $this->DeleteAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Update->Show();
        $this->Button_Delete->Show();
        $this->ORDER_NO->Show();
        $this->STATUS_ID->Show();
        $this->IMO_NUMBER->Show();
        $this->REQUISNUMBER->Show();
        $this->country_id->Show();
        $this->city_id->Show();
        $this->PORT_ID->Show();
        $this->AGENT_ID->Show();
        $this->AGENT_DUTY->Show();
        $this->ETA_HOUR->Show();
        $this->AGENT_EVAL_OFFICE->Show();
        $this->RETURN_REPORT_TO->Show();
        $this->SHIP_NAME->Show();
        $this->Button_Generate->Show();
        $this->ETA_DATE_DAY->Show();
        $this->ETA_DATE_MONTH->Show();
        $this->ETA_DATE_YEAR->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End service_tbl Class @170-FCB6E20C

class clsservice_tblDataSource extends clsDBhss_db {  //service_tblDataSource Class @170-3DA74026

//DataSource Variables @170-32B4975C
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $UpdateParameters;
    public $DeleteParameters;
    public $wp;
    public $AllParametersSet;

    public $UpdateFields = array();

    // Datasource fields
    public $ORDER_NO;
    public $STATUS_ID;
    public $IMO_NUMBER;
    public $REQUISNUMBER;
    public $country_id;
    public $city_id;
    public $PORT_ID;
    public $AGENT_ID;
    public $AGENT_DUTY;
    public $ETA_HOUR;
    public $AGENT_EVAL_OFFICE;
    public $RETURN_REPORT_TO;
    public $SHIP_NAME;
    public $ETA_DATE_DAY;
    public $ETA_DATE_MONTH;
    public $ETA_DATE_YEAR;
//End DataSource Variables

//DataSourceClass_Initialize Event @170-80280320
    function clsservice_tblDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record service_tbl/Error";
        $this->Initialize();
        $this->ORDER_NO = new clsField("ORDER_NO", ccsText, "");
        
        $this->STATUS_ID = new clsField("STATUS_ID", ccsInteger, "");
        
        $this->IMO_NUMBER = new clsField("IMO_NUMBER", ccsText, "");
        
        $this->REQUISNUMBER = new clsField("REQUISNUMBER", ccsText, "");
        
        $this->country_id = new clsField("country_id", ccsInteger, "");
        
        $this->city_id = new clsField("city_id", ccsInteger, "");
        
        $this->PORT_ID = new clsField("PORT_ID", ccsInteger, "");
        
        $this->AGENT_ID = new clsField("AGENT_ID", ccsInteger, "");
        
        $this->AGENT_DUTY = new clsField("AGENT_DUTY", ccsText, "");
        
        $this->ETA_HOUR = new clsField("ETA_HOUR", ccsText, "");
        
        $this->AGENT_EVAL_OFFICE = new clsField("AGENT_EVAL_OFFICE", ccsText, "");
        
        $this->RETURN_REPORT_TO = new clsField("RETURN_REPORT_TO", ccsText, "");
        
        $this->SHIP_NAME = new clsField("SHIP_NAME", ccsText, "");
        
        $this->ETA_DATE_DAY = new clsField("ETA_DATE_DAY", ccsText, "");
        
        $this->ETA_DATE_MONTH = new clsField("ETA_DATE_MONTH", ccsText, "");
        
        $this->ETA_DATE_YEAR = new clsField("ETA_DATE_YEAR", ccsText, "");
        

        $this->UpdateFields["ORDER_NO"] = array("Name" => "ORDER_NO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["STATUS_ID"] = array("Name" => "STATUS_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["IMO_NUMBER"] = array("Name" => "IMO_NUMBER", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["REQUISNUMBER"] = array("Name" => "REQUISNUMBER", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["country_id"] = array("Name" => "country_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["city_id"] = array("Name" => "city_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["PORT_ID"] = array("Name" => "PORT_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["AGENT_ID"] = array("Name" => "AGENT_ID", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["AGENT_DUTY"] = array("Name" => "AGENT_DUTY", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["ETA_DATE_DAY"] = array("Name" => "ETA_DATE_DAY", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["ETA_HOUR"] = array("Name" => "ETA_HOUR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["AGENT_EVAL_OFFICE"] = array("Name" => "AGENT_EVAL_OFFICE", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["RETURN_REPORT_TO"] = array("Name" => "RETURN_REPORT_TO", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["ETA_DATE_MONTH"] = array("Name" => "ETA_DATE_MONTH", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["ETA_DATE_YEAR"] = array("Name" => "ETA_DATE_YEAR", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @170-E5256A5B
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "sesORDER", ccsText, "", "", $this->Parameters["sesORDER"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "service_tbl.ORDER_NO", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @170-20B8E930
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT service_tbl.*, SHIP_NAME \n\n" .
        "FROM service_tbl INNER JOIN ships_tbl ON\n\n" .
        "service_tbl.IMO_NUMBER = ships_tbl.IMO_NUMBER {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @170-4750256F
    function SetValues()
    {
        $this->ORDER_NO->SetDBValue($this->f("ORDER_NO"));
        $this->STATUS_ID->SetDBValue(trim($this->f("STATUS_ID")));
        $this->IMO_NUMBER->SetDBValue($this->f("IMO_NUMBER"));
        $this->REQUISNUMBER->SetDBValue($this->f("REQUISNUMBER"));
        $this->country_id->SetDBValue(trim($this->f("country_id")));
        $this->city_id->SetDBValue(trim($this->f("city_id")));
        $this->PORT_ID->SetDBValue(trim($this->f("PORT_ID")));
        $this->AGENT_ID->SetDBValue(trim($this->f("AGENT_ID")));
        $this->AGENT_DUTY->SetDBValue($this->f("AGENT_DUTY"));
        $this->ETA_HOUR->SetDBValue($this->f("ETA_HOUR"));
        $this->AGENT_EVAL_OFFICE->SetDBValue($this->f("AGENT_EVAL_OFFICE"));
        $this->RETURN_REPORT_TO->SetDBValue($this->f("RETURN_REPORT_TO"));
        $this->SHIP_NAME->SetDBValue($this->f("SHIP_NAME"));
        $this->ETA_DATE_DAY->SetDBValue($this->f("ETA_DATE_DAY"));
        $this->ETA_DATE_MONTH->SetDBValue($this->f("ETA_DATE_MONTH"));
        $this->ETA_DATE_YEAR->SetDBValue($this->f("ETA_DATE_YEAR"));
    }
//End SetValues Method

//Update Method @170-2C8C9D7F
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["ORDER_NO"] = new clsSQLParameter("ctrlORDER_NO", ccsText, "", "", $this->ORDER_NO->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["STATUS_ID"] = new clsSQLParameter("ctrlSTATUS_ID", ccsInteger, "", "", $this->STATUS_ID->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["IMO_NUMBER"] = new clsSQLParameter("ctrlIMO_NUMBER", ccsText, "", "", $this->IMO_NUMBER->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["REQUISNUMBER"] = new clsSQLParameter("ctrlREQUISNUMBER", ccsText, "", "", $this->REQUISNUMBER->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["country_id"] = new clsSQLParameter("ctrlcountry_id", ccsInteger, "", "", $this->country_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["city_id"] = new clsSQLParameter("ctrlcity_id", ccsInteger, "", "", $this->city_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["PORT_ID"] = new clsSQLParameter("ctrlPORT_ID", ccsInteger, "", "", $this->PORT_ID->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["AGENT_ID"] = new clsSQLParameter("ctrlAGENT_ID", ccsInteger, "", "", $this->AGENT_ID->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["AGENT_DUTY"] = new clsSQLParameter("ctrlAGENT_DUTY", ccsText, "", "", $this->AGENT_DUTY->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["ETA_DATE_DAY"] = new clsSQLParameter("ctrlETA_DATE_DAY", ccsText, "", "", $this->ETA_DATE_DAY->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["ETA_HOUR"] = new clsSQLParameter("ctrlETA_HOUR", ccsText, "", "", $this->ETA_HOUR->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["AGENT_EVAL_OFFICE"] = new clsSQLParameter("ctrlAGENT_EVAL_OFFICE", ccsText, "", "", $this->AGENT_EVAL_OFFICE->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["RETURN_REPORT_TO"] = new clsSQLParameter("ctrlRETURN_REPORT_TO", ccsText, "", "", $this->RETURN_REPORT_TO->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["ETA_DATE_MONTH"] = new clsSQLParameter("ctrlETA_DATE_MONTH", ccsText, "", "", $this->ETA_DATE_MONTH->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["ETA_DATE_YEAR"] = new clsSQLParameter("ctrlETA_DATE_YEAR", ccsText, "", "", $this->ETA_DATE_YEAR->GetValue(true), NULL, false, $this->ErrorBlock);
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "sesORDER", ccsText, "", "", CCGetSession("ORDER", NULL), "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        if (!is_null($this->cp["ORDER_NO"]->GetValue()) and !strlen($this->cp["ORDER_NO"]->GetText()) and !is_bool($this->cp["ORDER_NO"]->GetValue())) 
            $this->cp["ORDER_NO"]->SetValue($this->ORDER_NO->GetValue(true));
        if (!is_null($this->cp["STATUS_ID"]->GetValue()) and !strlen($this->cp["STATUS_ID"]->GetText()) and !is_bool($this->cp["STATUS_ID"]->GetValue())) 
            $this->cp["STATUS_ID"]->SetValue($this->STATUS_ID->GetValue(true));
        if (!is_null($this->cp["IMO_NUMBER"]->GetValue()) and !strlen($this->cp["IMO_NUMBER"]->GetText()) and !is_bool($this->cp["IMO_NUMBER"]->GetValue())) 
            $this->cp["IMO_NUMBER"]->SetValue($this->IMO_NUMBER->GetValue(true));
        if (!is_null($this->cp["REQUISNUMBER"]->GetValue()) and !strlen($this->cp["REQUISNUMBER"]->GetText()) and !is_bool($this->cp["REQUISNUMBER"]->GetValue())) 
            $this->cp["REQUISNUMBER"]->SetValue($this->REQUISNUMBER->GetValue(true));
        if (!is_null($this->cp["country_id"]->GetValue()) and !strlen($this->cp["country_id"]->GetText()) and !is_bool($this->cp["country_id"]->GetValue())) 
            $this->cp["country_id"]->SetValue($this->country_id->GetValue(true));
        if (!is_null($this->cp["city_id"]->GetValue()) and !strlen($this->cp["city_id"]->GetText()) and !is_bool($this->cp["city_id"]->GetValue())) 
            $this->cp["city_id"]->SetValue($this->city_id->GetValue(true));
        if (!is_null($this->cp["PORT_ID"]->GetValue()) and !strlen($this->cp["PORT_ID"]->GetText()) and !is_bool($this->cp["PORT_ID"]->GetValue())) 
            $this->cp["PORT_ID"]->SetValue($this->PORT_ID->GetValue(true));
        if (!is_null($this->cp["AGENT_ID"]->GetValue()) and !strlen($this->cp["AGENT_ID"]->GetText()) and !is_bool($this->cp["AGENT_ID"]->GetValue())) 
            $this->cp["AGENT_ID"]->SetValue($this->AGENT_ID->GetValue(true));
        if (!is_null($this->cp["AGENT_DUTY"]->GetValue()) and !strlen($this->cp["AGENT_DUTY"]->GetText()) and !is_bool($this->cp["AGENT_DUTY"]->GetValue())) 
            $this->cp["AGENT_DUTY"]->SetValue($this->AGENT_DUTY->GetValue(true));
        if (!is_null($this->cp["ETA_DATE_DAY"]->GetValue()) and !strlen($this->cp["ETA_DATE_DAY"]->GetText()) and !is_bool($this->cp["ETA_DATE_DAY"]->GetValue())) 
            $this->cp["ETA_DATE_DAY"]->SetValue($this->ETA_DATE_DAY->GetValue(true));
        if (!is_null($this->cp["ETA_HOUR"]->GetValue()) and !strlen($this->cp["ETA_HOUR"]->GetText()) and !is_bool($this->cp["ETA_HOUR"]->GetValue())) 
            $this->cp["ETA_HOUR"]->SetValue($this->ETA_HOUR->GetValue(true));
        if (!is_null($this->cp["AGENT_EVAL_OFFICE"]->GetValue()) and !strlen($this->cp["AGENT_EVAL_OFFICE"]->GetText()) and !is_bool($this->cp["AGENT_EVAL_OFFICE"]->GetValue())) 
            $this->cp["AGENT_EVAL_OFFICE"]->SetValue($this->AGENT_EVAL_OFFICE->GetValue(true));
        if (!is_null($this->cp["RETURN_REPORT_TO"]->GetValue()) and !strlen($this->cp["RETURN_REPORT_TO"]->GetText()) and !is_bool($this->cp["RETURN_REPORT_TO"]->GetValue())) 
            $this->cp["RETURN_REPORT_TO"]->SetValue($this->RETURN_REPORT_TO->GetValue(true));
        if (!is_null($this->cp["ETA_DATE_MONTH"]->GetValue()) and !strlen($this->cp["ETA_DATE_MONTH"]->GetText()) and !is_bool($this->cp["ETA_DATE_MONTH"]->GetValue())) 
            $this->cp["ETA_DATE_MONTH"]->SetValue($this->ETA_DATE_MONTH->GetValue(true));
        if (!is_null($this->cp["ETA_DATE_YEAR"]->GetValue()) and !strlen($this->cp["ETA_DATE_YEAR"]->GetText()) and !is_bool($this->cp["ETA_DATE_YEAR"]->GetValue())) 
            $this->cp["ETA_DATE_YEAR"]->SetValue($this->ETA_DATE_YEAR->GetValue(true));
        $wp->Criterion[1] = $wp->Operation(opEqual, "service_tbl.ORDER_NO", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsText),false);
        $Where = 
             $wp->Criterion[1];
        $this->UpdateFields["ORDER_NO"]["Value"] = $this->cp["ORDER_NO"]->GetDBValue(true);
        $this->UpdateFields["STATUS_ID"]["Value"] = $this->cp["STATUS_ID"]->GetDBValue(true);
        $this->UpdateFields["IMO_NUMBER"]["Value"] = $this->cp["IMO_NUMBER"]->GetDBValue(true);
        $this->UpdateFields["REQUISNUMBER"]["Value"] = $this->cp["REQUISNUMBER"]->GetDBValue(true);
        $this->UpdateFields["country_id"]["Value"] = $this->cp["country_id"]->GetDBValue(true);
        $this->UpdateFields["city_id"]["Value"] = $this->cp["city_id"]->GetDBValue(true);
        $this->UpdateFields["PORT_ID"]["Value"] = $this->cp["PORT_ID"]->GetDBValue(true);
        $this->UpdateFields["AGENT_ID"]["Value"] = $this->cp["AGENT_ID"]->GetDBValue(true);
        $this->UpdateFields["AGENT_DUTY"]["Value"] = $this->cp["AGENT_DUTY"]->GetDBValue(true);
        $this->UpdateFields["ETA_DATE_DAY"]["Value"] = $this->cp["ETA_DATE_DAY"]->GetDBValue(true);
        $this->UpdateFields["ETA_HOUR"]["Value"] = $this->cp["ETA_HOUR"]->GetDBValue(true);
        $this->UpdateFields["AGENT_EVAL_OFFICE"]["Value"] = $this->cp["AGENT_EVAL_OFFICE"]->GetDBValue(true);
        $this->UpdateFields["RETURN_REPORT_TO"]["Value"] = $this->cp["RETURN_REPORT_TO"]->GetDBValue(true);
        $this->UpdateFields["ETA_DATE_MONTH"]["Value"] = $this->cp["ETA_DATE_MONTH"]->GetDBValue(true);
        $this->UpdateFields["ETA_DATE_YEAR"]["Value"] = $this->cp["ETA_DATE_YEAR"]->GetDBValue(true);
        $this->SQL = CCBuildUpdate("service_tbl", $this->UpdateFields, $this);
        $this->SQL .= strlen($Where) ? " WHERE " . $Where : $Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

//Delete Method @170-4C0E8A75
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "sesORDER", ccsText, "", "", CCGetSession("ORDER", NULL), "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $wp->Criterion[1] = $wp->Operation(opEqual, "service_tbl.ORDER_NO", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsText),false);
        $Where = 
             $wp->Criterion[1];
        $this->SQL = "DELETE FROM service_tbl";
        $this->SQL = CCBuildSQL($this->SQL, $Where, "");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End service_tblDataSource Class @170-FCB6E20C







//Initialize Page @1-69EBC44A
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
$TemplateFileName = "page5.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-74C32035
$DBhss_db = new clsDBhss_db();
$MainPage->Connections["hss_db"] = & $DBhss_db;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$employees_tbl_equipment_m1 = new clsGridemployees_tbl_equipment_m1("", $MainPage);
$Link2 = new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet, NULL), $MainPage);
$Link2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link2->Page = "page1.php";
$service_tbl = new clsRecordservice_tbl("", $MainPage);
$Link3 = new clsControl(ccsLink, "Link3", "Link3", ccsText, "", CCGetRequestParam("Link3", ccsGet, NULL), $MainPage);
$Link3->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link3->Page = "page1_1.php";
$MainPage->employees_tbl_equipment_m1 = & $employees_tbl_equipment_m1;
$MainPage->Link2 = & $Link2;
$MainPage->service_tbl = & $service_tbl;
$MainPage->Link3 = & $Link3;
$employees_tbl_equipment_m1->Initialize();
$service_tbl->Initialize();

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

//Execute Components @1-14561358
$service_tbl->Operation();
//End Execute Components

//Go to destination page @1-B76C6726
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBhss_db->close();
    header("Location: " . $Redirect);
    unset($employees_tbl_equipment_m1);
    unset($service_tbl);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-BA12D3BE
$employees_tbl_equipment_m1->Show();
$service_tbl->Show();
$Link2->Show();
$Link3->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-0318D04E
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBhss_db->close();
unset($employees_tbl_equipment_m1);
unset($service_tbl);
unset($Tpl);
//End Unload Page


?>
