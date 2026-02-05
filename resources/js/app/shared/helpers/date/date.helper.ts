import dayjs from "dayjs";
import localizedFormat from "dayjs/plugin/localizedFormat";
import "dayjs/locale/es";
dayjs.extend(localizedFormat);
dayjs.locale("es");

export function dateToLocal(date : string| Date | undefined) {
  return dayjs(date).locale('es').format('YYYY-MM-DD')
}

export function today(){
return dayjs().locale('es').format('YYYY-MM-DD');
}

export function monthLimitFromToday(months : number = 1){
    return dayjs().add(months, 'month').locale('es').format('YYYY-MM-DD');
}

export function dateFormat(date : string| Date | undefined, format : string = 'DD [de] MM [de] YYYY') {
  return dayjs(date).format(format);
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