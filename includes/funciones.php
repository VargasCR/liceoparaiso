<?php
define('IMAGE_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/build/img/pictures/');
define('QR_IMAGE_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/build/img/qr/');
define('CARNET_IMAGE_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/build/img/carnet/creados/');
define('CARNET_PDF_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/build/img/carnet/pdf/');
define('DW_CARNET_PDF_FOLDER', $_SERVER['DOCUMENT_ROOT'] . 'C:\Users\Vargas\Desktop\TCU\App\public\build\img\carnet\pdf\\');
define('CARNET_BASE_IMAGE_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/build/img/carnet/base/');
define('REPORT_BASE_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/build/report/');
//define('CARNET_BASE_IMAGE_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/build/img/carnet/base/');
// Establecer la zona horaria a Costa Rica
date_default_timezone_set('America/Costa_Rica');

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function isMobileDevice() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    
    // Palabras clave comunes en el agente de usuario de dispositivos móviles
    $mobileKeywords = array('mobile', 'android', 'iphone', 'ipad', 'windows phone');
    
    // Comprobamos si alguna de las palabras clave aparece en el agente de usuario
    foreach ($mobileKeywords as $keyword) {
        if (stripos($userAgent, $keyword) !== false) {
            return true;
        }
    }
    
    return false;
}
// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Función que revisa que el usuario este autenticado
function isAuth() : void {
    $url = $_SERVER['REQUEST_URI'];
    $encontrado = false;
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    } else {
        $parts = parse_url($url);
        $url = $parts['path'];
        switch ($_SESSION['permisos']) {
            
            case "0":
                $urls = ['/dashboard'
                ,'/dashboard-student'
                ,'/dashboard-student-add'
                ,'/dashboard-student-edit'
                ,'/dashboard-teacher'
                ,'/dashboard-teacher-add'
                ,'/dashboard-teacher-edit'
                ,'/dashboard-sections'
                ,'/dashboard-section-add'
                ,'/dashboard-records'
                ,'/dashboard-qr'
                ,'/noticias-borrar'
                ,'/dashboard-student-selected'
                ,'/admin-forum'
                ,'/form-delete-post'
                ,'/dashboard-admin-repository'
                ,'/admin-forum-add'
                ,'/open-admin-forum'
        ];
                break;
            case "1":
                $urls = ['/teacher-public-repository'
                ,'/teacher-forum'
                ,'/create-evaluation-report'
                ,'/teacher-dashboard'
                ,'/teacher-dashboard-module'
                ,'/dashboard-teacher-repository'
                ,'/teacher-news'];
                break;
            case "2":
                $urls = ['/student-dashboard'
                ,'/dashboard-student-repository'
                ,'/student-forum'];
                
                break;
            default:
                $urls = [];
                break;
          }
        foreach ($urls as $item) {
            if($item == $url) {
                $encontrado = true;
                break;
            }
        }
        
        //$encontrado = true;
        if(!$encontrado) {
            $_SESSION = null;
            header('Location: /logout');
        }
    }
}