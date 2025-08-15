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
		.register-form .input-group { margin-bottom: 1.2rem; text-align: left; }
		.register-form label { font-weight: 600; color: #334155; margin-bottom: .5rem; display: block; font-size: 1.08rem; }
		.register-form input {
			width: 100%;
			height: 48px;
			padding: 0 1rem;
			border-radius: 10px;
			border: 1px solid #cfd6dd;
			font-size: 1.05rem;
			background: #f8fafc;
			transition: border-color .3s, background .3s;
			box-sizing: border-box;
		}
		.register-form input:focus { border-color: #2563eb; background: #fff; outline: none; box-shadow: 0 0 0 3px #2563eb33; }
		.register-form .btn { width: 100%; padding: .8rem 0; font-size: 1.05rem; font-weight: 600; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; border: none; border-radius: 10px; box-shadow: 0 8px 18px -6px #2563eb55; cursor: pointer; transition: background .3s, box-shadow .3s; }
		.register-form .btn:hover {
			background: linear-gradient(135deg, #1d4ed8, #2563eb);
			box-shadow: 0 14px 32px -10px #2563eb55;
		}
		/* Secondary/outlined button like login page */
		.register-form .btn-secondary { width:100%; padding:.78rem 0; font-size:1rem; font-weight:600; background:#ffffff; color:#1d4ed8; border:2px solid #1d4ed8; border-radius:10px; box-shadow:0 2px 8px -4px rgba(0,0,0,0.15); cursor:pointer; transition: background .25s, color .25s, box-shadow .25s, transform .2s; text-decoration:none; display:inline-block; }
		.register-form .btn-secondary:hover { background:#eef2ff; box-shadow:0 8px 18px -8px rgba(29,78,216,0.45); transform: translateY(-1px); }
		.register-form .alt-action { display:none; }
		.error { margin-bottom: 1.1rem; }
		/* Show field errors under inputs in red; hide legacy aggregate box */
		.register-card .field-error { display:block; color:#b91c1c; font-size:.9rem; margin-top:.4rem; line-height:1.25; }
		.register-card .error { display:none !important; }
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
		<script>window.__serverErrors = <?php echo json_encode($fieldErrors ?? [], JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT); ?>;</script>
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
	<form class="register-form" method="post" action="register.php" novalidate>
						<div class="input-group">
								<label for="username">Username</label>
								<input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username ?? '', ENT_QUOTES); ?>" required placeholder="Enter your username" pattern=".*[A-Za-z].*[A-Za-z].*[A-Za-z].*" title="Name must contain at least 3 letters">
								<?php if (!empty($fieldErrors['username'])): ?>
									<div class="field-error" aria-live="polite"><?php echo htmlspecialchars(implode("\n", $fieldErrors['username'])); ?></div>
								<?php else: ?>
									<div class="field-error" aria-live="polite"></div>
								<?php endif; ?>
						</div>
						<div class="input-group">
								<label for="email">Email</label>
								<input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? '', ENT_QUOTES); ?>" required placeholder="Enter your email" title="Enter a valid email like user@domain.com">
								<?php if (!empty($fieldErrors['email'])): ?>
									<div class="field-error" aria-live="polite"><?php echo htmlspecialchars(implode("\n", $fieldErrors['email'])); ?></div>
								<?php else: ?>
									<div class="field-error" aria-live="polite"></div>
								<?php endif; ?>
						</div>
						<div class="input-group">
								<label for="password_1">Password</label>
								<input type="password" id="password_1" name="password_1" required placeholder="Create a password" pattern="(?=.{7,})(?=.*[A-Z])(?=.*\d)(?=.*[\.,+\-]).*" title="Password must be ≥ 7 chars, include an uppercase letter, a number, and one of . , + -">
								<?php if (!empty($fieldErrors['password_1'])): ?>
									<div class="field-error" aria-live="polite"><?php echo htmlspecialchars(implode("\n", $fieldErrors['password_1'])); ?></div>
								<?php else: ?>
									<div class="field-error" aria-live="polite"></div>
								<?php endif; ?>
						</div>
						<div class="input-group">
								<label for="password_2">Confirm Password</label>
								<input type="password" id="password_2" name="password_2" required placeholder="Confirm your password">
								<?php if (!empty($fieldErrors['password_2'])): ?>
									<div class="field-error" aria-live="polite"><?php echo htmlspecialchars(implode("\n", $fieldErrors['password_2'])); ?></div>
								<?php else: ?>
									<div class="field-error" aria-live="polite"></div>
								<?php endif; ?>
						</div>
			<button type="submit" class="btn" name="reg_user">Register</button>
	    <a href="login.php" class="btn-secondary" style="margin-top:.9rem;">Sign in</a>
		</form>
		</div>
	</div>
		<script>
// Minimal client-side inline validation for register
(function(){
	const form = document.querySelector('.register-form');
	if(!form) return;
		const showToast = ()=>{}; // disabled (using under-field errors instead)
	const u = form.querySelector('#username');
	const e = form.querySelector('#email');
	const p1 = form.querySelector('#password_1');
	const p2 = form.querySelector('#password_2');
	const setErr = (input, msg) => {
		const box = input.closest('.input-group').querySelector('.field-error');
		if (msg) {
			box.textContent = msg;
			input.classList.add('input-error');
		} else {
			box.textContent = '';
			input.classList.remove('input-error');
		}
	};
	const has3Letters = (str) => (str.match(/[A-Za-z]/g) || []).length >= 3;
	const validateU = () => {
		const v = (u.value || '').trim();
		if (!v) return setErr(u, 'Username is required');
		if (!has3Letters(v)) return setErr(u, 'Name must contain at least 3 letters');
		setErr(u, '');
	};
	const validateE = () => {
		const v = (e.value || '').trim();
		if (!v) return setErr(e, 'Email is required');
		const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
		if (!ok) return setErr(e, 'Enter a valid email address (e.g., user@domain.com)');
		setErr(e, '');
	};
	const validateP1 = () => {
		const v = p1.value || '';
		if (!v) return setErr(p1, 'Password is required');
		const okLen = v.length >= 7;
		const okUp = /[A-Z]/.test(v);
		const okNum = /\d/.test(v);
		const okSp = /[\.,+\-]/.test(v);
		if (!(okLen && okUp && okNum && okSp)) {
			return setErr(p1, 'Password must be ≥ 7 chars and include an uppercase letter, a number, and one of . , + -');
		}
		setErr(p1, '');
	};
	const validateP2 = () => {
		const v = p2.value || '';
		if (!v) return setErr(p2, 'Please confirm your password');
		if (v !== (p1.value || '')) return setErr(p2, 'The two passwords do not match');
		setErr(p2, '');
	};
	[u,e,p1,p2].forEach(inp => inp.addEventListener('blur', () => {
		switch(inp){
			case u: return validateU();
			case e: return validateE();
			case p1: return validateP1();
			case p2: return validateP2();
		}
	}));
		// no blur toasts; show under-field errors only
	// Live validation while typing
	u.addEventListener('input', validateU);
	e.addEventListener('input', validateE);
	p1.addEventListener('input', () => { validateP1(); if(p2.value) validateP2(); });
	p2.addEventListener('input', validateP2);
	form.addEventListener('submit', (ev) => {
		validateU(); validateE(); validateP1(); validateP2();
			if (form.querySelector('.input-error')) {
				ev.preventDefault();
				const msgs = Array.from(form.querySelectorAll('.field-error'))
					.map(n => (n.textContent || '').trim())
					.filter(Boolean);
				// rely on under-field errors only
			}
	});
		// If server-side errors are present under fields, show a toast on page load
				// no toasts on load; under-field errors already present
})();
	</script>
</body>
</html>