import { useMemo, useState } from "react"
import { filterCategoriasByTipoMovimiento } from "../../helpers/filters/filters.helper"
import { type MovimientoFilter } from "../../types/hooks";
export default function useCategoriasMovimientoFilter< TOptions extends Record<string, any>>({
    data,
    options
}:{
    data: MovimientoFilter | undefined,
    options: TOptions
}) {
    
      const [tipoMovimientoId, setTipoMovimientoId] = useState<number | string>(data?.tipo_movimiento_id ?? '');
            const categoriasFiltered = useMemo(() => {
                return filterCategoriasByTipoMovimiento(options.categorias, tipoMovimientoId);
            }, [options.categorias, tipoMovimientoId]);
      return {
        categoriasFiltered,
        tipoMovimientoId,
        setTipoMovimientoId
      }
}
