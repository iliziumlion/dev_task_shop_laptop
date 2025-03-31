<?php
use Bitrix\Main\Loader;

try {
    Loader::registerAutoLoadClasses('laptop.shop', [
        'Laptop\Shop\Model\ManufacturerTable' => 'lib/Model/ManufacturerTable.php',
        'Laptop\Shop\Model\ModelTable' => 'lib/Model/ModelTable.php',
        'Laptop\Shop\Model\NotebookTable' => 'lib/Model/NotebookTable.php',
        'Laptop\Shop\Model\OptionTable' => 'lib/Model/OptionTable.php',

        'Laptop\Shop\Relation\NotebookOptionTable' => 'lib/Relation/NotebookOptionTable.php',
    ]);
} catch (\Bitrix\Main\LoaderException $e) {
    $error = true;
}