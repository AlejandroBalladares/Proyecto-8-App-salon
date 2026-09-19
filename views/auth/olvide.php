<h1 class="nombre-pagina">Olvide password</h1>
<p class="descripcion-pagina">Restablece tu password escribiendo tu mail</p>

<form class="formulario" action="POST" method="/olvide">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="tu email">
    </div>

    <input type="submit" class="boton" value="Enviar instrucciones">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes cuenta? Inicia sesion</a>
    <a href="/crear-cuenta">¿Aún no tienes cuenta? Crea una</a>
</div>