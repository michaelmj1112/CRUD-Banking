<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="/assets/css/password.css">
        <link rel="stylesheet" href="/assets/css/index.css">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </head>

    <body>
        <?php require_once 'process.php'; ?>

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
                <form action="process.php" method="POST">
                    <div class="form-group">
                        <label>SSN</label>
                        <input type="text" name="ssn" class="form-control" required>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label style="margin-top: 0.6em; margin-right: 0.7em;">Firstname</label>
                        <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>"required>
                        <label style="margin-top: 0.6em; margin-right: 0.7em; margin-left: 1em;">Lastname</label>
                        <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>" required>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label style="margin-top: 0.6em; margin-right: 0.7em;">Address</label>
                        <input type="text" name="address" class="form-control" value="<?php echo $address; ?>" required>
                        <label style="margin-top: 0.6em; margin-right: 0.7em; margin-left: 1em;">City</label>
                        <input type="text" name="city" class="form-control" value="<?php echo $city; ?>" required>
                        <label style="margin-top: 0.6em; margin-right: 0.7em; margin-left: 1em;">Country</label>
                        <input type="text" name="country" class="form-control" value="<?php echo $country; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Phone number</label>
                        <input type="tel" name="tel" class="form-control" pattern="[0-9]{4}-[0-9]{3}-[0-9]{3}" required>
                        <span class="note">Format: xxxx-xxx-xxx</span>
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" id="psw" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                        <div id="message">
                            <h3>Password must contain the following:</h3>
                            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                            <p id="number" class="invalid">A <b>number</b></p>
                            <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                        </div>
                        <label>Confirm password</label>
                        <input type="password" name="cPassword"  class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="register">Register</button>
                        <a href="/">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </body>
    <script src="/assets/password.js"></script>
</html>