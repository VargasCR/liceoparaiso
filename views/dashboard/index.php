<?php include_once __DIR__  . '/header-dashboard.php'; ?>


<div class="contenedor-sm">
    <?php include_once __DIR__ .'/../templates/alertas.php'; ?>
    <form class="form-news" method="POST">
        <div class="slot">
            <label>Título</label>
            <input maxlength="100" type="text" name="titulo" value="<?php echo $editanto_noticia['titulo']; ?>">
        </div>
        <div class="slot">
            <label>Descripción</label>
            <textarea maxlength="350" name="descripcion"><?php echo $editanto_noticia['descripcion']; ?></textarea>
        </div>
        <input type="submit" value="Guardar" class="btn-news">
    </form>
    <?php if(!empty($noticias)) {
        foreach ($noticias as $noti) { ?>
            <form class="form-noticia" action="/noticias-borrar" method="POST">
                <h3><?php echo $noti->titulo; ?></h3>
                <p><?php echo $noti->descripcion; ?></p>
                <p style="font-size: 1.5rem;">Creado el: <?php echo $noti->fecha; ?></p>
                <input type="hidden" name="id" value="<?php echo $noti->id; ?>">
                <input type="submit" value="Borrar">
            </form>
       <?php }
    } else {
        echo "<div style='width: 100%;text-align: center;'><p>No hay noticias</p></div>";

    }?>
    
    </div>

<?php include_once __DIR__  . '/footer-dashboard.php'; ?>