<?php
header("Content-Type: text/html; charset=UTF-8");
//header("Content-Type: image/png");
//print("</br>");

$raw_dots = explode("\r\n", file_get_contents("data.txt"));

		foreach ($raw_dots as &$data_1){
			parse_str($data_1, $output);
			$addrs[] = $output["addr"];
		}
		$unique_addrs = array_unique($addrs);
	?>
	<h3>Выберите адрес устройства</h3>
	<form action="index.php" method="get">
	   <p><select size="<?print(count($unique_addrs));?>" required name="addr">
		<?
		foreach ($unique_addrs as &$unique_addr){
			print("<option ".(($unique_addr == $_GET["addr"]) ? "selected":"")." value=\"".$unique_addr."\">".$unique_addr."</option>");
		}
		?>
	   </select>
	   <input type="submit" value="Получить информацию"></p>
	  </form>
	<?
if (!empty($_GET["addr"])) {
	//echo $_GET["addr"];
	$addr = $_GET["addr"];

	foreach ($raw_dots as &$data_1){
		parse_str($data_1, $output);
		
		if ($output["addr"] == $addr) {
			$dots[] = $output["moisture"];
			
		}
	}
	?>
	<html>
	  <head>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">

		   google.charts.load('current', {'packages':['line']});
		  google.charts.setOnLoadCallback(drawChart);

		function drawChart() {

		  var data = new google.visualization.DataTable();
		  data.addColumn('number', 'Day');
		  data.addColumn('number');

		  data.addRows([
		  <?
			$k = 1;
			for ($i=count($dots)-20;$i < count($dots);$i++){
				print("[".$k.", ".$dots[$i]."],");
				$k++;
			}
		  
		  ?>
			
		  ]);
		  var options = {
			chart: {
			  title: 'Влажность датчика №<?print($addr)?>',
			  subtitle: 'за последние 20 дней'
			},
			width: 900,
			height: 500
		  };

		  var chart = new google.charts.Line(document.getElementById('linechart_material'));

		  chart.draw(data, google.charts.Line.convertOptions(options));
		}
		</script>
	  </head>
	  <body>
		<!--Div that will hold the pie chart-->
		<div id="linechart_material"></div>
	  </body>
	</html>
<?
}
die();
?>
