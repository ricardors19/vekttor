<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
$("div").on('click','#importar',function(){
	window.open('modulos/escolar/Inadimplentes/form_importar.php','carregador');
	//teste({a: [1 ,2 ,3, 4, 5]}, 'b', 'c', {hey: 'you', got: 'that?'});
});

</script>
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id="some">�</div>
<a href="#" class='s1'>SISTEMA</a>
        <a href="./" class='s2'>
    Escolar 
</a>
<a href="?tela_id=219" class="navegacao_ativo">
<span></span> Inadimplentes
</a>
</div>
<div id="barra_info">
	 
    <a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
    <button style="float:left; margin-top:3px;" id="importar" title="Importar Alunos Inadimplentes" data-placement="right">Importar</button>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">Codigo</td>
            <td width="100">CPF</td>
            <td width="230">Nome</td>
          	<td width="90"><?=linkOrdem("Telefone","Telefone",0)?></td>
          	<td><?=linkOrdem("Email","Email",0)?></td>
       	</tr>
    </thead>
</table>
<div id='dados'> 
<script>resize()</script><!-- Isso � Necess�rio para a cria��o o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = " AND cf.razao_social like '%{$_GET[busca]}%'";
	}
	// necessario para paginacao
    $registros= mysql_result(mysql_query($t="SELECT count(*) FROM  escolar_alunos_inadimplentes WHERE vkt_id='$vkt_id' "),0,0);
   //echo $t;
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		//$ordem="codigo_interno";
	}
	// colocar a funcao da pagina��o no limite
	/*$q= mysql_query($t="SELECT a.*,ab.*, a.id as aluno_id FROM escolar_alunos a, escolar_alunos_inadimplentes ab 
	WHERE a.responsavel_id=ab.cliente_fornecedor_id_responsavel AND ab.vkt_id='$vkt_id' $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));*/
	//echo $t;
	$q= mysql_query($t="SELECT cf.*,ab.*, cf.id as responsavel_id FROM  escolar_alunos_inadimplentes ab, cliente_fornecedor cf 
	WHERE cf.id=ab.cliente_fornecedor_id_responsavel AND ab.vkt_id='$vkt_id' $busca_add LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}

	?>
<tr <?=$sel?>onclick="window.open('<?=$caminho?>form.php?id=<?=$r->responsavel_id?>','carregador')">
<td width="50"><?=str_pad($r->responsavel_id,5,"0",STR_PAD_LEFT)?></td>
<td width="100"><?=$r->cnpj_cpf?></td>
<td width="230"><?=$r->razao_social?></td>
<td width="90"><?=$r->telefone1?></td>
<td><?=$r->email?></td>
</tr>
<?
	}
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
	<?=$registros?> Registros 
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
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>
