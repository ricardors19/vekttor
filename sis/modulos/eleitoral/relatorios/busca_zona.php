<?

/*

separacao por | campo

e  linha separado por qubra de linha ou para os leigos "\n"

@r0 = M�rio Fl�vios JR

@r1 = 29/01/1983

@r2 = 10/10/2010



*/



include("../../../_config.php");

// fun��es base do sistema

include("../../../_functions_base.php");

// fun��es do modulo empreendimento



//$cpf_cnpj =  str_replace=



$q=mysql_query("SELECT * FROM eleitoral_zonas WHERE (zona like '%$_GET[busca_auto_complete]%') ORDER BY zona LIMIT 15");

$i=0;

while($r= mysql_fetch_object($q)){

	echo urlencode("$r->zona|$r->secao|$r->local|$r->id\n");

	$i++;

}

if($i==0){

	echo urlencode("N�o Encontrado, Cadastre Zonas|0|0\n");

}

?> 