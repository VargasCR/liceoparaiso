

<fieldset>
    <legend>Información</legend>
    
<div class="slot">
    <label for="nombre">Nombre</label>
    <input 
        type="text" 
        id="nombre" 
        placeholder="Nombre completo del estudiante" 
        name="nombre" 
        value="<?php echo $estudiante->nombre ?? ''; ?>">
</div>
<div class="slot">
    <label for="title">Apellidos</label>
    <input 
        type="text" 
        id="apellido" 
        placeholder="Ambos apellidos del estudiante" 
        name="apellido" 
        value="<?php echo $estudiante->apellido ?? ''; ?>"></input>
</div>
<div class="slot">
    <label for="dni">Cedula</label>
    <input 
    type="text"
    id="dni"
    name="dni"
    placeholder="Cédula de identidad"
    value="<?php echo $estudiante->dni ?? ''; ?>"
    ></input>
</div>
<div class="slot">
    <label for="seccion">Seccion</label>
    <select name="seccion" id="seccion">
        <option selected value="" id="seccion">-- Seleccione --</option>
        <?php foreach($grupos as $grupo) { ?>
            <option <?php echo $estudiante->seccion === $grupo->id ? 'selected' : '' ?> 
            value="<?php echo s($grupo->id); ?>">
            <?php echo s($grupo->grado) . " - " . s($grupo->seccion); ?>
        <?php  } ?>
</select>


<div class="slot">
    <label for="image">Fotografía:</label>
    
    <?php if($estudiante->id) { ?>
        <img src="/build/img/pictures/<?php echo $estudiante->id.'.jpg' ?? ''; ?>" class="image-edit">
    <?php } ?>
    <input type="file" id="image" accept="image/jpeg, image/png" name="image">
        
</div>


        
    </select>
</div>

<div class="slot">
    <label for="comedor">¿Beca Comedor?</label>
    <input 
    type="checkbox"
    id="comedor" 
    name="comedor"
    <?php 
        if ($estudiante->comedor === '1') {
            echo "checked";
            // Contenido que deseas mostrar si la condición es verdadera
        }
    ?>
    ></input>
</div>
<div class="slot">
    <label for="transporte">¿Beca Transporte?</label>
    <input 
    type="checkbox"
    id="transporte" 
    name="transporte"
    <?php 
        if ($estudiante->transporte === '1') {
            echo "checked";
            // Contenido que deseas mostrar si la condición es verdadera
        }
    ?>
    
    ></input>
</div>
        <div 
        class="<?php if ($estudiante->transporte !== '1') {
                echo "hidden";
            // Contenido que deseas mostrar si la condición es verdadera
        };?>"
        id="divtransporte">
<div class="slot">
    <label for="ruta">Ruta</label>
    <input 
    type="numeric"
    id="ruta" 
    name="ruta"
    value="<?php echo $estudiante->ruta ?? '';?>"
    
    ></input>
</div>

<div class="slot">
    <label for="asiento">Asiento</label>
    <input 
    type="numeric"
    id="asiento" 
    name="asiento"
    value="<?php echo $estudiante->asiento ?? '';?>"
    
    
    ></input>
</div>
</div>

</fieldset>
