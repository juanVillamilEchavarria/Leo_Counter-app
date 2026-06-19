{{-- resources/views/movimientos_pendientes/emails/expired.blade.php --}}
<x-email-layout
    title="Movimientos Pendientes Expirados"
    :headerBackground="'linear-gradient(135deg, #5f1e1e 0%, #8a2c2c 100%)'"
    headerSubtitle="Gestión Financiera Inteligente"
>
    {{-- Saludo --}}
    <h2 style="color: #1e3a5f; font-size: 18px; font-weight: 600; margin: 0 0 10px 0;">
        ¡Hola, {{ $name }}!
    </h2>
    <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0 0 20px 0;">
        Te informamos que los siguientes <strong style="color: #8a2c2c;">movimientos pendientes han expirado</strong>
        y fueron eliminados automáticamente del sistema.
    </p>

    {{-- Tabla compacta de movimientos expirados --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border: 1px solid #fed7d7; border-radius: 8px; border-collapse: separate; overflow: hidden; margin-bottom: 25px;">
        <thead>
            <tr style="background-color: #fff5f5;">
                <th align="left" style="color: #8a2c2c; font-size: 12px; font-weight: 700; padding: 12px 14px; border-bottom: 1px solid #fed7d7;">Nombre</th>
                <th align="right" style="color: #8a2c2c; font-size: 12px; font-weight: 700; padding: 12px 14px; border-bottom: 1px solid #fed7d7;">Monto</th>
                <th align="right" style="color: #8a2c2c; font-size: 12px; font-weight: 700; padding: 12px 14px; border-bottom: 1px solid #fed7d7;">Fecha Programada</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movimientosPendientes as $movimientoPendiente)
                <tr style="background-color: {{ $loop->even ? '#f8fafc' : '#ffffff' }};">
                    <td style="color: #2d3748; font-size: 13px; font-weight: 600; padding: 12px 14px; border-bottom: 1px solid #edf2f7;">
                        {{ $movimientoPendiente->getNombre() }}
                    </td>
                    <td align="right" style="color: #2d3748; font-size: 13px; font-weight: 600; padding: 12px 14px; border-bottom: 1px solid #edf2f7; white-space: nowrap;">
                        ${{ number_format($movimientoPendiente->getMonto()->getValue(), 2) }}
                    </td>
                    <td align="right" style="color: #4a5568; font-size: 13px; padding: 12px 14px; border-bottom: 1px solid #edf2f7; white-space: nowrap;">
                        {{ $movimientoPendiente->getFechaProgramada()->format('d/m/Y') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Mensaje de Recomendación --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #fff5f5; border-left: 4px solid #e53e3e; border-radius: 4px; margin-bottom: 25px;">
        <tr>
            <td style="padding: 15px 20px;">
                <p style="color: #c53030; font-size: 13px; line-height: 1.6; margin: 0;">
                    <strong>Recomendación:</strong>
                    Para evitar expiraciones futuras, confirma los movimientos pendientes una vez realizados,
                    elimínalos si fueron cancelados y revisa periódicamente la sección de Movimientos Pendientes.
                </p>
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
