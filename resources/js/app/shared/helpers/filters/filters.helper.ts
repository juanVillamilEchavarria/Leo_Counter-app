import { type Categoria } from "@/app/domains/categoria";
export function filterCategoriasByTipoMovimiento(categorias: Categoria[], tipoMovimientoId: number | string) {
    if (tipoMovimientoId === '') return []
    const categoriasFiltered = categorias.filter((categoria)=> categoria.tipo_movimiento_id === Number(tipoMovimientoId))
    return categoriasFiltered;
}