<?php
	session_start();
	if ($_SESSION['first_name'] === null || $_SESSION['last_name'] === null || $_SESSION['email'] === null) {
		header("Location: ../login_and_register/index.php");
	}

	$db = new mysqli('localhost', 'root', '', 'esas') 
				or die("Error connecting to database!");
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['delete'])) {
			if ($_POST['delete'] == 'yes') {
				$_id = $_POST['_id'];
				$sql = "DELETE FROM staff WHERE _id = '$_id'";
				if ($db->query($sql)) {
					header("Location: viewStaff.php");
				}
			} else {
				header("Location: viewStaff.php");
			}

		} else {
			$_id = $_POST['delete_id'];
			$sql = "SELECT * from staff where _id = '$_id'";
			$res = $db->query($sql);
			$row = $res->fetch_assoc();

		}
	} else {
		$_id = $_POST['delete_id'];
		$sql = "SELECT * from staff where _id = '$_id'";
		$res = $db->query($sql);
		$row = $res->fetch_assoc();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>VES-ESAS</title>
	<link rel="stylesheet" type="text/css" href="addStaff.css" />
	<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
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
				<div class="title">Delete Staff Member!</div>
				<div class="subtitle">Confirm your request: </div>
			</div>

			<div class="exam_form">

				<div class="form_content" style="padding-left: 50px;">
				
					<form method="POST" action="deleteStaff.php">

						<div class="delete_confirmation">
							Are you sure you want to delete the following Staff Member?
						</div>

						<div class="delete_details">

							<input type="hidden" name="_id" value='<?php echo $row['_id'] ?>' placeholder="ID" />

							<div class="delete_title">First Name: <span class="info"><?php echo $row['firstname'] ?></span></div>

							<div class="delete_title">Last Name: <span class="info"><?php echo $row['lastname'] ?></span></div>

							<div class="delete_title">E-mail: <span class="info"><?php echo $row['email'] ?></span></div>

							<div class="delete_title">Position: <span class="info">
								<?php
									switch ($row['position']) {
										case 'professor':
											echo "Professor";
											break;
										case 'associateProfessor':
											echo "Associate Professor";
											break;
										case 'assistantProfessor':
											echo "Assistant Professor";
											break;
										case 'lecturer':
											echo "Lecturer";
											break;
										default:
											echo "Not Assigned";
											break;
									}
								?>					
							</span></div>
							
							<div class="delete_title">Available for: <span class="info"><?php echo $row['noa']." times" ?></span></div>

							<div class="delete_title">Is Available: <span class="info"><?php if($row['available']) { echo "Yes"; } else { echo "No"; } ?></span></div>

						</div>

						<div class="delete_yes">
							<button type="submit" name="delete" value="yes">YES</button>
						</div>

						<div class="delete_no">
							<button type="submit" name="delete" value="no">NO</button>
						</div>

					</form>

				</div>

			</div>

		</div>
	</div>


</body>
</html>