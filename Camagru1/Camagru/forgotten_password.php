<!DOCTYPE html>
    <html>
        <head>
        <meta charset="utf-8">
        <meta name="description" content="this is an example">
        <meta name=viewpoint content="width=device-width, initial-scale=1">
        <title>Reset Password</title>
        <link rel="stylesheet" href="style.css">
        </head>
        <body>
        <h1 font-weight:"900"; align="center" style="color:white"><font size="150">Reset Password</font></h1>
        <header>
            </header>
            <h1 font-weight:"900"; align="center" style="color:white"><font size="150">Please enter your email...</font></h1>
            <div class="c1">
            <form action="includes/forgotten_password.inc.php" method="post">
                <input style="border-radius:10px; height:40px; width:150px" type="text" name="email" placeholder="email">
                <br>
                <a href="reset_password.php"><button style="height:40px; width:150px" type="submit" name="send-mail">Send email</button></a>
            </form>
            <br>
                    </div>
                        <form action="header.php" method="post">
                            <button style="height:40px; width:150px" type="submit" name="back">Home</button>
                            </form>
            </body>
    </html>