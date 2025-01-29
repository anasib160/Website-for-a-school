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

    echo "<h1> Bonjour Admin {$_SESSION["name"]}</h1><br>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="css/ad.css">
</head>
<body>
    <div class="blc">
        <form action="" method="post">
            <label>Entrez ce que l'étudiant étudiera demain  8h-10h: </label>
            <input type="text" name="810"><br>

            <label>Entrez ce que l'étudiant étudiera demain 10h-12h: </label>
            <input type="text" name="1012"><br>

            <label>Entrez ce que l'étudiant étudiera demain 14h-16h: </label>
            <input type="text" name="1416"><br>

            <label>Entrez ce que l'étudiant étudiera demain 16h-18h: </label>
            <input type="text" name="1618"><br>

            <label>Entrez qui est le professeur :</label>
            <input type="text" name="prof"><br>

            <label>Sélectionnez la filiere :</label>
            <input type="text" name="class"><br>

            <input type="submit" value="Submit" name="enter">
        </form>
    </div>
    <?php
        if (isset($_POST["enter"])) {
            $sais1 = $_POST["810"];
            $sais2 = $_POST["1012"];
            $sais3 = $_POST["1416"];
            $sais4 = $_POST["1618"];
            $prof = $_POST["prof"];
            $class = $_POST["class"];

            $sql = "UPDATE emploi 
                    SET sais1 = '$sais1', sais2 = '$sais2', sais3 = '$sais3', sais4 = '$sais4', prof='$prof'
                    WHERE CLASS = '$class'";

            if (mysqli_query($connec, $sql)) {
                echo "<a class='success-message'>Emploi mis à jour avec succès !</a>";
            } else {
                echo "<a class='error-message'>Erreur lors de la mise à jour de l'emploi.</a> " . mysqli_error($connec);
            }
        }
    ?>
    <div class="blc">
    <?php
        echo "<h3>Liste des déclarations des profs:</h3><br>";

        $sql = "SELECT id, name_of_prof, decl FROM chat";
        $result = mysqli_query($connec, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $profId = $row['id'];
                $profName = $row['name_of_prof'];
                $declaration = $row['decl'];

                echo <<<HTML
                <form method="POST" action="">
                    Nom du prof: <strong>{$profName}</strong>, Declaration: <em>{$declaration}</em><br><br>
                    <textarea name="rep" required></textarea>
                    <input type="hidden" name="decl_id" value="{$profId}">
                    <input type="submit" name="Envoyez" value="Envoyez">
                </form><br>
                HTML;
            }
        } else {
            echo "Aucune déclaration trouvée. <br><br>";
        }
        if(isset($_POST["Supprimer"])){
            $sql = "DELETE FROM chat";
            if (mysqli_query($connec, $sql)) {
                echo "<a class='success-message'>Déclarations supprimées avec succès!</a>";
            } else {
                echo "<a class='error-message'>Erreur lors de la suppression de la déclaration.</a> " . mysqli_error($connec);
            }
        }
        if(mysqli_num_rows($result) > 0){
            echo "<form method='POST' action=''>
            <input type='submit' name='Supprimer' value='Supprimer'>
            </form><br><br>";
        }
        if (isset($_POST["Envoyez"])) {
            $rep = $_POST["rep"];
            $declId = $_POST["decl_id"];

            $sql = "UPDATE chat SET rep = '$rep' WHERE id = $declId";
            if (mysqli_query($connec, $sql)) {
                echo "<a class='success-message'>Réponse mise à jour avec succès!</a>";
            } else {
                echo "<a class='error-message'>Erreur lors de la mise à jour de la réponse.</a> " . mysqli_error($connec);
            }
        }
        if(isset($_POST["Supprimer"])){
            $sql = "TRUNCATE TABLE chat";
            if (mysqli_query($connec, $sql)) {
                echo "<a class='success-message'>Déclarations supprimées avec succès!</a>";
                header("Location: ad_page.php");
            } else {
                echo "<a class='error-message'>Erreur lors de la suppression de la déclaration.</a> " . mysqli_error($connec);
            }
        }
    ?>
    </div>
    <div class="blc">
    <?php
        echo "<h3>Liste des absences:</h3><br>";

        $sql = "SELECT justif, name, reg_date FROM absence";
        $res = mysqli_query($connec, $sql);

        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $name = $row['name'];
                $date = $row['reg_date'];
                $just = $row['justif'] == NULL ? 'Aucune justification pour l instant' : $row['justif'];
                echo <<<HTML
                <form action="" method="post">
                    Le nom de l'étudiant: <strong>{$name}</strong> à ce jour {$date}. Voici la justification : {$just} <br><br>
                    <input type="hidden" name="decl_id" value="{$name}">
                    <input type="submit" name="Valider" value="Valider">
                    <input type="submit" name="refuse" value="Refuse">
                </form><br>
                HTML;
            }
        } else {
            echo "Aucune absence ici.";
        }

        if (isset($_POST['Valider'])) {
            $profId = $_POST['decl_id'];
            $sql = "UPDATE absence SET penal = 'true' WHERE name = '$profId'";
            if (mysqli_query($connec, $sql)) {
                echo "<a class='success-message'>Justification acceptée!</a>";
            } else {
                echo "<a class='error-message'>Erreur lors de la mise à jour de l'absence:</a> " . mysqli_error($connec);
            }
        }
        if (isset($_POST['refuse'])) {
            $profId = $_POST['decl_id'];
            $sql = "UPDATE absence SET penal = 'false' WHERE name = '$profId'";
            if (mysqli_query($connec, $sql)) {
                echo "<a class='error-message'>Justification rejetée!</a>";
            } else {
                echo "<a class='error-message'>Erreur lors de la mise à jour de l'absence: </a>" . mysqli_error($connec);
            }
        }
        if(mysqli_num_rows($res) > 0){
            echo "<form method='POST' action=''>
            <input type='submit' name='Sup' value='Supprimer'>
            </form><br><br>";
        }
        if(isset($_POST["Sup"])){
            $sql = "TRUNCATE TABLE absence";
            if (mysqli_query($connec, $sql)) {
                echo "<a class='success-message'>Abcenses supprimées avec succès!</a>";
                header("Location: ad_page.php");
            } else {
                echo "<a class='error-message'>Erreur lors de la suppression de la abcense.</a> " . mysqli_error($connec);
            }
        }
    ?>
    </div>
    <form action="" method="post">
        <input type="submit" value="Log Out" name="logout"><br>
    </form>
</body>
</html>
