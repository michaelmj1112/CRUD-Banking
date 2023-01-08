<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <link rel="stylesheet" href="/assets/css/history.css">
    </head>

    <body>
        <div id="nav-placeholder"></div>
        
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/process.php'; ?>

        <?php
            $cUser = $_SESSION['cUser']; 
            $mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking') 
                or die(mysqli_error($mysqli));
            $q = $mysqli->query("SELECT * FROM accounts WHERE email = '$cUser'")
                or die($mysqli->error);
            $row = mysqli_fetch_assoc($q);
            $uID = $row['id'];
        ?>

        <div class="container">
            <!-- <form action="" method="POST">
                <label for="entries">Number of entries:</label>
                <select name="entries" id="entries" onchange="load_new_content()">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </form> -->

            <?php

                $perPageRecord = 10;

                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                $startFrom = ($page - 1) * $perPageRecord;

                $result = $mysqli->query("SELECT * FROM transactions WHERE account_id = $uID LIMIT $startFrom, $perPageRecord")
                    or die($mysqli->error);
            ?>
            <div class="row justiry-content-center">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Transaction</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['date_created']; ?></td>
                            <td><?php echo $row['remarks']; ?></td>
                            <td><?php echo $row['amount']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>

            <div class="pagination">
                <?php
                    $count = $mysqli->query("SELECT COUNT(*) FROM transactions WHERE account_id = $uID");
                    $row = mysqli_fetch_row($count);
                    $totalRecords = $row[0];
                    
                    $totalPages = ceil($totalRecords / $perPageRecord);
                    $pageLink = "";
                    
                    if ($page >= 2) {
                        echo "<a class='prev-next' href='history.php?page=".($page - 1)."'> Prev </a>";
                    }

                    for ($i = 1; $i <= $totalPages; $i++) {
                        if ($i == $page) {
                            $pageLink .= "<a class='active' href='history.php?page=".$i."'>".$i."</a>";
                        } else {
                            $pageLink .= "<a class='unactive' href='history.php?page=".$i."'>".$i."</a>";
                        }
                    };
                    echo $pageLink;

                    if ($page < $totalPages) {
                        echo "<a class='prev-next' href='history.php?page=".($page + 1)."'>Next</a>";
                    }

                ?>
            </div>

            <!-- <div class="inline">
                <input id="page" type="number" min="1" max="<?php echo $totalPages ?>" placeholder="<?php echo $page."/".$totalPages; ?>" required>
                <button onclick="go2Page();">Go</button>
            </div> -->
            <!-- <a href="home.php">Back</a> -->
        </div>
    </body>

    <script>
        function go2Page() {
            var page = document.getElementById("page").value;
            page = ((page><?php echo $totalPages; ?>) ? <?php echo $totalPages; ?> : ((page < 1) ? 1:page));
            window.location.href = 'history.php?page='+page;
        }

        $(function() {
            $("#nav-placeholder").load("../navbar/navbar.php");
        });
    </script>
</html>