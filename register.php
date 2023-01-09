<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
                        <label>Firstname</label>
                        <input type="text" name="firstname" class="form-control" required>
                        <label>Lastname</label>
                        <input type="text" name="lastname" class="form-control" required>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" required>
                        <label>City</label>
                        <input type="text" name="city" class="form-control" required>
                        <label>Country</label>
                        <input type="text" name="country" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="text" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password"  class="form-control" required>
                        <label>Confirm password</label>
                        <input type="password" name="cPassword"  class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="register">Register</button>
                        <a href="/">Cancel</a>
                    </div>  
                </form>
            </div>
    </body>
</html>