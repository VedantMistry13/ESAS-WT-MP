<?php 
	session_start();
	if ($_SESSION['first_name'] === null || $_SESSION['last_name'] === null || $_SESSION['email'] === null) {
		header("Location: ../login_and_register/index.php");
	}
?>


<html>

<head>
  <title>VES-ESAS</title>
  <link rel="stylesheet" type="text/css" href="index.css" />
  <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
</head>

<body>
  <!-- header component -->
  <div class="gen_header">
    
    <div class="header_img"> 
      <img src="../login_and_register/ves-logo.png" />
    </div>
    
    <div class="header_title">
      <a href="index.php">VESIT - ESAS</a>
      <hr>
      <div class="header_subtitle">VESIT Examination Staff Allotment System</div>
      <div class="header_info">Welcome <?php echo $_SESSION['first_name']." ".$_SESSION['last_name']."!"; ?></div>
    </div>

	  <div class="logout">
	    <button onclick="location.href='../login_and_register/logout.php'">LOGOUT</button>
	  </div>	

  </div>

  <!-- component body -->
  <div class="content_body">
  	
  	<div class="content">

  		<a href="../exam/addExam.php">
	  		<div class="navigator">
	  			<table>
	  				<tr>
	  						<td>
	  							<img src="assets/exam.png" />
	  						</td>
	  				</tr>
	  				<tr>
	  					<td>
	  						<div class="navigator_title">Add Exam</div>
	  					</td>
	  				</tr>
	  			</table>
	  		</div>
  		</a>

  		<a href="../staff/addStaff.php">
	  		<div class="navigator">
	  			<table>
	  				<tr>
	  						<td>
	  							<img src="assets/staff.png" />
	  						</td>
	  				</tr>
	  				<tr>
	  					<td>
	  						<div class="navigator_title">Add Staff</div>
	  					</td>
	  				</tr>
	  			</table>
	  		</div>
  		</a>

  		<a href="../allotment-generator/allotter.php">
	  		<div class="navigator">
	  			<table>
	  				<tr>
	  						<td>
	  							<img src="assets/list.png" />
	  						</td>
	  				</tr>
	  				<tr>
	  					<td>
	  						<div class="navigator_title">Generate Allotment</div>
	  					</td>
	  				</tr>
	  			</table>
	  		</div>
  		</a>
  		
  	</div>

  </div>

  <div class="content_body">
  	
  	<div class="content">

  		<a href="../exam/viewExam.php">
	  		<div class="navigator">
	  			<table>
	  				<tr>
	  						<td>
	  							<img src="assets/viewExam.png" />
	  						</td>
	  				</tr>
	  				<tr>
	  					<td>
	  						<div class="navigator_title">Exams</div>
	  					</td>
	  				</tr>
	  			</table>
	  		</div>
  		</a>

  		<a href="../staff/viewStaff.php">
	  		<div class="navigator">
	  			<table>
	  				<tr>
	  						<td>
	  							<img src="assets/viewStaff.png" />
	  						</td>
	  				</tr>
	  				<tr>
	  					<td>
	  						<div class="navigator_title">Staff Members</div>
	  					</td>
	  				</tr>
	  			</table>
	  		</div>
  		</a>
<!-- 
  		<a href="../allotment-generator/allotter.php">
	  		<div class="navigator">
	  			<table>
	  				<tr>
	  						<td>
	  							<img src="assets/list.png" />
	  						</td>
	  				</tr>
	  				<tr>
	  					<td>
	  						<div class="navigator_title">Generate Allotment</div>
	  					</td>
	  				</tr>
	  			</table>
	  		</div>
  		</a> -->
  		
  	</div>

  </div>

</body>

</html>
