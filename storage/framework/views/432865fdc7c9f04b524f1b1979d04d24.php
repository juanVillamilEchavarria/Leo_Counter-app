<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suscripción verificada · Leo Counter</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>
<body class="h-full bg-slate-50 font-sans antialiased">

<main class="grid min-h-full place-items-center px-6 py-24 sm:py-32">
    <div class="w-full max-w-md">
        <!-- Tarjeta -->
        <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/60 p-8 text-center ring-1 ring-slate-200">
            <!-- Icono de éxito (check) -->
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100">
                <svg class="h-12 w-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <h1 class="mt-6 text-2xl font-bold tracking-tight text-slate-900">
                ¡Suscripción verificada!
            </h1>

            <p class="mt-2 text-base leading-7 text-slate-500">
                Tu canal de notificación ha sido confirmado correctamente.<br>
                Ya puedes cerrar esta pestaña y volver a Leo Counter.
            </p>

            <div class="mt-8 flex flex-col gap-3">
                <a href="<?php echo e(url('/login')); ?>"
                   class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow hover:bg-slate-800 transition-colors">
                    Ir a la aplicación
                </a>
                <button onclick="window.close()"
                        class="inline-flex items-center justify-center rounded-lg bg-white px-6 py-3 text-sm font-medium text-slate-700 ring-1 ring-slate-300 hover:bg-slate-50 transition-colors">
                    Cerrar pestaña
                </button>
            </div>
        </div>

        <!-- Pie de página -->
        <p class="mt-8 text-center text-xs text-slate-400">
            &copy; <?php echo e(date('Y')); ?> Leo Counter. Gestión financiera familiar, privada y autoalojable.
        </p>
    </div>
</main>

</body>
</html>
<?php /**PATH /var/www/html/resources/views/notificaciones/suscriptores/verified.blade.php ENDPATH**/ ?>