<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css"/>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
        <link rel="stylesheet" href="/assets/css/history.css">
    </head>
    <body>
        <?php
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

            $mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking')
                or die($mysqli->error);
            $result = $mysqli->query("SELECT * FROM accounts_test")
                or die($mysqli->error);

            while($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $acc_num = $row['account_number'];
                $ssn = $row['SSN'];
                $firstname = $row['firstname'];
                $lastname = $row['lastname'];
                $address = $row['address'];
                $city = $row['city'];
                $country = $row['country'];
                $email = $row['email'];
                $password = $row['password'];
                $balance = $row['balance'];
                $date_created = $row['date_created'];

                echo "ID: " . $id . "<br><br>";
                echo "Account number:  " . $acc_num . "<br>";
                echo "SSN: " . $ssn . "<br>";
                echo "Firstname: " . $firstname . "<br>";
                echo "Lastname:  " . $lastname . "<BR>";
                echo "Address: " . $address . "<BR>";
                echo "City: " . $city . "<br>";
                echo "Country:  " . $country . "<BR>";
                echo "E-mail: " . $email . "<BR>";
                echo "Password: " . $password . "<BR>";
                echo "Balance: " . $balance . "<BR>";
                echo "Date created: " . $date_created . "<BR>";
                
                $usernameDBDecrypted = decryptthis($email, $key);
                $pwDBDecrypted = decryptthis($password, $key);
                echo "Username decrypted from db: " . $usernameDBDecrypted . "<BR>";
                echo "Password decrypted from db: " . $pwDBDecrypted . "<BR>";
                echo "<br><br>";
            }
            
        ?>
    </body>
</html>