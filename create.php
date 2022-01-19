<?php
include 'config.php'; #access the database
include 'main.css'; #any necesssary css will be stored in this file

#variables to be used in the form initialized as empty string
$name =$type = $edition = $amount = "";
$name_err = $amount_err = "";

#request method post means that a form has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

	#user proof the name. the name can't be an empty field
	$input_name = trim($_POST["name"]);
	if(empty($input_name)){
        	$name_err = "Please enter a name.";
	}else{
		$name = $input_name;
	}

	#type and edition are dropdowns so they can't have errors because it must be selected
	$type = trim($_POST["type"]);
	$edition = trim($_POST["edition"]);

	#user proof the number to be only positive
	$input_amount = trim($_POST["amount"]);
	if (!ctype_digit($input_amount)){
		$amount_err = "Please enter a positive integer number.";
	}elseif(empty($input_amount)){
		$amount_err = "Please enter an amount.";
	}else{
		$amount = trim($_POST["amount"]);
	}

	#if there were no errors in the submitted fields, go ahead with the sql query
	if (empty($name_err) && empty($amount_err)){			
		
		#first check if this entry already exists, if it does then don't insert
		$sql = "SELECT * FROM $table WHERE Name=? and Type=? AND Edition = ?";
		$stmt = $db -> prepare($sql);
		$stmt ->execute([$name,$type,$edition]);
		if($stmt->rowCount() >0){
			echo"This card already exists in the database.";	
		}

		else{
			$sql = "INSERT INTO $table (Name,Type,Edition,Amount) VALUES(?,?,?,?)";
			$stmt = $db -> prepare($sql);
			$stmt ->execute([$name,$type,$edition,$amount]);

			#go back to landing page because of successful submission
			header("location: index.php");
			exit();
		}
	}
}
?>

<!DOCTYPE html>
<h2>Create Card Record</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<div>
		<label>Name: </label>
		<input type="text" name="name" value="<?php echo $name; ?>">
		<span><?php echo $name_err;?></span>
	</div>
	<div>
		<label>Type: </label>
		<select name="type" value="<?php echo $type; ?>">
			<option>Monster</option>
			<option>Spell</option>
			<option>Trap</option>
		</select>
	</div>
	<div>
		<label>Edition</label>
		<select name="edition" value="<?php echo $edition; ?>">
			<option>1st</option>
			<option>Unlimited</option>
			<option>Limited</option>
			<option>Duel Terminal</option>
		</select>

	</div>
	<div>
		<label>Amount</label>
		<input type="number" name="amount" min="0" value="<?php echo $amount; ?>">
		<span><?php echo $amount_err;?></span>
	</div>

	<button type="submit">Submit</button>
	<a href="index.php" class="btn btn-secondary ml-2">Cancel</a>

</form>


