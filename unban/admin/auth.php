<?

session_start();

if($_SESSION["admin_mode"]!=1) {
  header("Location: /login/");
  exit;
}

?>