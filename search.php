<?php
	include 'datalogin.php';
	
	$query = "SELECT LGA FROM happinessIndex.index WHERE LGA LIKE '".$_GET['term']."%'";
	
	$result = mysqli_query($con,$query);
	while($row = mysqli_fetch_array($result)){$contentArray[]=$row['LGA'];}
	mysqli_close($con);
	echo json_encode($contentArray); //pass content as JSON
?>