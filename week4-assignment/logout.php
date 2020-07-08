<?php
// Week 4 - assignment Autos Post-redirect
// Faz o logout da sessão login - excluindo a sessão

	session_start();
	session_destroy();
	header("Location: index.php");
?>