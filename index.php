<?php

$resultado = '';

if (isset($_POST['expressao'])) {
    $expressao = $_POST['expressao'];
    
    try {
        $resultado = eval('return ' . $expressao . ';');
    } catch (Exception $e) {
        $resultado = 'Erro';
    }

    echo json_encode(['resultado' => $resultado]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="calculadora">
        <div class="display">
            <input type="text" name="expressao" id="expressao" readonly>
        </div>
        <div class="teclado">
            <div class="linha">
                <button type="button" class="botao especial" onclick="apagar()">←</button>
                <button type="button" class="botao especial" onclick="resetar()">C</button>
            </div>

            <div class="linha">
                <button type="button" class="botao" onclick="adicionarCaractere('7')">7</button>
                <button type="button" class="botao" onclick="adicionarCaractere('8')">8</button>
                <button type="button" class="botao" onclick="adicionarCaractere('9')">9</button>
                <button type="button" class="botao" onclick="adicionarCaractere('/')">/</button>
            </div>

            <div class="linha">
                <button type="button" class="botao" onclick="adicionarCaractere('4')">4</button>
                <button type="button" class="botao" onclick="adicionarCaractere('5')">5</button>
                <button type="button" class="botao" onclick="adicionarCaractere('6')">6</button>
                <button type="button" class="botao" onclick="adicionarCaractere('*')">*</button>
            </div>

            <div class="linha">
                <button type="button" class="botao" onclick="adicionarCaractere('1')">1</button>
                <button type="button" class="botao" onclick="adicionarCaractere('2')">2</button>
                <button type="button" class="botao" onclick="adicionarCaractere('3')">3</button>
                <button type="button" class="botao" onclick="adicionarCaractere('-')">-</button>
            </div>

            <div class="linha">
                <button type="button" class="botao" onclick="adicionarCaractere('0')">0</button>
                <button type="button" class="botao" onclick="adicionarCaractere('.')">.</button>
                <button type="button" class="botao" onclick="adicionarCaractere('+')">+</button>
                <button type="button" class="botao igual" onclick="calcular()">=</button>
            </div>
        </div>
    </div>

    <script>
        function adicionarCaractere(caractere) {
            let display = document.getElementById('expressao');
            display.value += caractere;
        }

        function calcular() {
            let display = document.getElementById('expressao');
            let expressao = display.value.trim();
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    let resposta = JSON.parse(xhr.responseText);
                    display.value = resposta.resultado;
                }
            };
            xhr.send('expressao=' + encodeURIComponent(expressao));
        }

        function apagar() {
            let display = document.getElementById('expressao');
            display.value = display.value.slice(0, -1);
        }

        function resetar() {
            let display = document.getElementById('expressao');
            display.value = '';
        }
    </script>
</body>
</html>
