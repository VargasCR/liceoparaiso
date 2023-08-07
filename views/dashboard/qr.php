<?php include_once __DIR__  . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    <a href='/dashboard-student' class="btn-top mb-1"><img src="/build/img/atras.svg" class="btn-student-ico" alt="Icono"></a>
    <div class="fx">
      
     

  </div>
        
        <form method="POST" action="" class="qr-search-form">
            <div class="slot">
                <label for="">Desde</label>
                <input type="date" value="<?php echo $dateFrom ?? date('Y-m-d')?>" name="dateFrom" id="">
            </div>
            <div class="slot">
                <label for="">Hasta</label>
                <input type="date" value="<?php echo $dateTo ?? date('Y-m-d')?>" name="dateTo" id="">
            </div>
            <input type="submit" value="Buscar">
        </form>
    



        
                    <?php if (!empty($asistencia_beca)) { ?>
                        <div style="overflow-x: auto !important;margin:1rem 0 0 0">
                    <table class="schedule-table">
                        <thead>
                            <tr>
                                <th>Cédula</th>
                                <th>Nombre</th>
                                <th>Seccion</th>
                                <th>Fecha</th>
                                <th>Borrar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($asistencia_beca as $key => $value) {

                                $cedula = 0;
                                $nombre = 0;
                                $seccion = 0;
                                $query = $_SERVER['QUERY_STRING'];
                                foreach ($estudiantes as $estudiante => $info) {
                                    if($info->id == $value->estudianteID) {
                                        $nombre = $info->nombre.' '.$info->apellido;
                                        $cedula = $info->dni;
                                        foreach ($grupos as $grupo => $secc) {
                                            if($secc->id == $info->seccion) {
                                                $seccion = $secc->grado.'-'.$secc->seccion;
                                            }
                                        }
                                    }
                                }
                                echo "
                                <tr>
                                    <td colspan='1'>{$cedula}</td>
                                    <td colspan='1'>{$nombre}</td>
                                    <td colspan='1'>{$seccion}</td>
                                    <td colspan='1'>{$value->fecha}</td>
                                    <td colspan='1'>
                                    <form method='POST' action='/admin-delete-qr'>
                                        <input type='hidden' value='{$value->id}' name='id'>
                                        <button class='btn-report' type='submit'><img src='/build/img/delete-student.svg' width='16px' class='btn-student-ico' alt='Icono'></button>
                                    </form></td>
                                </tr>";
                            }
                            ?>
                            
                                    
                        </tbody>
                    </table>
          
    
    </div>
                    <?php } else {echo "<h4>NO HAY RESULTADOS</h4>";}?>
            
    
    <?php include_once __DIR__  . '/footer-dashboard.php'; ?>
    <script src="/build/js/sweetAlert.js"></script>
    <script type="text/javascript" src="/build/js/qrscanner.js"></script>