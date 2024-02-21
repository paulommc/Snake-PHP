<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $lado = $_POST['lado'];
    $_SESSION['lado'] = $lado;
}
if (!isset($_SESSION['pos'])) {
    $_SESSION['pos'] = 1130;
}
if (!isset($_SESSION['lado'])) {
    $_SESSION['lado'] = 'd';
}
if (!isset($_SESSION['rabo'])) {
    $_SESSION['rabo'] = 1130;
    $string_rabo = $_SESSION['rabo'];
} else {
    $string_rabo = $_SESSION['rabo'];
}
if (!isset($_SESSION['tamanho'])) {
    $_SESSION['tamanho'] = 0;
}
if (!isset($_SESSION['vida'])) {
    $_SESSION['vida'] = 1;
}


if (!isset($_SESSION['fruta'])) {
    $_SESSION['fruta'] = rand(1, 2500);
}

//morte na borda
if($_SESSION['pos'] > 2500 ||
    $_SESSION['pos'] < 1 || 
    ($_SESSION['pos']%50==0 && $_SESSION['lado']=='d') ||
    (($_SESSION['pos']-1)%50==0 && $_SESSION['lado']=='e')){
        $_SESSION['vida']=0;
    }



//movimentação
if ($_SESSION['lado'] == 'd') {
    $_SESSION['pos'] += 1;
} elseif ($_SESSION['lado'] == 'e') {
    $_SESSION['pos'] -= 1;
} elseif ($_SESSION['lado'] == 'c') {
    $_SESSION['pos'] -= 50;
} else {
    $_SESSION['pos'] += 50;
}
$string_rabo .= "," . $_SESSION['pos'];
$_SESSION['rabo']  = $string_rabo;

//fruta
if ($_SESSION['fruta'] == $_SESSION['pos']) {
    unset($_SESSION['fruta']);
    $_SESSION['tamanho'] += 1;
}


//morte na borda
if($_SESSION['pos'] > 2500 ||
    $_SESSION['pos'] < 0 || 
    ($_SESSION['pos']%50==0 && $_SESSION['lado']=='d') ||
    (($_SESSION['pos']-1)%50==0 && $_SESSION['lado']=='e')){
        if($_SESSION['pos'] < 50){
            $_SESSION['pos']+=50;
        }
        elseif($_SESSION['pos'] >2500){
            $_SESSION['pos']-=50;
        }
        $_SESSION['vida']=0;
    }



$array_rabo = explode(",", $string_rabo);
$array_rabo = array_reverse($array_rabo);
//autofagia
for($x = 1;$x<sizeof($array_rabo);$x++){
    if($_SESSION['pos'] == $array_rabo[$x]){
        $_SESSION['vida'] = 0;
    }

}

?>

<!DOCTYPE html>
<html lang="pt-pb">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php
    if ($_SESSION['vida'] == 1) {
    ?>
        <meta http-equiv="refresh" content="0.1">
    <?php
    }
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snake PHP</title>
    <style>
        body {
            width: 1000px;
            margin: 10px auto;
            font-family: Arial, Helvetica, sans-serif;
            overflow: hidden;
        }

        #base {
            width: 700px;
            height: 700px;
            background-color: #222;
            padding-top: 1px;


        }

        .painel {
            width: 13px;
            height: 13px;
            background-color: #ddd;
            margin-left: 1px;
            margin-top: 1px;
            float: left;

        }

        p {
            text-align: center;
            margin-top: 19px;
            font-size: 3em;
            font-weight: 600;
        }

        #b {
            margin-left: 30px;
        }

        a[href="reset.php"] {
            position: absolute;
            top: 719px;
            left: 354px;
        }

        <?php

        for ($t = 1; $t <= $_SESSION['tamanho']; $t++) {

        ?>#p<?= $array_rabo[$t] ?> {
            background-color: green;
        }

        <?php
        }
        ?>#p<?= $_SESSION['fruta'] ?> {
            background-color: yellow;
        }

        #p<?= $_SESSION['pos'] ?> {
            background-color: red;
        }

        #debug {
            position: absolute;
            top: 10px;
            left: 10px;
        }
    </style>
</head>

<body>
    <a href="reset.php">Reset</a>
    <div id="base">
        <?php
        for ($x = 1; $x <= 2500; $x++) {
        ?>
            <div id="p<?= $x ?>" class="painel"></div>
        <?php
        }
        ?>
    </div>
    <form action="snake.php" method="post">

        <br><br>
        <input type="radio" name="lado" value="e" id="e" onclick="submit()">
        <input type="radio" name="lado" value="c" id="c" onclick="submit()">
        <input type="radio" name="lado" value="d" id="d" onclick="submit()"><br>
        <input type="radio" name="lado" value="b" id="b" onclick="submit()">
    </form>
    <div id="debug">
        <?php
       // array_splice($array_rabo, $_SESSION['tamanho'] + 1);
       // $array_rabo = array_reverse($array_rabo);
       // $_SESSION['rabo'] = implode(",", $array_rabo);
      //  print_r($array_rabo);
        ?>
        <br>
    </div>
    <script>
        window.addEventListener("keydown", handleInput, {
            once: true
        })

        function handleInput(e) {
            switch (e.key) {
                case "ArrowUp":
                    document.getElementById("c").click()
                    break
                case "ArrowDown":
                    document.getElementById("b").click()
                    break
                case "ArrowLeft":
                    document.getElementById("e").click()
                    break
                case "ArrowRight":
                    document.getElementById("d").click()
                    break
            }
        }
    </script>

</body>

</html>