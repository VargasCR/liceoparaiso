<?php

namespace Controllers;
use Model\Ajuste;
use Model\Asistencia;
use Model\Asistencia_beca;
use Model\Asistencia_evaluacion;
use Model\Cotidiano;
use Model\Cotidiano_evaluacion;
use Model\Estudiante;
use Model\Grupo;
use Model\Horario;
use Model\Modulo;
use Model\Profesor;
use Model\Proyecto;
use Model\Proyecto_evaluacion;
use Model\Proyecto_indicador;
use Model\Proyecto_observacion;
use Model\Tarea;
use Model\Tarea_evaluacion;

class ApiController {
    public static function encontrar_estudiantes() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $search_word = $_POST['search'];
            $search_seccion = $_POST['searchseccion'];
           // $tarea->proyectoId = $proyecto->id;
    if($search_word =='null') {
        $search_word = '';
    }
    if($search_seccion =='null') {
        $search_seccion = '';
    }
            $grupos = Grupo::all();
                $resultado = Estudiante::findStudent($search_word,$search_seccion);
    
            
            
                echo json_encode(['informacion' => $resultado,'grupos' => $grupos
            ]);
        }
        
        }


    public static function encontrar_estudiantes_seleccionados() {
       // if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $grupos = Grupo::all();
            $resultado = Estudiante::findStudentIN($id);
          //  $estudiante = new Estudiante($_POST);
        //    $resultado = $estudiante->eliminar();
        echo json_encode(['informacion' => $resultado,'grupos' => $grupos
    ]);
    //    }
    }
    public static function encontrar_profesores() {
    
            $resultado = Profesor::all();
          //  $estudiante = new Estudiante($_POST);
        //    $resultado = $estudiante->eliminar();
            echo json_encode($resultado);
    //    }
    }

    public static function eliminar_estudiante_seleccionado() {
        // debuguear($id);
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $estudiante = new Estudiante();
            $resultado = $estudiante->eliminar_seleccionados($id);
            echo json_encode($resultado);
        }
    }
    public static function eliminar_profesor_seleccionado() {
        // debuguear($id);
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $profesor = new Profesor();
            $profesor->id = $id;
            $resultado = $profesor->eliminar();
            echo json_encode($resultado);
        }
    }
    public static function eliminar_estudiante_todos() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $estudiante = new Estudiante();
            $resultado = $estudiante->eliminar_todos();
            echo json_encode($resultado);
        }
    }
    public static function eliminar_seccion() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $estudiantes = Estudiante::findGroup('seccion',$id);

            
            if(count($estudiantes) > 0) {
                echo json_encode('estudiante');
                
                
            } else {
                $grupo = Grupo::find($id);
                $horarios = Horario::findGroup('grupoID',$id);
                $modulos = Modulo::findGroup('grupoID',$id);
                foreach ($horarios as $horario) {
                    $horario->eliminar();
                }
                foreach ($modulos as $modelo) {
                    $modelo->eliminar();
                }
                $resultado = $grupo->eliminar();
                echo json_encode($resultado);
                
            }
            
            
        }

    }
    public static function eliminar_estudiante() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $estudiante = new Estudiante($_POST);
            $resultado = $estudiante->eliminar();
            echo json_encode($resultado);
        }

    }
    public static function download_carnet_all() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $id = $_POST['id'];

            $estudiante = new Estudiante();
            $resultado = $estudiante->crearPDF($id);
         //   $resultado = $estudiante->downloadPDF($name);
            echo json_encode($resultado);
        }

    }
    public static function download_list_all() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $id = $_POST['id'];

            $estudiante = new Estudiante();
            $resultado = $estudiante->crearPDFList($id);
         //   $resultado = $estudiante->downloadPDF($name);
            echo json_encode($resultado);
        }
    }

 public static function download_list_selected() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $estudiante = new Estudiante();
            $resultado = $estudiante->crearPDFList($id);
         //   $resultado = $estudiante->downloadPDF($name);
            echo json_encode($resultado);
        }

    }
 public static function download_carnet_selected() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $id = $_POST['id'];

            $estudiante = new Estudiante();
            $resultado = $estudiante->crearPDF($id);
         //   $resultado = $estudiante->downloadPDF($name);
            echo json_encode($resultado);
        }

    }
 public static function agregar_asistencia_beca_qr() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $id = $_POST['id'];
            $estudiante = new Estudiante();
            $estudiante_actual = $estudiante->find($id);
            if($estudiante_actual->comedor == '1' || $estudiante_actual->transporte == '1') {
                $Asistencia_beca = new Asistencia_beca();
                $existe = $Asistencia_beca->where('estudianteID',$id);
                if ($existe) {
                    echo json_encode('repetido');
                    return;
                } else {
                    
                    $fechaActual = date('Y-m-d');
                    $Asistencia_beca->fecha = $fechaActual;
                    $Asistencia_beca->estudianteID = $id;
                    $resultado = $Asistencia_beca->guardar();
                    echo json_encode($resultado);
                    return;
                }
            } else {
                echo json_encode('nobeca');
            }
            
            
         //   echo json_encode($resultado);
         //   $resultado = $estudiante->downloadPDF($name);
        }

    }
    public static function agregar_asistencia_beca() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $id = $_POST['id'];
            $array = explode(',', $id);
            $estudiante = new Estudiante();
            $response = [];
    
            foreach ($array as $element) {
                // Realiza las operaciones deseadas con cada elemento
                $estudiante_actual = $estudiante->find($element);
    
                if ($estudiante_actual->comedor == '1' || $estudiante_actual->transporte == '1') {
                    $Asistencia_beca = new Asistencia_beca();
                    $fechaActual = date('Y-m-d');
                    $existe = $Asistencia_beca->where_AND('estudianteID', $element,'fecha',$fechaActual);
    
                    if ($existe) {
                        $response[$element] = $estudiante_actual->nombre . ' ' . $estudiante_actual->apellido.' ya había sido registrado.';;
                    } else {
                        $fechaActual = date('Y-m-d');
                        $Asistencia_beca->fecha = $fechaActual;
                        $Asistencia_beca->estudianteID = $element;
                        $resultado = $Asistencia_beca->guardar();
                        if($resultado) {
                            $response[$element] = "Se agregó a ".$estudiante_actual->nombre . ' ' . $estudiante_actual->apellido.'.';

                        } else {
                            $response[$element] = "Error al agregar a ".$estudiante_actual->nombre . ' ' . $estudiante_actual->apellido.'.';
                        }
                    }
                } else {
                    $response[$element] = "El estudiante ". $estudiante_actual->nombre . ' ' . $estudiante_actual->apellido . ' no está becado.';
                }
            }
    
            echo json_encode($response);
        }
    }
    public static function add_indicador() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
         
            $value = $_POST['moduloID'];
            $type = $_POST['type'];
            $periodo = $_POST['periodo'];
            $clase = $_POST['clase'];

            switch ($clase) {
                case 0:
                  
            $cotidiano = new Cotidiano();
            $array = $cotidiano->where_AND('moduloID',$value,'periodo',$periodo);
            $cotidiano->sincronizar($array[0]);
           
          
            if($type == 0) {
                $cant = $cotidiano->totalIndicadores + 1;
                
            } else {
                $cant = $cotidiano->totalIndicadores - 1;
                
                $evaluacion = Cotidiano_evaluacion::where_AND('modulo',$value,'indicador',$cotidiano->totalIndicadores - 1);
                if($evaluacion) {
                    foreach ($evaluacion as $element) {
                        $element->eliminar();
                    }
                }
                if($cant < 1) {
                    $cant = 1;
                }
            }
            $cotidiano->totalIndicadores = $cant;
            
            $cotidiano->guardar();
            echo json_encode($cotidiano);
                  break;
                case 1:
      
                    $asistencia = new Asistencia();
                    $array = $asistencia->where_AND('moduloID',$value,'periodo',$periodo);
                    $asistencia->sincronizar($array[0]);
                   
                  
                    if($type == 0) {
                        $cant = $asistencia->totalIndicadores + 1;
                        
                    } else {
                        $cant = $asistencia->totalIndicadores - 1;
                        
                        $evaluacion = Asistencia_evaluacion::where_AND('modulo',$value,'indicador',$asistencia->totalIndicadores - 1);
                        if($evaluacion) {
                            foreach ($evaluacion as $element) {
                                $element->eliminar();
                            }
                        }
                        if($cant < 1) {
                            $cant = 1;
                        }
                    }
                    $asistencia->totalIndicadores = $cant;
                    
                    $asistencia->guardar();
                    echo json_encode($asistencia);
                 
                  break;
                case "green":
                  echo "Your favorite color is green!";
                  break;
                default:
                  echo "Your favorite color is neither red, blue, nor green!";
              }

    }
}
    

    public static function set_searching() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $id = $_SESSION['id'];
            $value = $_POST['value'];
            $ajuste = new Ajuste();
            $resultado = $ajuste->visibilidadSearchingbar($id,$value);
         //   $resultado = $estudiante->downloadPDF($name);
            echo json_encode($resultado);
        }

    }



    public static function eliminar_tarea() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $tarea_evaluacion = Tarea_evaluacion::findGroup('indicador',$id);

            
            if(!empty($tarea_evaluacion)) {
                foreach ($tarea_evaluacion as $item) {
                    $item->eliminar();
            }
                
                
            }

            $tarea = Tarea::find($id);
            if($tarea) {
                $resultado = $tarea->eliminar();
            }
                echo json_encode($resultado);
                
            }
            
            
        }


        public static function agregar_tarea() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $modulo = $_POST['modulo'];
                    $periodo = $_POST['periodo'];
                    $tarea = new Tarea();
                    $tarea->modulo = $modulo;
                    $tarea->periodo = $periodo;
                    $tarea->totalPuntosTarea = 1;
                    $tarea->totalPorcentajeTarea = 1;
                    $tarea->cant = 1;
                    $resultado = $tarea->guardar();
                    echo json_encode($resultado);
                    
                }
                
                
            }
        public static function borrar_proyecto() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $id = $_POST['id'];
                    $proyecto = Proyecto::findGroup('id',$id);
                    $proyecto_indicadores = Proyecto_indicador::findGroup('proyecto',$id);

                    $result = true;
                    $proyecto_evaluaciones = Proyecto_evaluacion::findGroup('proyecto',$id);
                    $proyecto_observaciones = Proyecto_observacion::findGroup('proyecto',$id);
                   
                    if(!empty($proyecto_indicadores)) {
                        foreach ($proyecto_indicadores as $item) {
                            $result = $item->eliminar();
                            if(!$result) {
                                echo json_encode($result);    
                                return;
                            }
                        }
                    }
                    if(!empty($proyecto_evaluaciones)) {
                        foreach ($proyecto_evaluaciones as $item) {
                            $result = $item->eliminar();
                            if(!$result) {
                                echo json_encode($result);
                                return;
                            }
                    }
                }
                    if(!empty($proyecto_observaciones)) {
                        foreach ($proyecto_observaciones as $item) {
                            $result = $item->eliminar();
                            if(!$result) {
                                echo json_encode($result);
                                return;
                            }
                    }
                }

                    if(!empty($proyecto)) {
                        foreach ($proyecto as $item) {
                            $result = $item->eliminar();
                            if(!$result) {
                                echo json_encode($result);
                                return;
                            }
                        }
                    
                        
                    }
                    echo json_encode($result);
                }
            }

        public static function agregar_indicador_proyecto() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $proyecto = new Proyecto();
                $proyecto = $proyecto->find($_POST['id']);
                $modulo = Modulo::find($_POST['modulo']);
                $estudiantes = Estudiante::findGroup('seccion',$modulo->grupoID);
                $resultado = false;
                if($_POST['tipo'] === '1') {
                    $proyecto->indicadores = intval($proyecto->indicadores) + 1;
                    $proyecto->guardar();
                    $proyecto_indicador = new Proyecto_indicador();
                    $proyecto_indicador->proyecto = $_POST['id'];
                    $proyecto_indicador->valor = $proyecto->indicadores.'-';
                    $proyecto_indicador->indicador = $proyecto->indicadores;
                    $proyecto_indicador->modulo = $_POST['modulo'];
                    $proyecto_indicador->guardar();
                    $proyecto_evaluacion = new Proyecto_evaluacion();
                    foreach ($estudiantes as $estudiante) {
                        $proyecto_evaluacion->estudiante = $estudiante->id;
                        $proyecto_evaluacion->valor = '0';
                        $proyecto_evaluacion->indicador = $proyecto->indicadores;
                        $proyecto_evaluacion->modulo = $modulo->id;
                        $proyecto_evaluacion->proyecto = $_POST['id'];
                        $proyecto_evaluacion->guardar();
                    }
                    $resultado = true;
                } else {
                    if(intval($proyecto->indicadores) > 1) {
                        $proyecto_indicador = new Proyecto_indicador();
                        $proyecto_indicador_array = Proyecto_indicador::where_AND('proyecto',$_POST['id'],'indicador',$_POST['cant']);
                        $proyecto_indicador->sincronizar($proyecto_indicador_array[0]);
                        
                        $proyecto_evaluacion = new Proyecto_evaluacion();
                        $proyecto_evaluacion = $proyecto_evaluacion->where_AND('indicador',$_POST['cant'],'proyecto',$proyecto_indicador->proyecto);
                        foreach ($proyecto_evaluacion as $item) {
                            $item->eliminar();
                        }
                        $proyecto_indicador->eliminar();
                        $proyecto->indicadores = intval($proyecto->indicadores) - 1;
                        $proyecto->guardar();
                        $resultado = true;
                    }
                }
                echo json_encode($resultado);
            }
        }

    }

