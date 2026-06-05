<<<<<<< HEAD
<x-email-layout
    title="Verificación de Suscripción"
    :headerBackground="'linear-gradient(135deg, #5f1e1e 0%, #8a2c2c 100%)'"
    headerSubtitle=""
>
<p style="margin: 0 0 16px; font-size: 20px; font-weight: 600; color: #0f172a;">Hola, {{ $name }}</p>
=======
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica tu suscripción - Leo Counter</title>
</head>
<body style="font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f1f5f9; margin: 0; padding: 0; -webkit-text-size-adjust: none;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 16px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06); overflow: hidden;">

    <tr>
        <td style="padding: 32px 40px 20px; text-align: center; background-color: #0f172a; border-radius: 16px 16px 0 0;">
            @if ($logoSvg)
                <div style="max-width: 180px; margin: 0 auto;">
                    {!! $logoSvg !!}
                </div>
            @else
                <span style="color: #ffffff; font-size: 24px; font-weight: bold;">Leo Counter</span>
            @endif
        </td>
    </tr>

    <!-- Cuerpo del mensaje -->
    <tr>
        <td style="padding: 32px 40px 20px; color: #334155; font-size: 16px; line-height: 1.6;">
            <p style="margin: 0 0 16px; font-size: 20px; font-weight: 600; color: #0f172a;">Hola, {{ $name }}</p>
>>>>>>> 23def1b7b9d919ef710829c8b7a5a63623b7ed7b

            <p style="margin: 0 0 16px;">
                Te han agregado como suscriptor de notificaciones en <strong>Leo Counter</strong>. Para comenzar a recibir alertas por correo electrónico, confirma tu suscripción haciendo clic en el siguiente botón:
            </p>

            <!-- Botón de verificación -->
            <div style="text-align: center; margin: 28px 0;">
                <a href="{{ $signedUrl }}" style="display: inline-block; padding: 14px 32px; background-color: #0f172a; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px; letter-spacing: 0.3px; transition: background-color 0.2s;">
                    Verificar suscripción
                </a>
            </div>

            <p style="margin: 0 0 16px; color: #64748b; font-size: 15px;">
                Este enlace expirará en 24 horas por razones de seguridad. Si no solicitaste esta suscripción, puedes ignorar este mensaje.
            </p>

            <p style="margin: 0 0 16px;">
                Si tienes problemas con el botón, copia y pega el siguiente enlace en tu navegador:
            </p>

            <p style="margin: 0 0 24px; word-break: break-all; font-size: 13px; color: #475569; background-color: #f8fafc; padding: 12px; border-radius: 6px; border: 1px solid #e2e8f0;">
                {{ $signedUrl }}
            </p>

            <p style="margin: 0;">
                ¡Gracias por usar Leo Counter!<br>
                <span style="color: #64748b; font-size: 14px;">— El equipo de Leo Counter</span>
            </p>
<<<<<<< HEAD
</x-email-layout>
=======
        </td>
    </tr>

    <!-- Pie de página -->
    <tr>
        <td style="padding: 20px 40px 24px; border-top: 1px solid #e2e8f0; text-align: center; color: #94a3b8; font-size: 13px;">
            &copy; {{ date('Y') }} Leo Counter. Todos los derechos reservados.<br>
            Un proyecto open source para la gestión financiera familiar.
        </td>
    </tr>
</table>
</body>
</html>
>>>>>>> 23def1b7b9d919ef710829c8b7a5a63623b7ed7b
