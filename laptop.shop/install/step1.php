<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid()) {
    die("Ошибка сессии");
}
global $APPLICATION;
?>
<form method="post" action="<?= $APPLICATION->GetCurPage() ?>">
    <p><?= Loc::getMessage('STEP_ONE_DESCRIPTION') ?></p>
    <label>
        <input type="checkbox" name="delete_tables" value="Y"> <?= Loc::getMessage('STEP_ONE_TITLE_CHECKBOX') ?>
    </label>
    <br><br>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="hidden" name="id" value="laptop.shop">
    <input type="hidden" name="install" value="Y">
    <input type="hidden" name="step" value="2">
    <?= bitrix_sessid_post(); ?>
    <input type="submit" value="<?= Loc::getMessage('STEP_ONE_TITLE_BUTTON') ?>">
</form>