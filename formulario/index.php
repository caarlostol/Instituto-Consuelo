<?php
    $message = '';
    if(isset($_POST['submit']))
    {
        include_once('config.php');
        
        $Nome = mysqli_real_escape_string($conexao, $_POST['nome']);
        $Email = mysqli_real_escape_string($conexao, $_POST['email']);
        $Telefone = mysqli_real_escape_string($conexao, $_POST['telefone']);
        $Sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);
        $Data_nasc = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);
        $Endereco = mysqli_real_escape_string($conexao, $_POST['endereco']);
        $Cidade = mysqli_real_escape_string($conexao, $_POST['cidade']);
        $Estado = mysqli_real_escape_string($conexao, $_POST['estado']);

        $query = "INSERT INTO usuario (nome, email, telefone, sexo, data_nasc, endereco, cidade, estado) 
                  VALUES ('$Nome', '$Email', '$Telefone', '$Sexo', '$Data_nasc', '$Endereco', '$Cidade', '$Estado')";

        $result = mysqli_query($conexao, $query);

        if(!$result) {
            $message = "Erro no cadastro: " . mysqli_error($conexao);
        } else {
            $message = "Usuário cadastrado com sucesso!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cadastro</title>
    <link rel="stylesheet" href="forms.css"/>
    <style>
        .notification {
            display: none;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }
        .notification.show {
            display: block;
            animation: fadeIn 0.5s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="notification" id="notification">
        <?php echo $message; ?>
    </div>

    <script>
        function showNotification() {
            var notification = document.getElementById('notification');
            notification.classList.add('show');
            setTimeout(function() {
                notification.classList.remove('show');
            }, 5000);
        }

        window.onload = function() {
            <?php if ($message != '') { ?>
                showNotification();
            <?php } ?>
        };
    </script>
    <div class="box">
        <form action="index.php" method="POST">
            <fieldset>
                <legend><b>Fórmulário de Cadastro</b></legend>
                <br>
                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Nome completo</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="email" id="email" class="inputUser" required>
                    <label for="email" class="labelInput">Email</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="tel" name="telefone" id="telefone" class="inputUser" required>
                    <label for="telefone" class="labelInput">Telefone</label>
                </div>
                <p>Sexo:</p>
                <input type="radio" id="feminino" name="sexo" value="feminino" required>
                <label for="feminino">Feminino</label>
                <br>
                <input type="radio" id="masculino" name="sexo" value="masculino" required>
                <label for="masculino">Masculino</label>
                <br>
                <input type="radio" id="outro" name="sexo" value="outro" required>
                <label for="outro">Outro</label>
                <br><br>
                <label for="data_nascimento"><b>Data de Nascimento:</b></label>
                <input type="date" name="data_nascimento" id="data_nascimento" required>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="endereco" id="endereco" class="inputUser" required>
                    <label for="endereco" class="labelInput">Endereço</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="cidade" id="cidade" class="inputUser" required>
                    <label for="cidade" class="labelInput">Cidade</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="estado" id="estado" class="inputUser" required>
                    <label for="estado" class="labelInput">Estado</label>
                </div>
                <br><br>
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </form>
    </div>
</body>
</html>
