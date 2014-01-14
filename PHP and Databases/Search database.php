<?php
    $mysqli = new mysqli('localhost', 'cs174_23', 'CGnjWYd8', 'cs174_23');
    
    $searchInput = "";
    $selected = "";
        
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $searchInput = $_POST["searchBar"];
        $mysqli->query("DROP PROCEDURE IF EXISTS searchByProduct");
        $mysqli->query("CREATE PROCEDURE searchByProduct(IN prod VARCHAR(100)) BEGIN SELECT Name, Description, Price, CountryOfOrigin FROM products WHERE Name LIKE '%$searchInput%'; END;");
        $mysqli->query("DROP PROCEDURE IF EXISTS searchByDescription");
        $mysqli->query("CREATE PROCEDURE searchByDescription(IN descr text) BEGIN SELECT Name, Description, Price, CountryOfOrigin FROM products WHERE Description LIKE '%$searchInput%'; END;");
        $mysqli->query("DROP PROCEDURE IF EXISTS searchByPrice");
        $mysqli->query("CREATE PROCEDURE searchByPrice(IN price float) BEGIN SELECT Name, Description, Price, CountryOfOrigin FROM products WHERE Price LIKE '%$searchInput%'; END;");
        $mysqli->query("DROP PROCEDURE IF EXISTS searchByCountry");
        $mysqli->query("CREATE PROCEDURE searchByCountry(IN country VARCHAR(20)) BEGIN SELECT Name, Description, Price, CountryOfOrigin FROM products WHERE CountryOfOrigin LIKE '%$searchInput%'; END;");
        
        if(isset($_POST["searchCategory"]))
           $selected = $_POST["searchCategory"];
        
        if($selected == "product")
        {
            $ProductResults = $mysqli->query("CALL searchByProduct('$searchInput')");
        }
        else if($selected == "description")
        {
            $DescriptionResults = $mysqli->query("CALL searchByDescription('$searchInput')");
        }
        else if($selected == "price")
        {
            $PriceResults = $mysqli->query("CALL searchByPrice('$searchInput')");
        }
        else if($selected == "country")
        {
           $CountryResults = $mysqli->query("CALL searchByCountry('$searchInput')");
        }
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
        <title>Project 6-1</title>
    </head>
    <body>
        <h2>Search Database Example</h2>
        <p>Search database by:</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <label for="name">Product Name:</label><input id="name" name="searchCategory" type="radio" value="product"/>
        <br/>
        <label for="descript">Description:</label><input id="descript" name="searchCategory" type="radio" value="description"/>
        <br/>
        <label for="price">Price:</label><input id="price" name="searchCategory" type="radio" value="price"/>
        <br/>
        <label for="country">Country of Origin:</label><input id="country" name="searchCategory" type="radio" value="country"/>
        
        <div>
            <input type="text" id="search" name="searchBar" />
            <input type="submit" value="Search" name="Search" />
        </div>
        </form>
        <div>
            <?php if(isset($ProductResults))
                {
                    while($row = $ProductResults->fetch_assoc())
                    {
                        printf("%s%s%s%s%s%s%s", $row["Name"], " ", $row["Description"], " ", $row["Price"], " ", $row["CountryOfOrigin"]);
                        print "<br/>";
                    }
                    
                }
                if(isset($DescriptionResults))
                {
                    while($rowa = $DescriptionResults->fetch_assoc())
                    {
                        printf("%s%s%s%s%s%s%s", $rowa["Name"], " ", $rowa["Description"], " ", $rowa["Price"], " ", $rowa["CountryOfOrigin"]);
                        print "<br/>";
                    }
                }
                if(isset($PriceResults))
                {
                    while($rowb = $PriceResults->fetch_assoc())
                    {
                        printf("%s%s%s%s%s%s%s", $rowb["Name"], " ", $rowb["Description"], " ", $rowb["Price"], " ", $rowb["CountryOfOrigin"]);
                        print "<br/>";
                    }
                }
                if(isset($CountryResults))
                {
                    while($rowc = $CountryResults->fetch_assoc())
                    {
                        printf("%s%s%s%s%s%s%s", $rowc["Name"], " ", $rowc["Description"], " ", $rowc["Price"], " ", $rowc["CountryOfOrigin"]);
                        print "<br/>";
                    }
                }
                
            ?>
        </div>
    </body>
</html>