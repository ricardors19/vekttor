<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>

<script>
	$(document).ready(function(){
		$("#dados tr:nth-child(2n+1)").addClass('al');
	})
	function checa_cpf(t){
		
	ultima = t.value.substr(13,1);
	
	//alert(id);
		if(ultima!='_' && t.value.length=='14' ){
			window.open('modulos/escolar/professor/form.php?cnpj_cpf='+t.value,'carregador')	
		}
	}
	function mudaStatus(status){
		location.href='?tela_id=294&status='+status.value;
	}
</script>
<div id="some">�</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
<a href="?tela_id=294" class="navegacao_ativo">
<span></span>Mensagens Privadas
</a>
</div>
<div id="barra_info">
    <strong>Status:</strong> <select name="status" onchange="mudaStatus(this)">
    	<option value="1" <?php if($_GET['status']==1){echo 'selected=selected';}?>>RESPONDIDAS</option>
        <option value="2" <?php if($_GET['status']==2){echo 'selected=selected';}?>>NAO RESPONDIDAS(NAO LIDAS)</option>
        
    </select>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
   <td width="40">Codigo</td>
   <td width="200">Para</td>
   <td width="150">Aula</td>
   <td width="80">Mat�ria</td>
   <td width="120">Data</td>
   <td width="120">Status</td>
   <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso � Necess�rio para a cria��o o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	<?
	if($aluno_id>0){	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND u.nome like '%{$_GET[busca]}%'";
	}
	
	
	// necessario para paginacao
    $registros= @mysql_result(mysql_query($t="SELECT p.*,p.id as id,c.*,u.* FROM escolar_professor p 
						INNER JOIN cliente_fornecedor c ON p.cliente_fornecedor_id =c.id
						INNER JOIN usuario u ON p.usuario_id =u.id
						WHERE p.vkt_id='$vkt_id' $busca_add"),0,0);
   //echo $t;
	if(isset($_GET['status'])){
		$st=$_GET['status'];
	}else{
		$st="1";
	}
	
	// colocar a funcao da pagina��o no limite
	$q= mysql_query($t="SELECT *,mp.id as mpid,mp.status as st FROM escolar_mensagens_privadas mp,
	cliente_fornecedor cf,
	escolar_aula ea,
	escolar_materias em	
	WHERE 
	em.id=mp.materia_id AND 
	mp.aluno_id=$aluno_id AND
	mp.professor_id=cf.id AND
	mp.aula_id=ea.id
	AND mp.status=$st
	AND mp.mensagem_origem_id='0'
	AND mp.vkt_id='$vkt_id' 
	$busca_add ORDER BY mp.id DESC ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}

	?>
<tr <?=$sel?> onclick="location.href='?tela_id=298&id=<?php echo $r->mpid?>'">
   <td width="40"><?=$r->mpid?></td>
   <td width="200"><?=$r->razao_social?></td>
   <td width="150"><?=$r->descricao?></td>
   <td width="80"><?=$r->nome?></td>
   <td width="120"><?=DataUsaToBr($r->data_envio)?></td>
   <?php if($r->st==2){$status='Aguardando Resposta';}else if($r->st==1){$status='Respondida';}?>
   <td width="120"><?=$status?></td>
   <td></td>
</tr>
<?
	}
	//}
	?>	
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">&nbsp;</td>
           <td width="230"><a>Total: <?=$total?></a></td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
		   <td width="110">&nbsp;</td>
           <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	Registros 
    <?
	if($_GET[limitador]<1){
		$limitador= 30;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador]);
	}//$aluno_id
	?>
    </div>
</div>
