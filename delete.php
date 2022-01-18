<?php
include 'config.php'; #access the database
include 'main.css'; #any necesssary css will be stored in this file

#variables to be used in the form initialized as empty string
$name =$type = $edition = $amount = "";
$name_err = $amount_err = "";

#request method post means that a form has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

	$sql = "DELETE FROM $table where ID = ?";
	$stmt = $db -> prepare($sql);
	$stmt ->execute([$_POST["id"]]);

	header("location: index.php");
	exit();

}

?>

<!DOCTYPE html>
<h2>Delete Card Record</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
        <p>Are you sure you want to remove this card?</p>
       	<p>
               	<input type="submit" value="Yes">
		<a href="index.php">No</a>	
	</p>
</form>


