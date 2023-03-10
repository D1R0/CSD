<?php
session_start();
$_SESSION["user"] = $_GET["user"];
$_SESSION["role"] = $_GET["role"];
?>
<script>
location.reload();
</script>