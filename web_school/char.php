<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/char.css">
</head>
<body>
    <h1>Choisir l'utilisateur :</h1>
    <input type="submit" value="←" id="left">
    <a href="regis_ele.php" id="link"><input type="submit" value="Eleve" id="elv"></a>
    <input type="submit" value="→" id="right">
    <script>
        document.getElementById("left").onclick = function(){
            per = ["Professeur","Admin","Eleve"]; 
            head = ["regis_prof.php","regis_ad.php","regis_ele.php"];
            let ComputerChoice_index = Math.floor(Math.random() * per.length) ;
            document.getElementById("elv").value=per[ComputerChoice_index];
            document.getElementById("link").href=head[ComputerChoice_index];
        };
        document.getElementById("right").onclick = function(){
            per = ["Professeur","Admin","Eleve"]; 
            head = ["regis_prof.php","regis_ad.php","regis_ele.php"];
            let ComputerChoice_index = Math.floor(Math.random() * per.length) ;
            document.getElementById("elv").value=per[ComputerChoice_index];
            document.getElementById("link").href=head[ComputerChoice_index];
        };

    </script>
</body>
</html>