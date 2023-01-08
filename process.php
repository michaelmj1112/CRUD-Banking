<?php

session_start();
date_default_timezone_set("Asia/Taipei");

$mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking')
            or die($mysqli->error);

$isAdmin = 0;
$update = false;
$id = 0;
$accNum = '';
$firstname = '';
$lastname = '';
$email = '';

function setCurrUser($uName) {
    return $_SESSION['cUser'] = $uName;
}

function getID($acc_num) {
    $conn = mysqli_connect('127.0.0.1', 'root', '1234', 'banking')
            or die($conn->error);
    $q = $conn->query("SELECT id FROM accounts WHERE account_number = $acc_num");
    $row = mysqli_fetch_assoc($q);

    $id = $row['id'];
    return $id;
}

function getAccNum() {
    $num = array();
    for ($i = 0; $i < 10; $i++) {
        $d = rand(0, 9);
        $num[$i] = $d;
        shuffle($num);
    }

    return $num;
}

class TransactionDemo {

    const DB_HOST = '127.0.0.1';
    const DB_NAME = 'banking';
    const DB_USER = 'root';
    const DB_PASSWORD = '1234';

    /**
     * Open the database connection
     */
    public function __construct() {
        // open database connection
        $conStr = sprintf("mysql:host=%s;dbname=%s", self::DB_HOST, self::DB_NAME);
        try {
            $this->pdo = new PDO($conStr, self::DB_USER, self::DB_PASSWORD);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * PDO instance
     * @var PDO 
     */
    private $pdo = null;

    /**
     * Transfer money between two accounts
     * @param int $from
     * @param int $to
     * @param float $amount
     * @return true on success or false on failure.
     */
    public function transfer($from, $to, $amount, $isAdmin) {

        try {
            $this->pdo->beginTransaction();

            // get available amount of the transferer account
            $sql = 'SELECT balance FROM accounts WHERE id=:from';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array(":from" => $from));
            $availableAmount = (int) $stmt->fetchColumn();
            $stmt->closeCursor();

            if ($availableAmount < $amount) {
                echo 'Insufficient amount to transfer';
                $_SESSION['message'] = "Insufficient amount to transfer";
                $_SESSION['msg_type'] = "danger";
                header('location: transfer.php');
                return false;
            }
            // deduct from the transferred account
            $sql_update_from = 'UPDATE accounts
				SET balance = balance - :amount
				WHERE id = :from';
            $stmt = $this->pdo->prepare($sql_update_from);
            $stmt->execute(array(":from" => $from, ":amount" => $amount));
            $stmt->closeCursor();

            // add to the receiving account
            $sql_update_to = 'UPDATE accounts
                                SET balance = balance + :amount
                                WHERE id = :to';
            $stmt = $this->pdo->prepare($sql_update_to);
            $stmt->execute(array(":to" => $to, ":amount" => $amount));
            $stmt->closeCursor();
            // commit the transaction
            

            $transactions_from = "INSERT INTO `transactions` (`account_id`, `type`, `amount`, `remarks`) VALUE ('$from', '3', '$amount', 'Transferred to $to')";
            $stmt = $this->pdo->prepare($transactions_from);
            $stmt->execute();
            $stmt->closeCursor();

            $transactions_to = "INSERT INTO `transactions` (`account_id`, `type`, `amount`, `remarks`) VALUE ('$to', '3', '$amount', 'Transferred from $from')";
            $stmt = $this->pdo->prepare($transactions_to);
            $stmt->execute();
            $stmt->closeCursor();

            $this->pdo->commit();

            echo 'The amount has been transferred successfully';

            $_SESSION['message'] = "Transferred succesfully";
            $_SESSION['msg_type'] = "success";

            if ($isAdmin == 1) {
                header('location: /admim/transactions/transfer.php');
            } else {
                header('location: /client/transactions/transfer.php');
            }
            
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            die($e->getMessage());
        }
    }

    public function withdraw($from, $amount, $isAdmin) {
        try {
            $this->pdo->beginTransaction();

            // get available amount of the transferer account
            $sql = 'SELECT balance FROM accounts WHERE id=:from';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array(":from" => $from));
            $availableAmount = (int) $stmt->fetchColumn();
            $stmt->closeCursor();

            if ($availableAmount < $amount) {
                echo 'Insufficient balance';
                $_SESSION['message'] = "Insufficient balance";
                $_SESSION['msg_type'] = "danger";
                if ($isAdmin == 1) {
                    header('location: /admin/transactions/withdraw.php');
                } else {
                    header('location: /client/transactions/withdraw.php');
                }
                return false;
            }
            // deduct
            $sql_update_from = 'UPDATE accounts
				SET balance = balance - :amount
				WHERE id = :from';
            $stmt = $this->pdo->prepare($sql_update_from);
            $stmt->execute(array(":from" => $from, ":amount" => $amount));
            $stmt->closeCursor();

            $transactions_update = "INSERT INTO `transactions` (`account_id`, `type`, `amount`, `remarks`) VALUE ('$from', '2', '$amount', 'Withdraw')";
            $stmt = $this->pdo->prepare($transactions_update);
            $stmt->execute();
            $stmt->closeCursor();

            $this->pdo->commit();

            $_SESSION['message'] = "Withdrew succesfully";
            $_SESSION['msg_type'] = "success";

            if ($isAdmin == 1) {
                header('location: /admin/transactions/withdraw.php');
            } else {
                header('location: /client/transactions/withdraw.php');
            }

            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            die($e->getMessage());
        }
    }

