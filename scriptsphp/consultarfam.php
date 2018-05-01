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
$familia=$_GET['familia'];
$congregacion=$_GET['congregacion'];
$a="select * from familias ORDER BY idfamilia DESC LIMIT 1";
$b=mysqli_query($con,$a) or die ("error buscando ".$a);
$m=mysqli_fetch_array($b);
$cod=$m['idfamilia'];
echo $cod;
?>