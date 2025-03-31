<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<div class="container">
    <h1>Список производителей</h1>
    <?php
    global $APPLICATION;
    $APPLICATION->IncludeComponent(
        "ilizium:laptop.shop.list",
        "",
        []
    );
    ?>
</div>