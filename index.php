<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>LOGIN</title>
        <link rel="stylesheet" href="CSS/login.css">
    </head> 
    <body>
        <div class="main">
            <div class="login_top">
                <div class="word1"><h1 style="color:rgb(255, 255, 255); font-size:27px">ระบบตรวจสอบผลการทดสอบภาษาอังกฤษ</h1></div>

            </div>
            <div class="login_body">
                <form method="POST" action="logon.php">
                    <input type="text" name="tUser" placeholder="username" class="user-username">
                    <input type="password" name="tPass" placeholder="password" class="user-password">
                    <input type="submit" value="Login" class="button_box">
                </form>
            </div>
        </div>
    </body>

</html> 