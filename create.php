<?php
include 'config.php'; #access the database
#include 'main.css'; #any necesssary css will be stored in this file

#variables to be used in the form initialized as empty string
$name =$type = $edition = $amount = "";
$name_err = $amount_err = "";

#request method post means that a form has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

	#$stmt = $db -> query("INSERT INTO tcg.yugioh (Name,Type,Edition,Amount) VALUES ('Dark Magician','Monster', 'Unlimited', 3)");

	
	#user proof the name, can't be empty
	if(empty($input_name)){
        	$name_err = "Please enter a name.";
	} else{
		$input_name = trim($_POST["name"]);
	}
	
	$input_type = trim($_POST["type"]);
	$input_edition = trim($_POST["edition"]);

	#user proof the number to be only positive
	if (!ctype_digit($input_amount)){
		$amount_err = "Please enter a positive integer number.";
	}elseif(empty($input_amount)){
		$amount_err = "Please enter an amount.";
	}else{
		$input_amount = trim($_POST["amount"]);
	}
	
	if (empty($name_err) && empty($amount_err)){
		$stmt = $db -> query("INSERT INTO tcg.yugioh (Name,Type,Edition,Amount) VALUES ('Dark Magician','Monster', 'Unlimited', 3)");
		#THIS BELOW IS BROKEN
	/*
		$sql = "INSERT INTO $table (Name,Type,Edition,Amount) VALUES(:name,:type,:edition,:amount);";
	
		#$db -> query("INSERT INTO yugioh (Name,Type,Edition,Amount) VALUES ('Dark Magician', 'Unlimited', 3);");
		$stmt = $db -> prepare($sql)->execute([$input_name, $input_type,$input_edition,$input_amount]);
	 */
		


		/*
		$stmt = $db ->prepare("INSERT INTO $table (Name,Type,Edition,Amount) VALUES(:name,:type,:edition,:amount)");
		$stmt ->bindParam(':name',$name);
		$stmt ->bindParam(':type',$type);
		$stmt ->bindParam(':edition',$edition);
		$stmt ->bindParam(':amount',$amount);
	
		$stmt ->execute();
		 */

	}	

}
elseif (empty($_POST)){
?>

<!DOCTYPE html>
<h2>Create Record</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<div>
		<label>Name: </label>
               	<input type="text" name="name" value="<?php echo $name; ?>">
	</div>
	<div>
		<label>Type: </label>
		<select name="type" value="<?php echo $type; ?>">
			<option>Monster</option>
			<option>Spell</option>
			<option>Trap</option>
			<option>Pendulum</option>
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
	</div>

	<button type="submit">Submit</button>
	<!-- <input type="submit" value="Submit"> -->
	<a href="index.php" class="btn btn-secondary ml-2">Cancel</a>

</form>

<?php } ?>
<!--

        <div class="form-group">
        	<label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
 </form>
-->
