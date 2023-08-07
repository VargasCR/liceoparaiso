<aside class="sidebar">
    <div class="contenedor-sidebar">
    <div style="width: 100%;text-align: center;">
<img id=""width="75" src="build/img/liceo_el_paraiso_icon_258px.png" alt="">
</div>

        <div class="cerrar-menu">
            <img id="cerrar-menu" src="build/img/cerrar.svg" alt="imagen cerrar menu">
        </div>
    </div>
    

    <nav class="sidebar-nav">
        
        <a class="<?php echo ($titulo === 'Secciones') ? 'activo' : ''; ?>" href="/student-dashboard">Noticias</a>
        <a class="<?php echo ($titulo === 'Biblioteca') ? 'activo' : ''; ?>" href="/dashboard-student-repository">Biblioteca</a>

        <!--<a class="<?php echo ($titulo === 'Perfil') ? 'activo' : ''; ?>" href="/perfil">Perfil</a> -->
    </nav>

    <div class="cerrar-sesion-mobile">
        <a href="/logout" class="cerrar-sesion">Cerrar Sesión</a>
    </div>
</aside>