
<?php include_once __DIR__  . '/teacher-header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    <div id="item-container">

        <?php if($modulos) { ?>
            <?php $i = 0; ?>
            <?php foreach ($modulos as $modulo) { ?>
                <a class="public-student section-container" href="/teacher-dashboard-module?id=<?php echo base64_encode($modulo->id);?>&periodo=MQ%3D%3D&page=dGFiLTE%3D">
                    <div class="public-student-info" >
                        <p><?php foreach ($grupos as $grupo) {?>
                           <?php if($modulo->grupoID == $grupo->id) { ?>
                                <?php echo $grupo->grado ?? '';?>
                                     - <?php echo $grupo->seccion ?? '';?>
                                <?php } ?>
                           <?php } ?>
                                
                        </p>
                        <p><?php echo $modulo->nombre?></p>
                    </div>
                        </a>
                <?php $i++; ?>
        <?php } ?>
    <?php } ?>
    </div>
</div>
    
    <?php include_once __DIR__  . '/footer-dashboard.php'; ?>
    <script src="/build/js/sweetAlert.js"></script>
    <script type="text/javascript" src="/build/js/profesor.js"></script>