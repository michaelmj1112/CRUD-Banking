<?php
    $mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking')
        or die($mysqli->error);

    $q = $_REQUEST['q'];
    $output = '';

    if ($q == '') {
        $result = $mysqli->query("SELECT * FROM transactions")
            or die($mysqli->error);
    } else {
        $result = $mysqli->query("SELECT * FROM transactions WHERE CONCAT(remarks, date_created, amount) LIKE '%$q%'")
            or die($mysqli->error);
    }

    if (mysqli_num_rows($result) > 0) {
        // $output .= '<h4 align="center">Search Result</h4>';
        // $output .= '<div class="table responsive">
        //                 <table class="table table-responsive">
        //                     <thead>
        //                         <tr>
        //                             <th>Date</th>
        //                             <th>Transaction</th>
        //                             <th>Amount</th>
        //                         </tr>';
        // while ($row = mysqli_fetch_assoc($result)) {
        //     $output .= '<tr>
        //                     <td>'.$row['date_created'].'</td>
        //                     <td>'.$row['remarks'].'</td>
        //                     <td>'.$row['amount'].'</td>
        //                 </tr>';
        // }

        $perPageRecord = 10;
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        $startFrom = ($page - 1) * $perPageRecord;
        $query = $mysqli->query("SELECT * FROM transactions LIMIT $startFrom, $perPageRecord")
                    or die($mysqli->error);

        $output .= '<div class="table table-responsive">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Transaction</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>';
        while ($row = $query->fetch_assoc()) {
            $output .= '<tr>
                            <td>'.$row['date_created'].'</td>
                            <td>'.$row['remarks'].'</td>
                            <td>'.$row['amount'].'</td>
                        </tr>';
        }
        $output .= '    </table>
                    </div>';
    
        $output .= '<div class="pagination">';
        $count = $mysqli->query("SELECT COUNT(*) FROM transactions");
        $row = mysqli_fetch_row($count);
        $totalRecords = $row[0];

        $totalPages = ceil($totalRecords / $perPageRecord);
        $pageLink = '';

        if ($page >= 2) {
            $output .= "<a class='prev-next' href='history.php?page=".($page - 1)."'> Prev </a>";
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $page) {
                $pageLink .= "<a class='active' href='history_backup.php?page=".$i."'>".$i."</a>";
            } else {
                $pageLink .= "<a class='unactive' href='history_backup.php?page=".$i."'>".$i."</a>";
            }
        };
        echo $pageLink;

        if ($page < $totalPages) {
            $output .= "<a class='prev-next' href='history_backup.php?page=".($page + 1)."'>Next</a>";
        }
        $output .= '</div>';
        
        echo $output;
    } else {
        echo "Data Not Found";
    }
?> 