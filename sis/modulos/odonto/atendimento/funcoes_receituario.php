<?php
include("../../../_config.php");
include("../../../_functions_base.php");
	
$acao              = $_POST['acao'];
$texto_receituario = $_POST['texto_receituario'];
$data_receituario  = $_POST['data_receituario'];
$atendimento_id    = $_POST['atendimento_id'];
$cliente_id        = $_POST['cliente_id'];

if($acao=='add'){	
	mysql_query($t="INSERT INTO odontologo_receituario SET vkt_id='$vkt_id',cliente_fornecedor_id='$cliente_id',odontologo_atendimento_id='$atendimento_id',txt='".utf8_decode($texto_receituario)."',data='".DataBrToUsa($data_receituario)."'");
	echo mysql_insert_id();
}else{
	$id = $_POST['id'];
	mysql_query($t="DELETE FROM odontologo_receituario WHERE id=$id");
}
?>