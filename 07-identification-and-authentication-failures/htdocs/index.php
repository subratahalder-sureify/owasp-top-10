<!DOCTYPE html>
<?php define('USE_CAPTCHA', '1'); ?>
<html>
    <header>
        <?php if (USE_CAPTCHA == "2") { ?>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js?render=6LdfxDYhAAAAADdBKg8IT0kHcepfaTSQCiY8piY0"></script>
        <?php } ?>
    </header>
    <body>
        <?php if (isset($_GET["fail"]) && $_GET["fail"] == "1") { ?>
        <div>Captcha Failed</div>
        <?php } else if (isset($_GET["fail"]) && $_GET["fail"] == "2") { ?>
        <div>Login Failed</div>
        <?php } ?>
        <form id="loginForm" method="POST" action="login<?= USE_CAPTCHA ?>.php">
            <div>
                <label>Username: </label>
                <input type="text" name="username" />
            </div>
            <div>
                <label>Password: </label>
                <input type="password" name="password" />
            </div>
            <div>
                <input type="submit" value="Login">
            </div>
        </form>
        <?php if (USE_CAPTCHA == "2") { ?>
        <script>
        $('#loginForm').submit(function(event) {
            event.preventDefault();

            grecaptcha.ready(function() {
                grecaptcha.execute('6LdfxDYhAAAAADdBKg8IT0kHcepfaTSQCiY8piY0', {action: 'login'}).then(function(token) {
                    $('#loginForm').prepend('<input type="hidden" name="token" value="' + token + '">');
                    $('#loginForm').prepend('<input type="hidden" name="action" value="login">');
                    $('#loginForm').unbind('submit').submit();
                });;
            });
        });
        </script>
        <?php } ?>
    </body>
</html>
