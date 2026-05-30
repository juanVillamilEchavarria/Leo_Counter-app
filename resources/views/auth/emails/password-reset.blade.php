{{-- resources/views/auth/emails/password-reset.blade.php --}}
<x-email-layout
    :logoSvg="$logoSvg"
    title="Restablecer Contraseña"
    :headerBackground="'linear-gradient(135deg, #1e3a5f 0%, #2c5f8a 100%)'"
    headerSubtitle="Gestión Financiera Inteligente"
>
    {{-- Saludo --}}
    <h2 style="color: #1e3a5f; font-size: 18px; font-weight: 600; margin: 0 0 10px 0;">
        ¡Hola, {{ $name }}!
    </h2>
    <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0 0 25px 0;">
        Has solicitado restablecer tu contraseña en <strong>Leo Counter</strong>. Haz clic en el siguiente botón para crear una nueva contraseña:
    </p>

    {{-- Botón de Restablecimiento --}}
    <div style="text-align: center; margin: 28px 0;">
        <a href="{{ $signedUrl }}" style="display: inline-block; padding: 14px 32px; background-color: #2c5f8a; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px; letter-spacing: 0.3px;">
            Restablecer contraseña
        </a>
    </div>

    <p style="color: #64748b; font-size: 15px; margin: 0 0 16px;">
        Este enlace expirará en 60 minutos por razones de seguridad. Si no solicitaste este cambio, puedes ignorar este mensaje.
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
</x-email-layout>
