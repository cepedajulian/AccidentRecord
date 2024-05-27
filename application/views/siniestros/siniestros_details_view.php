<?php error_reporting(0); ?>

<script src="<?php echo base_url(); ?>assets/plugins/fancybox/jquery.fancybox.pack.js"></script>
<link href="<?php echo base_url(); ?>assets/plugins/fancybox/jquery.fancybox.css" rel="stylesheet">

<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

    <div class="row">
        <div id="breadcrumb" class="col-md-12">
            <a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
                <li><a href="<?php echo site_url('/siniestros'); ?>">Siniestros</a></li>
                <li><a href="#">Datos del siniestro</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h3 class="page-header">Datos del siniestro</h3>
            <BR>
            <?php if (validation_errors()) echo "<div class='bg-danger'>" . utf8_encode(validation_errors()) . "</div>"; ?>
            <br>
        </div>	
    </div>

    <?php echo form_open('siniestros/add', array('id' => 'siniestrosForm', 'class' => 'form-horizontal bootstrap-validator-form')); ?>
    <input type="hidden" value="1" name="sendform">
    <input type="hidden" value="<?php if (isset($siniestro)) {
        echo $siniestro['id'];
    } ?>" name="id" id="id">
    <input type="hidden" class="form-control" id="latlng" name="latlng" value="<?php if (isset($siniestro)) {
        echo $siniestro['latlng'];
    } ?>" />

    <div class="row">	
        <div class="col-xs-12 col-sm-6">
            <div class="box">
                <div class="box-header">
                    <div class="box-name">
                        <i class="fa fa-folder-open-o"></i>
                        <span>Datos del siniestro</span>
                    </div>
                    <div class="box-icons">
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        <a class="expand-link"><i class="fa fa-expand"></i></a>

                    </div>
                    <div class="no-move"></div>
                </div>
                <div class="box-content no-padding">
                    <br>
                    <fieldset>
                        <dl class="dl-horizontal">
                            <dt>Localidad:</dt>
                            <?php if (empty($siniestro['localidad'])) { ?>
                                <dd>&nbsp;<?php if (isset($siniestro)) {
                                echo $siniestro['ciudad'];
                            } ?></dd>
<?php } else { ?>
                                <dd>&nbsp;<?php if (isset($siniestro)) {
        echo $siniestro['localidad'];
    } ?></dd>
<?php } ?>
                            <dt>Fecha:</dt>
                            <dd>&nbsp;<?php if (isset($siniestro)) {
    echo format_fecha($siniestro['fecha']);
} ?></dd>
                            <dt>Hora:</dt>
                            <dd>&nbsp;<?php if (isset($siniestro)) {
    echo format_hora($siniestro['fecha']);
} ?></dd>
                            <dt>Tipo de Siniestro:</dt>
                            <dd>&nbsp;<?php if (isset($siniestro)) {
    echo $siniestro['tipo'];
} ?></dd>
                            <dt>Calle/Ruta:</dt>
                            <dd>&nbsp;<?php if (isset($siniestro)) {
    echo $siniestro['calle1'];
} ?></dd>
                            <dt>Altura/km:</dt>
                            <dd>&nbsp;<?php if (!empty($siniestro['nro'])) {
    echo $siniestro['nro'];
} ?></dd>
<?php if (isset($siniestro['calle2'])) { ?>
                                <dt>Esquina 1:</dt>
                                <dd>&nbsp;<?php if (isset($siniestro)) {
        echo $siniestro['calle2'];
    } ?></dd>
<?php } ?>
<?php if (isset($siniestro['calle3'])) { ?>
                                <dt>Esquina 2:</dt>
                                <dd>&nbsp;<?php if (isset($siniestro)) {
        echo $siniestro['calle3'];
    } ?></dd>
<?php } ?>
                            <dt>Detalle de la ubicaci&oacute;n:</dt>
                            <dd>&nbsp;<?php if (isset($siniestro)) {
    echo $siniestro['ubicacion'];
} ?></dd>
                            <dt>Tipo de Calzada:</dt>
                            <dd>&nbsp;<?php if (isset($siniestro)) {
    echo $siniestro['tipocalzada'];
} ?></dd>
                            <dt>Clima:</dt>
                            <dd>&nbsp;<?php if (isset($siniestro)) {
    echo $siniestro['clima'];
} ?></dd>
                            <dt>Visibilidad:</dt>
                            <dd>&nbsp;<?php if (isset($siniestro)) {
    echo $siniestro['horario'];
} ?></dd>
                            <dt>Causa 1:</dt>
                            <dd>&nbsp;<?php if (isset($siniestro)) {
    echo $siniestro['causaTxt'];
} ?></dd>
                            <dt>Causa 2:</dt>
                            <dd>&nbsp;<?php if (isset($siniestro)) {
    echo $siniestro['causa2Txt'];
} ?></dd>
                            <dt>Causa 3:</dt>
                            <dd>&nbsp;<?php if (isset($siniestro)) {
    echo $siniestro['causa3Txt'];
} ?></dd>
                            <!-- dt>Patentes asociadas:</dt>
                                    <dd>&nbsp;<?php if (isset($siniestro)) {
    echo $siniestro['patentes'];
} ?></dd>
                            <dt>Relevamiento:</dt>
                                    <dd>&nbsp;<?php if (isset($siniestro)) {
    echo $siniestro['relevamiento'];
} ?></dd>
                            <dt>Rastros:</dt>
                                    <dd>&nbsp;<?php if (isset($siniestro)) {
    echo $siniestro['rastros'];
} ?></dd> -->
                            <dt>Fuerza:</dt>
                            <dd>&nbsp;<?php if (isset($siniestro)) {
    echo $siniestro['fuerza'];
} ?></dd>
                            <dt>Descripci&oacute;n:</dt>
                            <dd>&nbsp;<?php if (isset($siniestro)) {
    echo $siniestro['descripcion'];
} ?></dd>
                        </dl>					

                    </fieldset>
                    <br><br><br><br><br>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="box">
                <div class="box-header">
                    <div class="box-name">
                        <i class="fa fa-folder-open-o"></i>
                        <span>Veh&iacute;culos involucrados</span>
                    </div>
                    <div class="box-icons">
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        <a class="expand-link"><i class="fa fa-expand"></i></a>

                    </div>
                    <div class="no-move"></div>
                </div>
                <div class="box-content no-padding">
                    <br>
                    <fieldset>

                        <div class="form-group">
                            <table class="topInfractores" id="tablaVictimas">
                            <?php if (!empty($vehiculos)) { ?>
                                    <tr>
                                        <th>TIPO</th>
                                        <th>MARCA</th>
                                        <th>MODELO</th>
                                        <th>A&Ntilde;O</th>
                                        <th>PANTENTE</th>
                                        <th>COLOR</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                <?php foreach ($vehiculos as $vehiculo) { ?>
                                        <tr>
                                            <td><?php echo $vehiculo->tipo; ?></td>
                                            <td><?php echo $vehiculo->marca; ?></td>
                                            <td><?php echo $vehiculo->modelo; ?></td>
                                            <td><?php echo $vehiculo->anio; ?></td>
                                            <td><?php echo $vehiculo->patente; ?></td>
                                            <td><?php echo $vehiculo->color; ?></td>
                                        </tr>
                                <?php } ?>	
                                <?php
                                } else
                                    echo "* No hay veh&iacute;culos registrados.";
                                ?>
                            </table>
                        </div>

                    </fieldset>
                    <br><br>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="box">
                <div class="box-header">
                    <div class="box-name">
                        <i class="fa fa-folder-open-o"></i>
                        <span>Datos de los implicados</span>
                    </div>
                    <div class="box-icons">
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        <a class="expand-link"><i class="fa fa-expand"></i></a>

                    </div>
                    <div class="no-move"></div>
                </div>
                <div class="box-content no-padding">
                    <br>
                    <fieldset>

                        <div class="form-group">
                            <table class="topInfractores" id="tablaVictimas">
                            <?php if (!empty($victimas)) { ?>
                                    <tr>
                                        <th>DNI</th>
                                        <th>VEHICULO</th>
                                        <th>SEXO</th>
                                        <th>EDAD</th>
                                        <th>LESION</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                <?php foreach ($victimas as $victima) { ?>
                                        <tr>
                                            <td><?php echo $victima->dni; ?></td>
                                            <td><?php echo $victima->tipo; ?></td>
                                            <td><?php echo $victima->sexo; ?></td>
                                            <td><?php echo $victima->edad; ?></td>
                                            <td><?php echo $victima->lesion; ?></td>
                                        </tr>
                                <?php } ?>	
                            <?php } else
                                    echo "* No hay implicados registrados.";
                            ?>
                            </table>
                        </div>

                    </fieldset>
                    <br><br>
                </div>
            </div>
        </div>
        
        <!-- BOX IMAGES -->
        <div class="col-xs-12 col-sm-6">
            <div class="box">
                <div class="box-header">
                    <div class="box-name">
                        <i class="fa fa-folder-open-o"></i>
                        <span>Imagenes</span>
                    </div>
                    <div class="box-icons">
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        <a class="expand-link"><i class="fa fa-expand"></i></a>

                    </div>
                    <div class="no-move"></div>
                </div>
                <div class="box-content no-padding" style="max-height: 250px;">
                    <br>
                    <fieldset>
                        <div class="form-group">
                            <?php if (!empty($siniestro['imagenes'])) { ?>
                                <?php foreach ($siniestro['imagenes'] as $imagen) { ?>
                            
                            <a id="<?php echo $imagen->id; ?>" class="fancybox" rel="group" href="<?php echo base_url(); ?>files/imagenes/siniestros/<?php echo $imagen->filename; ?>">
                                <img src="<?php echo base_url(); ?>files/imagenes/siniestros/thumb/<?php echo $imagen->filename; ?>" alt="" />
                            </a>
                                <?php } ?>	
                            <?php } ?>                            
                        </div>
                    </fieldset>
                    <br><br>
                </div>
            </div>
        </div>
        <!-- /BOX IMAGES -->
        
        <div class="col-xs-12 col-sm-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-name">
                        <i class="fa fa-folder-open-o"></i>
                        <span>Geolocalizaci&oacute;n</span>
                    </div>
                    <div class="box-icons">
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        <a class="expand-link"><i class="fa fa-expand"></i></a>

                    </div>
                    <div class="no-move"></div>
                </div>
                <!--
                <div class="box-content no-padding">
                    <div id="map"  style="width:100%; max-width:1000px;height:300px;"></div>
                </div>-->
                <div style="width:100%;text-align:left;padding:10px">
                        <div id="map"  style="width:100%; max-width:auto;height:600px;margin: auto;"></div>             
                </div>
            </div>
        </div>
        
        <div style="clear:both"></div>
        <div style="width:100%;text-align:center;padding:10px">
            <a href="javascript:window.history.go(-1);">
                <button class="btn btn-primary btn-label-left" type="button">
                    Volver
                </button>
            </a>
        </div>
