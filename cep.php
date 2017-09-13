<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>

<body>
    <form method="POST">
        <h1 class="text-center">Buscar CEP</h1>
        <input type="text" name="cep" value="<?php if(isset($_POST['cep'])){ echo $_POST['cep'];} ?>">
        <input type="submit" value="buscar">
        <?php
function get_endereco($cep)
{
	// verifica se foi passado apenas numeros de 0 a 9
	if($cep != preg_replace("/[^0-9]/", "", $cep))
	{
		echo "cep invalido";
	}else
	{
	$cep = preg_replace("/[^0-9]/", "", $cep);
	$url = "http://viacep.com.br/ws/$cep/xml/";
	$xml = simplexml_load_file($url);
	return $xml;
	}
}

if(isset ($_POST['cep']))
{	$cep = preg_replace("/[^0-9]/", "", $_POST['cep']);
	if($_POST['cep'] != preg_replace("/[^0-9]/", "", $cep) or strlen($cep)> 8 or strlen($cep)< 8 )
	{
		echo "<span class='error'>numero de cep invalido</span>";
	}else
	{
		// caso o cep não exista retorna cep inexistente
		$cep = $_POST['cep'];
		$endereco = (get_endereco($cep));
		if($endereco->erro == 'true')
		{
			echo "<span class='error'>numero de cep inexistente</span>";
		}else
		{
			echo "<input type='text'  name='logradouro' value='".$endereco->logradouro."'>";
			echo "<input type='text'  name='bairro' value='".$endereco->bairro."'>";
			echo "<input type='text'  name='localidade' value='".$endereco->localidade."-".$endereco->uf."'>";
			echo "<input type='submit'  value='Salvar' name='btn-enviar'> ";

		}
	}
}	
?>

    </form>
    <div class="salvo" id="salvo">
        <?php

if (isset($_POST['btn-enviar']))
{
	echo "<style>";
	echo "form{display: none;}";
	echo "</style>";
		echo "<style>";
	echo ".salvo{display: block;}";
	echo "</style>";
}
?>
            <h1>Informações salvas com sucesso !</h1>
            <ul>
                <li>
                    <?php if (isset($_POST['cep'])): echo $_POST['cep'];?>
                        <?php endif ?>
                </li>
                <li>
                    <?php if (isset($_POST['logradouro'])): echo $_POST['logradouro'];?>
                        <?php endif ?>
                </li>
                <li>
                    <?php if (isset($_POST['bairro'])): echo $_POST['bairro'];?>
                        <?php endif ?>
                </li>
                <li>
                    <?php if (isset($_POST['localidade'])): echo $_POST['localidade'];?>
                        <?php endif ?>
                </li>
            </ul>
            <button class="btn-voltar" onclick="myFunction()">
                Voltar
            </button>

    </div>
    <script>
        function myFunction() {
            document.getElementById("salvo").style.display = "none";
            history.back();
        }
    </script>
    <footer class="fixed-bottom text-center footer">
        <span>Desenvolvido pro: <a href="http://www.hublab.com.br" target="_blank">Andre Luiz</a> - <a href="https://github.com/4nd114" target="_blank">GitHub</a></span>
    </footer>
</body>

</html>