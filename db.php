<?php
	include 'datalogin.php';
	
	$query = "SELECT * FROM happinessIndex.index As i INNER JOIN happinessIndex.housing As h INNER JOIN happinessIndex.community As c INNER JOIN happinessIndex.crime As cr INNER JOIN happinessIndex.health As he INNER JOIN happinessIndex.education As e INNER JOIN happinessIndex.jobs As j INNER JOIN happinessIndex.remoteness As r INNER JOIN happinessIndex.wealth w INNER JOIN happinessIndex.workLifeBalance wlb ON i.LGA_Code = h.LGA_Code AND i.LGA_Code = c.LGA_Code AND i.LGA_Code = cr.LGA_Code AND i.LGA_Code = he.LGA_Code AND i.LGA_Code = e.LGA_Code AND i.LGA_Code = j.LGA_Code AND i.LGA_Code = r.LGA_Code AND i.LGA_Code = w.LGA_Code AND i.LGA_Code = wlb.LGA_Code WHERE LGA = '".$_POST['LGA']."'";
	
	$result = mysqli_query($con,$query);
	while($row = mysqli_fetch_array($result)){$contentArray[]=$row;}
	mysqli_close($con);
	echo json_encode($contentArray); //pass content as JSON
?>