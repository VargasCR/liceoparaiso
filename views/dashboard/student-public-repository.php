<?php include_once __DIR__  . '/student-header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <style>
    
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/prism.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/themes/prism.min.css">
</head>

<body>
<div class="fx">
        <form method="POST" action="" style="display: flex;align-items: center;width: 100%;margin: 0 0 0 0.75rem !important;">
        <input type="submit" value="Buscar" class="btn-top" style="width: auto !important;">
          <input
            type="text"
            name="search"
            id="search-input"
            class=""
            placeholder="Palabras de busqueda"
            style="margin: 0 0 0 0.4rem !important;"
            maxlength="75"
            value="<?php echo $phrase ?? '';?>"
          />
          <input type="hidden" value="kydt" name="type">
        </form>
 
</div>
  

    <?php
    
    if(!empty($foros)) {?>
    <?php foreach ($foros as $value) { ?>
      <div style="display: flex;align-items: center;padding:0.5rem">
              <?php if($value->icon_img != null) { ?>
                <a href="/student-forum?<?php echo base64_encode('id').'='.base64_encode($value->id); ?>">
                  <img width="40px" height="40px" alt="" srcset="<?php echo $value->icon_img; ?>">

                </a>
             <?php } ?>
             <a style='display:block;margin: 1rem 1rem;font-size:2.4rem;' href="/student-forum?<?php echo base64_encode('id').'='.base64_encode($value->id); ?>"><?php echo $value->titulo;?></a>
            </div>
   <?php } 
   } else {echo "<h4 style='text-align:center;'>Sin resultados</h4>";}?>

</body>


<?php include_once __DIR__  . '/footer-dashboard.php'; ?>
 <script src="/build/js/teacherForum.js"></script>

