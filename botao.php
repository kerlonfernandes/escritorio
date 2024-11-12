<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Botão Animado</title>
    <!-- Incluindo jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @charset "UTF-8";

        * {
            font-family: "Roboto", sans-serif;
        }

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -65px;
            margin-top: -20px;
            width: 130px;
            height: 40px;
            text-align: center;
        }

        button {
            outline: none;
            height: 40px;
            text-align: center;
            width: 130px;
            border-radius: 40px;
            background: #fff;
            border: 2px solid #1ECD97;
            color: #1ECD97;
            letter-spacing: 1px;
            text-shadow: 0;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        button:hover {
            color: white;
            background: #1ECD97;
        }

        button:active {
            letter-spacing: 2px;
        }

        button:after {
            content: "SUBMIT";
        }

        .onclic {
            width: 40px;
            border-color: #bbbbbb;
            border-width: 3px;
            font-size: 0;
            border-left-color: #1ECD97;
            -webkit-animation: rotating 2s 0.25s linear infinite;
            animation: rotating 2s 0.25s linear infinite;
        }

        .onclic:after {
            content: "";
        }

        .onclic:hover {
            color: #1ECD97;
            background: white;
        }

        .validate {
            font-size: 13px;
            color: white;
            background: #1ECD97;
        }

        .validate:after {
            font-family: "FontAwesome";
            content: "";
        }

        @-webkit-keyframes rotating {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes rotating {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>

<div class="container">
    <button id="button"></button>
</div>

<script>
    $(function() {
        $("#button").click(function() {
            $(this).addClass("onclic", 250, validate);
        });

        function validate() {
            setTimeout(function() {
                $("#button").removeClass("onclic");
                $("#button").addClass("validate", 450, callback);
                $("#button").text("Enviado"); // Atualizando o texto para "Enviado"
            }, 2250);
        }

        function callback() {
            setTimeout(function() {
                $("#button").removeClass("validate");
                $("#button").text("SUBMIT"); // Restaurando o texto original após 1.25 segundos
            }, 1250);
        }
    });
</script>

</body>
</html>
