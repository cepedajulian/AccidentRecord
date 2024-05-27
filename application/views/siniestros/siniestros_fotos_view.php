
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dropzone/css/dropzone.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dropzone.js"></script>

<script src="<?php echo base_url(); ?>assets/js/zoomify.min.js"></script>
<link href="<?php echo base_url(); ?>assets/css/zoomify.min.css" rel="stylesheet">

<style type="text/css"> 
    .file-actions a{
        margin-right:10px; 
        float:left;
    }
</style>

<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

    <div class="row">
        <div id="breadcrumb" class="col-md-12">
            <a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
                <li>Siniestros</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12">
            <h3 class="page-header">Siniestros</h3>
            <br>
        </div>
    </div>

    <div class="row" >
        <div class="col-xs-12">
            
            <button class="btn btn-primary btn-label-left" type="button" id="btn_cargar_imagen">
                <span><i class="fa fa-paperclip"></i></span> Cargar Imagen
            </button>
            
            <a class="btn btn-primary btn-label-left" href="<?php echo site_url('/siniestros/') ?>"> 
                <span><i class="fa fa-backward"></i></span> Volver
            </a>
            <div class="box">
                <div class="box-header">
                    <div class="box-name">
                        <i class="fa fa-folder-open-o"></i>
                        <span>Fotos del Siniestro / Formulario de Datos del Siniestro </span>
                    </div>
                    <div class="box-icons">
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        <a class="expand-link"><i class="fa fa-expand"></i></a>

                    </div>
                    <div class="no-move"></div>
                </div>

                <div class="mediamgr">
                    <div class="mediamgr_left">
                        <div class="mediamgr_content_large">
                            <ul id="medialist" class="listfile">
                                <?php if (!empty($siniestro['imagenes'])) { ?>
                                    <?php foreach ($siniestro['imagenes'] as $imagen) { ?>
                                        <li class="image" id="li_<?php echo $imagen->id; ?>">
                                            <a href="#" 
                                               onclick="deleteImage(<?php echo $imagen->id; ?>)" 
                                               class="deleterow" 
                                               style="float:right; margin:-20px" 
                                               title="Eliminar" >
                                                <span class="iconfa-remove-sign"></span>&nbsp;<img width="24px" src="<?php echo base_url(); ?>/assets/img/delete.png">
                                            </a>
                                            <a href="#" onclick="zoom(<?php echo $imagen->id; ?>)" ><img class="imgGaleria" id="img<?php echo $imagen->id; ?>" width="160px" height="120px" src="<?php echo base_url(); ?>files/imagenes/siniestros/<?php echo $imagen->filename; ?>" /></a>
                                            <div class="file-actions">



                                                <!--div style="float:right"> 
                                                       <a href="#medialist" 
                                                          onclick="copyToClipboard('<?php echo base_url(); ?>/files/imagenes/siniestros/<?php echo $imagen->filename; ?>')" 
                                                          class="deleterow" 
                                                          title="Copiar" >
                                                               <span class="iconfa-copy"> </span>&nbsp;Copiar Url
                                                       </a> 
                                                </div>
                                                <Br>-->



                                                <!--  <div style="float:right"> 
                                                <?php
                                                $checkedString = " ";
                                                if ($siniestro["principal"] == $imagen->filename)
                                                    $checkedString = " checked ";
                                                ?>
                                                        Principal: <input type="radio" name="ppal" onclick="changeImagenPrincipal(<?php echo $imagen->id; ?>)" <?php echo $checkedString ?> /> 
                                                 </div--> 

                                            </div>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!--<div style="border:1px dashed #aaa;margin:35px;">-->
                    <form id="fupload" class="dropzone" action="<?php echo base_url('index.php'); ?>/imagenes/upload/siniestros">
                        <!--<div style="width:100%; text-align:center;font-size:22px;color:#bbb;"><br>Arrastrar las imagenes ac&aacute; o hacer click<br></div>-->
                        <input type="hidden" name="sendform" value="1"  />
                        <input type="hidden" id="tablename" name="tablename" value="siniestros"  />
                        <input type="hidden" id="iditem" name="iditem" value="<?php echo $siniestroId; ?>" />
                    </form>
                <!-- </div> -->
                
            </div>
        </div>
    </div>


</div><!--End Content-->


<script type="text/javascript">

    function disableF5(e) {
        if ((e.which || e.keyCode) == 116) {

            e.preventDefault();
        }
    }
    ;

    function zoom(imgId) {
        $('#img' + imgId).zoomify();
    }

    function deleteImage(idImagen) {
        jQuery.ajax({
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            type: "POST",
            url: "<?php echo base_url('index.php'); ?>/imagenes/delete/siniestros",
            data: "idImagen=" + idImagen,
            success: function (html) {
                jQuery("#li_" + idImagen).remove();
            }
        });
    }

    function changeImagenPrincipal(idImagen) {
        var iditem = jQuery("#iditem").val();

        jQuery.ajax({
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            type: "POST",
            url: "<?php echo base_url('index.php'); ?>/siniestros/changeImagenPrincipal",
            data: "idNoticia=" + iditem + "&idImagen=" + idImagen,
            success: function (html) {
            }
        });
    }

    function copyToClipboard(text) {
        window.prompt("Copiar al portapapeles: Ctrl+C, Enter", text);
    }

    function updateGaleria(elem, idImagen) {
        isSelected = 0;
        if (elem.checked)
            isSelected = 1;
        jQuery.ajax({
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            type: "POST",
            url: "<?php echo base_url('index.php'); ?>/imagenes/updateGaleria",
            data: "isSelected=" + isSelected + "&idImagen=" + idImagen,
            success: function (html) {

            }
        });
    }

    $(document).ready(function () {
        jQuery(document).on("keydown", disableF5);
        
        Dropzone.prototype.defaultOptions.dictDefaultMessage = "Drop files here to upload";
        Dropzone.prototype.defaultOptions.dictFallbackMessage = "Su navegador no admite la carga de archivos arrastrados.";
        Dropzone.prototype.defaultOptions.dictFallbackText = "Utilice el siguiente formulario alternativo para cargar sus archivos como en los viejos tiempos.";
        Dropzone.prototype.defaultOptions.dictFileTooBig = "El archivo es muy grande ({{filesize}}MiB). Tama�o m�ximo de archivo: {{maxFilesize}}MiB.";
        Dropzone.prototype.defaultOptions.dictInvalidFileType = "No puedes subir archivos de este tipo.";
        Dropzone.prototype.defaultOptions.dictResponseError = "El servidor respondi� con {{statusCode}} c�digo.";
        Dropzone.prototype.defaultOptions.dictCancelUpload = "Cancelar carga";
        Dropzone.prototype.defaultOptions.dictCancelUploadConfirmation = "�Seguro que quieres cancelar esta carga?";
        Dropzone.prototype.defaultOptions.dictRemoveFile = "Eliminar archivo";
        Dropzone.prototype.defaultOptions.dictMaxFilesExceeded = "No puedes subir m�s archivos.";
        
        var myDropzone = new Dropzone("#fupload", { 
            clickable: "#btn_cargar_imagen", 
            acceptedFiles: "image/*",
        });
        // Cada vez que se carga una imagen con el drag&drop se muestra abajo y se borra del dropzone.
        myDropzone.on("complete", function (file) {
            obj = JSON.parse(file.xhr.responseText);
            jQuery('#medialist').prepend('<li class="image" id="li_' + obj.imagenId + '">' +
                    '<a href="#" onclick="deleteImage(' + obj.imagenId + ')" class="deleterow" style="float:right; margin:-20px"  title="Eliminar" ><span class="iconfa-remove-sign"></span>&nbsp;<img width="24px" src="<?php echo base_url(); ?>/assets/img/delete.png"></a>' +
                    '<a href="#" onclick="zoom(<?php echo $imagen->id; ?>)" ><img class="imgGaleria" id="img<?php echo $imagen->id; ?>" width="160px" height="120px" src="<?php echo base_url(); ?>/files/imagenes/siniestros/' + obj.imagePath + '" /></a>' +
                    '<div class="file-actions">' +
                    //'<div style="float:right"> <a href="#medialist" onclick="copyToClipboard(\'<?php echo base_url(); ?>/files/imagenes/siniestros/'+obj.imagePath+'\')" class="deleterow" title="Copiar" ><span class="iconfa-copy"> </span>&nbsp;Copiar Url</a> </div><br>'+
                    //'<div class="checker"><span><input type="checkbox" name="galeria" value="galeria"	onclick="updateGaleria(this, '+obj.imagenId+')" /></span></div> Galer&iacute;a'+ 
                    //'<div style="float:right"> Principal: <input type="radio" name="ppal" id="RB'+obj.imagenId+'" onclick="changeImagenPrincipal('+obj.imagenId+')"  /> </div>'+
                    '</div>' +
                    '</li>');
            myDropzone.removeFile(file);
        });

    });
</script>

