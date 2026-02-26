<?php
require_once __DIR__ . "/../Lib/helpers.php";

if (!isset($_GET["module"])) {
  $_GET["module"] = "User";
  $_GET["controller"] = "User";
  $_GET["function"] = "home"; 
}

resolve();