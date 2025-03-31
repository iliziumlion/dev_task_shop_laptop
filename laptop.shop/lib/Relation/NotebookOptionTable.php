<?php

namespace Laptop\Shop\Relation;

use Bitrix\Main\Entity;
use Laptop\Shop\Model\OptionTable;
use Laptop\Shop\Model\NotebookTable;

class NotebookOptionTable extends Entity\DataManager
{
    public static function getTableName(): string
    {
        return 'laptop_notebook_option';
    }

    public static function getMap(): array
    {
        return [
            new Entity\IntegerField('NOTEBOOK_ID', ['primary' => true]),
            new Entity\IntegerField('OPTION_ID', ['primary' => true]),
            new Entity\ReferenceField(
                'NOTEBOOK',
                NotebookTable::class,
                ['=this.NOTEBOOK_ID' => 'ref.ID']
            ),
            new Entity\ReferenceField(
                'OPTION',
                OptionTable::class,
                ['=this.OPTION_ID' => 'ref.ID']
            ),
        ];
    }
}