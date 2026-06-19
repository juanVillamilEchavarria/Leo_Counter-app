{{-- resources/views/movimientos_fijos/notifications/emails/movimiento_created_automated.blade.php --}}
<x-email-layout
    title="Movimientos Creados Automáticamente"
    :headerBackground="'linear-gradient(135deg, #1e5f3a 0%, #2c8a4e 100%)'"
    headerSubtitle="Gestión Financiera Inteligente"
>
    {{-- Saludo --}}
    <h2 style="color: #1e3a5f; font-size: 18px; font-weight: 600; margin: 0 0 10px 0;">
        ¡Hola, {{ $name }}!
    </h2>
    <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0 0 20px 0;">
        Tus <strong style="color: #2c8a4e;">movimientos fijos</strong> han sido procesados automáticamente
        y se han creado los movimientos correspondientes en tu historial.
    </p>

    {{-- Tabla compacta de movimientos procesados --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border: 1px solid #dbe7df; border-radius: 8px; border-collapse: separate; overflow: hidden; margin-bottom: 25px;">
        <thead>
            <tr style="background-color: #f0fdf4;">
                <th align="left" style="color: #166534; font-size: 12px; font-weight: 700; padding: 12px 14px; border-bottom: 1px solid #bbf7d0;">Nombre</th>
                <th align="right" style="color: #166534; font-size: 12px; font-weight: 700; padding: 12px 14px; border-bottom: 1px solid #bbf7d0;">Monto</th>
                <th align="right" style="color: #166534; font-size: 12px; font-weight: 700; padding: 12px 14px; border-bottom: 1px solid #bbf7d0;">Fecha de Registro</th>
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

    {{-- Mensaje Informativo --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #eff6ff; border-left: 4px solid #3182ce; border-radius: 4px; margin-bottom: 25px;">
        <tr>
            <td style="padding: 15px 20px;">
                <p style="color: #2b6cb0; font-size: 13px; line-height: 1.6; margin: 0;">
                    <strong>Información:</strong>
                    Estos movimientos fueron creados automáticamente porque sus movimientos fijos tienen
                    <strong>registro automático</strong>. Puedes consultarlos en la sección de
                    <strong>Movimientos Históricos</strong> de Leo Counter.
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
