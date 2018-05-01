<table width="100%" border="0" cellspacing="3">
  
</table>
<? 
date_default_timezone_set('America/Argentina/Buenos_Aires');
$mes=date("m",strtotime("-2 month"));
echo $mes;
$anio=date("Y");
if ($anio==2015)
{
	echo "Este es el año 2015";
}
?>
