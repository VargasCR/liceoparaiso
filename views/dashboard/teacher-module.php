<?php include_once __DIR__  . '/teacher-header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    <div class="teacher-header-container">
        <a href='/teacher-dashboard' class="btn-top mb-1"><img src="/build/img/atras.svg" class="btn-student-ico" alt="Icono"></a>
        <select id="teacher-select-periodo" class="select-teacher mb-1" onchange="findPeriodo()">
            <option value="1" <?php if(base64_decode($_GET['periodo']) == '1') {echo 'selected';} ?>>Periodo #1</option>
            <option value="2" <?php if(base64_decode($_GET['periodo']) == '2') {echo 'selected';} ?>>Periodo #2</option>
            
        </select>
    </div>
    
    <?php include_once __DIR__ . '/../components/teacher-evaluation.php'; ?>
    </div>
    
    <?php include_once __DIR__  . '/footer-dashboard.php'; ?>
    <script src="/build/js/sweetAlert.js"></script>
    <script type="text/javascript" src="/build/js/profesor.js"></script>