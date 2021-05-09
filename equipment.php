<?php
include "db_connect.php";

$inventory_entry_id = $_POST['inventoryentry'];
$equipped = $_POST['equipped'];

$sql = "UPDATE `character-inventories` SET `equipped`= $equipped WHERE `inventory-entry-id` = $inventory_entry_id";
$stmt = mysqli_prepare($conn,$sql);
//if($stmt = mysqli_prepare($conn,$sql)){
    mysqli_stmt_execute($stmt);
//}

?>