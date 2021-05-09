<?php
include "db_connect.php";
$keyword = $_GET["keyword"];

//Search database for strength
echo "<h2>Lookup $keyword</h2>";
$sql = "SELECT AbiID, AbilityScoName, AbiScoreAbbr FROM abilityscores WHERE AbilityScoName LIKE '%" . $keyword . "%'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "AbiID: " . $row["AbiID"]. " - Name: " . $row["AbilityScoName"]. " " . $row["AbiScoreAbbr"]. "<br>";
    }
} else {
    echo "0 results";
}

?>