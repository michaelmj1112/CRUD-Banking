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
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/process.php'; ?>

        <?php
            $mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking') 
                or die(mysqli_error($mysqli));
            $result = $mysqli->query("SELECT * FROM transactions")
                or die($mysqli->error);
        ?>

        <div id="nav-placeholder"></div>

        <div class="container">
            <div class="form-group">
                <span class="input-group-addon">Search</span>
                <input type="text" name="search_text" class="form-control" onkeyup="getHistory(this.value)">
            </div>
            <div id="history">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Transaction</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['date_created']; ?></td>
                            <td><?php echo $row['remarks']; ?></td>
                            <td><?php echo $row['amount']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
            <!-- <p><span id="history"></span></p> -->
        </div>
    </body>

    <script>
        function getHistory(str) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("history").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "/functions/search.php?q=" + str, true);
            xmlhttp.send();
        }

        function go2Page() {
            var page = document.getElementById("page").value;
            page = ((page><?php echo $totalPages; ?>) ? <?php echo $totalPages; ?> : ((page < 1) ? 1:page));
            window.location.href = 'history.php?page='+page;
        }

        $(function() {
            $("#nav-placeholder").load("/client/navbar/navbar.php");
        });
    </script>
</html>