<?php

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
echo $mysqli->host_info . "<br>";

$sql = "SELECT AbiID, AbilityScoName, AbiScoreAbbr FROM abilityscores";
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