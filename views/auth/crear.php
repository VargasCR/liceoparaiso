<div class="contenedor crear">
    <?php include_once __DIR__ .'/../templates/nombre-sitio.php'; ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu cuenta</p>

        <?php include_once __DIR__ .'/../templates/alertas.php'; ?>

        <form class="form" method="POST" action="/crear">
            <div class="slot">
                <label for="nombre">Nombre</label>
                <input 
                    type="text"
                    id="email"
                    placeholder="Tu nombre"
                    name="nombre"
                    value="<?php echo $usuario->nombre; ?>"
                />
            </div>
            <div class="slot">
                <label for="email">Cédula de identidad</label>
                <input 
                    type="text"
                    id="email"
                    placeholder="Tu Cédula"
                    name="dni"
                    value="<?php echo $usuario->dni; ?>"
                />
            </div>
            <div class="slot">
                <label for="email">Correo Electrónico</label>
                <input 
                    type="text"
                    id="email"
                    placeholder="Tu E-mail"
                    name="email"
                    value="<?php echo $usuario->email; ?>"
                />
            </div>

            <div class="slot">
                <label for="password">Password</label>
                <input 
                    type="password"
                    id="password"
                    placeholder="Tu Password"
                    name="password"
                />
            </div>

            <div class="slot">
                <label for="password2">Repetir Password</label>
                <input 
                    type="password"
                    id="password2"
                    placeholder="Repite tu Password"
                    name="password2"
                />
            </div>

            <input type="submit" class="boton" value="Crear Cuenta">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
            <a href="/olvide">¿Olvidaste tu Password?</a>
        </div>
    </div> <!--.contenedor-sm -->
</div>