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
        <div id="nav-placeholder"></div>

        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/process.php'; ?>

        <?php if (isset($_SESSION['message'])): ?>

        <div class="alert alert-<?=$_SESSION['msg_type']?>">
            <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?>
        </div>
        <?php endif ?>

        <?php
            $mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking') 
                or die(mysqli_error($mysqli));
            $query = $mysqli->query("SELECT * FROM accounts");
        ?>

        <div class="container" style="padding: 1.5em 2em;">
            <div class="row justify-content-center">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Account #</th>
                            <th>Name</th>
                            <th>Current Balance</th>
                            <th>Date Added</th>
                            <th>Date Last Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php while($row = $query->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['account_number']; ?></td>
                        <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
                        <td><?php echo $row['balance']; ?></td>
                        <td><?php echo $row['date_created']; ?></td>
                        <td><?php echo $row['date_updated']; ?></td>
                        <td>
                            <a href="./manage_accounts.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                            <a href="/process.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
                <a href="../home.php">Back</a>
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
            $("#nav-placeholder").load("../../admin/navbar/navbar.php");
        });
    </script>
</html>