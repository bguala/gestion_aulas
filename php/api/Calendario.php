<?php

require_once(toba_dir().'/php/nucleo/componentes/interface/toba_ei_calendario.php');
/*
 * Personalizacion de la clase toba_ei_calendario
 */
class calendario_aulas_comahue extends toba_ei_calendario {
    function ini (){
        $this->_calendario=new cal();
    }
}

class cal extends calendario {
    
    /**
     * Construye las celdas asociadas a los dias de ls semana. Se personalizo con css3.
     */
    function mkWeekDays()
    {
            $out = '';
            if ($this->startOnSun) {
                    if ($this->mostrar_semanas) {

                            $out .="<tr class=\"".$this->cssWeekDay."\"><td>"."Sem"."</td>";
                    }
                    $out.='<td>'.$this->getDayName(0).'</td>';
                    $out.='<td>'.$this->getDayName(1).'</td>';
                    $out.='<td>'.$this->getDayName(2).'</td>';
                    $out.='<td>'.$this->getDayName(3).'</td>';
                    $out.='<td>'.$this->getDayName(4).'</td>';
                    $out.='<td>'.$this->getDayName(5).'</td>';
                    $out.='<td>'.$this->getDayName(6)."</td></tr>\n";
            } else {
                    if ($this->mostrar_semanas) {
                            $out .="<tr class=\"".$this->cssWeekDay."\"><td>".'Sem'.'</td>';
                        //$out .="<tr style=\"".'background-color:rgba(0,51,255,0.75);color:white;'."\"><td>".'Sem'.'</td>';
                    }
                    $out.='<td style='.'background-color:rgba(0,51,255,0.75);color:white;border-collapse:groove;'.'>'.$this->getDayName(1).'</td>';
                    $out.='<td style='.'background-color:rgba(0,51,255,0.75);color:white;border-collapse:groove;'.'>'.$this->getDayName(2).'</td>';
                    $out.='<td style='.'background-color:rgba(0,51,255,0.75);color:white;border-collapse:groove;'.'>'.$this->getDayName(3).'</td>';
                    $out.='<td style='.'background-color:rgba(0,51,255,0.75);color:white;border-collapse:groove;'.'>'.$this->getDayName(4).'</td>';
                    $out.='<td style='.'background-color:rgba(0,51,255,0.75);color:white;border-collapse:groove;'.'>'.$this->getDayName(5).'</td>';
                    $out.='<td style='.'background-color:rgba(0,51,255,0.75);color:white;border-collapse:groove;'.'>'.$this->getDayName(6).'</td>';
                    $out.='<td style='.'background-color:rgba(0,51,255,0.75);color:white;border-collapse:groove;'.'>'.$this->getDayName(0)."</td></tr>\n";
                    $this->firstday=$this->firstday-1;
                    if ($this->firstday<0) {
                            $this->firstday=6;
                    }
            }
            return $out;
    }
    
