
<?php
	session_start();
	if ($_SESSION['first_name'] === null || $_SESSION['last_name'] === null || $_SESSION['email'] === null) {
		header("Location: ../login_and_register/index.php");
	}
	$_SESSION['message'] = 'Please enter your details!';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email'])) {
			
			$db = new mysqli('localhost', 'root', '', 'esas') 
				or die("Error connecting to database!");
			
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

			$sql = "INSERT INTO staff (firstname, lastname, email, position, noa, available)"
				."VALUES ('$firstname', '$lastname', '$email', '$position', '$noa', '$available')";

			if ($db->query($sql) === true) {
				$_SESSION['message'] = "User added successfully!";
            } else {
            	$_SESSION['message'] = "Error adding user to the database!";
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
  	<div class="link"><a href="../home/index.php">🡨 Go Back</a></div>
  </div>

  <!-- content body -->
  <div class="container_body">

  		<div class="container">
				
				<table width="100%">
					
					<tr>
					
					<td>
						<div class="exam_form_header">
							<div class="title">Add Staff Member!</div>
							<div class="subtitle">Enter staff member details: </div>
						</div>
					</td>

					<td>
						<div class="staff_list_header">
							<div class="title">Staff Member List</div>
							<div class="subtitle"><a href="addStaff.php">Refresh</a></div>
						</div>
					</td>

				</tr>

					<tr>
						
						<td width="40%">
							
							<div class="exam_form">

								<div class="form_content">

									<form method="POST" name="staffForm" action="addStaff.php" onsubmit="return validateRegisterForm();">
										<div class="form_title">First Name*: </div>
										<input type="text" name="firstname" placeholder="First Name" />
										
										<div class="form_title">Last Name*: </div>
										<input type="text" name="lastname" placeholder="Last Name" />
										
										<div class="form_title">E-mail*: </div>
										<input type="text" name="email" placeholder="E-mail" />
										
										<div class="form_title">Position*: </div>
										<div class="styled-select slate">
											<select name="position">
												<option value="professor">Professor</option>
												<option value="associateProfessor">Associate Professor</option>
												<option value="assistantProfessor">Assistant Professor</option>
												<option value="lecturer">Lecturer</option>
											</select>
										</div>

										<div>
											<div class="form_title">Available: </div>
											<div style="height: 15px;"><input type="checkbox" name="available" value="yes"></div>
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
										<th>Sr. No.</th>
										<th>First Name</th>
										<th>Last Name</th>
										<th>E-Mail</th>
										<th>Position</th>
										<th>Times Available</th>
										<th>Available</th>
									</tr>
									<?php 
										$db = new mysqli('localhost', 'root', '', 'esas') 
											or die("Error connecting to database!");

										$sql = "SELECT * from staff";

										$results = $db->query($sql);

										$i = 1;
										while($row = $results->fetch_assoc()) {
											?>

											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $row['firstname']; ?></td>
												<td><?php echo $row['lastname']; ?></td>
												<td><?php echo $row['email']; ?></td>
												<td>
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
												</td>
												<td><?php echo $row['noa']; ?></td>
												<?php
													if ($row['available']) {
														echo "<td>Yes</td>";
													} else {
														echo "<td>No</td>";
													}
												?>
											</tr>
											
											<?php
											$i++;
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
