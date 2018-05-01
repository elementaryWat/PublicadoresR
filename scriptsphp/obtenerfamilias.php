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
$congregacion=$_GET['congregacion'];
$a="select * from familias where Congregacion=$congregacion ORDER BY Nombrefam ASC";
$b=mysqli_query($con,$a) or die ("error buscando ".$a);
$cantpub=mysqli_num_rows($b);	
if ($cantpub!=0){
echo '<select name="familiass" data-native-menu="false">';
            while ($ml=mysqli_fetch_array($b)){
            echo '<option value="'.$ml['idfamilia'].'">'.$ml['Nombrefam'].'</option>';
            }
echo '</select>';
 } else
 {
	 echo "no";
}
?>