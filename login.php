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
				align-items: center; /* center vertically */
				justify-content: center;
				font-family: 'Arial', sans-serif;
				padding: 0; /* no extra padding; wrapper offsets navbar */
			}
			/* Remove legacy global form border/background around the login form */
			body.login-page form {
				border: none !important;
				background: transparent !important;
				margin: 0 !important;
				padding: 0 !important;
				border-radius: 0 !important;
				box-shadow: none !important;
			}
			.login-wrap { min-height: 100vh; display:flex; align-items:center; justify-content:center; padding: 96px 16px 24px; width:100%; }
			.login-card {
				background: #fff;
				border-radius: 18px;
				box-shadow: 0 12px 32px -8px rgba(37,99,235,.18);
				padding: 2rem 1.5rem 1.5rem;
				max-width: 370px;
				width: 100%;
				text-align: center;
				position: relative;
				margin: 0 auto;
				animation: popIn .45s ease-out both;
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
				font-size: 1.05rem;
				height: 48px;
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
				padding: .8rem 0;
				font-size: 1.05rem;
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
			/* Secondary/outlined button for Sign up */
			.login-form .btn-secondary {
				width: 100%;
				padding: .78rem 0;
				font-size: 1rem;
				font-weight: 600;
				background: #ffffff;
				color: #1d4ed8;
				border: 2px solid #1d4ed8;
				border-radius: 10px;
				box-shadow: 0 2px 8px -4px rgba(0,0,0,0.15);
				cursor: pointer;
				transition: background .25s, color .25s, box-shadow .25s, transform .2s;
				text-decoration: none;
				display: inline-block;
			}
			.login-form .btn-secondary:hover {
				background: #eef2ff;
				box-shadow: 0 8px 18px -8px rgba(29,78,216,0.45);
				transform: translateY(-1px);
			}
			.login-form .alt-action {
				display:none; /* replaced by signup button */
			}
			/* Simple entrance sequence */
			.appear { opacity: 0; transform: translateY(14px); animation: fadeUp .55s ease forwards; }
			@keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
			@keyframes popIn { 0% { opacity: 0; transform: scale(.96); } 100% { opacity: 1; transform: scale(1); } }
			.error {
				margin-bottom: 1.1rem;
			}
			/* Responsive tweaks */
			@media (max-width: 480px) {
				.login-wrap { padding: 86px 14px 20px; }
				.login-card { max-width: 360px; border-radius: 14px; padding: 1.6rem 1.2rem 1.2rem; }
				.login-title { font-size: 1.7rem; }
				.login-logo { width: 64px; height: 64px; }
				.login-form input { height: 46px; font-size: 1rem; }
			}
		</style>
</head>

<body class="login-bg login-page" style="position:relative; min-height:100vh; overflow:hidden;">
	   <video autoplay muted loop playsinline class="bg-video" style="position:fixed; inset:0; width:100vw; height:100vh; object-fit:cover; z-index:-2;">
		   <source src="essentials/background.mp4" type="video/mp4">
		   Your browser does not support the video tag.
	   </video>
	   <div class="bg-overlay" style="position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:-1;"></div>
	   <nav class="navbar">
  <a href="index.php" class="logo" aria-label="Roaming Soul Home" style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:.4rem;">
    <img src="essentials/Logo.png" alt="Roaming Soul Logo" />
    <span class="logo-text">Roaming Soul</span>
  </a>
  <ul class="nav-menu">
    <li><a href="index.php#home" class="nav-link">Home</a></li>
    <li><a href="index.php#adventures" class="nav-link">Adventures</a></li>
    <li><a href="index.php#contact" class="nav-link">Contact</a></li>
  </ul>
</nav>
	   <div class="login-wrap" style="min-height:100vh; display:flex; align-items:center; justify-content:center; padding:84px 16px 24px; z-index:1001; position:relative;">
		   <div class="login-card" style="z-index:1001;">
				   <div style="width:100%; display:flex; flex-direction:column; align-items:center; justify-content:center; padding-top:2.2rem; padding-bottom:1.1rem;">
					   <img src="essentials/Logo.png" alt="Roaming Soul Logo" class="login-logo appear" style="animation-delay:.05s;">
					   <h2 class="login-title appear" style="margin-bottom:0; animation-delay:.35s;">User Login</h2>
				   </div>
				   <form class="login-form" method="post" action="login.php">
					   <?php include('errors.php'); ?>
					   <div class="input-group appear" style="animation-delay:.7s;">
						   <label for="username">Username</label>
						   <input type="text" id="username" name="username" required placeholder="Enter your username">
					   </div>
					   <div class="input-group appear" style="animation-delay:.85s;">
						   <label for="password">Password</label>
						   <input type="password" id="password" name="password" required placeholder="Enter your password">
					   </div>
					   <button type="submit" class="btn appear" style="animation-delay:1s;" name="login_user">Login</button>
					   <a href="register.php" class="btn-secondary appear" style="margin-top:.9rem; animation-delay:1.15s;">Sign up</a>
				   </form>
			   </div>
		   </div>
</body>
</html>