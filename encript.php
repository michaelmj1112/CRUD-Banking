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
            // $key = 'qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuu0';
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

            function getAccNum() {
                $num = array();
                for ($i = 0; $i < 10; $i++) {
                    $d = rand(0, 9);
                    $num[$i] = $d;
                    shuffle($num);
                }
            
                return $num;
            }

            $mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking')
                or die($mysqli->error);

            if (isset($_POST['register'])) {
                $acc_num = getAccNum();
                $acc_num = implode($acc_num);
                $ssn = $_POST['ssn'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $address = $_POST['address'];
                $city = $_POST['city'];
                $country = $_POST['country'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                $emailEncrypted = encryptthis($email, $key);
                $passEncrypted = encryptthis($password, $key);
                $passDecrypted = decryptthis($passEncrypted, $key);

                echo "Password: " . $password . "<BR>";
                echo $passEncrypted . "<BR>";
                echo $passDecrypted;

                // $query = $mysqli->query("INSERT INTO `accounts_test`(`account_number`, `SSN`, `firstname`, `lastname`, `address`, `city`, `country`, `email`, `password`) 
                //                             VALUES ('$acc_num','$ssn','$firstname','$lastname','$address','$city','$country','$emailEncrypted','$passEncrypted')")
                //     or die($mysqli->error);
            }
        ?>

        <div class="container">
            <div class="row justify-content-center">
                <form method="POST">
                    <div class="form-group">
                        <label>SSN</label>
                        <input type="text" name="ssn" class="form-control" >
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label>Firstname</label>
                        <input type="text" name="firstname" class="form-control" >
                        <label>Lastname</label>
                        <input type="text" name="lastname" class="form-control" >
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" >
                        <label>City</label>
                        <input type="text" name="city" class="form-control" >
                        <label>Country</label>
                        <input type="text" name="country" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="text" name="email" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password"  class="form-control" >
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="register">Register</button>
                        <a href="/">Cancel</a>
                    </div>  
                </form>
            </div>
        </div>
    </body>
</html>