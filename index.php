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
        // Loading data from file
        $fileIn = fopen("friends.txt", "rt");
        $friendsArray = [];
        while(!feof($fileIn)){
            $name = trim(fgets($fileIn));
            if($name !== "")
            {
                array_push($friendsArray, $name);
            }
        }
        fclose($fileIn);

        // Handle new friend
        if(isset($_POST["name"])){
            $name = $_POST["name"];
            array_push($friendsArray, $name);
        }

        // Handle friend deletion
        if (isset($_POST['delete'])) {
            $indexToBeRemoved = $_POST['delete'];
            array_splice($friendsArray, $indexToBeRemoved, 1);
        }

        // Save changes
        $fileOut = fopen("friends.txt", "wt");
        foreach($friendsArray as $name) {
            fwrite($fileOut, "$name\n");
        }
        fclose($fileOut);

        // filter set-up
        $nameFilter = "";
        $startingWith = false;
        if(isset($_POST["nameFilter"])){
            $nameFilter = $_POST["nameFilter"];
            echo "filter";
        }
        if(isset($_POST["startingWith"])){
            $startingWith = $_POST["startingWith"];
        }
        

        // display list
        $i = 0;
        foreach($friendsArray as $name){
            if(($nameFilter === "") || //No - filter
                 ($startingWith && stripos($name, $nameFilter) === 0) || // filter on begining of the name
                 (!$startingWith && stripos($name, $nameFilter) !== false)) { // filter every where in the name
                echo "<li>
                        <form action=index.php method='post'>
                            $name 
                            <button type='submit' name='delete' value='$i'>Delete</button>
                        </form>
                      </li>";
            }
            $i++;
        }
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