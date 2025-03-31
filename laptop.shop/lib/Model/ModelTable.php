<?php

namespace Laptop\Shop\Model;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class ModelTable extends Entity\DataManager
{
    public static function getTableName(): string
    {
        return 'laptop_model';
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
                    'title' => Loc::getMessage('LAPTOP_SHOP_MODEL_NAME'),
                ]
            ),
            new Entity\IntegerField(
                'MANUFACTURER_ID',
                [
                    'required' => true,
                ]
            ),
            new Entity\ReferenceField(
                'MANUFACTURER',
                ManufacturerTable::class,
                ['=this.MANUFACTURER_ID' => 'ref.ID']
            ),
            new Entity\ReferenceField(
                'NOTEBOOKS',
                NotebookTable::class,
                ['=this.ID' => 'ref.MODEL_ID']
            ),
        ];
    }
}