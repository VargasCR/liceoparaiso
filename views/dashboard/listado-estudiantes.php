<?php include_once __DIR__  . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    <a href='/dashboard-student' class="btn-top mb-1"><img src="/build/img/atras.svg" class="btn-student-ico" alt="Icono"></a>
    <a onclick='askdeleteSelectedList()' class="btn-top mb-1"><img src="/build/img/delete-student.svg" class="btn-student-ico" alt="Icono"></a>

    <a onclick='downloadID()' class="btn-top mb-1"><img src="/build/img/download.svg" class="btn-student-ico" alt="Icono"></a>

    <a onclick='printID()' class="btn-top mb-1 hidden"><img src="/build/img/print.svg" class="btn-student-ico" alt="Icono"></a>
    <input type="checkbox" id="selecting" class="" onclick="unselectAll(1)" checked></input>
    <a onclick='registrarAsistencia_becaSeleccion()' id="btn-check" class="btn-top mb-1"><img src="/build/img/asistencia.svg" class="btn-student-ico" alt="Icono"></a>

  <div class="fx">
      
    
  </div>

</div>
<div id="item-container">
    </div>

<?php include_once __DIR__  . '/footer-dashboard.php'; ?>

    <script type="text/javascript" src="/build/js/estudiantes.js"></script>