<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="/admin/navbar/styles.css" /> 
    </head>
    <body>
        <?php 
            require_once $_SERVER['DOCUMENT_ROOT'] . '/process.php';

            $cUser = $_SESSION['admin'];
            $mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking') 
                or die(mysqli_error($mysqli));
            $query = $mysqli->query("SELECT * FROM admins");
        ?>

        <nav class="navbar">
        <img src="/assets/images/logo.png" alt="Bank logo" width="80" height="80">
            <ul class="nav-links">
                <input type="checkbox" id="checkbox_toggle" />
                <label for="checkbox_toggle" class="hamburger">&#9776;</label>

                <div class="menu">
                    <li><a href="/admin/home.php">Home</a></li>
                    <li class="services">
                        <p>Accounts Management</p>
                        <ul class="dropdown">
                            <li><a href="/admin/accounts/manage_accounts.php">Create new account</a></li>
                            <li><a href="/admin/accounts/">Accounts list</a></li>
                        </ul>
                    </li>
                    <li class="services">
                        <p>Transactions</p>
                        <ul class="dropdown">
                            <li><a href="/admin/transactions/history.php">Transactions list</a></li>
                            <li><a href="/admin/transactions/deposit.php">Deposit</a></li>
                            <li><a href="/admin/transactions/withdraw.php">Withdraw</a></li>
                            <li><a href="/admin/transactions/transfer.php">Transfer funds</a></li>
                        </ul>
                    </li>

                    <?php while ($row = $query->fetch_assoc()): ?>
                    <li class="services">
                        <p><?php echo $row['firstname'] . " " . $row['lastname']; ?></p>
                        <ul class="dropdown">
                            <li><a href="/admin/profile.php">My Account</a></li>
                            <li><a href="/admin/logout.php">Logout</a></li>
                        </ul>
                    </li>
                    <?php endwhile; ?>
                </div>
            </ul>
        </nav>
    </body>
</html>
