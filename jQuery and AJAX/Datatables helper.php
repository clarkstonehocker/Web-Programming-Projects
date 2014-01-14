<?php
    $mysqli = new mysqli('localhost', 'cs174_23', 'CGnjWYd8', 'cs174_23');
    if($mysqli->connect_errno)
    {
        print("Error connecting" + $mysqli->connect_error);
    }
    
    $searchInput = "";
    $searchInput = $_POST["searchBar"];
    
     $columns = array("Name", "Description", "Price", "CountryOfOrigin");
    
    $Results = $mysqli->query("SELECT * FROM products WHERE Name LIKE '%$searchInput%' OR Description LIKE '%$searchInput%' OR Price LIKE '%searchInput%' OR CountryOfOrigin LIKE '%$searchInput%'");
    /*$index = 0;
    while ($row = $Results->fetch_assoc())
    {
        $name = $row['Name'];
        $descript = $row['Description'];
        $price = $row['Price'];
        $country = $row['CountryOfOrigin'];
        $array = array("Name"=>$name, "Description"=>$descript, "Price"=>$price, "CountryOfOrigin"=>$country);
        
        $output[$index] = $array;
        
        $index = $index + 1;
    }
        
    echo json_encode($output);*/
    
    $output = array("Name"=>"Name","Description"=>"Description", "Price"=>"Price", "CountryOfOrigin"=>"CountryOfOrigin", "data"=>array() );
	
	while ( $aRow = mysqli_fetch_array($Results) )
	{
		//$row = array($aRow['Name'], $aRow['Description'], $aRow['Price'], $aRow['CountryOfOrigin']);
                $row = array();
		for ( $i=0 ; $i<count($columns); $i++ )
		{
			if ( $columns[$i] != ' ' )
			{
				//General output
				$row[] = $aRow[ $columns[$i] ];
			}
		}
		$output["data"][] = $row;
	}
    
    echo json_encode($output);
    
    
    $mysqli->close();
?>