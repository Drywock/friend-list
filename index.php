<html>
<head>
    <title>Friend list</title>
</head>
<body>
    <?php
    include("header.html"); 
    ?>
    <br>
    <form action="index.php" method="post">
    Name: <input type="text" name="name">
        <input type="submit">
    </form>

    <h1>My best friends</h1>

    <ul>
    <?php
        if(isset($_POST["name"])){
            $name = $_POST["name"];
            $file = fopen("friends.txt","a");
            fwrite($file, "\n$name");
            fclose($file);
        }

        $nameFilter = "";
        $startingWith = false;
        if(isset($_POST["nameFilter"])){
            $nameFilter = $_POST["nameFilter"];
        }
        if(isset($_POST["startingWith"])){
            $startingWith = $_POST["startingWith"];
        }

        $file = fopen("friends.txt", "r");
        while(!feof($file)){
            $name = fgets($file);
            if($nameFilter === "") {
                echo "<li>$name</li>";
            }
            else if(($startingWith && stripos($name, $nameFilter) === 0) || (!$startingWith && stripos($name, $nameFilter) !== false)) {
                echo "<li>$name</li>";
            }
        }
        fclose($file);

    ?>
    </ul>

    <form action="index.php" method="post">
        <input type="text" name="nameFilter" value="<?=$nameFilter?>">
        <input type="checkbox" name="startingWith" <?php if ($startingWith=='TRUE') echo "checked"?> value="TRUE">Only names starting with</input>
        <input type="submit" value="Filter list">
    </form>

    <?php
    include("footer.html"); 
    ?>
</body>
</html>