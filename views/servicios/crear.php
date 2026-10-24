<h1 class="nombre-pagina">Nuevo Servicios</h1>
<p class="descripcion-pagina">Llena todos los campos para añadir un servicio</p>

<?php include_once __DIR__ . '/../templates/barra.php' ?>

<form action="/servicios/crear" method="POST" class="formnulario">
    
    <?php include_once __DIR__ . '/formulario.php'; ?>
    <input type="submit" class="boton" value="Guardar Servicio">
</form>