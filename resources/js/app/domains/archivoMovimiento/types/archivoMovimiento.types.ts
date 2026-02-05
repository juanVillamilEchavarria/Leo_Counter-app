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