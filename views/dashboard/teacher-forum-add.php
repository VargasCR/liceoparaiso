<?php include_once __DIR__  . '/teacher-header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <style>
    
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/prism.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/themes/prism.min.css">
</head>
<body>
<div class="forum-button-panel">
      <button onclick="addItemTeacherForum('h1')">Titulo 1</button>
      <button onclick="addItemTeacherForum('h2')">Titulo 2</button>
      <button onclick="addItemTeacherForum('h3')">Titulo 3</button>
      <button onclick="addItemTeacherForum('h4')">Titulo 4</button>
      <button onclick="addItemTeacherForum('p')">Párrafo</button>
      <button onclick="addItemTeacherForum('a')">Link</button>
      <button onclick="addItemTeacherForum('img')">Imagen</button>
 


</div>

<pre contenteditable="true" oninput="updatePreview(this)" id="prev-code" class="hidden">
  <code class="language-html" id="forum-code" class="hidden">
    
  </code>
</pre>

  <form class="preview" method="POST">
    <input type="submit" value="Guardar">
    <fieldset id="">
      <legend>Información</legend>
      <div class="campo">
        <label for="">Título</label>
        <input type="text" id="search-input" name="titulo" maxlength="100">
      </div>

        
      <div class="campo">
        <label for="">Categoría</label>
        <select name="categoria" id="search-input">
            <option value="opcion1">Opción 1</option>
            <option value="opcion2">Opción 2</option>
            <option value="opcion3">Opción 3</option>
            <!-- Puedes añadir más opciones si lo deseas -->
        </select>
      </div>
    </fieldset>
    <fieldset id="previewForm">
      <legend>Contenido</legend>
      <h4 id="empty" style="text-align: center;">Vacío</h3>
    </fieldset>
  </form>

</body>


<?php include_once __DIR__  . '/footer-dashboard.php'; ?>
 <script src="/build/js/teacherForum.js"></script>

