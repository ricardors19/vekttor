<?
//------------------------------------------------------------------
if($_GET['id']){$id=$_GET['id'];}
if($_POST['id']){$id=$_POST['id'];}

if(!empty($_GET['venda_id'])){
	$venda=$_GET['venda_id'];
}else
if(!empty($_POST['venda_id'])){
	$venda=$_POST['venda_id'];
}

//echo "Acao=".$_POST['acao'];

$verifica = mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_vendas WHERE id='$venda'"));
if($_GET['tela_id']!='512'){
if(empty($verifica)){
	$venda_id=cadastraVenda($_GET['cliente_id'],$_GET['almoxarifado_id'],$vkt_id);
	echo "<script>location.href='?tela_id=513&pagina=1&limitador=30&cliente_id=".$_GET['cliente_id']."&venda_id=$venda_id'</script>";	
}else{
	$venda_id=$verifica->id;
}
}

if($_POST["acao"]=='Finalizar'){
	finalizaVenda($venda_id);
}

if($_GET['status']=='cancelado'){
	cancelavenda($_GET['venda_id']);
}

$cliente_id=$_GET['cliente_id'];
$cliente = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$cliente_id."'"));
//echo $t;
$venda = @mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_vendas WHERE id=".$venda_id));

//$num_produtos=  mysql_num_rows(mysql_query("SELECT * FROM estoque_vendas_item WHERE pedido_id='$venda_id'"));
//echo $venda;


if(!empty($_GET["total"])){
	$total = $_GET["total"];
	$almoxarifado_id = $_GET["almoxarifado_id"];
	
	$config = mysql_fetch_object(mysql_query(" SELECT * FROM estoque_config WHERE vkt_id = '$vkt_id' AND almoxarifado_id = '$almoxarifado_id' "));
	
}

if($_POST["action"] == "Enviar Financeiro"){
	Pagamento($_POST);
}
?>