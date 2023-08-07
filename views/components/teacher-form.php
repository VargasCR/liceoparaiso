

<fieldset>
    <legend>Información</legend>
    
<div class="slot">
    <label for="nombre">Nombre</label>
    <input 
        type="text" 
        id="nombre" 
        placeholder="Nombre completo del profesor" 
        name="nombre" 
        value="<?php echo $profesor->nombre ?? ''; ?>">
</div>
<div class="slot">
    <label for="title">Apellidos</label>
    <input 
        type="text" 
        id="apellido" 
        placeholder="Ambos apellidos del profesor" 
        name="apellido" 
        value="<?php echo $profesor->apellido ?? ''; ?>"></input>
</div>
<div class="slot">
    <label for="dni">Cedula</label>
    <input 
    type="text"
    id="dni"
    name="dni"
    placeholder="Cédula de identidad"
    value="<?php echo $profesor->dni ?? ''; ?>"
    ></input>
</div>
<div class="slot">
    <label for="materias">Especialidad</label>
    <input 
    type="text"
    id="materias"
    name="materias"
    placeholder="Lista de especialidades"
    value="<?php echo $profesor->materias ?? ''; ?>"
    ></input>
</div>
<div class="slot">
    <label for="image">Fotografía:</label>
    
    <?php if($profesor->id) { ?>
        <img src="/build/img/pictures/<?php echo $profesor->id.'p.jpg' ?? ''; ?>" class="image-edit">
    <?php } ?>
    <input type="file" id="image" accept="image/jpeg, image/png" name="image">
        
</div>
</fieldset>
