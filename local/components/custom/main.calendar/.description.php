<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

$arComponentDescription = [
    "NAME" => Loc::getMessage("EXAMPLE_CALENDAR_COMPONENT"),
    "DESCRIPTION" => Loc::getMessage("EXAMPLE_CALENDAR_COMPONENT_DESCRIPTION"),
    "COMPLEX" => "N",
    "PATH" => [
        "ID" => "local",
        "NAME" => Loc::getMessage("EXAMPLE_CALENDAR_COMPONENT_PATH_NAME"),
    ],
];
?>