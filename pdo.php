<?php

//Connect to MySQL using the PDO object.
$pdo = new PDO('mysql:host=localhost;dbname=bitnami_myapp', 'root', '');

//Our SQL statement, which will select a list of tables from the current MySQL database.
$sql = "SHOW TABLES WHERE in_use>0 FROM botmessages";

//Prepare our SQL statement,
$statement = $pdo->prepare($sql);

//Execute the statement.
$statement->execute();

//Fetch the rows from our statement.
$tables = $statement->fetchAll(PDO::FETCH_NUM);

//Loop through our table names.
foreach($tables as $table){
    //Print the table name out onto the page.
    echo $table[0], '<br>';
}







function itemDiscontinued($dbh, $id, $detail) {
    try {   
        $tableList = array();
        $result = $dbh->query("SHOW TABLES");
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
            $tableList[] = $row[0];
        }
        print_r($tableList);
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}
