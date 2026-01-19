import { useState, useMemo } from "react";
import { filterCategoriasByTipoMovimiento } from "../helpers/optionFilter.helper";
import { type MovimientoFijoFormOptions } from "../types/movimientoFijo.types";

export default function useMovimientoFijoForm({
    options
}:{
    options: MovimientoFijoFormOptions
}) {
        const [tipoMovimientoId, setTipoMovimientoId] = useState<number | string>('');
        const categoriasFiltered = filterCategoriasByTipoMovimiento(options.categorias, tipoMovimientoId);
        const today= useMemo(()=>{
            return new Date().toISOString().split('T')[0];
        },[])
  return {
    categoriasFiltered,
    today,
    tipoMovimientoId,
    setTipoMovimientoId
  }
}
