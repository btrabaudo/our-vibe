<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<base href="<?php echo dirname($_SERVER["PHP_SELF"]) . "/"; ?>" />

		<title>our-vibe</title>
		<link href="dist/vendor.d4d3fd2f37378890a9e9.css" rel="stylesheet"><link href="dist/css.d4d3fd2f37378890a9e9.css" rel="stylesheet"><script type="text/javascript" src="dist/polyfills.d4d3fd2f37378890a9e9.js"></script><script type="text/javascript" src="dist/vendor.d4d3fd2f37378890a9e9.js"></script><script type="text/javascript" src="dist/app.d4d3fd2f37378890a9e9.js"></script><script type="text/javascript" src="dist/css.d4d3fd2f37378890a9e9.js"></script></head>
	<body>
		<!-- This custom tag much match your Angular @Component selector name in app/app.component.ts -->
		<our-vibe>Loading&hellip;</our-vibe>
	</body>
</html>