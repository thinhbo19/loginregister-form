<?php
session_start();

$servername = "localhost";
$database = "login_register";
$username = "root";
$password = "";
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["login"])) {
    // Xử lý đăng nhập
    $Email = $_POST["email"];
    $Password = $_POST["password"];

    $query = "SELECT * FROM users WHERE email = '$Email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
      $user = mysqli_fetch_assoc($result);
      if (password_verify($Password, $user['password'])) {
        // Mật khẩu hợp lệ, đăng nhập thành công
        $_SESSION['user_id'] = $user['ID'];
        // echo "Đăng nhập thành công!";
        // header("Location: dashboard.php");
      } else {
        echo "Mật khẩu không đúng. Vui lòng thử lại.";
      }
    } else {
      echo "Tài khoản không tồn tại. Vui lòng đăng ký trước.";
    }
  } elseif (isset($_POST["signup"])) {
    // Xử lý đăng ký
    $Username = $_POST["username"];
    $Email = $_POST["email"];
    $Password = $_POST["password"];

    $query = "SELECT * FROM users WHERE email = '$Email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
      // Email đã tồn tại trong cơ sở dữ liệu
      echo "Email đã được sử dụng. Vui lòng chọn email khác.";
    } else {
      // Thêm thông tin người dùng vào cơ sở dữ liệu
      $hashedPassword = password_hash($Password, PASSWORD_DEFAULT); // Hash password để lưu vào cơ sở dữ liệu
      $insertQuery = "INSERT INTO users (username, email, password) VALUES ('$Username', '$Email', '$hashedPassword')";

      if (mysqli_query($conn, $insertQuery)) {
        // echo "Đăng ký thành công!";
        // header("Location: login.php");
      } else {
        echo "Đã xảy ra lỗi khi thực hiện đăng ký: " . mysqli_error($conn);
      }
    }
  }
}

// Xử lý yêu cầu đặt lại mật khẩu
if (isset($_POST["forgot_password"])) {
  $ForgotEmail = $_POST["forgot_email"];

  $query = "SELECT * FROM users WHERE email = '$ForgotEmail'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    // Tìm thấy email trong cơ sở dữ liệu, gửi email đặt lại mật khẩu ở đây nếu muốn
    echo "Chúng tôi đã gửi một email đặt lại mật khẩu cho bạn.";
  } else {
    echo "Email không tồn tại trong hệ thống. Vui lòng kiểm tra lại.";
  }
}


mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="./login.css" />
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>

<body>

  <?php
  if (isset($_SESSION['user_id'])) {
    // header("Location: dashboard.php");
  }
  ?>

  <header>
    <div class="logo">
      <h1>THINH.</h1>
    </div>
    <nav class="navbar">
      <ul>
        <a href="#">HOME</a>
        <a href="#">ABOUT</a>
        <a href="#">SERVICES</a>
        <a href="#">CONTACTS</a>
        <button class="btnLogin-popup">Login</button>
      </ul>
    </nav>
  </header>

  <div class="wrapper">
    <span class="icon-close">
      <ion-icon name="close-outline"></ion-icon>
    </span>

    <div class="form-box login">
      <h2>LOGIN</h2>
      <form method="post" action="login.php">
        <div class="input-box">
          <span class="icon">
            <ion-icon name="mail"></ion-icon>
          </span>
          <input type="email" name="email" required />
          <label>Email</label>
        </div>

        <div class="input-box">
          <span class="icon">
            <ion-icon name="lock-closed"></ion-icon>
          </span>
          <input type="password" name="password" required />
          <label>Password</label>
        </div>

        <div class="remember-forgot">
          <label><input type="checkbox" />Remember me</label>
          <a class="forgot-pass" href="#">Forgot password?</a>
        </div>
        <button type="submit" name="login" class="btn">Login</button>
        <div class="login-register">
          <p>
            Don't have an account?<a href="#" class="register-link">Register</a>
          </p>
        </div>
      </form>
    </div>

    <!-- Form đăng ký -->
    <div class="form-box register">
      <h2>SIGN UP</h2>
      <form method="post" action="login.php">
        <div class="input-box">
          <span class="icon">
            <ion-icon name="person"></ion-icon>
          </span>
          <input type="text" name="username" required />
          <label>Username</label>
        </div>
        <div class="input-box">
          <span class="icon">
            <ion-icon name="mail"></ion-icon>
          </span>
          <input type="email" name="email" required />
          <label>Email</label>
        </div>

        <div class="input-box">
          <span class="icon">
            <ion-icon name="lock-closed"></ion-icon>
          </span>
          <input type="password" name="password" required />
          <label>Password</label>
        </div>

        <div class="remember-forgot">
          <label><input type="checkbox" /> I agree to the terms & conditions</label>
        </div>
        <button type="submit" name="signup" class="btn">Sign Up</button>
        <div class="login-register">
          <p>
            Already have an account?<a href="#" class="login-link">Login</a>
          </p>
        </div>
      </form>
    </div>

    <!-- Form quên mật khẩu -->
    <div class="form-box forgot-password-form">
      <h2>QUÊN MẬT KHẨU</h2>
      <form method="post" action="login.php">
        <div class="input-box">
          <span class="icon">
            <ion-icon name="mail"></ion-icon>
          </span>
          <input type="email" name="forgot_email" required />
          <label>Email</label>
        </div>
        <button type="submit" name="forgot_password" class="btn">Đặt lại mật khẩu</button>
        <div class="login-register">
          <a href="#" class="login-link-back">Back</a>
        </div>
      </form>
    </div>
</body>
</div>

<script src="./login.js"></script>
</body>

</html>