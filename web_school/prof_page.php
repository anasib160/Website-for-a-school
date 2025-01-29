<?php
    $db_serveur = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "ensem";
    $connec = mysqli_connect($db_serveur, $db_user, $db_password, $db_name);

    session_start();

    if (isset($_POST["logout"])) {
        session_destroy();
        header("Location: login.php");
        exit();
    }

    if (isset($_POST["sub"])) {
        $name = $_POST["abs"];
        $sql = "INSERT INTO absence (name) VALUES ('$name')";
        if (mysqli_query($connec, $sql)) {
            $_SESSION['message'] = "<a class='success-message'>Absence enregistrée avec succès.</a>";
        } else {
            $_SESSION['message'] = "<a class='error-message'>Échec de l'enregistrement de l'absence.</a>";
        }
        header("Location: prof_page.php");
        exit();
    }



    echo "<h1><em>Bonjour prof {$_SESSION["name"]}</em></h1>";
    $name = $_SESSION["name"];

    $sql1 = "SELECT sais1 FROM emploi WHERE prof = '$name'";
    $sql2 = "SELECT sais2 FROM emploi WHERE prof = '$name'";
    $sql3 = "SELECT sais3 FROM emploi WHERE prof = '$name'";
    $sql4 = "SELECT sais4 FROM emploi WHERE prof = '$name'";

    $res1 = mysqli_query($connec, $sql1);
    $res2 = mysqli_query($connec, $sql2);
    $res3 = mysqli_query($connec, $sql3);
    $res4 = mysqli_query($connec, $sql4);

    $row1 = mysqli_fetch_assoc($res1);
    $row2 = mysqli_fetch_assoc($res2);
    $row3 = mysqli_fetch_assoc($res3);
    $row4 = mysqli_fetch_assoc($res4);

    $sais1 = $row1['sais1'] ?? 'No data';
    $sais2 = $row2['sais2'] ?? 'No data';
    $sais3 = $row3['sais3'] ?? 'No data';
    $sais4 = $row4['sais4'] ?? 'No data';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/prof.css">
</head>
<body>
    <?php
        if (isset($_SESSION["message"])) {
            echo "<p>{$_SESSION['message']}</p>";
            unset($_SESSION["message"]);
        }
    ?>

    <h2>Voici votre emploi :</h2>

    <table border="1">
        <tr>
            <td>8:00-10:00</td>
            <td>10:00-12:00</td>
            <td>14:00-16:00</td>
            <td>16:00-18:00</td>
        </tr>
        <tr>
            <td><?php echo $sais1; ?></td>
            <td><?php echo $sais2; ?></td>
            <td><?php echo $sais3; ?></td>
            <td><?php echo $sais4; ?></td>
        </tr>
    </table><br>

    <form action="prof_page.php" method="post">
        <h3>Tapez l'absence :</h3>
        <input type="text" name="abs">
        <input type="submit" name="sub" value="Valider">
    </form>

    <form action="prof_page.php" method="post">
        <label>Déclarez votre problème ou votre demande :</label>
        <textarea name="decl"></textarea>
        <input type="submit" name="envy" value="Envoyez"><br><br>
        
        <h3>Voici vos réponses à vos déclarations :</h3>
        <?php
            $sql = "SELECT rep, decl FROM chat WHERE name_of_prof = '$name'";
            $app = mysqli_query($connec, $sql);
            if (mysqli_num_rows($app) > 0) {
                while ($row = mysqli_fetch_assoc($app)) {
                    $res = $row['rep'];
                    $decl = $row['decl'];
                    if($res == NULL) {
                        echo "Pas encore de réponse de votre declaration  '<em>{$decl}</em>'.<br>";
                    }else{
                        echo "La réponse de votre déclaration '<em>{$decl}</em>' est <strong>{$res}</strong><br>";

                    }
                }
            } else {
                echo "Aucune déclaration trouvée. <br><br>";
            }
        ?>
        <input type="submit" value="Log Out" name="logout">
    </form>
</body>
</html>
<?php
    if (isset($_POST["envy"])) {
        $decl = $_POST["decl"];
        $name = $_SESSION["name"];
        $sql = "INSERT INTO chat (name_of_prof, decl) VALUES ('$name', '$decl')";
        try {
            mysqli_query($connec, $sql);
            $_SESSION['message'] = "<a class='success-message'>Déclaration enregistrée avec succès.</a>";
        } catch (mysqli_sql_exception) {
            $_SESSION['message'] = "<a class='error-message'>Échec de l'enregistrement de la déclaration.</a>";
        }
        header("Location: prof_page.php");
        exit();
    }
    if (isset($_SESSION["message"])) {
        echo "<p>{$_SESSION['message']}</p>";
        unset($_SESSION["message"]); 
    }
?>