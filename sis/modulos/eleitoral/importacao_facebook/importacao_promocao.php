<?php
	//$host		= 'cpmy0109.servidorwebfacil.com';
	//$login_bd	= 'bdamz';
	//$senha_bd	= '49sglw73re';
	//$bd			= 'bdamz_bdamz';
	//mysql_connect($host,$login_bd,$senha_bd);
	//mysql_select_db($bd);
	include("../../../_config.php");
	// fun��es base do sistema
	include("../../../_functions_base.php");
	
	$file = fopen("arquivos/promocao_natal2012.csv",'r');
	
	while(!feof($file)){
		$linha = fgets($file);
		
		$dados = explode(";",$linha);
		echo $dados[1]."::".$dados[2]."::".$dados[4]."::".$dados[6]."::".$dados[14]."::".$dados[17]."::".$dados[38]."::".$dados[39]."::".$dados[40]."::".$dados[41]."::".$dados[42]."::".$dados[43]."<br>";
		$nome=str_replace("\"","",$dados[1]);
		$email=str_replace("\"","",$dados[2]);
		//$data_nascimento=str_replace("\"","",$dados[4]);
		$telefone1=str_replace("\"","",$dados[3]);
		$telefone1 = "(92)".substr($telefone1,0,4)."-".substr($telefone1,4,4);
		/*$sexo=str_replace("\"","",$dados[17]);
		if($sexo=="m"){
			$sexo='masculino';
		}else{
			$sexo='feminino';
		}*/
		$cep=str_replace("\"","",$dados[4]);
		$rua=str_replace("\"","",$dados[5]);
		$bairro=str_replace("\"","",$dados[7]);
		$numero=str_replace("\"","",$dados[6]);
		$referencia = str_replace("\"","",$dados[8]);
		$cidade=str_replace("\"","",$dados[9]);
		$estado=str_replace("\"","",$dados[10]);
		$obs=str_replace("\"","",$dados[11]);
		
		
		
		$endereco = $rua." - ".$referencia;
		
		//verifica se existe email
		$existe_email = mysql_fetch_object(mysql_query($t="SELECT * FROM eleitoral_eleitores WHERE email='$email'"));
		//echo $t."<br>";
		if(!($existe_email->id>0)){
			mysql_query($t="INSERT INTO eleitoral_eleitores SET vkt_id='$vkt_id',nome='$nome',email='$email',data_nascimento='$data_nascimento',telefone1='$telefone1',sexo='$sexo',cep='$cep',endereco='$endereco', bairro='$bairro', cidade='$cidade', descricao_bens='$obs', grupo_social_id='29', origem='Programa Josue Neto'");
		//echo $t."<br>";
		}
		
		
	}
?>