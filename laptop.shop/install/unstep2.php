<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
IncludeModuleLangFile(__FILE__);

global $DB;
$savedata = ($_POST['savedata'] ?? '') === 'Y';
if (!$savedata || $savedata == '') {
    $DB->Query("DROP TABLE IF EXISTS " . ManufacturerTable::getTableName());
    $DB->Query("DROP TABLE IF EXISTS " . ModelTable::getTableName());
    $DB->Query("DROP TABLE IF EXISTS " . NotebookTable::getTableName());
    $DB->Query("DROP TABLE IF EXISTS " . OptionTable::getTableName());
    $DB->Query("DROP TABLE IF EXISTS " . NotebookOptionTable::getTableName());
}



