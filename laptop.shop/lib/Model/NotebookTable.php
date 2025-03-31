<?php

namespace Laptop\Shop\Model;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Laptop\Shop\Relation\NotebookOptionTable;

Loc::loadMessages(__FILE__);

class NotebookTable extends Entity\DataManager
{
    public static function getTableName(): string
    {
        return 'laptop_notebook';
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
                    'title' => Loc::getMessage('LAPTOP_SHOP_NOTEBOOK_NAME'),
                ]
            ),
            new Entity\IntegerField(
                'YEAR',
                [
                    'required' => true,
                    'title' => Loc::getMessage('LAPTOP_SHOP_NOTEBOOK_YEAR'),
                ]
            ),
            new Entity\FloatField(
                'PRICE',
                [
                    'required' => true,
                    'title' => Loc::getMessage('LAPTOP_SHOP_NOTEBOOK_PRICE'),
                ]
            ),
            new Entity\IntegerField(
                'MODEL_ID',
                [
                    'required' => true,
                ]
            ),
            new Entity\ReferenceField(
                'MODEL',
                ModelTable::class,
                ['=this.MODEL_ID' => 'ref.ID']
            ),
            new Entity\ReferenceField(
                'OPTIONS',
                NotebookOptionTable::class,
                ['=this.ID' => 'ref.NOTEBOOK_ID']
            ),
        ];
    }
}