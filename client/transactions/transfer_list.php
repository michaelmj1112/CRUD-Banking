<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css"/>
        <link rel="stylesheet" href="/assets/css/background.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
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
            $row = mysqli_fetch_assoc($q);
            $acc_num = $row['account_number'];
            
            $result = $mysqli->query("SELECT * FROM transfer_list WHERE from_acc = '$acc_num'")
                or die($mysqli->error);
        ?>

        <div class="container">
            <div class="row justiy-content-center">
                <div class="col-lg-10 rounded my-2 py-2">
                    <table class="table" style="font-size: 1.3rem; margin-left: 1em;">
                        <thead>
                            <tr>
                                <th>Account #</th>
                                <th>Nickname</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['to_acc']; ?></td>
                                    <td><?php echo $row['to_name']; ?></td>
                                    <td>
                                        <a href="transfer_list.php?edit_transfer_list=<?php echo $row['to_acc']; ?>" class="btn btn-info">Edit</a>
                                        <a href="/process.php?delete_transfer_list=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <form action="/process.php" method="POST" style="margin-left: 3em;">
                    <div class="form-group">
                        <?php if ($update !== true): ?>
                        <h2>Register new account</h2>
                        <?php else: ?>
                        <h2>Update Account</h2>
                        <?php endif; ?>
                        
                        <label>Account #</label>
                        <input type="hidden" name="from_acc" value="<?php echo $acc_num; ?>"> 

                        <input type="text" name="to_acc" class="form-control" value="<?php echo $to_acc; ?>" required>
                        <label>Nickname</label>
                        <input type="text" name="to_name" class="form-control" value="<?php echo $to_name; ?>" required>

                        <?php if ($update !== true): ?>
                        <button type="submit" class="btn btn-primary" name="transfer_list" style="margin-top: 1em;">Submit</button>
                        <?php else: ?>
                        <button type="submit" class="btn btn-primary" name="update_transfer_list" style="margin-top: 1em;">Update</button>
                        <a href="/client/transactions/transfer_list.php" class="btn" style="margin-top: 1em;">Cancel</a>    
                        <?php endif; ?>
                    </div>
                </form>
                
            </div>
        </div>
    </body>

    <!-- <script type="text/javascript">
        $(document).ready(function() {
            $('table').DataTable();
        });
    </script> -->

    <script>
        function showName(str) {
            if (str.length == 0) {
                document.getElementById("accName").innerHTML = "";
                return;
            }
            else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("accName").innerHTML = this.responseText;
                        document.getElementById("accBal").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "../../functions/getName.php?q=" + str, true);
                xmlhttp.send();
            }
        }

        $(function() {
            $("#nav-placeholder").load("../navbar/navbar.php");
        });
    </script>
</html>