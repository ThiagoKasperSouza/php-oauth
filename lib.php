<?php

session_start();

// Captura a URI da requisição
$requestUri = $_SERVER['REQUEST_URI'];

// Remove a parte da query string, se existir
$requestUri = strtok($requestUri, '?');

$page='login';




function load($path): void
{
    $lines = file($path . '/.env');
    foreach ($lines as $line) {
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        putenv(sprintf('%s=%s', $key, $value));
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}
load(__DIR__);



// ROUTER
switch ($requestUri) {

    case '/login':
        $page = 'login';
        break;

    case '/home':
        $page = 'home'; // Página inicial
        break;

    default:
        $page = 'login'; // Página padrão em caso de erro
        break;
}

$metadata = http($metadata_url);


// fluxo pos login (tem code, pode pegar infos)
if(isset($_GET['code'])) {

    if($_SESSION['state'] != $_GET['state']) {
    die('Authorization server returned an invalid state parameter');
    }
    if(isset($_GET['error'])) {
    die('Authorization server returned an error: '.htmlspecialchars($_GET['error']));
    }

    $response = http($metadata->token_endpoint, [
    'grant_type' => 'authorization_code',
    'code' => $_GET['code'],
    'redirect_uri' => $redirect_uri,
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'code_verifier' => $_SESSION['code_verifier'],

    ]);

    if(!isset($response->access_token)) die('Error fetching access token');

    $userinfo = http('https://www.googleapis.com/oauth2/v3/userinfo', [
    'access_token' => $response->access_token,
    ]);
    if($userinfo->sub) {
        $_SESSION['sub'] = $userinfo->sub;
        $_SESSION['email'] = $userinfo->email; 
        $_SESSION['name'] = $userinfo->name; 
        $_SESSION['profile'] = $userinfo;
        header('Location: /home');
    }
}

// Fluxo login
if(isset($_POST['form_button'])) {
    $_SESSION['state'] = bin2hex(random_bytes(5));
    $_SESSION['code_verifier'] = bin2hex(random_bytes(50));
    $code_challenge = base64_urlencode(hash('sha256', $_SESSION['code_verifier'], true));
  
    $authorize_url = $metadata->authorization_endpoint.'?'.http_build_query([
      'response_type' => 'code',
      'client_id' => $client_id,
      'redirect_uri' => $redirect_uri,
      'state' => $_SESSION['state'],
      'scope' => 'openid profile email',
      'code_challenge' => $code_challenge,
      'code_challenge_method' => 'S256',
    ]);
    
    header('Location: '.$authorize_url);
}

// Fluxo logout
if(isset($_POST['logout_button'])) {
    unset($_SESSION['username']);
    unset($_SESSION['sub']);
    header('Location: /');
  }
  

function base64_urlencode($string) {
  return rtrim(strtr(base64_encode($string), '+/', '-_'), '=');
}


function http($url, $params=false) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  if($params)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
  return json_decode(curl_exec($ch));

}
?>