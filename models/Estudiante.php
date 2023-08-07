<?php


namespace Model;

use Model\ActiveRecord;
use setasign\Fpdi\Fpdi;
use Intervention\Image\ImageManagerStatic as Image;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;

use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use FPDF;

class Estudiante extends ActiveRecord {
    protected static $tabla = 'estudiantes';
    protected static $columnasDB = ['id', 'dni', 'nombre','apellido','transporte','seccion','comedor','ruta','asiento'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->dni = $args['dni'] ?? 0;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->seccion = $args['seccion'] ?? '';
        $this->comedor = $args['comedor'] ?? 0;
        $this->transporte = $args['transporte'] ?? 0;
        $this->ruta = $args['ruta'] ?? -1;
        $this->asiento = $args['asiento'] ?? -1;
    }

    public function validarEstudiante() {
        if(!$this->dni) {
            self::$alertas['error'][] = 'El DNI del Estudiante es Obligatorio';
        }
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre del Estudiante es Obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El apellido del Estudiante es Obligatorio';
        }
        if(!$this->seccion) {
            self::$alertas['error'][] = 'Seleccione una seccion';
        }

        if ($this->comedor == '0') {
            $this->comedor = 0;
        } else {
            if($this->comedor === 'on') {
                $this->comedor = 1;
            } else {$this->comedor = 0;}
        }
        if($this->ruta == '0') {
            $this->ruta = 0;
        }
        if($this->asiento == '0') {
            $this->asiento = 0;
        }
        if ($this->transporte == '0') {
            $this->transporte = 0;
            $this->ruta = 0;
            $this->asiento = 0;
        } else {
            if($this->transporte === 'on') {
                $this->transporte = 1;
            } else {$this->transporte = 0;}
        }
        return self::$alertas;
    }
   

    public function crearCarnet($e,$g) {
        $ruta = '';
        $ruta_0 = $e->ruta;
        $ruta_1 = strlen($ruta_0);
        switch ($ruta_1) {
            case 1:
                # code...
                $ruta = '00'.$ruta_0;
                break;
                case 2:
                    # code...
                    $ruta = '0'.$ruta_0;
                    break;
                    
                    default:
                    # code...
                    $ruta = ''.$ruta_0;
                break;
        }
        $asiento = '';
        $asiento_0 = $e->asiento;
        $asiento_1 = strlen($asiento_0);
        switch ($asiento_1) {
            case 1:
                # code...
                $asiento = '00'.$asiento_0;
                break;
                case 2:
                    # code...
                    $asiento = '0'.$asiento_0;
                    break;
                    
                    default:
                    # code...
                    $asiento = ''.$asiento_0;
                break;
        }


        $imagenFondoURL = CARNET_BASE_IMAGE_FOLDER.'carnet_base.png';
        $imagenFotoURL = IMAGE_FOLDER.$e->id.'.jpg';
        $imagenQRURL = QR_IMAGE_FOLDER.$e->id.'.png';

        $nombre = $e->nombre . ' ' . $e->apellido;
        $dni = $e->dni;
        $seccion = 'x - x';
        
        foreach ($g as $grupo) {
            if ($grupo->id == $e->seccion) {
                $seccion = $grupo->grado . ' - ' . $grupo->seccion;
                break;
            }
        }


       
        $beca = 'C'. $e->comedor . ':T' . $e->transporte . ':R' . $ruta . ':A' .$asiento;
    
        $imagenFondo = Image::make($imagenFondoURL);
        $imagenFoto = Image::make($imagenFotoURL);
        $imagenQR = Image::make($imagenQRURL);

        $imagenFoto->fit(268, 376); // Ajusta la foto al tamaño 200x200 (puedes ajustarlo según tus necesidades)
        $imagenFondo->insert($imagenFoto, 'top-left',50,60); // Inserta la foto en el centro de la imagen de fondo
        
        $imagenQR->fit(200, 200); // Ajusta la foto al tamaño 200x200 (puedes ajustarlo según tus necesidades)
        $imagenFondo->insert($imagenQR, 'bottom-right',30,50); // Inserta la foto en el centro de la imagen de fondo
    
        $x = $imagenFondo->width() / 2;
    //    $x = 400;
        $y = $imagenFondo->height() - 50;

 
        //debuguear(strlen($nombre));
        $imagenFondo->text($nombre, 50, 500, function ($font) {
            $font->file('C:\Users\Vargas\Desktop\TCU\App\public\build\OpenSans-Bold.TTF'); // Ruta a una fuente de texto (.ttf) que desees utilizar
            $font->size(30); // Tamaño de la fuente (puedes ajustarlo según tus necesidades)
            $font->color('#000000'); // Color del texto (en este caso, negro)
            $font->align('left'); // Alineación del texto (en este caso, centrado)
            $font->valign('left'); // Alineación vertical del texto (en este caso, abajo)
           // $font->width(376); // Ancho máximo del texto (ajusta el valor según tus necesidades)
        });
      
        //debuguear(strlen($nombre));
        $imagenFondo->text($dni, 50, 550, function ($font) {
            $font->file('C:\Users\Vargas\Desktop\TCU\App\public\build\OpenSans-Bold.TTF'); // Ruta a una fuente de texto (.ttf) que desees utilizar
            $font->size(24); // Tamaño de la fuente (puedes ajustarlo según tus necesidades)
            $font->color('#000000'); // Color del texto (en este caso, negro)
            $font->align('left'); // Alineación del texto (en este caso, centrado)
            $font->valign('left'); // Alineación vertical del texto (en este caso, abajo)
           // $font->width(376); // Ancho máximo del texto (ajusta el valor según tus necesidades)
        });
       
        //debuguear(strlen($nombre));
        $imagenFondo->text($seccion, 50, 600, function ($font) {
            $font->file('C:\Users\Vargas\Desktop\TCU\App\public\build\OpenSans-Bold.TTF'); // Ruta a una fuente de texto (.ttf) que desees utilizar
            $font->size(24); // Tamaño de la fuente (puedes ajustarlo según tus necesidades)
            $font->color('#000000'); // Color del texto (en este caso, negro)
            $font->align('left'); // Alineación del texto (en este caso, centrado)
            $font->valign('left'); // Alineación vertical del texto (en este caso, abajo)
           // $font->width(376); // Ancho máximo del texto (ajusta el valor según tus necesidades)
        });
        //debuguear(strlen($nombre));
        $imagenFondo->text($beca, 795, 685, function ($font) {
            $font->file('C:\Users\Vargas\Desktop\TCU\App\public\build\OpenSans-Bold.TTF'); // Ruta a una fuente de texto (.ttf) que desees utilizar
            $font->size(24); // Tamaño de la fuente (puedes ajustarlo según tus necesidades)
            $font->color('#000000'); // Color del texto (en este caso, negro)
            $font->align('bottom-right'); // Alineación del texto (en este caso, centrado)
            $font->valign('bottom-right'); // Alineación vertical del texto (en este caso, abajo)
           // $font->width(376); // Ancho máximo del texto (ajusta el valor según tus necesidades)
        });
        $fecha = '2023';
        //debuguear(strlen($nombre));
        $imagenFondo->text($fecha, 740, 285, function ($font) {
            $font->file('C:\Users\Vargas\Desktop\TCU\App\public\build\OpenSans-Bold.TTF'); // Ruta a una fuente de texto (.ttf) que desees utilizar
            $font->size(24); // Tamaño de la fuente (puedes ajustarlo según tus necesidades)
            $font->color('#000000'); // Color del texto (en este caso, negro)
            $font->align('bottom-right'); // Alineación del texto (en este caso, centrado)
            $font->valign('bottom-right'); // Alineación vertical del texto (en este caso, abajo)
           // $font->width(376); // Ancho máximo del texto (ajusta el valor según tus necesidades)
        });
    
        $carnetPath = CARNET_IMAGE_FOLDER.$e->id.'.jpg';
        $imagenFondo->save($carnetPath);
    
        //return $carnetPath;
    }


    public function crearQR($id) {
        $writer = new PngWriter();
        // Create QR code
        $cadena = $id;
        $qrCode = QrCode::create($cadena)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(2)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
            // Create generic logo
            //$logo = Logo::create(__DIR__.'/assets/symfony.png')
            //  ->setResizeToWidth(50);
            // Create generic label
            //$label = Label::create('Label')
            //  ->setTextColor(new Color(255, 0, 0));
        $result = $writer->write($qrCode);
        // Save it to a file
        $result->saveToFile(QR_IMAGE_FOLDER.$id.'.png');
        //header('Content-Type: '.$result->getMimeType());
        //echo $result->getString();
    }

    
    public function crearPDF($id) {
        if ($id == 'all') {
            $all = self::all();
            
        } else {
            $all = self::findStudentIN($id);

        }
            $i = 1;
            $w = 95;
            $h = 55;
            $wp = 0;
            $hp = 0;
            // Crear un nuevo objeto Fpdi
            $pdf = new Fpdi();
            // Agregar una página al PDF
            $pdf->AddPage('P','letter');
            foreach ($all as $objeto) {
                if($i == 0) {
                    $i++;
                    $pdf->AddPage('P','letter');
                }
                 // Ruta de la imagen PNG
                 $rutaImagen = CARNET_IMAGE_FOLDER.$objeto->id.'.jpg';
                    // Insertar la imagen en el PDF
                $pdf->Image($rutaImagen, $wp, $hp, $w, $h, '', '');

                //  $pdf->Image($rutaImagen, 100, $h*$i+1, $w, $h, '', '');
                if( $wp == 0) {
                    $wp = 100;
                } else {
                    $hp = ($h*$i)+1;
                    $wp = 0;
                    $i++;
                    if($i == 6) {
                        $wp = 0;
                        $hp = 0;
                        $i = 0;
                    }
                }
                
              //  return $i;
            }
            $filename = uniqid();
            // Guardar el PDF en un archivo
            $rutaPDF = CARNET_PDF_FOLDER.$filename.'.pdf';
            $pdf->Output($rutaPDF, 'F');
            $url = 'http://localhost:3000/build/img/carnet/pdf/'.$filename.'.pdf';
            return $url;
    }
       
    public function crearPDFList($id) {
        if ($id == 'all') {
            $all = self::all();
        } else {
            $all = self::findStudentIN($id);
        }
        
        $i = 1;
        $w = 95;
        $h = 55;
        $wp = 0;
        $hp = 0;
        
        // Crear un nuevo objeto Fpdi
        $pdf = new Fpdi();
        $pdf->SetFont('Arial', '', 10);
        
        // Agregar una página al PDF
        $pdf->AddPage('P','letter');
        
        foreach ($all as $objeto) {
            if ($i == 0) {
                $i++;
                $pdf->AddPage('P','letter');
            }
            
            // Ruta de la imagen PNG
            
            // Insertar el texto en el PDF
            $texto = $objeto->dni.' - '.$objeto->nombre . ' ' . $objeto->apellido;
            $pdf->MultiCell(0, 10, $texto);
            
            if ($wp == 0) {
                $wp = 100;
            } else {
                $hp = ($h*$i)+1;
                $wp = 0;
                $i++;
                if ($i == 6) {
                    $wp = 0;
                    $hp = 0;
                    $i = 0;
                }
            }
        }
        
        $filename = uniqid();
            // Guardar el PDF en un archivo
            $rutaPDF = REPORT_BASE_FOLDER.$filename.'.pdf';
            $pdf->Output($rutaPDF, 'F');
            $url = 'http://localhost:3000/build/report/'.$filename.'.pdf';
            return $url;
        
        // Esperar 5 segundos
     
        
       
    }
    public function crearPDFReporte($id) {
       
            $student = self::find($id);
            $grupos = Grupo::all();
            $grupo = '';
            $moduloID = base64_decode($_GET['id']);
            $periodo = base64_decode($_GET['periodo']);
            $cotidiano = Cotidiano::where_AND('moduloID',$moduloID,'periodo',$periodo)[0];
            $cotidiano_evaluacion = Cotidiano_evaluacion::where_AND_AND('estudiante_id',$id,'periodo',$periodo,'modulo',$moduloID);
            $tareas = Tarea::where_AND('modulo',$moduloID,'periodo',$periodo);
            $examenes = Examen_evaluacion::where_AND_AND('modulo',$moduloID,'periodo',$periodo,'estudiante_id',$id);
            $asistencia_evaluacion = Asistencia_evaluacion::where_AND_AND('modulo',$moduloID,'periodo',$periodo,'estudiante_id',$id);
            $asistencia = Asistencia::where_AND('moduloID',$moduloID,'periodo',$periodo)[0];
            $proyecto = Proyecto::where_AND('modulo',$moduloID,'periodo',$periodo)[0];
            $proyecto_observacion = Proyecto_observacion::where_AND('proyecto',$proyecto->id,'estudiante',$id)[0];
            $proyecto_evaluacion = Proyecto_evaluacion::where_AND('proyecto',$proyecto->id,'estudiante',$id);
            $comentarios = Profesor_comentarios::where_AND_AND('modulo',$moduloID,'estudiante',$id,'periodo',$periodo)[0];
           // debuguear($comentarios);
            //
            
            
            
            
            foreach ($examenes as $examen) {
                if($examen->indicador == '1') {
                    $porcentaje_examen_1 = $examen->valor;
                } else if ($examen->indicador == '2') {
                    $porcentaje_examen_2 = $examen->valor;
                    
                }
            }
            

            $cotidiano_total_puntos = 0;
            $cotidiano_total = $cotidiano->totalCotidiano;
     
            if(!empty($cotidiano_evaluacion)) {
                $indicadores_header = "| ";
                $c = 1;
                foreach ($cotidiano_evaluacion as $objeto) {
                    
                    $cotidiano_total_puntos = $cotidiano_total_puntos + intval($objeto->valor);
                    $indicadores_header .= $c.' = '.$objeto->valor.' | ';
                   
                    $c++;
                   
                }
            }
            
            
            



            
            $TotalPuntos = intval($cotidiano->totalIndicadores) * 10;


            $proyectoNota = ($cotidiano_total_puntos*$TotalPuntos)/$TotalPuntos;
    
            $porcentaje = $cotidiano_total / $TotalPuntos;
      
            $tareasPorcentaje = $proyectoNota * $porcentaje;


            $grupo = '';

            foreach ($grupos as $objeto) {
                if ($objeto->id === $student->seccion) {
                    $grupo = $objeto->grado .' - '. $objeto->seccion;
                    
                    break; // Terminar el bucle una vez encontrado el objeto
                }
            }
            
            
            // Verificar si se encontró el objeto
            if ($grupo == '') {
                $grupo = 'Seccion no encontrada';
            } 
        



            $total_tareas_porcentaje_final = 0;
            $total_tareas_porcentaje_final_obtenido = 0;
            $total_tareas_tarea_final = 0;
            $total_tareas_tarea_final_obtenido = 0;
            foreach ($tareas as $tarea) {
                $total_tareas_porcentaje_final = $total_tareas_porcentaje_final+$tarea->totalPorcentajeTarea;
                $total_tareas_tarea_final = $total_tareas_tarea_final+$tarea->totalPuntosTarea;
                $tareas_evaluaciones = Tarea_evaluacion::where('indicador',$tarea->id);
                if(!empty($tareas_evaluaciones)) {
                    $total_tareas_porcentaje_final_obtenido = $total_tareas_porcentaje_final_obtenido+$tareas_evaluaciones->tareasPorcentaje;
                    $total_tareas_tarea_final_obtenido = $total_tareas_tarea_final_obtenido+$tareas_evaluaciones->tareasPuntos;
                   // debuguear($tareas_evaluaciones);
                };
            }



            



            $filename = 'reporte_'.$grupo.'_'.$student->nombre.'_' .$student->apellido.'_'.$student->dni;
        // Crear un nuevo objeto Fpdi
        $pdf = new Fpdi();
        $pdf->SetFont('Arial', '', 10);
        
        // Agregar una página al PDF
        $pdf->AddPage('P','letter');
        
        
            $texto = 'Cedula: '.$student->dni;
            $pdf->MultiCell(0, 5, $texto);
            $texto = 'Nombre: '.$student->nombre . ' ' . $student->apellido;
            $pdf->MultiCell(0, 5, $texto);
            $texto = 'Seccion: '.$grupo;
            $pdf->MultiCell(0, 5, $texto);
            $texto = 'Periodo: '.$periodo;
            $pdf->MultiCell(0, 5, $texto);
            $pdf->MultiCell(0, 5, '');
            $texto = 'Cotidiano: ';
            
            $pdf->MultiCell(0, 5, $texto);

            
            $texto = 'Porcentaje: '.number_format($tareasPorcentaje,2).'% / '.$cotidiano_total.'%';
            $pdf->MultiCell(0, 5, $texto);
            $texto = 'Puntos: '.$cotidiano_total_puntos.' / '.$TotalPuntos.'';
            $pdf->MultiCell(0, 5, $texto);
            
            
          
            $texto = 'Indicadores( # revision = puntos obtenidos ): ';
            
            $pdf->MultiCell(0, 5, $texto);

            $pdf->MultiCell(0, 4, $indicadores_header);


            $pdf->MultiCell(0, 5, '');






            $texto = 'Tareas: ';
            
            $pdf->MultiCell(0, 5, $texto);
            $texto = 'Porcentaje: '.number_format($total_tareas_porcentaje_final_obtenido,2).'% / '.$total_tareas_porcentaje_final.'%';
            $pdf->MultiCell(0, 5, $texto);
            $texto = 'Puntos: '.$total_tareas_tarea_final_obtenido.' / '.$total_tareas_tarea_final.'';
            $pdf->MultiCell(0, 5, $texto);
            $pdf->MultiCell(0, 1, '');
  

            $c = 1;
            foreach ($tareas as $tarea) {
                
                $tareas_evaluaciones = Tarea_evaluacion::where_AND('indicador',$tarea->id,'estudiante',$id,'periodo',$periodo)[0];
            //    debuguear($tareas_evaluaciones);
                if(!empty($tareas_evaluaciones)) {
                    $texto = 'Tarea #'.$c;
                    $pdf->MultiCell(0, 5, $texto);
                    $texto = 'Porcentaje = '.$tareas_evaluaciones->tareasPorcentaje.' / '.$tarea->totalPorcentajeTarea;
                    $pdf->MultiCell(0, 4, $texto);
                    $texto = 'Puntos = '.$tareas_evaluaciones->tareasPuntos.' / '.$tarea->totalPuntosTarea;
                    $pdf->MultiCell(0, 5, $texto);
                    if ($tareas_evaluaciones->observaciones != '') {
                        $texto = 'Observaciones = '.$tareas_evaluaciones->observaciones;
                        $pdf->MultiCell(0, 4, $texto);
                    }
                    $pdf->MultiCell(0, 1, '');
                } else {
                    $texto = 'Tarea no encontrada';
                    $pdf->MultiCell(0, 5, $texto);
                };
                $c++;
            }

            $pdf->MultiCell(0, 4, '');
            $pdf->MultiCell(0, 5, 'Examenes:');
            $pdf->MultiCell(0, 4, 'Examen #1 = '.$porcentaje_examen_1.'%');
            $pdf->MultiCell(0, 4, 'Examen #2 = '.$porcentaje_examen_2.'%');
      

            

            
            $pdf->MultiCell(0, 5, '');
          

            $asistencia_presente = 0;
            $asistencia_tarde = 0;
            $asistencia_ausente = 0;
            $asistencia_puntos_totales_obtenidos = 0;
            foreach ($asistencia_evaluacion as $item) {
                $asistencia_puntos_totales_obtenidos += $item->valor;
                switch ($item->valor) {
                    case '0':
                        $asistencia_ausente++;
                        break;
                    case '1':
                        $asistencia_tarde++;
                        break;
                    case '2':
                        $asistencia_presente++;
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }
            $asistenciaNota = ($asistencia_puntos_totales_obtenidos*($asistencia->totalIndicadores * 2))/($asistencia->totalIndicadores * 2);
            $asistenciaPorcentajeAu = 100 - (($asistenciaNota*100)/($asistencia->totalIndicadores * 2)).'%';
            $porcentaje = $asistencia->totalAsistencia / ($asistencia->totalIndicadores * 2);
  
            $asistenciaPorcentaje = $asistenciaNota * $porcentaje;
           // $asistencia_porcentaje_totales_obtenidos
           // debuguear($asistencia_puntos_totales_obtenidos);
            
            $pdf->MultiCell(0, 5, 'Asistencia: ');

          
            $pdf->MultiCell(0, 5, 'Porcentaje: '.$asistenciaPorcentaje.'% / '.$asistencia->totalAsistencia.'%');

            $pdf->MultiCell(0, 5, 'Puntos: '.$asistencia_puntos_totales_obtenidos.' / '.$asistencia->totalIndicadores * 2);

            $pdf->MultiCell(0, 5, 'Ausente: '.$asistencia_ausente);
            $pdf->MultiCell(0, 5, 'Tarde: '.$asistencia_tarde);
            $pdf->MultiCell(0, 5, 'Presente: '.$asistencia_presente);
            
            $pdf->MultiCell(0, 5, 'Ausentismo: '.$asistenciaPorcentajeAu);
            foreach ($asistencia_evaluacion as $item) {
                $texto = '';
                $texto = $item->date.' = ';
                
                switch ($item->valor) {
                    case '0':
                        $texto .= 'Ausente';
                        break;
                    case '1':
                            
                        $texto .= 'Tarde';
                        break;
                    case '2':
                        $texto .= 'Presente';
                        break;
                    
                    default:
                        # code...
                        break;
                }
                $pdf->MultiCell(0, 4, $texto);
            }

            
            
            if (!empty($proyecto_evaluacion)) {
                $pdf->MultiCell(0, 4, '');
                //  debuguear($proyecto_evaluacion);
                $pdf->MultiCell(0, 5, 'Proyecto: ');


                $total_puntos_obtenidos = 0;
                $total_puntos_maximo = 5 * $proyecto->indicadores;
                foreach ($proyecto_evaluacion as $item) {
                    $total_puntos_obtenidos += $item->valor;
                }
                
                $asistenciaNota = ($total_puntos_obtenidos*$total_puntos_maximo)/$total_puntos_maximo;

                $porcentaje = $proyecto->porcentajeTotal / $total_puntos_maximo;

                $proyectoPorcentaje = $asistenciaNota * $porcentaje;


                $pdf->MultiCell(0, 5, 'Porcentaje: '.$proyectoPorcentaje.' / '.$proyecto->porcentajeTotal);
                $pdf->MultiCell(0, 5, 'Puntos: '.$total_puntos_obtenidos.' / '.$total_puntos_maximo);
                $pdf->MultiCell(0, 5, 'Indicadores:');
                $i = 1;
                foreach ($proyecto_evaluacion as $item) {
                    $pdf->MultiCell(0, 4, 'Indicador #'.$i);
                    $pdf->MultiCell(0, 4, $item->valor.' / '.'5');
                    
                    $i++;
                }
                if($proyecto_observacion->valor != '') {
                    $pdf->MultiCell(0, 5, 'Observacion: ');
                    $pdf->MultiCell(0, 4, $proyecto_observacion->valor);
                    
                }
            }
          
            $pdf->MultiCell(0, 4, '');
            if($comentarios->comentario != '') {
                $pdf->MultiCell(0, 5, 'Comentarios:');
                $pdf->MultiCell(0, 5, $comentarios->comentario);

            }
            // Guardar el PDF en un archivo
            $rutaPDF = CARNET_PDF_FOLDER.$filename.'.pdf';
            
            $pdf->Output($rutaPDF, 'F');
           
            // Ruta del archivo PDF
            $rutaPDF = CARNET_PDF_FOLDER . $filename . '.pdf';

            // Establecer el encabezado de respuesta para la descarga
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($rutaPDF) . '"');
            header('Content-Length: ' . filesize($rutaPDF));

            // Leer el archivo PDF y enviarlo al navegador
            readfile($rutaPDF);
            
        }
    
}
