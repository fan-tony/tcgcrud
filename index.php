

<?php
include 'config.php'; #access the database
#include 'main.css'; #any necesssary css will be stored in this file

?>


<head><link rel="stylesheet" href="main.css" type="text/css"></head>

<h2>Yu-Gi-Oh! Card Database</h2>

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

foreach($db->query("SELECT * FROM $table") as $row) {
	echo "<tr>";
		echo "<td style='text-align:center'>". $row['Name'] . "</td>";
		echo "<td style='text-align:center'>". $row['Type'] . "</td>";
		echo "<td style='text-align:center'>". $row['Edition'] . "</td>";
		echo "<td style='text-align:center'>". $row['Amount'] . "</td>";
		echo "<td style='text-align:center'><a href = 'update.php'>". 'Edit' . "</a></td>"; #Edit the selected card. 'Update' in CRUD
		echo "<td style='text-align:center'><a href = 'delete.php'>". 'Delete' . "</a></td>"; #Delete the selected card. 'Delete' in CRUD
	echo "</tr>";
}

echo "</table>";

?>
