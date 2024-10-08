<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;


return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    api: __DIR__ . '/../routes/api.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
      'JwtAuth' => App\Http\Middleware\JWTAuth::class,
      'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
      'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
      'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions) {
    $exceptions->render(function (Exception $e, Request $request) {

      if ($request->is('api/*')) {
        if ($e instanceof NotFoundHttpException) {
          return response()->json([
            'message' => 'Page not Found.'
          ], 404);
        } elseif ($e instanceof HttpException) {
          return response()->json([
            'message' => $e->getMessage()
          ], $e->getStatusCode());
        } elseif ($e instanceof \Exception) {
          return response()->json([
            'message' => $e->getMessage(),
          ], 500);
        }
      }

      // For non-API requests, let Laravel handle it.
      return parent::render($e, $request);
    });
  })->create();
