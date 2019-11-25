<?php
include '../../systeme/make-your-style/dblayer_light.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>MfWorkerRun</title>
</head>
<body>
	<code><?php session_write_close(); echo $r = mf_worker_run(true); fermeture_connexion_db();?></code>
    <?php
    if ($r != '-') {
        mf_file_append_whrite();
    }
    ?>
</body>
</html>
