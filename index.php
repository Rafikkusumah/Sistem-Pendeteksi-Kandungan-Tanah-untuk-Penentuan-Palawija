<?php
header("refresh: 30");   
    include_once('esp-database.php');
    if ($_GET["readingsCount"]){
      $data = $_GET["readingsCount"];
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      $readings_count = $_GET["readingsCount"];
    }
    // default readings count set to 20
    else {
      $readings_count = 20;
    }

    $last_reading = getLastReadings();
    $last_reading_temp = $last_reading["suhu"];
    $last_reading_humi = $last_reading["kelembaban"];
    $last_reading_ph = $last_reading["ph"];
    $last_reading_time = $last_reading["created_at"];

    $min_temp = minReading($readings_count, 'suhu');
    $max_temp = maxReading($readings_count, 'suhu');
    $avg_temp = avgReading($readings_count, 'suhu');

    $min_humi = minReading($readings_count, 'kelembaban');
    $max_humi = maxReading($readings_count, 'kelembaban');
    $avg_humi = avgReading($readings_count, 'kelembaban');

    $min_ph = minReading($readings_count, 'ph');
    $max_ph = maxReading($readings_count, 'ph');
    $avg_ph = avgReading($readings_count, 'ph');
?>

<!DOCTYPE html>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <link rel="stylesheet" type="text/css" href="esp-style.css">
        <meta http-equiv=”refresh” content=”5″>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <header class="header">
        <h1>📊 Palawija Monitoring Station</h1>
        <form method="get">
            <input type="number" name="readingsCount" min="1" placeholder="Number of readings (<?php echo $readings_count; ?>)">
            <input type="submit" value="UPDATE">
        </form>
    </header>
<body>
    <p>Last reading: <?php echo $last_reading_time; ?></p>
    <section class="content">
	    <div class="box gauge--1">
	    <h3>TEMPERATURE</h3>
              <div class="mask">
			  <div class="semi-circle"></div>
			  <div class="semi-circle--mask"></div>
			</div>
		    <p style="font-size: 30px;" id="temp">--</p>
		    <table cellspacing="5" cellpadding="5">
		        <tr>
		            <th colspan="3">Temperature <?php echo $readings_count; ?> readings</th>
	            </tr>
		        <tr>
		            <td>Min</td>
                    <td>Max</td>
                    <td>Average</td>
                </tr>
                <tr>
                    <td><?php echo $min_temp['min_amount']; ?> &deg;C</td>
                    <td><?php echo $max_temp['max_amount']; ?> &deg;C</td>
                    <td><?php echo round($avg_temp['avg_amount'], 2); ?> &deg;C</td>
                </tr>
            </table>
        </div>
        <div class="box gauge--2">
            <h3>HUMIDITY</h3>
            <div class="mask">
                <div class="semi-circle"></div>
                <div class="semi-circle--mask"></div>
            </div>
            <p style="font-size: 30px;" id="humi">--</p>
            <table cellspacing="5" cellpadding="5">
                <tr>
                    <th colspan="3">Humidity <?php echo $readings_count; ?> readings</th>
                </tr>
                <tr>
                    <td>Min</td>
                    <td>Max</td>
                    <td>Average</td>
                </tr>
                <tr>
                    <td><?php echo $min_humi['min_amount']; ?> %</td>
                    <td><?php echo $max_humi['max_amount']; ?> %</td>
                    <td><?php echo round($avg_humi['avg_amount'], 2); ?> %</td>
                </tr>
            </table>
        </div>

        <div class="box gauge--3">
            <h3>pH</h3>
            <div class="mask">
                <div class="semi-circle"></div>
                <div class="semi-circle--mask"></div>
            </div>
            <p style="font-size: 30px;" id="ph">--</p>
            <table cellspacing="5" cellpadding="5">
                <tr>
                    <th colspan="3">ph <?php echo $readings_count; ?> readings</th>
                </tr>
                <tr>
                    <td>Min</td>
                    <td>Max</td>
                    <td>Average</td>
                </tr>
                <tr>
                    <td><?php echo $min_ph['min_amount']; ?> Value</td>
                    <td><?php echo $max_ph['max_amount']; ?> Value</td>
                    <td><?php echo round($avg_ph['avg_amount'], 2); ?> Value</td>
                </tr>
            </table>
        </div>
    </section>
    <?php
    echo   '<h2> View Latest ' . $readings_count . ' Readings</h2>
            <table cellspacing="5" cellpadding="5" id="tableReadings">
                <tr>
                    <th>ID</th>
                    <th>Suhu</th>
                    <th>Kelembaban</th>
                    <th>ph</th>
                    <th>Timestamp</th>
                    <th>Cabai Merah</th>
                    <th>Terong</th>
                    <th>Kacang Panjang</th>
                    <th>kol</th>
                    <th>Singkong</th>
                </tr>';

    $result = getAllReadings($readings_count);
        if ($result) {
        while ($row = $result->fetch_assoc()) {
            $row_id = $row["id"];
            $row_value1 = $row["suhu"];
            $row_value2 = $row["kelembaban"];
            $row_value3 = $row["ph"];
            $row_reading_time = $row["created_at"];
            $cabai_merah = $row["cabaimerah"];
            $terong = $row["terong"];
            $kacang_panjang = $row["kacangpanjang"];
            $kol = $row["kol"];
            $singkong = $row["singkong"];

            echo '<tr>
                    <td>' . $row_id . '</td>
                    <td>' . $row_value1 . '</td>
                    <td>' . $row_value2 . '</td>
                    <td>' . $row_value3 . '</td>
                    <td>' . $row_reading_time . '</td>
                    <td>' . $cabai_merah . '</td>
                    <td>' . $terong . '</td>
                    <td>' . $kacang_panjang . '</td>
                    <td>' . $kol . '</td>
                    <td>' . $singkong . '</td>
                  </tr>';
        }
        echo '</table>';
        $result->free();
    }