    /**
     * Construye las celdas asociadas al numero de semana. Se personalizo con css3.
     */
    function mkWeek($date, $objeto_js=null, $eventos=array())
    {
            $week = $this->weekNumber($date);
            $year = $this->mkActiveDate('Y',$date);

            if (!$this->get_weekLinks()) {
                    if ($week == $this->getSelectedWeek() && $year == $this->getSelectedYear()) {
                            $out = "<td class=\"".$this->cssSelecDay."\">".$this->weekNumber($date)."</td>\n";
                    } else {
                            $out = "<td class=\"".$this->cssWeek."\">".$this->weekNumber($date)."</td>\n";
                    }
            } else {
                    if ($this->compare_week($this->weekNumber($date),$this->actyear) == 1) {
                            //$out = "<td class=\"".$this->cssWeekNoSelec."\">".$this->weekNumber($date)."</td>\n";
                            $out = "<td style=\"".'background-color:rgba(0,51,255,0.75);color:white;'."\">".$this->weekNumber($date)."</td>\n";
                    } else {	
                            $evento_js = toba_js::evento('seleccionar_semana', $eventos['seleccionar_semana'], "{$this->weekNumber($date)}||{$this->mkActiveDate('Y',$date)}");
                            $js = "{$objeto_js}.set_evento($evento_js);";

                            if ($week == $this->getSelectedWeek() && $year == $this->getSelectedYear()) {
                                    $out = "<td class=\"".$this->cssSelecDay."\" style='cursor: pointer;cursor:hand;' onclick=\"$js\">".$this->weekNumber($date)."</td>\n";	
                            } else { $out = "<td class=\"".$this->cssWeek."\" style='cursor: pointer;cursor:hand;background-color:rgba(0,51,255,0.75);' onclick=\"$js\">".$this->weekNumber($date)."</td>\n";
                                    //$out = "<td class=\"".$this->cssWeek."\" style='cursor: pointer;cursor:hand;' onclick=\"$js\">".$this->weekNumber($date)."</td>\n";	
                            }
                    }		
            }	
            return $out;
    }
    
    /**
     * Construye las celdas correspondientes a los dias del mes. Se personalizo con css3. La sentencia
     * !$this->get_dayLinks() es false.
     */
    function mkDay($var, $objeto_js=null, $eventos=array())
    {
            if ($var <= 9) {
                    $day = "0$var";
            } else {
                    $day = $var;	
            }
            $eventContent = $this->mkEventContent($var);
            $content = ($this->get_showEvents()) ? $eventContent : '';

            if (is_null($objeto_js)) {
                    $objeto_js = $this->get_id_objeto_js();
            }		

            $evento_js = toba_js::evento('seleccionar_dia', $eventos['seleccionar_dia'], "{$day}||{$this->actmonth}||{$this->actyear}");
            $js = "{$objeto_js}.set_evento($evento_js);";
            $day = $this->mkActiveTime(0,0,1,$this->actmonth,$var,$this->actyear);

            $resalta_hoy = ($this->siempre_resalta_dia_actual || $this->getSelectedDay() < 0);

            if ($this->solo_pasados && $this->compare_date($day) == 1) {
                    //Es una fecha futura y no se permite clickearla
                    $out="<td class=\"".$this->cssSunday."\">".$var.$content.'</td>';		
            } elseif (($this->get_dayLinks()) && ((!$this->get_enableSatSelection() && ($this->getWeekday($var) == 0)) || ((!$this->get_enableSunSelection() && $this->getWeekday($var) == 6)))) {
                    $out="<td class=\"".$this->cssSunday."\">".$var.'</td>';			
            } elseif ($var==$this->getSelectedDay() && $this->actmonth==$this->getSelectedMonth() && $this->actyear==$this->getSelectedYear()) {
                    if (!$this->get_dayLinks()) {
                            $out="<td class=\"".$this->cssSelecDay."\">".$var.$content.'</td>';
                    } else {
                            $out="<td class=\"".$this->cssSelecDay."\"style='cursor: pointer;cursor:hand;background-color:rgba(0,51,255,0.75);color:white;vertical-align:middle;border:inset;border-color:rgba(176,9,109,0.78);' onclick=\"$js\">".$var.$content.'</td>';
                    }
            } elseif ($var==$this->daytoday && $this->actmonth==$this->monthtoday && $this->actyear==$this->yeartoday && $resalta_hoy && $this->getSelectedMonth()==$this->monthtoday && $this->getSelectedWeek()<0) {
                    if (!$this->get_dayLinks()) {
                            $out="<td class=\"".$this->cssToday."\">".$var.$content.'</td>';
                    } else {
                            $out="<td class=\"".$this->cssToday."\"style='cursor: pointer;cursor:hand;background-color:rgba(0,51,255,0.75);color:white;vertical-align:middle;border:inset;border-color:rgba(176,9,109,0.78);' onclick=\"$js\">".$var.$content.'</td>';
                    }
            } elseif ($this->getWeekday($var) == 0 && $this->crSunClass){
                    if (!$this->get_dayLinks()) {
                            $out="<td class=\"".$this->cssSunday."\">".$var.$content.'</td>';
                    } else {
                            $out="<td class=\"".$this->cssSunday."\"style='cursor: pointer;cursor:hand;background-color:rgba(176,9,109,0.78);color:white;font-weight:bold;vertical-align:middle;' onclick=\"$js\">".$var.$content.'</td>';
                    }
            } elseif ($this->getWeekday($var) == 6 && $this->crSatClass) {
                    if (!$this->get_dayLinks()) {
                            $out="<td class=\"".$this->cssSaturday."\">".$var.$content.'</td>';
                    } else { 
                            $out="<td class=\"".$this->cssSaturday."\"style='cursor: pointer;cursor:hand;background-color:rgba(176,9,109,0.78);color:white;font-weight:bold;vertical-align:middle;' onclick=\"$js\">".$var.$content.'</td>';
                    }
            } else {
                    if (!$this->get_dayLinks()) { 
                            $out="<td class=\"".$this->cssMonthDay."\">".$var.$content.'</td>';
                    } else { $out="<td class=\"".$this->cssMonthDay."\"style='cursor: pointer;cursor:hand;background-color:rgba(176,9,109,0.78);color:white;vertical-align: middle;' onclick=\"$js\">".$var.$content.'</td>';
                            //$out="<td class=\"".$this->cssMonthDay."\"style='cursor: pointer;cursor:hand;' onclick=\"$js\">".$var.$content.'</td>';
                    }
            }		

            return $out;
    }
    
