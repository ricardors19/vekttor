<?
// fun�oes do modulo empreendimento
//include("../_functions.php");
//include("../_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});

$("#clickbusca").live("click",function(e) {
	busca=$("#busca").val();
	location.href="?tela_id=<?=$_GET['tela_id']?>&busca="+busca;
});

$("#grupo_id").live("change",function(){
		var grupo_id = $(this).val();
		//alert(grupo_id);
		$("#botoes").text("");
		if(grupo_id==""){
			location.href='?tela_id=<?=$_GET['tela_id']?>';
		}else if(grupo_id!="novo"){
			
			$("#botoes").append("<input type='button' value='filtrar' id='filtrar'>");
		}else if(grupo_id=="novo"){
			window.open('modulos/ordem_servico/servicos/form_grupo.php','carregador');
		}
	});
	$("#edt_grupo").live("click",function(){
		var grupo_id = $("#grupo_id").val();
		//alert(grupo_id);
		window.open('modulos/ordem_servico/servicos/form_grupo.php?grupo_id='+grupo_id,'carregador');
	});
	$("#filtrar").live("click",function(){
		var grupo_id = $("#grupo_id").val();
		location.href='?tela_id=<?=$_GET['tela_id']?>&grupo_id='+grupo_id+'&filtro=filtrar';
	});
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">�</div>
<a href="" class='s1'>
  Sistema
</a>
<a href="" class='s1'>
  	OS
</a>
<a href="" class='s1'>
  	Cliente X Servi�o X Tempo
</a>
<form class='form_busca' action="" method="get">
   	 <a id="clickbusca"></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" id="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>

<div id="barra_info">
	  <select name="grupo_id" id="grupo_id" style="float:left;margin-top:3px;">
    	<option value="">Grupos</option>
		<?php
			$grupos = mysql_query("SELECT * FROM servico_grupo WHERE vkt_id='$vkt_id'");
			while($grupo = mysql_fetch_object($grupos)){
		?>
        	<option value="<?=$grupo->id?>" <?php if($grupo->id==$_GET['grupo_id']){ echo "selected='selected'";}?>><?=$grupo->nome?></option>
        <?php
			}
		?>
    </select>
    <div id="botoes" style="float:left;">
    	<?php
			if($_GET['grupo_id']>0){
				echo "<input type='button' value='filtrar' id='filtrar'>";
			}
		?>
    </div>
</div>
<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
	
		location.href='?tela_id=395&id='+id;
	});
});
</script>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="60">Codigo</td>
          <td width="300">Descricao</td>
          <td width="70">Unidade</td>
          <td width="80">Valor Normal</td>
          <td width="60">Execu&ccedil;&atilde;o</td>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso � Necess�rio para a cria�ao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
		$fim='';
		if(!empty($_GET['busca'])){
			$fim.=" AND nome LIKE '%".$_GET['busca']."%'";	
		}
		if(!empty($_GET['grupo_id'])){
			$fim.=" AND grupo_id='".$_GET['grupo_id']."'";	
		}
		// necessario para paginacao
   		$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM servico WHERE vkt_id='$vkt_id' $fim"),0,0);
		
		$sql = mysql_query($t="SELECT *	FROM servico WHERE vkt_id='$vkt_id' $fim ORDER BY nome  LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
		//echo $t;				
		echo mysql_error();	
				while($r=mysql_fetch_object($sql)){
		
	?>      
    	<tr <?=$sel?> id="<?=$r->id?>">
          <td width="60"><?=$r->id?></td>
          <td width="300"><?=substr($r->nome,0,100);?></td>
          <td width="70"><?=$r->und?></td>
          <td width="80"><?=moedaUsaToBr($r->valor_normal)?></td>
          <td width="60"><?=$r->tempo_execucao?></td>
          <td></td>
        </tr>
<?php
				}
?>
    	
    </tbody>
</table>
<script>


</script>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        	<td width="20"></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td width="50"><?=$q_total->horas?></td>
          <td width="580"><?=$q_total->hora_final?></td>
          <td width="80">&nbsp;</td>
          <td ></td>
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
