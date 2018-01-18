<?php
	session_start();
	if ($_SESSION['first_name'] === null || $_SESSION['last_name'] === null || $_SESSION['email'] === null) {
		header("Location: ../login_and_register/index.php");
	}
?>
<!DOCTYPE html>
<html>

<head>
	<title>ESAS</title>
	<link rel="stylesheet" type="text/css" href="allotter.css" />
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
		  
		  <div class="exam_form_header">
		  	<div class="titles">
					<div class="title">Allotment List Generator!</div>
					<div class="subtitle">Enter required details: </div>
		  	</div>
		  	<div class="refresh"><a href="allotter.php">Refresh</a></div>
			</div>

			<div class="exam_form">

				<div class="form_content">

<?php
	$_SESSION['message'] = '';
	$_SESSION['error'] = '';

	$db = new mysqli('localhost', 'root', '', 'esas') 
		or die("Error connecting to database!");

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['nob']) && strlen($_POST['nob']) !== 0) {
			
			$nob = $_POST['nob'];

			$flag = 0;

			$batches = array();

			for ($c = 1; $c <= $nob; $c++) {
				$check_var = "batch_".$c;
				if (!isset($_POST[$check_var])) {
					$flag = 1;
					break;
				} else {
					if ($_POST['submit_button'] === "batch_submit" && trim($_POST[$check_var]) === "") {
						$flag = 1;
						$_SESSION['message'] = 'Set all fields!';
						echo "<div class='error_message'>".$_SESSION['message']."</div>";
						break;
					}
				}
				$batches[$c] = $_POST[$check_var];
			}
			
			if ($flag === 1) {				

				?>

						<form method="POST" action="allotter.php">

							<div class="form_title">Number of batches*: <?php echo $nob; ?></div>
							<input type="hidden" name="nob" value='<?php echo $nob ?>' placeholder="No. of batches" />
							
							<?php
								
								for($i = 1; $i <= $nob; $i++) {

									?>

									<div class="form_title">Batch Name <?php echo $i; ?>: </div>
									<input type="text" name='<?php echo "batch_".$i ?>' placeholder='<?php echo "Batch ".$i." name" ?>' />
									<br /><br />

									<?php

								}

							?>

							<div class="submit">
								<button type="submit" name="submit_button" value="batch_submit">Submit</button>	
							</div>

						</form>

				<?php

			} else {
				// Algorithm goes here...

				$select_all_exams_query = "SELECT * from exam";

				$select_available_staff_query = "SELECT * from staff where available = 1";

				$exam_result = mysqli_query($db, $select_all_exams_query);
				$staff_result = mysqli_query($db, $select_available_staff_query);

				$exam = array();
				$staff = array();
				$noas = array();
				$allocation = array();

				while ($row = $exam_result->fetch_assoc()) {
					$exam[] = $row;
				}

				while ($row = $staff_result->fetch_assoc()) {
					$staff[] = $row;
					$noas[] = $row['noa'];
				}

				// print_r($noas);
				array_multisort($noas, SORT_DESC, $staff);

				for ($i = 0; $i <= count($exam); $i++) {
					for ($j = 0; $j <= $nob; $j++) {
						$allocation[$i][$j] = "<td></td>";
					}
				}
				$allocation[0][0] = "<th>Allotments</th>";

				for ($i = 1; $i <= count($exam); $i++) {
					$allocation[$i][0] = "<th><div style='font-size: 18px;'>".$exam[$i-1]['course_name']."</div>"
					."<div style='font-size: 12px;'>Date: ".$exam[$i-1]['held_on']
						."</div><div style='font-size: 12px;'>Time: ".date('H:i', strtotime($exam[$i-1]['start_time']))." - ".date('H:i', strtotime($exam[$i-1]['end_time']))."</div></th>"; 
				}

				for ($i = 1; $i <= $nob; $i++) {
					$allocation[0][$i] = "<th>".$batches[$i]."</th>"; 
				}

				$k = 0;
				$total_staff = count($staff);
				$could_not_allot = false;
				for ($i = 1; $i <= count($exam); $i++) {
					$k = 0;

					for ($j = 1; $j <= $nob; $j++) {

						while ($k < $total_staff && $staff[$k]['noa'] === 0) {
							$k++;
						}

						if ($k == $total_staff) {
							$could_not_allot = true;
							break;
						} else {
							$could_not_allot = false;
							$allocation[$i][$j] = "<td>".$staff[$k]['firstname']." ".$staff[$k]['lastname']."</td>";
							$staff[$k]['noa']--;
							$k++;
						}

					}
					if ($could_not_allot) {
						break;
					}

					$sub = array_splice($allocation[$i], 1, $nob);
					shuffle($sub);
					array_splice($allocation[$i], 1, 0, $sub);
				}

				for ($i = 1; $i <= count($exam); $i++) {
					for ($j = 1; $j <= $nob; $j++) {
						if ($allocation[$i][$j] == "<td></td>") {
							$allocation[$i][$j] = "<td style='background-color: red;'>Failed</td>";
						}
					}
				}

				if ($could_not_allot) {
					$_SESSION['message'] = '*Failed to generate allotment, please refresh or add more staff!';
					echo "<div class='error_message'>".$_SESSION['message']."</div>";
				} else {
					$_SESSION['message'] = '*Allotment list generated!';
					echo "<div class='error_message'>".$_SESSION['message']."</div>";
				}

				?>
					
					<div class="allotment_container">

						<table width="100%">

							<tr>

								<td width="30%">
													
									<div class="form_title">Number of batches*: <?php echo $nob; ?></div>
									<input type="hidden" name="nob" value='<?php echo $nob ?>' placeholder="No. of batches" />
									
									<?php
										
										for($i = 1; $i <= $nob; $i++) {

											?>

											<div class="form_title">Batch Name <?php echo $i; ?>: <?php echo $_POST["batch_".$i] ?></div>
											<input type="hidden" name='<?php echo "batch_".$i ?>' value='<?php echo $_POST["batch_".$i] ?>' placeholder='<?php echo "Batch ".$i." name" ?>' />

											<?php

										}

									?>

								</td>

								<td>

									<div class="allotment_list">

										<table>
											
											<?php 

											for ($i = 0; $i <= count($exam); $i++) {

												?>

												<tr>

												<?php

													for ($j = 0; $j <= $nob; $j++) {
														echo $allocation[$i][$j];
													}

												?>

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

				<?php

			}

		} else {
				$_SESSION['message'] = "Error: Fields not set!";
				echo "<div class='error_message'>".$_SESSION['message']."</div>";
			?>
				
				<form method="POST" action="allotter.php">
					
					<div class="form_title">Number of batches*: </div>
					<input type="number" name="nob" placeholder="No. of batches" />
					<br /><br />
					
					<div class="submit">
						<button type="submit" name="submit_button" value="nob_submit">Submit</button>	
					</div>

				</form>

			<?php
		}
	} else {
			$_SESSION['message'] = 'Please add the number of batches!';
		?>
				<form method="POST" action="allotter.php">
					
					<div class="form_title">Number of batches*: </div>
					<input type="number" name="nob" placeholder="No. of batches" />
					<br /><br />
					
					<div class="submit">
						<button type="submit" name="submit_button" value="nob_submit">Submit</button>	
					</div>

				</form>
			

		<?php

	}

?>
	
				</div>

			</div>

		</div>

	</div>

</body>

</html>
