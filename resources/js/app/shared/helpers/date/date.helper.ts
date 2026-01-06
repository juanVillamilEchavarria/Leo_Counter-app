import dayjs from "dayjs";
import localizedFormat from "dayjs/plugin/localizedFormat";
import "dayjs/locale/es";
dayjs.extend(localizedFormat);
dayjs.locale("es");

export function dateFormat(date : string| Date | undefined) {
  return dayjs(date).format('DD [de] MMMM [de] YYYY')
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