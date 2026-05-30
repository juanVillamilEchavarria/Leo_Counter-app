/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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

export function dateFormat(date : string| Date | undefined, format : string = 'DD [de] MMM [de] YYYY') {
  if(!date) return '';
  return dayjs(date).format(format);
}

export const normalizePeriod = (period: string | Date | undefined) =>{
  if(!period) return '';
  if(period instanceof Date){
    return dayjs(period).format('YYYY-MM-DD');
  } 
  return period.slice(0,10);

}; // entra 2025-01-01T00:00:00.000000Z y sale 2025-01-01
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