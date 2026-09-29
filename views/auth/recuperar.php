<?php /** @var Bool $error */ ?>

<h1 class="nombre-pagina">Restablecer contraseña</h1>
<p class="descripcion-pagina"> Coloca tu nueva contraseña a continuacion</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<?php if($error) return null; ?>

<form class="formulario" method="POST">
    
    <div class="campo">
        <label for="contraseña">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Tu nueva contraseña">
    </div>

    <input type="submit" value="Guardar" class="boton">

</form>

<div class="acciones">
    <a href="/">¿Ya tienes cuenta? Inicia sesion</a>
    <a href="/crear-cuenta">¿Aún no tienes cuenta? Click aquí</a>
</div>