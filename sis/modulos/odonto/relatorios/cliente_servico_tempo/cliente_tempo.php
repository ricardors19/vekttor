<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

//include("_functions.php");
//include("_ctrl.php");
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
	$("#grupo_id").live("change",function(){
		var grupo_id = $(this).val();
		//alert(grupo_id);
		if(grupo_id!="novo"){
			$("#botoes").text("");
			$("#botoes").append("<input type='button' value='Editar' id='edt_grupo'><input type='button' value='filtrar' id='filtrar'>");
		}else if(grupo_id=="novo"){
			window.open('modulos/administrativo/clientes/form_grupo.php','carregador');
		}else{
			$("#botoes").text("");
		}
	});
	$("#edt_grupo").live("click",function(){
		var grupo_id = $("#grupo_id").val();
		//alert(grupo_id);
		window.open('modulos/administrativo/clientes/form_grupo.php?grupo_id='+grupo_id,'carregador');
	});
	$("#filtrar").live("click",function(){
		var grupo_id = $("#grupo_id").val();
		location.href='?tela_id=15&grupo_id='+grupo_id+'&filtro=filtrar';
	});
	/*$("#botoes button").on("click",function(event){
			window.open('modulos/administrativo/clientes/form_exportar.php','carregador');	
	});*/
	$("#exportar").live("click",function(event){
			//alert('ater');
			window.open('modulos/administrativo/clientes/form_exportar.php','carregador');	
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
<div id='some'>�</div>
<a href="./" class='s1'>
  	Sistema 
</a>
<a href="./" class='s2'>
    Odonto 
</a>
<a href="?tela_id=15" class="navegacao_ativo">
<span></span>    Clientes X Servi�os X Tempo 
</a>
</div>
<div id="barra_info">
<?php
	$servico_id = $_GET['id'];
	$servico = @mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE id=$servico_id"));
	echo "<strong>Servi�o:</strong>" .$servico->nome;
?>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">Codigo</td>
            <td width="230"><?=linkOrdem("Nome","nome_fantasia",1)?></td>
          	<td width="130"><?=linkOrdem("CNPJ/CPF","cnpj_cpf",0)?></td>
          	         	
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso � Necess�rio para a cria��o o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND nome_fantasia like '%{$_GET[busca]}%'";
	}
	
	$filtro = '';
	
	if($_GET['filtro']=="filtrar"&&$_GET['grupo_id']>0){
		$filtro = "AND grupo_id='".$_GET['grupo_id']."'";
	}
	
	// necessario para paginacao
    $registros= mysql_result(mysql_query("SELECT count(*) FROM cliente_fornecedor WHERE tipo='Cliente' AND cliente_vekttor_id ='{$_SESSION['usuario']->cliente_vekttor_id}' $busca_add ORDER BY nome_fantasia"),0,0);
    
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="nome_fantasia";
	}
	
	// colocar a funcao da pagina��o no limite
	$q= mysql_query($t="SELECT 
							* 
						FROM 
							cliente_fornecedor cf,
							odontologo_atendimentos oa
						WHERE 
							cf.id = oa.cliente_fornecedor_id AND
							cf.tipo='Cliente' AND 
							cliente_vekttor_id ='{$_SESSION['usuario']->cliente_vekttor_id}' 
							$busca_add 
							$filtro 
							ORDER BY ".$ordem." ".$_GET['ordem_tipo']." 
							LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		
		$ultima_vez_executado_cliente = @mysql_fetch_object(mysql_query($t="SELECT 
																			DATEDIFF(CURRENT_DATE(),data_cadastro) as diferenca
																		FROM
																			odontologo_atendimento_item
																		WHERE
																			servico_id                     = $servico_id AND
																			cliente_fornecedor_id     = $r->cliente_fornecedor_id AND
																			status                           = '2' AND 
																			vkt_id                           = $vkt_id
																			ORDER BY data_cadastro DESC LIMIT 1	
																			"));
																			//echo $t."<br>";
																			//echo mysql_error();
		
	?>
<tr <?=$sel?>onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">
<td width="50" align="right"><?=str_pad($r->id,5,"0",STR_PAD_LEFT)?></td>
<td width="230"><?=$r->nome_fantasia?></td>
<td width="130"><?=$r->cnpj_cpf?></td>
<td>
	<?php
		if(!$ultima_vez_executado_cliente>0){
			echo "Nunca Executou este servi�o";
		}else{
			echo "Executou h� $ultima_vez_executado_cliente->diferenca dias";
		}
	?>
</td>
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
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value+'&id=<?=$_GET['id']?>'">
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
