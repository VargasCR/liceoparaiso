<?php include_once __DIR__  . '/student-header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/prism.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.23.0/themes/prism.min.css">
</head>

<body>
  <a href='/dashboard-student-repository' class="btn-top mb-1"><img src="/build/img/atras.svg" class="btn-student-ico" alt="Icono"></a>
  <div class="forum-div">
    <?php 
    // Combina los dos arrays
    $combinedArray = array_merge($foros_items, $foros_enlaces,$foros_images);

    // Función de comparación para ordenar según 'ind'
    function compareInd($a, $b) {
        return strcmp($a->ind, $b->ind);
    }

    // Ordena el array combinado por el valor de 'ind'
    usort($combinedArray, 'compareInd');


    
    foreach ($combinedArray as $item) {
      if($item->enlace != null) { ?>
        <br>
          <a href="<?php echo $item->enlace; ?>"><?php echo $item->titulo;?></a>
        <br>
      <?php } 
      elseif($item->clase == 'img') { ?>
      <div style="text-align:center;">
        <img src="<?php echo $item->url; ?>" alt="" width="<?php echo $item->width; ?>%" height="<?php echo $item->height; ?>%">
      </div>
     <?php } else { ?>
        <<?php echo $item->clase?>><?php echo $item->texto; ?></<?php echo $item->clase?>>
      <?php } ?>
    <?php } ?>
  </div>


</body>


<?php include_once __DIR__  . '/footer-dashboard.php'; ?>
 <script src="/build/js/teacherForum.js"></script>

