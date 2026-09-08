<x-email-layout
    title="Alerta de Seguridad"
    :headerBackground="'linear-gradient(135deg, #c53030 0%, #e53e3e 100%)'"
    headerSubtitle="Notificación del Sistema"
>
    <h2 style="color: #1e3a5f; font-size: 18px; font-weight: 600; margin: 0 0 10px 0;">
        Hola, {{ $adminName }}
    </h2>
    <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0 0 20px 0;">
        Se ha detectado una <strong style="color: #c53030;">exportación masiva de registros</strong> en Leo Counter.
        Esta notificación se envía automáticamente como parte del protocolo de auditoría del sistema.
    </p>

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border: 1px solid #fed7d7; border-radius: 8px; border-collapse: separate; overflow: hidden; margin-bottom: 25px;">
        <thead>
            <tr style="background-color: #fff5f5;">
                <th colspan="2" align="left" style="color: #c53030; font-size: 12px; font-weight: 700; padding: 12px 14px; border-bottom: 1px solid #fed7d7;">
                    Detalles de la exportación
                </th>
            </tr>
        </thead>
        <tbody>
              <tr style="background-color: #f8fafc;">
                <td style="color: #4a5568; font-size: 13px; padding: 10px 14px; border-bottom: 1px solid #edf2f7;">ID de exportación</td>
                <td style="color: #2d3748; font-size: 13px; font-weight: 600; padding: 10px 14px; border-bottom: 1px solid #edf2f7; text-transform: capitalize;">
                    {{ $exportId}}
                </td>
            </tr>
            <tr style="background-color: #ffffff;">
                <td style="color: #4a5568; font-size: 13px; padding: 10px 14px; border-bottom: 1px solid #edf2f7; width: 40%;">Usuario</td>
                <td style="color: #2d3748; font-size: 13px; font-weight: 600; padding: 10px 14px; border-bottom: 1px solid #edf2f7;">
                    {{ $userName }}<br>
                    <span style="color: #718096; font-weight: 400; font-size: 12px;">{{ $userEmail }}</span>
                </td>
            </tr>
            <tr style="background-color: #f8fafc;">
                <td style="color: #4a5568; font-size: 13px; padding: 10px 14px; border-bottom: 1px solid #edf2f7;">Tabla exportada</td>
                <td style="color: #2d3748; font-size: 13px; font-weight: 600; padding: 10px 14px; border-bottom: 1px solid #edf2f7; text-transform: capitalize;">
                    {{ str_replace('_', ' ', $table) }}
                </td>
            </tr>
            <tr style="background-color: #ffffff;">
                <td style="color: #4a5568; font-size: 13px; padding: 10px 14px; border-bottom: 1px solid #edf2f7;">Registros exportados</td>
                <td style="color: #c53030; font-size: 13px; font-weight: 700; padding: 10px 14px; border-bottom: 1px solid #edf2f7;">
                    {{ number_format($recordsCount, 0, ',', '.') }}
                </td>
            </tr>
            <tr style="background-color: #f8fafc;">
                <td style="color: #4a5568; font-size: 13px; padding: 10px 14px; border-bottom: 1px solid #edf2f7;">Formato</td>
                <td style="color: #2d3748; font-size: 13px; font-weight: 600; padding: 10px 14px; border-bottom: 1px solid #edf2f7; text-transform: uppercase;">
                    {{ $format }}
                </td>
            </tr>
            <tr style="background-color: #ffffff;">
                <td style="color: #4a5568; font-size: 13px; padding: 10px 14px; border-bottom: 1px solid #edf2f7;">Archivo</td>
                <td style="color: #2d3748; font-size: 13px; padding: 10px 14px; border-bottom: 1px solid #edf2f7; word-break: break-all;">
                    {{ $filename }}
                </td>
            </tr>
            <tr style="background-color: #f8fafc;">
                <td style="color: #4a5568; font-size: 13px; padding: 10px 14px;">Fecha y hora</td>
                <td style="color: #2d3748; font-size: 13px; font-weight: 600; padding: 10px 14px;">
                    {{ $exportedAt->format('d/m/Y H:i:s') }}
                </td>
            </tr>
        </tbody>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #fffaf0; border-left: 4px solid #dd6b20; border-radius: 4px; margin-bottom: 25px;">
        <tr>
            <td style="padding: 15px 20px;">
                <p style="color: #c05621; font-size: 13px; line-height: 1.6; margin: 0;">
                    <strong>Recuerda:</strong> Puedes revisar el historial completo de exportaciones desde la sección
                    <strong>Exportaciones</strong> en tu panel de administrador de Leo Counter.
                </p>
            </td>
        </tr>
    </table>

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