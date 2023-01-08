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
            $admin = $_SESSION['admin']; 
            $mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking') 
                or die(mysqli_error($mysqli));
            $currentUser = $mysqli->query("SELECT * FROM admins WHERE username = '$admin'")
                or die($mysqli->error);

            $countQ = $mysqli->query("SELECT COUNT(*) FROM accounts")
                or die($mysqli->error);
            $countRow = mysqli_fetch_row($countQ);
            $noOfAccounts = $countRow[0];

            $totBalanceQ = $mysqli->query("SELECT SUM(balance) FROM accounts")
                or die($mysqli->error);
            $balanceRow = mysqli_fetch_row($totBalanceQ);
            $totBalance = $balanceRow[0];
        ?>

        <div class="container">
            <div class="row justify-content-center">
                <!-- <a href="./logout.php">Logout</a>
                <a href="./accounts/manage_accounts.php">Create new account</a>
                <a href="./accounts/">Accounts list</a> -->
                <?php while($row = $currentUser->fetch_assoc()): ?>
                <h1>Welcome! <?php echo $row['firstname'] . " " . $row['lastname']; ?></h1>
                <h2>Total accounts: <?php echo $noOfAccounts; ?></h2>
                <?php $totBalance = number_format($totBalance, 2, '.', ','); ?>
                <h2>Total accounts balance: TWD <?php echo $totBalance; ?></h2>
                <?php endwhile; ?>
            </div>
        </div>
    </body>

    <script>
        $(function() {
            $("#nav-placeholder").load("./navbar/navbar.php");
        });
    </script>
</html>