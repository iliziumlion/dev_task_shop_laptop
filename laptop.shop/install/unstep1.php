<form action="<?= $APPLICATION->GetCurPage()?>">
    <?=bitrix_sessid_post()?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID?>">
    <input type="hidden" name="id" value="laptop.shop">
    <input type="hidden" name="uninstall" value="Y">
    <input type="hidden" name="step" value="2">
    <?php CAdminMessage::ShowMessage(GetMessage("MOD_UNINST_WARN"))?>
    <p><?= GetMessage("MOD_UNINST_SAVE")?></p>
    <p><input type="checkbox" name="savedata" id="savedata" value="Y" checked><label for="savedata"><?= GetMessage("MOD_UNINST_SAVE_TABLES")?></label></p>
    <p><input type="checkbox" name="savefiles" id="savefiles" value="Y" checked><label for="savefiles"><?= GetMessage("LAPTOP_UNINSTALL_FILES")?></label></p>
    <input type="submit" name="inst" value="<?= GetMessage("MOD_UNINST_DEL")?>">
</form>