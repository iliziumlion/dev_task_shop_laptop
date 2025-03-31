<?php

namespace Laptop\Shop\Model;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class OptionTable extends Entity\DataManager
{
    public static function getTableName(): string
    {
        return 'laptop_option';
    }

    public static function getMap(): array
    {
        return [
            new Entity\IntegerField(
                'ID',
                [
                    'primary' => true,
                    'autocomplete' => true,
                ]
            ),
            new Entity\StringField(
                'NAME',
                [
                    'required' => true,
                    'title' => Loc::getMessage('LAPTOP_SHOP_OPTION_NAME'),
                ]
            ),
        ];
    }
}