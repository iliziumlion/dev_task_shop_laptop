<?php

namespace Laptop\Shop\Model;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class ManufacturerTable extends Entity\DataManager
{
    public static function getTableName(): string
    {
        return 'laptop_manufacturer';
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
                    'title' => Loc::getMessage('LAPTOP_SHOP_MANUFACTURER_NAME'),
                ]
            ),
            new Entity\ReferenceField(
                'MODELS',
                ModelTable::class,
                ['=this.ID' => 'ref.MANUFACTURER_ID']
            ),
        ];
    }
}