<?php

    $host = "localhost";		                 // Host
    $dbname = "id17948051_esp8266";             // Nome Banco
    $username = "id17948051_pi_esp8266";	    // Usuário Banco
    $password = "e3|&5OCSW)5s55&O";	           // Senha Banco


// Conexão com o banco
$conn = new mysqli($host, $username, $password, $dbname);


// Verifica se a conexão foi estabelecida
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else { echo "Conexão realizada com sucesso!";}

   
// Recuperando a data e hora
    date_default_timezone_set('America/Sao_Paulo');  // https://www.php.net/manual/en/timezones
    $d = date("Y-m-d");
    $t = date("H:i:s");
    
// Se os valores enviados do NodeMCU não forem vazios, então insere no banco MySQL
  if(!empty($_POST['sendcorrente']) && !empty($_POST['sendtensao']) )
    {
		$corrente = $_POST['sendcorrente'];
        $tensao = $_POST['sendtensao'];
        $consumoPot = floatval($_POST['sendpotencia']);
        $potencia = strval($consumoPot/1200);


// Atualiza os dados na tabela
	       $sql = "INSERT INTO ValoresRede (Corrente, Tensao, Potencia, Data, Hora) VALUES ('".$corrente."','".$tensao."', '". $potencia ."', '".$d."', '".$t."')"; 
            //$sql = "UPDATE ValoresRede SET Corrente='".$corrente."',Tensao='".$tensao."',Data='".$d."',Hora='".$t."' WHERE idDado=4"; 
           


		if ($conn->query($sql) === TRUE) {
		    echo "Valores inserido na tabela.";
		} else {
		    echo "Erro: " . $sql . "<br>" . $conn->error;
		}
	}


// Fecha a conexão
$conn->close();



?>
