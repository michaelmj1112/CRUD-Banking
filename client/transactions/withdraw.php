<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>
    <body>
        <div id="nav-placeholder"></div>
        
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/process.php'; ?>

        <?php
            $cUser = $_SESSION['cUser']; 
            $mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking') 
                or die(mysqli_error($mysqli));
            $currentUser = $mysqli->query("SELECT * FROM accounts WHERE email = '$cUser'")
                or die($mysqli->error);
        ?>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?=$_SESSION['msg_type']?>">
                <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                ?>
            </div>
        <?php endif ?>

        <div class="container">
            <div class="row justify-content-center">
                <form action="/process.php" method="POST">
                    <h2>Withdraw</h2>
                    <?php 
                        while($row = $currentUser->fetch_assoc()): 
                        $acc_num = $row['account_number'];
                        $balance = number_format($row['balance'], 2, '.', ',');
                    ?>
                    <div class="form-group">
                        <label>Account number</label>
                        <input type="text" name="from" class="form-control" value="<?php echo $row['account_number']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <h2>Available balance: TWD  <?php echo $balance; ?></h2>
                    </div>
                    <?php endwhile; ?>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="text" name="amount" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="withdraw">Continue</button>
                        <a href="home.php">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </body>
    <script>
        $(function() {
            $("#nav-placeholder").load("../navbar/navbar.php");
        });
    </script>
</html>