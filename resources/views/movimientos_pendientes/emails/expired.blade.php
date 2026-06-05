{{-- resources/views/movimientos_pendientes/emails/expired.blade.php --}}
<x-email-layout
<<<<<<< HEAD
=======
    :logoSvg="$logoSvg"
>>>>>>> 23def1b7b9d919ef710829c8b7a5a63623b7ed7b
    title="Movimiento Pendiente Expirado"
    :headerBackground="'linear-gradient(135deg, #5f1e1e 0%, #8a2c2c 100%)'"
    headerSubtitle="Gestión Financiera Inteligente"
>
    {{-- Saludo --}}
    <h2 style="color: #1e3a5f; font-size: 18px; font-weight: 600; margin: 0 0 10px 0;">
        ¡Hola, {{ $name }}!
    </h2>
    <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0 0 25px 0;">
        Te informamos que el siguiente <strong style="color: #8a2c2c;">movimiento pendiente ha expirado</strong>
        y ha sido eliminado automáticamente del sistema.
    </p>

    {{-- Tarjeta de Detalles del Movimiento --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 25px;">
        <tr>
            <td style="padding: 20px 25px;">
                <h3 style="color: #1e3a5f; font-size: 15px; font-weight: 600; margin: 0 0 15px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">
                    📋 Movimiento Pendiente Expirado
                </h3>

                <table width="100%" cellpadding="8" cellspacing="0" role="presentation">
                    <tr>
                        <td style="color: #718096; font-size: 13px; font-weight: 500; width: 40%;">Nombre:</td>
                        <td style="color: #2d3748; font-size: 13px; font-weight: 600;">{{ $movimiento->getNombre() }}</td>
                    </tr>
                    <tr>
                        <td style="color: #718096; font-size: 13px; font-weight: 500;">Monto:</td>
                        <td style="color: #2d3748; font-size: 13px; font-weight: 600;">
                            ${{ number_format($movimiento->getMonto()->getValue(), 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #718096; font-size: 13px; font-weight: 500;">Fecha Programada:</td>
                        <td style="color: #2d3748; font-size: 13px; font-weight: 600;">
                            {{ $movimiento->getFechaProgramada()->format('d/m/Y') }}
                        </td>
                    </tr>
                    @if($movimiento->getDescripcion())
                        <tr>
                            <td style="color: #718096; font-size: 13px; font-weight: 500;">Descripción:</td>
                            <td style="color: #2d3748; font-size: 13px;">{{ $movimiento->getDescripcion() }}</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>

    {{-- Mensaje de Recomendación --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #fff5f5; border-left: 4px solid #e53e3e; border-radius: 4px; margin-bottom: 25px;">
        <tr>
            <td style="padding: 15px 20px;">
                <p style="color: #c53030; font-size: 13px; line-height: 1.6; margin: 0 0 10px 0;">
                    <strong>⚠️ Recomendación:</strong>
                    Para evitar que tus movimientos pendientes expiren en el futuro, te sugerimos:
                </p>
                <ul style="color: #c53030; font-size: 13px; line-height: 1.6; margin: 0; padding-left: 20px;">
                    <li style="margin-bottom: 5px;"><strong>Confirmarlos</strong> una vez realizados.</li>
                    <li style="margin-bottom: 5px;"><strong>Eliminarlos manualmente</strong> si fueron cancelados.</li>
                    <li style="margin-bottom: 0;"><strong>Revisar periódicamente</strong> la sección de Movimientos Pendientes.</li>
                </ul>
            </td>
        </tr>
    </table>

    {{-- Mensaje de Despedida --}}
    <p style="color: #4a5568; font-size: 13px; line-height: 1.6; margin: 0 0 25px 0;">
        Mantener tus finanzas organizadas es clave para una gestión saludable.
        <strong>Leo Counter</strong> está aquí para ayudarte en cada paso.
    </p>

    {{-- Botón de Acción --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom: 10px;">
        <tr>
            <td align="center">
                <a href="{{ config('app.url') }}" style="display: inline-block; background-color: #2c5f8a; color: #ffffff; text-decoration: none; padding: 12px 35px; border-radius: 6px; font-size: 14px; font-weight: 600;">
                    Ir a Leo Counter
                </a>
            </td>
        </tr>
    </table>
</x-email-layout>
