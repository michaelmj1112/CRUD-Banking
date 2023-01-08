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

        <div class="container">
            <div class="row justify-content-center">
                <form action="../../process.php" method="POST">
                    <?php if ($update !== true): ?>
                    <h2>Create New Account</h2>
                    <?php else: ?>
                    <h2>Update Account</h2>
                    <?php endif; ?>
                    
                    <input type="hidden" name="id" class="form-control" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <label>Account number</label>
                        <input type="text" name="number" class="form-control" value="<?php echo $accNum; ?>">
                    </div>
                    <div class="form-group">
                        <label>First name</label>
                        <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">

                        <label>Last name</label>
                        <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" name="password" class="form-control">
                    </div>

                    <?php if ($update != true): ?>
                    <div class="form-group">
                        <label>Beginning balance</label>
                        <input type="text" name="balance" class="form-control">
                    </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <?php if ($update != true): ?>
                        <button type="submit" class="btn btn-primary" name="create_account">Save</button>
                        <?php else: ?>
                        <button type="submit" class="btn btn-primary" name="update">Update</button>
                        <a href="/admin/accounts/index.php">Cancel</a>
                        <?php endif; ?>
                    </div>

                </form>
            </div>
        </div>
    </body>

    <script>
        $(function() {
            $("#nav-placeholder").load("../navbar/navbar.php");
        });
    </script>
</html>