    /**
     * El DatePicker es la seccion del calendario que posee el nombre del mes y dos combos, uno para seleccionar 
     * el mes y otro para seleccionar el año.
     */
//    function mkDatePicker($objeto_js, $eventos=array())
//    {
//            $pickerSpan = 8;
//            if ($this->datePicker) {
//                    $evento_js = toba_js::evento('cambiar_mes', $eventos['cambiar_mes']);
//                    $js = "{$objeto_js}.set_evento($evento_js);";
//                    print_r("Entramos en la subclase");
//                    $out="<tr><td class=\"".$this->cssPicker."\" colspan=\"".$pickerSpan."\">\n";
//                    $out.="<select name=\"".$this->monthID."\" id=\"".$this->monthID."\" class=\"".$this->cssPickerMonth."\" onchange=\"$js\">\n";
//                    for ($z=1;$z<=12;$z++) {
//                            if ($z <= 9) {
//                                    $z = "0$z";
//                            }
//                            if ($z==$this->actmonth) {//$this->getMonthName($z)
//                                    $out.="<option value=\"".$z."\" selected=\"selected\" >".(parent::getMonthName($z))."</option>\n";
//                            } else {//$this->getMonthName($z)
//                                    $out.="<option value=\"".$z."\">".(parent::getMonthName($z))."</option>\n";
//                            }
//                    }
//                    $out.="</select>\n";
//                    $out.="<select name=\"".$this->yearID."\" id=\"".$this->yearID."\" class=\"".$this->cssPickerYear."\" onchange=\"$js\">\n";
//                    for ($z=$this->startYear;$z<=$this->endYear;$z++) {
//                            if ($z==$this->actyear) {
//                                    $out.="<option value=\"".$z."\" selected=\"selected\">".$z."</option>\n";
//                            } else {
//                                    $out.="<option value=\"".$z."\">".$z."</option>\n";
//                            }
//                    }
//                    $out.="</select>\n";
//                    $out.="</td></tr>\n";
//            }
//            return $out;
//    }
      
    function mkMonthHead()
    {
            $out = "<div align='center' >";
            $out .= "<table class=\"".$this->cssMonthTable."\" style='background-color:rgba(0,51,255,0.09);'>\n";
            
            return $out;
    }
}

?>

