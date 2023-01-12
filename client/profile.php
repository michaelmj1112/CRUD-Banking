<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="/assets/css/profile.css">
        <link rel="stylesheet" href="/assets/css/password.css">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
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
            $cUser = $_SESSION['cUser']; 
            $mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking') 
                or die(mysqli_error($mysqli));
            $q = $mysqli->query("SELECT * FROM accounts WHERE email = '$cUser'")
                or die($mysqli->error);
        ?>

        <div class="container">
            <div class="row justify-content-center">
                <form action="../../process.php" method="POST">
                    <?php while($row = $q->fetch_assoc()): ?>
                    <input type="hidden" name="id" class="form-control" value="<?php echo $row['id']; ?>">
                    <div class="flexbox">
                        <div class="flex-left">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="psw" name="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                                <p style="font-size:x-small;"><i>Leave empty if you do not wish to change your password</i></p>
                                <div id="message">
                                    <p><strong>Password must contain the following:</strong></p>
                                    <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                                    <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                                    <p id="number" class="invalid">A <b>number</b></p>
                                    <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Confirm password</label>
                                <input type="password" name="cPassword" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                            </div>
                        </div>
                        <div class="flex-right">
                            <div class="form-group">
                                <h2>Name</h2>
                                <p><?php echo $row['firstname'] . " " . $row['lastname']; ?></p>
                            </div>
                            <div class="form-group">
                                <h2>Address</h2>
                                <blockquote class="spoiler">
                                    <p><?php echo $row['address'] . ", " . $row['city'] . ", " . $row['country']; ?></p>
                                </blockquote>
                            </div>
                            <div class="form-group">
                                <h2>TEL</h2>
                                <blockquote class="spoiler">
                                    <p><?php echo $row['TEL']; ?></p>
                                </blockquote>
                            </div>
                            <p style="font-size:small;"><i>Contact an administrator if you wish to change your biodata</i></p>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <div class="submit">
                        <button type="submit" class="btn btn-primary" name="client_update">Update</button>
                        <a href="/client/home.php" style="padding-left: 0.5em;">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </body>
    <script src="/assets/password.js"></script>
    <script>
        $(function() {
            $("#nav-placeholder").load("./navbar/navbar.php");
        });
    </script>
</html>