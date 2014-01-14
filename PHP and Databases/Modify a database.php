<?php
    $mysqli = new mysqli('localhost', 'cs174_23', 'CGnjWYd8', 'cs174_23');
    $pName = $pdescription = $pprice = $corigin = "";
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        $pName = $_POST["product"];
        $pdescription = $_POST["description"];
        $pprice = $_POST["price"];
        $corigin = $_POST["country"];
        
        $stmt = $mysqli->prepare("INSERT INTO products(Name, Description, Price, CountryOfOrigin) VALUES(?, ?, ?, ?)");
        $stmt->bind_param('ssds', $pName, $pdescription, $pprice, $corigin);
        
        $stmt->execute();
        if($stmt->errno)
            echo "failed";
        else
            echo "Item Added Successfully";
    }
    
    if($mysqli->connect_errno)
    {
        print("Error connecting" + $mysqli->connect_error);
    }
    
    $mysqli->close();
?>
<!DOCTYPE>
<html>
    <head>
        <title>Project 6-2</title>
    </head>
    <body>
        <h2>Modify Database Example</h2>
        <p>Add a product to the database:</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <label for="name">Product Name:</label><input id="name" name="product" type="text"/>
      
        <label for="descript">Description:</label><input id="descript" name="description" type="text" />
        
        <label for="price">Price:</label><input id="price" name="price" type="text" />
        
        <label for="country">Country of Origin:</label><input id="country" name="country" type="text" />
        
        <input type="submit" value="Add item" name="AddItem" />
        </form>
        
    </body>
</html>