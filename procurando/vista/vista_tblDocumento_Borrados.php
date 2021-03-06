<?php
    session_start();
    require_once "../controlador/tbldocumentoControlador.php";
//    require_once "../controlador/tblproexpedienteControlador.php";    
    require_once ('../comunes/xajax/xajax_core/xajax.inc.php');
    $xajax= new xajax();
    $xajax->registerFunction('selectAllDocumentoBorrados');
    $xajax->registerFunction('selectReenviarDocumento');        
    $xajax->registerFunction('llenarSelectTipoDocumento');
    $xajax->registerFunction('llenarSelectTipoEvento');
    $xajax->registerFunction('llenarSelectTipoPrioridad');    
    $xajax->registerFunction('selectAllDpto');
    $xajax->registerFunction('ActualizarItemDocumentoBorrados');    
    
//    $xajax->registerFunction('selectFiltrosHonorarios');
//    $xajax->registerFunction('llenarDestinatarios');
    $xajax->processRequest();
    $xajax->printJavascript('../comunes/xajax/');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php
			$xajax->printJavascript('../comunes/xajax/')
		?>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="pragma" content="no-cache">
        <link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon" >
        <link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
        <link href="../comunes/css/enlaces.css" rel="stylesheet" type="text/css" />
        <link href="../comunes/css/pagination.css" rel="stylesheet" type="text/css" />
        <link href="../comunes/css/calendar-blue2.css" rel="stylesheet" type="text/css" media="all" title="win2k-cold-1" />
        <script src="../comunes/js/funciones.js" type="text/javascript"></script>
        <script src="../comunes/js/prototype.js" type="text/javascript"></script>
        <script src="../comunes/js/effects.js" type="text/javascript"></script>
<!--        <script src="../comunes/js/scriptaculous.js" type="text/javascript"></script>-->
        <script src="../comunes/js/calendar.js" type="text/javascript"></script>
        <script src="../comunes/js/calendar_es.js" type="text/javascript"></script>
        <script src="../comunes/js/calendar_setup.js" type="text/javascript"></script>
        <style>
            body {padding:0px;margin:0px;text-align:left;font:11px verdana, arial, helvetica, serif; background-color:#FFFFFF;}
        </style>
        <script language="javascript">   
            function edit(id){
                if (confirm('¿Seguro desea modificar el Honorario?')){
        	    document.location.href='vista_Ingresotblprohonorarios.php?id='.id;
                }                
            }             
            function ocultar(id, msj) {
                var log = $(id);
                log.innerHTML= msj;
                log.style.backgroundColor= '#fff36f';
                log.style.padding= '5px';
                new Effect.Fade(id, {from: 1, to: 0, duration: 2.0});
                new Effect.SlideUp(id, {queue: 'parallel', duration: 2.0});
            }
            function ver(id){
//                cargar(1);
                div = $(id);
                div.toggle();
                if (div.innerHTML==''){
                    div.update('<div align="center"><img src="../comunes/images/ajax-loader.gif"></div>');
                }else{
                    d = div.descendants();
                }
            }
            function filtrar(){
                var id_tipo= document.frmDocumento.id_tipo.value;
                var id_evento= document.frmDocumento.id_evento.value;
                var id_unidad= document.frmDocumento.id_unidad.value;
                var id_prioridad= document.frmDocumento.id_prioridad.value;                
                xajax_selectAllDocumentoBorrados(id_tipo, id_evento, id_unidad, id_prioridad);                        
                ver('formulario');
            }
        </script>
    </head>
    <body onload="xajax_selectAllDocumentoBorrados();xajax_llenarSelectTipoDocumento('','',1);xajax_llenarSelectTipoEvento();xajax_selectAllDpto();xajax_llenarSelectTipoPrioridad();">
        <form name="frmDocumento" id="frmDocumento" method="post" style="">
            <script src="../comunes/js/wz_tooltip/wz_tooltip.js" type="text/javascript"></script>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="65%" class="menu_izq_titulo">Remisión de Documentos Borrados<div id='capaMaestro'></div></td>
                    <td width="10%" align="center" class="menu_izq_titulo">
                        <img src="../comunes/images/filter.png" onmouseover="Tip('Filtros')" onmouseout="UnTip()" border="0" onclick="ver('formulario');"/>&nbsp;&nbsp;
                        <img src="../comunes/images/verde.gif" height='17px' onmouseover="Tip('Faltan Más de 2 Días')" onmouseout="UnTip()" border="0" onclick="javascript:location.href='vista_insertTblDocumento.php'"/>                        
                        <img src="../comunes/images/amarillo.gif" height='17px' onmouseover="Tip('Falta 1 Día')" onmouseout="UnTip()" border="0" onclick="javascript:location.href='vista_insertTblDocumento.php'"/>                        
                        <img src="../comunes/images/rojo.gif" height='17px' onmouseover="Tip('Día Actual o Vencidas')" onmouseout="UnTip()" border="0" onclick="javascript:location.href='vista_insertTblDocumento.php'"/>                                                
                        <img src="../comunes/images/page_add.png" onmouseover="Tip('Nuevo Item Documento')" onmouseout="UnTip()" border="0" onclick="javascript:location.href='vista_insertTblDocumento.php'"/>                        
                    </td>
                </tr>

            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top:10px; padding-bottom:0px;">
                <tr>
                    <td>
                        <div id="formulario" style="width:100%;display:none;" align="left">
                            <fieldset style="border:#339933 2px solid">
                                <table width="100%" border="0" class="tablaVer" >
                                   <tr>
                                        <td width="20%">
                                            Tipo de Documento:
                                        </td>
                                        <td width="30%">
                                            <div id="capaIdTipo">
                                                <select id="id_tipo" name="id_tipo" style='width:90%'>
                                                    <option value="0">Seleccione</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td width="20%">
                                            Tipo de Evento:
                                        </td>
                                        <td width="30%">
                                            <div id="capaIdTipoEvento">
                                                <select id="id_evento" name="id_evento" style='width:90%'>
                                                    <option value="0">Seleccione</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                   <tr>
                                        <td width="20%">
                                            Tipo de Unidad:
                                        </td>
                                        <td width="30%">
                                            <div id="capaIdTipoUnidad">
                                                <select id="id_unidad" name="id_unidad" style='width:60%'>
                                                    <option value="0">Seleccione</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td width="20%">
                                           Tipo de Prioridad:
                                        </td>
                                        <td width="30%">
                                            <div id="capaIdTipoPrioridad">
                                                <select id="id_prioridad" name="id_prioridad" style='width:90%'>
                                                    <option value="0">Seleccione</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>                                    
                                    <tr>
                                        <td align="right" colspan="8">
                                            <input type="button" value="Filtrar" onclick="filtrar();">
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="contenedorDocumento" style="width:100%;" align="left">
                            <div align="center"><img src="../comunes/images/ajax-loader.gif"></div>
                        </div>
                        <div id="pagDocumento" style="width:100%;" align="left" class="pagination">

                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>