<?php
	session_start();
	if(session_destroy()){
		//base64_decode(urldecode($_GET['msg']))
		header('Location: index.php?logout=' . urlencode(base64_encode("Successfully logged out!")));
	}
?>
