<?
//A��es do Formul�rio

//Recebe ID
if($_POST['id'])$cliente_fornecedor_id=$_POST['id'];
if($_GET['id'])$cliente_fornecedor_id=$_GET['id'];
if($_POST['cliente_fornecedor_id'])$cliente_fornecedor_id=$_POST['cliente_fornecedor_id'];
if($_GET['cliente_fornecedor_id'])$cliente_fornecedor_id=$_GET['cliente_fornecedor_id'];

//Cadastra Novo Usuario

if($_POST['action']=='Salvar'&&empty($cliente_fornecedor_id)){
	
	if($_POST['tipo_cadastro']=='Jur�dico'){
		$cliente_id=cadastraClienteFornecedor($_POST['j_razao_social'],$_POST['j_nome_fantasia'],$_POST['j_nome_contato'],$_POST['j_ramo_atividade'],$_POST['j_cnpj_cpf'],$_POST['j_suframa'],$_POST['j_inscricao_municipal'],$_POST['j_inscricao_estadual'],$_POST['j_email'],$_POST['j_telefone1'],$_POST['j_telefone2'],$_POST['j_fax'],$_POST['j_cep'],$_POST['j_endereco'],$_POST['j_bairro'],$_POST['j_cidade'],$_POST['j_estado'],$_POST['j_limite'],"Cliente",$_POST['tipo_cadastro'],"","","","","","","","","","","","","","","","","","","","","","",$_POST['cf_grupo_id']);
		
	}
	if($_POST['tipo_cadastro']=='F�sico'){
		$cliente_id=cadastraClienteFornecedor($_POST['f_nome_contato'],$_POST['f_nome_contato'],$_POST['f_nome_contato'],$_POST['f_ramo_atividade'],$_POST['f_cnpj_cpf'],"","","",$_POST['f_email'],$_POST['f_telefone1'],$_POST['f_telefone2'],$_POST['f_fax'],$_POST['f_cep'],$_POST['f_endereco'],$_POST['f_bairro'],$_POST['f_cidade'],$_POST['f_estado'],$_POST['f_limite'],"Cliente",$_POST['tipo_cadastro'],$_POST['f_telefone_comercial'],$_POST['f_estado_civil'],
		$_POST['f_naturalidade'],$_POST['f_rg'],$_POST['f_local_emissao'],dataBrToUsa($_POST['f_data_emissao']),$_POST['f_nacionalidade'],$_POST['f_conjugue_nome'],dataBrToUsa($_POST['f_conjugue_data_nascimento']),$_POST['f_conjugue_ramo_atividade'],$_POST['f_conjugue_cpf'],		$_POST['f_conjugue_rg'],$_POST['f_conjugue_local_emissao'],dataBrToUsa($_POST['f_conjugue_data_emissao']),$_POST['f_conjugue_telefone'],$_POST['f_conjugue_email'],$_POST['f_conjugue_naturalidade'],$_POST['f_conjugue_nacionalidade'],
		$_POST['f_endereco_comercial_conjugue'],$_POST['f_telefone_comercial_conjugue'],dataBrToUsa($_POST['f_nascimento']),$_POST['f_endereco_comercial'],$_POST['cf_grupo_id'],$_POST['sexo']);
	}
	//salvaUsuarioHistorico("Formul�rio - Cliente","Salvou um Cliente Novo");
}
//Altera Usuario
if($_POST['action']=='Salvar'&&isset($cliente_fornecedor_id)){
	
	if($_POST['tipo_cadastro']=='Jur�dico'){
		$cliente_id=alteraClienteFornecedor($cliente_fornecedor_id,$_POST['j_razao_social'],$_POST['j_nome_fantasia'],$_POST['j_nome_contato'],$_POST['j_ramo_atividade'],$_POST['j_cnpj_cpf'],$_POST['j_suframa'],$_POST['j_inscricao_municipal'],$_POST['j_inscricao_estadual'],$_POST['j_email'],$_POST['j_telefone1'],$_POST['j_telefone2'],$_POST['j_fax'],$_POST['j_cep'],$_POST['j_endereco'],$_POST['j_bairro'],$_POST['j_cidade'],$_POST['j_estado'],$_POST['j_limite'],"Cliente",$_POST['tipo_cadastro'],"","","","","","","","","","","","","","","","","","","","","","",$_POST['cf_grupo_id']);
	}
	if($_POST['tipo_cadastro']=='F�sico'){
		
		$cliente_id=alteraClienteFornecedor($cliente_fornecedor_id,$_POST['f_nome_contato'],$_POST['f_nome_contato'],$_POST['f_nome_contato'],$_POST['f_ramo_atividade'],$_POST['f_cnpj_cpf'],"","","",$_POST['f_email'],$_POST['f_telefone1'],$_POST['f_telefone2'],$_POST['f_fax'],$_POST['f_cep'],$_POST['f_endereco'],$_POST['f_bairro'],$_POST['f_cidade'],$_POST['f_estado'],$_POST['f_limite'],"Cliente",$_POST['tipo_cadastro'],$_POST['f_telefone_comercial'],$_POST['f_estado_civil'],
		$_POST['f_naturalidade'],$_POST['f_rg'],$_POST['f_local_emissao'],dataBrToUsa($_POST['f_data_emissao']),$_POST['f_nacionalidade'],$_POST['f_conjugue_nome'],dataBrToUsa($_POST['f_conjugue_data_nascimento']),$_POST['f_conjugue_ramo_atividade'],$_POST['f_conjugue_cpf'],		$_POST['f_conjugue_rg'],$_POST['f_conjugue_local_emissao'],dataBrToUsa($_POST['f_conjugue_data_emissao']),$_POST['f_conjugue_telefone'],$_POST['f_conjugue_email'],$_POST['f_conjugue_naturalidade'],$_POST['f_conjugue_nacionalidade'],
		$_POST['f_endereco_comercial_conjugue'],$_POST['f_telefone_comercial_conjugue'],dataBrToUsa($_POST['f_nascimento']),$_POST['f_endereco_comercial'],$_POST['cf_grupo_id'],$_POST['sexo']);
	}
	//salvaUsuarioHistorico("Formul�rio - Cliente","Alterou o ID $cliente_fornecedor_id");
}
//Exclui Usuario
if($_POST['action']=='Excluir'&&isset($cliente_fornecedor_id)){
	$exclui=excluiClienteFornecedor($cliente_fornecedor_id);
	if($exclui==0){
		alert('n�o pode excluir');
	}else{
		ExcluirTodosDocumentos($_POST);
	}
}
//Pega informa��es
if($cliente_fornecedor_id>0){
	$cliente_fornecedor=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='".$cliente_fornecedor_id."' LIMIT 1")); 
	//salvaUsuarioHistorico("Formul�rio - Cliente","Excluiu o ID $cliente_fornecedor_id");
}

//-----------------------------------------------------
if($_POST['actionGrupo']=="Salvar"){
	
	manipulaGrupo($_POST);
	
}
if($_POST['actionGrupo']=="Excluir"){
	//alert("oi");
	ExcluirGrupo($_POST);
	
	
	
}
//alert($_POST['action2']);
if($_POST['action2']=="ExcluirFoto"){
	
	ExcluirFoto($_POST);
	
}

if($_POST['action2']=="adicionarDocumento"){
	$id=adicionarDocumento($_POST);
	echo "<script>nl= top.document.getElementById('dados_documentos').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length-1;top.document.getElementById('dados_documentos').getElementsByTagName('tbody')[0].getElementsByTagName('tr')[nl].setAttribute('id','$id')</script>";
}

if($_POST['action2']=="excluirDocumento"){
	
	excluirDocumento($_POST);
}

if($_GET['action2']=="downloadDocumento"){
	
	DowloadDocumento($_POST['id_documento']);
	
}

if($_GET['grupo_id']>0){
	//alert("oi");
	$grupo = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor_grupo WHERE id='".$_GET['grupo_id']."'"));
}

?>