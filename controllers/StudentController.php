<?php

namespace Controllers;

use Model\Foro_enlace;
use Model\Foro_images;
use Model\Foro_items;
use Model\Foros;
use Model\Noticias;
use MVC\Router;
class StudentController {
    public static function index(Router $router) {
        session_start();
        isAuth();
        $noticias = Noticias::all();
        /*

        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);
*/
        $router->render('dashboard/student-dashboard', [
            'titulo' => 'Noticias',
            'noticias' => $noticias,
            // 'proyectos' => $proyectos 
        ]); 
    }
    public static function foros(Router $router) {
        session_start();
        isAuth();
        $foros = Foros::all('profesor',$_SESSION['profesorID']);
        
        //debuguear($mis_foros);
        $foros_items = Foro_items::all();
        $foros_enlaces = Foro_enlace::all();
        $public = true;
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($_POST['type'] != null) {
                $phrase = $_POST['search'];
                //debuguear($phrase);
                if($phrase != '') {
                    $foros = Foros::findForo($phrase);
                    
                } else {}
            }
        }
        $router->render('dashboard/student-public-repository', [
            'titulo' => 'Foros',
            'foros' => $foros,
            'foros_items' => $foros_items,
            'foros_enlaces' => $foros_enlaces,
            'public' => $public,
            'phrase' => $phrase,
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

       //    debuguear($foros_enlaces);

        $router->render('dashboard/student-forum', [
            'titulo' => 'Foro',
            'foros' => $foros,
            'foros_items' => $foros_items,
            'foros_enlaces' => $foros_enlaces,
            'foros_images' => $foros_images,
            // 'proyectos' => $proyectos 
        ]);
    }
}