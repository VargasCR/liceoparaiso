<?php include_once __DIR__  . '/header-dashboard.php'; ?>
<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<div class="contenedor-sm">
    <div class="contenedor-sm-btn">
    <a href='/dashboard-student-add' class="btn-top mb-1 hg-4 wg-4"><img src="/build/img/add-student.svg" class="btn-student-ico" alt="Icono"></a>
    <a onclick='showSearchBar()' class="btn-top mb-1"><img src="/build/img/search-student.svg" class="btn-student-ico" alt="Icono"></a>
    <a onclick='askdeleteSelectedList()' class="btn-top mb-1"><img src="/build/img/delete-student.svg" class="btn-student-ico" alt="Icono"></a>
    <a href='/dashboard-qr' class="btn-top mb-1"><img src="/build/img/qr-code-scanner.svg" class="btn-student-ico" alt="Icono"></a>
    <a onclick='downloadID()' class="btn-top mb-1"><img src="/build/img/download.svg" class="btn-student-ico" alt="Icono"></a>
    <a onclick='printID()' class="btn-top mb-1 hidden"><img src="/build/img/print.svg" class="btn-student-ico" alt="Icono"></a>
    <a href='/dashboard-student-selected' id="btn-list" class="btn-top mb-1 hidden"><img src="/build/img/list.svg" class="btn-student-ico" alt="Icono"></a>
    
    <a onclick='registrarAsistencia_becaSeleccion()' id="btn-check" class="btn-top mb-1 hidden"><img src="/build/img/asistencia.svg" class="btn-student-ico" alt="Icono"></a>
</div>
    
    
</div>
<input type="checkbox" id="selecting" class="" onclick="unselectAll(0)"></input>
<div class="fx">
 
      <select name="seccion" id="search-select" class="<?php echo $ajustes->searching ?? 'hidden'; ?>">
        <option selected value="0" id="seccion">-- Sección --</option>
        <?php foreach($grupos as $grupo) { ?>
            <option 
            value="<?php echo s($grupo->id); ?>">
            <?php echo s($grupo->grado) . " - " . s($grupo->seccion); ?>
        <?php  } ?>
</select>
<input
          type="text"
          name="search"
          id="search-input"
          class="<?php echo $ajustes->searching ?? 'hidden'; ?>"
          placeholder="Palabras de busqueda"
      />
  </div>
<div id="item-container">
    </div>

<?php include_once __DIR__  . '/footer-dashboard.php'; ?>

    <script type="text/javascript" src="/build/js/estudiantes.js"></script>