?>

<script>
    var suhu = <?php echo $last_reading_temp; ?>;
    var kelembaban = <?php echo $last_reading_humi; ?>;
    var ph = <?php echo $last_reading_ph; ?>;
    setTemperature(suhu);
    setHumidity(kelembaban);
    setph(ph);

    function setTemperature(curVal){
    	//set range for Temperature in Celsius -5 Celsius to 38 Celsius
    	var minTemp = -5.0;
    	var maxTemp = 38.0;
        //set range for Temperature in Fahrenheit 23 Fahrenheit to 100 Fahrenheit
    	//var minTemp = 23;
    	//var maxTemp = 100;

    	var newVal = scaleValue(curVal, [minTemp, maxTemp], [0, 180]);
    	$('.gauge--1 .semi-circle--mask').attr({
    		style: '-webkit-transform: rotate(' + newVal + 'deg);' +
    		'-moz-transform: rotate(' + newVal + 'deg);' +
    		'transform: rotate(' + newVal + 'deg);'
    	});
    	$("#temp").text(curVal + ' ºC');
    }

    function setHumidity(curVal){
    	//set range for Humidity percentage 0 % to 100 %
    	var minHumi = 0;
    	var maxHumi = 100;

    	var newVal = scaleValue(curVal, [minHumi, maxHumi], [0, 180]);
    	$('.gauge--2 .semi-circle--mask').attr({
    		style: '-webkit-transform: rotate(' + newVal + 'deg);' +
    		'-moz-transform: rotate(' + newVal + 'deg);' +
    		'transform: rotate(' + newVal + 'deg);'
    	});
    	$("#humi").text(curVal + ' %');
    }

    function setph(curVal){
    	
    	var minph = 0;
    	var maxph = 1000;

    	var newVal = scaleValue(curVal, [minph, maxph], [0, 180]);
    	$('.gauge--3 .semi-circle--mask').attr({
    		style: '-webkit-transform: rotate(' + newVal + 'deg);' +
    		'-moz-transform: rotate(' + newVal + 'deg);' +
    		'transform: rotate(' + newVal + 'deg);'
    	});
    	$("#ph").text(curVal + ' Value');
    }
    
    function scaleValue(value, from, to) {
        var scale = (to[1] - to[0]) / (from[1] - from[0]);
        var capped = Math.min(from[1], Math.max(from[0], value)) - from[0];
        return ~~(capped * scale + to[0]);
    }
</script>
</body>
</html>
