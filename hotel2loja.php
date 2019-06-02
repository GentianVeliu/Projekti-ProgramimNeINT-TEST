<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>*****MOUNTAIN HOTEL*****</title>
  <link rel="stylesheet" type="text/css" href="loja.css" />
</head>
<body>
<?php
  require_once("hotel2header.php");
  $value="";

  if(isset($_POST['btn'])) {
  echo "Vlera e btn3 ".$_POST['btn[3]'];
  }

  ?>
  <div class="form1">
    <form  method="post" action="hotel2loja.php">
      <div class="line">
        <button tybe="submit" name="btn[]" value="1" <?php if(isset($_SESSION["buttons[0]"])) echo "disabled";?> readonly>
        <?php if(isset($_SESSION["buttons[0]"])) echo "X"; else echo "X/O";?></button>
        <button tybe="submit" name="btn[]" value="2" <?php if(isset($_SESSION["buttons[1]"])) echo "disabled";?> readonly>
        <?php if(isset($_SESSION["buttons[1]"])) echo "X"; else echo "X/O";?></button>
        <button tybe="submit" name="btn[]" value="3" <?php if(isset($_SESSION["buttons[2]"])) echo "disabled";?> readonly>
        <?php if(isset($_SESSION["buttons[2]"])) echo "X"; else echo "X/O";?></button>

        <button tybe="submit" name="btn[]" value="4" <?php if(isset($_SESSION["buttons[3]"])) echo "disabled";?>readonly>
        <?php if(isset($_SESSION["buttons[3]"])) echo "X"; else echo "X/O";?></button>
        <button tybe="submit" name="btn[]" value="5" <?php if(isset($_SESSION["buttons[4]"])) echo "disabled";?> readonly>
        <?php if(isset($_SESSION["buttons[4]"])) echo "X"; else echo "X/O";?></button>
        <button tybe="submit" name="btn[]" value="6" <?php if(isset($_SESSION["buttons[5]"])) echo "disabled";?> readonly>
        <?php if(isset($_SESSION["buttons[5]"])) echo "X"; else echo "X/O";?></button>

        <button tybe="submit" name="btn[]" value="7" <?php if(isset($_SESSION["buttons[6]"])) echo "disabled";?> readonly>
        <?php if(isset($_SESSION["buttons[6]"])) echo "X"; else echo "X/O";?></button>
        <button tybe="submit" name="btn[]" value="8" <?php if(isset($_SESSION["buttons[7]"])) echo "disabled";?> readonly>
        <?php if(isset($_SESSION["buttons[7]"])) echo "X"; else echo "X/O";?></button>
        <button tybe="submit" name="btn[]" value="9" <?php if(isset($_SESSION["buttons[8]"])) echo "disabled";?> readonly>
        <?php if(isset($_SESSION["buttons[8]"])) echo "X"; else echo "X/O";?></button>
      </div>
    </form>
  </div>
<?php
require_once("hotel2footer.php");
?>
