/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useRoute } from "ziggy-js"
const route= useRoute()
export type Comprobante ={
    id : number,
    nombre : string,
    fecha: string
}
export const ArchivoMovimientoRoutes={
    movimientosArchivosShow: (id: number) => route('movimientos.archivos.show', { id }),
    movimientosArchivosDowland: (id: number) => route('movimientos.archivos.download', { id })


}