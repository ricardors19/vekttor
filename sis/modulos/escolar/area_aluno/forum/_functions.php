<?php

/*function selecionaAluno($al,$matricula){
		global $vkt_id;
		
		if(!empty($matricula)){
			$fim = " AND em.id = '$matricula'";
		}else{
			$fim = "ORDER BY em.id DESC";	
		}

		$aluno = mysql_query($t="SELECT *,ee.nome as escola,
			  ep.nome as periodo,
			  ea.nome as aluno,
			  emodulo.nome as modulo,
			  es.nome as sala,
			  eh.nome as horario,
			  em.id as idmatricula,
			  ea.id as idaluno,
			  ec.nome as curso
			  FROM escolar_matriculas em
			  INNER JOIN escolar_escolas ee ON em.escola_id=ee.id
			  INNER JOIN escolar_periodos ep ON em.periodo_id=ep.id
			  INNER JOIN escolar_alunos ea ON em.aluno_id=ea.id
			  INNER JOIN escolar_modulos emodulo ON em.modulo_id=emodulo.id
			  INNER JOIN escolar_salas es ON em.sala_id=es.id
			  INNER JOIN escolar_horarios eh ON em.horario_id=eh.id
			  INNER JOIN escolar_cursos ec ON em.curso_id=ec.id
			  WHERE em.aluno_id=$al
			   AND em.vkt_id='$vkt_id'
			   $fim"			   
			 );
			 //echo $t;
			 return $aluno;
}*/

function selecionaAulas($aluno,$matricula){
	global $vkt_id;
	$aulas = mysql_query($t="SELECT * FROM 
								escolar_frequencia_aula efa,
								escolar_aula ea,
								escolar_matriculas m
							WHERE 
								efa.aula_id=ea.id AND
								ea.vkt_id='$vkt_id' AND
								efa.matricula_aluno_id=$aluno AND
								m.id='$matricula'
							ORDER BY ea.id
				  ");
 
	return $aulas;
	}
function insere_pergunta_professor($campos){
			global $vkt_id;
			$data      = date('Y-m-d');
			$hora      = date('H:i:s');
				
				
				$pergunta_insert=mysql_query(" INSERT INTO escolar_forum_pergunta 
														SET
															vkt_id   = '$vkt_id',
															pergunta = '$campos[pergunta]' 	
														 ");
				$id_pergunta = mysql_insert_id();
				
				$sql_insere = "
						INSERT INTO escolar_forum
								SET  
									vkt_id       = '$vkt_id',
									aluno_id     = '$campos[aluno_id]',
									professor_id = '$campos[professor_id]',
									aula_id      = '$campos[aula_id]',
									pergunta_id  = '$id_pergunta',
									data_hora    = '$data $hora',
									status = '1'
				";	
				//echo $sql_insere;
				mysql_query($sql_insere);
}
function altera_pergunta_professor($campos){
				$sql_update = "
						UPDATE escolar_forum_pergunta
									SET
										pergunta = '$campos[pergunta]'
									WHERE 
										id = '$campos[pergunta_id]'
				";	
				//echo $sql_insere;
				mysql_query($sql_update);
}
?>