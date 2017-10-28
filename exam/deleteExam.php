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
				$sql = "DELETE FROM exam WHERE _id = '$_id'";
				if ($db->query($sql)) {
					header("Location: viewExam.php");
				}
			} else {
				header("Location: viewExam.php");
			}

		} else {
			$_id = $_POST['delete_id'];
			$sql = "SELECT * from exam where _id = '$_id'";
			$res = $db->query($sql);
			$row = $res->fetch_assoc();

		}
	} else {
		$_id = $_POST['delete_id'];
		$sql = "SELECT * from exam where _id = '$_id'";
		$res = $db->query($sql);
		$row = $res->fetch_assoc();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>VES-ESAS</title>
	<link rel="stylesheet" type="text/css" href="addExam.css" />
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
		<div class="link"><a href="viewExam.php">🡨 Go Back</a></div>
	</div>

	<!-- content body -->
	<div class="container_body">
		<div class="container">
			
			<div class="exam_form_header">
				<div class="title">Delete Examination!</div>
				<div class="subtitle">Confirm your request: </div>
			</div>

			<div class="exam_form">

				<div class="form_content" style="padding-left: 50px;">
				
					<form method="POST" action="deleteExam.php">

						<div class="delete_confirmation">
							Are you sure you want to delete the following Examination?
						</div>

						<div class="delete_details">

							<input type="hidden" name="_id" value='<?php echo $row['_id'] ?>' placeholder="ID" />

							<div class="delete_title">Course ID: <span class="info"><?php echo $row['course_id'] ?></span></div>

							<div class="delete_title">Course Name: <span class="info"><?php echo $row['course_name'] ?></span></div>

							<div class="delete_title">Held On: <span class="info"><?php echo date('d-m-Y', strtotime($row['held_on'])) ?></span></div>

							<div class="delete_title">Start Time: <span class="info"><?php echo date('H:i', strtotime($row['start_time'])) ?></span></div>
							
							<div class="delete_title">End Time: <span class="info"><?php echo date('H:i', strtotime($row['end_time'])) ?></span></div>

							<div class="delete_title">Room No.: <span class="info"><?php echo $row['room_no'] ?></span></div>

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