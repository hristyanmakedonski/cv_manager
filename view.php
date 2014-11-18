<?php 
/**
 * Description of update
 *
 * Here we see the presentation of all CV
 *
 * @author Hristiyan
 */
require_once './includes/header.php';
require_once './lib/Cv.php';
$CvObj = new Cv();
$result = $CvObj->View();
?>
<hr></hr>
<a href="./index.php">Back</a>
<hr></hr>
<?php foreach($result['personalinfo'] as $k=>$v): ?>
	<div> CV <?php echo $k; ?> <a href="./edit.php?cv=<?php echo $k; ?>"> View/Edit </a> </div>
	<div>
		<div> First name: <?php echo $v["first_name"];?> </div>
		<div> Last name: <?php echo $v["last_name"]; ?> </div>
		<div> Address: <?php echo $v["personal_address"]; ?> </div>
		<div >Phone: <?php echo $v["phone"]; ?> </div>
		<div> Birthday: <?php echo $v["birthday"]; ?> </div>
	<div>
<hr></hr>
<?php endforeach;?>
<?php require_once './includes/footer.php';?>