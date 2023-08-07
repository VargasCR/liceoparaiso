<?php

namespace Controllers;
use Model\Ajuste;
use Model\Asistencia;
use Model\Asistencia_beca;
use Model\Asistencia_evaluacion;
use Model\Cotidiano;
use Model\Cotidiano_evaluacion;
use Model\Estudiante;
use Model\Examen_evaluacion;
use Model\Foro_enlace;
use Model\Foro_images;
use Model\Foro_items;
use Model\Foros;
use Model\Grupo;
use Model\Horario;
use Model\Modulo;
use Model\Noticias;
use Model\Profesor;
use Model\Profesor_comentarios;
use Model\Proyecto;
use Model\Proyecto_evaluacion;
use Model\Proyecto_indicador;
use Model\Proyecto_observacion;
use Model\Tarea;
use Model\Tarea_evaluacion;
use MVC\Router;

class TeacherController {


    public static function teacher_module(Router $router) {
        session_start();
        isAuth();
        $id = base64_decode($_GET['id']);
        $modulo = Modulo::find($id);
        $grupo = Grupo::find($modulo->grupoID);
        $horario = Horario::findGroup('moduleID',$id);
        $cotidiano = Cotidiano::findGroup('moduloID',$id);
        $comentarios = Profesor_comentarios::findGroup('modulo',$id);
        $estudiantes = Estudiante::findGroup('seccion',$modulo->grupoID);
        $titulo = $grupo->grado . ' - '. $grupo->seccion . ' ' . $modulo->nombre;
        //debuguear($indicadores);
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $form = $_POST['form'];
            switch ($form) {
                case "c1":
                    $periodo = substr($form,1);
                    $ncontidiano = new Cotidiano();
                    
                    if(!empty($cotidiano)) {
                        foreach ($cotidiano as $item) {
                            if($item->periodo == $periodo) {
                                $ncontidiano->sincronizar($item);
                            }
                        }
                        
                        $ncontidiano->totalCotidiano = $_POST['totalCotidiano'];
                        $ncontidiano->totalIndicadores = $_POST['countInd'];
                        $ncontidiano->guardar();
                    } else {
                        
                        if($_POST['totalIndicadores'] == '') {
                            $ncontidiano->totalIndicadores = '1';
                        } else {$ncontidiano->totalIndicadores = $_POST['countInd'];}
                        $ncontidiano->totalCotidiano = $_POST['totalCotidiano'];
                        $ncontidiano->moduloID = $id;
                        $ncontidiano->periodo = $periodo;
                        $ncontidiano->guardar();
                    }
                    
                    $indicadores = $_POST['indicadores'];
                    
                    $cotidiano_evaluacion = new Cotidiano_evaluacion();
                    
                    foreach ($indicadores as $clave => $valor) {
                        //debuguear($_POST);
                        $valores = explode("-", $clave);
                        $indicador_estudiante = $valores[0]; // "estudiante"
                        $indicador_indicador = $valores[1]; // "indicador"
                        $indicador_modulo = $_POST['modulo'];
                        $cotidiano_evaluacion_1 = $cotidiano_evaluacion->where_AND_AND_AND_AND('modulo',$indicador_modulo,'indicador',$indicador_indicador,'estudiante_id',$indicador_estudiante,'periodo',$periodo);
                        //debuguear($indicador_modulo);
                        
                    
                        if($cotidiano_evaluacion_1) {
                            $cotidiano_evaluacion->id = $cotidiano_evaluacion_1[0]->id;
                        } else {
                            $cotidiano_evaluacion->id = null;
                        };
                        $cotidiano_evaluacion->modulo = $indicador_modulo;
                        $cotidiano_evaluacion->indicador = $indicador_indicador;
                        $cotidiano_evaluacion->valor = $valor;
                        
                        $cotidiano_evaluacion->periodo = $periodo;
                        
                        $cotidiano_evaluacion->estudiante_id = $indicador_estudiante;
                        $cotidiano_evaluacion->guardar();
                    }
                    //debuguear($cotidiano_evaluacion);
                break;
                case "c2":
                    //debuguear($_POST);
                    $periodo = substr($form,1);
                    $ncontidiano = new Cotidiano();
                    if(!empty($cotidiano)) {
                        foreach ($cotidiano as $item) {
                            if($item->periodo == $periodo) {
                                $ncontidiano->sincronizar($item);
                            }
                        }
                        
                        $ncontidiano->totalCotidiano = $_POST['totalCotidiano'];
                        $ncontidiano->totalIndicadores = $_POST['countInd'];
                        $ncontidiano->periodo = $periodo;
                        $ncontidiano->moduloID = $_POST['modulo'];
                        
                        $ncontidiano->guardar();
                    } else {
                        
                        if($_POST['totalIndicadores'] == '') {
                            $ncontidiano->totalIndicadores = '1';
                        } else {$ncontidiano->totalIndicadores = $_POST['countInd'];}
                        $ncontidiano->totalCotidiano = $_POST['totalCotidiano'];
                        $ncontidiano->moduloID = $id;
                        $ncontidiano->periodo = $periodo;
                        $ncontidiano->guardar();
                    }
                    
                    $indicadores = $_POST['indicadores'];
                    
                    $cotidiano_evaluacion = new Cotidiano_evaluacion();
                    
                    
                    foreach ($indicadores as $clave => $valor) {
                        //debuguear($_POST);
                        $valores = explode("-", $clave);
                        $indicador_estudiante = $valores[0]; // "estudiante"
                        $indicador_indicador = $valores[1]; // "indicador"
                        $indicador_modulo = $_POST['modulo'];
                        $cotidiano_evaluacion_1 = $cotidiano_evaluacion->where_AND_AND_AND_AND('modulo',$indicador_modulo,'indicador',$indicador_indicador,'estudiante_id',$indicador_estudiante,'periodo',$periodo);
                        //debuguear($indicador_modulo);
                        
                        
                        if($cotidiano_evaluacion_1) {
                            $cotidiano_evaluacion->id = $cotidiano_evaluacion_1[0]->id;
                        } else {
                            $cotidiano_evaluacion->id = null;
                        };
                        $cotidiano_evaluacion->modulo = $indicador_modulo;
                        $cotidiano_evaluacion->indicador = $indicador_indicador;
                        $cotidiano_evaluacion->valor = $valor;
                        
                        $cotidiano_evaluacion->periodo = $periodo;
                        
                        $cotidiano_evaluacion->estudiante_id = $indicador_estudiante;
                        //debuguear($cotidiano_evaluacion);
                        $cotidiano_evaluacion->guardar();
                    }
                    //debuguear($i);
                    break;
                    case "e1":
                        
                        $periodo = substr($form,1);
                    $indicadores = $_POST['examenes'];
                    foreach ($indicadores as $clave => $valor) {
                        $examen_evaluacion = new Examen_evaluacion();
                        
                        $valores = explode("-", $clave);
                        $indicador_estudiante = $valores[0]; // "estudiante"
                        $indicador_periodo = $valores[1]; // "periodo"
                        $indicador_examen = $valores[2]; // "examen"
                        
                            $examen_evaluacion_1 = $examen_evaluacion->where_AND_AND_AND_AND('modulo',$id,'indicador',$indicador_examen,'estudiante_id',$indicador_estudiante,'periodo',$periodo);
                            
                                if(!empty($examen_evaluacion_1)) {
                                    $examen_evaluacion->sincronizar($examen_evaluacion_1[0]);
                                    $examen_evaluacion->modulo = $id;
                                    $examen_evaluacion->periodo = $indicador_periodo;
                                    $examen_evaluacion->indicador = $indicador_examen;
                                    $examen_evaluacion->valor = $valor;
                                    $examen_evaluacion->estudiante_id = $indicador_estudiante;
                                    $examen_evaluacion->guardar();
                                } else {
                                    $examen_evaluacion->modulo = $id;
                                    $examen_evaluacion->periodo = $indicador_periodo;
                                    $examen_evaluacion->indicador = $indicador_examen;
                                    $examen_evaluacion->valor = 1;
                                    $examen_evaluacion->estudiante_id = $indicador_estudiante;
                                    $examen_evaluacion->guardar();
                                }
                        
                        
                        //debuguear($examen_evaluacion);
                        
                    }
                
                    break;

                    
                case "e2":
                     
                    $periodo = substr($form,1);
                    $indicadores = $_POST['examenes'];
                    //debuguear($indicadores);
                    foreach ($indicadores as $clave => $valor) {
                        $examen_evaluacion = new Examen_evaluacion();
                        $valores = explode("-", $clave);
                        $indicador_estudiante = $valores[0]; // "estudiante"
                        $indicador_periodo = $valores[1]; // "periodo"
                        $indicador_examen = $valores[2]; // "examen"
                        $examen_evaluacion_1 = $examen_evaluacion->where_AND_AND_AND_AND('modulo',$id,'indicador',$indicador_examen,'estudiante_id',$indicador_estudiante,'periodo',$periodo);
                        
                        if($examen_evaluacion_1) {
                            $examen_evaluacion->sincronizar($examen_evaluacion_1[0]);
                            $examen_evaluacion->modulo = $id;
                            $examen_evaluacion->periodo = $indicador_periodo;
                            $examen_evaluacion->indicador = $indicador_examen;
                            $examen_evaluacion->valor = $valor;
                            $examen_evaluacion->estudiante_id = $indicador_estudiante;
                            $examen_evaluacion->guardar();
                        } else {
                            $examen_evaluacion->modulo = $id;
                            $examen_evaluacion->periodo = $indicador_periodo;
                            $examen_evaluacion->indicador = $indicador_examen;
                            $examen_evaluacion->valor = 1;
                            $examen_evaluacion->estudiante_id = $indicador_estudiante;
                            $examen_evaluacion->guardar();
                        }
                    }
                    break;

                    
                case "a1":
                    $periodo = substr($form,1);
                    $nasistencia = new Asistencia();
                    $asistencia = $nasistencia->where_AND('moduloID',$id,'periodo','1');
                   
                    if(!empty($asistencia)) {
                        foreach ($asistencia as $item) {
                            if($item->periodo == $periodo) {
                                $nasistencia->sincronizar($item);
                            }
                        }
                        $nasistencia->totalAsistencia = $_POST['totalAsistencia'];
                        $nasistencia->totalIndicadores = $_POST['asistCount'];
                        $nasistencia->guardar();
                       
                    } else {
                        
                        if($_POST['totalIndicadores'] == '') {
                            $nasistencia->totalIndicadores = '1';
                        } else {
                            $nasistencia->totalIndicadores = $_POST['asistCount'];}
                            $nasistencia->totalAsistencia = $_POST['totalAsistencia'];
                            $nasistencia->moduloID = $id;
                            $nasistencia->periodo = $periodo;
                        
                            $nasistencia->guardar();
                    }
                    
                    $indicadores = $_POST['indicadores'];
                    
                    $asistencia_evaluacion = new Asistencia_evaluacion();
                    foreach ($indicadores as $clave => $valor) {
                        //debuguear($_POST);
                        $valores = explode("-", $clave);
                        $indicador_estudiante = $valores[0]; // "estudiante"
                        $indicador_indicador = $valores[1]; // "indicador"
                        $indicador_modulo = $_POST['modulo'];
                        $asistencia_evaluacion_1 = $asistencia_evaluacion->where_AND_AND_AND_AND('modulo',$indicador_modulo,'indicador',$indicador_indicador,'estudiante_id',$indicador_estudiante,'periodo',$periodo);
                       
                        //debuguear($indicador_modulo);
                        
                        
                        if($asistencia_evaluacion_1) {
                            $asistencia_evaluacion->id = $asistencia_evaluacion_1[0]->id;
                            $asistencia_evaluacion->date = $asistencia_evaluacion_1[0]->date;
                        } else {
                            $asistencia_evaluacion->id = null;
                            $asistencia_evaluacion->date = date('Y-m-d');
                        };
                        //debuguear($asistencia_evaluacion);
                        $asistencia_evaluacion->modulo = $indicador_modulo;
                        $asistencia_evaluacion->indicador = $indicador_indicador;
                        $asistencia_evaluacion->valor = $valor;
                        
                        $asistencia_evaluacion->periodo = $periodo;
                        
                        $asistencia_evaluacion->estudiante_id = $indicador_estudiante;
                        $asistencia_evaluacion->guardar();
                }
                //debuguear($i);
                break;
  
                    
                case "a2":
                    $periodo = substr($form,1);
                    $nasistencia = new Asistencia();
                    $asistencia = $nasistencia->where_AND('moduloID',$id,'periodo','2');
                   
                    if(!empty($asistencia)) {
                        foreach ($asistencia as $item) {
                            if($item->periodo == $periodo) {
                                $nasistencia->sincronizar($item);
                            }
                        }
                        $nasistencia->totalAsistencia = $_POST['totalAsistencia'];
                        $nasistencia->totalIndicadores = $_POST['asistCount'];
                        $nasistencia->guardar();
                       
                    } else {
                        
                        if($_POST['totalIndicadores'] == '') {
                            $nasistencia->totalIndicadores = '1';
                        } else {
                            $nasistencia->totalIndicadores = $_POST['asistCount'];}
                            $nasistencia->totalAsistencia = $_POST['totalAsistencia'];
                            $nasistencia->moduloID = $id;
                            $nasistencia->periodo = $periodo;
                        
                            $nasistencia->guardar();
                    }
                    
                    $indicadores = $_POST['indicadores'];
                    
                    $asistencia_evaluacion = new Asistencia_evaluacion();
                    foreach ($indicadores as $clave => $valor) {
                        //debuguear($_POST);
                        $valores = explode("-", $clave);
                        $indicador_estudiante = $valores[0]; // "estudiante"
                        $indicador_indicador = $valores[1]; // "indicador"
                        $indicador_modulo = $_POST['modulo'];
                        $asistencia_evaluacion_1 = $asistencia_evaluacion->where_AND_AND_AND_AND('modulo',$indicador_modulo,'indicador',$indicador_indicador,'estudiante_id',$indicador_estudiante,'periodo',$periodo);
                       
                        
                        //debuguear(date('Y-m-d'));
                        
                        if($asistencia_evaluacion_1) {
                            $asistencia_evaluacion->id = $asistencia_evaluacion_1[0]->id;
                            $asistencia_evaluacion->date = $asistencia_evaluacion_1[0]->date;
                        } else {
                            $asistencia_evaluacion->id = null;
                            
                            $asistencia_evaluacion->date = date('Y-m-d');
                        };
                        $asistencia_evaluacion->modulo = $indicador_modulo;
                        $asistencia_evaluacion->indicador = $indicador_indicador;
                        $asistencia_evaluacion->valor = $valor;
                        
                        $asistencia_evaluacion->periodo = $periodo;
                        
                        $asistencia_evaluacion->estudiante_id = $indicador_estudiante;
                        
                        $asistencia_evaluacion->guardar();
                        
                }
                //debuguear($i);
                break;
                case "t1":
                    
                    $periodo = substr($form,1);
                    $ntarea = new Tarea();
                    $tarea = $ntarea->find($_POST['id']);
                    //debuguear($tarea);
                    
                    if(!empty($tarea)) {
                        
                            $ntarea->sincronizar($tarea);
                            $indicador_indicador = $tarea->id;
                            //debuguear($ntarea);
                            $ntarea->totalPuntosTarea = $_POST['totalPuntosTarea'];
                            $ntarea->totalPorcentajeTarea = $_POST['totalPorcentajeTarea'];
                            $ntarea->evaluacion = $_POST['evaluacion'];
                            $ntarea->periodo = $periodo;
                            $ntarea->modulo = $_POST['modulo'];
                            //debuguear($ntarea);
                            //debuguear($ntarea);
                            $ntarea->guardar();
                        
                    } else {
                        
                        
                        if($_POST['cant'] == '') {
                            $ntarea->cant = '1';
                        } else {
                            $ntarea->cant = $_POST['cant'];
                        }
                            $ntarea->totalPuntosTarea = $_POST['totalPuntosTarea'];
                            $ntarea->totalPorcentajeTarea = $_POST['totalPorcentajeTarea'];
                            $ntarea->evaluacion = $_POST['evaluacion'];
                            $ntarea->modulo = $id;
                            $ntarea->periodo = $periodo;
                            
                            $ntarea->guardar();
                            
                            $indicador_indicador = $ntarea->findLast('modulo',$id);
                    }
                    
                    $tareasPuntos = $_POST['tareasPuntos'];
                    
                   
                    $tarea_evaluacion = new Tarea_evaluacion();
                    foreach ($tareasPuntos as $clave => $valor) {
                        //debuguear($_POST);
                        $valores = explode("-", $clave);
                        $indicador_estudiante = $valores[0]; // "estudiante"
                       
                        
                        $indicador_modulo = $_POST['modulo'];
                        $tarea_evaluacion_1 = $tarea_evaluacion->where_AND_AND_AND_AND('modulo',$indicador_modulo,'indicador',$indicador_indicador,'estudiante',$indicador_estudiante,'periodo',$periodo);
                        
                        //debuguear(date('Y-m-d'));
                        
                        if($tarea_evaluacion_1) {
                            $tarea_evaluacion->id = $tarea_evaluacion_1[0]->id;
                            
                        } else {
                            $tarea_evaluacion->id = null;
                            
                           
                        };
                        $tarea_evaluacion->modulo = $indicador_modulo;

                        $tarea_evaluacion->indicador = $indicador_indicador;
                        $tarea_evaluacion->tareasPuntos = $valor;
                        
                        $tarea_evaluacion->periodo = $periodo;
                        
                        $tarea_evaluacion->estudiante = $indicador_estudiante;

                        
                        $tarea_evaluacion->tareasNota = ($valor*100)/$ntarea->totalPuntosTarea;

                        $porcentaje = $ntarea->totalPorcentajeTarea / 100;
                      
                        $tarea_evaluacion->tareasPorcentaje = $tarea_evaluacion->tareasNota * $porcentaje;
                        
                        $tarea_evaluacion->observaciones = $_POST['observaciones'][$clave];
                        //debuguear($tarea_evaluacion);
                        $tarea_evaluacion->guardar();
                        
                        
                }
                    break;


                    case "t2":
                    
                        $periodo = substr($form,1);
                        $ntarea = new Tarea();
                        $tarea = $ntarea->find($_POST['id']);
                        //debuguear($tarea);
                        
                        if(!empty($tarea)) {
                            
                                $ntarea->sincronizar($tarea);
                                $indicador_indicador = $tarea->id;
                                //debuguear($ntarea);
                                $ntarea->totalPuntosTarea = $_POST['totalPuntosTarea'];
                                $ntarea->totalPorcentajeTarea = $_POST['totalPorcentajeTarea'];
                                $ntarea->evaluacion = $_POST['evaluacion'];
                                $ntarea->periodo = $periodo;
                                $ntarea->modulo = $_POST['modulo'];
                                //debuguear($ntarea);
                                //debuguear($ntarea);
                                $ntarea->guardar();
                            
                        } else {
                            
                            
                            if($_POST['cant'] == '') {
                                $ntarea->cant = '1';
                            } else {
                                $ntarea->cant = $_POST['cant'];
                            }
                                $ntarea->totalPuntosTarea = $_POST['totalPuntosTarea'];
                                $ntarea->totalPorcentajeTarea = $_POST['totalPorcentajeTarea'];
                                $ntarea->evaluacion = $_POST['evaluacion'];
                                $ntarea->modulo = $id;
                                $ntarea->periodo = $periodo;
                                
                                $ntarea->guardar();
                                
                                $indicador_indicador = $ntarea->findLast('modulo',$id);
                        }
                        
                        $tareasPuntos = $_POST['tareasPuntos'];
                        
                       
                        $tarea_evaluacion = new Tarea_evaluacion();
                        foreach ($tareasPuntos as $clave => $valor) {
                            //debuguear($_POST);
                            $valores = explode("-", $clave);
                            $indicador_estudiante = $valores[0]; // "estudiante"
                           
                            
                            $indicador_modulo = $_POST['modulo'];
                            $tarea_evaluacion_1 = $tarea_evaluacion->where_AND_AND_AND_AND('modulo',$indicador_modulo,'indicador',$indicador_indicador,'estudiante',$indicador_estudiante,'periodo',$periodo);
                            
                            //debuguear(date('Y-m-d'));
                            
                            if($tarea_evaluacion_1) {
                                $tarea_evaluacion->id = $tarea_evaluacion_1[0]->id;
                                
                            } else {
                                $tarea_evaluacion->id = null;
                                
                               
                            };
                            $tarea_evaluacion->modulo = $indicador_modulo;
    
                            $tarea_evaluacion->indicador = $indicador_indicador;
                            $tarea_evaluacion->tareasPuntos = $valor;
                            
                            $tarea_evaluacion->periodo = $periodo;
                            
                            $tarea_evaluacion->estudiante = $indicador_estudiante;
    
                            
                            $tarea_evaluacion->tareasNota = ($valor*100)/$ntarea->totalPuntosTarea;
    
                            $porcentaje = $ntarea->totalPorcentajeTarea / 100;
                          
                            $tarea_evaluacion->tareasPorcentaje = $tarea_evaluacion->tareasNota * $porcentaje;
                            
                            $tarea_evaluacion->observaciones = $_POST['observaciones'][$clave];
                            //debuguear($tarea_evaluacion);
                            $tarea_evaluacion->guardar();
                            
                            
                    }
                        break;
                    case "p1":
                        $proyecto = new Proyecto();
                        $proyecto_indicador = new Proyecto_indicador();
                        $proyecto_evaluacion = new Proyecto_evaluacion();
                        $proyecto_observacion = new Proyecto_observacion();
                        $proyecto = $proyecto->find($_POST['proyectoID']);
                        $proyecto->porcentajeTotal = $_POST['porcentajeTotal'];
                        $proyecto->guardar();
                        // debuguear($proyecto->porcentajeTotal);

                        foreach ($_POST['proyecto_indicadores'] as $p_ind => $value) {
                            $valores = explode("-", $p_ind);
                            $proyecto_indicador = $proyecto_indicador->find($valores[0]);
                            $proyecto_indicador->valor = $value;
                            $proyecto_indicador->guardar();
                            
                            
                        }


                        foreach ($estudiantes as $estudiante) {
                           
                            $proyecto_evaluacion = new Proyecto_evaluacion();
                            $proyecto_observacion = new Proyecto_observacion();
                            $encontradoP = false;
                            foreach ($_POST['proyecto_evaluacion'] as $p_eva => $value) {
                                
                                $valores = explode("-", $p_eva);
                                $proyecto_evaluacion = $proyecto_evaluacion->find($valores[0]);
                                
                                if($proyecto_evaluacion->id > 0 && $estudiante->id == $proyecto_evaluacion->estudiante) {
                                    $proyecto_evaluacion->valor = $value;
                                    $encontradoP = true;
                                    $proyecto_evaluacion->guardar();
                                }
                            }
                            if(!$encontradoP) {
                                $proyecto_evaluacion = new Proyecto_evaluacion();
                                $proyecto_observacion = new Proyecto_observacion();
                                
                                $proyecto_evaluacion->estudiante = $estudiante->id;
                                $proyecto_evaluacion->valor = '0';
                                $proyecto_evaluacion->indicador = '1';
                                $proyecto_evaluacion->modulo = $proyecto->modulo;
                                $proyecto_evaluacion->proyecto = $proyecto->id;
                               // debuguear($proyecto->id);
                                $proyecto_evaluacion->guardar();
                                $proyecto_observacion->estudiante = $estudiante->id;
                                $proyecto_observacion->valor = '';
                                $proyecto_observacion->indicador = '1';
                                $proyecto_observacion->modulo = $proyecto->modulo;
                                $proyecto_observacion->proyecto = $proyecto->id;
                                $proyecto_observacion->guardar();
                            }
                        }
                        
                        foreach ($_POST['observaciones'] as $p_obs => $value) {
                            $valores = explode("-", $p_obs);
                            //($valores);
                            $proyecto_observacion = $proyecto_observacion->find($valores[0]);
                            $proyecto_observacion->valor = $value;
                            
                            $proyecto_observacion->guardar();
                           
                            # code...
                        }
                        break;
                    case "p2":
                        $proyecto = new Proyecto();
                        $proyecto_indicador = new Proyecto_indicador();
                        $proyecto_evaluacion = new Proyecto_evaluacion();
                        $proyecto_observacion = new Proyecto_observacion();
                        $proyecto = $proyecto->find($_POST['proyectoID']);
                        $proyecto->porcentajeTotal = $_POST['porcentajeTotal'];
                        $proyecto->guardar();
                       // debuguear($proyecto->porcentajeTotal);

                        foreach ($_POST['proyecto_indicadores'] as $p_ind => $value) {
                            $valores = explode("-", $p_ind);
                            $proyecto_indicador = $proyecto_indicador->find($valores[0]);
                            $proyecto_indicador->valor = $value;
                            $proyecto_indicador->guardar();
                            
                            
                        }
                        foreach ($estudiantes as $estudiante) {
                           
                            $proyecto_evaluacion = new Proyecto_evaluacion();
                            $proyecto_observacion = new Proyecto_observacion();
                            $encontradoP = false;
                            foreach ($_POST['proyecto_evaluacion'] as $p_eva => $value) {
                                
                                $valores = explode("-", $p_eva);
                                $proyecto_evaluacion = $proyecto_evaluacion->find($valores[0]);
                                
                                if($proyecto_evaluacion->id > 0 && $estudiante->id == $proyecto_evaluacion->estudiante) {
                                    $proyecto_evaluacion->valor = $value;
                                    $encontradoP = true;
                                    $proyecto_evaluacion->guardar();
                                }
                            }
                            if(!$encontradoP) {
                                $proyecto_evaluacion = new Proyecto_evaluacion();
                                $proyecto_observacion = new Proyecto_observacion();
                                
                                $proyecto_evaluacion->estudiante = $estudiante->id;
                                $proyecto_evaluacion->valor = '0';
                                $proyecto_evaluacion->indicador = '1';
                                $proyecto_evaluacion->modulo = $proyecto->modulo;
                                $proyecto_evaluacion->proyecto = $proyecto->id;
                               // debuguear($proyecto->id);
                                $proyecto_evaluacion->guardar();
                                $proyecto_observacion->estudiante = $estudiante->id;
                                $proyecto_observacion->valor = '';
                                $proyecto_observacion->indicador = '1';
                                $proyecto_observacion->modulo = $proyecto->modulo;
                                $proyecto_observacion->proyecto = $proyecto->id;
                                $proyecto_observacion->guardar();
                            }
                        }
                        foreach ($_POST['observaciones'] as $p_obs => $value) {
                            $valores = explode("-", $p_obs);
                            //($valores);
                            $proyecto_observacion = $proyecto_observacion->find($valores[0]);
                            $proyecto_observacion->valor = $value;
                            
                            $proyecto_observacion->guardar();
                           
                            # code...
                        }
                        break;
                    case "ap1":
                        $proyecto = new Proyecto($_POST);
                        $proyecto_indicador = new Proyecto_indicador();
                        $proyecto_evaluacion = new Proyecto_evaluacion();
                        $proyecto_observacion = new Proyecto_observacion();
                        $proyecto->guardar();
                        $lastProject = $proyecto->findLast('modulo',$modulo->id);
                        $proyecto_indicador->proyecto = $lastProject->id;
                        $proyecto_indicador->valor = '1-';
                        $proyecto_indicador->modulo = $modulo->id;
                        $proyecto_indicador->indicador = '1';
                        $proyecto_indicador->guardar();
                        foreach ($estudiantes as $estudiante) {
                            $proyecto_evaluacion->estudiante = $estudiante->id;
                            $proyecto_evaluacion->valor = '0';
                            $proyecto_evaluacion->indicador = '1';
                            $proyecto_evaluacion->modulo = $modulo->id;
                            $proyecto_evaluacion->proyecto = $lastProject->id;
                            $proyecto_evaluacion->guardar();
                            $proyecto_observacion->estudiante = $estudiante->id;
                            $proyecto_observacion->valor = '';
                            $proyecto_observacion->indicador = '1';
                            $proyecto_observacion->modulo = $modulo->id;
                            $proyecto_observacion->proyecto = $lastProject->id;
                            $proyecto_observacion->guardar();
                        }
                        break;
                    case "ap2":
                        $proyecto = new Proyecto($_POST);
                      //  debuguear($proyecto);
                        $proyecto_indicador = new Proyecto_indicador();
                        $proyecto_evaluacion = new Proyecto_evaluacion();
                        $proyecto_observacion = new Proyecto_observacion();
                        $proyecto->guardar();
                        $lastProject = $proyecto->findLast('modulo',$modulo->id);
                        $proyecto_indicador->proyecto = $lastProject->id;
                        $proyecto_indicador->valor = '1-';
                        $proyecto_indicador->modulo = $modulo->id;
                        $proyecto_indicador->indicador = '1';
                        $proyecto_indicador->guardar();
                        foreach ($estudiantes as $estudiante) {
                            $proyecto_evaluacion->estudiante = $estudiante->id;
                            $proyecto_evaluacion->valor = '0';
                            $proyecto_evaluacion->indicador = '1';
                            $proyecto_evaluacion->modulo = $modulo->id;
                            $proyecto_evaluacion->proyecto = $lastProject->id;
                            $proyecto_evaluacion->guardar();
                            $proyecto_observacion->estudiante = $estudiante->id;
                            $proyecto_observacion->valor = '';
                            $proyecto_observacion->indicador = '1';
                            $proyecto_observacion->modulo = $modulo->id;
                            $proyecto_observacion->proyecto = $lastProject->id;
                            $proyecto_observacion->guardar();
                        }
                        break;
                        case "cm1":
                            $coment = new Profesor_comentarios();
                          
                            
                            foreach ($_POST['comentarios'] as $key => $value) {
                                $comentariosEncontrado = $coment->where_AND_AND('modulo',$_POST['modulo'],'periodo',$_POST['periodo'],'estudiante',$key);
                                if($comentariosEncontrado) {
                                    foreach ($comentariosEncontrado as $comentItem) {
                                        $coment->sincronizar($comentItem);
                                        $coment->comentario = $value;
                                        $coment->guardar();
                                    }
                                } else {
                                    $coment->modulo = $_POST['modulo'];
                                    $coment->periodo = $_POST['periodo'];
                                    $coment->estudiante = $key;
                                    $coment->comentario = $value;
                                    $coment->guardar();
                                   // debuguear($coment->estudiante);
                                }
                            }
                            

                            
                        break;
                default:
                    echo "Your favorite color is neither red, blue, nor green!";
                    }
                }

