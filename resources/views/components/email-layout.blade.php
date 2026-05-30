@props([
    'logoSvg',
    'title' => 'Leo Counter',
    'headerBackground' => 'linear-gradient(135deg, #1e3a5f 0%, #2c5f8a 100%)',
    'headerSubtitle' => 'Gestión Financiera Inteligente',
])

    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Leo Counter</title>
</head>
<body style="font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f1f5f9; margin: 0; padding: 0; -webkit-text-size-adjust: none;">

{{-- Contenedor Principal --}}
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 640px; margin: 40px auto; background-color: #ffffff; border-radius: 16px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06); overflow: hidden;">

    {{-- Encabezado con Logo y Título --}}
    <tr>
        <td style="padding: 24px 32px 18px; text-align: center; background: {{ $headerBackground }}; border-radius: 16px 16px 0 0;">
            <div style="max-width: 150px; margin: 0 auto;">
                {!! $logoSvg !!}
            </div>
            <h1 style="color: #ffffff; font-size: 20px; font-weight: 600; margin: 12px 0 4px 0;">
                {{ $title }}
            </h1>
            @if($headerSubtitle)
                <p style="color: rgba(255, 255, 255, 0.85); font-size: 13px; margin: 0;">
                    {{ $headerSubtitle }}
                </p>
            @endif
        </td>
    </tr>

    {{-- Cuerpo del Mensaje --}}
    <tr>
        <td style="padding: 32px 40px 20px; color: #334155; font-size: 16px; line-height: 1.6;">
            {{ $slot }}
        </td>
    </tr>

    {{-- Pie de Página --}}
    <tr>
        <td style="padding: 20px 40px 24px; border-top: 1px solid #e2e8f0; text-align: center; color: #94a3b8; font-size: 13px;">
            &copy; {{ date('Y') }} Leo Counter. Todos los derechos reservados.<br>
            Un proyecto open source para la gestión financiera familiar.
        </td>
    </tr>

</table>

</body>
</html>
