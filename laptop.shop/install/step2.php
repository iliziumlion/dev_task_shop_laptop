<?php

use Bitrix\Main\Localization\Loc;
use Laptop\Shop\Model\ManufacturerTable;
use Laptop\Shop\Model\ModelTable;
use Laptop\Shop\Model\NotebookTable;
use Laptop\Shop\Model\OptionTable;
use Laptop\Shop\Relation\NotebookOptionTable;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
IncludeModuleLangFile(__FILE__);

$deleteTables = ($_POST['delete_tables'] ?? '') === 'Y';

global $DB;
if ($deleteTables) {
    $DB->Query("DROP TABLE IF EXISTS " . ManufacturerTable::getTableName());
    $DB->Query("DROP TABLE IF EXISTS " . ModelTable::getTableName());
    $DB->Query("DROP TABLE IF EXISTS " . NotebookTable::getTableName());
    $DB->Query("DROP TABLE IF EXISTS " . OptionTable::getTableName());
    $DB->Query("DROP TABLE IF EXISTS " . NotebookOptionTable::getTableName());
}

$DB->Query("CREATE TABLE IF NOT EXISTS " . ManufacturerTable::getTableName() . " (
    ID int(11) NOT NULL AUTO_INCREMENT,
    NAME varchar(255) NOT NULL,
    PRIMARY KEY (ID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

$DB->Query("CREATE TABLE IF NOT EXISTS " . ModelTable::getTableName() . " (
    ID int(11) NOT NULL AUTO_INCREMENT,
    NAME varchar(255) NOT NULL,
    MANUFACTURER_ID int(11) NOT NULL,
    PRIMARY KEY (ID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

$DB->Query("CREATE TABLE IF NOT EXISTS " . NotebookTable::getTableName() . " (
    ID int(11) NOT NULL AUTO_INCREMENT,
    NAME varchar(255) NOT NULL,
    YEAR int(4) NOT NULL,
    PRICE float NOT NULL,
    MODEL_ID int(11) NOT NULL,
    PRIMARY KEY (ID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

$DB->Query("CREATE TABLE IF NOT EXISTS " . OptionTable::getTableName() . " (
    ID int(11) NOT NULL AUTO_INCREMENT,
    NAME varchar(255) NOT NULL,
    PRIMARY KEY (ID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

$DB->Query("CREATE TABLE IF NOT EXISTS " . NotebookOptionTable::getTableName() . " (
    NOTEBOOK_ID int(11) NOT NULL,
    OPTION_ID int(11) NOT NULL,
    PRIMARY KEY (NOTEBOOK_ID, OPTION_ID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

$brandNames = [
    "Lenovo",
    "HP",
    "Dell",
    "Apple",
    "Asus",
];

$brandMap = [];
foreach ($brandNames as $brand) {
    $result = ManufacturerTable::add([
        "NAME" => $brand
    ]);
    if ($result->isSuccess()) {
        $brandId = $result->getId();
        $brandMap[$brand] = $brandId;
    }
}

$modelsData = [
    "Lenovo" => ["ThinkPad T14", "IdeaPad Gaming 3"],
    "HP" => ["Pavilion 15", "Spectre x360"],
    "Dell" => ["Inspiron 15", "XPS 13"],
    "Apple" => ["MacBook Air", "MacBook Pro"],
    "Asus" => ["ZenBook 14", "ROG Zephyrus G14"],
];

$modelMap = [];
foreach ($modelsData as $brandName => $modelList) {
    if (!isset($brandMap[$brandName])) {
        continue;
    }
    $manufacturerId = $brandMap[$brandName];

    foreach ($modelList as $modelName) {
        $res = ModelTable::add([
            "NAME" => $modelName,
            "MANUFACTURER_ID" => $manufacturerId,
        ]);
        if ($res->isSuccess()) {
            $modelMap[$modelName] = $res->getId();
        }
    }
}

$years = [2019, 2020, 2021, 2022, 2023];
$notebookIds = [];

foreach ($modelsData as $brandName => $modelList) {
    foreach ($modelList as $modelName) {
        if (!isset($modelMap[$modelName])) {
            continue;
        }
        $modelId = $modelMap[$modelName];

        for ($i = 1; $i <= 2; $i++) {
            $year = $years[array_rand($years)];
            $price = mt_rand(50, 250) * 10;

            $resNotebook = NotebookTable::add([
                "NAME" => $modelName . " " . $i,
                "MODEL_ID" => $modelId,
                "YEAR" => $year,
                "PRICE" => $price,
            ]);

            if ($resNotebook->isSuccess()) {
                $notebookId = $resNotebook->getId();
                $notebookIds[] = $notebookId;
            }
        }
    }
}

$optionsList = [
    "Backlit Keyboard",
    "Fingerprint Reader",
    "Touchscreen",
    "Bluetooth",
    "NumPad",
];

$optionIds = [];
foreach ($optionsList as $optionName) {
    $resOption = OptionTable::add([
        "NAME" => $optionName,
    ]);
    if ($resOption->isSuccess()) {
        $optionIds[] = $resOption->getId();
    }
}

foreach ($notebookIds as $nbId) {
    $count = mt_rand(1, count($optionIds));
    $assignedKeys = array_rand($optionIds, $count);
    if (!is_array($assignedKeys)) {
        $assignedKeys = [$assignedKeys];
    }

    foreach ($assignedKeys as $optIndex) {
        $optionId = $optionIds[$optIndex];
        NotebookOptionTable::add([
            "NOTEBOOK_ID" => $nbId,
            "OPTION_ID" => $optionId,
        ]);
    }
}

if (!\Bitrix\Main\ModuleManager::isModuleInstalled('laptop_shop')) {
    RegisterModule('laptop_shop');
}

echo Loc::getMessage('LAPTOP_SHOP_INSTALL_SUCCESS');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");