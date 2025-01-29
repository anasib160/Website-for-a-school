<?php
    $db_serveur="localhost";
    $db_user="root";
    $db_password="";
    $db_name="ensem";
    $connec="";

    $connec= mysqli_connect($db_serveur,
                            $db_user,
                            $db_password,
                            $db_name);    
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/logiin.css">
</head>
<body>
<h2>Page de Connexion</h2>
    <form action="login.php" method="post">
        <label for="name">Nom :</label>
        <input type="text" name="name" id="name" required><br>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required><br>
        <input type="submit" name="subbmit" value="Login"><br><br>
    </form>
    <a href="char.php">Si vous n'êtes pas inscrit(e)</a><br>
</body>
</html>

<?php
    if(isset($_POST["subbmit"])){
        $name = $_POST["name"];
        $password = $_POST["password"];
        $sql = "SELECT * FROM eleve WHERE name = '$name' AND password = '$password' ";
        $result = mysqli_query($connec,$sql);

        if(mysqli_num_rows($result) == 1){
            $_SESSION["name"]=$_POST["name"];
            $name = $_SESSION["name"] ; 

            header("Location: ele_page.php");
        }else{
            $sql = "SELECT * FROM prof WHERE name = '$name' AND password = '$password' ";
            $result = mysqli_query($connec,$sql);
            if(mysqli_num_rows($result) == 1){
                $_SESSION["name"]=$_POST["name"];
                header("Location: prof_page.php");
            }else{
                $sql = "SELECT * FROM ad WHERE name = '$name' AND password = '$password' ";
                $result = mysqli_query($connec,$sql);
                if(mysqli_num_rows($result) == 1){
                    $_SESSION["name"]=$_POST["name"];
                    header("Location: ad_page.php") ;
                }else{
                    echo "<h6 class='error-message'>Nom d'utilisateur ou mot de passe invalide </h6>" ;
                }
        }

    }
}
    mysqli_close($connec);
?>