<?php

session_start();

if ( ! isset($_SESSION['name']) ) {
	die('Not logged in');
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

if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) ) {
    if ( strlen($_POST['make']) < 1) {
        $_SESSION['status'] = "Make is required";
        header("Location: add.php");
        return;
    } else {
        if ( !is_numeric($_POST['year']) || !is_numeric($_POST['mileage']) ) {
                $_SESSION['status'] = "Mileage and year must be numeric";
                header("Location: add.php");
                return; 
        } else {
                $make_t = htmlentities($_POST['make']);
                $year_t = htmlentities($_POST['year']);
                $mileage_t = htmlentities($_POST['mileage']);

                $sql = "INSERT INTO autos (make, year, mileage)
                            VALUES (:make, :year, :mileage)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':make' => $make_t,
                    ':year' => $year_t,
                    ':mileage' => $mileage_t));

                $_SESSION['status'] = 'Record inserted';
                $_SESSION['color'] = 'green';

                header('Location: view.php');
                return;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Flavia Oliveira Santos de Sa Lisboa 92fe0f14</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
</head>
<body>
<div class="container">
    <h1>Tracking Autos for <?php echo $name; ?></h1>
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
    <input type="text" name="make" size="60"/></p>
    <p>Year:
    <input type="text" name="year"/></p>
    <p>Mileage:
    <input type="text" name="mileage"/></p>
    <input class="btn btn-primary" type="submit" value="Add">
    <input class="btn" type="submit" name="logout" value="Cancel">
    </form>

</div>
</body>
</html>