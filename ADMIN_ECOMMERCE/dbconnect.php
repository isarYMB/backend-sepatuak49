<?php

$conn = mysqli_connect("34.128.121.200", "root", "skripsi-db2023", "sepatuak49");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
