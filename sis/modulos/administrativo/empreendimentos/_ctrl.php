<?
//A��es do Formul�rio

//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];



//Cadastra Registro
if($_POST['action']=='Salvar'&&empty($id)){
	//cadastraEmpreendimento($nome,$tipo,$orcamento,$inicio,$fim,$obs)
	//$cadastra=cadastraEmpreendimento($_POST['nome'],$_POST['tipo'],$_POST['orcamento'],$_POST['inicio'],$_POST['fim'],$_POST['obs']);
	$cadastra=cadastraEmpreendimento($_POST,$vkt_id);
}
//Altera Registro
if($_POST['action']=='Salvar'&&isset($id)){
	//echo "Tipo: ".$_POST['tipo']."<br>";
	$altera=alteraEmpreendimento($id,$_POST);
}
//Exclui Usuario
if($_POST['action']=='Excluir'&&isset($id)){
	
	$disponibilidades = @mysql_result(mysql_query("SELECT count(*) FROM disponibilidade WHERE empreendimento_id='$id'"),0,0);
	$negociacoes 	  = @mysql_result(mysql_query("SELECT count(*) FROM negociacao WHERE empreendimento_id='$id'"),0,0);
	//alert($disponibilidades);
	//alert($negociacoes);
	if($disponibilidades >0 || $negociacoes>0){
		if($negociacoes>0){
			$erro[] = "Existe uma negocia��o para este Empreendimento";
		}
		if($disponibilidades>0){
			$erro[] = "Existe uma disponibilidade para este Empreendimento";
		}
		
		echo "<script>alert('".implode('\n',$erro)."')</script>";
	}
	
	if($disponibilidades ==0 && $negociacoes==0){
		$exclui=excluiEmpreendimento($id);
	}
}
//Pega informa��es
if($id>0){
	$r=mysql_fetch_object(mysql_query("SELECT * FROM empreendimento WHERE id='".$id."' LIMIT 1"));
	salvaUsuarioHistorico("Formul�rio - Empreendimento",'Exibe','empreendimento',$id);
}

?>