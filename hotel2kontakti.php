<!DOCTYPE html>
<html>
<head>
<title>*****MOUNTAIN HOTEL*****</title>
<link rel="stylesheet" type="text/css" href="kontakti.css" />
<script>
function showEmail(str) {
    if (str == "") {
        document.getElementById("ajaxnames").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {

            xmlhttp = new XMLHttpRequest();
        } else {

            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ajaxnames").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","dbajaxnames.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
</head>
<body>
<?php
  include("hotel2header.php");
  require_once("dbconn.php");

  class Person {
    private $emri;
    private $mbiemri;
    private $email;
    private $comment;

    public function setEmri($_emri) {
      $this->emri = $_emri;
    }

    public function setMbiemri($_mbiemri) {
      $this->mbiemri = $_mbiemri;
    }

    public function setEmail($_email) {
      $this->email = $_email;
    }
    public function setComment($_comment) {
      $this->comment = $_comment;
    }

    public function getEmri() {
      return $this->emri;
    }

    public function getMbiemri() {
      return $this->mbiemri;
    }

    public function getEmail() {
      return $this->email;
    }
    public function getComment() {
      return $this->comment;
    }

    function __construct() {
      $this->emri="";
      $this->mbiemri="";
      $this->email="";
      $this->comment="";
    }

  }

  $errEmri=$errMbiemri=$errEmail=$errComment="";
  $valEmri=$valMbiemri=$valEmail=$valComment="";

  class EmailException extends Exception {
    public function errMsg() {
      $msg = "Shkruaj emailin sipas formatit te duhur";
      return $msg;
    }
  }


  $person1 = new Person();

  if(isset($_POST['submit'])) {

    if(empty($_POST['emri']))
      $errEmri="Shkruaj emrin";
    else {
      $person1->setEmri(trim($_POST['emri']));
      if(!preg_match('/^\+?[a-zA-Z]+$/',$person1->getEmri()))
        $valEmri = "Emri duhet te perbehet vetem nga shkronjat";
    }

    if(empty($_POST['mbiemri']))
      $errMbiemri="Shkruaj mbiemrin";
    else {
      $person1->setMbiemri(trim($_POST['mbiemri']));
      if(!preg_match('/^\+?[a-zA-Z]+$/',$person1->getMbiemri()))
        $valMbiemri = "Mbiemri duhet te perbehet vetem nga shkronjat";
    }

    if(empty($_POST['email']))
      $errEmail="Shkruaj emailin";
    else {
      $person1->setEmail(trim($_POST['email']));
      try {
        if(!preg_match('/^[a-zA-Z0-9]+[-_.]{0,2}[a-zA-Z0-9]*@[a-zA-Z0-9]+\.{1}[a-zA-Z]+\.?[a-zA-Z]+$/',$person1->getEmail())) {
          throw new EmailException();
        }
      }
      catch (EmailException $e) {
          $valEmail = $e->errMsg();
      }
    }

    if(empty($_POST['comment']))
      $errComment="Shkruaj komentin";
    else {
      $person1->setComment(trim($_POST['comment']));
    }

    if(empty($errEmri) && empty($errMbiemri) && empty($errEmail) && empty($errComment)
       && empty($valEmri) && empty($valMbiemri) && empty($valEmail)) {

         $conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

         if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
         }

         $emri = $person1->getEmri();
         $mbiemri = $person1->getMbiemri();
         $email = $person1->getEmail();
         $comment = $person1->getComment();

         $prstm = $conn->prepare("INSERT INTO Comments(emri,mbiemri,email,comment) VALUES(?, ?, ?, ?)");
         $prstm->bind_param("ssss",$emri,$mbiemri,$email,$comment);
         $prstm->execute();
         if(!is_file("email_subject.txt")) {
           echo "<p class='areservation'>Email nuk u dergua tek rezervuesi ka probleme me hapjen e email_subject file</p>";
           echo "</div>";
           $prstm->close();
           $conn->close();
           require_once("hotel2footer.php");
           die("");
         }
         else{
           $myfile = fopen("email_subject.txt","r");
           $subject = fread($myfile,filesize("email_subject.txt"));
           fclose($myfile);
         }

         if(!is_file("email_message.txt")) {
           echo "<p class='areservation'>Email nuk u dergua tek rezervuesi ka probleme me hapjen e email_message file</p>";
           echo "</div>";
           $prstm->close();
           $conn->close();
           require_once("hotel2footer.php");
           die("");
         }
         else{
           $myfile = fopen("email_message.txt","r");
           $message = fread($myfile,filesize("email_message.txt"));
           fclose($myfile);
         }

         if(mail($email,$subject,$message)) {
            echo "<p class='areservation'>Email u dergua me sukses</p>";
            echo "</div>";
          }
         else {
            echo "<p class='areservation'>Email nuk u dergua</p>";
            echo error_get_last()['message'];
            echo "</div>";
          }
         $prstm->close();
         $conn->close();
       }
  }

?>
<div class="div1">
  <div id="formulariperkontakt">
   <form method="post" action="hotel2kontakti.php" autocomplete="off">
     <fieldset>
       <legend>Formulari per kontakt</legend>
       <br/>Emri:<br/>
       <input type="text"  name="emri" autofocus value="<?php echo $person1->getEmri();?>">
       <br/>
       <?php if(!empty($errEmri)) echo "<span class='required'>$errEmri</span><br/>";
         else if(!empty($valEmri)) echo "<span class='required'>$valEmri</span><br/>";
       ?>
       <br/>Mbiemri:<br/>
       <input type="text" name="mbiemri" value="<?php echo $person1->getMbiemri();?>">
       <br/>
       <?php if(!empty($errMbiemri)) echo "<span class='required'>$errMbiemri</span><br/>";
         else if(!empty($valMbiemri)) echo "<span class='required'>$valMbiemri</span><br/>";
       ?>
       <br/>Email:<br/>
       <input type="text" list="ajaxnames" name="email" oninput="showEmail(this.value)"  value="<?php echo $person1->getEmail(); ?>">
       <datalist id="ajaxnames">
       </datalist>
       <br/>
       <?php if(!empty($errEmail)) echo "<span class='required'>$errEmail</span><br/>";
         else if(!empty($valEmail)) echo "<span class='required'>$valEmail</span><br/>";
       ?>
       <br/>Përmbajtja:<br/>
       <textarea rows="5" cols="30" name="comment"><?php echo $person1->getComment();?></textarea>
       </br>
       <?php if(!empty($errComment)) echo "<span class='required'>$errComment</span><br/>";?>
       <input type="submit" name="submit" value="Dërgo">
     </fieldset>
   </form>
  <img src="brezovica.gif" alt="capture">
  </div>
</div>
<?php
  include("hotel2footer.php");
?>