    public function deposit($from, $amount, $isAdmin) {
        try {
            $this->pdo->beginTransaction();

            // get available amount of the transferer account
            $sql = 'SELECT balance FROM accounts WHERE id=:from';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array(":from" => $from));
            $availableAmount = (int) $stmt->fetchColumn();
            $stmt->closeCursor();

            // add to the receiving account
            $sql_update_to = 'UPDATE accounts
                                SET balance = balance + :amount
                                WHERE id = :from';
            $stmt = $this->pdo->prepare($sql_update_to);
            $stmt->execute(array(":from" => $from, ":amount" => $amount));
            $stmt->closeCursor();
            // commit the transaction
            

            $transactions_update = "INSERT INTO `transactions` (`account_id`, `type`, `amount`, `remarks`) VALUE ('$from', '1', '$amount', 'Deposit')";
            $stmt = $this->pdo->prepare($transactions_update);
            $stmt->execute();
            $stmt->closeCursor();

            $this->pdo->commit();

            $_SESSION['message'] = "Deposited succesfully";
            $_SESSION['msg_type'] = "success";

            if ($isAdmin == 1) {
                header('location: /admin/transactions/deposit.php');
            } else {
                header('location: /client/transactions/deposit.php');
            }
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            die($e->getMessage());
        }
    }

    /**
     * close the database connection
     */
    public function __destruct() {
        // close the database connection
        $this->pdo = null;
    }
}

// Client Login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cUser = $email;
    setCurrUser($email);

    $result = $mysqli->query("SELECT * FROM accounts WHERE email = '$email' AND password = '$password'")
                or die("Failed to query database".mysqli_error($mysqli));

    $row = $result->fetch_assoc();
    if ($row['username'] == $username && $row['password'] == $password) {
        header('location: ./client/home.php');
    }
    else {
        $_SESSION['message'] = "Login failed!";
        $_SESSION['msg_type'] = "danger";
        header('location: index.php');
    }
}

