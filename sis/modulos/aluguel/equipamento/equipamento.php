<?
// fun�oes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});

</script>

<div id='conteudo'>
<div id='navegacao'>
<div id='some'>�</div>
<a href="?" class='s2'>
  	Aluguel
</a>
<a href="#" class='navegacao_ativo'>
<span></span>Equipamento
</a>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>

<div id="barra_info">
<a href="modulos/aluguel/equipamento/form.php" target="carregador" class="mais"></a>
</div>
<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		
		window.open('modulos/aluguel/equipamento/form.php?id='+id,'carregador');
	});
});
</script>
<script>
$(document).ready(function(){
		$("tr:odd").addClass('al');
});
</script>
<script>
$("#remove_todos_itens").live("click",function(){
	
	var id_equipamento=$("#id").val();
	var qtd_itens_disponiveis = $("#item_disponivel").html();
	var qtd_itens = $("#total_item").html();
	
	$("table tbody tr:contains('Dispon�vel')").remove();
	$("#total_item").html(qtd_itens-qtd_itens_disponiveis);
	$('#item_disponivel').html('0');
	//$("#qtd_itens").val('1');
	window.open('modulos/aluguel/equipamento/remove_item.php?id='+id_equipamento+'&acao=1','carregador');
});

$("#excluir_item").live("click",function(){
	//alert("oi");
	var status_item = $(this).parent().parent().find('.status_item').val();
	var id_item = $(this).parent().parent().find('.id_item_equipamento').val();
	var qtd_item = ($("#total_item").text())*1;
	var qtd_disponivel=$('#item_disponivel').html()*1;	

	//verifica se o item est� dispon�vel
	if(status_item==1){	
		//alert("oi");
		$("#total_item").html(qtd_item-1);
		$('#item_disponivel').html((qtd_disponivel-1));
		$(this).parent().parent().remove();
		window.open('modulos/aluguel/equipamento/remove_item.php?id='+id_item+'&qtd_item='+qtd_item+'&acao=0','carregador');
	}else{
		alert("Item nao pode ser removido. O mesmo est� locado");
	}

});

$('#identificar').live("click",function(){
	IdentificarItens();
});
$('#qtd_itens').live("keyup",function(){
	var marcado=$('#identificar').is(":checked");
	var qtd_input=($(".col").length)*1;
	var itens =$("#total_item").html()*1;
	var qtd_disponivel=$('#item_disponivel').html()*1;
	if(marcado==true){
		$("#total_item").html((itens-qtd_input));
		$('#item_disponivel').html((qtd_disponivel-qtd_input));
		IdentificarItens();
	}
});

function IdentificarItens(){
	//alert($('#qtd_itens').val());
	var qtd=$('#qtd_itens').val()*1;
	var qtd_disponivel=$('#item_disponivel').html()*1;
	var marcado=$('#identificar').is(":checked");
	var itens =$("#total_item").html()*1;
		 
	if(marcado==true){
		
		$(".col").remove();
		for(var i=0;i<qtd;i++){
			if($('#tbody tr:first-child').length>0){
				$("<tr class='col'><td width='350'><input type='text' class='item_q' name='item_q[]' style='width:300px;' ></td><td width='70'>Dispon�vel</td><td><img src='../fontes/img/menos.png' id='excluir_item'></td></tr>").insertBefore("#tbody tr:first-child");
			}else{
				$("#tbody").append("<tr class='col'><td width='350'><input type='text' class='item_q' name='item_q[]' style='width:300px;' ></td><td width='70'>Dispon�vel</td><td><img src='../fontes/img/menos.png' id='excluir_item'></td></tr>");
			}
		}//for
		$("#total_item").html((itens+qtd));
		$('#item_disponivel').html((qtd_disponivel+qtd));
	}//if
	else{
		$(".col").remove();
		$("#total_item").html((itens-qtd));
		$('#item_disponivel').html((qtd_disponivel-qtd));
	}//
}

$("#Salvar").live('click',function(){
	var qtd_cols = ($("#tbody tr").length)*1;
	var qtd_itens=$('#qtd_itens').val()*1;
	if(qtd_cols<=0&&(qtd_itens==''||qtd_itens<0)){
		alert("Adicione Pelo menos um item");
		return false;
	}
});

$("#Excluir").live('click',function(){
	
	var qtd_itens=$('#total_item').html()*1;
	var qtd_disponivel=$('#item_disponivel').html()*1;
	
	if(qtd_itens>qtd_disponivel){
		alert("Equipamento nao pode ser exclu�do. H� intens locados para este.");
		return false;
	}

});
</script>
<!-- -->
<table cellpadding="0" cellspacing="0" width="100%"  >
<thead>
    	<tr>
          <td width="60">C�digo</td>
          <td width="340">Descri&ccedil;&atilde;o</td>
          <td width="80">Fabricante</td>
          <td width="110">Valor Aluguel(R$)</td>
          <td width="80">Periodo(Dias)</td>
          <td width="80">N&ordm; de Itens</td>
          <td width="100">Itens Dispon�veis</td>
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
		$fim.=" AND descricao LIKE '%".$_GET['busca']."%'";	
	}
	// necessario para paginacao
    $registros= mysql_result(mysql_query("SELECT count(*) FROM aluguel_equipamentos WHERE vkt_id = '$vkt_id' $fim"),0,0);
	$sql=mysql_query($t="SELECT * FROM aluguel_equipamentos WHERE vkt_id = '$vkt_id' $fim ORDER BY descricao LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	while($e=mysql_fetch_object($sql)){	
			$total++;	
			$qtd_itens=mysql_fetch_object(mysql_query($t="SELECT COUNT(*) as qtd FROM aluguel_equipamentos_itens WHERE equipamento_id='$e->id' AND vkt_id='$vkt_id'"));
				/*$equipamento_itens_locados = mysql_fetch_object(mysql_query($t="SELECT 
														COUNT(*) as qtd 
													  FROM 
													  	aluguel_equipamentos ae,
														aluguel_equipamentos_itens aei,
														aluguel_locacao al,
														aluguel_locacao_itens ali														 
													  WHERE
													  	ae.id=aei.equipamento_id AND
														al.id=ali.locacao_id AND
														aei.id=ali.item_equipamento_id AND 
													    ae.id='$e->id' AND 
														ae.vkt_id='$vkt_id'"));*/
				$itens_disponiveis=mysql_fetch_object(mysql_query($t="SELECT COUNT(*) as qtd FROM aluguel_equipamentos_itens WHERE equipamento_id='$e->id' AND status='1' AND vkt_id='$vkt_id'"));
	?>      
    <tr id="<?=$e->id;?>">
        <td width="60"><?=$e->id;?></td>
        <td width="340"><?=$e->descricao;?></td>
        <td width="80"><?=substr($e->fabricante,0,10);?></td>
        <td width="110"><?=MoedaUsaToBr($e->vlr_aluguel);?></td>
        <td width="80"><?=$e->periodo;?></td>
        <td width="80"><?=$qtd_itens->qtd?></td>          
        <td width="100"><?=$itens_disponiveis->qtd?></td>
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
        <tr>
          <td width="60"><a>Total: <?=$total?></a></td>
          <td width="340"></td>
          <td width="80"></td>
          <td width="110"></td>
          <td width="80"></td>
          <td width="80"></td>
          <td width="100"></td>
          <td></td>
        </tr>
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

