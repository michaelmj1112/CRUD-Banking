<?php
    $mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking')
                or die($mysqli->error);

    $q = $_REQUEST['q'];
    // echo "q = ".$q."<br>";
    $name = "";
    if ($q !== "") {
        $query = $mysqli->query("SELECT account_number FROM accounts");
        $row = mysqli_fetch_all($query);
        
        foreach ($row as $accounts) {
            $accounts = implode("", $accounts);
            if ($q === $accounts) {
                $queryName = $mysqli->query("SELECT firstname, lastname FROM accounts WHERE account_number = $q");
                $result = mysqli_fetch_assoc($queryName);
                
                // echo $result['firstname'] . " " . $result['lastname'] . "<br>";

                if ($name === "") {
                    $name = implode(" ", $result);
                }
            }
        }
    }
    echo $name === "" ? "Account doesn't exist!" : $name;
?>