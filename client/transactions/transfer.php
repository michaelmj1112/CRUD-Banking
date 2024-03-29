<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="/assets/css/transfer.css">
        <link rel="stylesheet" href="/assets/css/background.css">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>
    <body>
        <div id="nav-placeholder"></div>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/process.php'; ?>

        <?php
            $cUser = $_SESSION['cUser'];
            $cUser_acc = $_SESSION['cUser_acc'];
            $mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking') 
                or die(mysqli_error($mysqli));
            $currentUser = $mysqli->query("SELECT * FROM accounts WHERE email = '$cUser'")
                or die($mysqli->error);
            
            $recent = $mysqli->query("SELECT * FROM transfer_list WHERE from_acc = '$cUser_acc'")
                or die($mysqli->error);
        ?>

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
                <form action="/process.php" method="POST">
                    <?php 
                        while($row = $currentUser->fetch_assoc()): 
                        $acc_num = $row['account_number'];
                        $balance = number_format($row['balance'], 2, '.', ',');
                    ?>
                    <div class="flexbox">
                        <div class="flex-left">
                            <div class="form-group">
                                <label>Transferer</label>
                                <input type="text" name="transferer" class="form-control" value="<?php echo $row['account_number']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Available balance:</label>
                                <label>TWD  <?php echo $balance; ?></label>
                            </div>
                        <?php endwhile; ?>
                        </div>
                        <div class="flex-right">
                            <div class="form-group">
                                <label>Transfer to</label>
                                <input type="text" id="input" name="transferee" class="form-control" onkeyup="showName(this.value)" autofocus="autofocus">
                            </div>
                            <div>
                                <label>Select from transfer list</label>
                            </div>
                            <select id="select" onchange="recentTransfer()" style="margin-bottom: 1em;">
                                    <option value="">-</option>
                                    <?php while($row = $recent->fetch_assoc()): ?>
                                    <option value="<?php echo $row['to_acc']; ?>"><?php echo $row['to_acc'] . " - ". $row['to_name']; ?></option>
                                    <?php endwhile; ?>
                            </select>
                            <div class="form-group">
                                <label>Name</label>
                                <p><i><span id="accName"></i></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="padding: 0em 1em;">
                        <label>Amount</label>
                        <input type="text" name="amount" class="form-control" placeholder="Enter amount to be transfered">
                    </div>
                    <div class="form-group" style="padding: 0em 1em;">
                        <button type="submit" class="btn btn-primary" name="transfer">Continue</button>
                        <a href="home.php">Back</a>
                    </div>
                </form>
            </div>
        </div>
        
    </body>

    <script>
        $(function(){
            $("#select").change(function(){
                $("#input").val($('#select option:selected').val());
                $("#input").keyup();
            });     
        });

        function recentTransfer() {
        var e = document.getElementById("recent");
        var str = e.options[e.selectedIndex].value;

        document.getElementById('txt').value = str;
        }

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
                    }
                };
                xmlhttp.open("GET", "/functions/getName.php?q=" + str, true);
                xmlhttp.send();
            }
        }

        $(function() {
            $("#nav-placeholder").load("../navbar/navbar.php");
        });
    </script>
</html>