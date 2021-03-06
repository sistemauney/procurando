<?php
    session_start();
    require_once "../controlador/controlador_contrarios.php";
    require_once ('../comunes/xajax/xajax_core/xajax.inc.php');
    require_once '../modelo/clPermisoModelo.php';
    require_once '../modelo/clConstantesModelo.php';
    if ($_SESSION['id_oficina']=='L') $nombre_modulo='Demandante';
    else  $nombre_modulo='Solicitantes';  
    
    $formulario_accion=  clConstantesModelo::getFormulario_accion('contrarios','demandantes_litigio');

    if(isset($_GET['id'])){
        $lngcodigo_cliente = $_GET['id'];
        $titulo_formulario = 'Editar '.$nombre_modulo;
        $funcion = 'xajax_editar_contrario';
    }else{
        $titulo_formulario = 'Nuevo '.$nombre_modulo;
        $funcion = 'xajax_validar_contrario';
    }
    
    $xajax= new xajax();
    $xajax->registerFunction('BuscarCedulaRepetida');   
    $xajax->registerFunction('buscarDatosContrarios');
    $xajax->registerFunction('buscar_cedula_contrario');
    $xajax->registerFunction('selectAllContrariosFiltro');
    $xajax->registerFunction('llenarSelectEstados');
    $xajax->registerFunction('llenarSelectMunicipio');
    $xajax->registerFunction('llenarSelectEstadoCivil');
    $xajax->registerFunction('llenarSelectSexo');
    $xajax->registerFunction('guardar_contrario');
    $xajax->registerFunction('selectContrario');
    $xajax->registerFunction('editar_contrario');
    $xajax->registerFunction('validar_contrario');
    
    
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
        <link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon" />
        <link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
        <link href="../comunes/css/enlaces.css" rel="stylesheet" type="text/css" />
        <link href="../comunes/css/calendar-blue2.css" rel="stylesheet" type="text/css" media="all" title="win2k-cold-1" />
        <link href="../comunes/css/tabcontent.css" rel="stylesheet" type="text/css"  />
        <link rel='StyleSheet' href='../comunes/js/dtree.css' type='text/css' />
        
        <script src="../comunes/js/jquery.js" type="text/javascript"></script>
        <script src="../comunes/js/jquery.maskedinput.js" type="text/javascript"></script>
        <script type='text/javascript' src='../comunes/js/dtree.js'></script>
        <script type='text/javascript' src='../comunes/js/funciones.js'></script>
        <script type="text/javascript" src="../comunes/js/prototype.js"></script>
        <script type="text/javascript" src="../comunes/js/effects.js"></script>
        <!--<script type="text/javascript" src="../comunes/js/scriptaculous.js"></script>-->
        <script type="text/javascript" src="../comunes/js/tabcontent.js"></script>
      
        <script src="../comunes/js/calendar.js" type="text/javascript"></script>
        <script src="../comunes/js/calendar_es.js" type="text/javascript"></script>
        <script src="../comunes/js/calendar_setup.js" type="text/javascript"></script>




        <style>
            body {padding:0px;margin:0px;text-align:left;font:11px verdana, arial, helvetica, serif; background-color:#FFFFFF;}
        </style>
        <script language="javascript">
            jQuery(function($){
                $("#strtelefono").mask("(9999) 999.99.99",{placeholder:" "});
                $("#strmovil").mask("(9999) 999.99.99",{placeholder:" "});
                $("#datefecnac").mask("99/99/9999",{placeholder:" "});
            });
            
            function cargar(lngcodigo_contrario){
                if(lngcodigo_contrario != ""){
                    xajax_selectContrario(lngcodigo_contrario)
                }else{
                    xajax_llenarSelectEstados('frmcontrario_nuevo');
                    xajax_llenarSelectEstadoCivil('');
                    xajax_llenarSelectSexo('')
                }
            }
            
            
            function verForm(id){
                //xajax_selectAllDpto();
                div = $(id);
                div.toggle();
                if (div.innerHTML==''){
                    div.update('<div align="center"><img src="../comunes/images/ajax-loader.gif"></div>');
                }else{
                    d = div.descendants();
                }
            }
            

        </script>
    </head>
    <body onload="cargar('<?php echo $lngcodigo_cliente ?>')" >
        <script src="../comunes/js/wz_tooltip/wz_tooltip.js" type="text/javascript"></script>
        <center>
            <form name="frmcontrario_nuevo" id="frmcontrario_nuevo" method="post">
            <fieldset style="border:#339933 2px solid">                     
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="65%" class="menu_izq_titulo">Editar Contrario</td>
                    <td width="10%" align="center" class="menu_izq_titulo">
                        <?php 
                        if(clPermisoModelo::getVerificar_Accion(clConstantesModelo::getFormulario($formulario_accion['formulario']),'guardar', $formulario_accion['accion'])) {?>
                        <img src="../comunes/images/16_save.png" onmouseover="Tip('Guardar')" onmouseout="UnTip()" border="0" onclick="<?php echo $funcion ?>(xajax.getFormValues('frmcontrario_nuevo'));"/>
                        &nbsp;&nbsp;&nbsp;
                        <?php }?>
                        <img src="../comunes/images/arrow_undo.png" onmouseover="Tip('Volver')" onmouseout="UnTip()" border="0" onclick="location.href='vista_contrarios.php'"/>
                    </td>
                </tr>
            </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top:10px; padding-bottom:0px;">
                <tr>
                    <td>
                        <div id="formulario" style=" width:100%;" align="left">
                                <input type="hidden" class='inputbox' id="id_contrarios" name="id_contrarios" size="30" />
                                <table width="100%" border="0" class="tablaVer" >
                                    <tr>
                                        <td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                                            <div align="center" style="background-image: url('../comunes/images/barra.png')">
                                                <strong>Datos del Contrario</strong>
                                            </div>
                                        </td>
                                    </tr>             
                                    <tr>
                                       <td width="20%">
                                            Cedula:
                                        </td>
                                        <td width="30%">
                                            <?php if ($lngcodigo_cliente!='') {?>
                                            <input type="text" class='inputbox' id="strcedula" name="strcedula" size="30" />
                                            <?php } else {?>
                                            <input type="text" class='inputbox' id="strcedula" name="strcedula" onblur="xajax_BuscarCedulaRepetida(document.frmcontrario_nuevo.strcedula.value);" size="30" />
                                            <?php }?>
                                        </td>
                                    </tr>                                    
                                    <tr>
                                        <td width="20%">
                                            Nombre:
                                        </td>
                                        <td width="30%">
                                            <input type="text" class='inputbox' id="strnombre" name="strnombre" size="30" />
                                        </td>
                                        <td width="20%">
                                            Apellido:
                                        </td>
                                        <td width="30%">
                                            <input type="text" class='inputbox' id="strapellido" name="strapellido" size="30" />
                                        </td>
                                    </tr>
                                    <tr>
                                       <td width="20%">
                                            Estado:
                                        </td>
                                        <td width="30%">
                                            <div id="capaEstado">
                                                <select id="id_estado" name="id_estado" style='width:50%'>
                                                    <option value="0">Seleccione</option>
                                                </select>
                                            </div>
                                        </td>
                                        
                                         <td width="20%">
                                            Municipio:
                                        </td>
                                        <td width="30%">
                                            <div id="capaMunicipio">
                                                <select id="id_municipio" name="id_municipio" style='width:50%'>
                                                    <option value="0">Seleccione</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td width="20%">
                                            Direccion:
                                        </td>
                                        <td width="30%">
                                            <textarea class="textarea" id="strdireccion" rows="2" cols="25" name="strdireccion"></textarea>
                                        </td>
                                        <td width="20%">
                                            Telefono:
                                        </td>
                                        <td width="30%">
                                            <input type="text" class='inputbox' id="strtelefono" name="strtelefono" size="30" />
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td width="20%">
                                            Email:
                                        </td>
                                        <td width="30%">
                                           <input type="text" class='inputbox' id="stremail" name="stremail" size="30" />
                                        </td>
                                        
                                        <td width="20%">
                                            Estado Civil:
                                        </td>
                                         <td width="30%">
                                            <div id="capaEstadoCivil">
                                                <select id="id_estado_civil" name="id_estado_civil" style='width:50%'>
                                                    <option value="0">Seleccione</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                     <tr>
                                        <td width="20%">
                                            Sexo:
                                        </td>
                                        <td width="30%">
                                          <div id="capaSexo">
                                                <select id="id_sexo" name="id_sexo" style='width:90%'>
                                                    <option value="0">Seleccione</option>
                                                </select>
                                            </div>
                                        </td>
                                        
                                        <td width="20%">
                                           Numero Hijos:
                                        </td>
                                         <td width="30%">
                                            <input type="text" class='inputbox' id="inthijos" name="inthijos" size="30" />
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td width="20%">
                                            Codigo Postal:
                                        </td>
                                        <td width="30%">
                                            <input type="text" class='inputbox' id="strcodigopostal" name="strcodigopostal" size="30" />
                                        </td>
                                        <td width="20%">
                                            Fecha de Nacimiento:
                                        </td>
                                        <td width="30%">
                                            <input type="text" class='inputbox' id="datefecnac" name="datefecnac" size="30" />
                                            <img name="button"  id="lanzador1"  src="../comunes/images/calendar.png" align="middle"/>
                                                <script type="text/javascript">
                                                    Calendar.setup({
                                                        inputField     :    "datefecnac",      // id del campo de texto
                                                        ifFormat       :    "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
                                                        button         :    "lanzador1"   // el id del botn que lanzar el calendario
                                                    });
                                                </script>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td width="20%">
                                            Observacion:
                                        </td>
                                        <td width="30%">
                                            <textarea id="strobservacion" rows="2" cols="25" name="strobservacion"></textarea>
                                        </td>
                                        <td width="20%">
                                            
                                        </td>
                                        <td width="30%">
                                        </td>
                                    </tr>
<!--                                    
                                    <tr>
                                        <td width="20%">
                                            Organizacion:
                                        </td>
                                        <td width="30%">
                                            <input type="text" class='inputbox' id="id_organizacion" name="id_organizacion" size="30" />
                                        </td>
                                        <td width="20%">
                                            Documento Constancia:
                                        </td>
                                        <td width="30%">
                                            <textarea id="strdocumentoconst" rows="2" cols="25" name="strdocumentoconst"></textarea>
                                            
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td width="20%">
                                            Rif:
                                        </td>
                                        <td width="30%">
                                            <input type="text" class='inputbox' id="strrif" name="strrif" size="30" />
                                        </td>
                                        <td width="20%">
                                            Telefono:
                                        </td>
                                        <td width="30%">
                                            <input type="text" class='inputbox' id="strmovil" name="strmovil" size="30" />
                                        </td>
                                    </tr>
                                  
-->                                    
                                </table>
                        </div>
                    </td>
                </tr>
               
              <!-- <tr>
                    <td>
                        <div id="contenedor" style="width:100%;" align="left">
                            <div align="center"><img src="../comunes/images/ajax-loader.gif"></div>
                        </div>
                    </td>
                </tr>-->
            </table>
            </form>
          </fieldset>               
        </center>
    </body>
</html><?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
