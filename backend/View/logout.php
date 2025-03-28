<?php

setcookie("id_user",$logged_in["id_user"], time()-60*60*24, "/");

header("Location: ../index.php");
?>