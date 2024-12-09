<?php

// Captura a URI da requisição
$requestUri = $_SERVER['REQUEST_URI'];

// Remove a parte da query string, se existir
$requestUri = strtok($requestUri, '?');


// Define a página padrão
$page = 'home';


// Verifica se a URI corresponde a uma página específica

switch ($requestUri) {

    case '/teste':

        $page = 'teste';
        break;

    case '/':

        $page = 'home'; // Página inicial
        break;

    default:

        $page = 'home'; // Página padrão em caso de erro

}


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

function oauthSignIn() {
    $oauth2Endpoint =getenv("LINK");

    $params = [
        'client_id' => getenv('T_CID'),
        'redirect_uri' => getenv('DEV_RU'),
        'response_type' => 'token',
        'scope' => getenv('M_SCOPE'),
        'include_granted_scopes' => getenv('GSCOPE'),
        'state' => getenv('STATE')
    ];
    // // Construir a URL com os parâmetros
    $query = http_build_query($params);
    $url = $oauth2Endpoint . '?' . $query;

    // Redirecionar para a URL do OAuth 2.0
    header('Location: ' . $url);
}

load(__DIR__ );

// Verifica se o botão foi clicado

if (isset($_POST['form_button'])) {
    oauthSignIn();
}

?>