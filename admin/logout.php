<?php
session_start();

header("location:index.php?page=home");

session_destroy();

?>