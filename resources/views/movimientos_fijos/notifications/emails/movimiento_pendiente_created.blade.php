{{-- resources/views/movimientos_fijos/notifications/emails/movimiento_pendiente_created.blade.php --}}
<x-email-layout
    title="Movimiento Pendiente Creado"
    :headerBackground="'linear-gradient(135deg, #d97706 0%, #f59e0b 100%)'"
    headerSubtitle="Gestión Financiera Inteligente"
>
    {{-- Saludo --}}
    <h2 style="color: #1e3a5f; font-size: 18px; font-weight: 600; margin: 0 0 10px 0;">
        ¡Hola, {{ $name }}!
    </h2>
    <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0 0 25px 0;">
        Tu <strong style="color: #d97706;">movimiento fijo</strong> no estaba configurado para
        <strong>registro automático</strong>, por lo que se ha creado un
        <strong style="color: #b45309;">movimiento pendiente</strong> para que puedas confirmarlo o eliminarlo manualmente.
    </p>

    {{-- Tarjeta del Movimiento Fijo Origen --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; margin-bottom: 15px;">
        <tr>
            <td style="padding: 15px 20px;">
                <h3 style="color: #92400e; font-size: 14px; font-weight: 600; margin: 0 0 10px 0;">
                    🔄 Movimiento Fijo Origen
                </h3>
                <table width="100%" cellpadding="6" cellspacing="0" role="presentation">
                    <tr>
                        <td style="color: #718096; font-size: 12px; font-weight: 500; width: 40%;">Nombre:</td>
                        <td style="color: #2d3748; font-size: 12px; font-weight: 600;">{{ $movimiento_fijo->getNombre() }}</td>
                    </tr>
                    <tr>
                        <td style="color: #718096; font-size: 12px; font-weight: 500;">Monto Programado:</td>
                        <td style="color: #2d3748; font-size: 12px; font-weight: 600;">
                            ${{ number_format($movimiento_fijo->getMonto()->getValue(), 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #718096; font-size: 12px; font-weight: 500;">Próxima Fecha:</td>
                        <td style="color: #2d3748; font-size: 12px; font-weight: 600;">
                            {{ $movimiento_fijo->getFechaProximo()->format('d/m/Y') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Tarjeta del Movimiento Pendiente Creado --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 25px;">
        <tr>
            <td style="padding: 20px 25px;">
                <h3 style="color: #1e3a5f; font-size: 15px; font-weight: 600; margin: 0 0 15px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">
                    📋 Movimiento Pendiente Creado
                </h3>

                <table width="100%" cellpadding="8" cellspacing="0" role="presentation">
                    <tr>
                        <td style="color: #718096; font-size: 13px; font-weight: 500; width: 40%;">Nombre:</td>
                        <td style="color: #2d3748; font-size: 13px; font-weight: 600;">{{ $movimiento_pendiente->getNombre() }}</td>
                    </tr>
                    <tr>
                        <td style="color: #718096; font-size: 13px; font-weight: 500;">Monto:</td>
                        <td style="color: #2d3748; font-size: 13px; font-weight: 600;">
                            ${{ number_format($movimiento_pendiente->getMonto()->getValue(), 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #718096; font-size: 13px; font-weight: 500;">Fecha Límite:</td>
                        <td style="color: #2d3748; font-size: 13px; font-weight: 600;">
                            {{ $movimiento_pendiente->getFechaProgramada()->format('d/m/Y') }}
                        </td>
                    </tr>
                    @if($movimiento_pendiente->getDescripcion())
                        <tr>
                            <td style="color: #718096; font-size: 13px; font-weight: 500;">Descripción:</td>
                            <td style="color: #2d3748; font-size: 13px;">{{ $movimiento_pendiente->getDescripcion() }}</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>

    {{-- Mensaje de Acción Urgente --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #fff7ed; border-left: 4px solid #f97316; border-radius: 4px; margin-bottom: 25px;">
        <tr>
            <td style="padding: 15px 20px;">
                <p style="color: #c2410c; font-size: 13px; line-height: 1.6; margin: 0 0 10px 0;">
                    <strong>⏰ Acción requerida:</strong>
                    Tienes <strong>1 día</strong> para confirmar o eliminar este movimiento pendiente.
                    Si no realizas ninguna acción, expirará automáticamente.
                </p>
                <ul style="color: #c2410c; font-size: 13px; line-height: 1.6; margin: 0; padding-left: 20px;">
                    <li style="margin-bottom: 5px;">
                        <strong>Confírmalo</strong> si el movimiento fue realizado.
                    </li>
                    <li style="margin-bottom: 0;">
                        <strong>Elimínalo</strong> si fue cancelado o ya no es necesario.
                    </li>
                </ul>
            </td>
        </tr>
    </table>

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
