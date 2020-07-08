<?php
require_once "pdo.php";

if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}

$failure = false;  

// insert model
if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) ) {
	if ( strlen($_POST['make']) < 1) {
		$failure = "Make is required";
	} else {
		if ( !is_numeric($_POST['year']) || !is_numeric($_POST['mileage']) ) {
			$failure = "Mileage and year must be numeric";
		} else {
			$sql = "INSERT INTO autos (make, year, mileage)
						VALUES (:make, :year, :mileage)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(
				':make' => $_POST['make'],
				':year' => $_POST['year'],
				':mileage' => $_POST['mileage']));
			$failure = "Record inserted";
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Flavia Oliveira Santos de Sa Lisboa 5e8c8476 - Automobile Tracker</title>
</head>
<body>
<div class="container">
	<h1>Tracking Autos for <?php echo htmlentities($_GET['name']); ?></h1>
<?php
if ( $failure !== false && $failure != "Record inserted" ) {
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
} else {
	echo('<p style="color: green;">'.htmlentities($failure)."</p>\n");
}

?>
<form method="post">
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" value="Add">
<input type="submit" name="logout" value="Logout">
</form>

<h2>Automobiles</h2>
  <table border="1" cellpadding="5">
	<?php 
		$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			echo "<tr><td>";
			echo(htmlspecialchars($row['make']));
			echo "</td><td>";
			echo($row['year']);
			echo "</td><td>";
			echo($row['mileage']);
			echo "</td></tr>\n";
		}
	?>
  </table>
</div>
</html>

