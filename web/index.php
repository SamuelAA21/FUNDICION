<?php
require_once __DIR__ . "/../Lib/helpers.php";
?>
<!DOCTYPE html>
<html> 
  <?php 
  include_once '../View/Partials/head.php';
  ?> 
<body>
<?php
    include_once '../Lib/helpers.php';
    include_once '../View/Partials/sidepanel.php';?>
<?php
if (!isset($_GET["module"])) {
  include_once '../View/Partials/header.php'; 
  include_once '../View/Partials/about.php';
  include_once '../View/Partials/footer.php';
} else {
  resolve();
}
?>
 <?php include_once '../View/Partials/scripts.php';  ?> 
</body>
</html>