<?php
   session_start();

   include('functions.php');
   
   date_default_timezone_set('America/Los_Angeles');
   $date = date('m/d/Y h:i:s a', time());
   include("db_connect.php");

   if (isset($_POST['hidden_signup'])) {
      // validate some of this data. It should have gone thru js - but
      // no gurantees.
      // "hidden_signup" if true, then sign up the entry and log them in.
      $email = _e($_POST['email']);
      $pwd = _e($_POST['pwd1']);
      if($_POST['hidden_signup'] == 'true') {
         $first_name = _e($_POST['first_name']);
         $last_name = _e($_POST['last_name']);
         // setup error string
         $error_oem = "There is a problem with: ";
         $error = $error_oem;
         // validate //email
         if (!preg_match('/^[\w.]+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/', $email)) {
            $error = $error . 'email';
         }
         if (!preg_match('/^[A-Z][a-z]+([\-\s]?[A-Z]?[a-z]+){0,2}$/', $first_name)) {
            $error = $error . ' first name';
         }
         if (!preg_match('/^[A-Z][a-z]+(\-?[A-Z][a-z]+){0,3}$/', $last_name)) {
            $error = $error . ' last name';
         }
         // snaged this from REGEX library. 
         if (!preg_match('/^(?=[^\d_].*?\d)\w(\w|[!@#$%]){6,20}/', $pwd)) {
            $error = $error . ' password';
         }
         if ($error == $error_oem) {
            // let's get these in the database. hash & salt password
            $pwd = password_hash($pwd, PASSWORD_DEFAULT);

            $istatement = 'insert into users (first_name, last_name, email, password) values (:first_name, :last_name, :email, :pwd)';
            $statement = $db->prepare($istatement);
            $statement->bindValue(':first_name', $first_name);
            $statement->bindValue(':last_name', $last_name);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':pwd', $pwd);

            $dbresult = $statement->execute(); 
            if (!$dbresult) {
               print "Insert failed!! $first_name, $last_name, $email, $pwd <br>";
               var_dump($_POST);
               $error = "Problem processing data";
            } else {
               $id = $db->lastInsertId("item_id_seq");
               // store session user to bypass check on all pages
               $_SESSION['user'] = array("id" => $id, "name" => $first_name . ' ' . $last_name, "email" => $email);
               // let's move to the item listing
               header('Location: ' . 'index.php');
               die();
            }                  
         } else {
            $error = $error . '.';
         }
      } else {
         // if false, then regular login. Check the email and password against the database.
         $s_statement = 'select * from users where email = :email';
         $statement = $db->prepare($s_statement);
         $statement->bindValue(':email', $email);
         $dbresult = $statement->execute();
         if(!$dbresult) {
            print "SELECT FAILED!! $email <br>";
            error_log('LOGIN select failed!' . var_dump($_POST));
         } else {
            // let's see what we've got back - if anything
            //$success = $db->query("select count(*) from  pdo_admin")->fetchColumn();
            //error_log("returned $success results for login");
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            //if($success) {
               //check the password for a match
               //$row = $dbresult->fetch(PDO::FETCH_ASSOC);
            if(password_verify($pwd, $row['password'])) {
               //success load data into session[user] and get out of here
               $_SESSION['user'] = array("id" => $row['id'], "name" => $row['first_name'] . ' ' . $row['last_name'], "email" => $email);
               error_log('Login success: ' . implode(",", $_SESSION['user']));
               header('Location: ' . 'index.php');
               die();
            } else {
               // no match
               $error = "No user with that email/password combo.";
               // clearing these so no warning thrown.
               $first_name = '';
               $last_name = '';
            }
         }

      }

   } else {
      // just coming to the page, nothing submitted
      $email = '';
      $first_name = '';
      $last_name = '';
      $error = '';
   }


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title><?php echo 'Login CS313-GOp Garage Organizer'; ?></title>
   <meta name="description" content="CS313 Project 1 - GOp">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
   <link rel="stylesheet" href="project1.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
   <script src="project1.js" async defer></script>
   <?php include("favicon.html");?>
</head>
<body>
   <div class="login_container">
      <!-- <div class="column"> -->
      <div class="edged">
         <div class="login h2">
            Log in
         </div>
      <div class="form-group login_form">
         <form action="" name="logForm" id="logForm" autocomplete="on" method="POST"> <!--don't know if i want this or not autocomplete-->
            <label for="email">Enter email:</label>
            <input type="email" name="email" id="email" class="form-control" value="<?=$email?>" autocomplete="user-email" placeholder="email.address@here.com" required/>
            <label for="pwd">Password:</label>
            <input type="password" name="pwd1" id="pwd1" class="form-control" autocomplete="new-password"  placeholder="Enter-password"/>
            <div class="hidden" id="pwd2_div">
               <label for="pwd2">Re-enter Password:</label>
               <input type="password" name="pwd2" id="pwd2" class="form-control" autocomplete="new-password" placeholder="Re-enter password"/>
               <input type="text" name="first_name" id="first_name" class="form-control" value="<?=$first_name?>" autocomplete="user-firstname" placeholder="First Name"/>
               <input type="text" name="last_name" id="last_name" class="form-control" value="<?=$last_name?>" autocomplete="user-lastname" placeholder="Last Name"/>
            </div>
            <div class="may_hide" id="may_hide">
               <input type="submit" class="btn btn-primary" name="logitin" id="logitin" value="Login" />
            </div>
            <input type="hidden" name="hidden_signup" id="hidden_signup" value="false"/>
         </form>
         <div class="signup link">
            <!-- <a href="signup.php">sign me up</a> -->
            <button class="btn btn-secondary" name="signup" id="signup" onclick="signup();" value="Sign up">Sign Up </button>
            <div id="error"><?=$error?></div>
            <div id="error2"></div>

         </div>
      </div>
   </div>
   </div>
   
</body>
</html>