<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$notebook     = $arResult["NOTEBOOK"];
$model        = $arResult["MODEL"];
$manufacturer = $arResult["BRAND"];
$options      = $arResult["OPTIONS"];
?>
<div class="container">
    <?php if (!$notebook): ?>
        <div class="alert alert-danger">Ноутбук не найден</div>
    <?php else: ?>
        <h3>Ноутбук <?=htmlspecialcharsbx($notebook["NAME"])?> (ID: <?=$notebook["ID"]?>)</h3>

        <p><strong>Производитель:</strong>
            <?php if ($manufacturer): ?>
                <?=htmlspecialcharsbx($manufacturer["NAME"])?> (ID: <?=$manufacturer["ID"]?>)
            <?php else: ?>
                неизвестен
            <?php endif; ?>
        </p>

        <p><strong>Модель:</strong>
            <?php if ($model): ?>
                <?=htmlspecialcharsbx($model["NAME"])?> (ID: <?=$model["ID"]?>)
            <?php else: ?>
                неизвестна
            <?php endif; ?>
        </p>

        <p><strong>Год выпуска:</strong> <?=htmlspecialcharsbx($notebook["YEAR"])?> </p>
        <p><strong>Цена:</strong> <?=htmlspecialcharsbx($notebook["PRICE"])?> руб.</p>

        <hr>
        <h4>Опции:</h4>
        <?php if (!empty($options)): ?>
            <ul>
                <?php foreach ($options as $opt): ?>
                    <li><?=htmlspecialcharsbx($opt["NAME"])?> (ID: <?=$opt["ID"]?>)</li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="alert alert-info">Нет дополнительных опций</div>
        <?php endif; ?>
    <?php endif; ?>
</div>