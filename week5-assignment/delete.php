<?php
session_start();

if ( ! isset($_SESSION['name']) ) {
	die('ACCESS DENIED');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: logout.php');
    return;
}

$status = false;

if ( isset($_SESSION['status']) ) {
	$status = $_SESSION['status'];
	$status_color = $_SESSION['color'];

	unset($_SESSION['status']);
	unset($_SESSION['color']);
}

require_once "pdo.php";

$name = htmlentities($_SESSION['name']);

$_SESSION['color'] = 'red';


if ( isset($_POST['delete']) && isset($_POST['autos_id']) ) {
	$sql = "DELETE FROM automobiles WHERE autos_id = :zip"; 
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(':zip'=>$_POST['autos_id']));
    $_SESSION['status'] = 'Record deleted';
    $_SESSION['color'] = 'green';
    header('Location: index.php');
    return;
	//$_SESSION['success'] = 'Record deleted';
}
$stmt = $pdo->prepare("SELECT make, model, autos_id FROM automobiles where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
	$_SESSION['error'] = 'Bad value for autos_id';
	header('Location: index.php');
	return;	
}
?>
<html>
<head>
	<title>Flavia Oliveira Santos de Sa Lisboa 92fe0f14</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
</head>
<body>
  	<p>Confirm: Deleting <?= htmlentities($row['make']) ?> - <?= htmlentities($row['model']) ?></p>
	
	<form method="post">
		<input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
		<input type="submit" value="Delete" name="delete" class="btn btn-primary">
		<a href="index.php" class="btn btn-default">Cancel</a>
	</form>
</body>
</html>		