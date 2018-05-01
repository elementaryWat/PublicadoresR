<?
session_start();
$Publicador=$_GET['Publicador'];
$Mes=$_GET['Mes'];
$Anio=$_GET['Anio'];
$Publicaciones=$_GET['Publicaciones'];
$Videos=$_GET['Videos'];
$Horas=$_GET['Horas'];
$Revisitas=$_GET['Revisitas'];
$Estbib=$_GET['Estbib'];
$Precaux=$_GET['Precaux'];
$Precreg=$_GET['Precreg'];
$Notas=$_GET['Notas'];
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fechaagre=date("Y-m-d");
$hora=date("G:i:s");
$fechaagre.=" ".$hora;	
if ($Precaux=="SI" || $Precreg=="SI")
{
	if ($Notas=="-" || $Notas==" - " || $Notas==" -" || $Notas=="- ")
	{
		if ($Precaux=="SI")
		{
			$Notas="Precursorado auxiliar";
		}
		if ($Precreg=="SI")
		{
			$Notas="Precursorado regular";
		}
	}
	else
	{
		if ($Precaux=="SI")
		{
			$Notas="Precursorado auxiliar - ".$Notas;
		}
		if ($Precreg=="SI")
		{
			$Notas="Precursorado regular - ".$Notas;
		}
	}
}
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
$ab="select * from publicadores where Idpublicadores=$Publicador";
$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
$mpub=mysqli_fetch_array($ba);
$Grupo=$mpub['Grupo'];
$aa="insert into records2 (Publicador,Mes,Anio,Publicaciones,Videos,Horas,Revisitas,Estbib,Notas,Precaux,Precreg,Grupo) values ($Publicador,$Mes,$Anio,$Publicaciones,$Videos,$Horas,$Revisitas,$Estbib,'$Notas','$Precaux','$Precreg',$Grupo)";
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);	
$aa="insert into notificaciones (Publicador,Tipo,Fecha,Congregacion) values ($Publicador,'MOD','$fechaagre',$Congre)";	
$bb=mysqli_query($con,$aa) or die ("error insertando ".$aa);

echo "Se ha insertado este informe de manera correcta";
?>


	