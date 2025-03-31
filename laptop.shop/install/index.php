<?php

use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;

if (class_exists('laptop_shop')) {
    return;
}

Loc::loadMessages(__FILE__);

class laptop_shop extends CModule
{
    public $MODULE_ID = 'laptop.shop';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_CSS;
    public $MODULE_GROUP_RIGHTS = 'Y';
    public $errors;

    public function __construct()
    {
        $arModuleVersion = [];
        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_ID = 'laptop.shop';
        $this->MODULE_NAME = Loc::getMessage('LAPTOP_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('LAPTOP_MODULE_DESCRIPTION');
        $this->PARTNER_NAME = Loc::getMessage('LAPTOP_MODULE_PARTNER_NAME');
    }

    public function DoInstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION, $step;
        $step = (int)$step;
        if ($step < 2) {
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('LAPTOP_INSTALL_TITLE'),
                $DOCUMENT_ROOT . "/local/modules/" . $this->MODULE_ID . "/install/step1.php"
            );
        }
        if ($step == 2) {
            RegisterModule($this->MODULE_ID);
            Loader::includeModule($this->MODULE_ID);
            $this->InstallFiles();
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('LAPTOP_INSTALL_TITLE'),
                $DOCUMENT_ROOT . "/local/modules/" . $this->MODULE_ID . "/install/step2.php"
            );
        }

        return true;
    }

    public function DoUninstall()
    {
        global $APPLICATION;

        ModuleManager::UnRegisterModule($this->MODULE_ID);

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage('LAPTOP_UNINSTALL_TITLE'),
            __DIR__ . '/unstep1.php'
        );

        global $APPLICATION, $DOCUMENT_ROOT, $step;
        $step = (int)$step;

        if ($step < 2) {
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('LAPTOP_UNINSTALL_TITLE'),
                $DOCUMENT_ROOT . "/local/modules/" . $this->MODULE_ID . "/install/unstep1.php"
            );
        }
        if ($step == 2) {
            $context = \Bitrix\Main\Application::getInstance()->getContext();
            $request = $context->getRequest();
            UnRegisterModule($this->MODULE_ID);
            if (empty($request->getValues()['savedata'])) {
                $this->UnInstallDB();
            }
            if (empty($request->getValues()['savefiles'])) {
                $this->UnInstallFiles();
            }
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('LAPTOP_UNINSTALL_TITLE'),
                $DOCUMENT_ROOT . "/local/modules/" . $this->MODULE_ID . "/install/unstep2.php"
            );
        }


        return true;
    }

    function InstallDB()
    {
        return true;
    }

    function UnInstallDB()
    {
        return true;
    }

    function InstallFiles()
    {
        CopyDirFiles(
            $_SERVER["DOCUMENT_ROOT"] . "/local/modules/" . $this->MODULE_ID . "/install/components/",
            $_SERVER["DOCUMENT_ROOT"] . "/local/components",
            true,
            true
        );
        return true;
    }

    function UnInstallFiles()
    {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/dev.txt', print_r('test', true));
        DeleteDirFilesEx("/local/components/ilizium/laptop.shop.complex");
        DeleteDirFilesEx("/local/components/ilizium/laptop.shop.detail");
        DeleteDirFilesEx("/local/components/ilizium/laptop.shop.list");

        return true;
    }
}