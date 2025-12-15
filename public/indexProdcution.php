<?php
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
*/
if (file_exists($maintenance = __DIR__ . '/../../csistandrewssithalapakkam_api/storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/
try {
    $autoloadPath = __DIR__ . '/../../csistandrewssithalapakkam_api/vendor/autoload.php';
    if (!file_exists($autoloadPath)) {
        throw new Exception("Autoload file not found at: $autoloadPath");
    }
    require $autoloadPath;
} catch (Throwable $e) {
    http_response_code(500);
    echo "❌ Autoload error: " . $e->getMessage();
    error_log($e);
    exit;
}

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/
try {
    $app = require_once __DIR__ . '/../../csistandrewssithalapakkam_api/bootstrap/app.php';
    $kernel = $app->make(Kernel::class);

    $response = $kernel->handle(
        $request = Request::capture()
    )->send();

    $kernel->terminate($request, $response);

} catch (Throwable $e) {
    http_response_code(500);
    echo "❌ Application error: " . $e->getMessage();
    error_log($e);
}
