<?
session_start();
$idusuario=$_SESSION["idusrecor"];
$Categoria=$_SESSION["Categoriarec"];
$Congre = $_SESSION["Congregacion"];
$servidor=$_SESSION['servidor'];
$dbusuario=$_SESSION['dbusuario'];
$dbcontrasena=$_SESSION['dbcontrasena'];
$nomdb=$_SESSION['nomdb'];
$mendb=$_SESSION['condb'];
$con=mysqli_connect($servidor,$dbusuario,$dbcontrasena);
mysqli_select_db($con,$nomdb) or die ($mendb);

$ab="SELECT * FROM records ORDER BY Publicador DESC ";
$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
$cantrecord=0;
$idactual=0;
while  ($mrecca=mysqli_fetch_array($ba))
{
	$idrecord=$mrecca['idrecord'];
	$idpub=$mrecca['Publicador'];
		$ad="SELECT * FROM publicadores WHERE Idpublicadores=$idpub";
		$da=mysqli_query($con,$ad) or die ("error buscando ".$ad);
		$mpubgr=mysqli_fetch_array($da);
		$Grupopub=$mpubgr['Grupo'];
		$ad="UPDATE records SET Grupo=$Grupopub WHERE idrecord=$idrecord";
		$da=mysqli_query($con,$ad) or die ("error buscando ".$ad);
}
?>