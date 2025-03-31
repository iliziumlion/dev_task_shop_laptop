<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Laptop\Shop\Model\ManufacturerTable;
use Laptop\Shop\Model\ModelTable;
use Laptop\Shop\Model\NotebookTable;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\PageNavigation;

Loc::loadMessages(__FILE__);

class LaptopShopListComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        return parent::onPrepareComponentParams($arParams);
    }

    public function executeComponent()
    {
        if (!Loader::includeModule("laptop.shop")) {
            ShowError("Модуль laptop.shop не установлен");
            return;
        }

        $this->prepareResult();
        $this->includeComponentTemplate();
    }

    protected function prepareResult()
    {
        $request = \Bitrix\Main\Context::getCurrent()->getRequest();

        $brand = $request->get("SEF_BRAND");
        $model = $request->get("SEF_MODEL");

        $sortField = strtolower($request->get("sort"));
        if (!in_array($sortField, ["price", "year"])) {
            $sortField = "price"; // по умолчанию
        }
        $sortOrder = strtolower($request->get("order"));
        if (!in_array($sortOrder, ["asc", "desc"])) {
            $sortOrder = "asc"; // по умолчанию
        }

        $pageSize = (int)$request->get("page_size");
        if ($pageSize <= 0) {
            $pageSize = 10;
        }

        // Настраиваем PageNavigation
        $nav = new PageNavigation("page");
        $nav->allowAllRecords(false)
            ->setPageSize($pageSize)
            ->initFromUri();

        if ($brand && $model) {
            // Список ноутбуков
            $this->arResult["ENTITY_TYPE"] = "notebook";
            $this->arResult["TITLE"] = "Ноутбуки модели «{$model}» (бренд: {$brand})";

            $modelRow = ModelTable::getRow([
                "select" => ["ID"],
                "filter" => ["=NAME" => $model],
            ]);
            if (!$modelRow) {
                $this->arResult["ITEMS"] = [];
                $this->arResult["NAV"] = $nav;
                return;
            }

            // Осуществляем запрос по ноутбукам (NotebookTable)
            $res = NotebookTable::getList([
                "select" => ["ID", "NAME", "YEAR", "PRICE", "MODEL_ID", "MODEL_NAME" => "MODEL.NAME"],
                "filter" => ["=MODEL_ID" => $modelRow["ID"]],
                "order" => [
                    strtoupper($sortField) => $sortOrder,
                ],
                "limit" => $nav->getLimit(),
                "offset" => $nav->getOffset(),
            ]);

            $items = [];
            while ($row = $res->fetch()) {
                $items[] = $row;
            }

            // Всего (для пагинации)
            $countTotal = NotebookTable::getCount(["=MODEL_ID" => $modelRow["ID"]]);
            $nav->setRecordCount($countTotal);

            $this->arResult["ITEMS"] = $items;
            $this->arResult["NAV"] = $nav;
            $this->arResult["SORT_FIELD"] = $sortField;
            $this->arResult["SORT_ORDER"] = $sortOrder;
            $this->arResult["PAGE_SIZE"] = $pageSize;

        } elseif ($brand) {
            // Список моделей бренда
            $this->arResult["ENTITY_TYPE"] = "model";
            $this->arResult["TITLE"] = "Модели бренда «{$brand}»";

            $brandRow = ManufacturerTable::getRow([
                "select" => ["ID"],
                "filter" => ["=NAME" => $brand],
            ]);
            if (!$brandRow) {
                $this->arResult["ITEMS"] = [];
                $this->arResult["NAV"] = $nav;
                return;
            }

            // Запрашиваем модели
            $res = ModelTable::getList([
                "select" => ["ID", "NAME", "MANUFACTURER_ID", "MANUFACTURER_NAME" => "MANUFACTURER.NAME"],
                "filter" => ["=MANUFACTURER_ID" => $brandRow["ID"]],
                "order" => ["ID" => "ASC"],
                "limit" => $nav->getLimit(),
                "offset" => $nav->getOffset(),
            ]);

            $items = [];
            while ($row = $res->fetch()) {
                $items[] = $row;
            }
            $countTotal = ModelTable::getCount(["=MANUFACTURER_ID" => $brandRow["ID"]]);
            $nav->setRecordCount($countTotal);

            $this->arResult["ITEMS"] = $items;
            $this->arResult["NAV"] = $nav;
            $this->arResult["SORT_FIELD"] = $sortField;
            $this->arResult["SORT_ORDER"] = $sortOrder;
            $this->arResult["PAGE_SIZE"] = $pageSize;

        } else {
            // Список производителей
            $this->arResult["ENTITY_TYPE"] = "manufacturer";
            $this->arResult["TITLE"] = "Производители";

            $res = ManufacturerTable::getList([
                "select" => ["ID", "NAME"],
                "order" => ["ID" => "ASC"],
                "limit" => $nav->getLimit(),
                "offset" => $nav->getOffset(),
            ]);

            $items = [];
            while ($row = $res->fetch()) {
                $items[] = $row;
            }
            $countTotal = ManufacturerTable::getCount([]);
            $nav->setRecordCount($countTotal);

            $this->arResult["ITEMS"] = $items;
            $this->arResult["NAV"] = $nav;
            $this->arResult["SORT_FIELD"] = $sortField;
            $this->arResult["SORT_ORDER"] = $sortOrder;
            $this->arResult["PAGE_SIZE"] = $pageSize;
        }
    }
}