                $evaluacion = Cotidiano_evaluacion::findGroup('modulo',$id);
                $asistencia_evaluacion = Asistencia_evaluacion::findGroup('modulo',$id);
                $examenes = Examen_evaluacion::findGroup('modulo',$id);
                $cotidiano = Cotidiano::findGroup('moduloID',$id);
                $asistencia = Asistencia::findGroup('moduloID',$id);
                $tareas = Tarea::findGroup('modulo',$id);
                $tareas_evaluacion = Tarea_evaluacion::findGroup('modulo',$id);
                $asistencia_fechas = Asistencia_evaluacion::findDate($asistencia_evaluacion);
                $proyectos = Proyecto::findGroup('modulo',$id);
                $proyecto_indicadores = Proyecto_indicador::findGroup('modulo',$id);
                $proyecto_evaluaciones = Proyecto_evaluacion::findGroup('modulo',$id);
                $proyecto_observaciones = Proyecto_observacion::findGroup('modulo',$id);
                $comentarios = Profesor_comentarios::findGroup('modulo',$id);
                //debuguear($proyecto_observaciones);
                //debuguear($proyecto_indicadores);
            $router->render('dashboard/teacher-module', [
                'titulo' => $titulo,
                'modulo' => $modulo,
                'grupo' => $grupo,
                'horario' => $horario,
                'estudiantes' => $estudiantes,
                'cotidiano' => $cotidiano,
                'indicadores' => $indicadores,
                'evaluacion' => $evaluacion,
                'tareas' => $tareas,
                'tareas_evaluacion' => $tareas_evaluacion,
                'examenes' => $examenes,
                'asistencia' => $asistencia,
                'proyectos' => $proyectos,
                'proyecto_indicadores' => $proyecto_indicadores,
                'proyecto_evaluaciones' => $proyecto_evaluaciones,
                'proyecto_observaciones' => $proyecto_observaciones,
                'asistencia_evaluacion' => $asistencia_evaluacion,
                'asistencia_fechas' => $asistencia_fechas,
                'comentarios' => $comentarios

            // 'proyectos' => $proyectos 
        ]); 
    }

    public static function index(Router $router) {
        
        session_start();
        isAuth();
        $modulos = Modulo::findGroup('profesorID',$_SESSION['profesorID']);
        $grupos = Grupo::all();
        
        /*

        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);
*/
        
        $router->render('dashboard/teacher-dashboard', [
            'titulo' => 'Secciones',
            'modulos' => $modulos,
            'grupos' => $grupos
            // 'proyectos' => $proyectos 
        ]); 
    }
    public static function evaluation_report() {
       
        $modulos = Modulo::findGroup('profesorID',$_SESSION['profesorID']);
        $grupos = Grupo::all();
        $estudiante = new Estudiante();
        $id = $_POST['estudiante'];
        
        $estudiante->crearPDFReporte($id);

     //   debuguear($_SERVER['QUERY_STRING']);
       
       // header('Location: /'.'teacher-dashboard-module?'.$_SERVER['QUERY_STRING']);
        
    }
   

    public static function agregar_foro(Router $router) {
        session_start();
       // debuguear($_SESSION);
        isAuth();
       
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($_POST['items'] && $_POST['titulo'] != '') {
                $foro = new Foros();
                $foroEnlaces = new Foro_enlace();
                $foroImages = new Foro_images();
                $foroItems = new Foro_items();
                $foro->profesor = $_SESSION['profesorID'];
                $foro->periodo = '1';
                $foro->year = date("Y");
                $foro->icon_img = $_POST['icon'];
                $foro->titulo = $_POST['titulo'];
                $foro->categoria = $_POST['categoria'];
                $foro->guardar();
                $lastForumID = $foro->findLastForum()[0]->id;
                $items = $_POST['items'];
                //debuguear($items);
                foreach ($items as $key => $value) {
                    
                    $variables = explode('-', $key);
                    
                    if($variables[0] == 'at') {
                        $enlace = $items['a-'.$variables[1]];
                        $titulo = $value;
                        $foroEnlaces->foro_id = $lastForumID;
                        $foroEnlaces->titulo = $titulo;
                        $foroEnlaces->enlace = $enlace;
                        $foroEnlaces->ind = $variables[1];
                        $foroEnlaces->guardar();
                        //  debuguear($foroEnlaces);
                    } else if($variables[0] == 'h1' || $variables[0] == 'h2' || $variables[0] == 'h3' || 
                        $variables[0] == 'h4' || $variables[0] == 'p') {
                        $foroItems->foro_id = $lastForumID;
                        $foroItems->texto = $value;
                        $foroItems->ind = $variables[1];
                        $foroItems->clase = $variables[0];
                        $foroItems->guardar();
                        //debuguear($foroItems);
                    }
                     else if($variables[0] == 'img') {

                         $images = $_POST['images'];
                         //debuguear($images['width-'.$variables[1]]);
                         $width = $images['width-'.$variables[1]];
                         $height = $images['height-'.$variables[1]];
                        $foroImages->foro_id = $lastForumID;
                        $foroImages->url = $value;
                        $foroImages->ind = $variables[1];
                        
                        $foroImages->clase = $variables[0];
                        $foroImages->height = $width;
                        $foroImages->width = $height;
                        $foroImages->guardar();
                        //debuguear($foroItems);
                    }
                }
            }
            
        }
        
        /*

        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);
*/
        $router->render('dashboard/teacher-forum-add', [
            'titulo' => 'Agregar Foro',
            // 'proyectos' => $proyectos 
        ]); 
    }
    public static function foros(Router $router) {
        session_start();
        isAuth();
        $foros = Foros::all('profesor',$_SESSION['profesorID']);
        $mis_foros = $_SESSION['profesorID'];
     //   debuguear($foros);
        $foros_items = Foro_items::all();
        $foros_enlaces = Foro_enlace::all();
        $foros_images = Foro_images::all();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($_POST['type'] != null) {
                $phrase = $_POST['search'];
                
                if($phrase != '') {
                    $foros = Foros::findForo($phrase);
                    
                } else {}
            } else {
                $id = base64_decode($_POST['id']);
                $foro = Foros::find($id);
                $foro_enlaces = Foro_enlace::findGroup('foro_id',$id);
                $foro_items = Foro_items::findGroup('foro_id',$id);
                foreach ($foro_enlaces as $item) {
                    $item->eliminar();
                }
                foreach ($foro_items as $item) {
                    $item->eliminar();
                }
                $foro->eliminar();
                header('Location: /teacher-public-repository?code=246');
            }
        }
        $router->render('dashboard/teacher-public-repository', [
            'titulo' => 'Foros',
            'foros' => $foros,
            'foros_items' => $foros_items,
            'foros_enlaces' => $foros_enlaces,
            'mis_foros' => $mis_foros,
            'foros_images' => $foros_images,
            'phrase' => $phrase
            // 'proyectos' => $proyectos 
        ]);
    }

    public static function teacher_news(Router $router) {
        session_start();
        isAuth();
        $noticias = Noticias::all();
        /*

        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);
*/
        $router->render('dashboard/teacher-news', [
            'titulo' => 'Noticias',
            'noticias' => $noticias,
            // 'proyectos' => $proyectos 
        ]); 
    }
    public static function abrir_foro(Router $router) {
        session_start();
       // debuguear($_SESSION);
        isAuth();
        $id = base64_decode($_GET['aWQ']);
        $foros = Foros::find($id);
        $foros_items = Foro_items::findGroup('foro_id',$id);
        
        $foros_enlaces = Foro_enlace::findGroup('foro_id',$id);
        $foros_images = Foro_images::findGroup('foro_id',$id);


         // debuguear($foros_images);

        $router->render('dashboard/teacher-forum', [
            'titulo' => 'Foro',
            'foros' => $foros,
            'foros_items' => $foros_items,
            'foros_enlaces' => $foros_enlaces,
            'foros_images' => $foros_images,
            // 'proyectos' => $proyectos 
        ]);
    }
}