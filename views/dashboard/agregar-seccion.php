<?php include_once __DIR__  . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    <a href='/dashboard-sections' class="btn-top mb-1"><img src="/build/img/atras.svg" class="btn-student-ico" alt="Icono"></a>
    
<div class="tab">
  <button id="stab-info" class="tablinks active" onclick="openTab(event, 'tab-info')">Información</button>
  <button id="stab-module" class="tablinks" onclick="openTab(event, 'tab-module')">Módulos</button>
  <button id="stab-schedule" class="tablinks" onclick="openTab(event, 'tab-schedule')">Horarios</button>
</div>

    <form method="POST" class="form" enctype="multipart/form-data" action="/dashboard-section-add">
   <!-- action="/student/add" -->
        
        <?php include_once __DIR__ . '/../components/seccion-form.php'; ?>
    
    
    </form>
    
    </div>
    
    <?php include_once __DIR__  . '/footer-dashboard.php'; ?>
    <script src="/build/js/sweetAlert.js"></script>
    <script type="text/javascript" src="/build/js/secciones.js"></script>