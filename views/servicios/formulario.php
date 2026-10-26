<?php /** @var Object $servicio */ ?>

<div class="campo">
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" placeholder="nombre servicio" name="nombre" value="<?php echo $servicio->nombre ?>">
</div>

<div class="campo">
    <label for="precio">Precio</label>
    <input type="number" id="precio" placeholder="precio servicio" name="precio" value="<?php echo $servicio->precio ?>">
</div>

