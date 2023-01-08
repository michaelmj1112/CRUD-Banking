<?php
    $mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking')
        or die($mysqli->error);

    $q = $_REQUEST['q'];
    echo $q;
    $output = '';

    if ($q == '') {
        $result = $mysqli->query("SELECT * FROM transactions")
            or die($mysqli->error);
    } else {
        $result = $mysqli->query("SELECT * FROM transactions WHERE CONCAT(remarks, date_created, amount) LIKE '%$q%'")
            or die($mysqli->error);
    }

    if (mysqli_num_rows($result) > 0) {
        $output .= '<h4 align="center">Search Result</h4>';
        $output .= '<div class="table responsive">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Transaction</th>
                                    <th>Amount</th>
                                </tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= '<tr>
                            <td>' . $row['date_created'] . '</td>
                            <td>' . $row['remarks'] . '</td>
                            <td>' . $row['amount'] . '</td>
                        </tr>';
        }
        

        echo $output;
    } else {
        echo "Data Not Found";
    }
?> 