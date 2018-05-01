<?
mysqli_connect("mysql.hostinger.com.ar","u300421416_root","registrospnb");
mysqli_select_db("u300421416_regis") or die ("no se ha podido encontrar la base de datos");
echo "La conexion se ha realizado de forma exitosa";
echo "Hola";
	$aa="select * from familias ORDER BY Nombrefam Asc";	
	$bb=mysql_query($aa) or die ("error buscando ".$aa);
	echo '<div id="acordeonpublicadores">';
		while ($mref=mysql_fetch_array($bb))
		{
		echo $mref['Nombrefam'];
		}
?>