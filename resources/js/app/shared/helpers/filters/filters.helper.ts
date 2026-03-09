import { type Categoria } from "@/app/domains/categoria";
export function filterCategoriasByTipoMovimiento(categorias: Categoria[], tipoMovimientoId: number | string) {
    if (tipoMovimientoId === '') return []
    const categoriasFiltered = categorias.filter((categoria)=> categoria.tipo_movimiento_id === Number(tipoMovimientoId))
    return categoriasFiltered;
}

export function filterItemByIndex<T extends Record<string, any>>(index : number, iterable : T){
     if(!Array.isArray(iterable)){
        throw new Error(`propiedad iterable no es un array`)
     }
    return iterable.filter((_ , i) => i !== index)
}

export function addUniqueItem<T extends { id: number }>(item: T, array: T[]): T[] {
    if (array.some(existing => existing.id === item.id)) return array;
    return [...array, item];
}

export function removeItemById<T extends { id: number }>(id: number, array: T[]): T[] {
    return array.filter(item => item.id !== id);
}