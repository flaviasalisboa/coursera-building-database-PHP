<?php
// Week 5 - assignment Autos C.R.U.D.
// Faz o logout da sessão login - excluindo a sessão

	session_start();
	session_destroy();
	header("Location: index.php");
?>