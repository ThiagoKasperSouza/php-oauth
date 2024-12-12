<?php

session_start();
// Captura a URI da requisição
$requestUri = $_SERVER['REQUEST_URI'];

// Remove a parte da query string, se existir
$requestUri = strtok($requestUri, '?');

$page='login';


/**
 * ENV
 */
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



/**
 * BANCO DE DADOS
 */
function getConnection($host, $dbname, $user, $password) {
    $conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
    if (!$conn) {
        die("Error connecting to PostgreSQL: " . pg_last_error());
    }
    return $conn;
}


function fill_sidebar_items() {
    $conn =getConnection($_SESSION['host'], "meu_db", $_SESSION['user'], $_SESSION['pwd']);
    $result = pg_query($conn, "SELECT * FROM information_schema.tables
     WHERE table_schema = 'public'
     AND table_type = 'BASE TABLE';");
    // Verificar se a consulta foi executada com sucesso
    if (!$result) {
        echo "Erro ao executar a consulta: " . pg_last_error($conn);
        exit;
    }

    // Exibir os resultados
    while ($row = pg_fetch_assoc($result)) {
        echo '<li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-table" viewBox="0 0 16 16">
                <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm15 2h-4v3h4zm0 4h-4v3h4zm0 4h-4v3h3a1 1 0 0 0 1-1zm-5 3v-3H6v3zm-5 0v-3H1v2a1 1 0 0 0 1 1zm-4-4h4V8H1zm0-4h4V4H1zm5-3v3h4V4zm4 4H6v3h4z"/>
                </svg>
                <div style="padding: 0 0.5em">' .$row["table_name"].'</div>
            </button>
            <div class="collapse" id="orders-collapse" style="">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="?path='.$row["table_name"].'&content=new" class="link-body-emphasis d-inline-flex text-decoration-none rounded">New</a></li>
                    <li><a href="?path='.$row["table_name"].'&content=list" class="link-body-emphasis d-inline-flex text-decoration-none rounded">List</a></li>
                </ul>
            </div>';
        // echo $row['table_name'] . "<br>";
    }

    // Fechar a conexão
    pg_close($conn);
}

/**
 * BANCO DE DADOS
 */


/** 
* ROUTER
*/


switch ($requestUri) {

    case '/login':
        $page = 'login';
        break;
    case '/settings':
        $page = 'settings';
        break;
    case '/dashboard':
        $page = 'dashboard';
        break;
    default:
        $page = 'login'; // Página padrão em caso de erro
        break;
}
/** 
* ROUTER
*/


/**
 * OAUTH
 */


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


$metadata = http(getenv("METADATA_URI"));


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
    'redirect_uri' => getenv("REDIRECT_URI"),
    'client_id' => getenv("CLIENT_ID"),
    'client_secret' => getenv("CLIENT_SECRET"),
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
        $_SESSION['picture'] = $userinfo->picture; 
        header('Location: /settings');
    }
}


// Fluxo login
if(isset($_POST['form_button'])) {
    $_SESSION['state'] = bin2hex(random_bytes(5));
    $_SESSION['code_verifier'] = bin2hex(random_bytes(50));
    $code_challenge = base64_urlencode(hash('sha256', $_SESSION['code_verifier'], true));
  
    $authorize_url = $metadata->authorization_endpoint.'?'.http_build_query([
      'response_type' => 'code',
      'client_id' => getenv("CLIENT_ID"),
      'redirect_uri' => getenv("REDIRECT_URI"),
      'state' => $_SESSION['state'],
      'scope' => 'openid profile email',
      'code_challenge' => $code_challenge,
      'code_challenge_method' => 'S256',
    ]);
    
    header('Location: '.$authorize_url);
}

// Fluxo logout
if(isset($_POST['logout_button'])) {
    unset($_SESSION['name']);
    unset($_SESSION['email']);
    unset($_SESSION['sub']);
    unset($_SESSION['picture']);
    unset($_SESSION['host']);
    unset($_SESSION['user']);
    unset($_SESSION['pwd']);
    header('Location: /login');
}

// Fluxo pg
if(isset($_POST['form_connection'])) {
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $picture = $_SESSION['picture'];
    // Store connection details in session

    header('Location: /dashboard');
    $_SESSION['host'] = $_POST['hostInput'];
    $_SESSION['user'] = $_POST['userInput'];
    $_SESSION['pwd'] =  $_POST['pwdInput'];
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['picture'] = $picture;
   
} 

/**
 * OAUTH
 */

?>