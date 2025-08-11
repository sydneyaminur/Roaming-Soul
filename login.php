<?php 
include('server.php'); 
if (isset($_SESSION['username'])) {
		header('location: index.php');
		exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - Roaming Soul</title>
	<link rel="stylesheet" href="style.css">
		<style>
			body.login-bg {
				background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
				min-height: 100vh;
				display: flex;
				align-items: flex-start;
				justify-content: center;
				font-family: 'Arial', sans-serif;
				padding-top: 60px;
			}
			.login-card {
				background: #fff;
				border-radius: 18px;
				box-shadow: 0 12px 32px -8px rgba(37,99,235,.18);
				padding: 2.2rem 1.7rem 1.7rem;
				max-width: 370px;
				width: 100%;
				text-align: center;
				position: relative;
				margin-top: 30px;
			}
			.login-logo {
				width: 70px;
				height: 70px;
				border-radius: 50%;
				margin-bottom: 1.2rem;
				box-shadow: 0 4px 18px -6px #2563eb44;
			}
			.login-title {
				font-size: 2rem;
				font-weight: bold;
				color: #2563eb;
				margin-bottom: .7rem;
				letter-spacing: .5px;
			}
			.login-desc {
				font-size: 1.05rem;
				color: #475569;
				margin-bottom: 1.5rem;
			}
			.login-form .input-group {
				margin-bottom: 1.7rem;
				text-align: left;
			}
			.login-form label {
				font-weight: 600;
				color: #334155;
				margin-bottom: .5rem;
				display: block;
				font-size: 1.08rem;
			}
			.login-form .input-row {
				display: flex;
				align-items: center;
				gap: .7rem;
			}
			.login-form .input-icon {
				color: #2563eb;
				font-size: 1.5rem;
				display: flex;
				align-items: center;
				justify-content: center;
				min-width: 28px;
			}
			.login-form input {
				flex: 1;
				font-size: 1.15rem;
				height: 52px;
				padding: 0 1rem;
				border-radius: 10px;
				border: 1px solid #cfd6dd;
				background: #f8fafc;
				transition: border-color .3s, background .3s;
				width: 100%;
				box-sizing: border-box;
			}
			.login-form input:focus {
				border-color: #2563eb;
				background: #fff;
				outline: none;
				box-shadow: 0 0 0 3px #2563eb33;
			}
			.login-form .btn {
				width: 100%;
				padding: .9rem 0;
				font-size: 1.1rem;
				font-weight: 600;
				background: linear-gradient(135deg, #2563eb, #1d4ed8);
				color: #fff;
				border: none;
				border-radius: 10px;
				box-shadow: 0 8px 18px -6px #2563eb55;
				cursor: pointer;
				transition: background .3s, box-shadow .3s;
			}
			.login-form .btn:hover {
				background: linear-gradient(135deg, #1d4ed8, #2563eb);
				box-shadow: 0 14px 32px -10px #2563eb55;
			}
			.login-form .alt-action {
				margin-top: 1.2rem;
				font-size: .95rem;
				color: #475569;
			}
			.login-form .alt-action a {
				color: #2563eb;
				font-weight: 600;
				text-decoration: none;
				margin-left: .3rem;
			}
			.error {
				margin-bottom: 1.1rem;
			}
		</style>
</head>

<body class="login-bg" style="position:relative; min-height:100vh; overflow:hidden;">
	   <video autoplay muted loop playsinline class="bg-video" style="position:fixed; inset:0; width:100vw; height:100vh; object-fit:cover; z-index:-2;">
		   <source src="essentials/background.mp4" type="video/mp4">
		   Your browser does not support the video tag.
	   </video>
	   <div class="bg-overlay" style="position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:-1;"></div>
	   <nav class="navbar" style="z-index:1002;">
		   <div class="logo">
			   <img src="essentials/Logo.png" alt="Roaming Soul Logo">
			   <span>Roaming Soul</span>
		   </div>
	   </nav>
	   <div style="position:fixed; top:0; left:0; width:100vw; height:100vh; display:flex; align-items:center; justify-content:center; z-index:1001; pointer-events:none;">
		   <div class="card" style="z-index:1001; pointer-events:auto;">
			   <div style="width:100%; display:flex; flex-direction:column; align-items:center; justify-content:center; padding-top:2.5rem; padding-bottom:1.2rem;">
				   <img src="essentials/Logo.png" alt="Roaming Soul Logo" style="width:70px; height:70px; border-radius:50%; margin-bottom:1.2rem; box-shadow:0 4px 18px -6px #2563eb44;">
				   <h2 class="login-title" style="margin-bottom:0;">Member Login</h2>
			   </div>
			   <form class="login-form" method="post" action="login.php">
				   <?php include('errors.php'); ?>
				   <div class="input-group">
					   <label for="username">Username</label>
					   <input type="text" id="username" name="username" required placeholder="Enter your username">
				   </div>
				   <div class="input-group">
					   <label for="password">Password</label>
					   <input type="password" id="password" name="password" required placeholder="Enter your password">
				   </div>
				   <button type="submit" class="btn" name="login_user">Login</button>
				   <div class="alt-action">
					   Not yet a member?
					   <a href="register.php" style="color:#2563eb; font-weight:600; text-decoration:none; margin-left:.3rem;">Sign up</a>
				   </div>
			   </form>
		   </div>
	   </div>
</body>
</html>