<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;
use Inertia\Inertia;

class InertiaParserException{
    public static function parse( Throwable $e, Request $request, Response | JsonResponse $fallback, ?string $message = null){
        if(!$request->inertia()){
            return $fallback;
        }

        
            $pageData = session()->get('_inertia_page', []);
            $component = $pageData['component'] ?? null;

            if ($component) {
                // Caso normal: tenemos la página capturada, la renderizamos con el error
                Inertia::share('flash', [
                    'success' => null,
                    'error' => $message ?? $e->getMessage(),
                ]);
                return Inertia::render($component, $pageData['props'] ?? []);
            }
          return back()->withErrors([
                'domain_error' => $e->getMessage(),
            ])->withInput();
    }
}