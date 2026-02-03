import { useMemo, useState } from "react"
import { filterCategoriasByTipoMovimiento } from "../../helpers/filters/filters.helper"
import { today as todayFunction } from "../../helpers";
import { type MovimientoFilter } from "../../types/hooks";
export default function useCategoriasMovimientoFilter< TOptions extends Record<string, any>>({
    data,
    options
}:{
    data: MovimientoFilter | undefined,
    options: TOptions
}) {
    
      const [tipoMovimientoId, setTipoMovimientoId] = useState<number | string>(data?.tipo_movimiento_id ?? '');
            const categoriasFiltered = filterCategoriasByTipoMovimiento(options.categorias, tipoMovimientoId);
            const today= useMemo(()=>{
                return todayFunction();
            },[])
      return {
        categoriasFiltered,
        today,
        tipoMovimientoId,
        setTipoMovimientoId
      }
}
