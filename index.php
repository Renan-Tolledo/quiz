<?php
include("testeconexao.php");

$sqlRanking = "
SELECT nome, xp_total
FROM ranking_usuarios
ORDER BY xp_total DESC
LIMIT 5
";

$ranking = $conn->query($sqlRanking);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">
<title>Menu</title>

<style>

body{
font-family: Arial;
background:#0f172a;
color:white;
text-align:center;
}

.container{
margin-top:120px;
}

button{
padding:15px 30px;
margin:10px;
border:none;
border-radius:10px;
cursor:pointer;
font-size:16px;
}

/* ranking */

.ranking{
margin-top:50px;
width:350px;
margin-left:auto;
margin-right:auto;
background:white;
color:black;
border-radius:10px;
padding:15px;
}

.ranking table{
width:100%;
border-collapse:collapse;
}

.ranking th{
background:#1e3a8a;
color:white;
padding:8px;
}

.ranking td{
padding:6px;
border-bottom:1px solid #ddd;
text-align:center;
}

</style>

</head>

<body>

<div class="container">

<h1>🎮 Sistema Educativo</h1>
<p>Escolha o modo de jogo:</p>

<a href="quiz.php"><button>📚 Jogar Quiz</button></a>

<a href="memoria.php"><button>🧠 Jogo da Memória</button></a>

<a href="verdadeiro_falso.php"><button>✔ Verdadeiro ou Falso</button></a>

<a href="identificar_golpe.php">
<button style="padding:15px;margin:10px;font-size:18px;">🔎 Identificador de Golpes</button>
</a>

<a href="ranking.php"><button>🏆 Ranking Completo</button></a>

</div>


<div class="ranking">

<h2>🏆 Top Jogadores</h2>

<table>

<tr>
<th>#</th>
<th>Nome</th>
<th>XP</th>
</tr>

<?php

$posicao = 1;

while($row = $ranking->fetch_assoc()){

if($posicao == 1) $medalha = "🥇";
elseif($posicao == 2) $medalha = "🥈";
elseif($posicao == 3) $medalha = "🥉";
else $medalha = $posicao;

?>

<tr>

<td><?php echo $medalha; ?></td>
<td><?php echo $row['nome']; ?></td>
<td><?php echo $row['xp_total']; ?></td>

</tr>

<?php
$posicao++;
}
?>

</table>

</div>

</body>
</html>