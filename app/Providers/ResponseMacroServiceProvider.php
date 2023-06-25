<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Response;
use JWTAuth;

class ResponseMacroServiceProvider extends ServiceProvider
{
  public function boot()
  {
    Response::macro('success', function ($data) {
        return Response::json([
          'errors'  => false,
          'data' => $data,       
        ]);
    });

    Response::macro('error', function ($message, $status = 400) {
        return Response::json([
          'errors'  => true,
          'message' => $message,
        ], $status);
    });
  }
}