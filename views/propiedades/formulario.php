<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Titulo:</label>
    <input 
        type="text" 
        id="titulo" 
        name="propiedad[titulo]" 
        placeholder="Titulo Propiedad" 
        value="<?php echo sanitizar($propiedad->titulo); ?>">

    <label for="precio">Precio:</label>
    <input 
        type="number" 
        id="precio" name="propiedad[precio]" 
        placeholder="Precio Propiedad" 
        value="<?php echo sanitizar($propiedad->precio); ?>">

    <label for="imagen">Imagen:</label>
    <input 
        type="file" 
        accept="image/jpeg, image/png" 
        id="imagen"
        name="propiedad[imagen]">

        <?php if($propiedad->imagen){ ?>
            <img src="/imagenes/<?php echo $propiedad->imagen ?>" alt="Imagen propiedad" class="imagen-small">
        <?php } ?>

    <label for="descripcion">Descripción</label>
    <textarea id="description" name="propiedad[descripcion]"><?php echo sanitizar($propiedad->descripcion) ?></textarea>
</fieldset>

<fieldset>
    <legend>Información Propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input 
        type="number" 
        id="habitaciones" 
        name="propiedad[habitaciones]" 
        placeholder="Ejemplo: 3" 
        min="1" max="9" 
        value="<?php echo sanitizar($propiedad->habitaciones); ?>">

    <label for="wc">Baños:</label>
    <input 
        type="number" 
        id="wc" name="propiedad[wc]" 
        placeholder="Ejemplo: 3" 
        min="1" 
        max="9" 
        value="<?php echo sanitizar($propiedad->wc); ?>">

    <label for="estacionamiento">Estacionamientos:</label>
    <input 
        type="number" 
        id="estacionamiento" 
        name="propiedad[estacionamiento]" 
        placeholder="Ejemplo: 3" 
        min="1" 
        max="9" 
        value="<?php echo sanitizar($propiedad->estacionamiento); ?>">

</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    <label for="vendedor">Vendedor</label>
    <select name="propiedad[vendedores_id]" id="vendedor">
        <option value="">-- Seleccione --</option>
        <?php foreach($vendedores as $vendedor) { ?>
            <option 
            <?php echo $propiedad->vendedores_id === $vendedor->id ? 'selected' : ''; ?>
            value="<?php echo sanitizar($vendedor->id) ?>"><?php echo sanitizar($vendedor->nombre) . " " . sanitizar($vendedor->apellido); ?></option>
        <?php } ?>
    </select>
</fieldset>