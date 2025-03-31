<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Laptop\Shop\Model\NotebookTable;
use Laptop\Shop\Model\ModelTable;
use Laptop\Shop\Model\ManufacturerTable;

use Laptop\Shop\Relation\NotebookOptionTable;

Loc::loadMessages(__FILE__);

class LaptopShopDetailComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        if (!Loader::includeModule("laptop.shop")) {
            ShowError("Модуль laptop.shop не установлен");
            return;
        }

        $request = \Bitrix\Main\Context::getCurrent()->getRequest();
        $notebookId = $request->get("SEF_NOTEBOOK") ?: 0;

        $notebookId = (int)$notebookId;
        if ($notebookId <= 0) {
            ShowError("Неверный идентификатор ноутбука");
            return;
        }

        // Загружаем данные ноутбука
        $notebook = NotebookTable::getList([
            "select" => [
                "ID", "NAME", "YEAR", "PRICE", "MODEL_ID",
            ],
            "filter" => ["=ID" => $notebookId],
        ])->fetch();
        if (!$notebook) {
            ShowError("Ноутбук не найден");
            return;
        }

        // Загружаем модель
        $model = ModelTable::getList([
            "select" => ["ID", "NAME", "MANUFACTURER_ID"],
            "filter" => ["=ID" => $notebook["MODEL_ID"]],
        ])->fetch();

        // Загружаем производителя (если есть модель)
        $manufacturer = null;
        if ($model) {
            $manufacturer = ManufacturerTable::getList([
                "select" => ["ID", "NAME"],
                "filter" => ["=ID" => $model["MANUFACTURER_ID"]],
            ])->fetch();
        }

        // Опции ноутбука (связь многие-ко-многим)
        $optionRows = NotebookOptionTable::getList([
            "select" => [
                "OPTION_ID",
                "OPTION_NAME" => "OPTION.NAME",
            ],
            "filter" => ["=NOTEBOOK_ID" => $notebookId],
        ]);

        $options = [];
        while ($row = $optionRows->fetch()) {
            $options[] = [
                "ID" => $row["OPTION_ID"],
                "NAME" => $row["OPTION_NAME"],
            ];
        }

        $this->arResult["NOTEBOOK"] = $notebook;
        $this->arResult["MODEL"] = $model;
        $this->arResult["BRAND"] = $manufacturer;
        $this->arResult["OPTIONS"] = $options;

        $this->includeComponentTemplate();
    }
}
