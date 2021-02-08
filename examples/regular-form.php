<?php
 
    session_start();

	require('../src/captcha-session.class.php');
    require('../src/captcha.class.php');

    IconCaptcha::setIconsFolderPath('../assets/icons/');


    IconCaptcha::setIconNoiseEnabled(true);

    if(!empty($_POST)) {
        if(IconCaptcha::validateSubmission($_POST)) {
            // Colocar o Link Aqui dentro para que o Capcha retorne a pagina
            
            $captchaMessage = 'correto';
            echo "<meta http-equiv='refresh' content='3;URL=../cokie.html'>";
        } else {
            $captchaMessage = json_decode(IconCaptcha::getErrorMessage())->error;
        }
    }
?>
<!DOCTYPE HTML>
<html>
    <head>
    <script>
    function get_current_url() {
      document.write(window.location.href);
      return null;
    }

  </script>

        <title>NEcon Segurança</title>
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

                <!-- Just a basic HTML form, captcha should ALWAYS be placed WITHIN the <form> element -->
                <h2>Form:</h2>

                <?php
                    if(isset($captchaMessage)) {
                        echo '<b>Captcha Message: </b>' . $captchaMessage;
                    }
                ?>

                <form action="" method="post">

                    <!-- Element that we use to create the IconCaptcha with -->
                    <div class="captcha-holder"></div>

                    <!-- Submit button to test your IconCaptcha input -->
                    <input type="submit" value="Submit demo captcha" class="btn" >
                </form>
            </div>

          

        


        <!-- Include Google Font - Just for demo page -->
        <link href="//fonts.googleapis.com/css?family=Poppins:400,700" rel="stylesheet">

        <!-- Include jQuery Library -->
        <!--[if lt IE 9]>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
        <![endif]-->

        <!--[if (gte IE 9) | (!IE)]><!-->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <!--<![endif]-->

        <!-- Include IconCaptcha script -->
        <script src="../assets/js/icon-captcha.min.js" type="text/javascript"></script>

        <!-- Initialize the IconCaptcha -->
        <script async type="text/javascript">
            $(window).ready(function() {
                $('.captcha-holder').iconCaptcha({
                    theme: ['light', 'dark'], // Selecione o (s) tema (s) do (s) Captcha (s).Disponível: claro, escuro
                    fontFamily: '', // Altere a família da fonte do captcha.Deixá-lo em branco adicionará a fonte padrão ao final do <body> tag.
                    clickDelay: 500, // O atraso durante o qual o usuário não consegue selecionar uma imagem.
                    invalidResetDelay: 1000, // Depois de quantos milissegundos o captcha deve ser redefinido após uma seleção de ícone incorreta.
                    requestIconsDelay: 800, // Quanto tempo o script deve esperar antes de solicitar os hashes e ícones? (to prevent a high(er) CPU usage during a DDoS attack)
                    loadingAnimationDelay: 500, // Por quanto tempo a animação falsa de carregamento deve ser reproduzida.
                    hoverDetection: true, // Ative ou desative a detecção de passagem do cursor.
                    showCredits: 'show', // Mostre, oculte ou desative o elemento de créditos.Valores válidos: 'show', 'hide', 'disabled' (por favor deixe habilitado).
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
                    .bind('init.iconCaptcha', function(e, id) { // You can bind to custom events, in case you want to execute some custom code.
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