<?php include_once __DIR__  . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    <a href='/dashboard-student' class="btn-top mb-1"><img src="/build/img/atras.svg" class="btn-student-ico" alt="Icono"></a>
    <form method="POST" class="form" enctype="multipart/form-data" action="/dashboard-student-edit?id=<?php echo $estudiante->id ?? ''; ?>">
   <input type="hidden" name="id" value="<?php echo $estudiante->id ?? '';?>">
    <!-- action="/student/add" -->
        
        <?php include_once __DIR__ . '/../components/student-form.php'; ?>
        <input type="submit" class="save-button" value="Actualizar">
    </form>
    
    </div>
    
    <?php include_once __DIR__  . '/footer-dashboard.php'; ?>
    <script src="/build/js/sweetAlert.js"></script>
    <script type="text/javascript" src="/build/js/estudiantes.js"></script>