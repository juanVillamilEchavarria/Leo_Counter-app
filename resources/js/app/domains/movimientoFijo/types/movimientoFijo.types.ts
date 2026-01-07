export type MovimientoFIjoTableData ={
    id : number,
    user : string,
    cuenta : string,
    tipo : string,
    categoria: string,
    monto: number,
    fecha : string | Date,
    frecuencia: string,
    descripcion: string,
    active: boolean,
    registrar_automatico: boolean

}