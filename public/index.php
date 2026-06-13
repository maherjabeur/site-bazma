<?php

use App\Kernel;

$_SERVER['APP_ENV'] = $_ENV['APP_ENV'] = getenv('APP_ENV') ?: 'prod';
$_SERVER['APP_DEBUG'] = $_ENV['APP_DEBUG'] = getenv('APP_DEBUG') ?: '0';

if (!is_file(dirname(__DIR__).'/.env')) {
    $_SERVER['APP_RUNTIME_OPTIONS'] = $_ENV['APP_RUNTIME_OPTIONS'] = json_encode(['disable_dotenv' => true]);
}

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return static function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
