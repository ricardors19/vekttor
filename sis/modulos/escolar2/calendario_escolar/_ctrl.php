<?
//A��es do Formul�rio
//Recebe ID
//acao enviada a partir de atendimento do vendedor, quando uma intera�ao gera uma venda
if($_POST['action'] == 'Salvar'){
			if($_POST['id'] > 0)
				updateEvento($_POST);
			else
				cadastraEvento($_POST);		
}
//Altera Usuario
if($_POST['action']=='Excluir'){
			ExcluiEvento($_POST['id']);
}

if($_POST['action'] == 'Salvar Agenda'){
	if($_POST['id'] > 0)
			updateAgenda($_POST);
	else
			cadastraAgenda($_POST);
}

if($_GET['editAgenda'] > 0){
		$id = $_GET['editAgenda'];
			$AgendaNome = mysql_fetch_object(mysql_query(" SELECT * FROM agenda WHERE id = '$id'"));
}

if($_GET['id'] > 0){
		$id = $_GET['id'];
		$agendamento = mysql_fetch_object(mysql_query(" SELECT * FROM agenda_agendamento WHERE vkt_id = '$vkt_id' AND id = '$id'"));
					$cliente = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$agendamento->cliente_id'"));
					$agenda = mysql_fetch_object(mysql_query(" SELECT * FROM agenda WHERE id = '$agendamento->agenda_id'"));
		/* Data Hora para Inicio de Cada Evento formata�ao*/
		$data_hora_inicio = explode(" ",$agendamento->data_hora_inicio);
		$data_inicio = $data_hora_inicio[0];
		$hora_inicio = $data_hora_inicio[1];
		/* Data Hora para fim de cada Evento formata��o */
		$data_hora_fim = explode(" ",$agendamento->data_hora_fim);
		$data_fim = $data_hora_fim[0];
		$hora_fim = $data_hora_fim[1];
		
}

if(!empty($_GET['dataInicial'])){ // 4/10/2012

		if(!empty($_GET['horaInicial'])){
				
				$hora_inicial = explode(":",$_GET['horaInicial']);
						
						if(strlen($hora_inicial[1]) < 2)
							$minutos = $hora_inicial[1]."0";
					    		else
									$minutos = $hora_inicial[1];
						/*-hora inicial-*/
						if(strlen($hora_inicial[0]) < 2)
							$hora = "0".$hora_inicial[0];
								else
								 	$hora = $hora_inicial[0];
				/*-Hora inicial configurada-*/
				$hora_inicial = $hora.":".$minutos;
								
		} /*-Fim de IF hora Inicial -*/
		
		if(!empty($_GET['horaFinal'])){
					$hora_final = explode(":",$_GET['horaFinal']);
						if(strlen($hora_final[1]) < 2)
							$minutos_final = str_pad($hora_final[1], 2 , "0");
								else
									$minutos_final = $hora_final[1];
						/*-hora final-*/
						if(strlen($hora_final[0]) < 2)
							$hora_f = "0".$hora_final[0];
								else
									$hora_f = $hora_final[0];
				/*- Hora final configurada -*/
					$hora_final = $hora_f.":".$minutos_final;
		} /*-Fim de IF hora Final-*/
		
		$dataEvento = $_GET['dataInicial'];
		
		if(!empty($_GET["agenda_id"]))
			$agenda_id = $_GET["agenda_id"];
		
		
				
}
if(!empty($_GET['dataFinal'])){
		
		$dataFinal = $_GET['dataFinal'];
}
?>