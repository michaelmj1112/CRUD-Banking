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

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?=$_SESSION['msg_type']?>">
                <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                ?>
            </div>
        <?php endif ?>

        <?php
            $user = $_SESSION['admin'];
            $mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking') 
                or die(mysqli_error($mysqli));
            $q = $mysqli->query("SELECT * FROM admins WHERE username = '$user'")
                or die($mysqli->error);
        ?>

        <div class="container">
            <div class="row justify-content-center">
                <form action="../../process.php" method="POST">
                    <?php while($row = $q->fetch_assoc()): ?>
                    <input type="hidden" name="id" class="form-control" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="admin" value="1">
                    <div class="form-group">
                        <label>First name</label>
                        <input type="text" name="firstname" class="form-control" value="<?php echo $row['firstname']; ?>" required>

                        <label>Last name</label>
                        <input type="text" name="lastname" class="form-control" value="<?php echo $row['lastname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                        <p><i>Leave empty if you do not wish to change your password</i></p>
                    </div>
                    <?php endwhile; ?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="admin_update">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </body>

    <script>
        $(function() {
            $("#nav-placeholder").load("./navbar/navbar.php");
        });
    </script>
</html>