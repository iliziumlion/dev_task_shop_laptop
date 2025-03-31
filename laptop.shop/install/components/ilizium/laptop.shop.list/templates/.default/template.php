<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$entityType = $arResult["ENTITY_TYPE"];
$title      = $arResult["TITLE"] ?? "Список";
$items      = $arResult["ITEMS"] ?? [];
$nav        = $arResult["NAV"] ?? null;

$sortField  = $arResult["SORT_FIELD"];
$sortOrder  = $arResult["SORT_ORDER"];
$pageSize   = $arResult["PAGE_SIZE"];

$sortAscPrice   = $APPLICATION->GetCurPageParam("sort=price&order=asc", ["sort", "order"]);
$sortDescPrice  = $APPLICATION->GetCurPageParam("sort=price&order=desc", ["sort", "order"]);
$sortAscYear    = $APPLICATION->GetCurPageParam("sort=year&order=asc", ["sort", "order"]);
$sortDescYear   = $APPLICATION->GetCurPageParam("sort=year&order=desc", ["sort", "order"]);

$link1 = $APPLICATION->GetCurPageParam("page_size=1", ["page_size"]);
$link3 = $APPLICATION->GetCurPageParam("page_size=3", ["page_size"]);
$link5 = $APPLICATION->GetCurPageParam("page_size=5", ["page_size"]);
?>
<div class="container">
    <h3><?= htmlspecialcharsbx($title) ?></h3>

    <?php if ($arResult["ENTITY_TYPE"] === "notebook"): ?>
        <div class="mb-2">
            <strong>Сортировать по:</strong>
            <a href="<?= $sortAscPrice ?>">Цена (возр.)</a> |
            <a href="<?= $sortDescPrice ?>">Цена (убыв.)</a> |
            <a href="<?= $sortAscYear ?>">Год (возр.)</a> |
            <a href="<?= $sortDescYear ?>">Год (убыв.)</a>
        </div>
    <?php endif; ?>

    <div class="mb-2">
        <strong>На странице:</strong>
        <a href="<?=$link1?>">1</a> |
        <a href="<?=$link3?>">3</a> |
        <a href="<?=$link5?>">5</a>
    </div>

    <?php if (empty($items)): ?>
        <div class="alert alert-warning">Нет элементов</div>
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <?php if ($entityType === "manufacturer"): ?>
                    <th>ID</th>
                    <th>Производитель</th>
                <?php elseif ($entityType === "model"): ?>
                    <th>ID</th>
                    <th>Модель</th>
                    <th>Производитель</th>
                <?php elseif ($entityType === "notebook"): ?>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Год</th>
                    <th>Цена</th>
                    <th>Модель</th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $row): ?>
                <tr>
                    <?php if ($entityType === "manufacturer"): ?>
                        <td><?= $row["ID"] ?></td>
                        <td>
                            <a href="?SEF_BRAND=<?= urlencode($row["NAME"]) ?>">
                                <?= htmlspecialcharsbx($row["NAME"]) ?>
                            </a>
                        </td>
                    <?php elseif ($entityType === "model"): ?>
                        <td><?= $row["ID"] ?></td>
                        <td>
                            <a href="?SEF_BRAND=<?= urlencode($_REQUEST["SEF_BRAND"]) ?>&SEF_MODEL=<?= urlencode($row["NAME"]) ?>">
                                <?= htmlspecialcharsbx($row["NAME"]) ?>
                            </a>
                        </td>
                        <td><?= $row["MANUFACTURER_NAME"] ?>
                        </td>
                    <?php elseif ($entityType === "notebook"): ?>
                        <td><?= $row["ID"] ?></td>
                        <td>
                            <a href="detail/<?= $row["ID"] ?>/">
                                <?= htmlspecialcharsbx($row["NAME"]) ?>
                            </a>
                        </td>
                        <td><?= $row["YEAR"] ?></td>
                        <td><?= $row["PRICE"] ?></td>
                        <td><?= $row["MODEL_NAME"] ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        $APPLICATION->IncludeComponent("bitrix:main.pagenavigation", "", [
            "NAV_OBJECT" => $nav,
            "SEF_MODE" => "N",
        ]);
        ?>
    <?php endif; ?>
</div>