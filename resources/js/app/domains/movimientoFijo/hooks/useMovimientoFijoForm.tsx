import { useState, useMemo } from "react";
import { filterCategoriasByTipoMovimiento } from "../helpers/optionFilter.helper";
import { type MovimientoFijoFormOptions, type MovimientoFijoFormData } from "../types/movimientoFijo.types";

export default function useMovimientoFijoForm({
    options,
    data
}:{
    options: MovimientoFijoFormOptions
    data?: MovimientoFijoFormData
}) {
        const [tipoMovimientoId, setTipoMovimientoId] = useState<number | string>(data?.tipo_movimiento_id ?? '');
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
