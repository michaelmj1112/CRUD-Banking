<?php

session_start();
date_default_timezone_set("Asia/Taipei");

$mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking')
            or die($mysqli->error);

$isAdmin = 0;
$update = false;
$id = 0;
$ssn = '';
$accNum = '';
$firstname = '';
$lastname = '';
$address = '';
$city = '';
$country = '';
$tel = '';
$email = '';

$to_acc = '';
$to_name = '';

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

$key = 'dcnakd3917&^34918djakw0+41-';
function encryptthis($data, $key) {
    $encryption_key = base64_decode($key);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

function decryptthis($data, $key) {
    $encryption_key = base64_decode($key);
    list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data), 2),2,null);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
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
    public function transfer($from, $to, $amount, $isAdmin, $fromName, $toName, $from_accNum, $to_accNum) {

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
            

            $transactions_from = "INSERT INTO `transactions` (`account_id`, `type`, `amount`, `remarks`) VALUE ('$from', '3', '$amount', 'Transferred to $from_accNum - $toName')";
            $stmt = $this->pdo->prepare($transactions_from);
            $stmt->execute();
            $stmt->closeCursor();

            $transactions_to = "INSERT INTO `transactions` (`account_id`, `type`, `amount`, `remarks`) VALUE ('$to', '3', '$amount', 'Transferred from $to_accNum - $fromName')";
            $stmt = $this->pdo->prepare($transactions_to);
            $stmt->execute();
            $stmt->closeCursor();

            $this->pdo->commit();

            echo 'The amount has been transferred successfully';

            $_SESSION['message'] = "Transferred succesfully";
            $_SESSION['msg_type'] = "success";

            if ($isAdmin == 1) {
                header('location: /admin/transactions/transfer.php');
            } else {
                header('location: /client/transactions/transfer.php');
            }
            
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            die($e->getMessage());
        }
    }

    public function withdraw($from, $amount, $isAdmin, $from_accNum, $fromName) {
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

            $transactions_update = "INSERT INTO `transactions` (`account_id`, `type`, `amount`, `remarks`) VALUE ('$from', '2', '$amount', '$from_accNum - $fromName [Withdraw]')";
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

    public function deposit($from, $amount, $isAdmin, $from_accNum, $fromName) {
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
            

            $transactions_update = "INSERT INTO `transactions` (`account_id`, `type`, `amount`, `remarks`) VALUE ('$from', '1', '$amount', '$from_accNum - $fromName [Deposit]')";
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

    // $query = $mysqli->query("SELECT * FROM accounts ")

    $result = $mysqli->query("SELECT * FROM accounts WHERE email = '$email'")
                or die("Failed to query database".mysqli_error($mysqli));

    $row = $result->fetch_assoc();
    $DBpassword = decryptthis($row['password'], $key);
    if ($row['email'] == $email && $DBpassword == $password) {
        header('location: ./client/home.php');
        $_SESSION['cUser'] = $cUser;
        $_SESSION['cUser_acc'] = $row['account_number'];
    }
    else {
        // echo "E-mail: " . $email . "<br>";
        // echo "Password: " . $password . "<br>";
        // echo "DB password: " . $password . "<br>";
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

    $result = $mysqli->query("SELECT * FROM admins WHERE username = '$username'")
                or die("Failed to query database".mysqli_error($mysqli));
    $row = $result->fetch_assoc();

    $passDecrypted = decryptthis($row['password'] , $key);
    if ($row['username'] == $username && $passDecrypted == $password) {
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
    $acc_num = getAccNum();
    $acc_num = implode($acc_num);
    $ssn = $_POST['ssn'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cPassword = $_POST['cPassword'];

    // echo $password . " -- " . $cPassword . "<BR>";
    if ($password != $cPassword) {
        $_SESSION['message'] = "Password doesn't match!";
        $_SESSION['msg_type'] = "warning";
        header('location: register.php');
    } else {
        $passEncrypted = encryptthis($password, $key);

        $query = $mysqli->query("INSERT INTO `accounts`(`account_number`, `SSN`, `firstname`, `lastname`, `address`, `city`, `country`, `TEL`, `email`, `password`) 
                                    VALUES ('$acc_num','$ssn','$firstname','$lastname','$address','$city','$country', '$tel','$email','$passEncrypted')")
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

    $from_query = $mysqli->query("SELECT * FROM accounts WHERE id = $transferer")
        or die($mysqli->error);
    $to_query = $mysqli->query("SELECT * FROM accounts WHERE id = $transferee")
        or die($mysqli->error);

    $from_row = $from_query->fetch_assoc();
    $fromName = $from_row['firstname'] . ' ' . $from_row['lastname'];
    $from_accNum = $from_row['account_number'];

    $to_row = $to_query->fetch_assoc();
    $toName = $to_row['firstname'] . ' ' . $to_row['lastname'];
    $to_accNum = $to_row['account_number'];



    $obj = new TransactionDemo();
    $obj->transfer($transferer, $transferee, $amount, $isAdmin, $fromName, $toName, $from_accNum, $to_accNum);
}

if (isset($_POST['withdraw'])) {
    $from = getID($_POST['from']);
    $amount = $_POST['amount'];
    $isAdmin = $_POST['isAdmin'];

    $query = $mysqli->query("SELECT * FROM accounts WHERE id = $from")
        or die($mysqli->error);
    $row = $query->fetch_assoc();
    $fromName = $row['firstname'] . ' ' . $row['lastname'];
    $from_accNum = $row['account_number'];

    $obj = new TransactionDemo();
    $obj->withdraw($from, $amount, $isAdmin, $from_accNum, $fromName);
}

if (isset($_POST['deposit'])) {
    $from = getID($_POST['from']);
    $amount = $_POST['amount'];
    $isAdmin = $_POST['isAdmin'];

    $query = $mysqli->query("SELECT * FROM accounts WHERE id = $from")
        or die($mysqli->error);
    $row = $query->fetch_assoc();
    $fromName = $row['firstname'] . ' ' . $row['lastname'];
    $from_accNum = $row['account_number'];

    $obj = new TransactionDemo();
    $obj->deposit($from, $amount, $isAdmin, $from_accNum, $fromName);
}

if (isset($_POST['create_account'])) {
    $acc_num = getAccNum();
    $acc_num = implode($acc_num);
    $ssn = $_POST['ssn'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cPassword = $_POST['cPassword'];
    $balance = $_POST['balance'];

    // echo $password . " -- " . $cPassword . "<BR>";
    if ($password != $cPassword) {
        $_SESSION['message'] = "Password doesn't match!";
        $_SESSION['msg_type'] = "warning";
        header('location: /admin/accounts/manage_accounts.php');
    } else {
        $passEncrypted = encryptthis($password, $key);

        $query = $mysqli->query("INSERT INTO `accounts`(`account_number`, `SSN`, `firstname`, `lastname`, `address`, `city`, `country`, `TEL`, `email`, `password`, `balance`) 
                                    VALUES ('$acc_num','$ssn','$firstname','$lastname','$address','$city','$country', '$tel','$email','$passEncrypted', '$balance')")
            or die($mysqli->error);
        $_SESSION['message'] = "Registered succesfully";
        $_SESSION['msg_type'] = "success";
        header('location: /admin/accounts/manage_accounts.php');
    }

    // $accNum = $_POST['number'];
    // $firstname = $_POST['firstname'];
    // $lastname = $_POST['lastname'];
    // $email = $_POST['email'];
    // $password = $_POST['password'];
    // $balance = $_POST['balance'];

    // echo $accNum . "<br>" . $firstname . "<br>" . $lastname . "<br>" . $email . "<br>" . $password . "<br>";
    // $query = $mysqli->query("INSERT INTO `accounts`(`account_number`, `firstname`, `lastname`, `email`, `password`, `balance`) VALUES ('$accNum','$firstname','$lastname','$email','$password','$balance')")
    //     or die($mysqli->error);
}

// ADMIN client account update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $ssn = $_POST['ssn'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cPassword = $_POST['cPassword'];
    $date = date("Y-m-d H:i:s");

    echo "UPDATE";

    echo "Password: " . $password . "<BR>";
    if ($password != '') {
        // Change password
        if ($password != $cPassword) {
            $_SESSION['message'] = "Password doesn't match!";
            $_SESSION['msg_type'] = "danger";
            header('location: admin/accounts/manage_accounts.php?edit=' . $id);
        } else {
            $password = encryptthis($password, $key);
            $query = $mysqli->query("UPDATE `accounts` SET `email`='$email',`password`='$password',`date_updated`='$date' WHERE id=$id")
            or die($mysqli->error);
            $_SESSION['message'] = "Record has been updated!";
            $_SESSION['msg_type'] = "warning";

            header('location: /admin/accounts/index.php');
        }
    } else {
        // Only change e-mail
        $query = $mysqli->query("UPDATE `accounts` SET `email`='$email', `date_updated`='$date' WHERE id=$id")
            or die($mysqli->error);
        $_SESSION['message'] = "Record has been updated!";
        $_SESSION['msg_type'] = "warning";

        header('location: /admin/accounts/index.php');
    }
//     $id = $_POST['id'];
//     $accNum = $_POST['number'];
//     $firstname = $_POST['firstname'];
//     $lastname = $_POST['lastname'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];

//     $date = date("Y-m-d H:i:s");
//     // echo $id . "<br>" . $accNum . "<br>" . $firstname . "<br>" . $lastname . "<br>" . $email . "<br>" . $password . "<br>" . $date . "<br>";
//     $query = $mysqli->query("UPDATE `accounts` SET `account_number`='$accNum',`firstname`='$firstname',`lastname`='$lastname',`email`='$email',`password`='$password',`date_updated`='$date' WHERE id=$id")
//         or die($mysqli->error);

//     $_SESSION['message'] = "Record has been updated!";
//     $_SESSION['msg_type'] = "warning";

//     header('location: ./admin/accounts/index.php');
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $query = $mysqli->query("DELETE FROM accounts WHERE id = $id")
        or die($mysqli->error);

    $_SESSION['message'] = "Account has been deleted.";
    $_SESSION['msg_type'] = "danger";

    header('location: ./admin/accounts/index.php');
}

// CLIENT update own profile
if (isset($_POST['client_update'])) {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cPassword = $_POST['cPassword'];
    $date = date("Y-m-d H:i:s");
    $_SESSION['cUser'] = $email;

    echo "Password: " . $password . "<BR>";
    if ($password != '') {
        // Change password
        if ($password != $cPassword) {
            $_SESSION['message'] = "Password doesn't match!";
            $_SESSION['msg_type'] = "warning";
            header('location: /client/profile.php');
        } else {
            $password = encryptthis($password, $key);
            $query = $mysqli->query("UPDATE `accounts` SET `email`='$email',`password`='$password',`date_updated`='$date' WHERE id=$id")
            or die($mysqli->error);
            $_SESSION['message'] = "Record has been updated!";
            $_SESSION['msg_type'] = "warning";

            header('location: /client/profile.php');
        }
    } else {
        // Only change e-mail
        $query = $mysqli->query("UPDATE `accounts` SET `email`='$email', `date_updated`='$date' WHERE id=$id")
            or die($mysqli->error);
        $_SESSION['message'] = "Record has been updated!";
        $_SESSION['msg_type'] = "warning";

        header('location: /client/profile.php');
    }
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
    $ssn = $row['SSN'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $address = $row['address'];
    $city = $row['city'];
    $country = $row['country'];
    $tel = $row['TEL'];
    $email = $row['email'];
}

if (isset($_GET['edit_transfer_list'])) {
    $update = true;
    $to_acc = $_GET['edit_transfer_list'];

    $query = $mysqli->query("SELECT * FROM transfer_list WHERE to_acc = '$to_acc'")
        or die($mysqli->error);
    $row = $query->fetch_array();
    $to_name = $row['to_name'];
}

if (isset($_POST['transfer_list'])) {
    $from_acc = $_POST['from_acc'];
    $to_acc = $_POST['to_acc'];
    $to_name = $_POST['to_name'];

    echo "From: " . $from_acc . "<br>";
    echo "to: " . $to_acc . "<br>";

    $stmt = $mysqli->query("SELECT from_acc FROM transfer_list WHERE to_acc = '$to_acc' AND from_acc = '$from_acc'")
        or die($mysqli->error);
    if ($stmt->fetch_column() > 0) {
        echo "Multiple acc<br>";
        $_SESSION['message'] = "Account already registered!";
        $_SESSION['msg_type'] = "warning";

        header('location: /client/transactions/transfer_list.php');
    } else {
        echo "New acc<br>";
        $q = $mysqli->query("SELECT * FROM accounts WHERE account_number = '$to_acc'")
            or die($mysqli->error);
        $row = $q->fetch_assoc();

        if (is_null($row['firstname'])) {
            // echo "NULL";
            $_SESSION['message'] = "Account doesn't exist!";
            $_SESSION['msg_type'] = "warning";

            header('location: /client/transactions/transfer_list.php');
        } else {
            $query = $mysqli->query("INSERT INTO `transfer_list`(`from_acc`, `to_acc`, `to_name`) VALUES ('$from_acc','$to_acc','$to_name')")
                or die($mysqli->error);
            
            $_SESSION['message'] = "Account successfully registered!";
            $_SESSION['msg_type'] = "success";

            header('location: /client/transactions/transfer_list.php');
        }
    }
}

if (isset($_POST['update_transfer_list'])) {
    $from_acc = $_POST['from_acc'];
    $to_acc = $_POST['to_acc'];
    $to_name = $_POST['to_name'];

    $query = $mysqli->query("UPDATE `transfer_list` SET `to_acc`='$to_acc',`to_name`='$to_name' WHERE `to_acc` = '$to_acc' AND `from_acc` = '$from_acc'")
        or die($mysqli->error);

    $_SESSION['message'] = "Record changed succesfully.";
    $_SESSION['msg_type'] = "warning";

    header('location: /client/transactions/transfer_list.php');
}

if (isset($_GET['delete_transfer_list'])) {
    $id = $_GET['delete_transfer_list'];

    $query = $mysqli->query("DELETE FROM transfer_list WHERE id = $id")
        or die($mysqli->error);

    $_SESSION['message'] = "Record has been deleted.";
    $_SESSION['msg_type'] = "danger";

    header('location: /client/transactions/transfer_list.php');
}