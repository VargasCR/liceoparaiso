<?php

namespace Controllers;

use Intervention\Image\ImageManagerStatic as Image;
use Model\Ajuste;
use Model\Asistencia_beca;
use Model\Estudiante;
use Model\Foro_enlace;
use Model\Foro_images;
use Model\Foro_items;
use Model\Foros;
use MVC\Router;
use Model\Usuario;
use Model\Grupo;
use Model\Horario;
use Model\Modulo;
use Model\Noticias;
use Model\Profesor;


class DashboardController {
    public static function index(Router $router) {
        session_start();
        isAuth();
        $noticias = Noticias::all();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $noticia = new Noticias($_POST);
            if($_POST['titulo'] != '' && $_POST['descripcion'] != '' ) {
                $noticia->guardar();
                header('Location: /dashboard?code=246');
            } else {
                
                Noticias::setAlerta('error', 'Llene los espacios');
                $alertas = $noticia->getAlertas();
                $editanto_noticia = $_POST;
            
            }
        }
       
        $router->render('dashboard/index', [
            'titulo' => 'Noticias',
            'alertas' => $alertas,
            'editanto_noticia' => $editanto_noticia,
            'noticias' => $noticias,
            // 'proyectos' => $proyectos 
        ]); 
    }
    
    
    public static function borrar_noticia() {
        session_start();
        isAuth();
      
      //  debuguear('');

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $noticia = Noticias::find($_POST['id']);
            if(!empty($noticia)) {
                $noticia->eliminar();
                header('Location: /dashboard?code=246');
                return;
                
            }
            
        }
        header('Location: /dashboard?code=245');
       
    }
    public static function estudiantes(Router $router) {
        session_start();
        isAuth();
        $grupos = Grupo::all();
        $ajustes = Ajuste::find($_SESSION['id']);

     //   $searching = $ajustes->searching;
        if($ajustes->searching == 0 && $ajustes != null) {
          $searching = $ajustes->searching = null;
        } else {
            
        }
        //debuguear('a');
        /*
        
        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);
        */
        $funciones = 'encontrarEstudiantes();addListenerSearch();';
        $router->render('dashboard/estudiantes', [
            'titulo' => 'Estudiantes',
            'funciones' => $funciones,
            'grupos' => $grupos,
            'ajustes' => $ajustes,
            'searching' => $searching
         
        //     'proyectos' => $proyectos 
        ]); 
    }

    
    public static function agregar_estudiante(Router $router) {
       // debuguear($_POST);
        session_start();
        isAuth();
        $grupos = Grupo::all();

       


        $funciones = 'findParamAlert();addListenerTransport();';
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $estudiante = new Estudiante($_POST);
            // validación
            $alertas = $estudiante->validarEstudiante();
            if(empty($alertas)) {
                // $image_folder = '../../images/';
                $estudiante->guardar();

                if (!is_dir(IMAGE_FOLDER)) {
                    mkdir(IMAGE_FOLDER);
                }
                $ultimo_estudiante = Estudiante::findLast('dni',$estudiante->dni);
                $image_name = $ultimo_estudiante->id . '.jpg';
                //debuguear($_FILES['image']['tmp_name']);
                if ($_FILES['image']['tmp_name']) {
                    $imagen = Image::make ($_FILES['image']['tmp_name'])->fit(700,800);
                    //   $users->setImage($image_name);
                    
                }

                $estudiante->id = $ultimo_estudiante->id;
             //   $image = $_FILES['image'];
                $imagen->save(IMAGE_FOLDER.$image_name);
           
                $estudiante->crearQR($estudiante->id);
                $estudiante->crearCarnet($estudiante,$grupos);

                // Redireccionar
                header('Location: /dashboard-student-add?code=1');
            }
        }
        $router->render('dashboard/agregar-estudiante', [
            'titulo' => 'Agregar Estudiante',
            'grupos' => $grupos,
            'alertas' => $alertas,
            'funciones' => $funciones,
            'estudiante' => $estudiante
        ]); 
    }

    


    public static function listar_estudiante(Router $router) {
        session_start();
        isAuth();
        $grupos = Grupo::all();
        /*

        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);
        */
        $funciones = 'showSelectedStudent();';
        $router->render('dashboard/listado-estudiantes', [
            'titulo' => 'Estudiantes Seleccionados',
            'funciones' => $funciones,
            'grupos' => $grupos,
         
        //     'proyectos' => $proyectos 
        ]); 
    }
    public static function encontrar_qr(Router $router) {
        session_start();
        isAuth();
       // $grupos = Grupo::all();
        /*

        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);
        */
        $funciones = '';
        $router->render('dashboard/qr-scanner', [
            'titulo' => 'Escaner',
            'funciones' => $funciones,
         //   'grupos' => $grupos,
         
        //     'proyectos' => $proyectos 
        ]); 
    }

    public static function editar_estudiante(Router $router) {
        session_start();
        isAuth();
        $id = $_GET['id'];
       $estudiante = Estudiante::find($id);
       $grupos = Grupo::all();
       
       $funciones = 'findParamAlert();addListenerTransport();';
       
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
           // debuguear($_POST);
           $estudiante = new Estudiante($_POST);
         //  debuguear($estudiante);
         //   $estudiante->id = $id; 
          //  debuguear($estudiante);
            // validación
            $alertas = $estudiante->validarEstudiante();
            if(empty($alertas)) {

               
                if (!is_dir(IMAGE_FOLDER)) {
                    mkdir(IMAGE_FOLDER);
                }
            //  $ultimo_estudiante = Estudiante::findLast('dni',$estudiante->dni);
                $image_name = $id . '.jpg';
                //debuguear($_FILES['image']['tmp_name']);
                if ($_FILES['image']['tmp_name']) {
                    $imagen = Image::make ($_FILES['image']['tmp_name'])->fit(700,800);
                    //   $users->setImage($image_name);
                    $imagen->save(IMAGE_FOLDER.$image_name);
                    
                }
                $estudiante->guardar();
                $estudiante->crearQR($estudiante->id);
                $estudiante->crearCarnet($estudiante,$grupos);
           //     $estudiante->crearPDF($estudiante->id);
                // Redireccionar
                header('Location: /dashboard-student-edit?code=1&id='.$id);
            }
        } 
        $router->render('dashboard/editar-estudiante', [
            'titulo' => 'Editar Estudiante',
            'grupos' => $grupos,
            'funciones' => $funciones,
            'estudiante' => $estudiante
        ]); 
    }


    public static function perfil(Router $router) {
        session_start();
        isAuth();
        $alertas = [];

        $usuario = Usuario::find($_SESSION['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);

            $alertas = $usuario->validar_perfil();

            if(empty($alertas)) {

                $existeUsuario = Usuario::where('email', $usuario->email);

                if($existeUsuario && $existeUsuario->id !== $usuario->id ) {
                    // Mensaje de error
                    Usuario::setAlerta('error', 'Email no válido, ya pertenece a otra cuenta');
                    $alertas = $usuario->getAlertas();
                } else {
                    // Guardar el registro
                    $usuario->guardar();

                    Usuario::setAlerta('exito', 'Guardado Correctamente');
                    $alertas = $usuario->getAlertas();

                    // Asignar el nombre nuevo a la barra
                    $_SESSION['nombre'] = $usuario->nombre;
                }
            }
        }
        
        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function cambiar_password(Router $router) {
        session_start();
        isAuth();

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = Usuario::find($_SESSION['id']);

            // Sincronizar con los datos del usuario
            $usuario->sincronizar($_POST);

            $alertas = $usuario->nuevo_password();

            if(empty($alertas)) {
                $resultado = $usuario->comprobar_password();

                if($resultado) {
                    $usuario->password = $usuario->password_nuevo;

                    // Eliminar propiedades No necesarias
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);

                    // Hashear el nuevo password
                    $usuario->hashPassword();

                    // Actualizar
                    $resultado = $usuario->guardar();

                    if($resultado) {
                        Usuario::setAlerta('exito', 'Password Guardado Correctamente');
                        $alertas = $usuario->getAlertas();
                    }
                } else {
                    Usuario::setAlerta('error', 'Password Incorrecto');
                    $alertas = $usuario->getAlertas();
                }
            }
        }

        $router->render('dashboard/cambiar-password', [
            'titulo' => 'Cambiar Password',
            'alertas' => $alertas
         ]);
    }


    public static function profesores(Router $router) {
        session_start();
        isAuth();
        $grupos = Grupo::all();
        $ajustes = Ajuste::find($_SESSION['id']);
        
        /*
        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);
        */
        $funciones = 'findParamAlert();';
        $router->render('dashboard/profesores', [
            'titulo' => 'Profesores',
            'funciones' => $funciones,
            'grupos' => $grupos,
            'ajustes' => $ajustes,
            
         
        //     'proyectos' => $proyectos 
        ]); 
    }
    public static function agregar_profesor(Router $router) {
        // debuguear($_POST);
         session_start();
         isAuth();
         $grupos = Grupo::all();
         $funciones = 'findParamAlert();';
         if($_SERVER['REQUEST_METHOD'] === 'POST') {
             $profesor = new Profesor($_POST);
             // validación
             $alertas = $profesor->validarProfesor();
             if(empty($alertas)) {
                 // $image_folder = '../../images/';
                 $profesor->guardar();
                 if (!is_dir(IMAGE_FOLDER)) {
                     mkdir(IMAGE_FOLDER);
                 }
                 $ultimo_profesor = Profesor::findLast('dni',$profesor->dni);
                 $image_name = $ultimo_profesor->id . 'p.jpg';
                 //debuguear($_FILES['image']['tmp_name']);
                 if ($_FILES['image']['tmp_name']) {
                     $imagen = Image::make ($_FILES['image']['tmp_name'])->fit(700,800);
                     //   $users->setImage($image_name);
                     
                 }
 
                 $profesor->id = $ultimo_profesor->id;
              //   $image = $_FILES['image'];
                 $imagen->save(IMAGE_FOLDER.$image_name);
                 // Redireccionar
                 header('Location: /dashboard-teacher-add?code=1');
             }
         }
         $router->render('dashboard/agregar-profesor', [
             'titulo' => 'Agregar Profesor',
             'grupos' => $grupos,
             'alertas' => $alertas,
             'funciones' => $funciones,
             'profesor' => $profesor
         ]); 
     }

     public static function editar_profesor(Router $router) {
        session_start();
        isAuth();
        $id = $_GET['id'];
        $profesor = Profesor::find($id);
        $profesor->id = $id;
       
       $funciones = 'findParamAlert();';
       
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
           // debuguear($_POST);
           $profesor = new Profesor($_POST);
         //  debuguear($estudiante);
         //   $estudiante->id = $id; 
          //  debuguear($estudiante);
            // validación
            $alertas = $profesor->validarProfesor();
            if(empty($alertas)) {

               
                if (!is_dir(IMAGE_FOLDER)) {
                    mkdir(IMAGE_FOLDER);
                }
            //  $ultimo_estudiante = Estudiante::findLast('dni',$estudiante->dni);
                $image_name = $id . 'p.jpg';
                //debuguear($_FILES['image']['tmp_name']);
                if ($_FILES['image']['tmp_name']) {
                    $imagen = Image::make ($_FILES['image']['tmp_name'])->fit(700,800);
                    //   $users->setImage($image_name);
                    $imagen->save(IMAGE_FOLDER.$image_name);
                    
                }


                $profesor->guardar();
               
           //     $estudiante->crearPDF($estudiante->id);
                // Redireccionar/dashboard-teacher-edit?
                header('Location: /dashboard-teacher-edit?code=1&id='.$id);
            }
        } 
        $router->render('dashboard/editar-profesor', [
            'titulo' => 'Editar Profesor',
            'funciones' => $funciones,
            'profesor' => $profesor
        ]); 
    }

    public static function secciones(Router $router) {
        session_start();
        isAuth();
        $grupos = Grupo::all();
        $ajustes = Ajuste::find($_SESSION['id']);
        $modulos = Modulo::all();
        $profesores = Profesor::all();
        /*
        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);
        */
        $funciones = 'findParamAlert();';
        //debuguear($modulos);
        $router->render('dashboard/secciones', [
            'titulo' => 'Secciones',
            'funciones' => $funciones,
            'grupos' => $grupos,
            'modulos' => $modulos,
            'profesores' => $profesores,
            'ajustes' => $ajustes,
        //     'proyectos' => $proyectos 
        ]); 
    }
    public static function delete_qr(Router $router) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $item = Asistencia_beca::find($_POST['id']);
            $item->eliminar();
            header('Location: /dashboard-records?code=246');
            
            
        }
    }
    public static function encontrar_qr_estudiante(Router $router) {
        session_start();
        isAuth();
        $asistencia_beca = Asistencia_beca::encontrarAsistencia(date('Y-m-d'),date('Y-m-d'));
        $estudiantes = Estudiante::all();
        $grupos = Grupo::all();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dateFrom = $_POST['dateFrom'];
            $dateTo = $_POST['dateTo'];
            
            $asistencia_beca = Asistencia_beca::encontrarAsistencia($_POST['dateFrom'],$_POST['dateTo']);
            
        }
        //debuguear($estudiantes);
        $router->render('dashboard/qr', [
            'titulo' => 'Registro Asistencia Becas',
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'asistencia_beca' => $asistencia_beca,
            'grupos' => $grupos,
            'estudiantes' => $estudiantes
        ]); 
    }
    
    

    

    
    public static function agregar_seccion(Router $router) {
        // debuguear($_POST);
         session_start();
         isAuth();
         $grupos = Grupo::all();
         $profesores = Profesor::all();
         $funciones = 'findParamAlert();findteacher();findclasses();';
       
         if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode($_POST['schedule'], true);
            // Acceder al valor del elemento "schedule"
            $grupo = new Grupo($_POST);
            $modulos = new Modulo();
            $tagsref = $_POST['tags'];
            $aulasref = $_POST['aula'];
            $profref = $_POST['profesores'];
             // validación
            $alertas = $grupo->validar_grupo();
            $i = 0;
            foreach ($tagsref as $tag) {
                $modulos->grupoID = $ultimo_grupo->id;
                $modulos->profesorID = $profref[$i];
                $modulos->nombre = $tag;
                $modulos->aula = $aulasref[$i];
                $alertas = $modulos->validar($alertas,$i);
                $i++;
            }
            if(!$data || count($data) === 0) {
                $alertas['error'][] = 'Agregue al menos una clase al horario';
                
            } 
        
            if(empty($alertas)) {
                // $image_folder = '../../images/';
                $grupo->guardar();
                $ultimo_grupo = Grupo::findLast('grado',$grupo->grado);
                $i = 0;
                $horario = new Horario();
                foreach ($tagsref as $tag) {
                    $modulos->grupoID = $ultimo_grupo->id;
                    $modulos->profesorID = $profref[$i];
                    $modulos->nombre = $tag;
                    $modulos->aula = $aulasref[$i];
                    $modulos->guardar();
                    $i++;
                    foreach ($data as $clave => $valor) {
                        $ultimo_modulo = Modulo::findLast('grupoID',$ultimo_grupo->id);
                        
                        if($valor['nombre'] == $tag) {
                            $horario->grupoID = $ultimo_grupo->id;
                            $horario->leccion = $clave;
                            $horario->moduleID = $ultimo_modulo->id;
                            $horario->guardar();
                        }
                      }
                }
                    // Redireccionar
                    header('Location: /dashboard-section-add?code=1');
            } else {
                $modulo = $_POST['modulo'];
                $funciones = 'findTagCount();';
            }
        }
        $data = json_encode($data,true);
     
        $router->render('dashboard/agregar-seccion', [
             'titulo' => 'Agregar Sección',
             'grupos' => $grupos,
             'grupo' => $grupo,
             'modulos' => $modulos,
             'modulo' => $modulo,
             'tags' => $tagsref,
             'aulasref' => $aulasref,
             'profref' => $profref,
             'profesores' => $profesores,
             'alertas' => $alertas,
             'funciones' => $funciones,
             'data'=> $data
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

        $router->render('dashboard/admin-forum', [
            'titulo' => 'Foro',
            'foros' => $foros,
            'foros_items' => $foros_items,
            'foros_enlaces' => $foros_enlaces,
            'foros_images' => $foros_images,
            // 'proyectos' => $proyectos 
        ]);
    }

     public static function admin_forum(Router $router) {
        session_start();
        isAuth();
        
        $foros = Foros::all();
       
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
                $foro_images = Foro_images::findGroup('foro_id',$id);
                foreach ($foro_enlaces as $item) {
                    $item->eliminar();
                }
                foreach ($foro_items as $item) {
                    $item->eliminar();
                }
                foreach ($foro_images as $item) {
                    $item->eliminar();
                }
                $foro->eliminar();
                header('Location: /admin-forum?code=246');
                return;
            }
            
        }
        $router->render('dashboard/admin-public-repository', [
            'titulo' => 'Foros',
            'foros' => $foros,
            'phrase' => $phrase
            // 'proyectos' => $proyectos 
        ]);
    }

    public static function agregar_foro(Router $router) {
        session_start();
        isAuth();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
           

            if ($_POST['items'] && $_POST['titulo'] != '') {
                $foro = new Foros();
                $foroEnlaces = new Foro_enlace();
                
                $foroItems = new Foro_items();
                $foroImages = new Foro_images();
            //    debuguear($_SESSION);
                $foro->profesor = '0';
                $foro->periodo = '1';
                $foro->year = date("Y");
                $foro->titulo = $_POST['titulo'];
                $foro->icon_img = $_POST['icon'];
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
        $router->render('dashboard/admin-forum-add', [
            'titulo' => 'Agregar Foro',
            // 'proyectos' => $proyectos 
        ]); 
    }
}