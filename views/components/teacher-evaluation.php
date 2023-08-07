<?php 
    if($estudiantes) {
?>
<div class="tab">
  <button id="stab-1" class="tablinks <?php if(base64_decode($_GET['page']) == 'tab-1') {echo 'active';} ?>" onclick="openTab(event, 'tab-1')">General</button>
  <button id="stab-2" class="tablinks <?php if(base64_decode($_GET['page']) == 'tab-2') {echo 'active';} ?>" onclick="openTab(event, 'tab-2')">Cotidiano</button>
  <button id="stab-3" class="tablinks <?php if(base64_decode($_GET['page']) == 'tab-3') {echo 'active';} ?>" onclick="openTab(event, 'tab-3')">Examenes</button>
  <button id="stab-4" class="tablinks <?php if(base64_decode($_GET['page']) == 'tab-4') {echo 'active';} ?>" onclick="openTab(event, 'tab-4')">Tareas</button>
  <button id="stab-5" class="tablinks <?php if(base64_decode($_GET['page']) == 'tab-5') {echo 'active';} ?>" onclick="openTab(event, 'tab-5')">Asistencia</button>
  <button id="stab-6" class="tablinks <?php if(base64_decode($_GET['page']) == 'tab-6') {echo 'active';} ?>" onclick="openTab(event, 'tab-6')">Proyecto</button>
  <button id="stab-7" class="tablinks <?php if(base64_decode($_GET['page']) == 'tab-7') {echo 'active';} ?>" onclick="openTab(event, 'tab-7')">Comentarios</button>
</div>
 
<div class="teacher-evaluation">
    <div id="tab-1" class="tabcontent <?php if(base64_decode($_GET['page']) == 'tab-1') {echo 'active';} ?>">
        <div class="<?php if(base64_decode($_GET['periodo']) != '1') {echo 'hidden';} ?>">
                    
            <div style="overflow-x: auto !important;">
                    <table class="schedule-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Cotidiano</th>
                                    <th>Exam #1</th>
                                    <th>Exam #2</th>
                                    <th>Tareas</th>
                                    <th>Asistencia</th>
                                    <th>Proyecto</th>
                                    <th>Total</th>
                                    <th>Reporte</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                                $et = 0;
                                foreach ($estudiantes as $estudiante) {
                                    $total = 0;
                                    ?>
                                <tr>
                                    <td colspan="1"><?php echo $estudiante->nombre;?> <?php echo $estudiante->apellido; ?></td>
                                   
                                   
                                        <td style="text-align: center;" class="input-exam-value"><?php $totalCotidiano = 0;
                                                $totalIndicadores = 0;
                                                $TotalPuntos = 0;
                                                foreach ($cotidiano as $cotidi) {
                                                    if($cotidi->periodo == '1') {
                                                        if($cotidi->totalIndicadores) {
                                                            $totalCotidiano = $cotidi->totalCotidiano;
                                                            $totalIndicadores = $cotidi->totalIndicadores;
                                                            $TotalPuntos = $cotidi->totalIndicadores * 10;
                                                            $totalPuntosObtenidos = 0;
                                                            foreach ($evaluacion as $evalua) {
                                                                if ($evalua->periodo == '1' && $estudiante->id == $evalua->estudiante_id) {
                                                                    $totalPuntosObtenidos = $totalPuntosObtenidos+$evalua->valor;
                                                                }
                                                            }   
                                                            $proyectoNota = ($totalPuntosObtenidos*$TotalPuntos)/$TotalPuntos;
                                                            $porcentaje = $totalCotidiano / $TotalPuntos;
                                                            $tareasPorcentaje = $proyectoNota * $porcentaje;
                                                            //$resultado = Min(number_format( intval($totalPuntosObtenidos) / intval($TotalPuntos) * 100, 2 ), $totalCotidiano);
                                                            
                                                            $total = $total+ number_format($tareasPorcentaje,2);
                                                            echo number_format($tareasPorcentaje,2);
                                                            break;
                                                        }
                                                        
                                                    }
                                                    
                                        } ?></td>
                                    


                                    <td colspan="1"
                                        style="text-align: center;"
                                        class="input-exam-value"><?php foreach ($examenes as $examen) {
                                                    if ($examen->estudiante_id == $estudiante->id && $examen->periodo == '1' && $examen->indicador == '1') {
                                                        $total = $total+ $examen->valor;
                                                        echo $examen->valor;
                                                        
                                                    }
                                                    # code...
                                                } ?> 
                                            
                                    </td>
                                    <td colspan="1"
                                        
                                            style="text-align: center;"
                                            class="input-exam-value" 
                                            ><?php foreach ($examenes as $examen) {
                                                    if ($examen->estudiante_id == $estudiante->id && $examen->periodo == '1' && $examen->indicador == '2') {
                                                        $total = $total+ $examen->valor;
                                                        echo $examen->valor;
                                                    }
                                                    # code...
                                                } ?>
                                    </td>
                                    </td>
                                    
                                    <td colspan="1" class="input-tarea-value" style="text-align: center;"<?php 
                                    $totalt = 0;
                                    foreach($tareas as $tarea) {
                                        
                                        if($tarea->periodo == '1') {
                                            foreach ($tareas_evaluacion as $tarea_evaluacion) {
                                                if ($tarea_evaluacion->estudiante == $estudiante->id && $tarea_evaluacion->periodo == '1' && $tarea_evaluacion->indicador == $tarea->id) {
                                                        $totalt = $totalt + $tarea_evaluacion->tareasPorcentaje;
                                                        
                                              
                                            }
                                        } }
                                    } 
                                    $total = $total + number_format($totalt,2);?>
                                     ><?php echo $totalt ?? '0'; ?>
                                    </td>








                                    <td colspan="1"
                                        <?php foreach ($asistencia as $asist) {
                                    
                                            if($asist->periodo == '1') {
                                                if($asist->totalAsistencia) {
                                                    $totalAsistencia = $asist->totalAsistencia;
                                                    $totalIndicadores = $asist->totalIndicadores;
                                                    $TotalPuntos = $asist->totalIndicadores * 2;
                                                    break;
                                                }
                                            }
                                        } 
                                    
                                    
                                        $totalPuntosObtenidos = 0;
                                        $asistenciaPorcentaje = 0;
                                        
                                        
                                        foreach ($asistencia_evaluacion as $asist) {
                                            if ($asist->periodo == '1' && $estudiante->id == $asist->estudiante_id) { 
                                                $totalPuntosObtenidos = $totalPuntosObtenidos+$asist->valor;
                                                $encontrado = true;
                                            } 
                                        }
                                        
                                    
                                        if($encontrado) { 
                                            $asistenciaNota = ($totalPuntosObtenidos*$TotalPuntos)/$TotalPuntos;
                                            $porcentaje = $totalAsistencia / $TotalPuntos;
                                            $asistenciaPorcentaje = $asistenciaNota * $porcentaje;
                                            $total = $total + $asistenciaPorcentaje;
                                            //echo $totalPuntosObtenidos;
                                            ?>
                                               style="text-align: center;width: 4.5rem !important;"
                                                    ><?php echo number_format($asistenciaPorcentaje,2); ?>
                                                   
                                        <?php } ?>
                                    </td>
                                    <td colspan="1"
                                        
                                        <?php $encontrado = false;
                                        foreach($proyectos as $proyecto) {
                                            if($proyecto->periodo == '1') {
                                                $proyecto_evaluacion_total = 0;
                                                        foreach ($proyecto_evaluaciones as $proyecto_evaluacion) { 
                                                            if($proyecto_evaluacion->estudiante == $estudiante->id  && $proyecto_evaluacion->proyecto == $proyecto->id) { 
                                                                $proyecto_evaluacion_total = $proyecto_evaluacion_total + $proyecto_evaluacion->valor;
                                                            }
                                                        }
                                                        foreach ($proyecto_observaciones as $proyecto_observacion) { 
                                                            if($proyecto_observacion->estudiante == $estudiante->id  && $proyecto_observacion->proyecto == $proyecto->id) { 
                                                                        $proyecto_evaluacion_puntos_total = $proyecto->indicadores * 5; 
                                                                        $total = $total + number_format(($proyecto_evaluacion_total / $proyecto_evaluacion_puntos_total) * $proyecto->porcentajeTotal, 2);
                                                                        $encontrado = true;?>
                                                                        
                                                                            style="text-align: center;width: 4.5rem !important;"
                                                                            class="input-tarea-value" 
                                                                            ><?php echo number_format(($proyecto_evaluacion_total / $proyecto_evaluacion_puntos_total) * $proyecto->porcentajeTotal, 2);?></td>
                                                        <?php }
                                                        }
                                                        
                                            }
                                        } ?>
                                        
                                      <?php if($encontrado == false) { 
                                        echo "style='text-align: center;width: 4.5rem !important;' class='input-tarea-value'>0"
                                        ?>      </td>
                                       <?php }
                                        
                                        ?>
                                    <td colspan="1"><?php echo $total ?? '0'; ?></td>
                                    <td>
                                        
                                        <form method="POST" action="/create-evaluation-report?<?php echo $_SERVER['QUERY_STRING'];?>">
                                            <input type="hidden" value="<?php echo $estudiante->id ?? '' ?>" name="estudiante">
                                            <button class="btn-report" type="submit"><img src="/build/img/report.svg" width="16px" class="btn-student-ico" alt="Icono"></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php 
                            $et++;
                            } ?>
                            </tbody>
                        </table>
            </div>
        </div>
        


        <div class="<?php if(base64_decode($_GET['periodo']) != '2') {echo 'hidden';} ?>">
                    
                    <div style="overflow-x: auto !important;">
                            <table class="schedule-table">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            
                                            <th>Cotidiano</th>
                                            <th>Exam #1</th>
                                            <th>Exam #2</th>
                                            <th>Tareas</th>
                                            <th>Asistencia</th>
                                            <th>Proyecto</th>
                                            <th>Total</th>
                                            <th>Reporte</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php 
                                
                                $et = 0;
                                foreach ($estudiantes as $estudiante) {
                                    $total = 0;
                                    ?>
                                <tr>
                                    <td colspan="1"><?php echo $estudiante->nombre;?> <?php echo $estudiante->apellido; ?></td>
                                   
                                   
                                        <td style="text-align: center;" class="input-exam-value"><?php $totalCotidiano = 0;
                                                $totalIndicadores = 0;
                                                $TotalPuntos = 0;
                                                foreach ($cotidiano as $cotidi) {
                                                    if($cotidi->periodo == '2') {
                                                        if($cotidi->totalIndicadores) {
                                                            $totalCotidiano = $cotidi->totalCotidiano;
                                                            $totalIndicadores = $cotidi->totalIndicadores;
                                                            $TotalPuntos = $cotidi->totalIndicadores * 10;
                                                            $totalPuntosObtenidos = 0;
                                                            foreach ($evaluacion as $evalua) {
                                                                if ($evalua->periodo == '2' && $estudiante->id == $evalua->estudiante_id) {
                                                                    $totalPuntosObtenidos = $totalPuntosObtenidos+$evalua->valor;
                                                                }
                                                            }   
                                                            $proyectoNota = ($totalPuntosObtenidos*$TotalPuntos)/$TotalPuntos;
                                                            $porcentaje = $totalCotidiano / $TotalPuntos;
                                                            $tareasPorcentaje = $proyectoNota * $porcentaje;
                                                            //$resultado = Min(number_format( intval($totalPuntosObtenidos) / intval($TotalPuntos) * 100, 2 ), $totalCotidiano);
                                                            
                                                            $total = $total+ number_format($tareasPorcentaje,2);
                                                            echo number_format($tareasPorcentaje,2);
                                                            break;
                                                        }
                                                        
                                                    }
                                                    
                                        } ?></td>
                                    


                                    <td colspan="1"
                                        style="text-align: center;"
                                        class="input-exam-value"><?php foreach ($examenes as $examen) {
                                                    if ($examen->estudiante_id == $estudiante->id && $examen->periodo == '2' && $examen->indicador == '1') {
                                                        $total = $total+ $examen->valor;
                                                        echo $examen->valor;
                                                        
                                                    }
                                                    # code...
                                                } ?> 
                                            
                                    </td>
                                    <td colspan="1"
                                        
                                            style="text-align: center;"
                                            class="input-exam-value" 
                                            ><?php foreach ($examenes as $examen) {
                                                    if ($examen->estudiante_id == $estudiante->id && $examen->periodo == '2' && $examen->indicador == '2') {
                                                        $total = $total+ $examen->valor;
                                                        echo $examen->valor;
                                                    }
                                                    # code...
                                                } ?>
                                    </td>
                                    </td>
                                    
                                    <td colspan="1" class="input-tarea-value" style="text-align: center;"<?php 
                                    $totalt = 0;
                                    foreach($tareas as $tarea) {
                                        
                                        if($tarea->periodo == '2') {
                                            foreach ($tareas_evaluacion as $tarea_evaluacion) {
                                                if ($tarea_evaluacion->estudiante == $estudiante->id && $tarea_evaluacion->periodo == '2' && $tarea_evaluacion->indicador == $tarea->id) {
                                                        $totalt = $totalt + $tarea_evaluacion->tareasPorcentaje;
                                                        
                                              
                                            }
                                        } }
                                    } 
                                    $total = $total + number_format($totalt,2);?>
                                     ><?php echo $totalt ?? '0'; ?>
                                    </td>








                                    <td colspan="1"
                                        <?php foreach ($asistencia as $asist) {
                                    
                                            if($asist->periodo == '2') {
                                                if($asist->totalAsistencia) {
                                                    $totalAsistencia = $asist->totalAsistencia;
                                                    $totalIndicadores = $asist->totalIndicadores;
                                                    $TotalPuntos = $asist->totalIndicadores * 2;
                                                    break;
                                                }
                                            }
                                        } 
                                    
                                    
                                        $totalPuntosObtenidos = 0;
                                        $asistenciaPorcentaje = 0;
                                        
                                        
                                        foreach ($asistencia_evaluacion as $asist) {
                                            if ($asist->periodo == '2' && $estudiante->id == $asist->estudiante_id) { 
                                                $totalPuntosObtenidos = $totalPuntosObtenidos+$asist->valor;
                                                $encontrado = true;
                                            } 
                                        }
                                        
                                    
                                        if($encontrado) { 
                                            $asistenciaNota = ($totalPuntosObtenidos*$TotalPuntos)/$TotalPuntos;
                                            $porcentaje = $totalAsistencia / $TotalPuntos;
                                            $asistenciaPorcentaje = $asistenciaNota * $porcentaje;
                                            $total = $total + $asistenciaPorcentaje;
                                            //echo $totalPuntosObtenidos;
                                            ?>
                                               style="text-align: center;width: 4.5rem !important;"
                                                    ><?php echo number_format($asistenciaPorcentaje,2); ?>
                                                   
                                        <?php } ?>
                                    </td>
                                    <td colspan="1"
                                        
                                        <?php $encontrado = false;
                                        foreach($proyectos as $proyecto) {
                                            if($proyecto->periodo == '2') {
                                                $proyecto_evaluacion_total = 0;
                                                        foreach ($proyecto_evaluaciones as $proyecto_evaluacion) { 
                                                            if($proyecto_evaluacion->estudiante == $estudiante->id  && $proyecto_evaluacion->proyecto == $proyecto->id) { 
                                                                $proyecto_evaluacion_total = $proyecto_evaluacion_total + $proyecto_evaluacion->valor;
                                                            }
                                                        }
                                                        foreach ($proyecto_observaciones as $proyecto_observacion) { 
                                                            if($proyecto_observacion->estudiante == $estudiante->id  && $proyecto_observacion->proyecto == $proyecto->id) { 
                                                                        $proyecto_evaluacion_puntos_total = $proyecto->indicadores * 5; 
                                                                        $total = $total + number_format(($proyecto_evaluacion_total / $proyecto_evaluacion_puntos_total) * $proyecto->porcentajeTotal, 2);
                                                                        $encontrado = true;?>
                                                                        
                                                                            style="text-align: center;width: 4.5rem !important;"
                                                                            class="input-tarea-value" 
                                                                            ><?php echo number_format(($proyecto_evaluacion_total / $proyecto_evaluacion_puntos_total) * $proyecto->porcentajeTotal, 2);?></td>
                                                        <?php }
                                                        }
                                                        
                                            }
                                        } ?>
                                        
                                      <?php if($encontrado == false) { 
                                        echo "style='text-align: center;width: 4.5rem !important;' class='input-tarea-value'>0"
                                        ?>      </td>
                                       <?php }
                                        
                                        ?>
                                    <td colspan="1"><?php echo $total ?? '0'; ?></td>
                                    <td>
                                        
                                        <form method="POST" action="/create-evaluation-report?<?php echo $_SERVER['QUERY_STRING'];?>">
                                            <input type="hidden" value="<?php echo $estudiante->id ?? '' ?>" name="estudiante">
                                            <button class="btn-report" type="submit"><img src="/build/img/report.svg" width="16px" class="btn-student-ico" alt="Icono"></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php 
                            $et++;
                            } ?>
                            </tbody>
                                </table>
                    </div>
                </div>


        </div>
                  
    </div>











<!-- COTIDIANO -->
    <div id="tab-2" class="tabcontent <?php if(base64_decode($_GET['page']) == 'tab-2') {echo 'active';} ?>">
        <form method="POST" action="" class="form form-cotidiano <?php if(base64_decode($_GET['periodo']) != '1') {echo 'hidden';} ?>">
            <input type="hidden" value="c1" name="form">
                <fieldset class="fset">





            <legend>Primer Semestre</legend>
            <input id="indCount" type="hidden" name="countInd" 
            value="<?php foreach ($cotidiano as $cotidi) {
                $encontrado = false;
                if($cotidi->periodo == '1') {
                    if($cotidi->totalIndicadores) {
                        echo $cotidi->totalIndicadores;
                        $encontrado = true;
                        break;
                    }
                }
            }
            
                if(!$encontrado) {
                    echo '1';
                } ?>">
                <?php $totalCotidiano = 0; ?>
            <input id="" type="hidden" name="modulo" value="<?php echo $modulo->id;?>">
                <div class="slot teacher-input-container">
                <label for="totalCotidiano">Valor Total</label>
                    <input 
                        type="number" 
                        id="totalCotidiano" 
                        placeholder="Agregue un porcentaje en números" 
                        name="totalCotidiano"
                        value="<?php foreach ($cotidiano as $cotidi) {
                        $encontrado = false;
                        
                        if($cotidi->periodo == '1') {
                            if($cotidi->totalCotidiano) {
                                echo $cotidi->totalCotidiano;
                                $totalCotidiano = $cotidi->totalCotidiano;
                                $encontrado = true;
                                break;
                            }
                        }
                        }
                        if(!$encontrado) {
                            echo '1';
                        } ?>"
                        class="number-input"
                        min="1"
                        max="99">
                    </div>
                    <div class="div-add-ind">
                            <label for="">Indicadores</label>
                            <button class="save-button circle-button" onclick="addIndicador(<?php echo $modulo->id?>,1,1,0); event.preventDefault()"> - </button><button class="save-button circle-button" onclick="addIndicador(<?php echo $modulo->id?>,0,1,0); event.preventDefault()"> + </button>
                    </div>
                    <div style="overflow-x: auto !important;">
                    <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Porcentaje</th>
                            <?php $encontrado = false;
                            $totalCotidiano = 0;
                            foreach ($cotidiano as $cotidi) {
                                if($cotidi->periodo == '1') {
                                    if($cotidi->totalCotidiano) {
                                        for ($i = 0; $i < $cotidi->totalIndicadores; $i++) { ?>
                                            <th id="indicador-header"><?php echo $i+1; ?></th>
                                            
                                            <?php
                                                $encontrado = true;
                                                $totalCotidiano = $cotidi->totalCotidiano;
                                                $totalIndicadores = $cotidi->totalIndicadores;
                                                $TotalPuntos = $cotidi->totalIndicadores * 10;
                                        }
                                    } else { ?>
                                        <th id="indicador-header-1">1</th>
                                        
                                        <?php 
                                        $encontrado = true;
                                   
                                        }
                                    }
                            } 
                            if($encontrado == false) {
                                echo '<th id="indicador-header-1">1</th>';
                            } 
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $t = 0;
                        foreach ($estudiantes as $estudiante) {?>
                        <tr>
                            <td colspan="1"><?php echo $estudiante->nombre;?> <?php echo $estudiante->apellido; ?></td>
                            
                            
                            
                            
                            <?php 
                             
                                $encontrado = false;
                            
                                $totalPuntosObtenidos = 0;
                                foreach ($evaluacion as $evalua) {
                                    if ($evalua->periodo == '1' && $estudiante->id == $evalua->estudiante_id) {
                                        
                                        $encontrado = true;
                                        $totalPuntosObtenidos = $totalPuntosObtenidos+$evalua->valor;
                                        
                                    }
                                } ?>
                                <?php
                                    if($encontrado) { ?>
                                        <td style="width: 1.5rem !important;padding: 0 !important;text-align: center !important;" 
                                        colspan="1">
                                        <input 
                                        type="text"
                                            id="<?php echo $estudiante->id;?>-tareatotal" 
                                            style="text-align: center;width: 4.5rem !important;border:none !important;"
                                            value="<?php
                                            //$resultado = number_format( (intval($totalPuntosObtenidos) * 100) / intval($TotalPuntos), 2 );
                                        
                                            $proyectoNota = ($totalPuntosObtenidos*$TotalPuntos)/$TotalPuntos;
    
                                            $porcentaje = $totalCotidiano / $TotalPuntos;
                                      
                                            $tareasPorcentaje = $proyectoNota * $porcentaje;
                                        
                                            //$resultado = Min(number_format( intval($totalPuntosObtenidos) / intval($TotalPuntos) * 100, 2 ), $totalCotidiano);
                                        
                                            echo number_format($tareasPorcentaje,2); // Imprime: 2?>"
                                            readonly>
                                       
                                        <!-- (8 puntos / ($evalua->totalIndicadores * 10)) * 100 -->
                                    </td>
                                  <?php  }  ?>
                                





                                <?php $i = 0; ?>
                           <?php foreach ($evaluacion as $evalua) { ?>
                                <?php if ($evalua->periodo == '1' && $estudiante->id == $evalua->estudiante_id) { ?>
                                    
                                    <td style="width: 1.5rem !important;padding: 0 !important" 
                                            colspan="1"><input 
                                            name="indicadores[<?php echo $estudiante->id;?>-<?php echo $i?>]" 
                                            id="<?php echo $estudiante->id;?>-<?php echo $i?>" 
                                            style="text-align: center;width: 2rem !important;border:none !important;" 
                                            type="number" 
                                            min="0" 
                                            max="10" 
                                            value="<?php echo $evalua->valor ?? '1';?>">
                                        </td>
                                    <?php 
                                        $i++;
                                        $encontrado = true;
                                    ?>
                                <?php } ?>
                            <?php } ?>
                              <?php 
                              $encontrado = false;
                              foreach ($cotidiano as $cotidi) {
                                  if($cotidi->periodo == '1') {
                                      $faltando = $cotidi->totalIndicadores - $i;
                                      if($faltando > 0) {
                                            for ($e = 0; $e < $faltando; $e++) { 
                                              
                                                ?>
                                            
                                                    <td style="width: 1.5rem !important;padding: 0 !important" 
                                                        colspan="1"><input 
                                                        name="indicadores[<?php echo $estudiante->id;?>-<?php echo $i;?>]" 
                                                        id="<?php echo $estudiante->id;?>-<?php echo $i;?>" 
                                                        style="text-align: center;width: 2rem !important;border:none !important;" 
                                                        type="number" 
                                                        min="0" 
                                                        max="10" 
                                                        value="10">
                                                    </td> 
                                                <?php
                                                $i++;
                                                $encontrado = true;
                                            }
                                        } else {$encontrado = true;}
                                    }
                                }
                                if($encontrado == false) { ?>
                                          <td style="width: 1.5rem !important;padding: 0 !important" 
                                              colspan="1"><input 
                                              name="indicadores[<?php echo $estudiante->id;?>-<?php echo $i;?>]" 
                                              id="<?php echo $estudiante->id;?>-<?php echo $i;?>" 
                                              style="text-align: center;width: 2rem !important;border:none !important;" 
                                              type="number" 
                                              min="0" 
                                              max="10" 
                                              value="10">
                                          </td> 
                                      <?php
                                    
                                  }
                        ?>
                        </tr>
                       <?php 
                    $t++;} ?>
                    </tbody>
                    </table>
                </div>
                    <input type="submit" class="save-button" value="Guardar">
        </fieldset>
    </form>

    <form method="POST" action="" class="form form-cotidiano <?php if(base64_decode($_GET['periodo']) != '2') {echo 'hidden';} ?>">
            <input type="hidden" value="c2" name="form">
        <fieldset class="fset">
            <legend>Segundo Semestre</legend>
            <input id="indCount" type="hidden" name="countInd" 
            value="<?php foreach ($cotidiano as $cotidi) {
                $encontrado = false;
                if($cotidi->periodo == '2') {
                    if($cotidi->totalIndicadores) {
                        echo $cotidi->totalIndicadores;
                        $totalCotidiano = $cotidi->totalCotidiano;
                                                $totalIndicadores = $cotidi->totalIndicadores;
                                                $TotalPuntos = $cotidi->totalIndicadores * 10;
                        $encontrado = true;
                        break;
                    }
                }
            }
                if(!$encontrado) {
                    echo '1';
                } ?>">
            <input id="" type="hidden" name="modulo" value="<?php echo $modulo->id;?>">
                <div class="slot teacher-input-container">
                <?php $totalCotidiano = 0; ?>
                <label for="totalCotidiano">Valor Total</label>
                    <input 
                        type="number" 
                        id="totalCotidiano" 
                        placeholder="Agregue un porcentaje en números" 
                        name="totalCotidiano"
                        value="<?php foreach ($cotidiano as $cotidi) {
                            $encontrado = false;
                            if($cotidi->periodo == '2') {
                                if($cotidi->totalCotidiano) {
                                    echo $cotidi->totalCotidiano;
                                    $totalCotidiano = $cotidi->totalCotidiano;
                                    $encontrado = true;
                                    
                                    break;
                                }
                            }
                            }
                            if(!$encontrado) {
                                echo '1';
                            } ?>"
                        class="number-input"
                        min="1"
                        max="99">
                    </div>
                    <div class="div-add-ind">
                            <label for="">Indicadores</label>
                            <button class="save-button circle-button" onclick="addIndicador(<?php echo $modulo->id?>,1,2,0); event.preventDefault()"> - </button><button class="save-button circle-button" onclick="addIndicador(<?php echo $modulo->id?>,0,2,0); event.preventDefault()"> + </button>
                        </div>
                <div style="overflow-x: auto !important;">
                    <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Porcentaje</th>
                            <?php $encontrado = false;
                            foreach ($cotidiano as $cotidi) {
                            if($cotidi->periodo == '2') {
                                if($cotidi->totalCotidiano) {
                                    for ($i = 0; $i < $cotidi->totalIndicadores; $i++) { ?>
                                        <th id="indicador-header"><?php echo $i+1; ?></th>
                                        <?php
                                        $encontrado = true;
                                    }
                                } else { ?>
                                    <th id="indicador-header-1">1</th>
                                    <?php }
                                }
                            }
                            if(!$encontrado) {
                                echo '<th id="indicador-header-1">1</th>';
                            } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($estudiantes as $estudiante) {?>
                        <tr>
                            <td colspan="1"><?php echo $estudiante->nombre;?> <?php echo $estudiante->apellido; ?></td>
                            
                            
                            
                            
                            <?php 
                             
                                $encontrado = false;
                            
                                $totalPuntosObtenidos = 0;
                                foreach ($evaluacion as $evalua) {
                                    if ($evalua->periodo == '2' && $estudiante->id == $evalua->estudiante_id) {
                                        
                                        $encontrado = true;
                                        $totalPuntosObtenidos = $totalPuntosObtenidos+$evalua->valor;
                                        
                                    }
                                } ?>
                                <?php
                                    if($encontrado) { ?>
                                        <td style="width: 1.5rem !important;padding: 0 !important;text-align: center !important;" 
                                        colspan="1">
                                        <input 
                                        type="text"
                                            id="<?php echo $estudiante->id;?>-tareatotal" 
                                            style="text-align: center;width: 4.5rem !important;border:none !important;"
                                            value="<?php
                                            //$resultado = number_format( (intval($totalPuntosObtenidos) * 100) / intval($TotalPuntos), 2 );
                                        
                                            $proyectoNota = ($totalPuntosObtenidos*$TotalPuntos)/$TotalPuntos;
    
                                            $porcentaje = $totalCotidiano / $TotalPuntos;
                                      
                                            $tareasPorcentaje = $proyectoNota * $porcentaje;
                                        
                                            //$resultado = Min(number_format( intval($totalPuntosObtenidos) / intval($TotalPuntos) * 100, 2 ), $totalCotidiano);
                                        
                                            echo number_format($tareasPorcentaje,2); // Imprime: 2?>"
                                            readonly>
                                       
                                        <!-- (8 puntos / ($evalua->totalIndicadores * 10)) * 100 -->
                                    </td>
                                  <?php  }  ?>
                            
                            
                            
                            <?php 
                                $i = 0;
                                $encontrado = false;
                            ?>
                            <?php foreach ($evaluacion as $evalua) { ?>
                                <?php if ($evalua->periodo == '2' && $estudiante->id == $evalua->estudiante_id) { ?>
                                    <td style="width: 1.5rem !important;padding: 0 !important" 
                                        colspan="1"><input 
                                       name="indicadores[<?php echo $estudiante->id;?>-<?php echo $i;?>]" 
                                        id="<?php echo $estudiante->id;?>-<?php echo $i;?>" 
                                        style="text-align: center;width: 2rem !important;border:none !important;" 
                                        type="number" 
                                        min="1" 
                                        max="10" 
                                        value="<?php echo $evalua->valor ?? '1';?>">
                                    </td> 
                                    <?php 
                                        $i++;
                                        $encontrado = true;
                                    ?>
                                <?php } ?>
                            <?php } ?>
                            
                            <?php 
                            $encontrado = false;
                            foreach ($cotidiano as $cotidi) {
                                        if($cotidi->periodo == '2') {
                                            $faltando = $cotidi->totalIndicadores - $i;
                                            if($faltando > 0) {
                                            for ($e = 0; $e < $faltando; $e++) { ?>
                                                    <td style="width: 1.5rem !important;padding: 0 !important" 
                                                        colspan="1"><input 
                                                        name="indicadores[<?php echo $estudiante->id;?>-<?php echo $i;?>]" 
                                                        id="<?php echo $estudiante->id;?>-<?php echo $i;?>" 
                                                        style="text-align: center;width: 2rem !important;border:none !important;" 
                                                        type="number" 
                                                        min="1" 
                                                        max="10" 
                                                        value="10">
                                                    </td> 
                                                <?php
                                                $i++;
                                                $encontrado = true;
                                            }
                                        } else {$encontrado = true;}
                                    }
                                }
                                if($encontrado == false) {
                                    ?>
                                          <td style="width: 1.5rem !important;padding: 0 !important" 
                                              colspan="1"><input 
                                              name="indicadores[<?php echo $estudiante->id;?>-<?php echo '0';?>]" 
                                              id="<?php echo $estudiante->id;?>-<?php echo '0';?>" 
                                              style="text-align: center;width: 2rem !important;border:none !important;" 
                                              type="number" 
                                              min="1" 
                                              max="10" 
                                              value="10">
                                          </td> 
                                      <?php
                                     
                                  }
                            ?>
                        </tr>
                       <?php } ?>
                    </tbody>
                    </table>
                </div>
                <input type="submit" class="save-button" value="Guardar">
        </fieldset>
    </form>
    </div>
















    <!-- FINAL DEL COTIDIANO -->
    <div id="tab-3" class="tabcontent <?php if(base64_decode($_GET['page']) == 'tab-3') {echo 'active';} ?>">
      
        <form method="POST" action="" class="form form-exam <?php if(base64_decode($_GET['periodo']) != '1') {echo 'hidden';} ?>">
            <input type="hidden" value="e1" name="form">
        <fieldset class="fset">
            <legend>Primer Semestre</legend>
            <div style="overflow-x: auto !important;">
                    <table class="schedule-table">
                    <thead>
                        <tr>
                            <th class="exam-header-1">Nombre</th>
                                <th class="exam-header-1">Examen #1</th>
                                <th class="exam-header-1">Examen #2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($estudiantes as $estudiante) {?>
                        <tr>
                            <td colspan="1"><?php echo $estudiante->nombre;?> <?php echo $estudiante->apellido; ?></td>
                            <td colspan="1"><?php ?><input name="examenes[<?php echo $estudiante->id ?? '';?>-1-1]" type="number" class="input-exam-value" 
                            value="<?php $encontrado = false;
                            foreach ($examenes as $examen) {
                                if ($examen->estudiante_id == $estudiante->id && $examen->periodo == '1' && $examen->indicador == '1') {
                                    echo $examen->valor;
                                    $encontrado = true;
                                    break;
                                }
                                # code...
                            }
                            
                            if(!$encontrado) {
                                echo '1';
                            }
                            ?>" 
                             min="1" max="100"></td>
                            <td colspan="1"><?php ?><input name="examenes[<?php echo $estudiante->id ?? '';?>-1-2]" type="number" class="input-exam-value" 
                            value="<?php $encontrado = false;
                            foreach ($examenes as $examen) {
                                if ($examen->estudiante_id == $estudiante->id && $examen->periodo == '1' && $examen->indicador == '2') {
                                    echo $examen->valor;
                                    $encontrado = true;
                                }
                                # code...
                            }
                            
                            if(!$encontrado) {
                                echo '1';
                            }
                            ?>" 
                             min="1" max="100"></td>
                        
                        </tr>
                        <?php } ?>
                    </tbody>


                    </table>
            </div>
                    <input type="submit" class="save-button" value="Guardar">
                </fieldset>
        </form>

        <form method="POST" action="" class="form form-exam <?php if(base64_decode($_GET['periodo']) != '2') {echo 'hidden';} ?>">
            <input type="hidden" value="e2" name="form">
        <fieldset class="fset">
            <legend>Segundo Semestre</legend>
            <div style="overflow-x: auto !important;">
                    <table class="schedule-table">
                    <thead>
                        <tr>
                            <th class="exam-header-1">Nombre</th>
                                <th class="exam-header-1">Examen #1</th>
                                <th class="exam-header-1">Examen #2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($estudiantes as $estudiante) {?>
                        <tr>
                            <td colspan="1"><?php echo $estudiante->nombre;?> <?php echo $estudiante->apellido; ?></td>
                            <td colspan="1"><?php ?><input name="examenes[<?php echo $estudiante->id ?? '';?>-2-1]" type="number" class="input-exam-value" 
                            value="<?php $encontrado = false;
                            foreach ($examenes as $examen) {
                                if ($examen->estudiante_id == $estudiante->id && $examen->periodo == '2' && $examen->indicador == '1') {
                                    echo $examen->valor;
                                    $encontrado = true;
                                }
                                # code...
                            }
                            
                            if(!$encontrado) {
                                echo '1';
                            }
                            ?>" 
                            min="1" max="100"></td>
                            <td colspan="1"><?php ?><input name="examenes[<?php echo $estudiante->id ?? '';?>-2-2]" type="number" class="input-exam-value" 
                            value="<?php $encontrado = false;
                            foreach ($examenes as $examen) {
                                if ($examen->estudiante_id == $estudiante->id && $examen->periodo == '2' && $examen->indicador == '2') {
                                    echo $examen->valor;
                                    $encontrado = true;
                                }
                                # code...
                            }
                            
                            if(!$encontrado) {
                                echo '1';
                            }
                            ?>"
                            min="1" max="100"></td>
                        
                        </tr>
                        <?php } ?>
                    </tbody>


                    </table>
            </div>
                    <input type="submit" class="save-button" value="Guardar">
                </fieldset>
        </form>
    </div>










    <div id="tab-4" class="tabcontent <?php if(base64_decode($_GET['page']) == 'tab-4') {echo 'active';} ?>">
        <label for="">Tareas <span><button class="save-button circle-button" onclick="addHW(<?php echo $modulo->id .','.base64_decode($_GET['periodo'])?>); event.preventDefault()"> + </button></span></label>
    <div class="<?php if(base64_decode($_GET['periodo']) != '1') {echo 'hidden';} ?>">
    <?php $c = 1; ?>
    <?php foreach($tareas as $tarea) {
        if($tarea->periodo == '1') { ?>
            <form method="POST" action="" class="form form-tarea" style="overflow: auto;">
                <input type="hidden" value="t1" name="form">
                <input id="" type="hidden" name="modulo" value="<?php echo $modulo->id;?>">
                <input id="" type="hidden" name="id" value="<?php echo $tarea->id ?? '0';?>">
                
                <input id="tareaCant" type="hidden" name="cant" value="<?php echo $tarea->cant ?? '1'; ?>">
                <fieldset class="fset">
                    
                    
                    <legend>Tarea #<?php echo $c; ?></legend>
                    <div style="width: 100%;text-align: right;">
                        <button style="margin: 0;padding: 0;" class="save-button circle-button" onclick="deleteHW(<?php echo $tarea->id ?? '';?>); event.preventDefault()"> X </button>
                    </div>
                        <label for="totalPuntosTarea">Puntos</label>
                                <input 
                                    type="number" 
                                    id="totalPuntosTarea"
                                    name="totalPuntosTarea"
                                    value="<?php echo $tarea->totalPuntosTarea ?? '1' ?>"
                                    class="number-input"
                                    min="1"
                                    max="99">
                                    <label for="totalPorcentajeTarea">Porcentaje</label>
                                <input 
                                    type="number" 
                                    id="totalPorcentajeTarea" 
                                    
                                    name="totalPorcentajeTarea"
                                    value="<?php echo $tarea->totalPorcentajeTarea ?? '1' ?>"
                                    class="number-input"
                                    min="1"
                                    max="99">


                        <div style="display:flex;margin: 1rem 0 0 0;">
                                <table class="schedule-table">
                                
                                <thead>
                                    <tr>
                                        <th class="tarea-header-1">Nombre</th>
                                            <th class="tarea-header-1">Puntos</th>
                                            <th class="tarea-header-1">Nota</th>
                                            <th class="tarea-header-1">Porcentaje</th>
                                            <th class="tarea-header-1">Observaciones</th>
                                        </tr>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($estudiantes as $estudiante) {?>
                                        <tr>
                                            <td colspan="1"><?php echo $estudiante->nombre;?> <?php echo $estudiante->apellido; ?></td>
                                            <?php
                                                $t = 1;
                                                $encontrado = false;
                                                foreach ($tareas_evaluacion as $tarea_evaluacion) {
                                                    if ($tarea_evaluacion->estudiante == $estudiante->id && $tarea_evaluacion->periodo == '1' && $tarea_evaluacion->indicador == $tarea->id) {
                                                       // echo $tarea_evaluacion->tareasPuntos; ?>
                                                        <td colspan="1">
                                                        <input name="tareasPuntos[<?php echo $estudiante->id ?? '';?>-<?php echo $t ?>]" type="number" class="input-tarea-value" 
                                                            value="<?php echo $tarea_evaluacion->tareasPuntos; ?>"
                                                            min="0" max="100">
                                                        </td>
                                                        <td colspan="1"><?php ?>
                                                        <input readonly name="" type="number" class="input-tarea-value" 
                                                            value="<?php echo $tarea_evaluacion->tareasNota; ?>"
                                                            min="0" max="100">
                                                        </td>
                                                        <td colspan="1"><?php ?>
                                                        <input readonly name="" type="number" class="input-tarea-value" 
                                                            value="<?php echo $tarea_evaluacion->tareasPorcentaje; ?>"
                                                            min="0" max="100">
                                                        </td>
                                                        <td colspan="1">
                                                            <textarea spellcheck="false" name="observaciones[<?php echo $estudiante->id ?? '';?>-<?php echo $t ?>]" id="" cols="30" rows="1"><?php echo $tarea_evaluacion->observaciones; ?></textarea>
                                                        </td>
                                                   <?php 
                                                    $encontrado = true;   
                                                }
                                                    # code...
                                                } 
                                                if(!$encontrado) { ?>
                                                    <td colspan="1">
                                                        <input name="tareasPuntos[<?php echo $estudiante->id ?? '';?>-<?php echo $t ?>]" type="number" class="input-tarea-value" 
                                                            value="0"
                                                            min="0" max="100">
                                                        </td>
                                                        <td colspan="1"><?php ?>
                                                        <input readonly name="" type="number" class="input-tarea-value" 
                                                            value="0"
                                                            min="0" max="100">
                                                        </td>
                                                        <td colspan="1"><?php ?>
                                                        <input readonly name="" type="number" class="input-tarea-value" 
                                                            value="0"
                                                            min="1" max="100">
                                                        </td>
                                                        <td colspan="1">
                                                            <textarea spellcheck="false" name="observaciones[<?php echo $estudiante->id ?? '';?>-<?php echo $t ?>]" id="" cols="30" rows="1"></textarea>
                                                        </td>
                                               <?php 
                                                    }
                                                ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                </table>
                                <div class="evaluation-homework-teacher">
                                    <label class="" for="evaluacion" style="">Evaluación</label>
                                    <textarea spellcheck="false" name="evaluacion" class="evaluacion-tarea" cols="20" rows="10"><?php echo $tarea->evaluacion ?? '' ?></textarea>
                                </div>
                        </div>
                        
                
                            <input type="submit" class="save-button" value="Guardar">
                        </fieldset>
                </form>

            
       <?php 
       
       $c++;
    }
    };?>
    
    </div>
    

    <?php $c = 1; ?>
    <div class="<?php if(base64_decode($_GET['periodo']) != '2') {echo 'hidden';} ?>">
    <?php foreach($tareas as $tarea) {
        if($tarea->periodo == '2') { ?>
            <form method="POST" action="" class="form form-tarea">
                <input type="hidden" value="t2" name="form">
                <input id="" type="hidden" name="modulo" value="<?php echo $modulo->id;?>">
                <input id="" type="hidden" name="id" value="<?php echo $tarea->id ?? '0';?>">
                
                <input id="tareaCant" type="hidden" name="cant" value="<?php echo $tarea->cant ?? '1'; ?>">
                <fieldset class="fset">
                    
                    
                    <legend> #<?php echo $c; ?></legend>
                    <div style="width: 100%;text-align: right;">
                        <button style="margin: 0;padding: 0;" class="save-button circle-button" onclick="deleteHW(<?php echo $tarea->id ?? '';?>); event.preventDefault()"> X </button>
                    </div>
                        <label for="totalPuntosTarea">Puntos</label>
                                <input 
                                    type="number" 
                                    id="totalPuntosTarea"
                                    name="totalPuntosTarea"
                                    value="<?php echo $tarea->totalPuntosTarea ?? '1' ?>"
                                    class="number-input"
                                    min="1"
                                    max="99">
                                    <label for="totalPorcentajeTarea">Porcentaje</label>
                                <input 
                                    type="number" 
                                    id="totalPorcentajeTarea" 
                                    
                                    name="totalPorcentajeTarea"
                                    value="<?php echo $tarea->totalPorcentajeTarea ?? '1' ?>"
                                    class="number-input"
                                    min="1"
                                    max="99">


                        <div style="overflow-x: auto !important;display:flex;margin: 1rem 0 0 0;">
                                <table class="schedule-table">
                                
                                <thead>
                                    <tr>
                                        <th class="tarea-header-1">Nombre</th>
                                            <th class="tarea-header-1">Puntos</th>
                                            <th class="tarea-header-1">Nota</th>
                                            <th class="tarea-header-1">Porcentaje</th>
                                            <th class="tarea-header-1">Observaciones</th>
                                        </tr>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($estudiantes as $estudiante) {?>
                                        <tr>
                                            <td colspan="1"><?php echo $estudiante->nombre;?> <?php echo $estudiante->apellido; ?></td>
                                            <?php
                                                $t = 1;
                                                $encontrado = false;
                                                foreach ($tareas_evaluacion as $tarea_evaluacion) {
                                                    if ($tarea_evaluacion->estudiante == $estudiante->id && $tarea_evaluacion->periodo == '2' && $tarea_evaluacion->indicador == $tarea->id) {
                                                       // echo $tarea_evaluacion->tareasPuntos; ?>
                                                        <td colspan="1">
                                                        <input name="tareasPuntos[<?php echo $estudiante->id ?? '';?>-<?php echo $t ?>]" type="number" class="input-tarea-value" 
                                                            value="<?php echo $tarea_evaluacion->tareasPuntos; ?>"
                                                            min="0" max="100">
                                                        </td>
                                                        <td colspan="1"><?php ?>
                                                        <input readonly name="" type="number" class="input-tarea-value" 
                                                            value="<?php echo $tarea_evaluacion->tareasNota; ?>"
                                                            min="0" max="100">
                                                        </td>
                                                        <td colspan="1"><?php ?>
                                                        <input readonly name="" type="number" class="input-tarea-value" 
                                                            value="<?php echo $tarea_evaluacion->tareasPorcentaje; ?>"
                                                            min="0" max="100">
                                                        </td>
                                                        <td colspan="1">
                                                            <textarea spellcheck="false" name="observaciones[<?php echo $estudiante->id ?? '';?>-<?php echo $t ?>]" id="" cols="30" rows="1"><?php echo $tarea_evaluacion->observaciones; ?></textarea>
                                                        </td>
                                                   <?php 
                                                    $encontrado = true;   
                                                }
                                                    # code...
                                                } 
                                                if(!$encontrado) { ?>
                                                    <td colspan="1">
                                                        <input name="tareasPuntos[<?php echo $estudiante->id ?? '';?>-<?php echo $t ?>]" type="number" class="input-tarea-value" 
                                                            value="0"
                                                            min="0" max="100">
                                                        </td>
                                                        <td colspan="1"><?php ?>
                                                        <input readonly name="" type="number" class="input-tarea-value" 
                                                            value="0"
                                                            min="0" max="100">
                                                        </td>
                                                        <td colspan="1"><?php ?>
                                                        <input readonly name="" type="number" class="input-tarea-value" 
                                                            value="0"
                                                            min="1" max="100">
                                                        </td>
                                                        <td colspan="1">
                                                            <textarea spellcheck="false" name="observaciones[<?php echo $estudiante->id ?? '';?>-<?php echo $t ?>]" id="" cols="30" rows="1"></textarea>
                                                        </td>
                                               <?php 
                                                    }
                                                ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                </table>
                                <div class="evaluation-homework-teacher">
                                    <label class="" for="evaluacion" style="">Evaluación</label>
                                    <textarea spellcheck="false" name="evaluacion" class="evaluacion-tarea" cols="20" rows="10"><?php echo $tarea->evaluacion ?? '' ?></textarea>
                                </div>
                        </div>
                        
                
                            <input type="submit" class="save-button" value="Guardar">
                        </fieldset>
                </form>

            
       <?php 
       
       $c++;
    }
    };?>
    
    </div>

    </div>














    <div id="tab-5" class="tabcontent <?php if(base64_decode($_GET['page']) == 'tab-5') {echo 'active';} ?>">
        
    <form method="POST" action="" class="form form-asistencia <?php if(base64_decode($_GET['periodo']) != '1') {echo 'hidden';} ?>">
            <input type="hidden" value="a1" name="form">
        <fieldset class="fset">
            <legend>Primer Semestre</legend>
            <input id="asistCount" type="hidden" name="asistCount" 
            value="<?php 
                $encontrado = false;
                foreach ($asistencia as $asist) {
                    if($asist->periodo == '1') {
                        if($asist->totalIndicadores) {
                            echo $asist->totalIndicadores;
                            $encontrado = true;
                            
                            break;
                        }
                    }
                }
                if($encontrado == false) {
                    echo '1';
                } ?>">
            <input id="" type="hidden" name="modulo" value="<?php echo $modulo->id;?>">
                <div class="slot teacher-input-container">


               
                <label for="totalAsistencia">Valor Total</label>
                    <input 
                        type="number" 
                        id="totalAsistencia" 
                        placeholder="" 
                        name="totalAsistencia"
                        value="<?php 
                        
                        $encontrado = false;
                        foreach ($asistencia as $asist) {
                        if($asist->periodo == '1') {
                            if($asist->totalAsistencia) {
                                echo $asist->totalAsistencia;
                                $totalAsistencia =  $asist->totalAsistencia;
                                $encontrado = true;
                                
                                $totalIndicadores = $asist->totalIndicadores;
                                $TotalPuntos = $asist->totalIndicadores * 2;
                                break;
                            }
                        }
                        }
                        if(!$encontrado) {
                            echo '1';
                        } ?>"
                        class="number-input"
                        min="1"
                        max="99">
                    </div>
                    <div class="div-add-ind">
                            <label for="">Indicadores</label>
                        
                            <button class="save-button circle-button" onclick="addIndicador(<?php echo $modulo->id?>,1,1,1); event.preventDefault()"> - </button><button class="save-button circle-button" onclick="addIndicador(<?php echo $modulo->id?>,0,1,1); event.preventDefault()"> + </button>
                        </div>
                    <p class="asist-helper" style="">A:<strong>0</strong> / T:<strong>1</strong> / P:<strong>2</strong></p>
                    <div style="overflow-x: auto !important;">
                    <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Total %</th>
                            <th>T</th>
                            <th>A</th>
                            <th>A%</th>
                            <?php $encontrado = false;
                            foreach ($asistencia as $asist) {
                                
                            if($asist->periodo == '1') {
                                if($asist->totalAsistencia) {
                                    for ($i = 0; $i < $asist->totalIndicadores; $i++) { ?>
                                        <?php if($asistencia_fechas[0][$i] === null) { ?>
                                            <th id="indicador-header-1" class="v-txt"><?php echo substr(date('Y-m-d'), 5) ?? '1' ?></th>
                                            <?php } else { ?>                        
                                                <th id="indicador-header" class="v-txt"><?php echo substr($asistencia_fechas[0][$i], 5); ?></th>
                                        <?php
                                        }
                                        $encontrado = true;
                                    }
                                } else { ?>
                                    <th id="indicador-header-1" class="v-txt"><?php echo substr(date('Y-m-d'), 5) ?? '1' ?></th>
                                    <?php }
                                }
                            }
                            if(!$encontrado) { ?>
                                    <th id="indicador-header-1" class="v-txt"><?php echo substr(date('Y-m-d'), 5) ?? '1' ?></th>
                                <?php } ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        $t = 0;
                        foreach ($estudiantes as $estudiante) {?>
                        <tr>

                            <td colspan="1"><?php echo $estudiante->nombre;?> <?php echo $estudiante->apellido; ?></td>
                            
                            
                            
                            <?php 
                                $i = 0;
                                $encontrado = false;
                                $totalPuntosObtenidos = 0;
                                $asistenciaPorcentaje = 0;
                                $tarde = 0;
                                $ausencia = 0;
                                foreach ($asistencia_evaluacion as $asist) {
                                    if ($asist->periodo == '1' && $estudiante->id == $asist->estudiante_id) { 
                                        $totalPuntosObtenidos = $totalPuntosObtenidos+$asist->valor;

                                        $encontrado = true;
                                        if($asist->valor === '0') {
                                            $ausencia++;
                                        } else if($asist->valor === '1') {
                                            $tarde++;
                                        }
                                        
                                      
                                        
                                    } 
                                }
                                //$resultado = number_format( (intval($totalPuntosObtenidos) * 100) / intval($TotalPuntos), 2 );
                                        
                                
                            
                                if($encontrado) { 
                                    $asistenciaNota = ($totalPuntosObtenidos*$TotalPuntos)/$TotalPuntos;
                                    $asistenciaPorcentajeAu = ($asistenciaNota*100)/$TotalPuntos;
                                    $porcentaje = $totalAsistencia / $TotalPuntos;
                          
                                    $asistenciaPorcentaje = $asistenciaNota * $porcentaje;
                                   
                                    ?>
                                    <td style="width: 1.5rem !important;padding: 0 !important;text-align: center !important;" 
                                        colspan="1">
                                        <input 
                                        type="text"
                                            id="<?php echo $estudiante->id;?>-Totalasistencia" 
                                            style="text-align: center;width: 4.5rem !important;border:none !important;"
                                            value="<?php
                                            
                                            //$resultado = Min(number_format( intval($totalPuntosObtenidos) / intval($TotalPuntos) * 100, 2 ), $totalCotidiano);
                                        
                                            echo number_format($asistenciaPorcentaje,2); // Imprime: 2?>"
                                            readonly>
                                       
                                        <!-- (8 puntos / ($evalua->totalIndicadores * 10)) * 100 -->
                                    </td>
                                     <td style="width: 1.5rem !important;padding: 0 !important;text-align: center !important;" 
                                        colspan="1">
                                        <input 
                                        type="text"
                                            id="<?php echo $estudiante->id;?>-Totalasistencia" 
                                            style="text-align: center;width: 4.5rem !important;border:none !important;<?php if($tarde > 2) { echo 'color: indianred;'; } ?>"
                                            value="<?php echo $tarde; // Imprime: 2?>"
                                            readonly>
                                       </td>
                                     <td style="width: 1.5rem !important;padding: 0 !important;text-align: center !important;" 
                                        colspan="1">
                                        <input 
                                        type="text"
                                            id="<?php echo $estudiante->id;?>-Totalasistencia" 
                                            style="text-align: center;width: 4.5rem !important;border:none !important; <?php if($ausencia > 2) { echo 'color: red;'; } ?>"
                                            value="<?php echo $ausencia; // Imprime: 2?>"
                                            readonly>
                                       </td>
                                     <td style="width: 1.5rem !important;padding: 0 !important;text-align: center !important;" 
                                        colspan="1">
                                        <input 
                                        type="text"
                                            id="<?php echo $estudiante->id;?>-Totalasistencia" 
                                            style="text-align: center;width: 4.5rem !important;border:none !important;"
                                            value="<?php echo number_format(100 - $asistenciaPorcentajeAu,2); // Imprime: 2?>"
                                            readonly>
                                       </td>
                                      
                                <?php } ?>
                            
                            <?php 
                                        $i = 0;
                                        $encontrado = false;
                                    ?>
                           <?php foreach ($asistencia_evaluacion as $asist) { ?>
                                <?php if ($asist->periodo == '1' && $estudiante->id == $asist->estudiante_id) { ?>
                                    
                                    <td style="width: 1.5rem !important;padding: 0 !important" 
                                            colspan="1"><input 
                                            name="indicadores[<?php echo $estudiante->id;?>-<?php echo $i?>]" 
                                            id="<?php echo $estudiante->id;?>-<?php echo $i?>" 
                                            style="text-align: center;width: 2rem !important;border:none !important;" 
                                            type="number" 
                                            min="0" 
                                            max="2" 
                                            value="<?php echo $asist->valor ?? '0';?>">
                                        </td>
                                    <?php 
                                        $i++;
                                        $encontrado = true;
                                    ?>
                                <?php } ?>
                            <?php } ?>
                              <?php 
                              $encontrado = false;
                              foreach ($asistencia as $asist) {
                                  if($asist->periodo == '1') {
                                      $faltando = $asist->totalIndicadores - $i;
                                      //echo $asist->totalIndicadores;
                                      if($faltando > 0) {
                                            for ($e = 0; $e < $faltando; $e++) { 
                                              
                                                ?>
                                                    <td style="width: 1.5rem !important;padding: 0 !important" 
                                                        colspan="1"><input 
                                                        name="indicadores[<?php echo $estudiante->id;?>-<?php echo $i;?>]" 
                                                        id="<?php echo $estudiante->id;?>-<?php echo $i;?>" 
                                                        style="text-align: center;width: 2rem !important;border:none !important;" 
                                                        type="number" 
                                                        min="0" 
                                                        max="2" 
                                                        value="0">
                                                    </td> 
                                                <?php
                                                $i++;
                                                $encontrado = true;
                                            }
                                        } else {$encontrado = true;}
                                    }
                                }
                                
                                if($encontrado == false) { ?>
                                          <td style="width: 1.5rem !important;padding: 0 !important" 
                                              colspan="1"><input 
                                              name="indicadores[<?php echo $estudiante->id;?>-<?php echo $i;?>]" 
                                              id="<?php echo $estudiante->id;?>-<?php echo $i;?>" 
                                              style="text-align: center;width: 2rem !important;border:none !important;" 
                                              type="number" 
                                              min="0" 
                                              max="2" 
                                              value="0">
                                          </td> 
                                      <?php
                                    
                                  }
                                  $encontrado = false;
                        ?>
                        </tr>
                       <?php 
                    $t++;} ?>
                    </tbody>
                    </table>
                </div>
                    <input type="submit" class="save-button" value="Guardar">
        </fieldset>
    </form>

    <form method="POST" action="" class="form form-asistencia <?php if(base64_decode($_GET['periodo']) != '2') {echo 'hidden';} ?>">
            <input type="hidden" value="a2" name="form">
        <fieldset class="fset">
            <legend>Segundo Semestre</legend>
            <input id="asistCount" type="hidden" name="asistCount" 
            value="<?php 
                $encontrado = false;
            foreach ($asistencia as $asist) {
                if($asist->periodo == '2') {
                    if($asist->totalIndicadores) {
                        echo $asist->totalIndicadores;
                        $encontrado = true;
                        break;
                    }
                }
            }
                if($encontrado == false) {
                    echo '1';
                } ?>">
            <input id="" type="hidden" name="modulo" value="<?php echo $modulo->id;?>">
                <div class="slot teacher-input-container">
                <label for="totalAsistencia">Valor Total</label>
                
                    <input 
                        type="number" 
                        id="totalAsistencia" 
                        placeholder="" 
                        name="totalAsistencia"
                        value="<?php foreach ($asistencia as $asist) {
                            $encontrado = false;
                            if($asist->periodo == '2') {
                                if($asist->totalAsistencia) {
                                    echo $asist->totalAsistencia;
                                    $encontrado = true;
                                    $totalAsistencia = $asist->totalAsistencia;
                                    $totalIndicadores = $asist->totalIndicadores;
                                    $TotalPuntos = $asist->totalIndicadores * 2;
                                    break;
                                }
                            }
                            }
                            if(!$encontrado) {
                                echo '1';
                            } ?>"
                        class="number-input"
                        min="1"
                        max="99">
                    </div>
                    <div class="div-add-ind">
                            <label for="">Indicadores</label>
                            <button class="save-button circle-button" onclick="addIndicador(<?php echo $modulo->id?>,1,2,1); event.preventDefault()"> - </button><button class="save-button circle-button" onclick="addIndicador(<?php echo $modulo->id?>,0,2,1); event.preventDefault()"> + </button>
                        </div>
                    <p class="asist-helper" style="">A:<strong>0</strong> / T:<strong>1</strong> / P:<strong>2</strong></p>

                    <div style="overflow-x: auto !important;">
                    <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Total %</th>
                            <th>T</th>
                            <th>A</th>
                            <th>A%</th>
                            <?php $encontrado = false;
                            // Establecer la zona horaria a Costa Rica
                            date_default_timezone_set('America/Costa_Rica');
                            foreach ($asistencia as $asist) {
                            if($asist->periodo == '2') {
                                if($asist->totalAsistencia) {
                                    for ($i = 0; $i < $asist->totalIndicadores; $i++) { ?>
                                        <?php if($asistencia_fechas[1][$i] === null) { ?>
                                            <th id="indicador-header-1"  class="v-txt"><?php
                                                
                                                echo substr(date('Y-m-d'), 5) ?? '1' ?></th>
                                            <?php } else {?>                        
                                                <th id="indicador-header" class="v-txt"><?php echo substr($asistencia_fechas[1][$i], 5); ?></th>
                                        <?php
                                        }
                                        $encontrado = true;
                                    }
                                } else { ?>
                                    <th id="indicador-header-1" class="v-txt"><?php echo substr(date('Y-m-d'), 5) ?? '1' ?></th>
                                    <?php }
                                }
                            }
                            if(!$encontrado) { ?>
                                    <th id="indicador-header-1" class="v-txt"><?php echo substr(date('Y-m-d'), 5) ?? '1' ?></th>
                           <?php } ?>
                        </tr>
                    </thead>




                    <tbody>
                        <?php 
                        $t = 0;
                        foreach ($estudiantes as $estudiante) {?>
                        <tr>
                            <td colspan="1"><?php echo $estudiante->nombre;?> <?php echo $estudiante->apellido; ?></td>
                            <?php 
                                        $i = 0;
                                        $encontrado = false;
                                     
                                        $totalPuntosObtenidos = 0;
                                        $asistenciaPorcentaje = 0;
                                        $tarde = 0;
                                        $ausencia = 0;
                                        foreach ($asistencia_evaluacion as $asist) {
                                            if ($asist->periodo == '2' && $estudiante->id == $asist->estudiante_id) { 
                                                $totalPuntosObtenidos = $totalPuntosObtenidos+$asist->valor;
        
                                                $encontrado = true;
                                                if($asist->valor === '0') {
                                                    $ausencia++;
                                                } else if($asist->valor === '1') {
                                                    $tarde++;
                                                }
                                                
                                              
                                                
                                            } 
                                        }
                                        //$resultado = number_format( (intval($totalPuntosObtenidos) * 100) / intval($TotalPuntos), 2 );
                                                
                                        
                                    
                                        if($encontrado) { 
                                            $asistenciaNota = ($totalPuntosObtenidos*$TotalPuntos)/$TotalPuntos;
                                            $asistenciaPorcentajeAu = ($asistenciaNota*100)/$TotalPuntos;
                                            
                                            $porcentaje = $totalAsistencia / $TotalPuntos;
                                  
                                            $asistenciaPorcentaje = $asistenciaNota * $porcentaje;
                                           
                                            ?>
                                            <td style="width: 1.5rem !important;padding: 0 !important;text-align: center !important;" 
                                                colspan="1">
                                                <input 
                                                type="text"
                                                    id="<?php echo $estudiante->id;?>-Totalasistencia" 
                                                    style="text-align: center;width: 4.5rem !important;border:none !important;"
                                                    value="<?php
                                                    
                                                    //$resultado = Min(number_format( intval($totalPuntosObtenidos) / intval($TotalPuntos) * 100, 2 ), $totalCotidiano);
                                                
                                                    echo number_format($asistenciaPorcentaje,2); // Imprime: 2?>"
                                                    readonly>
                                               
                                                <!-- (8 puntos / ($evalua->totalIndicadores * 10)) * 100 -->
                                            </td>
                                             <td style="width: 1.5rem !important;padding: 0 !important;text-align: center !important;" 
                                                colspan="1">
                                                <input 
                                                type="text"
                                                    id="<?php echo $estudiante->id;?>-Totalasistencia" 
                                                    style="text-align: center;width: 4.5rem !important;border:none !important; <?php if($tarde > 2) { echo 'color: indianred;'; } ?>"
                                                    value="<?php echo $tarde; // Imprime: 2?>"
                                                    readonly>
                                               </td>
                                             <td style="width: 1.5rem !important;padding: 0 !important;text-align: center !important;" 
                                                colspan="1">
                                                <input 
                                                type="text"
                                                    id="<?php echo $estudiante->id;?>-Totalasistencia" 
                                                    style="text-align: center;width: 4.5rem !important;border:none !important; <?php if($ausencia > 2) { echo 'color: red;'; } ?>"
                                                    value="<?php echo $ausencia; // Imprime: 2?>"
                                                    readonly>
                                               </td>
                                             <td style="width: 1.5rem !important;padding: 0 !important;text-align: center !important;" 
                                                colspan="1">
                                                <input 
                                                type="text"
                                                    id="<?php echo $estudiante->id;?>-Totalasistencia" 
                                                    style="text-align: center;width: 4.5rem !important;border:none !important;"
                                                    value="<?php echo number_format(100 - $asistenciaPorcentajeAu,2); // Imprime: 2?>"
                                                    readonly>
                                               </td>
                                              
                                        <?php } ?>
                                    
                           <?php foreach ($asistencia_evaluacion as $asist) { ?>
                                <?php if ($asist->periodo == '2' && $estudiante->id == $asist->estudiante_id) { ?>
                                    
                                    <td style="width: 1.5rem !important;padding: 0 !important" 
                                            colspan="1"><input 
                                            name="indicadores[<?php echo $estudiante->id;?>-<?php echo $i?>]" 
                                            id="<?php echo $estudiante->id;?>-<?php echo $i?>" 
                                            style="text-align: center;width: 2rem !important;border:none !important;" 
                                            type="number" 
                                            min="0" 
                                            max="2" 
                                            value="<?php echo $asist->valor ?? '0';?>">
                                        </td>
                                    <?php 
                                        $i++;
                                        $encontrado = true;
                                    ?>
                                <?php } ?>
                            <?php } ?>
                              <?php 
                              $encontrado = false;
                              foreach ($asistencia as $asist) {
                                  if($asist->periodo == '2') {
                                      $faltando = $asist->totalIndicadores - $i;
                                      if($faltando > 0) {
                                            for ($e = 0; $e < $faltando; $e++) { 
                                              
                                                ?>
                                                    <td style="width: 1.5rem !important;padding: 0 !important" 
                                                        colspan="1"><input 
                                                        name="indicadores[<?php echo $estudiante->id;?>-<?php echo $i;?>]" 
                                                        id="<?php echo $estudiante->id;?>-<?php echo $i;?>" 
                                                        style="text-align: center;width: 2rem !important;border:none !important;" 
                                                        type="number" 
                                                        min="0" 
                                                        max="2" 
                                                        value="0">
                                                    </td> 
                                                <?php
                                                $i++;
                                                $encontrado = true;
                                            }
                                        } else {$encontrado = true;}
                                    }
                                }
                                if($encontrado == false) { ?>
                                          <td style="width: 1.5rem !important;padding: 0 !important" 
                                              colspan="1"><input 
                                              name="indicadores[<?php echo $estudiante->id;?>-<?php echo $i;?>]" 
                                              id="<?php echo $estudiante->id;?>-<?php echo $i;?>" 
                                              style="text-align: center;width: 2rem !important;border:none !important;" 
                                              type="number" 
                                              min="0" 
                                              max="2" 
                                              value="0">
                                          </td> 
                                      <?php
                                    
                                  }
                        ?>
                        </tr>
                       <?php 
                    $t++;} ?>
                    </tbody>
                    </table>
                </div>
                <input type="submit" class="save-button" value="Guardar">
        </fieldset>
    </form>
    </div>












    <div id="tab-6" class="tabcontent <?php if(base64_decode($_GET['page']) == 'tab-6') {echo 'active';} ?>">
        <?php 
        $encontrado1 = false; 
        $encontrado2 = false;?>

        <?php foreach($proyectos as $proyecto) { ?>
            <?php if($proyecto->periodo == '1') {
               
                $encontrado1 = true;?>
                <form  style="overflow-x: auto !important" method="POST" action="" class="form form-asistencia <?php if(base64_decode($_GET['periodo']) != '1') {echo 'hidden';} ?>">
                    
                    <input type="hidden" value="p1" name="form">
                    <input type="hidden" name="modulo" value="<?php echo $modulo->id;?>">
                    <input type="hidden" name="proyectoID" value="<?php echo $proyecto->id;?>">
                    <input id="projectCount" type="hidden" name="projectCount" value="<?php echo $proyecto->indicadores ?? '0';?>">
                    <fieldset class="fset">
                        <legend>Primer Semestre</legend>
                        <div style="width: 100%;text-align: left;">
                            <button style="margin: 0; padding: 0;" class="save-button circle-button" onclick="deleteProject(<?php echo $proyecto->id ?? ''; ?>); event.preventDefault()"> X </button>
                        </div>
                        <div class="slot teacher-input-container">
                            <label for="porcentajeTotal">Valor Total</label>
                                <input 
                                    type="number" 
                                    id="porcentajeTotal" 
                                    placeholder="" 
                                    name="porcentajeTotal"
                                    value="<?php echo $proyecto->porcentajeTotal; ?>"
                                    class="number-input"
                                    min="1"
                                    max="99"
                                >
                        </div>
                        <div class="div-add-ind">
                            <label for="">Indicadores</label>
                            <button id="btn-add-project-ind" class="save-button circle-button" onclick="addProjectIndicador(<?php echo $proyecto->id?>,<?php echo $modulo->id?>,<?php echo $proyecto->indicadores ?>,1,0); event.preventDefault()"> - </button>
                            <button id="btn-add-project-ind" class="save-button circle-button" onclick="addProjectIndicador(<?php echo $proyecto->id?>,<?php echo $modulo->id?>,<?php echo $proyecto->indicadores ?>,1,1); event.preventDefault()"> + </button>
                        </div>
                        <div style="margin: 1rem 0 0 0;">
                            <table class="schedule-table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Observaciones</th>
                                        <th>Puntos </th>
                                        <th>Porcentaje</th>
                                        <?php 
                                        $t = 1;
                                        foreach ($proyecto_indicadores as $proyecto_indicador) { 
                                            if($proyecto_indicador->proyecto == $proyecto->id) { ?>
                                                <td colspan="1">
                                                    <textarea spellcheck="false" name="proyecto_indicadores[<?php echo $proyecto_indicador->id ?? '';?>-<?php echo $proyecto->id ?>]" id="" cols="30" rows="1"><?php echo $proyecto_indicador->valor; ?></textarea>
                                                </td>
                                           <?php }?>
                                            
                                            
                                            <?php 
                                            $t++;
                                        }
                                        ?>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    foreach ($estudiantes as $estudiante) {?>
                                        <tr>
                                            <td class="estudiante" colspan="1"><?php echo $estudiante->nombre;?> <?php echo $estudiante->apellido; ?></td>
                                        

                                        <?php

                                        $proyecto_evaluacion_total = 0;
                                        foreach ($proyecto_evaluaciones as $proyecto_evaluacion) { 
                                            if($proyecto_evaluacion->estudiante == $estudiante->id  && $proyecto_evaluacion->proyecto == $proyecto->id) { 
                                                $proyecto_evaluacion_total = $proyecto_evaluacion_total + $proyecto_evaluacion->valor;
                                            }
                                        } 

                                        $t = 1;
                                        foreach ($proyecto_observaciones as $proyecto_observacion) {
                                            if($proyecto_observacion->estudiante == $estudiante->id && $proyecto_observacion->proyecto == $proyecto->id) { ?>
                                            
                                                <td colspan="1">
                                                    <textarea spellcheck="false" name="observaciones[<?php echo $proyecto_observacion->id ?? '';?>-<?php echo $proyecto_indicador->id ?>]" id="" cols="30" rows="1"><?php echo $proyecto_observacion->valor; ?></textarea>
                                                </td>
                                                
                                        <?php }
                                        $t++;
                                        } 
                                        $t = 1;
                                        foreach ($proyecto_observaciones as $proyecto_observacion) { 
                                            if($proyecto_observacion->estudiante == $estudiante->id && $proyecto_observacion->proyecto == $proyecto->id) { ?>
                                                <td colspan="1">
                                                    <?php 
                                                        $proyecto_evaluacion_puntos_total = $proyecto->indicadores * 5
                                                    ?>
                                                        <input readonly name="" type="number" class="input-tarea-value" 
                                                            value="<?php echo number_format(($proyecto_evaluacion_total / $proyecto_evaluacion_puntos_total) * 100, 2); ?>"
                                                            min="0" max="100"
                                                        >
                                                </td>
                                        <?php }
                                        $t++;
                                        } 

                                        $t = 1;
                                        foreach ($proyecto_observaciones as $proyecto_observacion) { 
                                            if($proyecto_observacion->estudiante == $estudiante->id  && $proyecto_observacion->proyecto == $proyecto->id) { ?>
                                                <td colspan="1">
                                                    <?php 
                                                        $proyecto_evaluacion_puntos_total = $proyecto->indicadores * 5
                                                    ?>
                                                        <input readonly name="" type="number" class="input-tarea-value" 
                                                            value="<?php echo number_format(($proyecto_evaluacion_total / $proyecto_evaluacion_puntos_total) * $proyecto->porcentajeTotal, 2); ; ?>"
                                                            min="0" max="100"
                                                        >
                                                        <!--  (Nota obtenida / Puntos totales) * Valor del proyecto -->
                                                </td>
                                        <?php }
                                        $t++;
                                        } 

    
                                       
                                        foreach ($proyecto_evaluaciones as $proyecto_evaluacion) { 
                                            if($proyecto_evaluacion->estudiante == $estudiante->id  && $proyecto_evaluacion->proyecto == $proyecto->id) { ?>
                                            
                                           
                                                
                                                <td colspan="1">
                                                    <input max="5" min="0" type="number" name="proyecto_evaluacion[<?php echo $proyecto_evaluacion->id ?? '';?>-<?php echo $proyecto_indicador->id ?>]" value="<?php echo $proyecto_evaluacion->valor; ?>">
                                                </td>
                                            <?php }
                                        
                                        } 
                                        ?>
                                    <?php } ?>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <input type="submit" class="save-button" value="Guardar">
                    </fieldset>
                </form>
                <?php 
                
            }
            
            
            if($proyecto->periodo == '2') { 
               
                $encontrado2 = true;?>
                <form  style="overflow-x: auto !important" method="POST" action="" class="form form-asistencia <?php if(base64_decode($_GET['periodo']) != '2') {echo 'hidden';} ?>">
                    
                    <input type="hidden" value="p2" name="form">
                    <input type="hidden" name="modulo" value="<?php echo $modulo->id;?>">
                    <input type="hidden" name="proyectoID" value="<?php echo $proyecto->id;?>">
                    <input id="projectCount" type="hidden" name="projectCount" value="<?php echo $proyecto->indicadores ?? '0';?>">
                    <fieldset class="fset">
                        <legend>Primer Semestre</legend>
                        <div style="width: 100%;text-align: left;">
                            <button style="margin: 0; padding: 0;" class="save-button circle-button" onclick="deleteProject(<?php echo $proyecto->id ?? ''; ?>); event.preventDefault()"> X </button>
                        </div>
                        <div class="slot teacher-input-container">
                            <label for="porcentajeTotal">Valor Total</label>
                                <input 
                                    type="number" 
                                    id="porcentajeTotal" 
                                    placeholder="" 
                                    name="porcentajeTotal"
                                    value="<?php echo $proyecto->porcentajeTotal; ?>"
                                    class="number-input"
                                    min="1"
                                    max="99"
                                >
                        </div>
                        <div class="div-add-ind">
                            <label for="">Indicadores</label>
                            <button id="btn-add-project-ind" class="save-button circle-button" onclick="addProjectIndicador(<?php echo $proyecto->id?>,<?php echo $modulo->id?>,<?php echo $proyecto->indicadores ?>,2,0); event.preventDefault()"> - </button>
                            <button id="btn-add-project-ind" class="save-button circle-button" onclick="addProjectIndicador(<?php echo $proyecto->id?>,<?php echo $modulo->id?>,<?php echo $proyecto->indicadores ?>,2,1); event.preventDefault()"> + </button>
                        </div>
                        <div style="margin: 1rem 0 0 0;">
                            <table class="schedule-table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Observaciones</th>
                                        <th>Puntos </th>
                                        <th>Porcentaje</th>
                                        <?php 
                                        $t = 1;
                                        foreach ($proyecto_indicadores as $proyecto_indicador) { 
                                            //echo $estudiante->id;
                                            if($proyecto_indicador->proyecto == $proyecto->id) { ?>
                                                <td colspan="1">
                                                    <textarea spellcheck="false" name="proyecto_indicadores[<?php echo $proyecto_indicador->id ?? '';?>-<?php echo $proyecto->id ?>]" id="" cols="30" rows="1"><?php echo $proyecto_indicador->valor; ?></textarea>
                                                </td> 
                                           <?php } 
                                           
                                           $t++;
                                        }
                                        if($t == '1') { ?>
                                            <td colspan="1">
                                                <textarea spellcheck="false" name="proyecto_indicadores[<?php echo $proyecto_indicador->id ?? '';?>-<?php echo $proyecto->id ?>]" id="" cols="30" rows="1"><?php echo $proyecto_indicador->valor; ?></textarea>
                                            </td>
                                        <?php } ?>
                                        
                                        
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    foreach ($estudiantes as $estudiante) {?>
                                        <tr>
                                            <td class="estudiante" colspan="1"><?php echo $estudiante->nombre;?> <?php echo $estudiante->apellido; ?></td>
                                        

                                    <?php

                                    $proyecto_evaluacion_total = 0;
                                    foreach ($proyecto_evaluaciones as $proyecto_evaluacion) { 
                                        if($proyecto_evaluacion->estudiante == $estudiante->id && $proyecto_evaluacion->proyecto == $proyecto->id) { 
                                            $proyecto_evaluacion_total = $proyecto_evaluacion_total + $proyecto_evaluacion->valor;
                                        }
                                    } 

                                    $tpr = 1;
                                    foreach ($proyecto_observaciones as $proyecto_observacion) { 
                                        if($proyecto_observacion->estudiante == $estudiante->id && $proyecto_observacion->proyecto == $proyecto->id) { ?>
                                        
                                            <td colspan="1">
                                                <textarea spellcheck="false" name="observaciones[<?php echo $proyecto_observacion->id ?? '';?>-<?php echo $proyecto_indicador->id ?>]" id="" cols="30" rows="1"><?php echo $proyecto_observacion->valor; ?></textarea>
                                            </td>
                                            
                                    <?php $tpr++; }
                                  
                                    }
                                    if ($tpr == 1) { ?>
                                        <td colspan="1">
                                            <textarea spellcheck="false" name="observaciones[<?php echo $proyecto_observacion->id ?? '';?>-<?php echo $proyecto_indicador->id ?>]" id="" cols="30" rows="1"></textarea>
                                        </td>
                                        <?php } ?>


                                    <td colspan="1">
                                   <?php $tpr = 1;
                                   
                                    foreach ($proyecto_observaciones as $proyecto_observacion) { 
                                        if($proyecto_observacion->estudiante == $estudiante->id && $proyecto_observacion->proyecto == $proyecto->id) { ?>
                                        
                                            
                                                <?php 
                                                    $proyecto_evaluacion_puntos_total = $proyecto->indicadores * 5
                                                ?>
                                                    <input readonly name="" type="number" class="input-tarea-value" 
                                                        value="<?php echo number_format(($proyecto_evaluacion_total / $proyecto_evaluacion_puntos_total) * 100, 2); ?>">
                                                        <?php 
                                        $tpr++; 
                                        }
                                
                                
                            } 
                            if ($tpr == 1) { ?>
                                <input readonly name="" type="number" class="input-tarea-value" value="0">
                           <?php }
                            ?> 
                            </td>
                                    
                            <td colspan="1">
                                   <?php $t = 1;
                                    foreach ($proyecto_observaciones as $proyecto_observacion) { 
                                        if($proyecto_observacion->estudiante == $estudiante->id && $proyecto_observacion->proyecto == $proyecto->id) { ?>
                                        
                                            
                                                <?php 
                                                    $proyecto_evaluacion_puntos_total = $proyecto->indicadores * 5
                                                ?>
                                                    <input readonly name="" type="number" class="input-tarea-value" 
                                                        value="<?php echo number_format(($proyecto_evaluacion_total / $proyecto_evaluacion_puntos_total) * $proyecto->porcentajeTotal, 2); ; ?>"
                                                        min="0" max="100"
                                                    >
                                                    <!--  (Nota obtenida / Puntos totales) * Valor del proyecto -->
                                                    <?php $t++; 
                                                    }
                                    
                                } 
                                if ($t == 1) { ?>
                                    <input readonly name="" type="number" class="input-tarea-value" value="0">
                               <?php }
                                ?> 
                             
                              
                            </td>



                            <td colspan="1">
                                   <?php $t = 1;
                                    $proyecto_evaluacion_total = 0;
                                    foreach ($proyecto_evaluaciones as $proyecto_evaluacion) { 
                                        if($proyecto_evaluacion->estudiante == $estudiante->id && $proyecto_evaluacion->proyecto == $proyecto->id) { 
                                            $proyecto_evaluacion_total = $proyecto_evaluacion_total + $proyecto_evaluacion->valor;
                                        ?>
                                                <input max="5" min="0" type="number" name="proyecto_evaluacion[<?php echo $proyecto_evaluacion->id ?? '';?>-<?php echo $proyecto_indicador->id ?>]" value="<?php echo $proyecto_evaluacion->valor; ?>">
                                                
                                                <?php 
                                                $t++;
                                        }
                                    } 
                                    if ($t == 1) { ?>
                                        <input max="5" min="0" type="number" class="input-tarea-value" value="0" name="proyecto_evaluacion[<?php echo $proyecto_evaluacion->proyecto; ?>-<?php echo $estudiante->id ?>-<?php echo $proyecto_evaluacion->modulo ?>-add]">
                                   <?php }
                                    ?>
                            </td>
                                    <?php } ?>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <input type="submit" class="save-button" value="Guardar">
                    </fieldset>
                </form>
            <?php } ?>
        <?php } ?>




            

           
       <?php 
        if(!$encontrado1 && base64_decode($_GET['periodo']) == '1') { ?>
        <form action="" method="POST">
            <input type="submit" class="save-button" value="Activar">
            <input type="hidden" value="ap1" name="form">
            <input type="hidden" value="1" name="periodo">
            <input type="hidden" value="1" name="porcentajeTotal">
            <input type="hidden" name="modulo" value="<?php echo $modulo->id;?>">
        </form>
       <?php }
       if(!$encontrado2 && base64_decode($_GET['periodo']) == '2') { ?>
        <form action="" method="POST">
            <input type="submit" class="save-button" value="Activar">
            <input type="hidden" value="ap2" name="form">
            <input type="hidden" value="2" name="periodo">
            <input type="hidden" value="1" name="porcentajeTotal">
            <input type="hidden" name="modulo" value="<?php echo $modulo->id;?>">
        </form>
      <?php }?>
        



    </div>
















    <div id="tab-7" class="tabcontent <?php if(base64_decode($_GET['page']) == 'tab-7') {echo 'active';} ?>">

       
        <form  style="overflow-x: auto !important" method="POST" action="" class="form form-asistencia <?php //if(base64_decode($_GET['periodo']) != '1') {echo 'hidden';} ?>">
            <input type="hidden" value="cm1" name="form">
            <input type="hidden" name="modulo" value="<?php echo $modulo->id;?>">
           <input type="hidden" name="periodo" value="<?php echo base64_decode($_GET['periodo'])?>">
            <fieldset class="fset">
                <legend>Primer Semestre</legend>
                <div style="margin: 1rem 0 0 0;">
                    <table class="schedule-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th style="width: 100%;">Observaciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($estudiantes as $estudiante) {
                                $encontrado = false;?>
                                <tr>
                                    <td class="estudiante" colspan="1"><?php echo $estudiante->nombre;?> <?php echo $estudiante->apellido; ?></td>
                                


                                <?php foreach ($comentarios as $comentario) {
                                    if($comentario->estudiante == $estudiante->id && $comentario->modulo == $modulo->id && $comentario->periodo == base64_decode($_GET['periodo'])) { ?>
                                        <td colspan="1">
                                            <textarea spellcheck="false" name="comentarios[<?php echo $estudiante->id;?>]" id="" cols="30" rows="1"><?php echo $comentario->comentario;?></textarea>
                                        </td>
                                    <?php $encontrado = true;
                                    }
                                }
                                if(!$encontrado) { ?>
                                    <td colspan="1">
                                        <textarea spellcheck="false" name="comentarios[<?php echo $estudiante->id; ?>]" id="" cols="30" rows="1"></textarea>
                                    </td>
                               <?php } ?>
                               </tr>
                           <?php } ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <input type="submit" class="save-button" value="Guardar">
        </form>
               
        

        
    </div>


</div>
    <?php }
?>
