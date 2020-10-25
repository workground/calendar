<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Календарь дел");


$APPLICATION->includeComponent(
    'custom:main.calendar',
    '',
    array(
        'DEFAULT_MONTH' => $_REQUEST["month"],
        'DATA_FILE' => 'data',
        'AJAX_MODE' => 'Y',
        'AJAX_OPTION_JUMP' => 'N',
        'AJAX_OPTION_SHADOW' => 'N',
    )
);



require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