// Admin Login
if (isset($_POST['admin_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $_SESSION['admin'] = $username;
    $date = date("Y-m-d H:i:s");

    $result = $mysqli->query("SELECT * FROM admins WHERE username = '$username' AND password = '$password'")
                or die("Failed to query database".mysqli_error($mysqli));
    $row = $result->fetch_assoc();

    if ($row['username'] == $username && $row['password'] == $password) {
        $query = $mysqli->query("UPDATE admins SET last_login = '$date'")
                or die($mysqli->error);
        header('location: /admin/home.php');
    }
    else {
        $_SESSION['message'] = "Login failed!";
        $_SESSION['msg_type'] = "danger";
        header('location: /admin/index.php');
    }
}

if (isset($_POST['register'])) {
    $password = $_POST['password'];
    $cPassword = $_POST['cPassword'];

    echo $password . " -- " . $cPassword . "<BR>";
    if ($password != $cPassword) {
        $_SESSION['message'] = "Password doesn't match!";
        $_SESSION['msg_type'] = "warning";
        header('location: register.php');
    } else {
        $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $num = getAccNum();
        $num = implode($num);
        $query = $mysqli->query("INSERT INTO `accounts`(`account_number`, `firstname`, `lastname`, `email`, `password`, `balance`) VALUES ('$num','$firstname','$lastname','$email','$password','0')")
            or die($mysqli->error);
        $_SESSION['message'] = "Registered succesfully";
        $_SESSION['msg_type'] = "success";
        header('location: index.php');
    }
}

if (isset($_POST['transfer'])) {
    $transferer = getID($_POST['transferer']);
    $transferee = getID($_POST['transferee']);
    $amount = $_POST['amount'];
    $isAdmin = $_POST['isAdmin'];

    $obj = new TransactionDemo();
    $obj->transfer($transferer, $transferee, $amount, $isAdmin);
}

if (isset($_POST['withdraw'])) {
    $from = getID($_POST['from']);
    $amount = $_POST['amount'];
    $isAdmin = $_POST['isAdmin'];

    $obj = new TransactionDemo();
    $obj->withdraw($from, $amount, $isAdmin);
}

if (isset($_POST['deposit'])) {
    $from = getID($_POST['from']);
    $amount = $_POST['amount'];
    $isAdmin = $_POST['isAdmin'];

    $obj = new TransactionDemo();
    $obj->deposit($from, $amount, $isAdmin);
}

if (isset($_POST['create_account'])) {
    $accNum = $_POST['number'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $balance = $_POST['balance'];

    echo $accNum . "<br>" . $firstname . "<br>" . $lastname . "<br>" . $email . "<br>" . $password . "<br>";
    $query = $mysqli->query("INSERT INTO `accounts`(`account_number`, `firstname`, `lastname`, `email`, `password`, `balance`) VALUES ('$accNum','$firstname','$lastname','$email','$password','$balance')")
        or die($mysqli->error);
}

// ADMIN client account update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $accNum = $_POST['number'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $date = date("Y-m-d H:i:s");
    // echo $id . "<br>" . $accNum . "<br>" . $firstname . "<br>" . $lastname . "<br>" . $email . "<br>" . $password . "<br>" . $date . "<br>";
    $query = $mysqli->query("UPDATE `accounts` SET `account_number`='$accNum',`firstname`='$firstname',`lastname`='$lastname',`email`='$email',`password`='$password',`date_updated`='$date' WHERE id=$id")
        or die($mysqli->error);

    $_SESSION['message'] = "Record has been updated!";
    $_SESSION['msg_type'] = "warning";

    header('location: ./admin/accounts/index.php');
}

// CLIENT update own profile
if (isset($_POST['client_update'])) {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $date = date("Y-m-d H:i:s");

    if ($password != '') {
        $query = $mysqli->query("UPDATE `accounts` SET `firstname`='$firstname',`lastname`='$lastname',`email`='$email',`password`='$password',`date_updated`='$date' WHERE id=$id")
            or die($mysqli->error);
    } else {
        $query = $mysqli->query("UPDATE `accounts` SET `firstname`='$firstname',`lastname`='$lastname',`email`='$email', `date_updated`='$date' WHERE id=$id")
            or die($mysqli->error);
    }
    
    $_SESSION['message'] = "Record has been updated!";
    $_SESSION['msg_type'] = "warning";

    header('location: /client/profile.php');
}

// ADMIN update own profile
if (isset($_POST['admin_update'])) {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $date = date("Y-m-d H:i:s");

    if ($password != '') {
        $query = $mysqli->query("UPDATE `admins` SET `firstname`='$firstname',`lastname`='$lastname',`username`='$username',`password`='$password',`date_updated`='$date' WHERE id=$id")
            or die($mysqli->error);
    } else {
        $query = $mysqli->query("UPDATE `admins` SET `firstname`='$firstname',`lastname`='$lastname',`username`='$username', `date_updated`='$date' WHERE id=$id")
            or die($mysqli->error);
    }

    $_SESSION['message'] = "Record has been updated!";
    $_SESSION['msg_type'] = "warning";

    header('location: /admin/profile.php');
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;

    $query = $mysqli->query("SELECT * FROM accounts WHERE id=$id")
        or die($mysqli->error);
    $row = $query->fetch_array();
    $accNum = $row['account_number'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $email = $row['email'];
}