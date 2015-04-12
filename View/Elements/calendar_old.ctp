<?php

   //debug($calendarData);

if (isset($calendarData)) {
//$calendarDays = array("Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb");


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
                        //debug($dayString);
                        
                        if (isset($calendarData['data'][$dayString])) {
                            $todayData = array();
                            foreach($calendarData['data'][$dayString] as $entry) {
                                $record = array();
                                $record['title'] = $entry['Sessao']['titulo'];
                                $record['date'] = $dayString;
                            
                                $todayData[] = $record;
                            }
                            
                            
                            $data = json_encode($todayData);
                            //debug($todayData);
                            //debug($calendarData['data'][$dayString]);
                            $class="calendarDayWithContent";
                            /*
                            $overlayContent = "<div class='calendarOverlay'>";
                            foreach($todayData as $sessao) {
                                //debug($sessao);
                                $overlayContent=$overlayContent."<p>".$sessao['Sessao']['titulo']."</p>";
                            }
                            $overlayContent=$overlayContent."</div>";
                             * 
                             */
                        }
                        
                    }
                    $count = $count+1;
                ?>
                <td class="<?=$class;?>" data='<?=$data;?>'><?=$dayDisplay?><?=$overlayContent?></td>
            <?php } ?>
        </tr>
        <?php
        }
        
        
        ?>
        
    
</table>
<div id="calendarLegend">Legenda</div>

<?php

$this->Js->get('.calendarDayWithContent')->event('mouseenter', 
        'var position = $(this).position();
        var data = JSON.parse($(this).attr("data"));
        console.log("hre2");
        
        var top;
        var left;
        
        top = position.top+$(this).outerHeight();
        //top = 0;
        left = position.left-$("#calendarLegend").outerWidth() + $(this).outerWidth();
        $("#calendarLegend").css("left", left);
        $("#calendarLegend").css("top", top);
        
        //var calendarY = $(".calendar").offset().top+position.top+$(this).outerHeight();
        //$("#calendarLegend").css("top", calendarY)
        
        var html = "";
        html=html+"<p class=\'calendarLegendData\'>"+data[0].date+"</p>";
        for(f=0;f<data.length;f++) {
            //html=html+"<p class\'calendarLegendData\'>"+data[f].date+"</p>";
            html=html+"<p class=\'calendarLegendTitle\'>"+data[f].title+"</p>";
        }
        $("#calendarLegend").html(html);
        $("#calendarLegend").fadeIn();');
$this->Js->get('.calendarDayWithContent')->event('mouseleave','$("#calendarLegend").fadeOut();');
}
?>