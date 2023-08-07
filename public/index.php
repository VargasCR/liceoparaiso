<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\ApiController;
use MVC\Router;
use Controllers\LoginController;
use Controllers\DashboardController;
use Controllers\StudentController;
use Controllers\TareaController;
use Controllers\TeacherController;

$router = new Router();

// Login
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

// Crear Cuenta
$router->get('/crear', [LoginController::class, 'crear']);
$router->post('/crear', [LoginController::class, 'crear']);

// Formulario de olvide mi password
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);

// Colocar el nuevo password
$router->get('/reestablecer', [LoginController::class, 'reestablecer']);
$router->post('/reestablecer', [LoginController::class, 'reestablecer']);

// Confirmación de Cuenta
$router->get('/mensaje', [LoginController::class, 'mensaje']);
$router->get('/confirmar', [LoginController::class, 'confirmar']);



$router->get('/teacher-dashboard', [TeacherController::class, 'index']);
$router->get('/teacher-news', [TeacherController::class, 'teacher_news']);
$router->get('/teacher-dashboard-module', [TeacherController::class, 'teacher_module']);
$router->post('/teacher-dashboard-module', [TeacherController::class, 'teacher_module']);
$router->post('/create-evaluation-report', [TeacherController::class, 'evaluation_report']);



$router->get('/student-dashboard', [StudentController::class, 'index']);

// ZONA DE PROYECTOS
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/admin-forum', [DashboardController::class, 'admin_forum']);
$router->post('/admin-forum', [DashboardController::class, 'admin_forum']);
$router->post('/dashboard', [DashboardController::class, 'index']);

$router->post('/admin-delete-qr', [DashboardController::class, 'delete_qr']);

$router->post('/noticias-borrar', [DashboardController::class, 'borrar_noticia']);

$router->get('/dashboard-student', [DashboardController::class, 'estudiantes']);
$router->get('/dashboard-student-add', [DashboardController::class, 'agregar_estudiante']);
$router->post('/dashboard-student-add', [DashboardController::class, 'agregar_estudiante']);
$router->get('/dashboard-student-edit', [DashboardController::class, 'editar_estudiante']);
$router->post('/dashboard-student-edit', [DashboardController::class, 'editar_estudiante']);
$router->get('/dashboard-student-selected', [DashboardController::class, 'listar_estudiante']);




$router->get('/dashboard-teacher', [DashboardController::class, 'profesores']);
$router->get('/dashboard-section-add', [DashboardController::class, 'agregar_seccion']);
$router->post('/dashboard-section-add', [DashboardController::class, 'agregar_seccion']);

$router->post('/api/add-indicador-teacher', [ApiController::class, 'add_indicador']);
$router->get('/api/add-indicador-teacher', [ApiController::class, 'add_indicador']);


$router->get('/dashboard-teacher-add', [DashboardController::class, 'agregar_profesor']);
$router->post('/dashboard-teacher-add', [DashboardController::class, 'agregar_profesor']);
$router->get('/dashboard-teacher-edit', [DashboardController::class, 'editar_profesor']);
$router->post('/dashboard-teacher-edit', [DashboardController::class, 'editar_profesor']);




$router->get('/dashboard-student-repository', [StudentController::class, 'foros']);
$router->post('/dashboard-student-repository', [StudentController::class, 'foros']);
$router->get('/student-forum', [StudentController::class, 'abrir_foro']);






$router->get('/teacher-forum', [TeacherController::class, 'abrir_foro']);
$router->get('/teacher-public-repository', [TeacherController::class, 'foros']);
$router->post('/teacher-public-repository', [TeacherController::class, 'foros']);

$router->get('/dashboard-teacher-repository', [TeacherController::class, 'agregar_foro']);
$router->post('/dashboard-teacher-repository', [TeacherController::class, 'agregar_foro']);
$router->get('/dashboard-admin-repository', [DashboardController::class, 'agregar_foro']);
$router->get('/open-admin-forum', [DashboardController::class, 'abrir_foro']);
$router->post('/dashboard-admin-repository', [DashboardController::class, 'agregar_foro']);

$router->get('/dashboard-sections', [DashboardController::class, 'secciones']);

$router->get('/dashboard-qr', [DashboardController::class, 'encontrar_qr']);
$router->post('/dashboard-qr', [DashboardController::class, 'encontrar_qr']);


$router->get('/dashboard-records', [DashboardController::class, 'encontrar_qr_estudiante']);
$router->post('/dashboard-records', [DashboardController::class, 'encontrar_qr_estudiante']);



$router->post('/api/delete-project-teacher', [ApiController::class, 'borrar_proyecto']);


$router->post('/api/add-attendance-qr', [ApiController::class, 'agregar_asistencia_beca_qr']);
$router->post('/api/add-attendance', [ApiController::class, 'agregar_asistencia_beca']);
$router->get('/api/add-attendance', [ApiController::class, 'agregar_asistencia_beca']);

$router->post('/api/delete-seccion', [ApiController::class, 'eliminar_seccion']);
$router->post('/api/delete-homework', [ApiController::class, 'eliminar_tarea']);
$router->post('/api/add-homework', [ApiController::class, 'agregar_tarea']);
$router->post('/api/add-project-indicador-teacher', [ApiController::class, 'agregar_indicador_proyecto']);

$router->get('/api/delete-student', [ApiController::class, 'eliminar_estudiante']);
$router->post('/api/delete-student', [ApiController::class, 'eliminar_estudiante']);
$router->post('/api/delete-student-selected', [ApiController::class, 'eliminar_estudiante_seleccionado']);
$router->post('/api/delete-student-all', [ApiController::class, 'eliminar_estudiante_todos']);
$router->post('/api/find-student', [ApiController::class, 'encontrar_estudiantes']);
$router->post('/api/download-carnet-all', [ApiController::class, 'download_carnet_all']);
$router->post('/api/download-list-all', [ApiController::class, 'download_list_all']);
$router->post('/api/download-list-selected', [ApiController::class, 'download_list_selected']);
$router->post('/api/download-carnet-selected', [ApiController::class, 'download_carnet_selected']);
$router->post('/api/find-student-selected', [ApiController::class, 'encontrar_estudiantes_seleccionados']);

$router->post('/api/delete-teacher-selected', [ApiController::class, 'eliminar_profesor_seleccionado']);


$router->post('/api/set-searching-bar', [ApiController::class, 'set_searching']);

$router->get('/api/find-teacher', [ApiController::class, 'encontrar_profesores']);

$router->get('/crear-proyecto', [DashboardController::class, 'crear_proyecto']);
$router->post('/crear-proyecto', [DashboardController::class, 'crear_proyecto']);
$router->get('/proyecto', [DashboardController::class, 'proyecto']);
$router->get('/perfil', [DashboardController::class, 'perfil']);
$router->post('/perfil', [DashboardController::class, 'perfil']);
$router->get('/cambiar-password', [DashboardController::class, 'cambiar_password']);
$router->post('/cambiar-password', [DashboardController::class, 'cambiar_password']);

// API para las tareas


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();