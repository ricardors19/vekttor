<?php
include("../../../_config.php");
include("../../../_functions_base.php");

$id = $_POST['id'];

$extensao = mysql_fetch_object(mysql_query("SELECT extensao FROM eleitoral_emailmarketing_imagens WHERE id='$id'"));

mysql_query("DELETE FROM eleitoral_emailmarketing_imagens WHERE id='$id'");
unlink("img/$id.$extensao->extensao");
echo $id;
?>