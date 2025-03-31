<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

class LaptopShopComplexComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        $arDefaultUrlTemplates404 = [
            "manufacturers" => "",
            "models"        => "#BRAND#/",
            "notebooks"     => "#BRAND#/#MODEL#/",
            "detail"        => "detail/#NOTEBOOK#/",
        ];

        $arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates(
            $arDefaultUrlTemplates404,
            $this->arParams["SEF_URL_TEMPLATES"]
        );

        $arVariables = [];
        $componentPage = CComponentEngine::ParseComponentPath(
            $this->arParams["SEF_FOLDER"] ?? "/laptops/",
            $arUrlTemplates,
            $arVariables
        );

        if (!$componentPage) {
            $componentPage = "manufacturers";
        }

        $this->arResult = [
            "FOLDER"        => $this->arParams["SEF_FOLDER"],
            "URL_TEMPLATES" => $arUrlTemplates,
            "VARIABLES"     => $arVariables,
            "PAGE"          => $componentPage,
        ];

        $this->includeComponentTemplate($componentPage);
    }
}
