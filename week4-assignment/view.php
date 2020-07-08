<?php
// Week 4 - assignment Autos Post-redirect

session_start();

if ( ! isset($_SESSION['name']) ) {
	die('Not logged in');
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

$autos = [];
$all_autos = $pdo->query("SELECT * FROM autos");

while ( $row = $all_autos->fetch(PDO::FETCH_OBJ) ) 
{
    $autos[] = $row;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Flavia Oliveira Santos de Sa Lisboa 92fe0f14 - Login Page</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    </head>
    <body>
        <div class="container">
            <h1>Tracking Autos for <?php echo $name; ?></h1>

            <p>
				<a href="add.php" class="btn btn-primary">Add New</a>
				<a href="logout.php" class="btn btn-default">Logout</a>
            </p>

            <?php if(!empty($autos)) : ?>
                <h2>Automobiles</h2>
                  <table class="table-condensed table-bordered">
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
            <?php endif; ?>

        </div>
    </body>
</html>