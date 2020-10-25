<?php

use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;
use \Bitrix\Main\UI\Extension;
use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Engine\Contract\Controllerable;
use \Bitrix\Main\Engine\ActionFilter;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class CalendarCompSimple extends CBitrixComponent implements Controllerable
{
    /**
     * Подключаем bootstrap4
     */
    private function loadAssets()
    {
        CJSCore::Init(array('jquery2'));
        Extension::load('ui.bootstrap4');
    }

    public function configureActions()
    {
        return [
            'addTask' => [
                'prefilters' => []
            ],
            'deleteTask' => [
                'prefilters' => []
            ]
        ];
    }

    public function deleteTaskAction($date, $key)
    {
        $arData = $this->getSavedData();
        if (!empty($arData[$date][$key]))
            unset($arData[$date][$key]);
        if (empty($arData[$date]))
            unset($arData[$date]);
        $res = $this->saveData($arData);
        return array(
            "res" => $res,
            "date" => $date,
            "key" => $key
        );
    }

    public function addTaskAction($date, $text)
    {
        $arData = $this->getSavedData();
        $dateObj = DateTime::createFromFormat('Y-m-d', $date);
        $arData[$dateObj->format("d-m-Y")][] = $text;
        $res = $this->saveData($arData);
        return array(
            "res" => $res,
            "date" => $dateObj->format("d-m-Y"),
            "text" => $text
        );
    }

    public function getSavedData()
    {
        $result = array();
        $file = __DIR__ . "/" . $this->arParams["DATA_FILE"];
        if (file_exists($file))
            $result = unserialize(file_get_contents($file));
        return $result;
    }

    public function saveData($arData)
    {
        $file = __DIR__ . "/" . $this->arParams["DATA_FILE"];
        $res = file_put_contents($file, serialize($arData)) !== false ? "ok" : "error";
        return $res;
    }

    public function onPrepareComponentParams($arParams)
    {

        if (!empty($arParams["DEFAULT_MONTH"])) {
            $testDate = preg_replace('/[^0-9\.]/u', '', trim($arParams["DEFAULT_MONTH"]));
            $testDateAr = explode('.', $testDate);
            if (!checkdate($testDateAr[0], 1, $testDateAr[1])) {
                $arParams["DEFAULT_MONTH"] = "";
            }
        }
        if (empty($arParams["DEFAULT_MONTH"]))
            $arParams["DEFAULT_MONTH"] = date("m.Y");
        if (empty($arParams["DATA_FILE"]))
            $arParams["DATA_FILE"] = "data";

        $arParams["GET_PARAM"] = "month";
        return $arParams;
    }

    private function getDate($strDate)
    {
        return DateTime::createFromFormat('d.m.Y', "01.$strDate");
    }

    private function getLinkMonth($type, $strDate)
    {
        global $APPLICATION;
        $getParamName = $this->arParams["GET_PARAM"];
        $date = $this->getDate($strDate);
        $date->modify("$type month");
        $strDate = $date->format('m.Y');
        $link = $APPLICATION->GetCurPageParam("$getParamName=$strDate", array($getParamName));
        return $link;
    }

    private function getCurMonth($strDate)
    {
        $date = $this->getDate($strDate);
        $numMonth = $date->format("m");
        $numYear = $date->format("Y");
        return Loc::getMessage("MONTH_$numMonth") . " " . $numYear;
    }

    private function getCurentDate($strDate)
    {
        $date = $this->getDate($strDate);
        return $date->format("Y-m-d");
    }

    private function getCalendar($strDate)
    {
        $currentDate = $this->getDate($strDate);
        $dateStart = $this->getDate($strDate);
        $dateStart->modify("first day of this month");
        $numDay = $dateStart->format("N");
        if ($numDay != 1)
            $dateStart->modify("previous monday");

        $dateEnd = $this->getDate($strDate);
        $dateEnd->modify("last day of this month");
        $numDay = $dateEnd->format("N");
        if ($numDay != 7)
            $dateEnd->modify("next sunday");

        $interval = $dateStart->diff($dateEnd);
        $arListDates = array();
        $j = 0;
        for ($i = 0; $i <= $interval->days; $i++) {
            $num = $dateStart->format("N");
            if ($num == 1) $j++;
            $arListDates[$j][] = array(
                "NUM" => $num,
                "DATE" => $dateStart->format("d.m.Y"),
                "CUR" => $dateStart->format("m") == $currentDate->format("m")
            );
            $dateStart->modify("+1 day");
        }
        return $arListDates;
    }

    public function executeComponent()
    {
        $this->loadAssets();
        $curDate = $this->arParams["DEFAULT_MONTH"];
        $this->arResult['NEXT_MONTH'] = $this->getLinkMonth("next", $curDate);
        $this->arResult['PREVIOUS_MONTH'] = $this->getLinkMonth("previous", $curDate);
        $this->arResult['CUR_MONTH'] = $this->getCurMonth($curDate);
        $this->arResult['AR_LIST_DATES'] = $this->getCalendar($curDate);
        $this->arResult["DATE"] = $this->getCurentDate($curDate);
        $this->arResult["DATA"] = $this->getSavedData();

        $this->includeComponentTemplate();
    }
}