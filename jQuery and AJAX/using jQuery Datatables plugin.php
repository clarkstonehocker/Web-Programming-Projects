<?php
    
?>
<!DOCTYPE>
<html>
    <head>
        <title>Project 7-2</title>
        <script type="text/javascript" charset="utf-8" src="./DataTables-1.9.4/media/js/jquery.js"></script>
        <script type="text/javascript" charset="utf-8" src="./DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
        <style type="text/css" title="currentStyle">
            @import "./DataTables-1.9.4/media/css/demo_table.css";
        </style>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#resultsTable").dataTable();
            });
        </script>
    </head>
    <body>
        <h2 style="text-align: center">Search Database Example</h2>
        <table id="resultsTable" class="display">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>CountryOfOrigin</th>
                </tr>
            </thead>
            <tbody><?php
                        $mysqli = new mysqli('localhost', 'cs174_23', 'CGnjWYd8', 'cs174_23');
                        if($mysqli->connect_errno)
                        {
                           print("Error connecting" + $mysqli->connect_error);
                        }

                        $Results = $mysqli->query("SELECT * FROM products");
    
                        $mysqli->close();
                    while ($row = $Results->fetch_assoc()) { ?>                    
                    <tr>
                        <td><?php echo $row['Name']; ?></td>
                        <td><?php echo $row['Description']; ?></td>
                        <td><?php echo $row['Price']; ?></td>
                        <td><?php echo $row['CountryOfOrigin']; ?></td>
                    </tr><?php } ?>                
                </tbody>
            
        </table>
            
        </table>
       
        
    </body>
</html>