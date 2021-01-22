<?php
   

    // Start a PHP session.
    session_start();

    // Include the IconCaptcha classes.
	require('../src/captcha-session.class.php');
    require('../src/captcha.class.php');

    // DEFAULT IS SET TO ../icons/
    IconCaptcha::setIconsFolderPath('../assets/icons/');

    // NOTE: Ativar isso pode causar um ligeiro aumento no uso da CPU.
    IconCaptcha::setIconNoiseEnabled(true);

    // Se o formulário foi enviado, valide o captcha.
    if(!empty($_POST)) {
        if(IconCaptcha::validateSubmission($_POST)) {
            // Formulario Enviado com sucesso.
            $captchaMessage = 'O formulário foi enviado!';
        } else {
            $captchaMessage = json_decode(IconCaptcha::getErrorMessage())->error;
        }
    }
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Captcha</title>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
        <meta name="author" content="Fabian Wennink © <?= date('Y') ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="../assets/favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <link href="../assets/demo.css" rel="stylesheet" type="text/css">

        <!-- Include IconCaptcha stylesheet -->
        <link href="../assets/css/icon-captcha.min.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container">

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
                    <input type="submit" value="Submit demo captcha" class="btn" >
                </form>
            </div>

        <!-- Include Google Font - Just for demo page -->
        <link href="//fonts.googleapis.com/css?family=Poppins:400,700" rel="stylesheet">

        <!--[if (gte IE 9) | (!IE)]><!-->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <!--<![endif]-->

        <!-- Include IconCaptcha script -->
        <script src="../assets/js/icon-captcha.min.js" type="text/javascript"></script>

        <!-- Inicialize o IconCaptcha -->
        <script async type="text/javascript">
            $(window).ready(function() {
                $('.captcha-holder').iconCaptcha({
                    theme: ['light', 'dark'], // Selecione o (s) tema (s) do (s) Captcha (s).acessível: light, dark
                    fontFamily: '', // Altere a família da fonte do captcha.Deixá-lo em branco adicionará a fonte padrão ao final do<body> tag.
                    clickDelay: 500, // O atraso durante o qual o usuário não consegue selecionar uma imagem.
                    invalidResetDelay: 3000, // Após quantos milissegundos, o captcha deve ser redefinido após uma seleção de ícone incorreta.
                    requestIconsDelay: 1500, //Quanto tempo o script deve esperar antes de solicitar os hashes e ícones?(para evitar um alto (er) uso da CPU durante um ataque DDoS)
                    loadingAnimationDelay: 1500, // Por quanto tempo a animação falsa de carregamento deve ser reproduzida.
                    hoverDetection: true, // Ative ou desative a detecção de passagem do cursor.
                    showCredits: 'show', // Mostre, oculte ou desative o elemento de créditos.Valores válidos: 'show', 'ocultar', 'desabilitado' (por favor, deixe habilitado).
                    enableLoadingAnimation: true, // Ative ou desative a animação de carregamento falso.Na verdade, não faz nada além de ter uma boa aparência.
                    validationPath: '../src/captcha-request.php', // O caminho para o arquivo de validação Captcha.
                    messages: { // Você pode colocar a mensagem que quiser no captcha.
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
                    .bind('init.iconCaptcha', function(e, id) { // Você pode vincular a eventos personalizados, caso queira executar algum código personalizado.
                        console.log('Event: Captcha initialized', id);
                    }).bind('selected.iconCaptcha', function(e, id) {
                    console.log('Event: Icon selected', id);
                }).bind('refreshed.iconCaptcha', function(e, id) {
                    console.log('Event: Captcha refreshed', id);
                }).bind('success.iconCaptcha', function(e, id) {
                    console.log('Event: Correct input', id);
                }).bind('error.iconCaptcha', function(e, id) {
                    console.log('Event: Wrong input', id);
                });
            });
        </script>
    </body>
</html>