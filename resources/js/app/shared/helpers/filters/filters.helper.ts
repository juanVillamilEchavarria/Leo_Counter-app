/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { type Categoria } from "@/app/domains/categoria";
export function filterCategoriasByTipoMovimiento(categorias: Categoria[], tipoMovimientoId: number | string) {
    if (tipoMovimientoId === '') return []
    const categoriasFiltered = categorias.filter((categoria)=> categoria.tipo_movimiento_id === Number(tipoMovimientoId))
    return categoriasFiltered;
}

export function filterItemByIndex<T extends Record<string, any>>(index : number | string, iterable : T){
     if(!Array.isArray(iterable)){
        throw new Error(`propiedad iterable no es un array`)
     }
    return iterable.filter((_ , i) => i !== index)
}

export function addUniqueItem<T extends { id: number | string }>(item: T, array: T[]): T[] {
    if (array.some(existing => existing.id === item.id)) return array;
    return [...array, item];
}

export function removeItemById<T extends { id: number | string }>(id: number | string, array: T[]): T[] {
    return array.filter(item => item.id !== id);
}