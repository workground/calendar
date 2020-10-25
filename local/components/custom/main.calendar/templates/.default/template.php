<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="container main-calendar">
    <div class="row">
        <div class="col-sm"></div>
        <div class="col-sm">
            <div class="slider-container">
                <a href="<?= $arResult['PREVIOUS_MONTH'] ?>" class="btn btn-info"><</a>
                <div class="month-label"><?= $arResult['CUR_MONTH'] ?></div>
                <a href="<?= $arResult['NEXT_MONTH'] ?>" class="btn btn-info">></a>
            </div>
        </div>
        <div class="col-sm">
            <form action="" method="post" onsubmit="calendar.addTask(event);">
                <input id="date_input" type="date" required="required" value="<?= $arResult["DATE"] ?>">
                <input id="task_input" type="text" required="required" value="">
                <input type="submit" value="Отправить">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-bordered calendar-table">
                <thead>
                <tr>
                    <th scope="col"><?=GetMessage("MONDAY")?></th>
                    <th scope="col"><?=GetMessage("TUESDAY")?></th>
                    <th scope="col"><?=GetMessage("WEDNESDAY")?></th>
                    <th scope="col"><?=GetMessage("THURSDAY")?></th>
                    <th scope="col"><?=GetMessage("FRIDAY")?></th>
                    <th scope="col"><?=GetMessage("SATURDAY")?></th>
                    <th scope="col"><?=GetMessage("SUNDAY")?></th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($arResult['AR_LIST_DATES'] as $arWeek): ?>
                    <tr>
                        <? foreach ($arWeek as $day): ?>
                            <? $dateLink = str_replace(".", "-", $day["DATE"]); ?>
                            <td class="cell_<?= $dateLink ?>">
                                <? if ($day["CUR"]): ?>
                                    <div class="label-date"><?= $day["DATE"] ?></div>
                                    <? if (!empty($arResult['DATA'][$dateLink])): ?>
                                        <? foreach ($arResult['DATA'][$dateLink] as $key => $task): ?>
                                            <? if (!empty($task)): ?>
                                                <div class="label-task"><?= $task ?>
                                                    <span class="del"
                                                          onclick="calendar.deleteTask(this, '<?= $dateLink ?>', '<?= $key ?>');">x</span>
                                                </div>
                                            <? endif; ?>
                                        <? endforeach; ?>
                                    <? endif; ?>
                                <? endif; ?>
                            </td>
                        <? endforeach; ?>
                    </tr>
                <? endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    calendar.init(<?=CUtil::PhpToJSObject(array(
        "componentName" => $this->__component->__name,
        "SITE_ID" => SITE_ID,
        "DIR" => $arParams["DIR_FILES"]
    ))?>);
</script>