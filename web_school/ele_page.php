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
    if(isset($_POST["logout"])){
        session_destroy();
        header("Location: login.php");
    }

    
    echo "<h1><em>Bonjour élève {$_SESSION["name"]}</em></h1> ";
    echo "<h2> Here's your schecule : </h2>";

    $name = $_SESSION["name"];
    $sql="SELECT class from eleve WHERE name = '$name'";
    $res = mysqli_query($connec,$sql);
    $row = mysqli_fetch_assoc($res);
    $class = $row["class"]??  'Nodata' ; 


    $sql1 = "SELECT sais1 FROM emploi WHERE CLASS = '$class'";
    $sql2 = "SELECT sais2 FROM emploi WHERE CLASS = '$class'";
    $sql3 = "SELECT sais3 FROM emploi WHERE CLASS = '$class'";
    $sql4 = "SELECT sais4 FROM emploi WHERE CLASS = '$class'";


    $res1 = mysqli_query($connec, $sql1);
    $res2 = mysqli_query($connec, $sql2);
    $res3 = mysqli_query($connec, $sql3);
    $res4 = mysqli_query($connec, $sql4);
    
    $row1 = mysqli_fetch_assoc( $res1);
    $row2 = mysqli_fetch_assoc( $res2);
    $row3 = mysqli_fetch_assoc( $res3);
    $row4 = mysqli_fetch_assoc( $res4);



    $sais1 = $row1['sais1'] ?? 'No data';
    $sais2 = $row2['sais2'] ?? 'No data';
    $sais3 = $row3['sais3'] ?? 'No data';
    $sais4 = $row4['sais4'] ?? 'No data';

    if (isset($_POST["Envoyez"])) {
        $file = $_POST["abs"] ;
        $nname = $_POST["decl_id"];
        $sql = "UPDATE absence SET justif = '$file' WHERE name = '$nname'";
        if (mysqli_query($connec, $sql)) {
            echo "Justification successfully uploaded and updated!";
        } else {
            echo "Error updating justification: " . mysqli_error($connec);
        }
    }
?>

    <table border="1">
        <tr>
            <td>8:00-10:00</td>
            <td>10:00-12:00</td>
            <td>14:00-16:00</td>
            <td>16:00-18:00</td>
        </tr>
        <tr>
            <td><?php echo $sais1 ;  ?></td>
            <td><?php echo $sais2 ;  ?></td>
            <td><?php echo $sais3 ;  ?></td>
            <td><?php echo $sais4 ;  ?></td>
        </tr>
    </table><br>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/el.css">
</head>
<body>
    <form action="ele_page.php" method="post" class="blc">
        <h2>Your absences : </h2>
        <?php
            $name = $_SESSION["name"] ; 
            $sql="SELECT * from absence WHERE name ='$name'" ;
            $res=mysqli_query($connec,$sql);
            if(mysqli_num_rows($res)>0){
                while($row=mysqli_fetch_assoc($res)){
                    $profId = $row['name'];
                    $date = $row['reg_date'];
                    $rep = $row['penal'];
                    echo <<<HTML
                    <form action="ele_page.php" method="post" enctype="multipart/form-data">
                        <h4>Vous étiez absent à cette date : {$date} . </h4><br>
                        <strong>Entrez votre justification :</strong>
                        <input type="hidden" name = "decl_id" value="{$profId}">
                        <input type="file" name = "abs">
                        <input type="submit" name="Envoyez" value="Envoyez">
                    </form>
                    <br>
                    HTML;
                    if(!empty($rep)){
                        if($rep=='true'){
                            echo"<a class='success-message'>Votre absence a été validée </a><br><br>";
                        }else{
                            echo"<a class='error-message'>Votre absence a été refusée </a> <br><br>";
                        }

                    }else{
                        echo "Pas encore de réponse<br><br>";
                    }
                }
            }else{
                echo"No abscence found";
            }
            
        ?>
    </form>
    <form action="ele_page.php" method="post" class="log">
        <input type="submit" value="Log Out" name="logout">

    </form>
</body>
</html>
<?php   
    mysqli_close($connec);
?>