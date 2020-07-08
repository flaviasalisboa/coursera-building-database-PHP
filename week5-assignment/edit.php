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

if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) 
    && isset($_POST['model']) && isset($_POST['autos_id']) ) {
    if ( strlen($_POST['make']) < 1 && strlen($_POST['model']) < 1) {
        $_SESSION['status'] = "All fields are required";
        header("Location: edit.php?autos_id=" . htmlentities($_REQUEST['autos_id']));
        return;
    } else {
        if ( !is_numeric($_POST['year']) || !is_numeric($_POST['mileage']) ) {
                $_SESSION['status'] = "Mileage and year must be numeric";
                header("Location: edit.php?autos_id=" . htmlentities($_REQUEST['autos_id']));
                return; 
        } else {
                $make_t = htmlentities($_POST['make']);
                $model_t = htmlentities($_POST['model']);
                $year_t = htmlentities($_POST['year']);
                $mileage_t = htmlentities($_POST['mileage']);

                $sql = "UPDATE automobiles SET make = :make, 
                        model = :model, year = :year, mileage = :mileage
                        WHERE autos_id = :autos_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':make' => $make_t,
                    ':model' => $model_t,
                    ':year' => $year_t,
                    ':mileage' => $mileage_t,
                    ':autos_id' => $_POST['autos_id']));

                //$_SESSION['success'] = 'Record updated';
                $_SESSION['status'] = 'Record updated';
                $_SESSION['color'] = 'green';
                header('Location: index.php');
                return;
        }
    }
}
$stmt = $pdo->prepare("SELECT * FROM automobiles where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['status'] = 'Bad value for autos_id';
    header('Location: edit.php');
    return; 
}
$ma = htmlentities($row['make']);
$mo = htmlentities($row['model']);
$y = htmlentities($row['year']);
$mi = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Flavia Oliveira Santos de Sa Lisboa 92fe0f14</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
</head>
<body>
<div class="container">
    <h1>Editing automobile - <?php echo $name; ?></h1>
    <?php
        if ( $status !== false ) {
            echo('<p style="color: ' .$status_color. ';" class="col-sm-10 col-sm-offset-2">'.
                htmlentities($status).
                "</p>\n"
                );
        }
    ?>

    <form method="post">
    <p>Make:
    <input type="text" name="make" size="40" value="<?= $ma ?>"/></p>
    <p>Model:
    <input type="text" name="model" size="40" value="<?= $mo ?>"/></p>
    <p>Year:
    <input type="text" name="year" value="<?= $y ?>"/></p>
    <p>Mileage:
    <input type="text" name="mileage" value="<?= $mi ?>"/></p>
    <input type="hidden" name="autos_id" value="<?= $autos_id ?>">
    <input class="btn btn-primary" type="submit" value="Save">
    <a href="index.php" class="btn btn-default">Cancel</a>    
    </form>

</div>
</body>
</html>