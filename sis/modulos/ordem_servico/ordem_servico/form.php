<?
//Includes
// configura��o inicial do sistema
include("../../../_config.php");
// fun��es base do sistema
include("../../../_functions_base.php");
include("../../../modulos/financeiro/_functions_financeiro.php");
// fun��es do modulo empreendimento
$opcoes = array('1'=>'block','2'=>'none');
$disabled = '';
$readonly = '';
$disOrcado = 'none';
include("_functions.php");
include("_ctrl.php"); 
?>

<style>
input,textarea{ display:block; border:1px solid #E0E0E0}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">

<div id='aSerCarregado'>
<div style="width:860px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Ordem de Servi&ccedil;o</span></div>
    </div>
   
	<form onSubmit="return validaForm(this)" id="form_osCadastro" class="form_float"  method="post" autocomplete='off' enctype="multipart/form-data">
    <input type="hidden" name="id" id="id" value="<?=$reg_os->id?>" <?=$readonly?>>
     <input type="hidden" name="numero_sequencia_empresa" id="numero_sequencia_empresa" value="<?=$reg_os->numero_sequencial_empresa?>" <?=$readonly?>>
    <input type="hidden" name="data_hoje" id="data_hoje" value="<?=date('d/m/Y')?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
    <input type="hidden" name="situacao_orcamento" value="1">
		 <legend>
            <a onclick="aba_form(this,0)">  <strong>Ordem de Servi&ccedil;o</strong> </a>
    		<a onclick="aba_form(this,1)"> Produtos </a>
    		<a onclick="aba_form(this,2)"> Servi&ccedil;os </a>
    		<a onclick="aba_form(this,3)"> Resumo </a>
            <a onclick="aba_form(this,7)"> Despesas </a>
          </legend>
          <input type="hidden" name="cliente_id" id="cliente_id" value="<?=$reg_os->cliente_id?>">
               
        <div id="motivo" style="display:none;">
        <label style="width:340px;">Motivo<br/>
        	<input type="text" name="motivo_cancelado" id="motivo_cancelado" style="width:350px;" value="">
        </label>
        </div>
        <div style="clear:both;"></div>
        
		<label style="width:311px;">
			Cliente
			  <input type="text" id='cliente' busca='modulos/ordem_servico/ordem_servico/busca_cliente.php,@r1 @r2,@r0-value>cliente_id|@r1-value>cliente,0' autocomplete='off' name="cliente" maxlength="44"  valida_minlength="3"  retorno='focus|Selecione o Cliente' value="<?=$cliente_id->razao_social?>" <?=$disabled?> />
		</label>
        <label style="width:32px;"><br/>
          	<button type="button" name="cad_cliente"  id="cad_cliente" title="Cadastro de Clientes" rel="tip" ><img  src="../fontes/img/adm.png" ></button>
         </label>
         
         <label><br/>
         	<button type="button" name="add-equipamento" id="add-equipamento"><b>+</b> Adicionar equipamento</button>
         </label>
            <!-- modal -->
           <div style="position:absolute; left:181px; margin-top:50px;">
              <div class="modal" style="display:none">
              <div class="modal-header-2">
              	<a href="#" style="color:#CCC; font-weight:bold; float:right;" class="modal_close">x</a>
                <span>Cadastro de Cliente</span>
              </div>
                    <div class="modal-body">
                    	<p>
                        	<div class="atl_natureza" style="padding:3px;">
                            	<div style="float:left"><input type="radio" name="natureza" id="cpf" value="1" style="width:20px;">CPF</div>
                            	<div><input type="radio" name="natureza" id="cnpj" value="2" style="width:20px;">CNPJ</div>
                            </div>
                            <div style="clear:both;"></div>
                        	<div style=" float:left;"><label style="width:175px;">Nome<br/><input type="text" name="atl_nome" id="atl_nome" style="height:15px;" disabled="disabled"></label></div>
                            <div><label style="width:120px;">CNPJ/CPF <br/><input type="text" name="atl_cnpf_cpf" id="atl_cnpf_cpf" style="height:15px;" disabled="disabled"></label></div>      
                         </p>
                         <!--<button type="button" name="atl_cadastrar" id="atl_cadastrar" disabled="disabled" style="margin-top:8px;" >cadastrar</button>-->
                          <div><small style=" color:#999999; font-size:11px;">ap&oacute;s cadastro v&aacute; para tela cliente para completar as informa&ccedil;&otilde;es </small></div>
                    </div>
              <div class="modal-footer">
              	<!--<div style="padding:3px;"><span>ap&oacute;s o cadastro v� para tela cliente</span></div>999999-->
                <button type="button" name="atl_cadastrar" id="atl_cadastrar" disabled="disabled" >cadastrar</button>
               
              </div>
			</div>
    		</div>
        	<!-- fim modal -->
         <div style="clear:both;"></div>
         <label>
        	Local Atendimento<br/>
            	<select name="local_atendimento" <?=$disabled?> style="width:100px;">
                	<option <? if($reg_os->local_atendimento == '1'){echo 'selected="selected"';}?> value="1">Empresa</option>
                    <option <? if($reg_os->local_atendimento == '2'){echo 'selected="selected"';}?>value="2">Cliente</option>
                </select>
        </label>        
        
        <label>Descri�ao<br/>
        	<input type="text" name="descricao" id="descricao" style="width:250px;" value="<?=$reg_os->descricao?>" <?=$disabled?>>
        </label>
        
       
        <label>Vendedor<br/>
        	<select name="vendedor_id" id="vendedor_id" <?=$disabled?> style="width:150px;">
            	<option></option>
				<?
                		$sqlVendedor=mysql_query(" SELECT * FROM rh_funcionario WHERE vkt_id = '$vkt_id' ");
							while($vendedor=mysql_fetch_object($sqlVendedor)){
									if($reg_os->vendedor_id == $vendedor->id) {$selVendedor='selected="selected"';}else{$selVendedor='';}
				?>            
            	<option <?=$selVendedor?>  value="<?=$vendedor->id?>"><?=$vendedor->nome?></option>
            	<?
							}
				?>
            </select>
        </label>
         <div style="clear:both;"></div>
         <label>
        	Tipo Atendimento<br/>
            	<select name="tipo_atendimento" id="tipo_atendimento" style="width:100px;" <?=$disabled?>>
                	<?
                    		$sqlAtendimento=mysql_query(" SELECT * FROM os_atendimento WHERE vkt_id = '$vkt_id'");
								while($atendimento = mysql_fetch_object($sqlAtendimento)){
					?>
                    <option <? if($reg_os->tipo_atendimento == $atendimento->id){echo 'selected="selected"';}?> value="<?=$atendimento->id?>"><?=$atendimento->descricao?></option>
                    <?
						}
					?>                   
                </select>
        </label>
        
        <label>
        	Garantia<br/>
            	<select name="garantia" id="garantia" <?=$disabled?>>
                	<option selected="selected" <? if($reg_os->garantia == '1'){echo 'selected="selected"';}?> value="1">N�o</option>
                    <option  <? if($reg_os->garantia == '2'){echo 'selected="selected"'; }?> value="2">Loja</option>
                    <option  <? if($reg_os->garantia == '3'){echo 'selected="selected"'; }?> value="3">Fabricante</option>
                </select>
        </label>
        <label> Garantia At&eacute;<br/>
        	<input type="text" disabled="disabled" name="data_final_garantia" id="data_final_garantia" <? if($reg_os->garantia == '2'){echo 'disabled="disabled"';} else{echo '';}?>  calendario="1" mascara="__/__/____" style="width:70px; background:#E8E8E8;" value="<? if($reg_os->data_final_garantia){echo dataUsaToBr($reg_os->data_final_garantia);}?>" <?=$disabled?> >
        </label>
        <label style="width:80px;">Data Cadastro<br/>
        	<input type="text" name="data_cadastro" id="data_cadastro" size="5" value="<? 
			if($reg_os->data_cadastro){ echo dataUsaToBr($reg_os->data_cadastro);}
			else{ echo date("d/m/Y");}
			?>" calendario="1" <?=$disabled?> />
        </label>
         <label>Situa&ccedil;&atilde;o <br/>
        		<select name="opcao_1" id="opcao_1" disabled="disabled">
                	<option <? if($reg_os->situacao == '1'){ echo 'selected="selected"';}?> value="1">Or&ccedil;amento</option>
                    <option <? if($reg_os->situacao == '2'){ echo 'selected="selected"';}?> value="2">Aprovado</option>
                    <option <? if($reg_os->situacao == '3'){ echo 'selected="selected"';}?> value="3">Cancelado</option>
                </select>   
        </label>
        <div style="clear:both"></div>
        <label id="date_entrega">Previs�o Entrega<br/>
        	<input type="text" name="data_entrega" id="data_entrega" calendario="1" mascara="__/__/____" style="width:70px;" value="<? if($reg_os->data_entrega){echo dataUsaToBr($reg_os->data_entrega); }?>" <?=$disabled?>>
        </label>
        
        <label>
        Dias<br/>
        	<input type="text" name="dias" id="dias" style="width:50px" value="<?=$reg_os->qtd_dias?>" <?=$DisaPago?>>
        </label>
        
        <label style="width:70px;">
        	<?php
            		if(!empty($reg_os->comissao_vendedor)){
						$comissao = $reg_os->comissao_vendedor;
					}else{
						$sqlConf = mysql_fetch_object(mysql_query(" SELECT * FROM os_configuracao WHERE id =  '$vkt_id' "));
						$comissao = $sqlConf->comissao_vendedor;
					}
			?>
        	 Vendedor<br/>
            	<input type="comissao_vendedor" name="comissao_vendedor" id="comissao_vendedor" style="width:50px; float:left; text-align:right;" decimal="1" value="<?=substr(moedaUsaToBr($comissao),0,4);?>"><div style="margin-top:5px;"> %</div>
        </label>
       <div style="clear:both;"></div>
        <label style="width:250px;">
        	Arquivo Modelo
        	<input type="file" name="arquivo_modelo" id="arquivo_modelo" />
        </label>
        
        <span id="lista-equipamento"></span>
        <div style="clear:both"></div>
        <div id="window-add-equipamento" class="window" style="position:absolute; top:10%;"></div>
        <div id="result-table-equipamento" style="max-height:120px; overflow:auto;">
        
        <?php
            $sql = mysql_query(" SELECT * FROM os_has_equipamento WHERE os_id = '$reg_os->id' ");
			while($equipamentoItem=mysql_fetch_object($sql)){
		    $EquipamentoName = mysql_fetch_object(mysql_query(" SELECT * FROM os_equipamento WHERE id = '$equipamentoItem->equipamento_id'  "));
			echo "<input type='hidden' name='list_equipamento[]' value='".$equipamentoItem->equipamento_id."'>";
		?>
      <table id="table-equipamento" class="table-equipamento-<?=$equipamentoItem->equipamento_id?>" cellpadding="0" cellspacing="0" width="98%">
          <thead>
              <tr>
                  <th colspan="4" align="left" class="equipamento"><?=$EquipamentoName->nome?>
                  <?php if($reg_os->pago != "sim"){ ?>
                  		<a href="#" class="<?=$equipamentoItem->id?>" id="del-equipamento-edit"><span style="float:right; color:#777"> &times; </span></a>
                  <? } ?>
                  </th>
              </tr>
              <tr>
                  <th style="width:35px;">COD</th>
                  <th>Solicita��o / Defeito</th>
                  <th>Diagn�stico / Laudo</th>
                  <th>Estado Equipamento</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td>
                    <input type="hidden" name="os_id" value="<?=$equipamentoItem->os_id?>">
                    <input type="hidden" name="equipamento" value="<?=$EquipamentoName->nome?>">
                    <input type="hidden" name="marca" value="<?=$EquipamentoName->marca?>">
                    <input type="hidden" name="modelo" value="<?=$EquipamentoName->modelo?>">
                    <input type="hidden" name="numero_serie" value="<?=$EquipamentoName->numero_serie?>">
                    <input type="hidden" name="equipamento_id[]" value="<?=$EquipamentoName->id?>"> <?=$EquipamentoName->id?> </td>
                  <td><input type="hidden" name="solicitacao_defeito[]" value="<?=$equipamentoItem->solicitacao_defeito?>"><span><?=$equipamentoItem->solicitacao_defeito?></span></td>
                  <td><input type="hidden" name="diagnostico_laudo[]" value="<?=$equipamentoItem->diagnostico_laudo?>"><span><?=$equipamentoItem->diagnostico_laudo?></span></td>
                  <td><input type="hidden" name="estado_equipamento[]" value="<?=$equipamentoItem->estado_equipamento?>"><span><?=$equipamentoItem->estado_equipamento?></span></td>
              </tr>
          </tbody>
        </table>
        <? }?>
        </div>
	
    </fieldset>
<!-- *********************** AQUI FORMULARIO DE CADASTRO PARA PRODUTOS **************** -->
<!-- ABA PRODUTO -->     
      <fieldset id="campos_2" style="display:none">
		 <legend>
            <a onclick="aba_form(this,0)"> Ordem de Servi&ccedil;o </a>
    		<a onclick="aba_form(this,1)"> <strong>Produtos</strong>   </a>
    		<a onclick="aba_form(this,2)"> Servi&ccedil;os </a>
    		<a onclick="aba_form(this,3)"> Resumo </a>
            <a onclick="aba_form(this,7)"> Despesas </a>
          </legend>
            <input type="hidden" name="produto_id" id="produto_id" style="width:50px;">
            <input type="hidden" name="preco_venda_produto" id="preco_venda_produto" style="width:50px;">
            <label>
            	Produto<br/>
                <input type="text" name="produto" id="produto" style="width:300px;" <?=$disabled?> busca='modulos/ordem_servico/ordem_servico/busca_produto.php,@r0 ,@r1-value>produto_id|@r2-value>preco_venda_produto,0'>
            </label>
            <label>
            	QTD<br/>
            	<input type="text" name="qtd_produto" id="qtd_produto" style="width:50px;" <?=$disabled?> sonumero="1" maxlength="6" value="1">
            </label>
            <label style="margin-top:3px;"><br/>
            	<img src="../fontes/img/mais.png" id="click_produto">
            </label>
            <div style="clear:both"></div>
          	<table cellpadding="0" cellspacing="0" width="100%" >
                <thead>
                        <tr>
                          <!--<td width="20"></td>-->
                          <td width="340" style="border-left:1px solid #CCC;">Descri&ccedil;&atilde;o Produto</td>
                          <td width="50">QTD</td>
                          <td width="80">Valor</td>
                          <td width="80">Valor Total </td>
                          <td width="30" style="padding-left:3px;">A&ccedil;&atilde;o</td>
                        </tr>
               </thead>
<script>resize()</script><!-- Isso � Necess�rio para a cria�ao o resize -->
                <tbody id="tbody">
                </tbody>
            
             <div id="excluir_item_produto"></div>
                <tbody>
						<?php															
						  $sqlProduto = mysql_query(" SELECT * FROM os_item_produto WHERE os_id = '$reg_os->id' AND vkt_id = '$vkt_id' ORDER BY id DESC");
						  while($item_produto=mysql_fetch_object($sqlProduto)){
						  $produtoDescricao = mysql_fetch_object(mysql_query(" SELECT * FROM produto WHERE id = '$item_produto->produto_id'"));
						  $total_item = $item_produto->valor_produto * $item_produto->qtd_produto;
						  $total_produto += $total_item;
						?>
                        <tr>
                        	  <td style="display:none;">
                              	<input type="hidden" name="IDItemProduto[]" id="IDItemProduto" value="<?=$item_produto->id?>" size="5">
                                <input type="text" name="osIDProduto[]" id="osIDProduto" value="<?=$item_produto->os_id?>" size="5">
                              </td>
                              <!--<td width="20"><input type="checkbox" name="marcado_edit" id="marcado_edit" value="1"></td>-->
							  <td width="370" style="border-left:1px solid #CCC;">
							  <input type="hidden" name="edit_ServicoID[]" id="edit_ServicoID" value="<?=$array_produto[$i]?>" size="5">
							  <?=$produtoDescricao->nome?>
							  </td>
							  <td width="55">
							  <input type="hidden" name="array_qtd_produto[]" id="array_qtd_produto" value="<?=$item_produto->qtd_produto?>" size="3">
							  <?=$item_produto->qtd_produto?>
							  </td>
							  <td width="87">
							  	<input type="hidden" name="array_valor_produto[]" id="array_valor_produto" value="<?=moedaUsaToBr($item_produto->valor_produto)?>" size="5">
								<?=moedaUsaToBr($item_produto->valor_produto)?>
							  </td>
							  <td width="88">
							  <input type="hidden" name="v_total_produto[]" id="v_total_produto" value="<?=moedaUsaToBr($total_item);?>" size="5">
							  <?=moedaUsaToBr($total_item);?>
							  </td>
							  <td width="33" style="padding-left:3px;">
                              <?
                              	if(!empty($disabled)){
									echo '';	
								} else{
									echo '<img src="../fontes/img/menos.png" id="edit_produto_excluir" style="padding-left:4px;">';	
								}
							  ?>							  
                              </td>
						</tr>
                        <?
							}
						?>
                </tbody>
            	<thead>
            			<tr>
							 <td style="border-left:1px solid #CCC; padding-right:10px;" colspan="3" align="right"> Total R$ </td>
							 <td width="88">
                              <div id="t_produto_table"><?=moedaUsaToBr($total_produto)?></div>
                             </td>
							 <td width="33" style="padding-left:3px;"></td>
						</tr>
                      </thead> 
              </table>
      </fieldset>
<!-- *********************** AQUI FORMULARIO DE CADASTRO PARA SERVI�OS **************** -->
<!-- ABA SERVI�OS -->
       <fieldset id="campos_3" style="display:none">
		 <legend>
            <a onclick="aba_form(this,0)"> Ordem de Servi&ccedil;o </a>
    		<a onclick="aba_form(this,1)"> Produtos </a>
    		<a onclick="aba_form(this,2)"> <strong>Servi&ccedil;os</strong> </a>
    		<a onclick="aba_form(this,3)"> Resumo </a>
            <a onclick="aba_form(this,7)"> Despesas </a>
          </legend>
          
           <input type="hidden" name="servico_id" id="servico_id" >
           <input type="hidden" name="valor_normal" id="valor_normal" >
           <input type="hidden" name="valor_unit" id="valor_unit" >
          <label style="width:160px">
            	Servi&ccedil;os<br/>
                <input type="text" name="servico" id='servico' <?=$disabled?> busca='modulos/ordem_servico/ordem_servico/busca_servico.php,@r0 ,@r1-value>servico_id|@r2-value>valor_normal|@r2-value>valor_unit|@r4-value>und_servico,0'  >
            </label><label>
            	UND
                <div style="padding:3px;" id="visual_und"><strong></strong></div>
                <input type="hidden" name="und_servico" id="und_servico" style="width:30px" value="">
            </label>
            <div id="info_m2"></div>
            
            <label style="width:30px;">QTD
            	<input type="text" name="qtd_servico" id="qtd_servico"  <?=$disabled?> maxlength="8" value="1">
            </label>
            
            <label style="width:130px;">Respons�vel<br/>
            	<select name="funcionario_id" id="funcionario_id" <?=$disabled?>>
                	<option></option>
					<?
                    	$s_funcionario=mysql_query("SELECT * FROM rh_funcionario WHERE vkt_id ='$vkt_id'");
							while($funcionario=mysql_fetch_object($s_funcionario)){
					?>
                    	<option value="<?=$funcionario->id?>"><?=$funcionario->nome?></option>                
                	<?
							}
					?>
                </select>
            </label>
            <div style="clear:both;"></div>
            <label style="width:175px;" title="Observa��o de Or�amento" rel="tip">
            Obs. Or�amento<br/>
            	<input type="text" name="obs_item_servico" id="obs_item_servico" <?=$disabled?>>
            </label>
            
            <label style="width:175px;" title="Observa��o de Produ��o" rel="tip">
            Obs. de Produ��o<br/>
            	<input type="text" name="obs_producao" id="obs_producao" <?=$disabled?>>
            </label>
            
            <label style="margin-top:3px;"><br/>
            	<img src="../fontes/img/mais.png" id="click_servico">
            </label>
            <div style="clear:both"></div>
          	<table cellpadding="0" cellspacing="0" width="100%" >
                <thead>
                        <tr>
                          <!--<td width="20"></td>-->
                          <td width="230">Descri&ccedil;&atilde;o </td>
                          <td width="160">Respons&aacute;vel</td>
                          <td width="160">Observa&ccedil;&atilde;o</td>
                          <td width="160">Obs. Produ��o</td>
                          <td width="40">QTD</td>
                          <td width="70">Valor</td>
                          <td width="80" style="padding-left:2px;">Total</td>
                          <td></td>
                        </tr>
               </thead>
			<script>resize()</script><!-- Isso � Necess�rio para a cria�ao o resize -->
                <tbody id="tbody_servico">
                	
                </tbody>
                <tbody>
                		<?
							$sql_ServicoEdit = mysql_query(" SELECT * FROM os_item WHERE os_id = '$reg_os->id' AND vkt_id = '$vkt_id' ORDER BY id DESC");
                  
							while($item_servico=mysql_fetch_object($sql_ServicoEdit)){
								
								$funcionario = mysql_fetch_object(mysql_query(" SELECT * FROM rh_funcionario WHERE id = '$item_servico->funcionario_id' AND vkt_id = '$vkt_id'"));
								$servicoDescricao = mysql_fetch_object(mysql_query(" SELECT * FROM servico WHERE id = $item_servico->servico_id"));
							$total_item_servico = $item_servico->valor_servico * $item_servico->qtd_servico;
							
							$total_servico += $total_item_servico;
							
							if($item_servico->status == '1'){
									$checked_edit = 'checked="checked"';
									$edit_servico = 1;
							} else{
									$checked_edit = '';
									$edit_servico = 2;
							}
							
						?>
						 <tr id="<?=$item_servico->id?>">
                              <td style="display:none;">
                              	<input type="hidden" name="id_ItemServico[]" value="<?=$item_servico->id?>" size="5"><br/>
                                <input type="hidden" name="edit_osID[]" id="edit_osID" value="<?=$item_servico->os_id?>" size="5">
                              </td>
                              <td width="20" style="padding-left:4px;display:none;">
                              	<input type="checkbox" <?=$checked_edit?> <?=$disabled?> name="marcado_edit_servico[]" id="marcado_edit_servico" value="1">
                                <input type="hidden" name="check_edit_servico[]" id="check_edit_servico" size="5" value="<?=$edit_servico?>">
                              </td>
							  <td width="230">
							  	<input type="hidden" name="edit_ServicoID[]" id="array_servico_id" value="<?=$item_servico->servico_id?>" >
							  <?=$servicoDescricao->nome?>
							  </td>
							  <td width="160">
							  	<input type="hidden"  name="array_funcionario_id[]" id="array_funcionario_id" value="<?=$funcionario->id?>" size="5">
								<br/><?=$funcionario->nome?>
							  </td>
                              <td width="160"> 
                              	<input type="text" id="edit_obsItemServico" name="edit_obsItemServico[]" value="<?=($item_servico->obs_item_servico)?>">
                                
                               </td>
                               <td width="160"> 
                              	<input type="text" id="edit_obs_producao" name="edit_obs_producao[]" value="<?=($item_servico->obs_item_producao)?>">
                                
                               </td>
							  <td width="40">
							  	<input type="hidden" name="array_qtd_servico[]" id="array_qtd_servico" value="<?=$item_servico->qtd_servico?>" size="2">
								<?=$item_servico->qtd_servico?>
							  </td>
							  <td width="70">
							  	<input type="hidden" name="array_valor_servico[]" id="array_valor_servico" value="<?=moedaUsaToBr($item_servico->valor_servico)?>" size="4">
								  	<input type="hidden" name="valor_tecnico[]" id="valor_tecnico" value="<?=moedaUsaToBr($item_servico->valor_funcionario)?>">
							<?=moedaUsaToBr($item_servico->valor_servico)?>
							  </td>
							  <td width="80">
							  	<input type="hidden" name="v_total_servico[]" id="v_total_servico" value="<?=moedaUsaToBr($total_item_servico)?>">
							  	<?=moedaUsaToBr($total_item_servico)?>
							  </td>
							  <td>
                              <?
							  	if(!empty($disabled)){
									echo '';	
								}else{
									echo '<img src="../fontes/img/menos.png" id="edit_servicoExcluir" style="padding-left:4px;">';	
								}
                              ?>
							  </td>
                    	 </tr>
                         <?
							}
						 ?>
                </tbody>
            <!--</table>-->
            <!-- TABELA TOTAL PARA SERVICOS -->
            <!--<table cellpadding="0" cellspacing="0" width="100%" >-->
           	 	<thead>
                        <tr>
							  <td width="300" style="border-left:1px solid #CCC; padding-right:10px;" align="right" colspan="6" >Total R$ </td>
							  <td width="69">
                                <div id="t_servico_table"><?=moedaUsaToBr($total_servico)?></div>
                              </td>
							  
                              <td width="33">&nbsp;</td>
                   	     </tr>
               </thead>
            </table>
      </fieldset>
<!--Fim dos fiels set-->
<!-- ************************* VISUALIZA�AO DOS ORCAMENTOS **************************** -->

<!-- ABA RESUMO -->
	<fieldset id="campos_4" style="display:none">
       <legend>
          <a onclick="aba_form(this,0)"> Ordem de Servi&ccedil;o </a>
          <a onclick="aba_form(this,1)"> Produtos   </a>
          <a onclick="aba_form(this,2)"> Servi&ccedil;os </a>
          <a onclick="aba_form(this,3)"> <strong>Resumo</strong> </a>
          <a onclick="aba_form(this,7)"> Despesas </a>
        </legend>
         
        <label>
              Valor Produtos<br/>
             <!--<span id="TotalProduto" style="font-weight:bold; padding-left:5px; margin-left:3px"><?=moedaUsaToBr($total_edit_produto->total_produto)?></span>-->
             <input type="text" name="total_produto" style="width:80px;text-align:right;" id="total_produto" readonly="readonly" value="<?=moedaUsaToBr($total_edit_produto->total_produto)?>">
        </label>
        <label>
          Descontos (-) <br/>
          <input type="text" style="width:70px;text-align:right;" name="desconto-produto" id="desconto-produto" decimal="2" maxlength="14" value="<?=moedaUsaToBr($reg_os->desconto_produto)?>">
        </label>
        <?
        	if(!empty($total_edit_produto->total_produto))
				  $porcentProduto = moedaUsaToBr(($reg_os->desconto_produto / $total_edit_produto->total_produto) * 100);
		?>
        <label style="width:50px;">
          %<br/>
          <input type="text" style="width:40px;text-align:right;" name="desconto-produto-porcent" id="desconto-produto-porcent" decimal="1" maxlength="14" value="<?=$porcentProduto?>">
        </label>
        <label>Acr�scimo (+) <br/>
          <input type="text" style="width:80px;text-align:right;" name="acrescimo-produto" id="acrescimo-produto" decimal="2" maxlength="14" value="<? if(!empty($reg_os->acrescimo_produto)) echo moedaUsaToBr($reg_os->acrescimo_produto)?>">
        </label>
       
        <label> <strong>Total Produto</strong> <br/>
          <input type="text" name="total-geral-produto" id="total-geral-produto" readonly="readonly" style="width:80px; text-align:right;" value="<?=moedaUsaToBr(SomaTotalProdutos($total_edit_produto->total_produto,$reg_os->desconto_produto,$reg_os->acrescimo_produto));?>">
        </label>
          
        <div style="clear:both"></div><br/>
        <? SomaTotalServicos($total_edit_servico->total_servico,$reg_os->desconto,$reg_os->acrescimo); ?>
        <label>
          Valor Servi&ccedil;os<br/>
            <!--<span id="TotalServico" style="font-weight:bold; padding-left:5px; margin-left:3px"><?=moedaUsaToBr($total_edit_servico->total_servico)?></span>-->
            <input type="text" name="total_servico" style="width:80px; text-align:right;" id="total_servico" readonly="readonly" value="<?=moedaUsaToBr($total_edit_servico->total_servico)?>" >
        </label> 
          <?	
			  if(!empty($total_edit_servico->total_servico))
				  $porcentagem = moedaUsaToBr(($reg_os->desconto / $total_edit_servico->total_servico) * 100);
		  ?>
          <label>
          	Descontos(-)<br/>
            	<input type="text" name="desconto" id="desconto" style="width:70px;text-align:right;" decimal="2" maxlength="14" value="<? if($reg_os->desconto > 0){ echo moedaUsaToBr($reg_os->desconto);} ?>" <?=$disabled?>>
          </label>
          
          <label style="width:50px;">%<br/>
          	<input type="text" name="descontoPorcentagem" id="descontoPorcentagem" style="width:40px;text-align:right;"  decimal="1" value="<?=substr($porcentagem,0,4);?>" <?=$disabled?>>
          </label>
          
          <label>
          	Acrescimo(+)<br/>
            	<input type="text" name="acrescimo" id="acrescimo" decimal="2" maxlength="14" style="width:80px; text-align:right;" value="<? if($reg_os->acrescimo > 0){ echo moedaUsaToBr($reg_os->acrescimo); }?>" <?=$disabled?>>
          </label>
           
           <label> <strong>Total Servi�o</strong> <br/>
          <input type="text" name="total-servico" id="total-servico" readonly="readonly" style="width:80px;text-align:right;" value="<?=moedaUsaToBr(SomaTotalServicos($total_edit_servico->total_servico,$reg_os->desconto,$reg_os->acrescimo))?>">
        </label>
        <div style="clear:both"></div>
          
          <div style="width:479px;" >
            <label><strong>Subtotal</strong><br/>
             <input type="text" name="valor_total" id="subtotal" readonly="readonly" style="width:80px; text-align:right" value="<?=moedaUsaToBr($reg_os->valor_total);?>">
           </label>
          
          <div style="float:right; margin-top:8px;">
          <div style="clear:both"></div>
          <label>
          	 <strong>Total Geral</strong><br/>
             <input type="text" name="valor_total_geral" id="ostotalView" readonly="readonly"  style="width:80px; text-align:right" value="<?=moedaUsaToBr($reg_os->valor_total_geral);?>">
             <input type="hidden" name="ostotal" id="ostotal" style="width:80px; text-align:right" value="<?=moedaUsaToBr($reg_os->valor_total_geral);?>" />
          </label>
          </div>
         
         </div>
         
        
          
        
       <div style="clear:both"></div>
       
       <div>     
        <label style="width:120px;">Forma de Pagamento <?=$reg_os->forma_pagamento?>
          <select name="forma_pagamento_resumo" id="forma_pagamento_resumo">
              <option value="0">Selecione</option>
              <?php
                  $sql = mysql_query(" SELECT * FROM financeiro_formas_pagamento WHERE vkt_id = '$vkt_id' ");
                  while($formaPlano=mysql_fetch_object($sql)){
              ?>
              <option <? if($reg_os->forma_pagamento_resumo == $formaPlano->id){echo 'selected="selected"';}?> value="<?=$formaPlano->id?>"><?=$formaPlano->nome?></option>
              <?php } ?>
          
          </select>
        </label>
          
          
         <label>Parcelas<br/>
   			<select name="parcelas_resumo" id="parcelas_resumo" idregistro="<?=$reg_os->id?>">
                <option value="0"></option>
            	<option <? if($reg_os->qtd_parcelas_resumo == '1'){echo 'selected="selected"';}?>value="1">1 x</option>
                <option <? if($reg_os->qtd_parcelas_resumo == '2'){echo 'selected="selected"';}?>value="2">2 x</option>
                <option <? if($reg_os->qtd_parcelas_resumo == '3'){echo 'selected="selected"';}?>value="3">3 x</option>
                <option <? if($reg_os->qtd_parcelas_resumo == '4'){echo 'selected="selected"';}?>value="4">4 x</option>
                <option <? if($reg_os->qtd_parcelas_resumo == '5'){echo 'selected="selected"';}?>value="5">5 x</option>
                <option <? if($reg_os->qtd_parcelas_resumo == '6'){echo 'selected="selected"';}?>value="6">6 x</option>
                <option <? if($reg_os->qtd_parcelas_resumo == '7'){echo 'selected="selected"';}?>value="7">7 x</option>
                <option <? if($reg_os->qtd_parcelas_resumo == '8'){echo 'selected="selected"';}?>value="8">8 x</option>
            </select>
            
        </label>   
        	<div style="clear:both"></div>
        	<label style="width:300px;"> 
             	Observa��o: <textarea name="os_obs" id_obs="os_obs" rows="5"><?=$reg_os->os_obs?></textarea>
             </label>
      </div>
       
     </fieldset>

<!-- ABA ENVIO EMAIL -->
	<fieldset id="campos_5" style="display:none">
		 <legend>
            <a onclick="aba_form(this,0)"> Ordem de Servi&ccedil;o </a>
    		<a onclick="aba_form(this,1)"> Produtos   </a>
    		<a onclick="aba_form(this,2)"> Servi&ccedil;os </a>
    		<a onclick="aba_form(this,3)"> Resumo </a>
            <a onclick="aba_form(this,7)"> Despesas </a>
            <a onclick="aba_form(this,4)"> <strong>Envio de Or&ccedil;amento</strong> </a>
          </legend>
          <?
         		$sqlCliente = mysql_fetch_object(mysql_query($t=" SELECT * FROM cliente_fornecedor WHERE id = ".$reg_os->cliente_id));
		  ?>
          <div style="clear:both; margin-top:15px;"></div>
          <label>
          	Email destino:
            <input type="text" name="emailDestino" id="emailDestino" value="<?=$sqlCliente->email?>">
          </label>
          <div style="clear:both;"></div>
          <label>
          	Texto Adicional:
            <textarea name="msg" id="msg"></textarea>
          </label> 
          <div style="clear:both;"></div>
          <input type="button" value="Enviar" id="enviar_orcamento">
          <div style="clear:both; margin-top:15px;"></div>
          <label>
          	<span id="carregaEmail"></span>
          </label>      
	</fieldset>
    
<!-- ABA APROVA�AO -->
    <fieldset id="campos_6" style="display:none">
    <input type="hidden" name="situacao_aprovado" value="2">
		 <legend>
            <a onclick="aba_form(this,0)"> Ordem de Servi&ccedil;o </a>
    		<a onclick="aba_form(this,1)"> Produtos  </a>
    		<a onclick="aba_form(this,2)"> Servi&ccedil;os </a>
    		<a onclick="aba_form(this,3)"> Resumo </a>
            <a onclick="aba_form(this,7)"> Despesas </a>
            <a onclick="aba_form(this,5)"> <strong> Aprova�&atilde;o </strong> </a>
          </legend>
         <div style="clear:both"></div>
       
        <label id="date_aprovacao">Data Aprova&ccedil;&atilde;o<br/>
        	<input type="text" name="data_aprovacao" id="data_aprovacao" disabled="disabled" calendario="1" mascara="__/__/____" style="width:70px;" value="<? if($reg_os->data_aprovacao == '0000-00-00'){echo date("d/m/Y");} else if($reg_os->data_aprovacao == NULL){echo date("d/m/Y");}else{ echo dataUsaToBr($reg_os->data_aprovacao);}?>">
        </label>
        
        <div style="clear:both;"></div>
       	<label style="width:340px;" >Observa&ccedil;&atilde;o
            <!--<input type="text"  style="width:270px;" value="">-->
        	<textarea name="obs_aprovacao" id="obs_aprovacao"><?=$reg_os->obs_pagamento?></textarea>
        </label>       
        <div style="clear:both;"></div>
        <!-- fim de forma de pagamento -->      
	</fieldset>

<!-- ABA CANCELAMENTNO  -->
	<fieldset id="campos_7" style="display:none">
		 <legend>
            <a onclick="aba_form(this,0)"> Ordem de Servi&ccedil;o </a>
    		<a onclick="aba_form(this,1)"> Produtos   </a>
    		<a onclick="aba_form(this,2)"> Servi&ccedil;os </a>
    		<a onclick="aba_form(this,3)"> Resumo </a>
            <a onclick="aba_form(this,7)"> Despesas </a>
            <a onclick="aba_form(this,6)"> <strong>Cancelar O.S</strong> </a>
          </legend>
          <p>Para cancelar uma OS, � necess�rio digitar seu login e senha.</p>
          <label style="width:150px;">
           Login
              <input type="text" name="login" id="login">
            </label>
            
            <label style="width:150px;">
           Senha
              <input type="password" name="senha" id="senha">
            </label>
          <div style="clear:both;"></div>
          <label>
          Motivo<br/>
          	<textarea name="motivo_cancelamento" id="motivo_cancelamento" cols="40"><?=$reg_os->motivo_cancelamento?></textarea>
          </label>
          <div style="clear:both"></div>
            
</fieldset>
    
<!-- ABA DESPESAS -->
<fieldset id="campos_8" style="display:none">
		 <legend>
            <a onclick="aba_form(this,0)"> Ordem de Servi&ccedil;o </a>
    		<a onclick="aba_form(this,1)"> Produtos  </a>
    		<a onclick="aba_form(this,2)"> Servi&ccedil;os </a>
    		<a onclick="aba_form(this,3)"> Resumo </a>
            <a onclick="aba_form(this,7)"> <strong>Despesas</strong> </a>
          </legend>
          <label>
            	Despesas<br/>
                <input type="text" name="descricao_despesa" id="descricao_despesa" style="width:300px;" <?=$disabled?> />
            </label>
            <label>
            	QTD<br/>
            	<input type="text" name="qtd_despesa" id="qtd_despesa" style="width:50px;" <?=$disabled?> sonumero="1" maxlength="6" value="1">
            </label>
             <label>
            	Valor<br/>
            	<input type="text" name="valor_despesa" id="valor_despesa" style="width:80px;" <?=$disabled?> decimal="2"   />
            </label>
            <label style="margin-top:3px;"><br/>
            	<img src="../fontes/img/mais.png" id="click_despesas">
            </label>
			<div style="clear:both"></div>
            <?php
            $sql_despesa=mysql_query(" SELECT * FROM os_custo WHERE os_id = '".$reg_os->id."' AND vkt_id = '$vkt_id'");
			?>
            
            <table cellpadding="0" cellspacing="0" width="70%" >
                	<thead>
                        <tr>
                          <td width="300" style="border-left:1px solid #CCC;">Despesas</td>
                          <td width="80">QTD</td>
                          <td width="140">Valor Despesa</td>
                          <td width="160">Total Item</td>
                          <td width="50"></td>
                        </tr>
               	    </thead>
                    <tbody id="item_despesas">

                    </tbody>
                    <tbody>
                    <?
					  while($item_depesa=mysql_fetch_object($sql_despesa)){
						$cor++;
						if($cor%2){$sel='class="al"';}else{$sel='class="odd"';}
						$total_finalItemDespesa += $item_depesa->total_item;
					?>
                    	   <tr <?=$sel?> id="aqui">
                              <td>
                                <input type="hidden" name="os_custo_id[]" id="os_custo_id" value="<?=$item_depesa->id?>">
                                <input type="hidden" name="item_controle[]" id="item_controle" value="update">
                                <input type="hidden" name="id_item_despesa[]" id="id_item_despesa" size="4" value="<?=$item_depesa->id?>">
                                <input type="hidden" name="os_id_despesa[]" id="os_id_despesa" size="5" value="<?=$item_depesa->os_id?>">
                                <input type="text" style="height:13px;"  name="descricao_despesas_item[]" value="<?=$item_depesa->descricao?>">
                              </td>
                              <td>
							  <input type="hidden" name="qtd_despesas_item[]" value="<?=$item_depesa->qtd?>" size="5">
							  <?=$item_depesa->qtd?></td>
                              <td>
							  <input type="hidden" name="valor_despesas_item[]" value="<?=moedaUsaToBr($item_depesa->valor)?>" size="5">
							  <?=moedaUsaToBr($item_depesa->valor)?></td>
                              <td>
							  	<input type="hidden" name="total_item_despesa[]" id="total_item_despesa" size="5" value="<?=moedaUsaToBr($item_depesa->total_item)?>">
                                <input type="hidden" name="total_itemDespesaEdit[]" id="total_itemDespesaEdit" size="5" value="<?=moedaUsaToBr($item_depesa->total_item)?>">
								<?=moedaUsaToBr($item_depesa->total_item)?>
                              </td>
                              <td><img src="../fontes/img/menos.png" id="excluir_edit_despesas"></td>
                           </tr>
                    <?
								}
					?>
                    </tbody>
                    <thead>
                        <tr>
                          <td colspan="3">Total</td>
                          <td id="valor_total_despesas">
                          	<?=moedaUsaToBr($total_finalItemDespesa)?>
                          </td>
                          <td></td>
                        </tr>
               	    </thead>
                    <thead>
                        <tr>
                          <td colspan="3">Lucro</td>
                          <td id="lucro">
                          	<?=moedaUsaToBr($reg_os->valor_total-$total_finalItemDespesa)?>
                          </td>
                          <td></td>
                        </tr>
               	    </thead>
                    
             </table>
             <div style="clear:both"></div>
             
</fieldset>

<!-- ABA PAGAMENTO -->
<?php $sqlConta = mysql_fetch_object(mysql_query(" SELECT * FROM os_conta WHERE vkt_id = '$vkt_id'"));?>
<fieldset id="campos_9" style="display:none">
		<legend>
            <!--<a onclick="aba_form(this,0)"> Ordem de Servi&ccedil;o </a>
    		<a onclick="aba_form(this,1)"> Produtos  </a>
    		<a onclick="aba_form(this,2)"> Servi&ccedil;os </a>
    		<a onclick="aba_form(this,3)"> Resumo </a>
            <a onclick="aba_form(this,7)"> Despesas </a>-->
            <a onclick="aba_form(this,8)"> <strong>Pagamento</strong> </a>
          </legend>
          <!-- ATEN�AO!! Aqui nao inserir o valida_minlength="1" porque est� via javascript -->
          <input type="hidden" name="ContaID" id="ContaID" value="<?=$sqlConta->id?>"  retorno='focus|Nao Existe Conta Cadastrada'>
          <!-- forma de pagamento -->
          <div id="pg">
          <?php
		  	$formaPagamento = mysql_fetch_object(mysql_query("SELECT * FROM financeiro_movimento WHERE doc = '".$reg_os->id."' AND cliente_id = '$vkt_id' AND internauta_id = '".$reg_os->cliente_id."'"));
		    $num_parcelas = 0;
			
			 if( !empty($reg_os->id) ){
				$parcelas = mysql_query($t="SELECT * FROM financeiro_movimento WHERE cliente_id='$vkt_id' AND doc='$reg_os->id' ");
				
				$num_parcelas = mysql_num_rows($parcelas);
			 }
			 if($num_parcelas == 0){	
		?>
        <label><strong>Informe quantidade de Parcelas</strong><br/>
   			<select name="parcelas" id="parcelas" style="width:70px;" idregistro="<?=$reg_os->id?>" <?=$disabled?>>
                <option value="0"></option>
            	<option <? if($num_parcelas == '1'){echo 'selected="selected"';}?>value="1">1 x</option>
                <option <? if($num_parcelas == '2'){echo 'selected="selected"';}?>value="2">2 x</option>
                <option <? if($num_parcelas == '3'){echo 'selected="selected"';}?>value="3">3 x</option>
                <option <? if($num_parcelas == '4'){echo 'selected="selected"';}?>value="4">4 x</option>
                <option <? if($num_parcelas == '5'){echo 'selected="selected"';}?>value="5">5 x</option>
                <option <? if($num_parcelas == '6'){echo 'selected="selected"';}?>value="6">6 x</option>
                <option <? if($num_parcelas == '7'){echo 'selected="selected"';}?>value="7">7 x</option>
                <option <? if($num_parcelas == '8'){echo 'selected="selected"';}?>value="8">8 x</option>
            </select>
            
        </label> 
        <? } ?>
        <div id="info_parcela">
        <div class="container_pagamento"></div>
		  <?
              if( !empty($reg_os->id) ){
               
                $parcelas = mysql_query($t="SELECT * FROM financeiro_movimento WHERE cliente_id='$vkt_id' AND doc='$reg_os->id' ");
                $num_registros = mysql_num_rows($parcelas);
                
                $htmllista = "";
                $c=0;
                if( $num_registros > 0){ ?>
                  <table cellpadding="0" cellspacing="0" width="100%">
                      <thead>
                          <tr>    
                              <td>Descri��o</td>
                              <td>Vencimento</td>
                              <td>Valor</td>
                              <td>Status</td>
                          </tr>
                      </thead>
                  <?  
                    $i = 0;
                    while($parcela = mysql_fetch_object($parcelas)){
                       if($i%2==0){$s="class='al'";}else{$s='';} 
                   ?>
                      <tbody>
                          <tr <?=$s?> style="background:#FFF;" >
                              <td><?=$parcela->descricao?></td>
                              <td><?=dataUsaToBr($parcela->data_vencimento)?></td>
                              <td><?=moedaUsaToBr($parcela->valor_cadastro)?></td>
                              <td><?=$statusPagamento[$parcela->status]?></td>
                          </tr>
                      </tbody>      
                     <?
                    $i++; }			
                }
              ?> 
                  </table>
          <? }?>       
      </div>
        
        <!--<label style="width:100px;">
        Pago
        	<select name="pago" id="pago">
            	<option value="0">Selecione</option>
                <option <?if($reg_os->pago == 'sim'){echo 'selected="selected"';}?>value="sim">Sim</option>
                <option <?if($reg_os->pago == 'nao'){echo 'selected="selected"';}?>value="nao">N&atilde;o</option>
            </select>
        </label>-->
        <label style="width:150px; visibility:hidden;">
			Conta
			  <select name="conta_id" id="conta_id">
					<option value='0'  >Selecione 1 Conta</option> 
              <?
              $q= mysql_query("select * from financeiro_contas WHERE  cliente_vekttor_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'order by preferencial DESC,nome");
			  while($r= mysql_fetch_object($q)){
				$saldo=checaSaldo($r->cliente_vekttor_id ,$r->id );
				$saldo=number_format($saldo,2,',','.');
				if($obj->id>0){
					if($r->id==$obj->conta_id){$sel = "selected='selected'";}else{$sel = "";}
				}else{
					if($r->id==$sqlConta->conta_id){$sel = "selected='selected'";}else{$sel = "";}
				}
					echo "<option value='$r->id' $sel >$r->nome   $saldo</option>";  
				}
			  ?>
			    
		    </select>
        </label>
        <label style="width:120px;visibility:hidden;">
            
			Centro de Custos
			<select name="centro_custo_id[]" id='centro_custo_id'>
              	<?
    
				exibe_option_sub_plano_ou_centro('centro',0,$sqlConta->centro_custo_id,0);

				?>
              </select>
        </label>
        <label style="width:120px;visibility:hidden;">
			Plano de Conta
			<select name="plano_de_conta_id[]" id="plano_de_conta_id">
              	<?
					exibe_option_sub_plano_ou_centro('plano',0,$sqlConta->plano_conta_id,0);
				?>
              </select>
        </label>
        <!-- fim campos do pagamento -->
        <div style="clear:both"></div>
        <input type="hidden" name="total_da_os" id="total_da_os" readonly="readonly" value="<?=moedaUsaToBr($reg_os->valor_total)?>">
           <? 
		   $count_parcela = mysql_fetch_object(mysql_query("SELECT COUNT(*) AS qtd_parcelas FROM financeiro_movimento WHERE cliente_id='$vkt_id' AND doc='$reg_os->id'"));
		   
		   if ($count_parcela->qtd_parcelas == 0) {?>
           <table cellpadding="0" cellspacing="0" width="50%" >
                <thead>
                  <tr>
                    <td width="300">OS</td>
                    <td width="140">VALOR <?=$parcelas->qtdParcelaOS?></td>
                  </tr>
               </thead>
               <tbody>
                  
                  <!--<tr style="background:#FFF">
                    <td width="300"><strong>SOMA DAS PARCELAS</strong></td>
                    <td width="140" id="total_parcela_forma_pagamento"><?moedaUsaToBr($reg_os->valor_total)?></td>
                  </tr>-->
                  
                   <tr style="background:#FFF">
                    <td width="300"><strong>DIFEREN�A</strong></td>
                    <td width="140" id="total_parcela_diferenca"></td>
                  </tr>
                  
                  <tr style="background:#FFF">
                    <td width="300">VALOR TOTAL DA O.S </td>
                    <td width="140"><?=moedaUsaToBr($reg_os->valor_total_geral)?></td>
                  </tr>
                  
                 
                  
           	   </tbody>
         </table>
       <? }?>
        <div style="clear:both"></div> 
       
        
        <div style="clear:both"></div>
        <!--<div id="info_parcela_1" style="float:left;"></div>-->
        <div style="clear:both;"></div>
        <div class="info_parcela" style="float:left; max-height:150px; width:420px; overflow:auto"></div> 
        <!--<div style="float:left;" id="ParcelasData"></div>-->
        
        
        <div style="clear:both;"></div>
        
        <? if ($parcelas->qtdParcelaOS > 0) {?>
        <label style="border-bottom:1px solid #C9C9C9; width:360px; display:none; padding:3px" id="titulo_parcela">Informa&ccedil;&otilde;es da Parcela:</label>
        
        <label style="border-bottom:1px solid #C9C9C9; width:390px; display:block; padding:3px" id="tableDescricaoParcela">Detalhes da Parcela:</label>
        <div style="clear:both;"></div>
        
        <div>
        	<table cellpadding="0" cellspacing="0" width="50%" >
                <thead>
                        <tr >
                          <td width="300" style="border-left:1px solid #CCC;">Descri&ccedil;&atilde;o</td>
                          <td width="140">Vencimento</td>
                          <td width="160">Valor Parcela</td>
                          <td width="70">Status</td>
                        </tr>
               </thead>
               <tbody>
               <?
               		$sql = mysql_query(" SELECT * FROM financeiro_movimento WHERE doc = '".$reg_os->id."' AND cliente_id = '$vkt_id' ORDER BY data_vencimento ");				
						while($item_parcela=mysql_fetch_object($sql)){
							$total += $item_parcela->valor_cadastro;
							$cor++;
							if($cor%2){$sel='class="al"';}else{$sel='class="odd"';}
			   ?>
               			<tr <?=$sel?>>
                          <td style="border-left:1px solid #CCC;" width="300"><?=$item_parcela->descricao?></td>
                          <td width="140"><?=dataUsaToBr($item_parcela->data_vencimento)?></td>
                          <td width="160"><?=moedaUsaToBr($item_parcela->valor_cadastro)?></td>
                          <td width="70">
						  	<?
                          		if($item_parcela->status == '0')
									echo 'N&atilde;o Pago';
								else if($item_parcela->status == '1')
									echo 'Pago'
						  	?>
                          </td>
                        </tr>
               <?
						}
			   ?>
               </tbody>
               <thead>
                        <tr>
                          <td colspan="2" style="padding-right:8px" align="right">Total</td>
                          <td><?=moedaUsaToBr($total)?></td>
                          <td></td>
                        </tr>         
               </thead>
           </table>
        </div>
        <? }?>
</fieldset>

  <!-- ABA ENTREGA -->
  <fieldset id="campos_10" style="display:none">
          <legend>
              <a onclick="aba_form(this,0)"> Ordem de Servi&ccedil;o </a>
              <a onclick="aba_form(this,1)"> Produtos  </a>
              <a onclick="aba_form(this,2)"> Servi&ccedil;os </a>
              <a onclick="aba_form(this,3)"> Resumo </a>
              <a onclick="aba_form(this,9)"> <strong>Entrega</strong> </a>
            </legend>
            <label>
              Data Entrega
                  
            </label>
            <div style="clear:both"></div>
            <label>
            Informa&ccedil;&otilde;es Finais
              <textarea name="infoFinais" id="infoFinais"></textarea>
            </label>
  </fieldset>


	<fieldset id="campos_11" style="display:none">
          <legend>
              <a onclick="aba_form(this,0)"> Ordem de Servi&ccedil;o </a>
              <a onclick="aba_form(this,1)"> Produtos  </a>
              <a onclick="aba_form(this,2)"> Servi&ccedil;os </a>
              <a onclick="aba_form(this,3)"> Resumo </a>
              <a onclick="aba_form(this,10)"> <strong>Cancelamento</strong> </a>
            </legend>
            
  </fieldset>


<div  style="margin-bottom:10px;" id="fimFieldset">
<label>
	<input type="checkbox" value="1" name="orcado" id="orcado" <? if($reg_os->orcado == 'sim') echo'checked="checked"'; ?> <?=$disabled?> onchange="if(this.checked){$('#data_orcamento').show(); $('#data_orcado').removeAttr('disabled');}else{$('#data_orcamento').hide();$('#data_orcado').attr('disabled','disabled');}" >  Or�ado
</label>

<label style="display:<?=$disOrcado;?>;" id='data_orcamento'> : Data <input calendario='1' disabled="disabled" name="data_orcado" <?=$disabled?> id="data_orcado" type="text" value="<? if($reg_os->data_orcamento == '0000-00-00'){ echo date("d/m/Y");}if($reg_os->data_orcamento== NULL){echo date("d/m/Y");}else{ echo dataUsaToBr($reg_os->data_orcamento);}?>" size="8"> 
</label>
<? if($reg_os->id == 0){ ?>
<label style="display:none;" id="AprID">
	<input type="checkbox" name="aprSim" id="aprSim" value="1"> Aprovar
</label>
<? 
} //if($reg_os->situacao == '2' and $reg_os->status_os == '1' ){
?>
<label id="executadoID" style="display:none">
	<input type="checkbox"  value="3" name="executado" id="executado" onchange="if(this.checked){$('#data_executa').show();}else{$('#data_executa').hide();}" >Executado
</label>
<label style="display:none" id='data_executa'>
	: Data <input calendario='1' name="data_execucao" id="data_execucao" type="text" value="<?=date("d/m/Y")?>" size="8"> 
</label>
<? //} ?>
<label style="width:500px; display:none" id="entregaID">
  	<input type="checkbox" name="forEntrega" id="forEntrega" value="4">
	Entrega
</label>
<?
if($reg_os->situacao == '2' and $reg_os->pago == 'sim'){
	echo "<a href='#' style='float:right' id='ExInfoPg'>Informa&ccedil;&otilde;es de Parcelas </a>";
}
?>
</div>
<!-- FIM DE TODOS OS FIELDSET -->

<div style="width:100%; text-align:center" >
<? 
if($reg_os->id == 0){
	echo '<div style="float:left"><input type="checkbox" name="imprimir_ok" id="imprimir_ok" checked="checked" value="1">Imprimir ap&oacute;s cadastro</div>'; 
	
}
if($reg_os->situacao == '1'){
	echo '<input type="button" value="Enviar por E-mail" id="envio-email" style="float:left;" onclick="aba_form(this,4)">';
	echo '<input type="button" name="aprovar" id="aprovar" value="Aprova&ccedil;&atilde;o" style="float:left" onclick="aba_form(this,5)">';
	echo '<input type="button" value="Cancelamento" id="cancelamento" style="float:left;" onclick="">';
	
}
if($reg_os->situacao == '2' and $reg_os->status_os == '1'){
	echo '<input type="button" value="Enviar por E-mail" id="envio-email" style="float:left;" onclick="aba_form(this,4)">';
	echo '<input type="button" value="Pagamento" id="pagamento" style="float:left;" >';
	echo '<input type="button" value="Cancelamento" id="cancelamento" style="float:left;" onclick="">';
}
if($reg_os->situacao == '2' and $reg_os->status_os == '3'){
	echo '<input type="button" value="Enviar por E-mail" id="envio-email" style="float:left;" onclick="aba_form(this,4)">';
	echo '<input type="button" value="Entrega" id="entrega" style="float:left;" onclick="">';
	echo '<input type="button" value="Cancelamento" id="cancelamento" style="float:left;" onclick="">';
}
if(($reg_os->situacao != '2') || ($reg_os->situacao != '3') ){	
?>
<!--<input type="submit" name="action" id="finalizar" value="Finalizar" style="float:right; display:none;"> -->  
<input name="action" type="submit"  value="Salvar" id="salvar" style="float:right" <?=$disabled?> />
<? 
}
	
if($reg_os->id > 0){?>
<!--<input type='button' value='Cancelar' id='cancelar_os' style='float:left;' onclick="aba_form(this,10)"/>-->
<input type="button" value="Imprimir Or�amento" id="imp_orcamento" />
<input type="button" value="Imprimir O.S" id="imp_os" />

<? if( $vkt_id == 185 ) { ?>
<input type="button" value="Ordem Produ��o" id="imp_ordem_producao" />
<? 
	}
} 
?>
<div style="float:right;" id="info_aprovacao"></div>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>