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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/reg.css">
</head>
<body>
    <h2>Creation d'un compte pour un Admin</h2>
    <form action="regis_ad.php" method="post">
        <label>NOM :</label>
        <input type="text" name="NOM" ><br>
        <label>PRENOM :</label>
        <input type="text" name="PRENOM" ><br>
        <label>Email :</label>
        <input type="email" name="Email" ><br>
        <label>PHONE NUMBER :</label>
        <input type="number" maxlength="10" name="phone" ><br>
        <label>Password :</label>
        <input type="password" name="password" ><br>
        <input type="submit" name="Resgister" value="Creer"><br>


    </form>

    
</body>
</html>

<?php
    if(isset($_POST["Resgister"])){
        if(!empty($_POST["NOM"])&&
            !empty($_POST["PRENOM"])&&
            !empty($_POST["Email"])&&
            !empty($_POST["phone"])&&
            !empty($_POST["password"])){
                $nom=$_POST["NOM"];
                $prenom=$_POST["PRENOM"];
                $mail=$_POST["Email"];
                $phone=$_POST["phone"];
                $password =$_POST["password"];
                
                
                $sql = "INSERT INTO ad (name,prenom,email,phone,password)
                        values ('$nom','$prenom','$mail','$phone','$password') ";

                
                try{
                    mysqli_query($connec, $sql);
                    echo "Le compte est créé" ;
                    header('Location: login.php');

                }
                catch(mysqli_sql_exception){
                    echo"<h5 class='error-message'>Le compte n'est pas créé. Veuillez vérifier vos informations.</h5>";
                }

                
                
        }         
    }
    mysqli_close($connec);
?>