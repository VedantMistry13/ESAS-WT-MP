<?php
  // session
  session_start();

  if (isset($_SESSION['first_name']) && isset($_SESSION['last_name']) && isset($_SESSION['email'])) {
    header("Location: ../home/index.php");
  }

  $_SESSION['login_message'] = '';
  $_SESSION['register_message'] = '';

  // database
  $db = new mysqli('localhost', 'root', '', 'esas') 
    or die("Error connecting to database!");
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['submit'] === 'register') {
      if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) 
        && isset($_POST['password']) && isset($_POST['cpassword'])) {
          // $_SESSION['register_message'] = '*works!';
          
          $first_name = $_POST['first_name'];
          $last_name = $_POST['last_name'];
          $email = $_POST['email'];
          $password = $_POST['password'];
          $cpassword = $_POST['cpassword'];

          if (trim($first_name) === '' || trim($last_name) === '' || trim($email) === ''
            || strlen($password) == 0 || strlen($cpassword) == 0) {
            $_SESSION['register_message'] = '*enter all fields!';
          } else {
            if ($password === $cpassword) {
              $md5_2 = md5(md5($password));
              $sql = "INSERT into users (first_name, last_name, email, password)"
                ."VALUES ('$first_name', '$last_name', '$email', '$md5_2')";

              if ($db->query($sql)) {
                $_SESSION['first_name'] = $first_name;
                $_SESSION['last_name'] = $last_name;
                $_SESSION['email'] = $email;
                header("Location: ../home/index.php");
              } else {
                $_SESSION['register_message'] = '*error querying database';
              }
            } else {
              $_SESSION['register_message'] = '*passwords do not match';
            }
          }
        } else {
          $_SESSION['register_message'] = '*enter all fields!';
        }
    } else if ($_POST['submit'] === 'login') {
      // $_SESSION['login_message'] = '*works';
      if(isset($_POST['email']) && isset($_POST['password'])) {
        // $_SESSION['login_message'] = '*works!';
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * from users WHERE email = '$email'";
        $result = $db->query($sql);

        if ($user = $result->fetch_assoc()) {
          if (md5(md5($password)) === $user['password']) {
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            header("Location: ../home/index.php");
          } else {
            $_SESSION['login_message'] = '*Invlaid email or password!';
          }
        } else {
          $_SESSION['login_message'] = '*Invalid email or password!';
        }
      } else {
        $_SESSION['login_message'] = '*enter all fields!';
      }
    }
  }
?>

<html>

<head>
  <title>VES-ESAS</title>
  <link rel="stylesheet" type="text/css" href="index.css" />
  <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
  <script type="text/javascript" src="index.js"></script>
</head>

<body>
  <!-- header component -->
  <div class="gen_header">
    
    <div class="header_img"> 
      <img src="ves-logo.png" />
    </div>
    
    <div class="header_title">
      <a href="index.php">VESIT - ESAS</a>
      <hr>
      <div class="header_subtitle">VESIT Examination Staff Allotment System</div>
    </div>

  </div>
  <br />
  <!-- content body -->
  <div class="form_body">
    
    <div class="forms">

      <form method="POST" action="index.php">

        <div class="login_form">

          <div class="form_heading">
            Login Here!
          </div>

          <div class="label">
            Email Address:
          </div>
          <div>
            <input type="text" name="email" placeholder="E-mail Address" />
          </div>

          <div class="label">
            Password:
          </div>
          <div>
            <input type="password" name="password" placeholder="Password" />
          </div>

          <div class="error_message">
            <?= $_SESSION['login_message'] ?>
          </div>

          <div class="submit">
            <button type="submit" name="submit" value="login">LOGIN</button>
          </div>

        </div>
      
      </form>
      
      <form method="POST" action="index.php" name="registerForm" onsubmit="return validateRegisterForm();">

        <div class="register_form">

          <div class="form_heading">
            Register Here!
          </div>

          <div class="label">
            First Name:
          </div>
          <div>
            <input type="text" name="first_name" placeholder="First Name" />
          </div>

          <div class="label">
            Last Name:
          </div>
          <div>
            <input type="text" name="last_name" placeholder="Last Name" />
          </div>

          <div class="label">
            Email Address:
          </div>
          <div>
            <input type="text" name="email" placeholder="E-mail Address" />
          </div>

          <div class="label">
            Password:
          </div>
          <div>
            <input type="password" name="password" placeholder="Password" />
          </div>

          <div class="label">
            Confirm Password:
          </div>
          <div>
            <input type="password" name="cpassword" placeholder="Confirm Password" />
          </div>

          <div class="error_message">
            <?= $_SESSION['register_message'] ?>
          </div>

          <div class="submit">
            <button type="submit" name="submit" value="register">REGISTER</button>
          </div>

        </div>

      </form>
      
    </div>

  </div>

</body>

</html>
