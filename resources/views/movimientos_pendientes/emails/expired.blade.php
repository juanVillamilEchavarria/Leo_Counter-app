{{-- resources/views/movimientos_pendientes/emails/expired.blade.php --}}
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leo Counter - Movimiento Pendiente Expirado</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

{{-- Contenedor Principal --}}
<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #f4f6f9; padding: 30px 0;">
    <tr>
        <td align="center">

            {{-- Tarjeta del Correo --}}
            <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);">

                {{-- Encabezado --}}
                <tr>
                    <td style="background: linear-gradient(135deg, #5f1e1e 0%, #8a2c2c 100%); padding: 30px 40px; text-align: center;">
                        <div style="margin-bottom: 10px;">
                            {!! $logoSvg !!}
                        </div>
                        <h1 style="color: #ffffff; font-size: 22px; font-weight: 600; margin: 15px 0 5px 0;">
                            Leo Counter
                        </h1>
                        <p style="color: rgba(255, 255, 255, 0.85); font-size: 14px; margin: 0;">
                            Gestión Financiera Inteligente
                        </p>
                    </td>
                </tr>

                {{-- Cuerpo --}}
                <tr>
                    <td style="padding: 35px 40px;">

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

                    </td>
                </tr>

                {{-- Pie de Página --}}
                <tr>
                    <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 40px; text-align: center;">
                        <p style="color: #a0aec0; font-size: 12px; margin: 0 0 5px 0;">
                            Este es un correo automático generado por <strong>Leo Counter</strong>.
                        </p>
                        <p style="color: #a0aec0; font-size: 11px; margin: 0;">
                            © {{ date('Y') }} Leo Counter - Todos los derechos reservados.
                        </p>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
