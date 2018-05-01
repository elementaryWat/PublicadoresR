<? 
session_start();
$usuario=$_GET['usuario'];
$pass=$_GET['pass'];
$_SESSION['servidor']="mysql.hostinger.com.ar";
$_SESSION['dbusuario']="u300421416_root";
$_SESSION['dbcontrasena']="registrospnb";
$_SESSION['nomdb']="u300421416_regis";
$_SESSION['condb']="no se ha podido encontrar la base de datos";
$servidor=$_SESSION['servidor'];
$dbusuario=$_SESSION['dbusuario'];
$dbcontrasena=$_SESSION['dbcontrasena'];
$nomdb=$_SESSION['nomdb'];
$mendb=$_SESSION['condb'];
$con=mysqli_connect($servidor,$dbusuario,$dbcontrasena);
mysqli_select_db($con,$nomdb) or die ($mendb);
$incor=true;$cor=false;
if (is_numeric($usuario) && $usuario!="0")
{
	$a="SELECT * FROM `publicadores` WHERE `DNI` = $usuario";
	$b = mysqli_query ($con,$a)
	or die ("error buscando".$a);
	$cant=mysqli_num_rows($b);
	$m=mysqli_fetch_array ($b);	
	if ($cant <> 0 ) {
		$Idpublicador=$m['Idpublicadores'];
		$Nombre=$m['Nombre'];
		$DNI=$m['DNI'];
		$Passpub=$m['Passpub'];
		$Grupo=$m['Grupo'];
		$Precreg=$m['Precreg'];
		$Familia=$m['Familia'];
		if ($Passpub=="")
		{
			if ($pass==$DNI)
			{
				$cor=true;
			}
		}
		else if ($pass==$Passpub)
		{
			$cor=true;
		}
		if ($cor)
		{
			$a="SELECT * FROM `familias` WHERE `idfamilia` = $Familia";
			$b = mysqli_query ($con,$a);
			$mfam=mysqli_fetch_array ($b);	
			$Congre=$mfam['Congregacion'];
			$_SESSION["Idpublicador"] = $Idpublicador;
			$_SESSION["Nombre"] = $Nombre;
			$_SESSION["DNI"] = $DNI;
			$_SESSION["Passpub"] = $Passpub;
			$_SESSION["Grupo"] = $Grupo;
			$_SESSION["Precreg"] = $Precreg;
			$_SESSION["Familia"] = $Familia;
			$_SESSION["Congregacion"] = $Congre;
			echo "pub";
			$incor=false;
		}
	} 
}

if ($incor)
{
	$a="select * from usuarios where Usuario = '$usuario'";
	$b = mysqli_query ($con,$a)
	or die ("error buscando".$a);
	$cant=mysqli_num_rows($b);
	$m=mysqli_fetch_array ($b);
	if ($cant <> 0 ) {
		$idusuario=$m['Iduser'];
		$usuario=$m['Usuario'];
		$passus=$m['Pass'];
		$Categoria=$m['Categoria'];
		$Nombre=$m['Nombre'];
		$Grupo=$m['Grupo'];
		$Apellido=$m['Apellido'];
		$Email=$m['Email'];
		$Congre=$m['Congregacion'];
		if ($pass == $passus ) {
		$_SESSION["idusrecor"] = $idusuario;
		$_SESSION["Congregacion"] = $Congre;
		$_SESSION["Usuariorec"] = $usuario;
		$_SESSION["Pass"] = $passus;
		$_SESSION["Categoriarec"] = $Categoria;
		$_SESSION["Email"]=$Email;
		$_SESSION["Nombre"]=$Nombre;
		$_SESSION["Grupo"]=$Grupo;
		$_SESSION["Apellido"]=$Apellido;
		echo "adm";
		} else {
		echo "no";
		}
	} else {
	echo "no";
	}
}

?>