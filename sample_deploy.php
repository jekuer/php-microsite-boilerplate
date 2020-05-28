<?php

	/**
	 * GitHub Deployment Script Sample
	 */

	$postHeaders = getallheaders();
  $checkPostBody = file_get_contents('php://input');
	$checkSum = 'sha1=' . hash_hmac('sha1', $checkPostBody, '123ABC456DEF789');
	$output = '';

  if (isset($postHeaders['X-Hub-Signature']) and $checkSum == $postHeaders['X-Hub-Signature']) {

		// The commands
		$commands = array(
			'git checkout master',
			'git fetch --all',
			'git reset --hard origin/master',
			'git pull',
			'git status',
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