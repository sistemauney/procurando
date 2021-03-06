<?php
    session_start();
    
    require_once '../modelo/clMaestroModelo.php';
    require_once '../modelo/clContactoModelo.php';    
    require_once '../modelo/ctblagendaModelo.php';
    require_once '../modelo/ctbldocumentoModelo.php';    
    require_once '../modelo/ctblproexpedienteModelo.php';    
    require_once '../modelo/clActuacionesModelo.php'; 
    require_once '../comunes/php/utilidades.php';
    require_once '../modelo/clConstantesModelo.php';
    require_once '../modelo/clFunciones.php';    
    require_once '../herramientas/herramientas.class.php';    

    verificarSession();
    
function selectActividadMensual(){
        $respuesta= new xajaxResponse();
        $data=$_SESSION['agenda_semana'];
        if($data){
            $html= "<div style='border:solid 1px #CCCCCC;background:#f8f8f8'>
                        <table style='text-align:center' border='0' class='tablaTitulo' width='100%'>
                            <tr>
                                <th width='3%'>
                                    <a href='#' onclick=\"xajax_orden('id_maestro')\">N°</a>
                                </th>                            
                                <th width='5%'>
                                    <a href='#' onclick=\"xajax_orden('id_maestro')\">Fecha</a>
                                </th>
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('id_origen')\">Agenda</a>
                                </th>
                                <th width='25%'>
                                    <a href='#' onclick=\"xajax_orden('stritema')\">Evento</a>
                                </th>
                                <th width='15%'>
                                    <a href='#' onclick=\"xajax_orden('stritemb')\">Prioridad</a>
                                </th>
                                <th width='42%'>
                                    <a href='#' onclick=\"xajax_orden('stritemb')\">Actividad</a>
                                </th>
                            </tr>";
            for ($i= 0; $i < count($data); $i++){
                $k=$i+1;
                $datos=  explode('-', $data[$i]);
                $html.= "<tr bgcolor='#f8f8f8'onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue'\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
                            <td align='left'>".$k."</td>
                            <td align='left'>".strtoupper($datos[0])."</td>
                            <td align='left' >".strtoupper($datos[1])."</td>
                            <td align='left' >".strtoupper($datos[2])."</td>
                            <td align='left' >".strtoupper($datos[3])."</td>
                            <td align='left' >".strtoupper($datos[4])."</td>
                        </tr>";
            }
            $html.= "</table></div>";
        }else{
            $html="<div class='celda_etiqueta'>No Hay Contrarios Registrados</div>";
        }
        $respuesta->assign("semana_actividad_texto","innerHTML",$html);
        return $respuesta;
    }    
    
  function selectSemanaActual() 
  {
        $respuesta= new xajaxResponse();
	$now = time();
        $agenda_personal='';
	$html.= '<table width="100%">';
            $html.= '<tr><td colspan="7" align="center"><b>' . $lang['left-coming'] . '</b></td></tr>';
            $html.= '<tr>';
            for ($i = 0; $i < 7; $i++) {
                    $xcolor = '#ffffff';
                    $tmp = mktime(0, 0, 0, date("m", $now), date("d", $now) + $i, date("Y", $now));
                    $tmp1 = mktime(0, 0, 0, date("m", $now), date("d", $now) + $i +1, date("Y", $now));
                                $strtitulo="";
                                $data=clTblagenda::getDiaActividad($tmp);
                                if ($data)
                                {
                                    for ($k= 0; $k < count($data); $k++){ 
                                        if ($data[$k]['strtitulo']!='') $strtitulo.=$data[$k]['id_tipo_agenda'].': '.$data[$k]['strtitulo'].'</br>';
                                        if ($data[$k]['strtitulo']!='') $agenda_personal[]=$data[$k]['fecagenda'].'-'.$data[$k]['id_tipo_agenda'].'-'.$data[$k]['id_evento_agenda'].'-'.$data[$k]['id_prioridad_agenda'].'-'.$data[$k]['strtitulo'];
                                    }
              
                                }
                                if (trim($strtitulo)!='')
                                {
                                        $xcolor = '#ff0000';
                                        $etiqueta="onmouseover=\"Tip('".$strtitulo."', TITLE, 'Actividades')\" onmouseout='UnTip()'";
                                        $url='vista_tblagenda';
                                }          
                                else {
                                    $etiqueta="";
                                    $url='vista_insertTblAgenda';                                    
                                } 

                    if (date("w", $tmp) == 0 or date("w", $tmp) == 6)
                            $html.= '<td '.$etiqueta.' ><span style="background: ' . $xcolor . ' ;"><b><a href="'.$url.'.php?date=' . date("Y-m-d", $tmp) . '">' . date("j", $tmp) . "</a></b></span></td>";
                    else
                            $html.= '<td '.$etiqueta.' ><span style="background: ' . $xcolor . ' ;"><a href="'.$url.'.php?date=' . date("Y-m-d", $tmp) . '">' . date("j", $tmp) . "</a></span></td>";
            }
            $html.= '</tr>';
	$html.= '</table>';
//        print_r($agenda_personal);
        if (is_array($agenda_personal))
            $_SESSION['agenda_semana']=$agenda_personal;
            $respuesta->script('xajax_selectActividadMensual();');
        $respuesta->assign("semana","innerHTML",$html);
        return $respuesta;
    }
          
    
    
    function selectAllAgendaFecha($pagina, $fecha){
        $respuesta= new xajaxResponse();
        $proagenda= new clTblagenda();
        $data= "";
        $html= "";
	if ($fecha!='')  {
            $dataC= $proagenda->selectAllAgendaFecha($pagina, $fecha);
            $data= $dataC[0];
            $paginacion=true;
        }
        if($data){
            $html= "<div style='border:solid 1px #CCCCCC;background:#f8f8f8'>
                        <table border='0' class='tablaTitulo' width='100%'>
                            <tr>
                                <th width='5%'>
                                    <a href='#' onclick=\"xajax_orden('id_honorarios')\"></a>
                                </th>                               
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('id_honorarios')\">Agenda</a>
                                </th>  
                                <th width='15%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Departamentto</a>
                                </th>                                
                                <th width='7%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Evento</a>
                                </th>
                                <th width='15%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Titulo</a>
                                </th>                                
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('Tramite')\">Prioridad</a>
                                </th>
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('Unidad')\">Estado</a>
                                </th>                    
                                <th width='5%'>
                                    <a href='#' onclick=\"xajax_orden('Unidad')\">Días</a>
                                </th>                                   
                                <th width='30%'>Acci&oacute;n</th>
                            </tr></table>";
            for ($i= 0; $i < count($data); $i++){
                if ($data[$i][visto]==1)
                    $html.= "<table border='0' class='tablaTitulo' width='100%'><tr bgcolor='#fbffd7'onmouseover=\"this.style.background='#ffc05c';this.style.color='blue'\" onmouseout=\"this.style.background='#fbffd7';this.style.color='black'\" >";
                else
                    $html.= "<table border='0' class='tablaTitulo' width='100%'><tr bgcolor='#f8f8f8'onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue'\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >";                    
                $html.= "<td width='5%' align='center'><img src='../comunes/images/".$data[$i][origen].".png' height='20px' onmouseover=\"Tip('Prioridad Alta', TITLE, 'Origen')\" onmouseout='UnTip()'\"></td>
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_tipo_agenda]."</td>
                            <td width='15%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".clTblagenda::getMaestro($data[$i][id_unidad])."</td>                    
                            <td width='7%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_evento_agenda]."</td>
                            <td width='15%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][strtitulo]."</td>                                
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_prioridad_agenda]."</td>
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_estado_agenda]."</td>                               
                            <td width='5%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".functions::diterenciaFechasDiasAgenda($data[$i][fecagenda])."</td>
                            <td width='30%'  align='center'>";
                $color=functions::diterenciaFechasSemaforoAgenda($data[$i]['fecagenda'],clTblagenda::getDiasRecordatorios($data[$i]['id_recordatorio']));
                if ($data[$i][id_prioridad]==clConstantesModelo::prioridad_alta)
                {
                    $html.="<a>
                                    <img src='../comunes/images/flag_red.png' height='17px' onmouseover=\"Tip('Prioridad Alta')\" onmouseout='UnTip()'\">
                                </a>";
                }elseif ($data[$i][id_prioridad]==clConstantesModelo::prioridad_media) {
                    $html.="<a>
                                    <img src='../comunes/images/flag_green.png' height='17px' onmouseover=\"Tip('Prioridad Media')\" onmouseout='UnTip()'\">
                                </a>";                
                }else{
                    $html.="<a>
                                    <img src='../comunes/images/flag_yellow.png' height='17px' onmouseover=\"Tip('Prioridad Baja')\" onmouseout='UnTip()'\">
                                </a>";                
                }                      
                if ($data[$i][id_refiere]==clConstantesModelo::buscar_refiere)
                {
                    $html.="<a>
                                    <img src='../comunes/images/UserGroup.png' height='17px' onmouseover=\"Tip('Refiere Departamento')\" onmouseout='UnTip()'\">
                                </a>";
                }                      
                if ($data[$i][id_refiere]==clConstantesModelo::buscar_persona)
                {
                    if ($data[$i][id_seguimiento]!='')
                    {
                        if (clTblagenda::getEstadoAgendaSeguimiento($data[$i][id_seguimiento])==1)
                        {
                            $image='group_error.png';
                            $msg='Mensaje no Leido';
                        }
                        else
                        { 
                            $image='group.png';         
                            $msg='Mensaje Leido';                            
                        }
                    }
                    else
                        $image='group.png';                     
                          
                    $html.="<a>
                                    <img src='../comunes/images/".$image."' height='17px' onmouseover=\"Tip('".$msg."')\" onmouseout='UnTip()'\">
                                </a>";
                }                      
                if ($color=='R')
                {
                    $html.="<a>
                                    <img src='../comunes/images/rojo.gif' height='17px' onmouseover=\"Tip('Agenda Pendiente Vencidas')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";
                }
                elseif ($color=='A')
                {        
                    $html.="<a>
                                    <img src='../comunes/images/amarillo.gif' height='17px'  onmouseover=\"Tip('Agenda Pendiente por Vencer')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";                
                }
                elseif ($color=='V')
                {
                    $html.="<a>
                                    <img src='../comunes/images/verde.gif' height='17px'  onmouseover=\"Tip('Agenda Pendiente')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";                   
                }                            
                $html.="        <a>
                                    <img src='../comunes/images/page_edit.png' onmouseover='Tip(\"Editar Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";  
                $html.="<a>
                                    <img src='../comunes/images/ver.gif' onmouseover=\"Tip('Detalle de la Agenda')\" onmouseout='UnTip()' onclick=\"location.href='../reportes/reporte_agenda_individual.php?id=".$data[$i]['id_agenda']."'\">
                                </a>";
                if ($data[$i][visto]!=1)
                 $html.="       <a>
                                    <img src='../comunes/images/Undo.png' onmouseover='Tip(\"Marcar como no Leido Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"xajax_ActualizarItemAgenda('".$data[$i]['id_agenda']."','1','visto');\">
                                </a>
                                <a>
                                    <img src='../comunes/images/table_multiple.png' onmouseover='Tip(\"Clonar Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."&clon=1'\">
                                </a>
                                <a>
                                    <img src='../comunes/images/vcard_delete.png' onmouseover='Tip(\"Eliminar Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"if(confirm('¿Desea Eliminar el Item de Agenda?')){xajax_ActualizarItemAgenda('".$data[$i]['id_agenda']."','1','bolborrado')};\">
                                </a>";
                
                
                 $html.="</td></tr></table>";
            }
            $html.= "</div>";
        }else{
            $html="<div class='celda_etiqueta'>No Hay Items Registrados</div>";
        }
        $respuesta->assign("contenedorAgenda","innerHTML",$html);
        if ($paginacion) $respuesta->assign("pagAgenda","innerHTML",$dataC[1]);           
        return $respuesta;
    }        
    
  function selectAgendaMeses($offset) 
  {
        $respuesta= new xajaxResponse();
//      exit('hola');        
	$now = time();
	$firstday = mktime(0, 0, 0, date("m", $now), date("d", $now), date("Y", $now));        
	$today = mktime(0, 0, 0, date("m", $firstday), date('d', $firstday), date("y", $firstday));
	$month = mktime(0, 0, 0, date("m", $today) + $offset, 1, date("y", $today));

	$startpos = date("w", $month);
	if ($startpos == 0) {
		$startpos = 7;
	}
        $mes=date("F", $month);    
        if (strtoupper($mes)=='JANUARY') $mes='ENERO'.date(" - Y", $month);
        if (strtoupper($mes)=='FEBRUARY') $mes='FEBRERO'.date(" - Y", $month);
        if (strtoupper($mes)=='MARCH') $mes='MARZO'.date(" - Y", $month); 
        if (strtoupper($mes)=='APRIL') $mes='ABRIL'.date(" - Y", $month);  
        if (strtoupper($mes)=='MAY') $mes='MAYO'.date(" - Y", $month); 
        if (strtoupper($mes)=='JUNE') $mes='JUNIO'.date(" - Y", $month);  
        if (strtoupper($mes)=='JULY') $mes='JULIO'.date(" - Y", $month); 
        if (strtoupper($mes)=='AUGUST') $mes='AGOSTO'.date(" - Y", $month);  
        if (strtoupper($mes)=='SEPTEMBER') $mes='SEPTIEMBRE'.date(" - Y", $month); 
        if (strtoupper($mes)=='OCTOBER') $mes='OCTUBRE'.date(" - Y", $month);  
        if (strtoupper($mes)=='NOVEMBER') $mes='NOVIEMBRE'.date(" - Y", $month); 
        if (strtoupper($mes)=='DECEMBER') $mes='DICIEMBRE'.date(" - Y", $month); 

//        $mes=date("F - Y", $month);
	$tmpnextmonth = mktime(0, 0, 0, date("m", $month) + 1, 0, date("y", $month));
	$tmpmonth = $month;
	$html.= '<table width="100%">';
	$html.= '<tr><td colspan="7" align="center"><b><a href="?page=overview&amp;type=month&amp;offset=' . $offset . '">' . $mes . '</a></b></td></tr>';
	for ($i = 1;(date("m", $month) == date("m", $tmpmonth)); $i++) {
		$html.= '<tr>';
		for ($j = 1; $j <= 7; $j++) {
			if (($i == 1 and $j < $startpos) or (date("m", $month) != date("m", $tmpmonth))) {
				$html.= '<td>&nbsp;</td>';
			} else {
				$backcolor = '#ffffff';
                                $strtitulo="";
                                $data=clTblagenda::getDiaActividad($tmpmonth);
                                if ($data)
                                {
                                    for ($k= 0; $k < count($data); $k++){ 
                                        if ($data[$k]['strtitulo']!='') $strtitulo.=$data[$k]['id_tipo_agenda'].': '.$data[$k]['strtitulo'].'</br>';
                                    }
              
                                }
                                    if (trim($strtitulo)!='')
                                    {
                                            $backcolor = '#ff0000';
                                            $etiqueta="onmouseover=\"Tip('".$strtitulo."', TITLE, 'Actividades')\" onmouseout='UnTip()'";
                                            $url='vista_tblagenda';
                                    }          
                                    else {
                                        $etiqueta="";
                                        $url='vista_insertTblAgenda';                                    
                                    }                                
                                

				if (date("Y-m-d", $tmpmonth) == date("Y-m-d", $today)) {
					$daymark = 'blue';
				} else {
					$daymark = 'white';
				}
				if ($j >= 6) {
					$html.= '<td '.$etiqueta.' bgcolor=' . $daymark . '><span 
					style="background: ' . $backcolor . ';"><b><a 
					href="'.$url.'.php?date=' . date("Y-m-
					d", $tmpmonth) . '">' . date("d", $tmpmonth) . '</a></b></span></td>';
				} else {
					$html.= '<td '.$etiqueta.' bgcolor=' . $daymark . '><span 
					style="background: ' . $backcolor . ';"><a 
					href="'.$url.'.php?date=' . date("Y-m-
					d", $tmpmonth) . '">' . date("d", $tmpmonth) . '</a></span></td>';
				}
			}
			if ($i != 1 or $j >= $startpos) {
				$tmpmonth = mktime(0, 0, 0, date("m", $tmpmonth), date("d", $tmpmonth) + 1, date("y", $tmpmonth));
			}
		}
		$html.= '</tr>';

	}
	$html.= '</table>';
        $respuesta->assign("meses","innerHTML",$html);
        return $respuesta;
    }
            
    
    
    
  function selectAllDptoIntegrantes($id_unidad="", $select= "", $ancho= "60%") 
  {
        $respuesta= new xajaxResponse();
        $data= "";
        $html= "";        
        $contacto= new clContactoModelo();        
        $data= $contacto->selectContactoByIdDepartamento($id_unidad);
        $html= "";
        $html= "<select id='id_integrantes_unidad' name='id_integrantes_unidad' style='width:".$ancho."'>";            
        $html.= "<option value='0'>Seleccione</option>";        
        for($i= 0; $i < count($data); $i++){
               $seleccionar= "";
                if($select == $data[$i]['id_contacto']){
                    $seleccionar= "SELECTED";
                }            
                $html.= "<option value='".$data[$i]['id_contacto']."' ".$seleccionar.">".$data[$i]['strapellido'].', '.$data[$i]['strnombre']."</option>";
        }
        $html.= "</select>";
        $respuesta->assign("capaIdTipoIntegrantesUnidad","innerHTML",$html);
        return $respuesta;
    }
        
    
    function guardarAgendaExpediente($request){
        $respuesta= new xajaxResponse();
        $agenda= new clTblagenda();
        $agenda->llenar($request);
        if (functions::VerificarFechaActual(str_replace('/', '-', $request['fecagenda'])))
        {        
            if( $request['id_agenda'] =="") 
            {
                $data= $agenda->insertAgenda();
                $respuesta->alert("La Agenda se creo Exitosamente");                
                $respuesta->script("location.href='vista_tblagenda_Expediente.php?id=".$request['id_agenda_expediente']."';");            
            }
            else 
            {
                $data= $agenda->updateAgenda();
                $respuesta->alert("La Agenda se Actualizo Exitosamente");                    
                $respuesta->script("location.href='vista_tblagenda_Expediente.php?id=".$request['id_agenda_expediente']."';"); 
            }
            if(!$data){
                $respuesta->alert("La Agenda no se ha guardado");
            }
        }
        else
            $respuesta->alert("La fecha del Item de Agenda no puede vencer el mismo día, o ser menor a la fecha de Registro");
        return $respuesta;
    }      
    
    function validar_Agenda_Expediente($request){
        $respuesta = new xajaxResponse();
            $campos_validar= array(
            'Tipo de Agenda'    => 'id_tipo',
            'Tipo de Prioridad'    => 'id_prioridad',
            'Tipo de Evento'    => 'id_evento',                
            'Tipo de Estado'    => 'id_estado',
            'Tipo de Recordatorio'    => 'id_recordatorio',                
            'Titulo del Evento'  => 'strtitulo',
            'Fecha de la Agenda'    => 'fecagenda',
            'Descripcion de la Agenda' => 'strdescripcion',
            );
            $validacion=  functions::validarFormulario('frmAgenda',$request,$campos_validar);
            if($validacion){
                $respuesta->alert($validacion['msg']);
                $respuesta->script($validacion['focus']);
            }else{
                $respuesta->script("xajax_guardarAgendaExpediente(xajax.getFormValues('frmAgenda'))");
            }
        return $respuesta;
    }        
    
    function selectAllAgendaExpediente($id,$tipo_expediente){

        //exit("id: ".$id." tipo_expediente: ".$tipo_expediente);
        $respuesta= new xajaxResponse();
        $proagenda= new clTblagenda();
        $data= "";
        $html= "";
	if ($id)
        {
            $data= $proagenda->selectAllAgendaExpediente($id,$tipo_expediente);
        }
        if($data){
            $html= "<div style='border:solid 1px #CCCCCC;background:#f8f8f8'>
                        <table border='0' class='tablaTitulo' width='100%'>
                            <tr>
                                <th width='5%'>
                                    <a href='#' onclick=\"xajax_orden('id_honorarios')\"></a>
                                </th>                               
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('id_honorarios')\">Agenda</a>
                                </th>  
                                <th width='15%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Departamentto</a>
                                </th>                                
                                <th width='7%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Evento</a>
                                </th>
                                <th width='15%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Titulo</a>
                                </th>                                
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('Tramite')\">Prioridad</a>
                                </th>
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('Unidad')\">Estado</a>
                                </th>                    
                                <th width='5%'>
                                    <a href='#' onclick=\"xajax_orden('Unidad')\">Días</a>
                                </th>                                   
                                <th width='30%'>Acci&oacute;n</th>
                            </tr></table>";
            for ($i= 0; $i < count($data); $i++){
                if ($data[$i][visto]==1)
                    $html.= "<table border='0' class='tablaTitulo' width='100%'><tr bgcolor='#fbffd7'onmouseover=\"this.style.background='#ffc05c';this.style.color='blue'\" onmouseout=\"this.style.background='#fbffd7';this.style.color='black'\" >";
                else
                    $html.= "<table border='0' class='tablaTitulo' width='100%'><tr bgcolor='#f8f8f8'onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue'\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >";                    
                $html.= "<td width='5%' align='center'><img src='../comunes/images/".$data[$i][origen].".png' height='20px' onmouseover=\"Tip('Prioridad Alta', TITLE, 'Origen')\" onmouseout='UnTip()'\"></td>
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_tipo_agenda]."</td>
                            <td width='15%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".clTblagenda::getMaestro($data[$i][id_unidad])."</td>                    
                            <td width='7%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_evento_agenda]."</td>
                            <td width='15%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][strtitulo]."</td>                                
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_prioridad_agenda]."</td>
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_estado_agenda]."</td>                               
                            <td width='5%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".functions::diterenciaFechasDiasAgenda($data[$i][fecagenda])."</td>
                            <td width='30%'  align='center'>";
                $color=functions::diterenciaFechasSemaforoAgenda($data[$i]['fecagenda'],clTblagenda::getDiasRecordatorios($data[$i]['id_recordatorio']));
                if ($data[$i][id_prioridad]==clConstantesModelo::prioridad_alta)
                {
                    $html.="<a>
                                    <img src='../comunes/images/flag_red.png' height='17px' onmouseover=\"Tip('Prioridad Alta')\" onmouseout='UnTip()'\">
                                </a>";
                }elseif ($data[$i][id_prioridad]==clConstantesModelo::prioridad_media) {
                    $html.="<a>
                                    <img src='../comunes/images/flag_green.png' height='17px' onmouseover=\"Tip('Prioridad Media')\" onmouseout='UnTip()'\">
                                </a>";                
                }else{
                    $html.="<a>
                                    <img src='../comunes/images/flag_yellow.png' height='17px' onmouseover=\"Tip('Prioridad Baja')\" onmouseout='UnTip()'\">
                                </a>";                
                }                      
                if ($data[$i][id_refiere]==clConstantesModelo::buscar_refiere)
                {
                    $html.="<a>
                                    <img src='../comunes/images/UserGroup.png' height='17px' onmouseover=\"Tip('Refiere Departamento')\" onmouseout='UnTip()'\">
                                </a>";
                }                      
                if ($data[$i][id_refiere]==clConstantesModelo::buscar_persona)
                {
                    if ($data[$i][id_seguimiento]!='')
                    {
                        if (clTblagenda::getEstadoAgendaSeguimiento($data[$i][id_seguimiento])==1)
                        {
                            $image='group_error.png';
                            $msg='Mensaje no Leido';
                        }
                        else
                        { 
                            $image='group.png';         
                            $msg='Mensaje Leido';                            
                        }
                    }
                    else
                        $image='group.png';                     
                          
                    $html.="<a>
                                    <img src='../comunes/images/".$image."' height='17px' onmouseover=\"Tip('".$msg."')\" onmouseout='UnTip()'\">
                                </a>";
                }                      
                if ($color=='R')
                {
                    $html.="<a>
                                    <img src='../comunes/images/rojo.gif' height='17px' onmouseover=\"Tip('Agenda Pendiente Vencidas')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgendaExpediente.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";
                }
                elseif ($color=='A')
                {        
                    $html.="<a>
                                    <img src='../comunes/images/amarillo.gif' height='17px'  onmouseover=\"Tip('Agenda Pendiente por Vencer')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgendaExpediente.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";                
                }
                elseif ($color=='V')
                {
                    $html.="<a>
                                    <img src='../comunes/images/verde.gif' height='17px'  onmouseover=\"Tip('Agenda Pendiente')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgendaExpediente.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";                   
                }
                
                $src= ($data[$i]['tipo_expediente'] == clConstantesModelo::$TIPO_EXPEDIENTE['oas']) ? "vista_insertTblAgendaExpediente.php?id=".$data[$i]['id_agenda']."" : "vista_insertTblAgendaLitigio.php?id=".$data[$i]['id_agenda'] ;
                //exit($src);
                $html.="        <a>
                                    <img src='../comunes/images/page_edit.png' onmouseover='Tip(\"Editar Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"javascript:location.href='$src'\">
                                </a>";  
                $html.="<a>
                                    <img src='../comunes/images/ver.gif' onmouseover=\"Tip('Detalle de la Agenda')\" onmouseout='UnTip()' onclick=\"location.href='../reportes/reporte_agenda_individual.php?id=".$data[$i]['id_agenda']."'\">
                                </a>";
                
                
                 $html.="</td></tr></table>";
            }
            $html.= "</div>";
        }else{
            $html="<div class='celda_etiqueta'>No Hay Items Registrados</div>";
        }
        $respuesta->assign("contenedorAgenda","innerHTML",$html);
        return $respuesta;
    }       
    
    function IntroAgenda(){
        $respuesta=new xajaxResponse(); 
            $agenda= new clTblagenda();   
            $respuesta->assign("numagendanoleidos","innerHTML",$agenda->CountIntroNoLeidosAgenda()." No Leidos");
            $respuesta->assign("numagendaleidos","innerHTML",$agenda->CountIntroLeidosAgenda()." Leidos");            
            $documento= new clTblDocumento();           
            $respuesta->assign("numdocumentosnoleidos","innerHTML",$documento->CountIntroNoLeidosDocumentos()." No Leidos");
            $respuesta->assign("numdocumentosleidos","innerHTML",$documento->CountIntroLeidosDocumentos()." Leidos");                
         
        return $respuesta;
    }     
    
    function ActualizarItemAgendaAnexadas($id,$valor,$campo){
        $respuesta=new xajaxResponse(); 
        if ($id)
        {
            $agenda= new clTblagenda();            
            $agenda->updateAgendaItem($id,$valor,$campo); 
            $respuesta->alert("Requerimiento Procesado con Exito");      
            $respuesta->script('xajax_selectAllAgendaAnexadas();');
        }
        return $respuesta;
    }     
    
    function selectAllAgendaAnexadas($fil_id_tipo=0, $fil_id_evento=0, $fil_id_unidad=0, $fil_id_prioridad=0, $fil_id_integrantes_unidad=0, $fil_id_expediente=''){
        $respuesta= new xajaxResponse();
        $proagenda= new clTblagenda();
        $data= "";
        $html= "";
	if (($fil_id_tipo>0) or ($fil_id_evento>0) or ($fil_id_unidad>0) or ($fil_id_prioridad>0)  or ($fil_id_integrantes_unidad>0)  or ($fil_id_expediente!=''))  {
            $data= $proagenda->selectFiltrarAgendaAnexadas($fil_id_tipo, $fil_id_evento, $fil_id_unidad, $fil_id_prioridad, $fil_id_integrantes_unidad, $fil_id_expediente);
        }
        else
        {
            $data= $proagenda->selectAllAgendaAnexadas();
        }
        if($data){
            $html= "<div style='border:solid 1px #CCCCCC;background:#f8f8f8'>
                        <table border='0' class='tablaTitulo' width='100%'>
                            <tr>
                                <th width='5%'>
                                    <a href='#' onclick=\"xajax_orden('id_honorarios')\"></a>
                                </th>                               
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('id_honorarios')\">Agenda</a>
                                </th>                            
                                <th width='15%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Departamentto</a>
                                </th>                                
                                <th width='7%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Evento</a>
                                </th>
                                <th width='15%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Titulo</a>
                                </th>                                
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('Tramite')\">Prioridad</a>
                                </th>
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('Unidad')\">Estado</a>
                                </th>                    
                                <th width='5%'>
                                    <a href='#' onclick=\"xajax_orden('Unidad')\">Días</a>
                                </th>                                   
                                <th width='30%'>Acci&oacute;n</th>
                            </tr></table>";
            for ($i= 0; $i < count($data); $i++){
                if ($data[$i][visto]==1)
                    $html.= "<table border='0' class='tablaTitulo' width='100%'><tr bgcolor='#fbffd7'onmouseover=\"this.style.background='#ffc05c';this.style.color='blue'\" onmouseout=\"this.style.background='#fbffd7';this.style.color='black'\" >";
                else
                    $html.= "<table border='0' class='tablaTitulo' width='100%'><tr bgcolor='#f8f8f8'onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue'\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >";                    
                $html.= "<td width='5%' align='center'><img src='../comunes/images/".$data[$i][origen].".png' height='20px' onmouseover=\"Tip('Prioridad Alta')\" onmouseout='UnTip()'\"></td>
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_tipo_agenda]."</td>
                            <td width='15%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".clTblagenda::getMaestro($data[$i][id_unidad])."</td>                    
                            <td width='7%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_evento_agenda]."</td>
                            <td width='15%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][strtitulo]."</td>                                
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_prioridad_agenda]."</td>
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_estado_agenda]."</td>                               
                            <td width='5%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".functions::diterenciaFechasDiasAgenda($data[$i][fecagenda])."</td>
                            <td width='30%'  align='center'>";
                $color=functions::diterenciaFechasSemaforoAgenda($data[$i]['fecagenda'],clTblagenda::getDiasRecordatorios($data[$i]['id_recordatorio']));
                if ($data[$i][id_prioridad]==clConstantesModelo::prioridad_alta)
                {
                    $html.="<a>
                                    <img src='../comunes/images/flag_red.png' height='17px' onmouseover=\"Tip('Prioridad Alta')\" onmouseout='UnTip()'\">
                                </a>";
                }elseif ($data[$i][id_prioridad]==clConstantesModelo::prioridad_media) {
                    $html.="<a>
                                    <img src='../comunes/images/flag_green.png' height='17px' onmouseover=\"Tip('Prioridad Media')\" onmouseout='UnTip()'\">
                                </a>";                
                }else{
                    $html.="<a>
                                    <img src='../comunes/images/flag_yellow.png' height='17px' onmouseover=\"Tip('Prioridad Baja')\" onmouseout='UnTip()'\">
                                </a>";                
                }                      
                if ($data[$i][id_refiere]==clConstantesModelo::buscar_refiere)
                {
                    $html.="<a>
                                    <img src='../comunes/images/UserGroup.png' height='17px' onmouseover=\"Tip('Refiere Departamento')\" onmouseout='UnTip()'\">
                                </a>";
                }                      
                if ($data[$i][id_refiere]==clConstantesModelo::buscar_persona)
                {
                    if ($data[$i][id_seguimiento]!='')
                    {
                        if (clTblagenda::getEstadoAgendaSeguimiento($data[$i][id_seguimiento])==1)
                        {
                            $image='group_error.png';
                            $msg='Mensaje no Leido';
                        }
                        else
                        { 
                            $image='group.png';         
                            $msg='Mensaje Leido';                            
                        }
                    }
                    else
                        $image='group.png';                     
                          
                    $html.="<a>
                                    <img src='../comunes/images/".$image."' height='17px' onmouseover=\"Tip('".$msg."')\" onmouseout='UnTip()'\">
                                </a>";
                }                      
                if ($color=='R')
                {
                    $html.="<a>
                                    <img src='../comunes/images/rojo.gif' height='17px' onmouseover=\"Tip('Agenda Pendiente Vencidas')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";
                }
                elseif ($color=='A')
                {        
                    $html.="<a>
                                    <img src='../comunes/images/amarillo.gif' height='17px'  onmouseover=\"Tip('Agenda Pendiente por Vencer')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";                
                }
                elseif ($color=='V')
                {
                    $html.="<a>
                                    <img src='../comunes/images/verde.gif' height='17px'  onmouseover=\"Tip('Agenda Pendiente')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";                   
                }                            
                $html.="        <a>
                                    <img src='../comunes/images/page_edit.png' onmouseover='Tip(\"Editar Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";
                $html.="<a>
                                    <img src='../comunes/images/ver.gif' onmouseover=\"Tip('Detalle de la Agenda')\" onmouseout='UnTip()' onclick=\"location.href='../reportes/reporte_agenda_individual.php?id=".$data[$i]['id_agenda']."'\">
                                </a>";
                if ($data[$i][visto]!=1)
                 $html.="       <a>
                                    <img src='../comunes/images/Undo.png' onmouseover='Tip(\"Marcar como no Leido Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"xajax_ActualizarItemAgenda('".$data[$i]['id_agenda']."','1','visto');\">
                                </a>
                                <a>
                                    <img src='../comunes/images/table_multiple.png' onmouseover='Tip(\"Clonar Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."&clon=1'\">
                                </a>
                                <a>
                                    <img src='../comunes/images/vcard_delete.png' onmouseover='Tip(\"Eliminar Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"if(confirm('¿Desea Eliminar el Item de Agenda?')){xajax_ActualizarItemAgendaAnexadas('".$data[$i]['id_agenda']."','1','bolborrado')};\">
                                </a>";                                 
                 $html.="</td></tr></table>";
            }
            $html.= "</div>";
        }else{
            $html="<div class='celda_etiqueta'>No Hay Items Registrados</div>";
        }
        $respuesta->assign("contenedorAgenda","innerHTML",$html);
        return $respuesta;
    }    
    
    
    function ActualizarItemAgendaBorrados($id,$valor,$campo){
        $respuesta=new xajaxResponse(); 
        if ($id)
        {
            $agenda= new clTblagenda();            
            $agenda->updateAgendaItem($id,$valor,$campo); 
            $respuesta->alert("Requerimiento Procesado con Exito");      
            $respuesta->script('xajax_selectAllAgendaBorrados();');
        }
        return $respuesta;
    } 
    
    function selectAllAgendaBorrados($fil_id_tipo=0, $fil_id_evento=0, $fil_id_unidad=0, $fil_id_prioridad=0, $fil_id_integrantes_unidad=0, $fil_id_expediente=''){
        $respuesta= new xajaxResponse();
        $proagenda= new clTblagenda();
        $data= "";
        $html= "";
	if (($fil_id_tipo>0) or ($fil_id_evento>0) or ($fil_id_unidad>0) or ($fil_id_prioridad>0)  or ($fil_id_integrantes_unidad>0)  or ($fil_id_expediente!=''))  {
            $data= $proagenda->selectFiltrarAgendaBorrados($fil_id_tipo, $fil_id_evento, $fil_id_unidad, $fil_id_prioridad, $fil_id_integrantes_unidad, $fil_id_expediente);
        }
        else
        {
            $data= $proagenda->selectAllAgendaBorrados();
        }
        if($data){
            $html= "<div style='border:solid 1px #CCCCCC;background:#f8f8f8'>
                        <table border='0' class='tablaTitulo' width='100%'>
                            <tr>
                                <th width='5%'>
                                    <a href='#' onclick=\"xajax_orden('id_honorarios')\"></a>
                                </th>                            
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('id_honorarios')\">Agenda</a>
                                </th>                                     
                                <th width='15%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Departamentto</a>
                                </th>                                
                                <th width='7%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Evento</a>
                                </th>
                                <th width='15%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Titulo</a>
                                </th>                                
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('Tramite')\">Prioridad</a>
                                </th>
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('Unidad')\">Estado</a>
                                </th>                    
                                <th width='5%'>
                                    <a href='#' onclick=\"xajax_orden('Unidad')\">Días</a>
                                </th>                                   
                                <th width='30%'>Acci&oacute;n</th>
                            </tr></table>";
            for ($i= 0; $i < count($data); $i++){
                if ($data[$i][visto]==1)
                    $html.= "<table border='0' class='tablaTitulo' width='100%'><tr bgcolor='#fbffd7'onmouseover=\"this.style.background='#ffc05c';this.style.color='blue'\" onmouseout=\"this.style.background='#fbffd7';this.style.color='black'\" >";
                else
                    $html.= "<table border='0' class='tablaTitulo' width='100%'><tr bgcolor='#f8f8f8'onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue'\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >";                    
                $html.= "<td width='5%' align='center'><img src='../comunes/images/".$data[$i][origen].".png' height='20px' onmouseover=\"Tip('Prioridad Alta')\" onmouseout='UnTip()'\"></td>
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_tipo_agenda]."</td>
                            <td width='15%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".clTblagenda::getMaestro($data[$i][id_unidad])."</td>                    
                            <td width='7%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_evento_agenda]."</td>
                            <td width='15%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][strtitulo]."</td>                                
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_prioridad_agenda]."</td>
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_estado_agenda]."</td>                               
                            <td width='5%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".functions::diterenciaFechasDiasAgenda($data[$i][fecagenda])."</td>
                            <td width='30%'  align='center'>";
                $color=functions::diterenciaFechasSemaforoAgenda($data[$i]['fecagenda'],clTblagenda::getDiasRecordatorios($data[$i]['id_recordatorio']));
                if ($data[$i][id_prioridad]==clConstantesModelo::prioridad_alta)
                {
                    $html.="<a>
                                    <img src='../comunes/images/flag_red.png' height='17px' onmouseover=\"Tip('Prioridad Alta')\" onmouseout='UnTip()'\">
                                </a>";
                }elseif ($data[$i][id_prioridad]==clConstantesModelo::prioridad_media) {
                    $html.="<a>
                                    <img src='../comunes/images/flag_green.png' height='17px' onmouseover=\"Tip('Prioridad Media')\" onmouseout='UnTip()'\">
                                </a>";                
                }else{
                    $html.="<a>
                                    <img src='../comunes/images/flag_yellow.png' height='17px' onmouseover=\"Tip('Prioridad Baja')\" onmouseout='UnTip()'\">
                                </a>";                
                }                      
                if ($data[$i][id_refiere]==clConstantesModelo::buscar_refiere)
                {
                    $html.="<a>
                                    <img src='../comunes/images/UserGroup.png' height='17px' onmouseover=\"Tip('Refiere Departamento')\" onmouseout='UnTip()'\">
                                </a>";
                }                      
                if ($data[$i][id_refiere]==clConstantesModelo::buscar_persona)
                {
                    if ($data[$i][id_seguimiento]!='')
                    {
                        if (clTblagenda::getEstadoAgendaSeguimiento($data[$i][id_seguimiento])==1)
                        {
                            $image='group_error.png';
                            $msg='Mensaje no Leido';
                        }
                        else
                        { 
                            $image='group.png';         
                            $msg='Mensaje Leido';                            
                        }
                    }
                    else
                        $image='group.png';                     
                          
                    $html.="<a>
                                    <img src='../comunes/images/".$image."' height='17px' onmouseover=\"Tip('".$msg."')\" onmouseout='UnTip()'\">
                                </a>";
                }                      
                if ($color=='R')
                {
                    $html.="<a>
                                    <img src='../comunes/images/rojo.gif' height='17px' onmouseover=\"Tip('Agenda Pendiente Vencidas')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";
                }
                elseif ($color=='A')
                {        
                    $html.="<a>
                                    <img src='../comunes/images/amarillo.gif' height='17px'  onmouseover=\"Tip('Agenda Pendiente por Vencer')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";                
                }
                elseif ($color=='V')
                {
                    $html.="<a>
                                    <img src='../comunes/images/verde.gif' height='17px'  onmouseover=\"Tip('Agenda Pendiente')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";                   
                }                            
                $html.="        <a>
                                    <img src='../comunes/images/page_edit.png' onmouseover='Tip(\"Editar Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>"; 
                $html.="<a>
                                    <img src='../comunes/images/ver.gif' onmouseover=\"Tip('Detalle de la Agenda')\" onmouseout='UnTip()' onclick=\"location.href='../reportes/reporte_agenda_individual.php?id=".$data[$i]['id_agenda']."'\">
                                </a>";
                if ($data[$i][visto]!=1)
                 $html.="       <a>
                                    <img src='../comunes/images/Undo.png' onmouseover='Tip(\"Marcar como no Leido Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"xajax_ActualizarItemAgendaBorrados('".$data[$i]['id_agenda']."','1','visto');xajax_ActualizarItemAgendaBorrados('".$data[$i]['id_agenda']."','0','bolborrado');\">
                                </a>
                                <a>
                                    <img src='../comunes/images/table_multiple.png' onmouseover='Tip(\"Clonar Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."&clon=1'\">
                                </a>
                                <a>
                                    <img src='../comunes/images/vcard_add.png' onmouseover='Tip(\"Colocar como no Borrado el Item de Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"if(confirm('¿Desea Colocar como no Borrado el Item de Agenda?')){xajax_ActualizarItemAgendaBorrados('".$data[$i]['id_agenda']."','0','bolborrado')};\">
                                </a>";                                 
                 $html.="</td></tr></table>";
            }
            $html.= "</div>";
        }else{
            $html="<div class='celda_etiqueta'>No Hay Items Registrados</div>";
        }
        $respuesta->assign("contenedorAgenda","innerHTML",$html);
        return $respuesta;
    }    
    
    
    function buscarPersonaPopup($id_coord_maestro){
        $respuesta= new xajaxResponse();
        $contacto = new clContactoModelo();        
//        exit($id_coord_maestro."---");        
        $data= "";
        $html= "";   
        if ($id_coord_maestro!='')
        {    
            $data=$contacto->selectAllContactoFiltrosAgenda($id_coord_maestro);
        }
        if(is_array($data)){
                $html= "<div style='border:solid 1px #CCCCCC;background:#f8f8f8'>
                            <table style='text-align:center' border='0' class='tablaTitulo' width='100%'>
                            <tr>
                                <td colspan=\"5\" align=\"right\" style=\"color:white; border:#CCCCCC solid 0px;\" bgcolor=\"#273785\" >
                                    <div align=\"center\" style=\"background-image: url('../comunes/images/barra.png')\">
                                        <strong>LISTADO DE TRABAJADORES</strong>
                                    </div>                                
                                </td>
                            </tr>                               
                                <tr>
                                    <th width='10%'>
                                        <a href='#' onclick=\"xajax_orden('id_maestro')\">Id</a>
                                    </th>                                
                                    <th width='21%'>
                                        <a href='#' onclick=\"xajax_orden('id_maestro')\">Nombre</a>
                                    </th>
                                    <th width='22%'>
                                        <a href='#' onclick=\"xajax_orden('id_origen')\">Apellido</a>
                                    </th>
                                    <th width='22%'>
                                        <a href='#' onclick=\"xajax_orden('id_origen')\">Departamento</a>
                                    </th>                                    
                                    <th width='5%'>
                                        <a href='#' onclick=\"xajax_orden('id_origen')\">Acción</a>
                                    </th>                                         
                                </tr>";
                for ($i= 0; $i < count($data); $i++){
                    if ($data[$i]['id_contacto']!=$_SESSION['id_contacto']){
                    $html.= "<tr bgcolor='#f8f8f8'onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue'\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
                                <td align='center'>".$i."</td>
                                <td align='center'>".strtoupper($data[$i]['strnombre'])."</td>
                                <td align='center'>".strtoupper($data[$i]['strapellido'])."</td>
                                <td align='center'>".  clFunciones::mostrarStritema($data[$i]['id_coord_maestro'])."</td>                       
                                <td align='center'>
                                        <a>
                                            <img src='../comunes/images/s_success.png' onmouseover='Tip(\"Elegir Persona\")' onmouseout='UnTip()' onclick=\"xajax_buscarPersona('".$data[$i][id_contacto]."')\">
                                        </a>                                   
                                </td>
                            </tr>";
                    }
                    $respuesta->assign("strnombre", "value", '');
                    $respuesta->assign("id_contacto", "value", '');                      
                    //$respuesta->script("$('contenedorTrabajador').show();");                      
                }
                $html.= "</table></div>";
            }else
            {
                $html="";
                $respuesta->alert("No hay Registros en el Departamento");                   
            }
        $respuesta->assign("contenedorTrabajador","innerHTML",$html);
        return $respuesta;
    }    
    
    function buscarPersona($id){
//        exit($id);
        $respuesta=new xajaxResponse();
        $contacto = new clContactoModelo();        
        $data=$contacto->selectContactoById($id);
        if(is_array($data)){
            $respuesta->assign("strnombre", "value", $data[0][strnombre].", ".$data[0][strapellido]);
            $respuesta->assign("id_contacto", "value", $data[0][id_contacto]);  
            $respuesta->script("$('contenedorTrabajador').hide();");                     
        }
        else  $respuesta->alert("El Trabajador no Existe");   
        return $respuesta;
    }    
    
    function verPersona($id){
        $respuesta=new xajaxResponse(); 
        if ($id)
        {
            $cod=clConstantesModelo::buscar_persona;
            if($id==$cod){
                $respuesta->script("$('CapaTrabajador').show();");
            }
            else {
                $respuesta->script("$('CapaTrabajador').hide();");
                    $respuesta->assign("strnombre", "value", '');
                    $respuesta->assign("id_contacto", "value", '');  
           }
        }
        return $respuesta;
    }    

    function selectClonarAgenda($id) {
    $respuesta = new xajaxResponse();
    $agenda= new clTblagenda();
    $data = "";
    $agenda->updateAgendaItem($id,0);    
    $data = $agenda->selectAgenda($id);
    if ($data) {
        $respuesta->script("$('fecha').hide();");           
        $respuesta->script('xajax_llenarSelectTipoAgenda(' . $data[0][id_tipo] . ')');
        if ($data[0][id_expediente]>0)
        {
             $respuesta->script('xajax_buscarExpediente(' . $data[0][id_expediente] . ')');
             $respuesta->script("$('CapaExpediente').show();");             
        }
        if ($data[0][id_contacto]>0)
        {
             $respuesta->script('xajax_buscarPersona(' . $data[0][id_contacto] . ')');
             $respuesta->script("$('CapaTrabajador').show();");             
        }            
        $respuesta->script('xajax_selectRefiereAgenda(' . $data[0][id_refiere] . ')');        
        $respuesta->script('xajax_llenarSelectTipoEvento(' . $data[0][id_evento] . ')');
        $respuesta->script('xajax_llenarSelectTipoPrioridad(' . $data[0][id_prioridad] . ')'); 
        $respuesta->script('xajax_llenarSelectTipoEstadoAgenda(' . $data[0][id_estado] . ')');   
        $respuesta->script('xajax_llenarSelectTipoRecordatorio(' . $data[0][id_recordatorio] . ')');     
        $respuesta->script('xajax_selectAllDpto(' . $data[0][id_unidad] . ')');         
        $respuesta->script('xajax_llenarSelectTipoOrganismo(' . $data[0][id_tipo_organismo] . ')');
        $respuesta->script('xajax_llenarSelectOrganismo(' . $data[0][id_tipo_organismo] . ',' . $data[0][id_organismo] . ')');        
        $respuesta->assign('strtitulo', 'value', $data[0][strtitulo]);
        $respuesta->assign('strtitulo', 'value', $data[0][strtitulo]);        
        $respuesta->assign('strpersona', 'value', $data[0][strpersona]);        
        $respuesta->assign('fecagenda', 'value', $data[0][fecagenda]);
        $respuesta->assign('strtitulo', 'value', $data[0][strtitulo]);
        $respuesta->assign('id_agenda', 'value', '');   
        $respuesta->script("FCKeditorAPI.__Instances['descripcion'].SetHTML('".$data[0][strdescripcion]."')");
    }
    return $respuesta;
}
    
    function ActualizarItemAgendaCreadas($id,$valor,$campo){
        $respuesta=new xajaxResponse(); 
        if ($id)
        {
            $agenda= new clTblagenda();            
            $agenda->updateAgendaItem($id,$valor,$campo); 
            $respuesta->alert("Requerimiento Procesado con Exito");      
            $respuesta->script('xajax_selectAllAgendaCreados();');
        }
        return $respuesta;
    } 
    
    function ActualizarItemAgenda($id,$valor,$campo){
        $respuesta=new xajaxResponse(); 
        if ($id)
        {
            $agenda= new clTblagenda();            
            $agenda->updateAgendaItem($id,$valor,$campo); 
            $respuesta->alert("Requerimiento Procesado con Exito");      
//            $respuesta->script('xajax_selectAllAgenda();');
        }
        return $respuesta;
    }         
    
  function selectRefiereAgenda($select= "", $ancho= "60%", $ajax=0) 
  {
        $respuesta= new xajaxResponse();
        $maestro= new clMaestroModelo();
        $data= "";
        $html= "";        
        $estados= clConstantesModelo::combos();
        $data= $maestro->selectAllMaestroHijos($estados['tipo_refiere_agenda'], "stritema");
        if ($ajax>0)
            $html= "<select id='id_refiere' name='id_refiere' style='width:".$ancho."'>";
        else
            $html= "<select id='id_refiere' name='id_refiere' style='width:".$ancho."' onchange=\"xajax_verPersona(document.frmAgenda.id_refiere.value)\">";            
        $html.= "<option value='0'>Seleccione</option>";        
        for($i= 0; $i < count($data); $i++){
               $seleccionar= "";
                if($select == $data[$i]['id_maestro']){
                    $seleccionar= "SELECTED";
                }            
                $html.= "<option value='".$data[$i]['id_maestro']."' ".$seleccionar.">".$data[$i]['stritema']."</option>";
        }
        $html.= "</select>";
        $respuesta->assign("capaIdRefiere","innerHTML",$html);
        return $respuesta;
    }    
    
    function selectAgenda($id) {
    $respuesta = new xajaxResponse();
    $agenda= new clTblagenda();
    $expedientelitigio = new clActuaciones();     
    $expediente = new clProExpediente();         
                
    $data = "";
    //
    $agenda->updateAgendaItem($id,0,'visto');
    
    $data = $agenda->selectAgenda($id);
    if ($data) {
        
        $respuesta->script('xajax_llenarSelectTipoAgenda(' . $data[0][id_tipo] . ')');
        if ($data[0][id_expediente]>0)
        {
             if($data[0][tipo_expediente] == clConstantesModelo::$TIPO_EXPEDIENTE['litigio'])
             {
                $data_expediente=$expedientelitigio->getExpedienteClienteAgendaLitigio($data[0][id_expediente]);
                if(is_array($data_expediente)){
                    $respuesta->assign("strnroexpediente", "value", $data_expediente[0][strnroexpediente]);
                    $respuesta->assign("id_proexpediente", "value", $data_expediente[0][id_proexpediente]);  
                }
//                 $respuesta->script('xajax_buscarExpedienteLitigio(' . $data[0][id_expediente] . ')');
             }else{
                $data_expediente=$expediente->getExpedienteClienteAgenda($data[0][id_expediente]);
                if(is_array($data_expediente)){
                    $respuesta->assign("strnroexpediente", "value", $data_expediente[0][strnroexpediente]);
                    $respuesta->assign("id_proexpediente", "value", $data_expediente[0][id_proexpediente]);  
                }                 
//                 $respuesta->script('xajax_buscarExpediente(' . $data[0][id_expediente] . ')');
             }
             
             $respuesta->script("$('CapaExpediente').show();");             
        }
        if ($data[0][id_contacto]>0)
        {
             $respuesta->script('xajax_buscarPersona(' . $data[0][id_contacto] . ')');
             $respuesta->script("$('CapaTrabajador').show();");             
        }        
        $respuesta->script('xajax_selectRefiereAgenda(' . $data[0][id_refiere] . ')');        
        $respuesta->script('xajax_llenarSelectTipoEvento(' . $data[0][id_evento] . ')');
        $respuesta->script('xajax_llenarSelectTipoPrioridad(' . $data[0][id_prioridad] . ')'); 
        $respuesta->script('xajax_llenarSelectTipoEstadoAgenda(' . $data[0][id_estado] . ')');   
        $respuesta->script('xajax_llenarSelectTipoRecordatorio(' . $data[0][id_recordatorio] . ')');     
        $respuesta->script('xajax_selectAllDpto(' . $data[0][id_unidad] . ')');         
        $respuesta->script('xajax_llenarSelectTipoOrganismo(' . $data[0][id_tipo_organismo] . ')');
        $respuesta->script('xajax_llenarSelectOrganismo(' . $data[0][id_tipo_organismo] . ',' . $data[0][id_organismo] . ')');        
        $respuesta->assign('strtitulo', 'value', $data[0][strtitulo]);
        $respuesta->assign('strpersona', 'value', $data[0][strpersona]);        
        $respuesta->assign('fecagenda', 'value', $data[0][fecagenda]);
        $respuesta->assign('fechacreacion', 'value', $data[0][date]);        
        $respuesta->assign('strtitulo', 'value', $data[0][strtitulo]);
        $respuesta->assign('id_agenda', 'value', $data[0][id_agenda]);        
        $respuesta->script("FCKeditorAPI.__Instances['descripcion'].SetHTML('".$data[0][strdescripcion]."')");
    }
    return $respuesta;
}
    
    
    function guardarAgenda($request){
        $respuesta= new xajaxResponse();
        $agenda= new clTblagenda();
        $agenda->llenar($request);
        if (functions::VerificarFechaActual(str_replace('/', '-', $request['fecagenda'])))
        {        
            if( $request['id_agenda'] =="") 
            {
                $data= $agenda->insertAgenda();
                $respuesta->script("if(confirm('La Agenda se Creo exitosamente, ¿Desea Crear otro Item de Agenda?')){ location.href='vista_insertTblAgenda.php';}else{location.href='vista_tblagenda.php';}");            
            }
            else 
            {
                $data= $agenda->updateAgenda();
                $respuesta->script("if(confirm('La Agenda se Actualizo exitosamente, ¿Desea Crear otro Item de Agenda?')){ location.href='vista_insertTblAgenda.php';}else{location.href='vista_tblagenda.php';}");                        
            }
            if(!$data){
                $respuesta->alert("La Agenda no se ha guardado");
            }
        }
        else
            $respuesta->alert("La fecha del Item de Agenda no puede vencer el mismo día, o ser menor a la fecha de Registro");
        return $respuesta;
    }   
    
    function validar_Agenda($request){
        $respuesta = new xajaxResponse();
            $campos_validar= array(
            'Tipo de Agenda'    => 'id_tipo',
            'Tipo de Prioridad'    => 'id_prioridad',
            'Tipo de Evento'    => 'id_evento',                
            'Tipo de Estado'    => 'id_estado',
            'Tipo de Recordatorio'    => 'id_recordatorio',                
            'Titulo del Evento'  => 'strtitulo',
            'Fecha de la Agenda'    => 'fecagenda',
            'Descripcion de la Agenda' => 'strdescripcion',
            );
            $validacion=  functions::validarFormulario('frmAgenda',$request,$campos_validar);
            if($validacion){
                $respuesta->alert($validacion['msg']);
                $respuesta->script($validacion['focus']);
            }else{
                $respuesta->script("xajax_guardarAgenda(xajax.getFormValues('frmAgenda'))");
            }
        return $respuesta;
    }    
    
    
     function llenarSelectOrganismo($valor, $select= "", $ancho= "60%") {
        $respuesta= new xajaxResponse();
        $maestro= new clMaestroModelo();
        $data= "";
        $html= "";;
        $data= $maestro->selectAllMaestroHijos($valor, 'stritema');
        $html= "<select id='id_organismo' name='id_organismo' style='width:".$ancho."' >";
        $html.= "<option value='0'>Seleccione</option>";
        if($data){
            for ($i= 0; $i < count($data); $i++){
               $seleccionar= "";
                if($select == $data[$i]['id_maestro']){
                    $seleccionar= "SELECTED";
                }
                $html.= "<option value='".$data[$i]['id_maestro']."' ".$seleccionar.">".$data[$i]['stritema']."</option>";
            }
            $html.= "</select>";
        }
        $respuesta->assign("capaIdOrganismo","innerHTML",$html);
        return $respuesta;
    }    
    
     function llenarSelectTipoOrganismo($select= "", $ancho= "60%") {
        $respuesta= new xajaxResponse();
        $maestro= new clMaestroModelo();
        $data= "";
        $html= "";
//        $estados= clConstantesModelo::combos();
//        $data= $maestro->selectAllMaestroHijos($estados['tipo_organismo'], 'stritema');
        $estados= clConstantesModelo::combos();
        $data= $maestro->selectAllMaestroHijos($estados['tipo_cen_des'],'stritema', 2);        
        $html= "<select id='id_tipo_organismo' name='id_tipo_organismo' style='width:".$ancho."' onchange=\"xajax_llenarSelectOrganismo(document.frmAgenda.id_tipo_organismo.value)\">";
        $html.= "<option value='0'>Seleccione</option>";
        if($data){
            for ($i= 0; $i < count($data); $i++){
               $seleccionar= "";
                if($select == $data[$i]['id_maestro']){
                    $seleccionar= "SELECTED";
                }
                $html.= "<option value='".$data[$i]['id_maestro']."' ".$seleccionar.">".$data[$i]['stritema']."</option>";
            }
            $html.= "</select>";
        }
        $respuesta->assign("capaIdTipoOrganismo","innerHTML",$html);
        return $respuesta;
    }    

  function selectAllDpto($select= "", $ancho= "60%") 
  {
        $respuesta= new xajaxResponse();
        $maestro= new clMaestroModelo();
        $data= "";
        $html= "";        
        $estados= clConstantesModelo::combos();
        $data= $maestro->selectAllMaestroHijos($estados['tipo_departamento_agenda'], "stritema");
        $html= "";
        $html= "<select id='id_unidad' name='id_unidad' style='width:".$ancho."' onchange=\"xajax_selectAllDptoIntegrantes(document.frmAgenda.id_unidad.value)\">";            
        $html.= "<option value='0'>Seleccione</option>";        
        for($i= 0; $i < count($data); $i++){
               $seleccionar= "";
                if($select == $data[$i]['id_maestro']){
                    $seleccionar= "SELECTED";
                }            
                $html.= "<option value='".$data[$i]['id_maestro']."' ".$seleccionar.">".$data[$i]['stritema']."</option>";
        }
        $html.= "</select>";
        $respuesta->assign("capaIdTipoUnidad","innerHTML",$html);
        return $respuesta;
    }
    
    
   function llenarSelectTipoRecordatorio($select= "", $ancho= "60%") {
        $respuesta= new xajaxResponse();
        $maestro= new clMaestroModelo();
        $data= "";
        $html= "";
        $estados= clConstantesModelo::combos();
        $data= $maestro->selectAllMaestroHijos($estados['tipo_recordatorio_agenda'], 'stritema');
//        exit(print_r($data));        
        $html= "<select id='id_recordatorio' name='id_recordatorio' style='width:".$ancho."'>";
        $html.= "<option value='0'>Seleccione</option>";
        if($data){
            for ($i= 0; $i < count($data); $i++){
               $seleccionar= "";
                if($select == $data[$i]['id_maestro']){
                    $seleccionar= "SELECTED";
                }
                $html.= "<option value='".$data[$i]['id_maestro']."' ".$seleccionar.">".$data[$i]['stritema']."</option>";
            }
            $html.= "</select>";
        }
        $respuesta->assign("capaIdTipoRecordatorio","innerHTML",$html);
        return $respuesta;
    }       
    
   function llenarSelectTipoEstadoAgenda($select= "", $ancho= "60%") {
        $respuesta= new xajaxResponse();
        $maestro= new clMaestroModelo();
        $data= "";
        $html= "";
        $estados= clConstantesModelo::combos();
        $data= $maestro->selectAllMaestroHijos($estados['tipo_estado_agenda'], 'stritema');
//        exit(print_r($data));        
        $html= "<select id='id_estado' name='id_estado' style='width:".$ancho."'>";
        $html.= "<option value='0'>Seleccione</option>";
        if($data){
            for ($i= 0; $i < count($data); $i++){
               $seleccionar= "";
                if($select == $data[$i]['id_maestro']){
                    $seleccionar= "SELECTED";
                }
                $html.= "<option value='".$data[$i]['id_maestro']."' ".$seleccionar.">".$data[$i]['stritema']."</option>";
            }
            $html.= "</select>";
        }
        $respuesta->assign("capaIdTipoEstado","innerHTML",$html);
        return $respuesta;
    }     
    
   function llenarSelectTipoEvento($select= "", $ancho= "60%") {
        $respuesta= new xajaxResponse();
        $maestro= new clMaestroModelo();
        $data= "";
        $html= "";
        $estados= clConstantesModelo::combos();
        $data= $maestro->selectAllMaestroHijos($estados['tipo_evento_agenda'], 'stritema');
//        exit(print_r($data));        
        $html= "<select id='id_evento' name='id_evento' style='width:".$ancho."'>";
        $html.= "<option value='0'>Seleccione</option>";
        if($data){
            for ($i= 0; $i < count($data); $i++){
               $seleccionar= "";
                if($select == $data[$i]['id_maestro']){
                    $seleccionar= "SELECTED";
                }
                $html.= "<option value='".$data[$i]['id_maestro']."' ".$seleccionar.">".$data[$i]['stritema']."</option>";
            }
            $html.= "</select>";
        }
        $respuesta->assign("capaIdTipoEvento","innerHTML",$html);
        return $respuesta;
    }         

   function llenarSelectTipoPrioridad($select= "", $ancho= "60%") {
        $respuesta= new xajaxResponse();
        $maestro= new clMaestroModelo();
        $data= "";
        $html= "";
        $estados= clConstantesModelo::combos();
        $data= $maestro->selectAllMaestroHijos($estados['tipo_prioridad_agenda'], 'stritema');
//        exit(print_r($data));        
        $html= "<select id='id_prioridad' name='id_prioridad' style='width:".$ancho."'>";
        $html.= "<option value='0'>Seleccione</option>";
        if($data){
            for ($i= 0; $i < count($data); $i++){
               $seleccionar= "";
                if($select == $data[$i]['id_maestro']){
                    $seleccionar= "SELECTED";
                }
                $html.= "<option value='".$data[$i]['id_maestro']."' ".$seleccionar.">".$data[$i]['stritema']."</option>";
            }
            $html.= "</select>";
        }
        $respuesta->assign("capaIdTipoPrioridad","innerHTML",$html);
        return $respuesta;
    }     

    function buscarExpedienteLitigio($id){
        $respuesta=new xajaxResponse();
        $expediente = new clActuaciones();         
        $data=$expediente->getExpedienteClienteAgendaLitigio($id);
        if(is_array($data)){
            $respuesta->script('xajax_llenarSelectTipoAgenda(13221)');            
            $respuesta->script('xajax_llenarSelectTipoOrganismo(' . $data[0][id_tipo_organismo_centralizado] . ')');
            $respuesta->script('xajax_llenarSelectOrganismo(' . $data[0][id_tipo_organismo_centralizado] . ',' . $data[0][id_tipo_organismo] . ')');        
            $respuesta->assign("strnroexpediente", "value", $data[0][strnroexpediente]);
//            $respuesta->assign("strpersona", "value", $data[0][strnombre]);          
//            $respuesta->assign("fecagenda", "value", $data[0][fecapertura]);                       
            
            $respuesta->assign("id_proexpediente", "value", $data[0][id_proexpediente]);  
            $respuesta->script("FCKeditorAPI.__Instances['descripcion'].SetHTML('Refiere a Expediente Nro:".$data[0][strnroexpediente]."<br /><br />".$data[0][strdescripcion]."<br type=\"_moz\" />')");            
            $respuesta->script("$('contenedorExpediente').hide();");                     
        }
        else  $respuesta->alert("El Expediente no Existe");   
        return $respuesta;
    }
    
    
    function buscarExpediente($id){
        $respuesta=new xajaxResponse();
        $expediente = new clProExpediente();         
        $data=$expediente->getExpedienteClienteAgenda($id);
        if(is_array($data)){
            $respuesta->script('xajax_llenarSelectTipoAgenda(13221)');            
            $respuesta->script('xajax_llenarSelectTipoOrganismo(' . $data[0][id_tipo_organismo] . ')');
            $respuesta->script('xajax_llenarSelectOrganismo(' . $data[0][id_tipo_organismo] . ',' . $data[0][id_organismo] . ')');        
            $respuesta->assign("strnroexpediente", "value", $data[0][strnroexpediente]);
            $respuesta->assign("strpersona", "value", $data[0][strnombre]);          
//            $respuesta->assign("fecagenda", "value", $data[0][fecapertura]);                       
            
            $respuesta->assign("id_proexpediente", "value", $data[0][id_proexpediente]);  
            $respuesta->script("FCKeditorAPI.__Instances['descripcion'].SetHTML('Refiere a Expediente Nro:".$data[0][strnroexpediente]."<br /><br />".$data[0][strdescripcion]."<br type=\"_moz\" />')");            
            $respuesta->script("$('contenedorExpediente').hide();");                     
        }
        else  $respuesta->alert("El Expediente no Existe");   
        return $respuesta;
    }    
    
    
    function buscarExpedientePopup($str){
//        exit($str."PASO");
        $respuesta= new xajaxResponse();
        $expediente = new clProExpediente();        
        $data= "";
        $html= "";      
//        exit($str."PASO");            
        $data=$expediente->SelectExpedienteAgendaLike($str);
//        exit($str."PASO");        
        if($data){
                $html= "<div style='border:solid 1px #CCCCCC;background:#f8f8f8'>
                            <table style='text-align:center' border='0' class='tablaTitulo' width='100%'>
                            <tr>
                                <td colspan=\"5\" align=\"right\" style=\"color:white; border:#CCCCCC solid 0px;\" bgcolor=\"#273785\" >
                                    <div align=\"center\" style=\"background-image: url('../comunes/images/barra.png')\">
                                        <strong>LISTADO DE EXPEDIENTE</strong>
                                    </div>                                
                                </td>
                            </tr>                               
                                <tr>
                                    <th width='10%'>
                                        <a href='#' onclick=\"xajax_orden('id_maestro')\">Id</a>
                                    </th>                                
                                    <th width='21%'>
                                        <a href='#' onclick=\"xajax_orden('id_maestro')\">Expediente</a>
                                    </th>
                                    <th width='22%'>
                                        <a href='#' onclick=\"xajax_orden('id_origen')\">C.I Abogado</a>
                                    </th>
                                    <th width='22%'>
                                        <a href='#' onclick=\"xajax_orden('id_origen')\">Tramite</a>
                                    </th>                                    
                                    <th width='5%'>
                                        <a href='#' onclick=\"xajax_orden('id_origen')\">Acción</a>
                                    </th>                                         
                                </tr>";
                for ($i= 0; $i < count($data); $i++){

                    $html.= "<tr bgcolor='#f8f8f8'onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue'\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
                                <td align='center'>".$i."</td>
                                <td align='center'>".$data[$i]['strnroexpediente']."</td>
                                <td align='center'>".$data[$i]['cedula_abogado_responsable']."</td>
                                <td align='center'>".  clFunciones::mostrarStritema($data[$i]['id_tipo_tramite'])."</td>                       
                                <td align='center'>
                                        <a>
                                            <img src='../comunes/images/s_success.png' onmouseover='Tip(\"Elegir Expediente\")' onmouseout='UnTip()' onclick=\"xajax_buscarExpediente('".$data[$i][id_proexpediente]."')\">
                                        </a>                                   
                                </td>
                            </tr>";
                }
                $html.= "</table></div>";
            }else{
                $html="";
            }
//        $respuesta->script("$('contenedorExpediente').show();");            
        $respuesta->assign("contenedorExpediente","innerHTML",$html);
        return $respuesta;
    }
        
        
    
    
    function verExpediente($id,$expediente){
        $respuesta=new xajaxResponse(); 
        if ($id)
        {
            $cod=clConstantesModelo::buscar_expediente;
            if ($expediente!='')
            {    
                if($id==$cod){
                    $respuesta->script("$('CapaExpediente').show();");
                }
                else {
                    $respuesta->script("$('CapaExpediente').hide();");
                        $respuesta->assign("strnroexpediente", "value", '');
                        $respuesta->assign("id_proexpediente", "value", '');  
                        $respuesta->script("FCKeditorAPI.__Instances['descripcion'].SetHTML('')");            
                }
           }           
        }
        return $respuesta;
    }
            
    
   function llenarSelectTipoAgenda($select= "", $ancho= "60%", $ajax=0) {
        $respuesta= new xajaxResponse();
        $maestro= new clMaestroModelo();
        $data= "";
        $html= "";
        $estados= clConstantesModelo::combos();
        $data= $maestro->selectAllMaestroHijos($estados['tipos_agenda'], 'stritema');
        if ($ajax>0)
            $html= "<select id='id_tipo' name='id_tipo' style='width:".$ancho."'>";
        else
            $html= "<select id='id_tipo' name='id_tipo' style='width:".$ancho."' onchange=\"xajax_verExpediente(document.frmAgenda.id_tipo.value,document.frmAgenda.id_agenda_expediente.value)\">";            
        $html.= "<option value='0'>Seleccione</option>";
        if($data){
            for ($i= 0; $i < count($data); $i++){
               $seleccionar= "";
                if($select == $data[$i]['id_maestro']){
                    $seleccionar= "SELECTED";
                }
                $html.= "<option value='".$data[$i]['id_maestro']."' ".$seleccionar.">".$data[$i]['stritema']."</option>";
            }
            $html.= "</select>";
        }
        $respuesta->assign("capaIdTipo","innerHTML",$html);
        return $respuesta;
    }     

    function selectAllAgenda($pagina, $fil_id_tipo=0, $fil_id_evento=0, $fil_id_unidad=0, $fil_id_prioridad=0, $fil_id_integrantes_unidad=0, $fil_id_expediente=''){
        $respuesta= new xajaxResponse();
        $proagenda= new clTblagenda();
        $data= "";
        $html= "";
	if (($fil_id_tipo>0) or ($fil_id_evento>0) or ($fil_id_unidad>0) or ($fil_id_prioridad>0)  or ($fil_id_integrantes_unidad>0)  or ($fil_id_expediente!=''))  {
            $dataC= $proagenda->selectFiltrarAgenda($pagina, $fil_id_tipo, $fil_id_evento, $fil_id_unidad, $fil_id_prioridad, $fil_id_integrantes_unidad, $fil_id_expediente);
            $data= $dataC[0];
            $paginacion=true;            
        }
        else
        {
            $dataC= $proagenda->selectAllAgenda($pagina);
            $data= $dataC[0];
            $paginacion=true;
        }
        if($data){
//            print_r($data);
//            exit;
            $html= "<div style='border:solid 1px #CCCCCC;background:#f8f8f8'>
                        <table border='0' class='tablaTitulo' width='100%'>
                            <tr>
                                <th width='5%'>
                                    <a href='#' onclick=\"xajax_orden('id_honorarios')\"></a>
                                </th>                               
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('id_honorarios')\">Agenda</a>
                                </th>  
                                <th width='15%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Departamentto</a>
                                </th>                                
                                <th width='7%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Evento</a>
                                </th>
                                <th width='15%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Titulo</a>
                                </th>                                
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('Tramite')\">Prioridad</a>
                                </th>
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('Unidad')\">Estado</a>
                                </th>                    
                                <th width='5%'>
                                    <a href='#' onclick=\"xajax_orden('Unidad')\">Días</a>
                                </th>                                   
                                <th width='30%'>Acci&oacute;n</th>
                            </tr></table>";
            for ($i= 0; $i < count($data); $i++){
                if ($data[$i][visto]==1)
                    $html.= "<table border='0' class='tablaTitulo' width='100%'><tr bgcolor='#fbffd7'onmouseover=\"this.style.background='#ffc05c';this.style.color='blue'\" onmouseout=\"this.style.background='#fbffd7';this.style.color='black'\" >";
                else
                    $html.= "<table border='0' class='tablaTitulo' width='100%'><tr bgcolor='#f8f8f8'onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue'\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >";                    
                $html.= "<td width='5%' align='center'><img src='../comunes/images/".$data[$i][origen].".png' height='20px' onmouseover=\"Tip('Prioridad Alta', TITLE, 'Origen')\" onmouseout='UnTip()'\"></td>
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_tipo_agenda]."</td>
                            <td width='15%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".clTblagenda::getMaestro($data[$i][id_unidad])."</td>                    
                            <td width='7%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_evento_agenda]."</td>
                            <td width='15%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][strtitulo]."</td>                                
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_prioridad_agenda]."</td>
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_estado_agenda]."</td>                               
                            <td width='5%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".functions::diterenciaFechasDiasAgenda($data[$i][fecagenda])."</td>
                            <td width='30%'  align='center'>";
                $color=functions::diterenciaFechasSemaforoAgenda($data[$i]['fecagenda'],clTblagenda::getDiasRecordatorios($data[$i]['id_recordatorio']));
                if ($data[$i][id_prioridad]==clConstantesModelo::prioridad_alta)
                {
                    $html.="<a>
                                    <img src='../comunes/images/flag_red.png' height='17px' onmouseover=\"Tip('Prioridad Alta')\" onmouseout='UnTip()'\">
                                </a>";
                }elseif ($data[$i][id_prioridad]==clConstantesModelo::prioridad_media) {
                    $html.="<a>
                                    <img src='../comunes/images/flag_green.png' height='17px' onmouseover=\"Tip('Prioridad Media')\" onmouseout='UnTip()'\">
                                </a>";                
                }else{
                    $html.="<a>
                                    <img src='../comunes/images/flag_yellow.png' height='17px' onmouseover=\"Tip('Prioridad Baja')\" onmouseout='UnTip()'\">
                                </a>";                
                }                      
                if ($data[$i][id_refiere]==clConstantesModelo::buscar_refiere)
                {
                    $html.="<a>
                                    <img src='../comunes/images/UserGroup.png' height='17px' onmouseover=\"Tip('Refiere Departamento')\" onmouseout='UnTip()'\">
                                </a>";
                }                      
                if ($data[$i][id_refiere]==clConstantesModelo::buscar_persona)
                {
                    if ($data[$i][id_seguimiento]!='')
                    {
                        if (clTblagenda::getEstadoAgendaSeguimiento($data[$i][id_seguimiento])==1)
                        {
                            $image='group_error.png';
                            $msg='Mensaje no Leido';
                        }
                        else
                        { 
                            $image='group.png';         
                            $msg='Mensaje Leido';                            
                        }
                    }
                    else
                        $image='group.png';                     
                          
                    $html.="<a>
                                    <img src='../comunes/images/".$image."' height='17px' onmouseover=\"Tip('".$msg."')\" onmouseout='UnTip()'\">
                                </a>";
                }                      
                if ($color=='R')
                {
                    $html.="<a>
                                    <img src='../comunes/images/rojo.gif' height='17px' onmouseover=\"Tip('Agenda Pendiente Vencidas')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";
                }
                elseif ($color=='A')
                {        
                    $html.="<a>
                                    <img src='../comunes/images/amarillo.gif' height='17px'  onmouseover=\"Tip('Agenda Pendiente por Vencer')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";                
                }
                elseif ($color=='V')
                {
                    $html.="<a>
                                    <img src='../comunes/images/verde.gif' height='17px'  onmouseover=\"Tip('Agenda Pendiente')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";                   
                }                            
                $html.="        <a>
                                    <img src='../comunes/images/page_edit.png' onmouseover='Tip(\"Editar Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";  
                $html.="<a>
                                    <img src='../comunes/images/ver.gif' onmouseover=\"Tip('Detalle de la Agenda')\" onmouseout='UnTip()' onclick=\"location.href='../reportes/reporte_agenda_individual.php?id=".$data[$i]['id_agenda']."'\">
                                </a>";
                if ($data[$i][visto]!=1)
                 $html.="       <a>
                                    <img src='../comunes/images/Undo.png' onmouseover='Tip(\"Marcar como no Leido Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"xajax_ActualizarItemAgenda('".$data[$i]['id_agenda']."','1','visto');\">
                                </a>
                                <a>
                                    <img src='../comunes/images/table_multiple.png' onmouseover='Tip(\"Clonar Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."&clon=1'\">
                                </a>
                                <a>
                                    <img src='../comunes/images/vcard_delete.png' onmouseover='Tip(\"Eliminar Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"if(confirm('¿Desea Eliminar el Item de Agenda?')){xajax_ActualizarItemAgenda('".$data[$i]['id_agenda']."','1','bolborrado')};\">
                                </a>";
                
                
                 $html.="</td></tr></table>";
            }
            $html.= "</div>";
        }else{
            $html="<div class='celda_etiqueta'>No Hay Items Registrados</div>";
        }
        $respuesta->assign("contenedorAgenda","innerHTML",$html);
        if ($paginacion) $respuesta->assign("pagAgenda","innerHTML",$dataC[1]);           
        return $respuesta;
    }    
    
    function selectAllAgendaCreados($fil_id_tipo=0, $fil_id_evento=0, $fil_id_unidad=0, $fil_id_prioridad=0, $fil_id_integrantes_unidad=0, $fil_id_expediente=''){
        $respuesta= new xajaxResponse();
        $proagenda= new clTblagenda();
        $data= "";
        $html= "";
	if (($fil_id_tipo>0) or ($fil_id_evento>0) or ($fil_id_unidad>0) or ($fil_id_prioridad>0)  or ($fil_id_integrantes_unidad>0)  or ($fil_id_expediente!=''))  {
            $data= $proagenda->selectFiltrarAgendaCreados($fil_id_tipo, $fil_id_evento, $fil_id_unidad, $fil_id_prioridad, $fil_id_integrantes_unidad, $fil_id_expediente);
        }
        else
        {
            $data= $proagenda->selectAllAgendaCreados();
        }
        if($data){
            $html= "<div style='border:solid 1px #CCCCCC;background:#f8f8f8'>
                        <table border='0' class='tablaTitulo' width='100%'>
                            <tr>
                                <th width='5%'>
                                    <a href='#' onclick=\"xajax_orden('id_honorarios')\"></a>
                                </th>                               
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('id_honorarios')\">Agenda</a>
                                </th>                            
                                <th width='15%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Departamentto</a>
                                </th>                                
                                <th width='7%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Evento</a>
                                </th>
                                <th width='15%'>
                                    <a href='#' onclick=\"xajax_orden('id_tipo')\">Titulo</a>
                                </th>                                
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('Tramite')\">Prioridad</a>
                                </th>
                                <th width='10%'>
                                    <a href='#' onclick=\"xajax_orden('Unidad')\">Estado</a>
                                </th>                    
                                <th width='5%'>
                                    <a href='#' onclick=\"xajax_orden('Unidad')\">Días</a>
                                </th>                                   
                                <th width='30%'>Acci&oacute;n</th>
                            </tr></table>";
            for ($i= 0; $i < count($data); $i++){
                if ($data[$i][visto]==1)
                    $html.= "<table border='0' class='tablaTitulo' width='100%'><tr bgcolor='#fbffd7'onmouseover=\"this.style.background='#ffc05c';this.style.color='blue'\" onmouseout=\"this.style.background='#fbffd7';this.style.color='black'\" >";
                else
                    $html.= "<table border='0' class='tablaTitulo' width='100%'><tr bgcolor='#f8f8f8'onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue'\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >";                    
                $html.= "<td width='5%' align='center'><img src='../comunes/images/".$data[$i][origen].".png' height='20px' onmouseover=\"Tip('Prioridad Alta')\" onmouseout='UnTip()'\"></td>
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_tipo_agenda]."</td>
                            <td width='15%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".clTblagenda::getMaestro($data[$i][id_unidad])."</td>                    
                            <td width='7%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_evento_agenda]."</td>
                            <td width='15%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][strtitulo]."</td>                                
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_prioridad_agenda]."</td>
                            <td width='10%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".$data[$i][id_estado_agenda]."</td>                               
                            <td width='5%'  align='center' onmouseover=\"Tip('".$data[$i][strtitulo]."', TITLE, 'Asunto')\" onmouseout='UnTip()'>".functions::diterenciaFechasDiasAgenda($data[$i][fecagenda])."</td>
                            <td width='30%'  align='center'>";
                $color=functions::diterenciaFechasSemaforoAgenda($data[$i]['fecagenda'],clTblagenda::getDiasRecordatorios($data[$i]['id_recordatorio']));
                if ($data[$i][id_prioridad]==clConstantesModelo::prioridad_alta)
                {
                    $html.="<a>
                                    <img src='../comunes/images/flag_red.png' height='17px' onmouseover=\"Tip('Prioridad Alta')\" onmouseout='UnTip()'\">
                                </a>";
                }elseif ($data[$i][id_prioridad]==clConstantesModelo::prioridad_media) {
                    $html.="<a>
                                    <img src='../comunes/images/flag_green.png' height='17px' onmouseover=\"Tip('Prioridad Media')\" onmouseout='UnTip()'\">
                                </a>";                
                }else{
                    $html.="<a>
                                    <img src='../comunes/images/flag_yellow.png' height='17px' onmouseover=\"Tip('Prioridad Baja')\" onmouseout='UnTip()'\">
                                </a>";                
                }                      
                if ($data[$i][id_refiere]==clConstantesModelo::buscar_refiere)
                {
                    $html.="<a>
                                    <img src='../comunes/images/UserGroup.png' height='17px' onmouseover=\"Tip('Refiere Departamento')\" onmouseout='UnTip()'\">
                                </a>";
                }                      
                if ($data[$i][id_refiere]==clConstantesModelo::buscar_persona)
                {
                    if ($data[$i][id_seguimiento]!='')
                    {
                        if (clTblagenda::getEstadoAgendaSeguimiento($data[$i][id_seguimiento])==1)
                        {
                            $image='group_error.png';
                            $msg='Mensaje no Leido';
                        }
                        else
                        { 
                            $image='group.png';         
                            $msg='Mensaje Leido';                            
                        }
                    }
                    else
                        $image='group.png';                     
                          
                    $html.="<a>
                                    <img src='../comunes/images/".$image."' height='17px' onmouseover=\"Tip('".$msg."')\" onmouseout='UnTip()'\">
                                </a>";
                }                      
                if ($color=='R')
                {
                    $html.="<a>
                                    <img src='../comunes/images/rojo.gif' height='17px' onmouseover=\"Tip('Agenda Pendiente Vencidas')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";
                }
                elseif ($color=='A')
                {        
                    $html.="<a>
                                    <img src='../comunes/images/amarillo.gif' height='17px'  onmouseover=\"Tip('Agenda Pendiente por Vencer')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";                
                }
                elseif ($color=='V')
                {
                    $html.="<a>
                                    <img src='../comunes/images/verde.gif' height='17px'  onmouseover=\"Tip('Agenda Pendiente')\" onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";                   
                }                            
                $html.="        <a>
                                    <img src='../comunes/images/page_edit.png' onmouseover='Tip(\"Editar Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"javascript:location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."'\";\">
                                </a>";
                $html.="<a>
                                    <img src='../comunes/images/ver.gif' onmouseover=\"Tip('Detalle de la Agenda')\" onmouseout='UnTip()' onclick=\"location.href='../reportes/reporte_agenda_individual.php?id=".$data[$i]['id_agenda']."'\">
                                </a>";
                if ($data[$i][visto]!=1)
                 $html.="       <a>
                                    <img src='../comunes/images/Undo.png' onmouseover='Tip(\"Marcar como no Leido Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"xajax_ActualizarItemAgenda('".$data[$i]['id_agenda']."','1','visto');\">
                                </a>
                                <a>
                                    <img src='../comunes/images/table_multiple.png' onmouseover='Tip(\"Clonar Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"location.href='vista_insertTblAgenda.php?id=".$data[$i]['id_agenda']."&clon=1'\">
                                </a>
                                <a>
                                    <img src='../comunes/images/vcard_delete.png' onmouseover='Tip(\"Eliminar Item Agenda ".$data[$i]['id_agenda']."\")' onmouseout='UnTip()' onclick=\"if(confirm('¿Desea Eliminar el Item de Agenda?')){xajax_ActualizarItemAgendaCreadas('".$data[$i]['id_agenda']."','1','bolborrado')};\">
                                </a>";                                 
                 $html.="</td></tr></table>";
            }
            $html.= "</div>";
        }else{
            $html="<div class='celda_etiqueta'>No Hay Items Registrados</div>";
        }
        $respuesta->assign("contenedorAgenda","innerHTML",$html);
        return $respuesta;
    }    
    
    
    
   // AGENDA EXPEDIENTE LITIGIO
    
