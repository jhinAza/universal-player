<?php
  require_once("/inc/functions.php");
  writeHeader("register");
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["userRegister"]) && isset($_POST["mailRegister"]) && isset($_POST["mailRegisterAgain"]) && isset($_POST["passRegister"])) {
      require_once("/inc/databaseController.php");
      $db = new DatabaseController();
      $bool = $db->registerUser($_POST["userRegister"], $_POST["passRegister"], $_POST["mailRegister"]);
      if ($bool) {
        $id = $db->getUserID($_POST["userRegister"]);
        if ($id) {
          $filename = "user_$id.xml";
          $default = "default.xml";
          $folder = "userSettings/";
          if (file_exists($folder.$filename)) {
            unlink($folder.$filename);
          }
          if (copy($folder.$default, $folder.$filename)) {
            header("Location:/login.php");
          }
        }
      } else {
        print "<h3>Ha ocurrido un error</h3>";
        print "<a href=/login.php>Pulse aqui</a> para reintentar";
      }
    }
  }
?>
