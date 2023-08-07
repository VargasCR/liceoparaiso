<?php include_once __DIR__  . '/teacher-header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <style>
    
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/prism.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/themes/prism.min.css">
</head>

<body>
  <div class="fx">
      <a href='/dashboard-teacher-repository' class="btn-top mb-1"><img src="/build/img/add-student.svg" class="btn-student-ico" alt="Icono"></a>
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
  
    <br>

    <?php
    if($mis_foros != null) {
      $encontrado = false;
      ?>
      <h4 style="font-size: 2.5rem;margin: 1rem 0;text-align:center;">Mis Foros</h4>
      <?php foreach ($foros as $value) { 
        
        if($value->profesor == $mis_foros) { 
          $encontrado = true;?>
          <div id="div-delete-post" style="padding:0.5rem">
                    <form id="form-delete-post" action="" method="POST">
                      <input type="hidden" value="<?php echo base64_encode($value->id); ?>" name="id">
                      <input id="input-delete-post" type="submit" value="X">
                    </form>
                    <div style="display: flex;align-items: center;">
                        <?php if($value->icon_img != null) { ?>
                          <a href="/open-admin-forum?<?php echo base64_encode('id').'='.base64_encode($value->id); ?>">
                            <img width="40px" height="40px" alt="" srcset="<?php echo $value->icon_img; ?>">

                          </a>
                      <?php } ?>
                      </div>
                    <a style='display:block;margin: 1rem 1rem;font-size:2.4rem;' href="/teacher-forum?<?php echo base64_encode('id').'='.base64_encode($value->id); ?>"><?php echo $value->titulo;?></a>
                  </div>
    <?php }?>
        
        <?php }
        if(!$encontrado) {
          echo "<h4 style='text-align:center;'>Sin resultados</h4>";
        }
    }
    if(!empty($foros)) {
      $encontrado = false;?>
      <h4 style="font-size: 2.5rem;margin: 1rem 0;text-align:center;">Otros Foros</h4>
    <?php foreach ($foros as $value) { 
      
      if($value->profesor != $mis_foros) { 
        $encontrado = true;?>
      <div style="display: flex;align-items: center;padding:0.5rem">
              <?php if($value->icon_img != null) { ?>
                <a href="/teacher-forum?<?php echo base64_encode('id').'='.base64_encode($value->id); ?>">
                  <img width="40px" height="40px" alt="" srcset="<?php echo $value->icon_img; ?>">

                </a>
             <?php } ?>
             <a style='display:block;margin: 1rem 1rem;font-size:2.4rem;' href="/teacher-forum?<?php echo base64_encode('id').'='.base64_encode($value->id); ?>"><?php echo $value->titulo;?></a>
            </div>
            <?php }?>
   <?php } 
   if(!$encontrado) {
    echo "<h4 style='text-align:center;'>Sin resultados</h4>";
  }
   }?>

</body>


<?php include_once __DIR__  . '/footer-dashboard.php'; ?>
 <script src="/build/js/teacherForum.js"></script>

