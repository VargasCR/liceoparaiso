<?php include_once __DIR__  . '/header-dashboard.php'; ?>
<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<div class="contenedor-sm">
    <a href='/dashboard-section-add' class="btn-top mb-1 hg-4 wg-4"><img src="/build/img/add-student.svg" class="btn-student-ico" alt="Icono"></a>
    

</div>
<div id="item-container">
    <?php $i = 0; ?>
    <?php foreach ($grupos as $grupo) { ?>
        
        <div class="public-student section-container" >
        
            <div class="public-student-info" >
                <input type="hidden" name="id" value="<?php echo $objeto->id ?? ''; ?>">

                <h4 onclick="showDetailSection(<?php echo $i; ?>); event.stopPropagation()"><?php echo $grupo->grado. ' - ' .$grupo->seccion; ?></h4>

                <div id="module-list-<?php echo $i; ?>" class="hidden">
                    <p>Módulos:</p>
                    <div class="module-list">

                        <?php foreach ($modulos as $objeto) { ?>
                            <?php if($grupo->id == $objeto->grupoID) { ?>
                                <p><?php echo $objeto->nombre; ?></p>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>

                <div class="btn-edit-student" style="width: auto !important">
                    <button class="btn-student btn-delete" onclick="showconfirmremoveSeccion(<?php echo $grupo->id ?? '';?>); event.stopPropagation()">
                    <img src="/build/img/delete-student.svg" class="btn-student-ico" alt="Icono">
                    </button>
                </div>
            </div>
        </div>
        
            <?php $i++; ?>
        <?php } ?>
   
    </div>

<?php include_once __DIR__  . '/footer-dashboard.php'; ?>

    <script type="text/javascript" src="/build/js/secciones.js"></script>
  