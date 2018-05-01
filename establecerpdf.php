
<?php
session_start();
$stringpdf=html_entity_decode($_POST['valorpdf']);
$_SESSION['stringpdf']=$stringpdf;