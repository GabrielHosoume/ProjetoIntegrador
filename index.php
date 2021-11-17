<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset ="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <title>PI - Univesp</title>
        <link rel="stylesheet" href="/style.css" type="text/css"/>
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <script src="https://kit.fontawesome.com/b6a32c201a.js" crossorigin="anonymous"></script>
        <meta http-equiv="refresh" content="5"/>
    </head>
    <body>



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
}


// Query para recuperar os dados do banco


// Recuperando os dados do log
	$sql = "SELECT idDado, Corrente, Tensao, Potencia, Data, Hora FROM ValoresRede ORDER BY idDado DESC LIMIT 1"; 
	$result = $conn->query($sql);


if ($result->num_rows > 0) {


    // Saída dos dados recuperados pela query
    while($row = $result->fetch_assoc()) {
        $_POST['idDado'] = $row["idDado"];
		$_POST['Corrente'] = $row["Corrente"];
		$_POST['Tensao'] = $row["Tensao"];
        $_POST['Potencia'] = $row["Potencia"];
        $_POST['Data'] = $row["Data"];
        $_POST['Hora'] = $row["Hora"];

}
} else {
    echo "0 results";
}

echo "</center>";


// Recuperando o valor de Watts consumido no dia
$sqlConsumo = "SELECT SUM(Potencia/1000) as consumoPotencia, ((SELECT SUM(Potencia/1000) FROM ValoresRede WHERE Data = current_date()) * 0.92 ) as consumo FROM ValoresRede WHERE Data = current_date()"; 
$result2 = $conn->query($sqlConsumo);


if ($result2->num_rows > 0) {


// Saída dos dados recuperados pela query
while($row = $result2->fetch_assoc()) {
    $consumoP = number_format((float)$row["consumoPotencia"], 3, '.', '');
    $consumoR = number_format((float)$row["consumo"], 2, '.', '');
    $_POST['consumoPotencia'] = $consumoP;
    $_POST['consumoReais'] = $consumoR;

}
} else {
echo "0 results";
}

echo "</center>";

$conn->close();



?>

        <div class="back">
            <a href="#">
            <i class='bx bx-arrow-back'></i>
            </a>
        </div>

        <div class="wrapper">
            <div class="wrapper-type1">
                <h1 class="h1-title">Medidor de Energia - Projeto Integrador Univesp</h1>
            </div>
            <div class="detail">
                <h3><?php echo "Data: &nbsp" . $_POST['Data'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hora:&nbsp;" . $_POST['Hora'] ?></h3>
            </div>
            <div class="ampere">
                <h3>Corrente (A)</h3>
                <div class="info">
                    <h1 id="corrente"><?php echo $_POST['Corrente'] . "&nbspA" ?></h1>
                </div>
            </div>
            <div class="voltage">
                <h3>Tensão (V)</h3>
                <div class="info">
                    <h1 id="tensao"><?php echo $_POST['Tensao'] . "&nbspV" ?></h1>
                </div>
            </div>
            <div class="potencia">
                <h3>Potência (W)</h3>
                <div class="info">
                    <h1 id="potencia"></h1>
                </div>
            </div>

            

            <div class="dados-monitor">
                <h3>Consumo atual do dia</h3>
                <div class="kWh-preco"><h4 class="kWh-txt">Preço kWh: R$ 0,92</h4></div>
            </div>


            <div class="kWh">
                <h3>Consumo total(kW)</h3>
                <div class="info">
                    <h1 id="kWh"><?php echo $_POST['consumoPotencia'] . "&nbspKw" ?></h1>
                </div>
            </div>

            <div class="consumo">
                <h3>Consumo em Reais (R$)</h3>
                <div class="info">
                    <h1 id="consumo"><?php echo "R$&nbsp" . $_POST['consumoReais']?></h1>
                </div>
           
        </div>

        <script>

            var V = parseInt(document.getElementById("tensao").innerText.substring(0,3));

            var A = parseInt(document.getElementById("corrente").innerText.substring(0,1));

            var P = V * A;

            document.getElementById("potencia").innerText = P + " W";

        </script>
    </body>
    </html>