<html>
    <head>
        <title>New Password</title>
        <link rel="stylesheet" href="style.css">
        <style>
            body
            {
                background-image: url("https://www.creativefabrica.com/wp-content/uploads/2019/02/Monogram-DB-Logo-by-Greenlines-Studios.jpg");;
            }
        </style>
    </head>

    <main>
        <div>
            <section>
                <h1 font-weight:"900"; align="center" style="color:white"><font size="50">Create New Password</font></h1>
                <div class="form">
                    <form action="includes/forgotten_password.inc.php" method="post">
                    <input style="height:40px; width:150px" type="text" name="email" placeholder="Email">
                    <br>
                        <input style="height:40px; width:150px" type="password" name="pwd" placeholder="Password" minlength="8">
                            <br>
                        <input style="height:40px; width:150px" type="password" name="pwd-repeat" placeholder="Confirm password">
                            <br>
                        <button border-radius:"10px" style="height:40px; width:150px" type="submit" name="reset-submit">Change Password</button>
                    </form>
                </div>
                <a href="header.php"><button style="height:20px; width:75px">Home</button></a>
            </section>
            </div>
    </main>
    </html>