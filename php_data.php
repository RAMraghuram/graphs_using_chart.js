<?php
ob_start();
error_reporting(0);
// connection
$db_conx = mysqli_connect("localhost", "root", "", "db");
$dbh = mysqli_connect("localhost", "root", "", "healthcare");
// Evaluate the connection
if (mysqli_connect_errno()) {
    echo mysqli_connect_error("Our database server is down at the moment. :(");
    exit();
} 
//initialize variables
$patients = ' ';
$P_IDs=' ';
$L_b_ps=' ';
$H_b_ps=' ';
$s_levels=' ';
$weights= ' ';
$temps= ' ';
$h_rates= ' ';
$himoglobins= ' ';
$wbcs = ' ';
//Get lists from db
$sql = mysqli_query($db_conx, "SELECT  * FROM  phdata;");
$sql1 = mysqli_query($dbh, "SELECT * from diagnosis where PATIENT_ID='p16';");
$row1 = mysqli_fetch_array($sql1);
echo 'pid '.$row1[1];

echo '<br>';
//$sql = mysqli_query($db_conx, "SELECT  P_ID, L_b_p, H_b_p, s_level, weight, temp, h_rate, himoglobin, wbc FROM  phdata  ");

// if($row = mysql_fetch_array($sql)){
while($row = mysqli_fetch_array($sql)){
	$P_ID=$row['P_ID'];
	$L_b_p = $row['L_b_p'];
	$H_b_p = $row['H_b_p'];
	$s_level = $row['s_level'];
	$weight = $row['weight'];
	$temp = $row['temp'];
	$h_rate = $row['h_rate'];
	$himoglobin = $row['himoglobin'];
	$wbc=$row['wbc'];
	
	$P_IDs = $P_IDs. ' " ' .$P_ID.' ", ';
	$L_b_ps = $L_b_ps. ' " ' .$L_b_p.' ", ';
	$H_b_ps = $H_b_ps. ' " ' .$H_b_p.' ", ';
	$s_levels = $s_levels. ' " ' .$s_level.' ", ';
	$weights = $weights. ' " ' .$weight.' ", ';
	$temps = $temps. ' " ' .$temp.' ", ';
	$h_rates = $h_rates. ' " ' .$h_rate.' ", ';
	$himoglobins = $himoglobins. ' " ' .$himoglobin.' ", ';
	$wbcs = $wbcs. ' " ' .$wbc.' ", ';
}
// }elseif ($row = mysql_fetch_array($sql1)) {
	// $PULSE = $row['PULSE'];
	
	// $pulses = 
// }s
//$P_IDs = trim($P_IDS , ",");
$L_b_ps = trim($L_b_ps , ",");
// echo $L_b_ps;
// echo 'something';
$H_b_ps = trim($H_b_ps , ",");
$s_levels = trim($s_levels , ",");
$weights = trim($weights , ",");
$temps = trim($temps, ",");
$h_rates= trim($h_rates , ",");
$himoglobins = trim($himoglobins, ",");
$wbcs = trim($wbcs , ",");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="graph.css">

<title>graphs</title>
</head>

<body>
<div class ="container" >
	<div class = "row">
		<div class="col-lg-1 col-centered">
		<h1>Patient chart</h1>
		</div>
	</div>
</div>


<div class ="chart1">
<canvas id="Chart1" ></canvas>
</div>

<div class="chart2">
<canvas id="Chart2" ></canvas>
<div id="div1" style="display: none"><?php echo $row1[1] ?></div>
<div class="chart3">
<canvas id="Chart3" ></canvas>
</div>
    <!-- jQuery cdn -->
   <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="crossorigin="anonymous"></script>
    <!-- Chart.js cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>
    
</body>
</html><script>

      // chart DOM Element
      var ctx1 = document.getElementById("Chart1");
	  // var ctx2 = document.getElementById("Chart2");
	  // var ctx3 = document.getElementById("Chart3");
	  var x = document.getElementById("div1").innerHTML;
	  // console.log(typeof x);
	  var myarr = x.split(",");
	  var i, j = [];
      console.log('x: ',myarr[0]);
      for(i=0; i<myarr.length; i++){
      	j[i] = Number(myarr[i]);
      }
      // var j = Number:(myarr[0]);
      console.log('type: ',typeof j);
      console.log(j);
      var data = {
        datasets: [{
          data: j,
		  backgroundColor: 'transparent',
		  //backgroundColor: 'rgba(69, 92, 115, 0.5)',
		  backgroundColor: 'rgba(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ', 0.4)',
          //backgroundColor: "#455C73",
		  borderColor: "#000000",
		  borderWidth: 2,
          label: 'L_b_p' // for legend
        },{
          data: [<?php echo $H_b_ps; ?>],
		  backgroundColor: 'transparent',
		  borderColor: "#9BB6ff",
		  backgroundColor: 'rgba(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ', 0.4)',
		  borderWidth: 2,
		  // Changes this dataset to become a line
          //type: 'line',
          label: 'H_b_p' // for legend
        },{
          data: [<?php echo $s_levels; ?>],
		  backgroundColor: 'transparent',
		  borderColor: "#ff0000",
		  backgroundColor: 'rgba(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ', 0.4)',
		  borderWidth: 2,
		  // Changes this dataset to become a line
          //type: 'line',
          label: 's_level' // for legend
        },{
          data: [<?php echo $weights; ?>],
					backgroundColor:'transparent',
					borderColor:'#4000ff',
					backgroundColor: 'rgba(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ', 0.4)',
					hoverBackgroundColor:'rgba(200,200,200,1)',
					borderWidth: 2,
					hoverBorderColor:'rgba(200,200,200,1)',
          label: 'weight' // for legend
        },{
          data: [<?php echo $temps; ?>],
					backgroundColor:'transparent',
					borderColor:'#ff0040',
					backgroundColor: 'rgba(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ', 0.4)',
					borderWidth: 2,
					hoverBackgroundColor:'rgba(200,200,200,1)',
					hoverBorderColor:'rgba(200,200,200,1)',
          label: 'temp' // for legend
        },{
          data: [<?php echo $h_rates; ?>],
					backgroundColor:'transparent',
					borderColor:'#ffff00',
					backgroundColor: 'rgba(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ', 0.4)',
					hoverBackgroundColor:'rgba(200,200,200,1)',
					borderWidth: 2,
					hoverBorderColor:'rgba(200,200,200,1)',
          label: 'h_rate' // for legend
        },{
          data: [<?php echo $himoglobins; ?>],
					backgroundColor:'transparent',
					borderColor:'#808080',
					backgroundColor: 'rgba(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ', 0.4)',
					hoverBackgroundColor:'rgba(200,200,200,1)',
					borderWidth: 2,
					hoverBorderColor:'rgba(200,200,200,1)',
          label: 'himoglobin' // for legend
        }],
        labels: [
          <?php echo $P_IDs; ?>
        ]
      };
	  
      var xChart = new Chart(ctx1, {
	type:'bar',
        data: data,
		  });
		   var xChart = new Chart(ctx2, {
	type:'line',
        data: data,
		});
		   var xChart = new Chart(ctx3, {
	type:'radar',
        data: data,
		  });
</script>