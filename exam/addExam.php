<?php
	session_start();
	if ($_SESSION['first_name'] === null || $_SESSION['last_name'] === null || $_SESSION['email'] === null) {
		header("Location: ../login_and_register/index.php");
	}
	$_SESSION['message'] = '';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['course_id']) && isset($_POST['course_name']) && isset($_POST['held_on'])
				&& isset($_POST['start_time']) && isset($_POST['end_time']) && isset($_POST['room_no'])) {
			
			$db = new mysqli('localhost', 'root', '', 'esas') 
				or die("Error connecting to database!");
			
			$course_id = $_POST['course_id'];
			$course_name = $_POST['course_name'];
			$held_on = $_POST['held_on'];
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			$room_no = $_POST['room_no'];

			$db_start_time = date('H:i:s', strtotime($start_time));
			$db_end_time = date('H:i:s', strtotime($end_time));
			$db_held_on = date("Y-m-d",strtotime($held_on));
			
			$sql = "INSERT into exam (course_id, course_name, held_on, start_time, end_time, room_no) "
						."VALUES ('$course_id', '$course_name', '$db_held_on', '$db_start_time', '$db_end_time'"
						.", '$room_no')";
			
			if ($db->query($sql)) {
				$_SESSION['message'] = "Exam added successfully!";
			} else {
				$_SESSION['message'] = "Unable to add exam! ";
			}

		} else {
			$_SESSION['message'] = "Error: Fields not set!";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>ESAS</title>
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
  	<div class="link"><a href="../home/index.php">🡨 Go Back</a></div>
  </div>
  
  <!-- content body -->
  <div class="container_body">

	  <div class="container">
			
			<table width="100%">
				
				<tr>
					
					<td>
						<div class="exam_form_header">
							<div class="title">Add Examination!</div>
							<div class="subtitle">Enter exam details: </div>
						</div>
					</td>

					<td>
						<div class="staff_list_header">
							<div class="title">Examination List</div>
							<div class="subtitle"><a href="addExam.php">Refresh</a></div>
						</div>
					</td>

				</tr>

				<tr>
					
					<td width="40%">
						
						<div class="exam_form">

							<div class="form_content">
							
								<form method="POST" action="addExam.php">

									<div class="form_title">Course ID*: </div>
									<input type="text" maxlength="5" name="course_id" placeholder="Course ID" />
									<br />

									<div class="form_title">Course Name*: </div>
									<input type="text" name="course_name" placeholder="Course Name"/>
									<br />

									<div class="form_title">Held on*: </div>
									<input type="date" name="held_on" />
									<br />

									<div class="form_title">Start Time*: </div>
									<input type="time" name="start_time" />
									<br />

									<div class="form_title">End Time*: </div>
									<input type="time" name="end_time" />
									<br />

									<div class="form_title">Room No.*: </div>
									<div class="styled-select slate">
										<select name="room_no">
											<?php
												for ($i = 1; $i <= 10; $i++) {
													echo "<option value='$i'>Room no. $i</option>";
												}
											?>
										</select>
									</div>
									<br />

									<div class="submit">
										<button type="submit">Submit</button>	
									</div>

								</form>

							</div>

						</div>

					</td>

					<td width="60%">
						
						<div class="staff_list">
						
							<table width="100%">
						
								<tr>
									<th>Course ID</th>
									<th>Course Name</th>
									<th>Held On</th>
									<th>Start Time</th>
									<th>End Time</th>
									<th>Room No.</th>
								</tr>
						
								<?php 
									$db = new mysqli('localhost', 'root', '', 'esas') 
										or die("Error connecting to database!");

									$sql = "SELECT * from exam";

									$results = $db->query($sql);

									while($row = $results->fetch_assoc()) {
										?>

										<tr>
											<td><?php echo $row['course_id']; ?></td>
											<td><?php echo $row['course_name']; ?></td>
											<td><?php echo date('d-m-Y', strtotime($row['held_on']));; ?></td>
											<td><?php echo date('H:i', strtotime($row['start_time'])); ?></td>
											<td><?php echo date('H:i', strtotime($row['end_time'])); ?></td>
											<td><?php echo $row['room_no']; ?></td>
										</tr>
										
										<?php
									}
								?>
						
							</table>
						
						</div>

					</td>
				</tr>
			</table>
		
		</div>

	</div>

</body>

</html>
