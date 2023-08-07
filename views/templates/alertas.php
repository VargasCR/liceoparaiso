<?php
    foreach($alertas as $key => $alerta):
        foreach($alerta as $mensaje):
            echo $mensaje;
?>
    <div class="alerta <?php echo $key; ?>"><?php echo $mensaje; ?></div>
<?php
        endforeach;
    endforeach;
?>
<?php if($code = $_GET['code'] == '245') { ?>
    <div class="alerta error">Error en el proceso</div>
    <?php 
} ?>
<?php if($code = $_GET['code'] == '246') { ?>
    <div class="alerta exito">Completado correctamente</div>
<?php 
} ?>
<script>
    const newUrl = window.location.href.replace(/[?&]code=([^&#]*)/i, '');
    window.history.replaceState({}, document.title, newUrl);
</script>