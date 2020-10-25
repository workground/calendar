<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

$arComponentParameters = [
    "GROUPS" => [
        "SETTINGS" => [
            "NAME" => Loc::getMessage('EXAMPLE_CALENDAR_PROP_SETTINGS'),
            "SORT" => 550,
        ],
    ],
    "PARAMETERS" => [
        "DIR_FILES" => [
            "PARENT" => "SETTINGS",
            "NAME" => Loc::getMessage('EXAMPLE_CALENDAR_PROP_DIR_FILES'),
            "TYPE" => "STRING",
            "MULTIPLE" => "N",
            "DEFAULT" => "data",
        ],
        "DEFAULT_MONTH" => [
            "PARENT" => "SETTINGS",
            "NAME" => Loc::getMessage('EXAMPLE_CALENDAR_PROP_DEFAULT_MONTH'),
            "TYPE" => "STRING",
            "MULTIPLE" => "N",
            "DEFAULT" => '={$_REQUEST["ID"]}',
        ],
        "AJAX_MODE" => array(),
    ]
];