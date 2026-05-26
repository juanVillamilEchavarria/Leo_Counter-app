<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso Denegado - {{ config('app.name', 'Leo Counter') }}</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 flex items-center justify-center min-h-screen">
<div class="text-center">
    <h1 class="text-6xl font-bold text-red-500">403</h1>
    <p class="text-xl text-gray-700 dark:text-gray-300 mt-4">
        No tienes permiso para acceder a esta sección.
    </p>
    <p class="text-md text-gray-500 dark:text-gray-400 mt-2">
        Si crees que esto es un error, contacta al administrador del sistema.
    </p>
</div>
</body>
</html>