<?php echo form_close(); ?>

    </div>

</div><!--End Content-->

<?php

function format_fecha($fecha) {
    $date = new DateTime($fecha);
    return $date->format('d-m-Y');
}

function format_hora($fecha) {
    $date = new DateTime($fecha);
    return $date->format('H:i');
}
?>
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrapvalidator/bootstrapValidator.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/validations.js"></script>

<script type="text/javascript">
    // Run Select2 on element
    function Select2Test() {
        $("#tipoaccidente").select2();
        $("#victimas").select2();
        $("#calle1").select2();
        $("#calle2").select2();
        $("#calle3").select2();
        $("#tipocalzada").select2();
        $("#clima").select2();
        $("#horario").select2();
        $("#causa").select2();

        $("#sexo").select2();
        $("#tipovehiculo").select2();
        $("#edad").select2();
        $("#lesion").select2();
    }
    $(document).ready(function () {
        
        $(".fancybox").fancybox();
        
        $('#fecha').datepicker({dateFormat: "dd/mm/yy", altFormat: "yy-mm-dd", altField: "#fecha"});
        // Load script of Select2 and run this
        LoadSelect2Script(Select2Test);
        // Load example of form validation
        LoadBootstrapValidatorScript(FormValidator);
        WinMove();
    });
    
