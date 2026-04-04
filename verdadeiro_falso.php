<?php
session_start();
if(!isset($_SESSION['combo'])){
    $_SESSION['combo'] = 0;
}
if(!isset($_SESSION['bonus3'])){
    $_SESSION['bonus3'] = false;
}

if(!isset($_SESSION['bonus5'])){
    $_SESSION['bonus5'] = false;
}
$_SESSION['id_usuario'] = 1;
include("testeconexao.php");
include("xp.php");

if (!isset($_SESSION['vf_pergunta'])) {
    $_SESSION['vf_pergunta'] = 1;
}

$id = $_SESSION['vf_pergunta'];

$sql = "SELECT * FROM verdadeiro_falso WHERE id_pergunta = $id";
$result = $conn->query($sql);
$pergunta = $result->fetch_assoc();

if (!$pergunta) {

    echo "<h1>Fim do questionário</h1>";
    echo '<a href="index.php"><button>Voltar ao menu</button></a>';
    session_destroy();
    exit();
}

$resposta_dada = false;
$mensagem = "";
$explicacao = "";

if (isset($_POST['resposta'])) {

    $resposta_usuario = $_POST['resposta'];
    $resposta_dada = true;

if ($resposta_usuario == $pergunta['resposta_correta']) {

    $_SESSION['combo']++;

    $xp = 5;
    $bonus = 0;

    if($_SESSION['combo'] == 3 && !$_SESSION['bonus3']){
        $bonus = 10;
        $_SESSION['bonus3'] = true;
    }

    if($_SESSION['combo'] == 5 && !$_SESSION['bonus5']){
        $bonus = 20;
        $_SESSION['bonus5'] = true;
    }

    $xp_total = $xp + $bonus;

    adicionarXP($conn, $_SESSION['id_usuario'], $xp_total);

    $mensagem = "✅ Resposta correta! +$xp XP";

    if($bonus > 0){
        $mensagem .= "<br>🔥 Bônus de sequência +$bonus XP";
    }

} else {

    $_SESSION['combo'] = 0;

    $mensagem = "❌ Resposta incorreta! Sequência reiniciada.";

}

    $explicacao = $pergunta['explicacao'];
}

if (isset($_POST['proxima'])) {

    $_SESSION['vf_pergunta']++;
    header("Location: verdadeiro_falso.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Verdadeiro ou Falso</title>

<style>
body{
font-family:Arial;
background:#0f172a;
color:white;
text-align:center;
}

button{
margin:10px;
padding:15px;
border-radius:10px;
cursor:pointer;
}

.explicacao{
margin-top:20px;
max-width:700px;
margin-left:auto;
margin-right:auto;
}
</style>

</head>

<body>

<h2><?php echo $pergunta['pergunta']; ?></h2>
<p>🔥 Sequência atual: <?php echo $_SESSION['combo']; ?></p>

<?php if(!$resposta_dada){ ?>

<form method="POST">
<button name="resposta" value="1">Verdadeiro</button>
<button name="resposta" value="0">Falso</button>
</form>

<?php } ?>

<?php if($resposta_dada){ ?>

<h3><?php echo $mensagem; ?></h3>

<div class="explicacao">
<p><b>Explicação:</b> <?php echo $explicacao; ?></p>
</div>

<form method="POST">
<button name="proxima">Próxima pergunta</button>
</form>

<?php } ?>

</body>
</html>