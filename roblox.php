<?php
$message = "";

// ===== background-image: url('<?php echo...'); =====
$bgPath = "C:/Users/karan/OneDrive/Pictures/GAME.jpg";
$bgImage = "";
background-size:cover;
if (file_exists($bgPath)) {
    $bgImage = "data:image/jpeg;base64," . base64_encode(file_get_contents($bgPath));
}

// ===== Database Connection =====
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = new mysqli("localhost", "root", "", "userdp");

    if ($conn->connect_error) {
        $message = "<div class='alert error'>Database Connection Failed: " .
                   htmlspecialchars($conn->connect_error) . "</div>";
    } else {

        $user = trim($_POST['username']);
        $pass = $_POST['password'];

        // Password hash
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");

        if ($stmt) {
            $stmt->bind_param("ss", $user, $hashed_password);

            if ($stmt->execute()) {
                $message = "<div class='alert success'>Data Successfully Saved!</div>";
            } else {
                $message = "<div class='alert error'>Insert Error: " .
                           htmlspecialchars($stmt->error) . "</div>";
            }

            $stmt->close();
        } else {
            $message = "<div class='alert error'>Prepare Failed: " .
                       htmlspecialchars($conn->error) . "</div>";
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ROCKSTART D.P</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;
    background:
        linear-gradient(rgba(0,0,0,.4),rgba(0,0,0,.4)),
        url('<?php echo $bgImage; ?>') no-repeat center center fixed;
    background-size:cover;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.login-card{
    background:rgba(31,31,46,.85);
    backdrop-filter:blur(5px);
    padding:35px;
    width:350px;
    border-radius:12px;
    color:#fff;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,.8);
}

.heading{
    font-size:24px;
    color:#ffeb3b;
    margin-bottom:25px;
    font-weight:bold;
}

.form-group{
    margin-bottom:18px;
    text-align:left;
}

.form-group label{
    display:block;
    margin-bottom:6px;
    color:#bfc5d2;
}

.form-group input{
    width:100%;
    padding:10px;
    border:none;
    border-radius:5px;
    background:#2f3542;
    color:white;
}

.btn-submit{
    width:100%;
    padding:11px;
    background:#ffeb3b;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-weight:bold;
}

.btn-submit:hover{
    background:#fbc02d;
}

.alert{
    padding:10px;
    border-radius:5px;
    margin-bottom:15px;
}

.success{
    background:#2ed573;
    color:white;
}

.error{
    background:#ff4757;
    color:white;
}
</style>
</head>

<body>

<div class="login-card">

    <div class="heading">ROCKSTART D.P</div>

    <?php echo $message; ?>

    <form method="POST">

        <div class="form-group">
            <label>Username or Email</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit" class="btn-submit">Submit</button>

    </form>

</div>

</body>
</html>
