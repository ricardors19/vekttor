<?
//Includes
// configura��o inicial do sistema
include("../../../../_config.php");
// fun��es base do sistema
include("../../../../_functions_base.php");
// fun��es do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:700px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>IRPF</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
        
       
        <label style="width:90px;">
        	Menor Sal�rio
		<input type="text" name="menor_salario" valida_minlength="3" value="<?=moedaUsaToBr($irpf->valor_minimo)?>" decimal="2"/>
        </label>
        
        <label style="width:90px;">
        	Maior Sal�rio
		<input type="text" name="maior_salario" valida_minlength="3" value="<?=moedaUsaToBr($irpf->valor_maximo)?>" decimal="2" sonumero="1"/>
        </label>
        <label style="width:70px;">
        	Al�quota (%)
		<input type="text" name="valor_aliquota" valida_minlength="3" value="<?=moedaUsaToBr($irpf->percentual_aliquota)?>" decimal="2" sonumero="1"/> 
        
        </label>
        <label style="width:90px;">
        	Valor Dedu�ao
		<input type="text" name="valor_deducao" valida_minlength="3" value="<?=moedaUsaToBr($irpf->valor_deducao)?>" decimal="2" sonumero="1"/>
        </label>
        	       
        
	</fieldset>
	<input name="id" type="hidden" value="<?=$irpf->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($irpf->id > 0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>