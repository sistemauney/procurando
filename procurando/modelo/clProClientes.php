<?php
 require_once "../controlador/Conexion.php";
 /**
 * Description of clTbl_clientes
 * @author jmendoza
 */
 class clProClientes {

//=========================== VAR ===================




  private   $id_cliente;

  private   $strnombre;

  private   $strapellido;

  private   $strcedula;

  private   $strdireccion;

  private   $id_estado;

  private   $id_municipio;

  private   $strtelefono;

  private   $stremail;

  private   $id_estado_civil;

  private   $id_sexo;

  private   $inthijos;

  private   $strcodigopostal;

  private   $datefecnac;

  private   $strobservacion;

  private   $id_representante=0;

  private   $id_organizacion=0;

  private   $strdocumentoconst;

  private   $strrif;

  private   $strmovil;

//=========================== FUNCION LLENAR ===================




public function llenar($request)
{
     if($request['id_cliente'] != ""){
        $this->set_id_cliente($request['id_cliente']);
     }


     if($request['strnombre'] != ""){
        $this->set_strnombre($request['strnombre']);
     }


     if($request['strapellido'] != ""){
        $this->set_strapellido($request['strapellido']);
     }


     if($request['strcedula'] != ""){
        $this->set_strcedula($request['strcedula']);
     }


     if($request['strdireccion'] != ""){
        $this->set_strdireccion($request['strdireccion']);
     }


     if($request['id_estado'] != ""){
        $this->set_id_estado($request['id_estado']);
     }


     if($request['id_municipio'] != ""){
        $this->set_id_municipio($request['id_municipio']);
     }


     if($request['strtelefono'] != ""){
        $this->set_strtelefono($request['strtelefono']);
     }


     if($request['stremail'] != ""){
        $this->set_stremail($request['stremail']);
     }


     if($request['id_estado_civil'] != ""){
        $this->set_id_estado_civil($request['id_estado_civil']);
     }


     if($request['id_sexo'] != ""){
        $this->set_id_sexo($request['id_sexo']);
     }


     if($request['inthijos'] != ""){
        $this->set_inthijos($request['inthijos']);
     }
     else $this->set_inthijos(0);


     if($request['strcodigopostal'] != ""){
        $this->set_strcodigopostal($request['strcodigopostal']);
     }


     if($request['datefecnac'] != ""){
        $this->set_datefecnac($request['datefecnac']);
     }
     else $this->set_datefecnac(date('d/m/Y'));


     if($request['strobservacion'] != ""){
        $this->set_strobservacion($request['strobservacion']);
     }


     if($request['id_representante'] != ""){
        $this->set_id_representante($request['id_representante']);
     }


     if($request['id_organizacion'] != ""){
        $this->set_id_organizacion($request['id_organizacion']);
     }


     if($request['strdocumentoconst'] != ""){
        $this->set_strdocumentoconst($request['strdocumentoconst']);
     }


     if($request['strrif'] != ""){
        $this->set_strrif($request['strrif']);
     }


     if($request['strmovil'] != ""){
        $this->set_strmovil($request['strmovil']);
     }

}//=========================== GET ===================




    public function get_id_cliente(){
        return $this->id_cliente;
    }



    public function get_strnombre(){
        return $this->strnombre;
    }



    public function get_strapellido(){
        return $this->strapellido;
    }



    public function get_strcedula(){
        return $this->strcedula;
    }



    public function get_strdireccion(){
        return $this->strdireccion;
    }



    public function get_id_estado(){
        return $this->id_estado;
    }



    public function get_id_municipio(){
        return $this->id_municipio;
    }



    public function get_strtelefono(){
        return $this->strtelefono;
    }



    public function get_stremail(){
        return $this->stremail;
    }



    public function get_id_estado_civil(){
        return $this->id_estado_civil;
    }



    public function get_id_sexo(){
        return $this->id_sexo;
    }



    public function get_inthijos(){
        return $this->inthijos;
    }



    public function get_strcodigopostal(){
        return $this->strcodigopostal;
    }



    public function get_datefecnac(){
        return $this->datefecnac;
    }



    public function get_strobservacion(){
        return $this->strobservacion;
    }



    public function get_id_representante(){
        return $this->id_representante;
    }



    public function get_id_organizacion(){
        return $this->id_organizacion;
    }



    public function get_strdocumentoconst(){
        return $this->strdocumentoconst;
    }



    public function get_strrif(){
        return $this->strrif;
    }



    public function get_strmovil(){
        return $this->strmovil;
    }



//=========================== SET ===================




    public function set_id_cliente($id_cliente){
         $this->id_cliente=$id_cliente;
    }



    public function set_strnombre($strnombre){
         $this->strnombre=$strnombre;
    }



    public function set_strapellido($strapellido){
         $this->strapellido=$strapellido;
    }



    public function set_strcedula($strcedula){
         $this->strcedula=$strcedula;
    }



    public function set_strdireccion($strdireccion){
         $this->strdireccion=$strdireccion;
    }



    public function set_id_estado($id_estado){
         $this->id_estado=$id_estado;
    }



    public function set_id_municipio($id_municipio){
         $this->id_municipio=$id_municipio;
    }



    public function set_strtelefono($strtelefono){
         $this->strtelefono=$strtelefono;
    }



    public function set_stremail($stremail){
         $this->stremail=$stremail;
    }



    public function set_id_estado_civil($id_estado_civil){
         $this->id_estado_civil=$id_estado_civil;
    }



    public function set_id_sexo($id_sexo){
         $this->id_sexo=$id_sexo;
    }



    public function set_inthijos($inthijos){
         $this->inthijos=$inthijos;
    }



    public function set_strcodigopostal($strcodigopostal){
         $this->strcodigopostal=$strcodigopostal;
    }



    public function set_datefecnac($datefecnac){
         $this->datefecnac=$datefecnac;
    }



    public function set_strobservacion($strobservacion){
        $this->strobservacion=$strobservacion;
    }



    public function set_id_representante($id_representante){
        if(isset($id_representante)  and $id_representante == "on"){
            $this->id_representante = 1;
        }
    }



    public function set_id_organizacion($id_organizacion){
        return $this->id_organizacion=$id_organizacion;
    }



    public function set_strdocumentoconst($strdocumentoconst){
        return $this->strdocumentoconst=$strdocumentoconst;
    }



    public function set_strrif($strrif){
        return $this->strrif=$strrif;
    }



    public function set_strmovil($strmovil){
        return $this->strmovil=$strmovil;
    }


    public static function getNombreClienteExpediente($id){
        $conn= new Conexion();
        $conn->abrirConexion();
        $sql="SELECT upper(strapellido) as strapellido, upper(strnombre) as strnombre FROM ".clConstantesModelo::correspondencia_table."tbl_clientes WHERE id_cliente=".$id;        
//        exit($sql);
        $conn->sql= $sql;
        $data= $conn->ejecutarSentencia(2);
        $conn->cerrarConexion();
        if ($data[0][strapellido])
        return $data[0][strapellido].', '.$data[0][strnombre];
        else return "";
    }    
    
    public static function getNombreCIClienteExpediente($id){
        $conn= new Conexion();
        $conn->abrirConexion();
        $sql="SELECT strcedula FROM ".clConstantesModelo::correspondencia_table."tbl_clientes WHERE id_cliente=".$id;        
//        exit($sql);
        $conn->sql= $sql;
        $data= $conn->ejecutarSentencia(2);
        $conn->cerrarConexion();
        if ($data[0][strcedula])
        return $data[0][strcedula];
        else return "";
    }      
        
    
    
    public static function getCedulaClienteExpediente($id){
        $conn= new Conexion();
        $conn->abrirConexion();
        $sql="SELECT id_solicitante FROM ".clConstantesModelo::correspondencia_table."tblproexpediente WHERE id_solicitante=".$id;        
//        exit($sql);
        $conn->sql= $sql;
        $data= $conn->ejecutarSentencia(2);
        $conn->cerrarConexion();
        if ($data[0][id_solicitante])
        return $data[0][id_solicitante];
        else return "";
    }    
    
    public static function getCedulaCliente($cedula){
        $conn= new Conexion();
        $conn->abrirConexion();
        $sql="SELECT strcedula FROM ".clConstantesModelo::correspondencia_table."tbl_clientes WHERE strcedula::integer=".$cedula;        
        //exit($sql);
        $conn->sql= $sql;
        $data= $conn->ejecutarSentencia(2);
        $conn->cerrarConexion();
        return $data[0][strcedula];
    }     
    
    public static function getBuscarAbogadoCedulaRepetido($cedula){
        $conn= new Conexion();
        $conn->abrirConexion();
        $sql="SELECT strcedula FROM ".clConstantesModelo::correspondencia_table."tbl_clientes WHERE trim(strcedula)='".$cedula."'";        
//        exit($sql);
        $conn->sql= $sql;
        $data= $conn->ejecutarSentencia(2);
        $conn->cerrarConexion();
        if ($data[0][strcedula])
        return $data[0][strcedula];
        else return "";
    }              



//================================FUNCION INSERTAR============================================


     public function insertar(){
         $conn= new Conexion();
         $conn->abrirConexion();
         $sql="Insert into public.tbl_clientes (
         strnombre,
         strapellido,
         strcedula,
         strdireccion,
         id_estado,
         id_municipio,
         strtelefono,
         stremail,
         id_estado_civil,
         id_sexo,
         inthijos,
         strcodigopostal,
         datefecnac,
         strobservacion) VALUES ('"
         .$this->get_strnombre()."','"
         .$this->get_strapellido()."','"
         .$this->get_strcedula()."','"
         .$this->get_strdireccion()."',"
         .$this->get_id_estado().","
         .$this->get_id_municipio().",'"
         .$this->get_strtelefono()."','"
         .$this->get_stremail()."',"
         .$this->get_id_estado_civil().","
         .$this->get_id_sexo().","
         .$this->get_inthijos().",'"
         .$this->get_strcodigopostal()."',TO_DATE('"
         .$this->get_datefecnac()."', 'DD/MM/YYYY'),'"
         .$this->get_strobservacion()."')";
         $conn->sql=$sql;
         if($conn->ejecutarSentencia()){
             $retorno=true;
         }else{
             $retorno=false;
         }
         $conn->cerrarConexion();
         return $retorno;
    }
    
    public function nextValCliente() {
               $conn = new Conexion ();
               $conn->abrirConexion ();
               $sql="SELECT last_value as maximo FROM " . clConstantesModelo::correspondencia_table . "tbl_clientes_id_cliente_seq";
               $conn->sql = $sql;
               $data = $conn->ejecutarSentencia (2);
               if ($data)
               {
                    $maximo=$data[0]['maximo'];
               }
               $conn->cerrarConexion ();
               return $maximo;
     }    
//================================FUNCION CONSULTAR===============================================


     public function SelectAll($lngcodigo_cliente=""){
         $conn= new Conexion();
         $conn->abrirConexion();
         $sql="SELECT id_cliente,
         strnombre,
         strapellido,
         strcedula,
         strdireccion,
         id_estado,
         id_municipio,
         strtelefono,
         stremail,
         id_estado_civil,
         id_sexo,
         inthijos,
         strcodigopostal,
          to_char(datefecnac,'DD/MM/YYYY') as datefecnac,
         strobservacion,
         id_representante,
         id_organizacion,
         strdocumentoconst,
         strrif,
         strmovil FROM public.tbl_clientes WHERE bolborrado=0";
         
         if($lngcodigo_cliente !=""){
             $sql .=" AND id_cliente=".$lngcodigo_cliente;
         }
         $conn->sql=$sql;
         $data = $conn->ejecutarSentencia(2);
         return $data;
    }
//======================================FUNCION ACTUALIZAR===============================================


     public function Update(){
         $conn= new Conexion();
         $conn->abrirConexion();
         $sql="UPDATE public.tbl_clientes SET
         strnombre='".$this->get_strnombre()."',
         strapellido='".$this->get_strapellido()."',
         strcedula='".$this->get_strcedula()."',
         strdireccion='".$this->get_strdireccion()."',
         id_estado=".$this->get_id_estado().",
         id_municipio=".$this->get_id_municipio().",
         strtelefono='".$this->get_strtelefono()."',
         stremail='".$this->get_stremail()."',
         id_estado_civil=".$this->get_id_estado_civil().",
         id_sexo=".$this->get_id_sexo().",
         inthijos=".$this->get_inthijos().",
         strcodigopostal='".$this->get_strcodigopostal()."',
         datefecnac=TO_DATE('".$this->get_datefecnac()."','DD/MM/YYYY'),
         strobservacion='".$this->get_strobservacion()."' WHERE id_cliente=".$this->get_id_cliente();
         $conn->sql=$sql;
         $data = $conn->ejecutarSentencia();
         return $data;
    }
 
 
 
 public function SelectAllClientesFiltro($strnombre="",$strapellido="",$strcedula=""){
         $conn= new Conexion();
         $conn->abrirConexion();
//         exit($strnombre.'--'.$strcedula);
         $sql="SELECT id_cliente,
         upper(strnombre) as strnombre, 
         upper(strapellido) as strapellido,  
         strcedula,
         strdireccion,
         id_estado,
         id_municipio,
         strtelefono,
         stremail,
         id_estado_civil,
         id_sexo,
         inthijos,
         strcodigopostal,
         datefecnac,
         strobservacion,
         id_representante,
         id_organizacion,
         strdocumentoconst,
         strrif,
         strmovil FROM public.tbl_clientes WHERE bolborrado=0";
         if($strnombre != ""){
             $sql .= " AND upper(tbl_clientes.strnombre) LIKE '%".strtoupper($strnombre)."%'";
         }
         if($strapellido != ""){
             $sql .= " AND tbl_clientes.strapellido LIKE '%".strtoupper($strapellido)."%'";
         }
         if($strcedula != ""){
             $sql .= " AND tbl_clientes.strcedula LIKE '%".strtoupper($strcedula)."%'";
         }
         $sql .= " limit ".clConstantesModelo::maximo_registro_popup;         
//         exit($sql);
         $conn->sql=$sql;
         $data = $conn->ejecutarSentencia(2);
         return $data;
    }
    
    function Delete($id_cliente){
        $conn= new Conexion();
         $conn->abrirConexion();
         $sql="UPDATE public.tbl_clientes SET
         bolborrado=1
         WHERE id_cliente=".$id_cliente;
         $conn->sql=$sql;
         $data = $conn->ejecutarSentencia();
         return $data;
    }
    
    function buscarAsistido($id)
    {
         $conn= new Conexion();
         $conn->abrirConexion();
         $sql="SELECT id_cliente,strcedula,
         strnombre,
         strapellido
         FROM public.tbl_clientes WHERE bolborrado=0";
         
         if($id !=""){
             $sql .=" AND id_cliente =".$id;
         }
//         exit($sql);
         $conn->sql=$sql;
         //exit($conn->sql);
         $data = $conn->ejecutarSentencia(2);
         return $data;
    }
    
    function buscarAsistidoCedula($cedula)
    {
         $conn= new Conexion();
         $conn->abrirConexion();
         $sql="SELECT id_cliente,strcedula,
         strnombre,
         strapellido
         FROM public.tbl_clientes WHERE bolborrado=0 AND strcedula::integer =".$cedula;
//         exit($sql);
         $conn->sql=$sql;
         //exit($conn->sql);
         $data = $conn->ejecutarSentencia(2);
         return $data;
    }    


 }
 ?>
