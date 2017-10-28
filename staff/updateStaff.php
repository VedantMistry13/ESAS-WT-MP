<?php
	session_start();
	if ($_SESSION['first_name'] === null || $_SESSION['last_name'] === null || $_SESSION['email'] === null) {
		header("Location: ../login_and_register/index.php");
	}

	$db = new mysqli('localhost', 'root', '', 'esas') 
				or die("Error connecting to database!");
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email'])) {
			$_id = $_POST['_id'];
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$email = $_POST['email'];
			$position = $_POST['position'];

			if (isset($_POST['available'])) {
				$available = true;
			} else {
				$available = false;
			}
			
			switch ($position) {
				case 'professor':
					$noa = 1;
					break;
				case 'associateProfessor':
					$noa = 2;
					break;
				case 'assistantProfessor':
					$noa = 4;
					break;
				case 'lecturer':
					$noa = 6;
					break;
				default:
					$noa = 0;
					break;
			}

			$sql = "UPDATE staff SET "
							."firstname = '$firstname', "
							."lastname = '$lastname', "
							."email = '$email', "
							."position = '$position', "
							."noa = '$noa', "
							."available = '$available' "
							."WHERE _id = '$_id'";

			if ($db->query($sql)) {
				header("Location: viewStaff.php");
			} else {
				$sql = "SELECT * from staff where _id = '$_id'";
				$res = $db->query($sql);
				$row = $res->fetch_assoc();
			}
		} else {
			$_id = $_POST['update_id'];
			$sql = "SELECT * from staff where _id = '$_id'";
			$res = $db->query($sql);
			$row = $res->fetch_assoc();
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>VES-ESAS</title>
	<link rel="stylesheet" type="text/css" href="addStaff.css" />
	<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
	<script type="text/javascript" src="addStaff.js"></script>
</head>
<body>

	<!-- header component -->
	<div class="gen_header">

	<div class="header_img"> 
	  <img src="../login_and_register/ves-logo.png" />
	</div>

	<div class="header_title">
	  <a href="../home/index.php">VESIT - ESAS</a>
	  <hr>
	  <div class="header_subtitle">VESIT Examination Staff Allotment System</div>
	  <div class="header_info">Welcome <?php echo $_SESSION['first_name']." ".$_SESSION['last_name']."!"; ?></div>
	</div>

	  <div class="logout">
	    <button onclick="location.href='../login_and_register/logout.php'">LOGOUT</button>
	  </div>	

	</div>
	<div class="home_navigator">
		<div class="link"><a href="viewStaff.php">🡨 Go Back</a></div>
	</div>

	<!-- content body -->
	<div class="container_body">
		<div class="container">
			
			<div class="exam_form_header">
				<div class="title">Update Staff Member!</div>
				<div class="subtitle">Update staff member details: </div>
			</div>

			<div class="exam_form">

				<div class="form_content" style="padding-left: 50px;">
				
					<form method="POST" name="staffForm" action="updateStaff.php" onsubmit="return validateRegisterForm();">

							<input type="hidden" name="_id" value='<?php echo $row['_id'] ?>' placeholder="ID" />

							<div class="form_title">First Name*: </div>
							<input type="text" name="firstname" value='<?php echo $row['firstname'] ?>' placeholder="First Name" />
							
							<div class="form_title">Last Name*: </div>
							<input type="text" name="lastname" value='<?php echo $row['lastname'] ?>' placeholder="Last Name" />
							
							<div class="form_title">E-mail*: </div>
							<input type="text" name="email" value='<?php echo $row['email'] ?>' placeholder="E-mail" />
							
							<div class="form_title">Position*: </div>
							<div class="styled-select slate">
								<select name="position">
									<?php 
										if ($row['position'] == 'professor') {
											echo '<option value="professor" selected>Professor</option>';
										} else {
											echo '<option value="professor">Professor</option>';
										}

										if ($row['position'] == 'associateProfessor') {
											echo '<option value="associateProfessor" selected>Associate Professor</option>';
										} else {
											echo '<option value="associateProfessor">Associate Professor</option>';
										}

										if ($row['position'] == 'assistantProfessor') {
											echo '<option value="assistantProfessor" selected>Assistant Professor</option>';
										} else {
											echo '<option value="assistantProfessor">Assistant Professor</option>';
										}

										if ($row['position'] == 'lecturer') {
											echo '<option value="lecturer" selected>Lecturer</option>';
										} else {
											echo '<option value="lecturer">Lecturer</option>';
										}
									?>
								</select>
							</div>

							<div>
								<div class="form_title">Available: </div>
								<div style="height: 15px;"><input type="checkbox" name="available" value="yes" 
									<?php if ($row['available']) {echo "checked";} ?>></div>
							</div>
							<br />

							<div class="update_button">
								<button type="submit">UPDATE</button>	
							</div>

						</form>

				</div>

			</div>

		</div>
	</div>

</body>
</html>