</script>

<script>

    function addVictima() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/siniestros/ajaxVictimas",
            data: {action: 'add',
                idSiniestro: $("#id").val(),
                tipovehiculo: $("#tipovehiculo").val(),
                edad: $("#edad").val(),
                sexo: $("#sexo").val(),
                cinturon: $("#cinturon").val(),
                casco: $("#casco").val(),
                lesion: $("#lesion").val()
            },
            cache: false,
            success:
                    function (data) {
                        $("#tablaVictimas").html(data);
                    }
        });
    }

    function delVictima($idVictima) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/siniestros/ajaxVictimas",
            data: {action: 'del',
                idSiniestro: $("#id").val(),
                idVictima: $idVictima,
                edad: $("#edad").val(),
                sexo: $("#sexo").val(),
                cinturon: $("#cinturon").val(),
                casco: $("#casco").val(),
                lesion: $("#lesion").val()
            },
            cache: false,
            success:
                    function (data) {
                        $("#tablaVictimas").html(data);
                    }
        });
    }


    function iniciar2() {

        var mapOptions = {
            center: new google.maps.LatLng(<?php if (!empty($siniestro['latlng'])) echo $siniestro['latlng'];
else echo $latlng; ?>),
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP};
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);
        //marcador con la ubicaci�n de la Universidad
        i = 0;
<?php
if ($siniestro['latlng'] == null || $siniestro['latlng'] == "")
    $siniestro['latlng'] = $latlng;;
$latlng = explode(',', $siniestro['latlng']);
?>

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(<?php echo $latlng[0]; ?>,<?php echo $latlng[1]; ?>),
            draggable: true,
            map: map
        });

        //Dispara accion al dar un clic en el marcador          
        google.maps.event.addListener(marker, 'click', function () {
            map.setZoom(14); //aumenta el zoom
            map.setCenter(marker.getPosition());
            var contentString = 'Ubicaci�n Actual';
            var infowindow = new google.maps.InfoWindow({
                content: '<?php
                    echo '<b>Fecha:</b>&nbsp;&nbsp;  ' . format_fecha($siniestro['fecha']) . '<br>' .
                    '<b>Hora:</b>&nbsp;&nbsp;  ' . format_hora($siniestro['fecha']) . '<br>' .
                    '<b>Implicados:</b>&nbsp;&nbsp;  ' . count($victimas) . '<br>' .
                    '<b>Tipo de accidente:</b>&nbsp;&nbsp;  ' . $siniestro['tipo']
                    ?>'
            });
            infowindow.open(map, marker);
        });

        google.maps.event.addListener(marker, 'dragend', function (event) {
            document.getElementById("latlng").value = this.getPosition().lat() + ',' + this.getPosition().lng();
        });



    }
</script>

<script src="https://maps.google.com/maps/api/js?key=...&sensor=false&callback=iniciar2" loading=async></script>