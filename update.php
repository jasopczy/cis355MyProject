<?php 
	
	// filename: update.php, Joshua Sopczynski, cis355, 2015-03-30
	
	session_start();
	if ($_SESSION["id"] != "loggedIn")
		header("Location: login.php");	
	
	require 'database.php';

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$animalError = null;
		$breedError = null;
		$colorError = null;
		
		
		// keep track post values
		$name = $_POST['name'];
		$animal = $_POST['animal'];
		$breed = $_POST['breed'];
		$color = $_POST['color'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($animal)) {
			$animalError = 'Please enter Animal';
			$valid = false;
		
		}
		
		if (empty($breed)) {
			$breedError = 'Please enter Breed';
			$valid = false;
		
		}
		if (empty($color)) {
			$colorError = 'Please enter Color';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE Animals  set name = ?, animal = ?, breed =?, color =? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$animal,$breed,$color,$id));
			Database::disconnect();
			header("Location: index.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Animals where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$name = $data['name'];
		$animal = $data['animal'];
		$breed = $data['breed'];
		$color = $data['color'];
		Database::disconnect();
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Update An Animal</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($animalError)?'error':'';?>">
					    <label class="control-label">Animal</label>
					    <div class="controls">
					      	<input name="animal" type="text" placeholder="Animal" value="<?php echo !empty($animal)?$animal:'';?>">
					      	<?php if (!empty($animalError)): ?>
					      		<span class="help-inline"><?php echo $animalError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($breedError)?'error':'';?>">
					    <label class="control-label">Breed</label>
					    <div class="controls">
					      	<input name="breed" type="text"  placeholder="Breed" value="<?php echo !empty($breed)?$breed:'';?>">
					      	<?php if (!empty($breedError)): ?>
					      		<span class="help-inline"><?php echo $breedError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($colorError)?'error':'';?>">
					    <label class="control-label">Color</label>
					    <div class="controls">
					      	<input name="color" type="text"  placeholder="Color" value="<?php echo !empty($color)?$color:'';?>">
					      	<?php if (!empty($colorError)): ?>
					      		<span class="help-inline"><?php echo $colorError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="index.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>