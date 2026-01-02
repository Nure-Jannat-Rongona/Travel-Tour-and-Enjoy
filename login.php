<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Travel System</title>
    <link rel="stylesheet" href="style.css/decor.css">
</head>
<body>

<div class="container">
    <h2>Travel Tour Enjoy</h2>
    <p>Please log in to continue</p>

    <form method="POST" action="login_process.php">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login ✨</button>
    </form>

    <p style="margin-top:15px; font-size:13px; color:#555;">
        Don't have an account? <a href="register.php">Sign up</a>
    </p>
</div>

</body>
</html>
