<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
$atendimento_id = $_GET['id'];
include("_functions.php");
include("_ctrl.php");
$aba = $_GET['aba'];
?>
<form onSubmit="return validaForm(this)" class="form_float" method="post" id="consulta" enctype="multipart/form-data" action="modulos/odonto/atendimento/funcoes_exame.php">
	    <input type="hidden" name="id" id="id" value="<?=$_GET['id']?>" />
        <?php
			$cliente_id = @mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_clientes WHERE id=".$_GET['id']));
		?>
        <input type="hidden" name="cliente_id" id="cliente_id" value="<?=$cliente_fornecedor->id?>" />
        <input type="hidden" name="cliente_razao_social" id="cliente_razao_social" value="<?=$cliente_fornecedor->razao_social?>" />
        <fieldset style="display:<?php if($aba=="Historico"){echo "block";}else{echo "none";}?>">
        		<legend style="float:left;">
                	<a class="chamaAuxiliares" title="cliente">Cliente</a>
                    <a class="chamaAuxiliares" title="anamnese">Anamnese</a>
                    <a class="chamaAuxiliares" title="analise">An&aacute;lise</a>
                    <a class="chamaAuxiliares" title="consulta">Consulta</a>
                </legend>
                <legend style="float:right;">
                	<a class="aba_form(this,0)"><strong>Hist&oacute;rico</strong></a>
                	<a onclick="aba_form(this,1)">Exames</a>
                    <a onclick="aba_form(this,2)">Receitu&aacute;rio</a>
                    <a onclick="aba_form(this,3)">Atestado</a>
                </legend>
				<div style="clear:both"></div>
                
                <label style="width:150px;">                
                Data
                <input type="text" name="data_exame" id="data_exame" value="<?=date('d/m/Y');?>" calendario='1' sonumero='1' mascara='__/__/____'>
                <?php
					$proximo_exame = mysql_fetch_array(mysql_query($t="SHOW TABLE STATUS LIKE 'odontologo_exames'"));	
				?>
                 <input type="hidden" name="proximo_exame" id="proximo_exame" value="<?=$proximo_exame['Auto_increment'];?>">
                </label>
                <label style="width:150px;">                
                OBS
                <input type="text" name="obs_exame" id="obs_exame">
                </label>                
                <label style="width:140px;">                
                	Arquivo
                    <input type="file" name="imagem" id="imagem" size="9">
                </label>                    
                <label style="margin-left:110px;margin-top:20px;">                
                <img src="../fontes/img/mais.png" id="add_exame"/>
                </label>
                <div id='imagem_exame' style="width:0px;height:0px;"></div>
                <div style="clear:both"></div>
                <table id="dados_exames" cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:45px;">Data</td>
                        <td style="width:210px;">Nome</td>
                        <td style="width:30px;">Baixar</td>                        
                    </tr>
                 </thead>
                 <tbody>
                 <?php
				 	$exames = mysql_query($t="SELECT * FROM odontologo_exames WHERE vkt_id='$vkt_id' AND cliente_fornecedor_id='$cliente_fornecedor->id'AND odontologo_atendimento_id=$atendimento_id");
					//alert($t);
					while($exame = @mysql_fetch_object($exames)){
				 ?>
                 	<tr id_exame="<?=$exame->id?>">
                    	<td style="width:45px;"><img src='../fontes/img/menos.png' id='remove_exame'><?=DataUsaToBr($exame->data)?></td>
                        <td style="width:210px;"><?=$cliente_fornecedor->razao_social?></td>
                        <td style="width:30px;" align="center"><a href="modulos/odonto/atendimento/exame_download.php?id=<?=$exame->id?>"> <img src='modulos/odonto/atendimento/img/baixar.png'/></a></td>          
                    </tr>
                  <?php
					}
				  ?>
                 </tbody>
                </table>                
		</fieldset>
        <fieldset style="display:<?php if($aba=="Exames"){echo "block";}else{echo "none";}?>">
        		<legend style="float:left;">
                	<a class="chamaAuxiliares" title="cliente">Cliente</a>
                    <a class="chamaAuxiliares" title="anamnese">Anamnese</a>
                    <a class="chamaAuxiliares" title="analise">An&aacute;lise</a>
                    <a class="chamaAuxiliares" title="consulta">Consulta</a>
                </legend>
                <legend style="float:right;">
                	<a class="aba_form(this,0)">Hist&oacute;rico</a>
                	<a onclick="aba_form(this,1)"><strong>Exames</strong></a>
                    <a onclick="aba_form(this,2)">Receitu&aacute;rio</a>
                    <a onclick="aba_form(this,3)">Atestado</a>
                </legend>
				<div style="clear:both"></div>
                
                <label style="width:150px;">                
                Data
                <input type="text" name="data_exame" id="data_exame" value="<?=date('d/m/Y');?>" calendario='1' sonumero='1' mascara='__/__/____'>
                <?php
					$proximo_exame = mysql_fetch_array(mysql_query($t="SHOW TABLE STATUS LIKE 'odontologo_exames'"));	
				?>
                 <input type="hidden" name="proximo_exame" id="proximo_exame" value="<?=$proximo_exame['Auto_increment'];?>">
                </label>
                <label style="width:150px;">                
                OBS
                <input type="text" name="obs_exame" id="obs_exame">
                </label>                
                <label style="width:140px;">                
                	Arquivo
                    <input type="file" name="imagem" id="imagem" size="9">
                </label>                    
                <label style="margin-left:110px;margin-top:20px;">                
                <img src="../fontes/img/mais.png" id="add_exame"/>
                </label>
                <div id='imagem_exame' style="width:0px;height:0px;"></div>
                <div style="clear:both"></div>
                <table id="dados_exames" cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:45px;">Data</td>
                        <td style="width:210px;">Nome</td>
                        <td style="width:30px;">Baixar</td>                        
                    </tr>
                 </thead>
                 <tbody>
                 <?php
				 	$exames = mysql_query($t="SELECT * FROM odontologo_exames WHERE vkt_id='$vkt_id' AND cliente_fornecedor_id='$cliente_fornecedor->id'AND odontologo_atendimento_id=$atendimento_id");
					//alert($t);
					while($exame = @mysql_fetch_object($exames)){
				 ?>
                 	<tr id_exame="<?=$exame->id?>">
                    	<td style="width:45px;"><img src='../fontes/img/menos.png' id='remove_exame'><?=DataUsaToBr($exame->data)?></td>
                        <td style="width:210px;"><?=$cliente_fornecedor->razao_social?></td>
                        <td style="width:30px;" align="center"><a href="modulos/odonto/atendimento/exame_download.php?id=<?=$exame->id?>"> <img src='modulos/odonto/atendimento/img/baixar.png'/></a></td>          
                    </tr>
                  <?php
					}
				  ?>
                 </tbody>
                </table>                
		</fieldset>
        <fieldset style="display:<?php if($aba=="Receituário"){echo "block";}else{echo "none";}?>">
					<legend style="float:left;">
                	<a class="chamaAuxiliares" title="cliente">Cliente</a>
                    <a class="chamaAuxiliares" title="anamnese">Anamnese</a>
                    <a class="chamaAuxiliares" title="analise">An&aacute;lise</a>
                    <a class="chamaAuxiliares" title="consulta">Consulta</a>
                </legend>
                <legend style="float:right;">
                	<a class="aba_form(this,0)">Hist&oacute;rico</a>
                	<a onclick="aba_form(this,1)">Exames</a>
                    <a onclick="aba_form(this,2)"><strong>Receitu&aacute;rio</strong></a>
                    <a onclick="aba_form(this,3)">Atestado</a>
                </legend>
				<div style="clear:both"></div>
                
                <label style="width:150px;">                
                Data
                <input type="text" name="data_receituario" id="data_receituario" value="<?=date('d/m/Y');?>" calendario='1' sonumero='1' mascara='__/__/____'>
                </label>
                <label style="width:80%;float:left;">                
                Receitu&aacute;rio
                <textarea name="texto_receituario" id='texto_receituario' rows="20" cols="70"></textarea>
                </label>
                <label style="margin-left:30px;margin-top:20px;">                
                <img src="../fontes/img/mais.png" id="add_receituario"/>
                </label>
                
                <div style="clear:both"></div>
                <table id="dados_receituario" cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:45px;">Data</td>
                        <td style="width:210px;">Nome</td>
                        <td style="width:30px;">Imprimir</td>                        
                    </tr>
                 </thead>
                  <tbody>
                 <?php
				 	$receituarios = mysql_query($t="SELECT * FROM odontologo_receituario WHERE vkt_id='$vkt_id' AND cliente_fornecedor_id='$cliente_fornecedor->id' AND odontologo_atendimento_id = $atendimento_id");
					
					while($receituario = @mysql_fetch_object($receituarios)){
				 ?>
                 	<tr id_receituario="<?=$receituario->id?>">
                    	<td style="width:45px;"><img src='../fontes/img/menos.png' id='remove_receituario'><?=DataUsaToBr($receituario->data)?></td>
                        <td style="width:210px;"><?=$cliente_fornecedor->razao_social?></td>
                        <td style="width:30px;" align="center" ><a><img src='modulos/odonto/consulta/Printer-icon.png' class="print_receituario"/></a></td>          
                    </tr>
                  <?php
					}
				  ?>
                 </tbody>
                </table>     
           
		</fieldset>
        <fieldset style="display:<?php if($aba=="Atestado"){echo "block";}else{echo "none";}?>">
				<legend style="float:left;">
                	<a class="chamaAuxiliares" title="cliente">Cliente</a>
                    <a class="chamaAuxiliares" title="anamnese">Anamnese</a>
                    <a class="chamaAuxiliares" title="analise">An&aacute;lise</a>
                    <a class="chamaAuxiliares" title="consulta">Consulta</a>
                </legend>
                <legend style="float:right;">
                	<a class="aba_form(this,0)">Hist&oacute;rico</a>
                	<a onclick="aba_form(this,1)">Exames</a>
                    <a onclick="aba_form(this,2)">Receitu&aacute;rio</a>
                    <a onclick="aba_form(this,3)"><strong>Atestado</strong></a>
                </legend>
				<div style="clear:both"></div>
                
                <label style="width:80px;">                
                CID
                <input type="text" name="cid" id="cid" sonumero='1'>
                </label>
                <label style="width:150px;">                
                Data
                <input type="text" name="data_atestado" id="data_atestado" value="<?=date('d/m/Y');?>" calendario='1' sonumero='1' mascara='__/__/____'>
                </label>
                <label style="width:80px;">                
                Hora In&iacute;cio
                <input type="text" name="hora_inicio_atestado" id="hora_inicio_atestado" mascara='__:__'>
                </label>
               <label style="width:80px;">                
                Hora Fim
                <input type="text" name="hora_fim_atestado" id="hora_fim_atestado" mascara='__:__'>
                </label>
                <label style="width:120px;">                
                Dias Afastamento
                <input type="text" name="dias_afastamento" id="dias_afastamento" sonumero='1'>
                </label>
                <label style="margin-left:30px;margin-top:20px;">                
                <img src="../fontes/img/mais.png" id="add_atestado"/>
                </label>
                
                <div style="clear:both"></div>
                <table id="dados_atestado" cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:30px;">Data</td>
                        <td style="width:200px;">Nome</td>
                        <td style="width:30px;">Dias</td>
                        <td style="width:30px;">Imprimir</td>                        
                    </tr>
                 </thead>
                  <tbody>
                 <?php
				 	$atestados = mysql_query($t="SELECT * FROM odontologo_atestados WHERE vkt_id='$vkt_id' AND cliente_fornecedor_id='$cliente_fornecedor->id' AND odontologo_atendimento_id = $atendimento_id");
					//echo $t;
					while($atestado = @mysql_fetch_object($atestados)){
				 ?>
                 	<tr id_atestado="<?=$atestado->id?>">
                        <td style="width:30px;"><img src='../fontes/img/menos.png' id='remove_atestado'><?=DataUsaToBr($atestado->data)?></td>
                        <td style="width:200px;"><?=$cliente_fornecedor->razao_social?></td>
                        <td style="width:30px;"><?=$atestado->dias_afastado?></td>
                        <td style="width:30px;" align="center"><img src='modulos/odonto/consulta/Printer-icon.png' class="print_atestado"/></td>          
                    </tr>
                  <?php
					}
				  ?>
                 </tbody>
                </table>                
		</fieldset>

		<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($fila->id>0){
		if($fila->status!='Concluido'&&$fila->status!='Cancelado'){
			echo "<input name='action' type='submit' value='Cancelar' style='float:left' />";
		}
		if($fila->status=='Em espera'){
		 	echo "<input name='action' type='submit'  value='Atendimento' style='float:right'  />";
		}
		else if($fila->status=='Em atendimento'){
		 	echo "<input name='action' type='submit'  value='Concluir' style='float:right'  />";
		}
	}else{
	?>
	<input name="action" type="submit"  value="Enviar Para Fila" style="float:right"  />
    <?
	}
	?>
    
	<div style="clear:both"></div>
	</div>
</form>