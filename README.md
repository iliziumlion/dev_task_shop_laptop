# dev_task_shop_laptop

на странице можно использовать

```php
<?php
$APPLICATION->IncludeComponent(
    "ilizium:laptop.shop.complex",
    "",
    [
        "SEF_MODE"          => "Y",
        "SEF_FOLDER"        => "/laptops/",
        "SEF_URL_TEMPLATES" => [
            "manufacturers" => "",
            "models"        => "#BRAND#/",
            "notebooks"     => "#BRAND#/#MODEL#/",
            "detail"        => "detail/#NOTEBOOK#/",
        ],
    ]
); 
?>
```