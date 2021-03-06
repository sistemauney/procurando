<?php 
session_start();
require_once '../controlador/adjuntarDictamenControlador.php';
//require_once '../controlador/tblactuacionesControlador.php';
require_once '../comunes/xajax/xajax_core/xajax.inc.php';

$xajax = new xajax();
$xajax->registerFunction('eliminar_documento');
$xajax->registerFunction('ListaDocumentosExpediente');
$xajax->processRequest();
$xajax->printJavascript('../comunes/xajax/');


if ($_POST)
{
    $adjunto= new adjuntarDocumentoControlador();
    $status = "";
    $id_dictamen=$_POST["id_dictamen"];
    if ($_POST["action"] == "upload") {
            // obtenemos los datos del archivo 
    //	$tamano = $_FILES["archivo"]['size'];
    //	$tipo = $_FILES["archivo"]['type'];
            $archivo = $_FILES["archivo"]['name'];
    //	$prefijo = substr(md5(uniqid(rand())),0,6);

            if ($archivo != "") {
                    // guardamos el archivo a la carpeta files
                    $destino =  "dictamenes/dictamen_".$id_dictamen."_".$archivo;
//                    exit($destino);
                    $adjunto->insertAdjunto($id_dictamen, $destino);
                    if (copy($_FILES['archivo']['tmp_name'],$destino)) {
                            $status = "Archivo subido con Exito: <b>".$archivo."</b>";
                    } else {
                            $status = "Error al subir el archivo";
                    }
            } else {
                    $status = "Error al subir archivo";
            }
    }
}
if ($_GET['id']!='')
    $id_dictamen = $_GET['id'];
?>
<html>
<head>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
$xajax->printJavascript('../comunes/xajax/')
?>  
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Archivador de Documentos</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
<script language="javascript"> 
    function cargar(id){
        if(id != ""){
            xajax_ListaDocumentosExpediente(id);
        }
    }
</script>
</head>
<body onload="cargar('<?php echo $id_dictamen ?>')">
<table width="413" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="text">Por favor seleccione el archivo a subir:</td>
  </tr>
  <tr>
    <td class="infsub">
	<?php 
	/*if ($gestor = opendir('documentos')) {
		echo "<ul>";
	    while (false !== ($arch = readdir($gestor))) {
		   if ($arch != "." && $arch != "..") {
			   echo "<li><a href=\"documentos/".$arch."\" class=\"linkli\">".$arch."</a></li>\n";
		   }
	    }
	    closedir($gestor);
		echo "</ul>";
	}
	*/?>	
    </td>
  </tr>
</table>
<table width="100%" border="0" class="tablaTitulo" >
  <tr>
  <form action="vista_uploadDictamen.php?id=<?php echo $id_dictamen; ?>" method="post" enctype="multipart/form-data">
    <td class="text">
      <input type="hidden" id="id_dictamen" name="id_dictamen" value="<?php echo $id_dictamen; ?>" />
      <input name="archivo" type="file" class="casilla" id="archivo" size="35" />
      <input name="enviar" type="submit" class="boton" id="enviar" value="Subir Archivos" />
      <input name="action" type="hidden" value="upload" />	  
    </td>
  </form>
  </tr>       
  <tr>
    <td class="text"><?php echo $status; ?></td>
  </tr>      
<tr>
    <td>
        <div id="contenedorDocumentos" style="width:100%;" align="left">
            <div align="center"></div>
        </div>
    </td>
</tr>                                                                                                                                   
</table>     
</body>
</html>
