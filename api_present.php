<html>
	<head>
		<link rel = "stylesheet" href = "weather_design.css">
	</head>
	<body>
		
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<select name = "area">
				<option value = "latitude=51.48&longitude=-3.18">Cardiff</option>;
				<option value = "latitude=51.51&longitude=-0.13">London</option>;
				<option value = "latitude=55.95&longitude=-3.20">Edinburgh</option>
			<input type="submit">
		</form>

		<?php
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$location = "https://api.open-meteo.com/v1/forecast?".$_POST["area"]."&hourly=temperature_2m,precipitation_probability,rain,windspeed_10m";
				$location2 = "https://air-quality-api.open-meteo.com/v1/air-quality?".$_POST["area"]."&hourly=pm10,pm2_5,european_aqi";
			}
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $location);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			$data = json_decode($response, true);
			?>
			
			
		<div class = "box">
			<div class = "content">
				<?php
					echo date("Y/m/d");
					echo "<h2>" .$data["hourly"]["temperature_2m"][0]. "°C</h2>";
					echo "<p>Precipitation Probability : " .$data["hourly"]["precipitation_probability"][0]. "%</p>";
					echo "<p>Windspeed : "  .$data["hourly"]["windspeed_10m"][0]. "</p>";
					
				?>
			</div>
		</div>
		<?php
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $location2);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			$quality = json_decode($response, true);
		?>
		<div class = "box">
			<div class = "content">
				<?php
					echo "<h2>" .(100-$quality["hourly"]["european_aqi"][0]). "%</h2>";
				?>
			</div>
		</div>
	</body>
</html>