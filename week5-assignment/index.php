<?php
session_start();

$login = false;

if (isset($_SESSION['name']) ) {
	$login = true;
	$status = false;

	if ( isset($_SESSION['status']) ) {
		$status = htmlentities($_SESSION['status']);
		$status_color = htmlentities($_SESSION['color']);

		unset($_SESSION['status']);
		unset($_SESSION['color']);
	}

	require_once "pdo.php";

	$autos = [];
	$all_autos = $pdo->query("SELECT * FROM automobiles");

	while ( $row = $all_autos->fetch(PDO::FETCH_OBJ) ) 
	{
    	$autos[] = $row;
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
			<h1>Welcome to the Automobiles Database</h1>
			<?php if (!$login) : ?>
				<p>
					<a href="login.php">Please log in</a>
				</p>
				<p>
					Attempt
					<a href="add.php">add data</a> 
					without logging in.
				</p>
			</div>	
			<?php else : ?>
				<?php
	                if ( $status !== false ) 
	                {
	                    echo(
	                        '<p style="color: ' .$status_color. ';" class="col-sm-10">'.
	                            $status.
	                        "</p>\n"
	                    );
	                }
	         ?>

		<div class="container">
            <?php if(empty($autos)) { ?>
            		<p>No rows found</p>
 			<?php }  else { ?>

            <?php //if(!empty($autos)) : ?>
                  <table class="table-condensed table-bordered">
                    <?php 
                        $stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM automobiles");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr><td>";
                            echo(htmlspecialchars($row['make']));
                            echo "</td><td>";
                            echo(htmlspecialchars($row['model']));
                            echo "</td><td>";
                            echo($row['year']);
                            echo "</td><td>";
                            echo($row['mileage']);
                            echo "</td><td>";
            echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
			echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
                            echo "</td></tr>\n";
                        }                      
                    ?>
                  </table><br>
            <?php } ?>
 	            <p>
				<a href="add.php" class="btn btn-primary">Add New Entry</a>
				<a href="logout.php" class="btn btn-default">Logout</a>
            </p>

            <?php endif; ?>
        </div>

	</body>
</html>