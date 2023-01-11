<?php
    $mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking')
                or die($mysqli->error);

    $q = $_REQUEST['q'];

    $balance = "";
    if ($q !== "") {
        $query = $mysqli->query("SELECT account_number FROM accounts");
        $row = mysqli_fetch_all($query);
        
        foreach ($row as $accounts) {
            $accounts = implode("", $accounts);
            if ($q === $accounts) {
                $querybalance = $mysqli->query("SELECT balance FROM accounts WHERE account_number = $q");
                $result = mysqli_fetch_assoc($querybalance);

                if ($balance === "") {
                    $balance = implode(" ", $result);
                }
            }
        }
    }
    echo $balance === "" ? "" : number_format($balance, 2, '.', ',');
?>