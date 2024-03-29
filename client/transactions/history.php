<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css"/>
        <link rel="stylesheet" href="/assets/css/background.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
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
            
            $result = $mysqli->query("SELECT * FROM transactions WHERE account_id = '$uID'")
                or die($mysqli->error);
        ?>

        <div class="container" style="padding: 1em 2em;">
            <div class="row justiy-content-center">
                <div class="col-lg-10 rounded my-2 py-2">
                    <table class="table" style="font-size: 1.3rem;">
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
        $(function() {
            $("#nav-placeholder").load("../navbar/navbar.php");
        });
    </script>
</html>