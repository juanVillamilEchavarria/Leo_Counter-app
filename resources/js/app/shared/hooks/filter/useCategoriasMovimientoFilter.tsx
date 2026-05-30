/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useMemo, useState, useEffect } from "react"
import { filterCategoriasByTipoMovimiento } from "../../helpers/filters/filters.helper"
import { type MovimientoFilter } from "../../types/hooks";
export default function useCategoriasMovimientoFilter< TOptions extends Record<string, any>>({
    data,
    options,
    onCategoriaInvalid
}:{
    data: MovimientoFilter | undefined,
    options: TOptions
    onCategoriaInvalid : () => void
}) {
    
      const [tipoMovimientoId, setTipoMovimientoId] = useState<number | string>(data?.tipo_movimiento_id ?? '');
            const categoriasFiltered = useMemo(() => {
                return filterCategoriasByTipoMovimiento(options.categorias, tipoMovimientoId);
            }, [options.categorias, tipoMovimientoId]);

             useEffect(()=>{
                    const valid = categoriasFiltered.find(categoria => categoria.id === data?.categoria_id)
             
                    if(valid === undefined){
                        onCategoriaInvalid();
                    }
                }, [data?.categoria_id, data?.tipo_movimiento_id, categoriasFiltered])
      return {
        categoriasFiltered,
        tipoMovimientoId,
        setTipoMovimientoId
      }
}
