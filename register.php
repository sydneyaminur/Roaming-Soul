<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register - Roaming Soul</title>
	<link rel="stylesheet" href="style.css">
	<style>
		body.register-bg {
			min-height: 100vh;
			display: flex;
			align-items: center; /* center like login */
			justify-content: center;
			font-family: 'Arial', sans-serif;
			position: relative;
			overflow-y: auto; /* allow page scroll */
			padding: 0; /* wrapper offsets navbar */
		}
	.register-wrap { min-height:100vh; width:100%; display:flex; align-items:center; justify-content:center; padding: 96px 16px 24px; position:relative; z-index:1001; }
		.register-card {
			background: #fff;
			border-radius: 18px;
			box-shadow: 0 12px 32px -8px rgba(37,99,235,.18);
			padding: 2rem 1.5rem 1.5rem;
			max-width: 520px;
			width: 100%;
			text-align: center;
			position: relative;
			z-index: 1001;
			margin: 0 auto;
		}
		.register-logo {
			width: 70px;
			height: 70px;
			border-radius: 50%;
			margin-bottom: 1.2rem;
			box-shadow: 0 4px 18px -6px #2563eb44;
		}
		.register-title {
			font-size: 2rem;
			font-weight: bold;
			color: #2563eb;
			margin-bottom: .7rem;
			letter-spacing: .5px;
		}
		.register-desc {
			font-size: 1.05rem;
			color: #475569;
			margin-bottom: 1.5rem;
		}
		.register-form .input-group {
			margin-bottom: 1.2rem;
			text-align: left;
		}
		.register-form label {
			font-weight: 600;
			color: #334155;
			margin-bottom: .3rem;
			display: block;
		}
		.register-form input {
			width: 100%;
			padding: .85rem 1rem;
			border-radius: 10px;
			border: 1px solid #cfd6dd;
			font-size: 1rem;
			background: #f8fafc;
			transition: border-color .3s, background .3s;
		}
		.register-form input:focus {
			border-color: #2563eb;
			background: #fff;
			outline: none;
			box-shadow: 0 0 0 3px #2563eb33;
		}
		.register-form .btn {
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
		.register-form .btn:hover {
			background: linear-gradient(135deg, #1d4ed8, #2563eb);
			box-shadow: 0 14px 32px -10px #2563eb55;
		}
		.register-form .alt-action {
			margin-top: 1.2rem;
			font-size: .95rem;
			color: #475569;
		}
		.register-form .alt-action a {
			color: #2563eb;
			font-weight: 600;
			text-decoration: none;
			margin-left: .3rem;
		}
		.error { margin-bottom: 1.1rem; }
		/* Remove legacy global form border/background on this page */
		body.register-page form { border:none !important; background:transparent !important; margin:0 !important; padding:0 !important; border-radius:0 !important; box-shadow:none !important; }
		/* Responsive */
		/* Short screens: top align and tighter spacing */
		@media (max-height: 740px){
			.register-wrap { align-items: flex-start; padding-top: 84px; }
			.register-card { padding: 1.6rem 1.2rem 1.2rem; }
			.register-form .input-group { margin-bottom: .9rem; }
		}
		@media (max-width: 480px){
			.register-card { max-width: 360px; border-radius: 14px; padding: 1.6rem 1.2rem 1.2rem; }
			.register-title { font-size: 1.7rem; }
			.register-logo { width: 64px; height: 64px; }
			.register-form .input-group { margin-bottom: 1rem; }
		}
	</style>
</head>
<body class="register-bg register-page">
	<video autoplay muted loop playsinline style="position:fixed; inset:0; width:100vw; height:100vh; object-fit:cover; z-index:-2;">
		<source src="essentials/background.mp4" type="video/mp4">
		Your browser does not support the video tag.
	</video>
	<div style="position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:-1;"></div>
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
	<div class="register-wrap">
		<div class="register-card">
		<img src="essentials/Logo.png" alt="Roaming Soul Logo" class="register-logo">
		<div class="register-title">Create Account</div>
		<div class="register-desc">Join Roaming Soul and start your next adventure!</div>
		<form class="register-form" method="post" action="register.php">
			<?php include('errors.php'); ?>
			<div class="input-group">
				<label for="username">Username</label>
				<div style="background:#f8fafc; border-radius:10px; box-shadow:0 2px 8px -6px #2563eb22; padding:0.2rem 0.5rem;">
					<input type="text" id="username" name="username" value="<?php echo $username; ?>" required placeholder="Enter your username">
				</div>
			</div>
			<div class="input-group">
				<label for="email">Email</label>
				<div style="background:#f8fafc; border-radius:10px; box-shadow:0 2px 8px -6px #2563eb22; padding:0.2rem 0.5rem;">
					<input type="email" id="email" name="email" value="<?php echo $email; ?>" required placeholder="Enter your email">
				</div>
			</div>
			<div class="input-group">
				<label for="password_1">Password</label>
				<div style="background:#f8fafc; border-radius:10px; box-shadow:0 2px 8px -6px #2563eb22; padding:0.2rem 0.5rem;">
					<input type="password" id="password_1" name="password_1" required placeholder="Create a password">
				</div>
			</div>
			<div class="input-group">
				<label for="password_2">Confirm Password</label>
				<div style="background:#f8fafc; border-radius:10px; box-shadow:0 2px 8px -6px #2563eb22; padding:0.2rem 0.5rem;">
					<input type="password" id="password_2" name="password_2" required placeholder="Confirm your password">
				</div>
			</div>
			<button type="submit" class="btn" name="reg_user">Register</button>
			<div class="alt-action">
				Already a member?<a href="login.php">Sign in</a>
			</div>
		</form>
		</div>
	</div>
</body>
</html>