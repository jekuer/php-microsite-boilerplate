<?php

	/**
	 * GitHub Deployment Script Sample
	 */

	$postHeaders = getallheaders();
  $checkPostBody = file_get_contents('php://input');
	$secret = '123ABC456DEF789'; // change this to match the secret you set e.g. on GitHub (mind to not add this file afterwards to your repo!)
	$checkSum = 'sha1=' . hash_hmac('sha1', $checkPostBody, $secret);
	$output = '';

  if (isset($postHeaders['X-Hub-Signature']) and $checkSum == $postHeaders['X-Hub-Signature']) {

		// The commands
		$commands = array(
			'git checkout master',
			'git fetch --all',
			'git reset --hard origin/master',
			'git pull',
			'git status',
			'npm install', // remove if you do not want to minify the css and js on the server
			'npm run build' // remove if you do not want to minify the css and js on the server
		);

		// Run the commands for output		
		foreach($commands as $command){
			$tmp = shell_exec($command);
			$output .= "\${$command}\n";
			$output .= htmlentities(trim($tmp)) . "\n";
		}

	}

?>


<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Updating Git</title>
</head>
<body style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 10px;">
<pre>
<?php echo $output; // Remove this for more security. Still, since we check for the secret above, no strong need. ?>
</pre>
</body>
</html>