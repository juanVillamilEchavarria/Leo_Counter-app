export function dateFormat(date : string| Date | undefined) {
    if(!date) return
     return new Intl.DateTimeFormat('es-ES', {
    day: '2-digit',
    month: 'long',
    year: 'numeric',
  }).format(new Date(date))
}
export const months: Record<string, string> = {
        'january': 'Enero',
        'february': 'Febrero',
        'march': 'Marzo',
        'april': 'Abril',
        'may': 'Mayo',
        'june': 'Junio',
        'july': 'Julio',
        'august': 'Agosto',
        'september': 'Septiembre',
        'october': 'Octubre',
        'november': 'Noviembre',
        'december': 'Diciembre',
    };