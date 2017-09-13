<?php
require_once __DIR__ . '/src/functions.php';
$hasError = false;
$cep = filter_input(INPUT_POST, 'cep');

if (strlen($cep)) {
    try {
        $endereco = getEndereco($cep);
    } catch (\Exception $e) {
        $hasError = true;
        $errorMessage = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
          integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>

<body>
<form method="POST" action="cep.php">
    <h1 class="text-center">Buscar CEP</h1>
    <input type="text" name="cep" value="<?php echo $cep; ?>">
    <input type="submit" value="buscar">
    <?php
    if ($hasError) {
        echo "<div class='alert alert-danger'>{$errorMessage}</div>";
    } elseif (isset($endereco) && count($endereco) > 1) {
        echo "<input type='text'  name='logradouro' value='{$endereco['logradouro']}'>";
        echo "<input type='text'  name='bairro' value='{$endereco['bairro']}'>";
        echo "<input type='text'  name='localidade' value='{$endereco['localidade']}-{$endereco['uf']}'>";
        echo "<input type='submit'  value='Salvar' name='btn-enviar'> ";
    }

    ?>

</form>
<div class="salvo" id="salvo">
    <?php
    $btnEnviar = filter_input(INPUT_POST, 'btn-enviar');

    if ($btnEnviar) {
        echo "<style>";
        echo "\tform {\n\t\tdisplay: none;\n}";
        echo "\t.salvo {\n\t\tdisplay: block;\n}";
        echo "</style>";
    }
    ?>
    <h1>Informações salvas com sucesso!</h1>
    <ul>
        <li><?php echo filter_input(INPUT_POST, 'cep'); ?></li>
        <li><?php echo filter_input(INPUT_POST, 'logradouro'); ?></li>
        <li><?php echo filter_input(INPUT_POST, 'bairro'); ?></li>
        <li><?php echo filter_input(INPUT_POST, 'localidade'); ?></li>

    </ul>
    <button class="btn-voltar" onclick="myFunction()">Voltar</button>

</div>
<footer class="fixed-bottom text-center footer">
    <span>Desenvolvido pro: <a href="http://www.hublab.com.br" target="_blank">Andre Luiz</a> - <a
                href="https://github.com/4nd114" target="_blank">GitHub</a></span>
</footer>

<script>
    function myFunction() {
        document.getElementById("salvo").style.display = "none";
        history.back();
    }
</script>

</body>

</html>