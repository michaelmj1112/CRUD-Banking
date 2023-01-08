<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="/client/navbar/styles.css" /> 
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/process.php'; ?>

        <?php
            $cUser = $_SESSION['cUser']; 
            $mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking') 
                or die(mysqli_error($mysqli));
            $currentUser = $mysqli->query("SELECT * FROM accounts WHERE email = '$cUser'")
                or die($mysqli->error);
        ?>

        <nav class="navbar">
            <div class="logo">OBS</div>
            <ul class="nav-links">
                <input type="checkbox" id="checkbox_toggle" />
                <label for="checkbox_toggle" class="hamburger">&#9776;</label>

                <div class="menu">
                    <li><a href="/client/home.php">Home</a></li>
                    <li class="services">
                        <a href="/client/transactions/history.php">Transactions</a>
                        <ul class="dropdown">
                            <li><a href="/client/transactions/deposit.php">Deposit</a></li>
                            <li><a href="/client/transactions/withdraw.php">Withdraw</a></li>
                            <li><a href="/client/transactions/transfer.php">Transfer funds</a></li>
                        </ul>
                    </li>
                    <li class="services">
                        <?php while($row = $currentUser->fetch_assoc()): ?>
                        <p><?php echo $row['firstname'] . " " . $row['lastname']; ?></p>
                        <?php endwhile; ?>
                        <ul class="dropdown">
                            <li><a href="/client/profile.php">My Account</a></li>
                            <li><a href="/client/logout.php">Logout</a></li>
                        </ul>
                    </li>
                </div>
            </ul>
        </nav>
    </body>
</html>
