

<?php
include 'config.php'; #access the database
include 'main.css'; #any necesssary css will be stored in this file

$filter="";#filter will store the string applied to the sql query to filter the select statement
?>

<head><link rel="stylesheet" href="main.css" type="text/css"></head>

<?php
#request method post means that a form has been submitted. For this page, it means to apply a filter
if($_SERVER["REQUEST_METHOD"] == "POST"){
	#each data column for a card is mutually exclusive (you can't have a card that is 1st edition and unlimited at the same time. This means if multiple options are selected for one data column, the user must intend to select any card with that attribute (OR operation). If combined with another data column (e.g the type as monster/spell/trap) then the card selected must have both attributes (AND operation).

	#add sql query strings to filter the select statement for the selected filters on edition
	if(!empty($_POST['ed_filter'])) {
		$filter = $filter . "(";
		foreach($_POST['ed_filter'] as $edition) {
			$filter .= "Edition = '$edition' OR ";	    
		}
		$pattern = '/(OR )$/i';
		$filter = preg_replace($pattern,'',$filter); #remove the last OR from the above concatenation

		$filter =  $filter.")"; #end this filter
	}

	#combine conditional statements with AND
	if(!empty($_POST['ed_filter']) && !empty($_POST['type_filter'])) {
		$filter = $filter . " AND" ;
	}

	#add to the filter the selected types
	if(!empty($_POST['type_filter'])) {
		$filter = $filter . "(";
		foreach($_POST['type_filter'] as $type) {
			$filter .= "Type = '$type' OR "; 
		}
		$pattern = '/(OR )$/i';
		$filter = preg_replace($pattern,'',$filter); #remove the last OR from the above concatenation
		$filter = $filter . ")" ; #end this filter
	}
	
	#if there is actually a filter, supply the WHERE clause and then remove the final 'AND' in the string
	if (!empty($filter)){
		$filter = "WHERE " . $filter;
	}
}

?>

<h2>Yu-Gi-Oh! Card Database</h2><br>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<table align=left style='margin:0 auto;border-spacing: 0px;' rules=none>
		<caption> Filter Options </caption>
		<div>
			<tr>	
				<td><input type="checkbox" name="ed_filter[]" value="1st">1st</td>
				<td><input type="checkbox" name="type_filter[]" value="Monster">Monster</td>
		</div>	
			</tr>
		<div>
			<tr>	
				<td><input type="checkbox" name="ed_filter[]" value="Unlimited">Unlimited</td>
				<td><input type="checkbox" name="type_filter[]" value="Spell">Spell</td>
			</tr>
		</div>
		<div>
			<tr>	
				<td><input type="checkbox" name="ed_filter[]" value="Limited">Limited</td>
				<td><input type="checkbox" name="type_filter[]" value="Trap">Trap</td>
			</tr>
		</div>
		<div>
			<tr>	
				<td><input type="checkbox" name="ed_filter[]" value="Duel Terminal">Duel Terminal</td>
				<td><button type="submit" />Apply FIlter</button></td>	
			</tr>
		</div>	
	</table><br><br><br>

	
</form>	
<br><br>


<!-- Link to page to allow for addition of new cards. This is the 'Create' in CRUD -->
<a href="create.php" style="float:right;"> Add Card</a>

<?php
#display the table containing the database's information - this serves as the 'Review' in CRUD
echo "<table border = '1|0' style='margin:0 auto;width:100%;border-spacing: 0px;'>
	<th>Name</th>
	<th>Type</th>
	<th>Edition</th>
	<th>Amount</th>
	<th colspan=2>Action</th>
";

foreach($db->query("SELECT * FROM $table $filter ORDER BY Name") as $row) {
	
	echo "<tr>";
		echo "<td style='text-align:center'>". $row['Name'] . "</td>";
		echo "<td style='text-align:center'>". $row['Type'] . "</td>";
		echo "<td style='text-align:center'>". $row['Edition'] . "</td>";
		echo "<td style='text-align:center'>". $row['Amount'] . "</td>";
		echo "<td style='text-align:center'><a href = 'update.php?id=". $row['ID'] ."'>". 'Edit' . "</a></td>"; #Hyperlink to edit the selected card. 'Update' in CRUD
		echo "<td style='text-align:center'><a href = 'delete.php?id=". $row['ID'] ."'>". 'Delete' . "</a></td>"; #Hyperlink to delete the selected card. 'Delete' in CRUD
	echo "</tr>";
}

echo "</table>";
?>
