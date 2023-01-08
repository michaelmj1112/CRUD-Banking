<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
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

        <div class="container">
            <div class="row justify-content-center">
                <form action="../process.php" method="POST">
                    <h2>Deposit</h2>
                    <div class="form-group">
                        <input type="hidden" name="isAdmin" value="1">
                        <label>Account number</label>
                        <input type="text" name="from" class="form-control" onkeyup="showNameBalance(this.value)">
                        <label><em>Name</em></label>
                        <p><strong><span id="accName"></span></strong></p>
                        <label><em>Balance</em></label>
                        <p><strong><span id="accBal"></span></strong></p>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="text" name="amount" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="deposit">Continue</button>
                        <!-- <a href="../home.php">Back</a> -->
                    </div>
                </form>
            </div>
        </div>
    </body>
    <script>
        function showBalance(str) {
            if (str.length == 0) {
                document.getElementById("accBal").innerHTML = "";
                return;
            }
            else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("accBal").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "../../functions/getBalance.php?q=" + str, true);
                xmlhttp.send();
            }
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
                        document.getElementById("accBal").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "../../functions/getName.php?q=" + str, true);
                xmlhttp.send();
            }
        }

        function showNameBalance(str) {
            showName(str);
            showBalance(str);
        }

        $(function() {
            $("#nav-placeholder").load("../navbar/navbar.php");
        });
    </script>
</html>