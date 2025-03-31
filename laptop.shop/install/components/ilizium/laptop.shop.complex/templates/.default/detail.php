<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$notebook = $arResult["VARIABLES"]["NOTEBOOK"] ?? "";
?>
<div class="container">
    <h1>Детальная страница ноутбука <?= htmlspecialcharsbx($notebook) ?></h1>
    <?php
    global $APPLICATION;
    $APPLICATION->IncludeComponent(
        "ilizium:laptop.shop.detail",
        "",
        [
            "SEF_NOTEBOOK" => $notebook,
        ]
    );
    ?>
</div>