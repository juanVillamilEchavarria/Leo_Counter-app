<x-email-layout
    title="Aviso de Movimientos"
    :headerBackground="'linear-gradient(135deg, #1e3a5f 0%, #2c5f8a 100%)'"
    headerSubtitle="Gestión Financiera Inteligente"
>
    @php
        $esMovimientoFijo = $tipo === 'movimiento fijo';
        $tipoPlural = $esMovimientoFijo ? 'movimientos fijos' : 'movimientos pendientes';
        $fechaLabel = $esMovimientoFijo ? 'Próxima Fecha' : 'Fecha Programada';
    @endphp

    {{-- Saludo --}}
    <h2 style="color: #1e3a5f; font-size: 18px; font-weight: 600; margin: 0 0 10px 0;">
        ¡Hola, {{ $name }}!
    </h2>
    <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0 0 20px 0;">
        Este es un recordatorio automático de Leo Counter para informarte que tienes
        <strong style="color: #2c5f8a;">{{ $tipoPlural }}</strong>
        programados para los próximos días.
    </p>

    {{-- Tabla compacta de movimientos --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border: 1px solid #d9e6f2; border-radius: 8px; border-collapse: separate; overflow: hidden; margin-bottom: 25px;">
        <thead>
            <tr style="background-color: #ebf8ff;">
                <th align="left" style="color: #1e3a5f; font-size: 12px; font-weight: 700; padding: 12px 14px; border-bottom: 1px solid #bee3f8;">Nombre</th>
                <th align="right" style="color: #1e3a5f; font-size: 12px; font-weight: 700; padding: 12px 14px; border-bottom: 1px solid #bee3f8;">Monto</th>
                <th align="right" style="color: #1e3a5f; font-size: 12px; font-weight: 700; padding: 12px 14px; border-bottom: 1px solid #bee3f8;">{{ $fechaLabel }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movimientos as $movimiento)
                @php
                    $fecha = $esMovimientoFijo
                        ? $movimiento->getFechaProximo()
                        : $movimiento->getFechaProgramada();
                @endphp
                <tr style="background-color: {{ $loop->even ? '#f8fafc' : '#ffffff' }};">
                    <td style="color: #2d3748; font-size: 13px; font-weight: 600; padding: 12px 14px; border-bottom: 1px solid #edf2f7;">
                        {{ $movimiento->getNombre() }}
                    </td>
                    <td align="right" style="color: #2d3748; font-size: 13px; font-weight: 600; padding: 12px 14px; border-bottom: 1px solid #edf2f7; white-space: nowrap;">
                        ${{ number_format($movimiento->getMonto()->getValue(), 2) }}
                    </td>
                    <td align="right" style="color: #4a5568; font-size: 13px; padding: 12px 14px; border-bottom: 1px solid #edf2f7; white-space: nowrap;">
                        {{ $fecha->format('d/m/Y') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Mensaje de Acción --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #ebf8ff; border-left: 4px solid #3182ce; border-radius: 4px; margin-bottom: 25px;">
        <tr>
            <td style="padding: 15px 20px;">
                <p style="color: #2b6cb0; font-size: 13px; line-height: 1.6; margin: 0;">
                    <strong>Recuerda:</strong>
                    @if($esMovimientoFijo)
                        Puedes gestionar estos movimientos fijos desde la sección de <strong>Movimientos Fijos</strong> en tu panel de Leo Counter.
                    @else
                        Puedes confirmar o cancelar estos movimientos desde la sección de <strong>Movimientos Pendientes</strong> en tu panel de Leo Counter.
                    @endif
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