//    function buscarExpedienteLitigio($id){
//        $respuesta=new xajaxResponse();
//        $expediente = new clActuaciones();  
////        exit("voy");
//        $data=$expediente->getExpedienteClienteAgenda($id);
//        
//        if(is_array($data)){
//            $respuesta->assign("strnroexpediente", "value", $data[0][strnroexpediente]);
//            $respuesta->assign("id_pro_expediente", "value", $data[0][id_proactuacion]);  
//            $respuesta->script("FCKeditorAPI.__Instances['descripcion'].SetHTML('Refiere a Expediente Nro:".$data[0][strnroexpediente]."<br /><br />".$data[0][strdescripcion]."<br type=\"_moz\" />')");            
//            $respuesta->script("$('contenedorExpediente').hide();");                     
//        }
//        else  $respuesta->alert("El Expediente no Existe");   
//        return $respuesta;
//    }
    
     function validar_Agenda_Expediente_Litigio($request){
        $respuesta = new xajaxResponse();
            $campos_validar= array(
            'Tipo de Agenda'    => 'id_tipo',
            'Tipo de Prioridad'    => 'id_prioridad',
            'Tipo de Evento'    => 'id_evento',                
            'Tipo de Estado'    => 'id_estado',
            'Tipo de Recordatorio'    => 'id_recordatorio',                
            'Titulo del Evento'  => 'strtitulo',
            'Fecha de la Agenda'    => 'fecagenda',
            'Descripcion de la Agenda' => 'strdescripcion',
            );
            $validacion=  functions::validarFormulario('frmAgenda',$request,$campos_validar);
            if($validacion){
                $respuesta->alert($validacion['msg']);
                $respuesta->script($validacion['focus']);
            }else{
                $respuesta->script("xajax_guardarAgendaExpedienteLitigio(xajax.getFormValues('frmAgenda'))");
            }
        return $respuesta;
    }
    
    function guardarAgendaExpedienteLitigio($request){
        $respuesta= new xajaxResponse();
        $agenda= new clTblagenda();
        $agenda->llenar($request);
       // exit(print_r($request));
        if (functions::VerificarFechaActual(str_replace('/', '-', $request['fecagenda'])))
        {        
            if( $request['id_agenda'] =="") 
            {
                $data= $agenda->insertAgendaLitigio();
                $respuesta->alert("La Agenda se creo Exitosamente");                
                $respuesta->script("location.href='vista_tblagenda_Litigio.php?id=".$request['id_agenda_expediente']."';");            
            }
            else 
            {
                //exit($request['id_agenda_expediente']);
                $data= $agenda->updateAgendaLitigio();
                $respuesta->alert("La Agenda se Actualizo Exitosamente");                    
                $respuesta->script("location.href='vista_tblagenda_Litigio.php?id=".$request['id_agenda_expediente']."';"); 
            }
            if(!$data){
                $respuesta->alert("La Agenda no se ha guardado");
            }
        }
        else
            $respuesta->alert("La fecha del Item de Agenda no puede vencer el mismo día, o ser menor a la fecha de Registro");
        return $respuesta;
    }
    
    
    
?>
