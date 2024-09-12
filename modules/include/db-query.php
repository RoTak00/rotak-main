<?php


function query_unsafe($query)
{
    global $conn;
    $result = $conn->query($query);

    if(!$result)
    {
        echo "Failed query ($query) :" . $conn->error; 
        return;
    }

    $output = [];
    while($row = $result->fetch_assoc())
    {
        $output [] = $row;
    }

    return $output;

}


?>