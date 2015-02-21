<?php

$varConfig = parse_ini_file("./config.ini");

@$varGetBitStampAPI = json_decode(file_get_contents('https://www.bitstamp.net/api/ticker/'));
@$varBitStampPrice = $varGetBitStampAPI->last;

@$varGetBitFinexAPI = json_decode(file_get_contents('https://api.bitfinex.com/v1/pubticker/btcusd/'));
@$varBitFinexPrice = $varGetBitFinexAPI->last_price;

@$varGetBTCEAPI = json_decode(file_get_contents('https://btc-e.com/api/3/ticker/btc_usd/'));
@$varBTCEPrice = $varGetBTCEAPI->btc_usd->last;

@$varAverageArr = array(
	0 =>  $varBitStampPrice,
	1 =>  $varBitFinexPrice,
	2 =>  $varBTCEPrice
);

@$varAverage = array_sum($varAverageArr) / count($varAverageArr); 

@$varGetXRateAPI = json_decode(file_get_contents('http://api.fixer.io/latest?base=USD'));

@$varEURRate = $varGetXRateAPI->rates->EUR;
@$varCADRate = $varGetXRateAPI->rates->CAD;
@$varGBPRate = $varGetXRateAPI->rates->GBP;
@$varAUDRate = $varGetXRateAPI->rates->AUD;

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Text Here</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link href='http://fonts.googleapis.com/css?family=Dosis:300' rel='stylesheet' type='text/css'>
		

		
	</head>

	<body>
		<div class="containerDiv">
			<div class="bodyHeader">
				<div class="logoDiv">
					<span>Text Here</span>
				</div>
				<div class="titleDiv">
					<span>Title Here</span>
				</div>


			</div>
			
			<div class="bodyValues">
				<div class="exchangesDiv">
				an average of <br>
				<span class="tickSpan">&#10004;</span> Bitstamp
				<span class="tickSpan">&#10004;</span> Bitfinex
				<span class="tickSpan">&#10004;</span> BTC-E
			</div>
				<div class="currDiv">
					<input type="text" class="inputStandard" id="currInput" value="1" onchange="currConvert(this.value)" onkeyup="currConvert(this.value)">
					<input type="text" class="inputGrey" value="<?php echo $varConfig['coin']; ?>" disabled>
				</div>
				<div class="equalsDiv">
					<span class="bodyEquals">=</span>
				</div>
				<div class="fiatDiv">
				    <input type="text" class="inputStandard" id="fiatInput" value="<?php echo number_format($varAverage, 2); ?>" onchange="fiatConvert(this.value)" onkeyup="fiatConvert(this.value)">
					<select class="selectGrey" id="selectBox" onchange="currConvert(this.value)">
					  <option value="USD">USD</option>
					  <option value="GBP">GBP</option>
					  <option value="EUR">EUR</option>
					  <option value="CAD">CAD</option>
					  <option value="AUD">AUD</option>
					</select>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			function fiatConvert(Value)
			{
				var fiatAmount = document.getElementById("fiatInput").value;
				var currValue = document.getElementById("currInput");
				if (document.getElementById('selectBox').value=='USD') {
				var value = fiatAmount / <?php echo number_format($varAverage, 2); ?>;
				currValue.value = value.toFixed(8);
				} else if (document.getElementById('selectBox').value=='GBP') {
					var value = (fiatAmount / <?php echo number_format($varAverage, 2); ?>) / <?php echo $varGBPRate; ?>;
					currValue.value = value.toFixed(8);
				} else if (document.getElementById('selectBox').value=='EUR') {
					var value = (fiatAmount / <?php echo number_format($varAverage, 2); ?>) / <?php echo $varEURRate; ?>;
					currValue.value = value.toFixed(8);
				} else if (document.getElementById('selectBox').value=='CAD') {
					var value = (fiatAmount / <?php echo number_format($varAverage, 2); ?>) / <?php echo $varCADRate; ?>;
					currValue.value = value.toFixed(8);
				} else if (document.getElementById('selectBox').value=='AUD') {
					var value = (fiatAmount / <?php echo number_format($varAverage, 2); ?>) / <?php echo $varAUDRate; ?>;
					currValue.value = value.toFixed(8);
				}
				$('#currInput').autoGrow(30);
		    	$('#fiatInput').autoGrow(30);
			}
		</script>
		<script type="text/javascript">
			function currConvert(Value)
			{
				var amount = document.getElementById("currInput").value;
				var fiatValue = document.getElementById("fiatInput");
				var value = amount * <?php echo number_format($varAverage, 2); ?>;
				if (document.getElementById('selectBox').value=='USD') {
					var value = amount * <?php echo number_format($varAverage, 2); ?>;
					fiatValue.value = value.toFixed(2);
				} else if (document.getElementById('selectBox').value=='GBP') {
					var value = (amount * <?php echo number_format($varAverage, 2); ?>) * <?php echo $varGBPRate; ?>;
					fiatValue.value = value.toFixed(2);
				} else if (document.getElementById('selectBox').value=='EUR') {
					var value = (amount * <?php echo number_format($varAverage, 2); ?>) * <?php echo $varEURRate; ?>;
					fiatValue.value = value.toFixed(2);
				} else if (document.getElementById('selectBox').value=='CAD') {
					var value = (amount * <?php echo number_format($varAverage, 2); ?>) * <?php echo $varCADRate; ?>;
					fiatValue.value = value.toFixed(2);
				} else if (document.getElementById('selectBox').value=='AUD') {
					var value = (amount * <?php echo number_format($varAverage, 2); ?>) * <?php echo $varAUDRate; ?>;
					fiatValue.value = value.toFixed(2);
				}
				
				$('#currInput').autoGrow(30);
		    	$('#fiatInput').autoGrow(30);
			}
		</script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="./jquery-autogrow.min.js"></script>
		<script type="text/javascript">
		    $('#currInput').autoGrow(30);
		    $('#fiatInput').autoGrow(30);
		</script>
	
	</body>

</html>