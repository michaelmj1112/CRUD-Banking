<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css"/>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    </head>

    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/process.php'; ?>

        <?php
            $mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking') 
                or die(mysqli_error($mysqli));
            $result = $mysqli->query("SELECT * FROM transactions")
                or die($mysqli->error);
        ?>

        <div id="nav-placeholder"></div>

        <div class="container">
            <div class="row justiy-content-center">
                <div class="col-lg-10 bg-light rounded my-2 py-2">
                    <h4 class="text-center text-dark pt-2">Pagination Test</h4>
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Transaction</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['date_created']; ?></td>
                                    <td><?php echo $row['remarks']; ?></td>
                                    <td><?php echo $row['amount']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>

    <script type="text/javascript">
        $(document).ready(function() {
            $('table').DataTable();
        });
    </script>
    <script>
        function getHistory(str) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("history").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "/functions/search.php?q=" + str, true);
            xmlhttp.send();
        }

        function go2Page() {
            var page = document.getElementById("page").value;
            page = ((page><?php echo $totalPages; ?>) ? <?php echo $totalPages; ?> : ((page < 1) ? 1:page));
            window.location.href = 'history.php?page='+page;
        }

        $(function() {
            $("#nav-placeholder").load("/client/navbar/navbar.php");
        });
    </script>
</html>