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
$hermano=$_GET['hermano'];
$a="insert into publicadores (Nombre,Bautizado,Fechanac,Fechabau,Grupo,Unguotro,Sexo,Anciano,Siervomin,Precreg,Familia) values ('$hermano','SI','2000-01-01','2000-01-01',1,'OO','M','NO','NO','NO',$familia)";
$b=mysqli_query($con,$a) or die ("error buscando ".$a);
echo "agregado";
?>