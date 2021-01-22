<?php 

function safe_print($value){
	$value .= "";
	return strlen($value) > 1 && (strpos($value, "0") !== false) ? ltrim($value, "0") : (strlen($value) == 0 ? "0" : $value);
}
if(!isset($_SESSION)){
	session_start();
}
if(isset($_SESSION['standby'])){

	// Lá está toda a sua configuração
	$_SESSION['standby'] = $_SESSION['standby']+1;

	$ad_ddos_query = 5;// Número de solicitações por segundo para detectar ataques DDOS
	$ad_check_file = 'check.txt';// arquivo para escrever o estado atual durante o monitoramento

	$ad_dir = 'anti_ddos/files';// diretório com scripts
	$ad_num_query = 0;// Número atual de solicitações por segundo de um arquivo $check_file
	$ad_sec_query = 0;// ​​segundo de um arquivo $check_file
	$ad_end_defense = 0;// Terminar enquanto protege o arquivo $check_file
	$ad_sec = date("s");// segundo atual
	$ad_date = date("is");// hora atual
	$ad_defense_time = 100;// tempo de detecção de ataque ddos em segundos, no qual interrompe o monitoramento
		

	$config_status = "";
	function Create_File($the_path){
		$handle = fopen($the_path, 'a+') or die('Cannot create file:  '.$the_path);
		return "Creating ".$the_path." .... done";
	}

	// TO verify the session start or not
	require ("{$ad_dir}/{$ad_check_file}");

	if ($ad_end_defense and $ad_end_defense> $ad_date) {
		
		$ad_num_query = ($ad_sec == $ad_sec_query) ? $ad_num_query++ : '1 ';
		$ad_file = fopen ("{$ad_dir}/{$ad_check_file}", "w");

		$ad_string = ($ad_num_query >= $ad_ddos_query) ? '<?php $ad_end_defense='.safe_print($ad_date + $ad_defense_time).'; ?>'
: '<?php $ad_num_query='. safe_print($ad_num_query) .'; $ad_sec_query='. safe_print($ad_sec) .'; ?>';

fputs ($ad_file, $ad_string);
fclose ($ad_file);
}
}else{

$_SESSION['standby'] = 1;
// Esse é o link que volta para a pagina atual
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") .
"://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
header("refresh:8,".$actual_link);
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Captcha</title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<meta name="author" content="Fabian Wennink © <?= date('Y') ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="assets/favicon.ico" rel="shortcut icon" type="image/x-icon" />
	<link href="assets\demo.css" rel="stylesheet" type="text/css">

	<!-- Include IconCaptcha stylesheet -->
	<link href="assets/css/icon-captcha.min.css" rel="stylesheet" type="text/css">

	<style type="text/css">
		.loading {
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		.loading__msg {
			font-family: Roboto;
			font-size: 16px;
		}

		.loading__dots {
			display: flex;
			flex-direction: row;
			width: 100%;
			justify-content: center;
			margin: 100px 0 30px 0;
		}

		.loading__dots__dot {
			background-color: #44BBA4;
			width: 20px;
			height: 20px;
			border-radius: 50%;
			margin: 0 5px;
			color: #587B7F;
		}

		.loading__dots__dot:nth-child(1) {
			animation: bounce 1s 1s infinite;
		}

		.loading__dots__dot:nth-child(2) {
			animation: bounce 1s 1.2s infinite;
		}

		.loading__dots__dot:nth-child(3) {
			animation: bounce 1s 1.4s infinite;
		}

		@keyframes bounce {
			0% {
				transform: translate(0, 0);
			}

			50% {
				transform: translate(0, 15px);
			}

			100% {
				transform: translate(0, 0);
			}
		}
	</style>
</head>

<body>
	<div class="loading" style="margin-top: 11%;">
		<div class="loading__dots">
			<div class="loading__dots__dot"></div>
			<div class="loading__dots__dot"></div>
			<div class="loading__dots__dot"></div>
		</div>
		<div class="loading__msg">
			<center>
				<b style="font-size: 22px;">
					ANTIDDOS is checking....
				</b>
				<br><br>
				Hi, don't worry, this is a simple security verfication,
				you will see this only one time;<br> your webpage will show up soon!
				</br>
				<div class="section">

					<!-- Apenas um formulário HTML básico, o captcha deve SEMPRE ser colocado DENTRO do <form> element -->
					<h2>Form:</h2>

					<?php
                    if(isset($captchaMessage)) {
                        echo '<b>Captcha Message: </b>' . $captchaMessage;
                    }
                ?>

					<form action="" method="post">

						<!-- Elemento que usamos para criar o IconCaptcha com -->
						<div class="captcha-holder"></div>

						<!-- Botão Enviar para testar seu IconCaptcha input -->
						<input type="submit" value="Submit demo captcha" class="btn">
					</form>
				</div>
			</center>
		</div>
	</div>
	<link href="//fonts.googleapis.com/css?family=Poppins:400,700" rel="stylesheet">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

	<script src="assets/js/icon-captcha.min.js" type="text/javascript"></script>

	<script async type="text/javascript">
		$(window).ready(function () {
			$('.captcha-holder').iconCaptcha({
					theme: ['light', 'dark'],
					fontFamily: '',
					clickDelay: 500,
					invalidResetDelay: 3000,
					requestIconsDelay: 1500,
					loadingAnimationDelay: 1500,
					hoverDetection: true,
					showCredits: 'show',
					enableLoadingAnimation: true,
					validationPath: 'src/captcha-request.php',
					messages: {
						header: "Selecione a imagem que não pertence à linha",
						correct: {
							top: "Great!",
							bottom: "Você não parece ser um robô."
						},
						incorrect: {
							top: "Oops!",
							bottom: "Você selecionou a imagem errada."
						}
					}
				})
				.bind('init.iconCaptcha', function (e, id) {
					console.log('Event: Captcha initialized', id);
				}).bind('selected.iconCaptcha', function (e, id) {
					console.log('Event: Icon selected', id);
				}).bind('refreshed.iconCaptcha', function (e, id) {
					console.log('Event: Captcha refreshed', id);
				}).bind('success.iconCaptcha', function (e, id) {
					console.log('Event: Correct input', id);
				}).bind('error.iconCaptcha', function (e, id) {
					console.log('Event: Wrong input', id);
				});
		});
	</script>
</body>

</html>

<?php exit();
}
?>