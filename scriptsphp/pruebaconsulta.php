<?
session_start();
$publicadorsino="NO";
$precregsino="NO";
$precauxsino="SI";
 if ($publicadorsino=="SI")
 {
	 $conpublicador='OR (`Precreg` =  "NO" AND  `Precaux` =  "NO")';
}
else
{
	$conpublicador='';
}

if ($precregsino=="SI")
 {
	 $conprecreg='(Precreg =  "SI" AND Precaux =  "NO")';
}
else
{
	$conprecreg='(Precreg =  "SI" AND Precaux =  "SI")';
}

if ($precauxsino=="SI")
 {
	 $conpreaux='OR (Precreg =  "NO" AND Precaux =  "SI")';
}
else
{
	$conpreaux='OR (Precreg =  "SI" AND Precaux =  "SI")';
}


$consulta="SELECT * FROM  records WHERE  Mes=1 AND  Anio=2015 AND ($conprecreg  $conpreaux  $conpublicador)";
echo "La consulta a la base de datos es ".$consulta;
 ?>