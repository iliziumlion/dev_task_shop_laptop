<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentParameters = [
    "GROUPS" => [],
    "PARAMETERS" => [
        "SEF_MODE" => [
            "manufacturers" => [
                "NAME"      => "Список производителей",
                "DEFAULT"   => "",
                "VARIABLES" => [],
            ],
            "models" => [
                "NAME"      => "Список моделей",
                "DEFAULT"   => "#BRAND#/",
                "VARIABLES" => ["BRAND"],
            ],
            "notebooks" => [
                "NAME"      => "Список ноутбуков",
                "DEFAULT"   => "#BRAND#/#MODEL#/",
                "VARIABLES" => ["BRAND", "MODEL"],
            ],
            "detail" => [
                "NAME"      => "Детальная страница",
                "DEFAULT"   => "detail/#NOTEBOOK#/",
                "VARIABLES" => ["NOTEBOOK"],
            ],
        ],
        "SEF_FOLDER" => [
            "NAME"    => "Каталог для ЧПУ (SEF_FOLDER)",
            "TYPE"    => "STRING",
            "DEFAULT" => "/laptops/",
        ],
    ],
];
