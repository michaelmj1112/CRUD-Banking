<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="link" action="dualstream/index.html">
        <input  id="txt" name="stream1" placeholder="" required="required" autofocus="autofocus" />
        <select id="mySelect" onchange="selectionchange();">
            <option value="abc" >abc</option>
            <option value="xyz" >xyz</option>
        </select>
        <input type="submit" class="button" value="Click to watch the stream" />
    </form>
</body>

<script>
    function selectionchange() {
    var e = document.getElementById("mySelect");
    var str = e.options[e.selectedIndex].value;

    document.getElementById('txt').value = str;
    }
</script>
</html>