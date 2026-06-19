{{-- resources/views/movimientos_fijos/notifications/emails/movimiento_pendiente_created.blade.php --}}
<x-email-layout
    title="Movimientos Pendientes Creados"
    :headerBackground="'linear-gradient(135deg, #d97706 0%, #f59e0b 100%)'"
    headerSubtitle="Gestión Financiera Inteligente"
>
    {{-- Saludo --}}
    <h2 style="color: #1e3a5f; font-size: 18px; font-weight: 600; margin: 0 0 10px 0;">
        ¡Hola, {{ $name }}!
    </h2>
    <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0 0 20px 0;">
        Algunos <strong style="color: #d97706;">movimientos fijos</strong> no están configurados para
        <strong>registro automático</strong>, por lo que se crearon
        <strong style="color: #b45309;">movimientos pendientes</strong> para que puedas confirmarlos o eliminarlos manualmente.
    </p>

    {{-- Tabla compacta de movimientos pendientes creados --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border: 1px solid #fde68a; border-radius: 8px; border-collapse: separate; overflow: hidden; margin-bottom: 25px;">
        <thead>
            <tr style="background-color: #fffbeb;">
                <th align="left" style="color: #92400e; font-size: 12px; font-weight: 700; padding: 12px 14px; border-bottom: 1px solid #fde68a;">Nombre</th>
                <th align="right" style="color: #92400e; font-size: 12px; font-weight: 700; padding: 12px 14px; border-bottom: 1px solid #fde68a;">Monto</th>
                <th align="right" style="color: #92400e; font-size: 12px; font-weight: 700; padding: 12px 14px; border-bottom: 1px solid #fde68a;">Próxima Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movimientosFijos as $movimientoFijo)
                <tr style="background-color: {{ $loop->even ? '#f8fafc' : '#ffffff' }};">
                    <td style="color: #2d3748; font-size: 13px; font-weight: 600; padding: 12px 14px; border-bottom: 1px solid #edf2f7;">
                        {{ $movimientoFijo->getNombre() }}
                    </td>
                    <td align="right" style="color: #2d3748; font-size: 13px; font-weight: 600; padding: 12px 14px; border-bottom: 1px solid #edf2f7; white-space: nowrap;">
                        ${{ number_format($movimientoFijo->getMonto()->getValue(), 2) }}
                    </td>
                    <td align="right" style="color: #4a5568; font-size: 13px; padding: 12px 14px; border-bottom: 1px solid #edf2f7; white-space: nowrap;">
                        {{ $movimientoFijo->getFechaProximo()->format('d/m/Y') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Mensaje de Acción Urgente --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #fff7ed; border-left: 4px solid #f97316; border-radius: 4px; margin-bottom: 25px;">
        <tr>
            <td style="padding: 15px 20px;">
                <p style="color: #c2410c; font-size: 13px; line-height: 1.6; margin: 0;">
                    <strong>Acción requerida:</strong>
                    Confirma los movimientos pendientes si ya fueron realizados, o elimínalos si fueron cancelados.
                    Si no realizas ninguna acción, expirarán automáticamente.
                </p>
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
