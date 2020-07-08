<?php 
// Week 2 - assignment Autos database

if ( isset($_POST['cancel'] ) ) {
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; // php123

$failure = false;  
date_default_timezone_set('America/Sao_Paulo');
$date = date('d-m-Y H:i:s');

if ( isset($_POST['who']) && isset($_POST['pass']) ) {
    if ( strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1 ) {
        $failure = "Email and password are required";
    } else {
        // check if there is an @ at username
        if(strpos($_POST['who'], '@') !== false){
            // test password to see if it is ok
            $check = hash('md5', $salt.$_POST['pass']);
            if ( $check == $stored_hash ) {
                // Redirect the browser to autos.php
                // The error_log is saved in the file error.php
                error_log($date." Login success ".$_POST['who'].PHP_EOL,3,"error.php");
                header("Location: autos.php?name=".urlencode($_POST['who']));
                return;
            } else {
                $failure = "Incorrect password";
                error_log($date." Login fail ".$_POST['who']." $check".PHP_EOL,3,"error.php");
            }
        } else {
            $failure = "Email must have an at-sign (@)";
        }
    }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<title>Flavia Oliveira Santos de Sa Lisboa 5e8c8476 - Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
if ( $failure !== false ) {
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
?>
<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="who" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
</div>
</body>
