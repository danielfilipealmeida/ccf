<?php

if (isset($calendarData)) {
//$calendarDays = array("Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb");

$monthData = array();
//print_r($calendarData);
?>
<table class="calendar">
    <tr>
        <td>
            <?php 
            /*
            echo($this->Html->link(
                    '<', 
                    array(
                        'controller'=>'sessoes', 
                        'action' => 'alteraMesCalendario', 
                        $calendarData['previousMonth']['month'],
                        $calendarData['previousMonth']['year']
                    )));
            
             */
            ?>
        </td>
        <td colspan="5"><?=$calendarData['calendarTitle'];?>
        <td>
        <?php 
        /*
            echo($this->Html->link(
                    '>', 
                    array(
                        'controller'=>'sessoes', 
                        'action' => 'alteraMesCalendario', 
                        $calendarData['nextMonth']['month'],
                        $calendarData['nextMonth']['year']
                    )));
         * 
         */
            ?>
        </td>
        </td>
    </tr>
    <tr>
        <?php foreach($calendarData['calendarDays'] as $calendarDay) { ?>
        <td class="calendar_title"><?=$calendarDay;?></td>
        <?php } ?>
        </tr>
        
        <?php 
        $month = date("m", $calendarData['startTimestamp']);
        $year = date("Y", $calendarData['startTimestamp']);
        $count = 0;
        for($week=0;$week<$calendarData['weeksInMonth'];$week++) { ?>
        <tr class='calendarRow'>
            <?php 
            
            for($day=0;$day<7;$day++) { 
                    $dayDisplay="";
                    $overlayContent ="";
                    $dayInMonth = $count-$calendarData['firstDayWeekDay']+1;
                    $class = "";
                    $data = "";
                    if ($dayInMonth>0 && $dayInMonth<=$calendarData['daysInMonth']) {
                        $dayDisplay=$dayInMonth;
                        $class="calendarDay";
                        $dayString = $year."-".$month."-".str_pad($dayDisplay,2,"0",STR_PAD_LEFT);
                        if (isset($calendarData['data'][$dayString])) {
                            foreach($calendarData['data'][$dayString] as $entry) {
                                $record = array();
                                $record['dia'] = $dayDisplay;
                                $record['title'] = $entry['Sessao']['titulo'];
                                $record['date'] = $dayString;
                                $record['hora'] = $entry['Sessao']['hora'];
                                $record['local'] = $entry['Local']['local'];
                                $monthData[] = $record;
                            }
                            //$data = json_encode($todayData);
                            $class="calendarDayWithContent";
                        }
                    }
                    $count = $count+1;
                ?>
                <td class="<?=$class;?>"><?=$dayDisplay?><?=$overlayContent?></td>
            <?php } ?>
        </tr>
        <?php  }   ?>
</table>


<br />
<?php foreach($monthData as $entry) { 
    $smallText = implode(", ", array($entry['local'], $entry['hora']));
?>
<p><?=$entry['dia']?> - <strong><?=$entry['title']?></strong><small> | <?=$smallText?></small></p>
<?php } ?>


<?php } ?>