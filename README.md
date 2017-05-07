# filemanager

The filemanager project models several processes within a service company. It is composed by a set of tools stored inside the _**webapps**_ folder.

For the operation of filemanager, data is extracted periodically from an ERP's database.
This data is then used firstly by worksheet, where the service process starts.

## List of Webapps and Utility tools:
* **worksheet** - depends on the import of data from an ERP, done by _mssql_importer.php_.  This app kickstarts the service process and generates a _worksheet.pdf_ file to be delivered to engineers on their way out to a service.
* **file_manager** - in charge of creating the filesystem for each service case, and presenting content to users.
* **reportstarter** - interface used by service coordinators to create a new _.xml_ file containing service information. The _.xml_ file is sent automatically to assigned engineer(s) via email.
* **after_service_data** - set of forms used to feed the system with information after a service is done.
* **failed_service** - later replaced by reports done under **hssiso**
* **returned_parts** - form used by service engineers to report a defective part has to be sent to factory for repair/warranty. Generates a _.pdf_ and sends and automated email to Logistics Dept.
* **employees** - general creation/administration of users,
* **hssiso** - set of forms created to comply with ISO 9001:2008 standard. Categorized by area (service, sales, logistics, etc), generates _.pdf_ reports that are automatically sent to Quality Manager.
* **service_search** - tool used to look for specific cases, filtering by date, manufacturer, equipment type and model.
* **tech_eval** - tool used to input evaluations made by customers.
* **tools_man** - tool used to manage and control the use of workshop tools in the company.  Works together with **barcodes_app** (found in the root level of this Project).
* **workshopin** - form used by warehouse personnel to report and control the delivery of parts/equipment in to be processed by the workshop.
* **ws_dummy** - form created as a backup in case of failure of the filemanager system.  **This tool has never been used**.

All webapps except **hssiso**, **reportstarter** and **barcodes_app** were created using a tool called CodeCharge (v4). CodeCharge is a sort of framework but not like Laravel, it is stricter, one can only use local libraries/modules to produce the app. In general, I don't like it.

There is a list of _**utility**_ web tools used to directly extract specific data from the ERP and produce reports (in .xlsx or .pdf formats) to be delivered to external parties (like Panama's MEF, suppliers, customers).

* **cobham** - generates a quarterly report of sales for an specific manufacturer
* **mef** - generates a monthly report of payments to suppliers (MEF Form 43)
* **mef_taxes** - generates a yearly report of payments to suppliers (used for Taxes declaration purposes).
* **stock** - synchronizes stock/inventory data between ERP's and local databases. These reports are used for several purposes including informing customers about availability of parts/equipment for specific service cases.

## Stack
* Ubuntu Server 12.04
* Apache2
* MySQL 5
* PHP5.3
* jQuery (for parts of the UI and some user interactions)
* postfix (for sending automated emails)
* bash scripting (for database backups and complete data/files incremental backups to a remote storage)

