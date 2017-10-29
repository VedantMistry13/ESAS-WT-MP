<?php
	session_start();
	if ($_SESSION['first_name'] === null || $_SESSION['last_name'] === null || $_SESSION['email'] === null) {
		header("Location: ../login_and_register/index.php");
	}

	$db = new mysqli('localhost', 'root', '', 'esas') 
				or die("Error connecting to database!");
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['course_id']) && isset($_POST['course_name']) && isset($_POST['held_on'])
				&& isset($_POST['start_time']) && isset($_POST['end_time']) && isset($_POST['room_no'])) {
			$_id = $_POST['_id'];
			$course_id = $_POST['course_id'];
			$course_name = $_POST['course_name'];
			$held_on = $_POST['held_on'];
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			$room_no = $_POST['room_no'];

			$db_start_time = date('H:i:s', strtotime($start_time));
			$db_end_time = date('H:i:s', strtotime($end_time));
			$db_held_on = date("Y-m-d",strtotime($held_on));

			$sql = "UPDATE exam SET "
							."course_name = '$course_name', "
							."held_on = '$db_held_on', "
							."start_time = '$db_start_time', "
							."end_time = '$db_end_time', "
							."room_no = '$room_no' "
							."WHERE _id = '$_id'";

			if ($db->query($sql)) {
				header("Location: viewExam.php");
			} else {
				// $update_id = $_id;

				$sql = "SELECT * from exam where _id = '$_id'";

				$res = $db->query($sql);
				$row = $res->fetch_assoc();
				// print_r($row);
			}
		} else {
			$_id = $_POST['update_id'];

			$sql = "SELECT * from exam where _id = '$_id'";

			$res = $db->query($sql);
			$row = $res->fetch_assoc();
			// print_r($row);
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>VES-ESAS</title>
	<link rel="stylesheet" type="text/css" href="addExam.css" />
	<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
	<script type="text/javascript" src="addExam.js"></script>
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
				<div class="title">Update Examination!</div>
				<div class="subtitle">Update exam details: </div>
			</div>

			<div class="exam_form">

				<div class="form_content" style="padding-left: 50px;">
				
					<form method="POST" action="updateExam.php" name="examForm" onsubmit="return validateRegisterForm();">

						<input type="hidden" name="_id" value='<?php echo $row['_id'] ?>' placeholder="ID" />

						<div class="form_title">Course ID*: </div>
						<input type="text" maxlength="5" name="course_id" value='<?php echo $row['course_id'] ?>' placeholder="Course ID" />
						<br />

						<div class="form_title">Course Name*: </div>
						<input type="text" name="course_name" value='<?php echo $row['course_name'] ?>' placeholder="Course Name"/>
						<br />

						<div class="form_title">Held on*: </div>
						<input type="date" value='<?php echo date("Y-m-d", strtotime($row['held_on'])) ?>' name="held_on" />
						<br />

						<div class="form_title">Start Time*: </div>
						<input type="time" value='<?php echo date('H:i', strtotime($row['start_time'])) ?>' name="start_time" />
						<br />

						<div class="form_title">End Time*: </div>
						<input type="time" value='<?php echo date('H:i', strtotime($row['end_time'])) ?>' name="end_time" />
						<br />

						<div class="form_title">Room No.*: </div>
						<div class="styled-select slate">
							<select name="room_no">
								<?php
									for ($i = 1; $i <= 10; $i++) {
										if ($i == $row['room_no']) {
											echo "<option value='$i' selected>Room no. $i</option>";
										} else {
											echo "<option value='$i'>Room no. $i</option>";
										}
									}
								?>
							</select>
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