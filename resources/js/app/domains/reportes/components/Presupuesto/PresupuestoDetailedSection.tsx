/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */
import { type SortMode } from "./PresupuestoDetailedSortToggle";
import { PresupuestoDetailedSortToggle } from "./PresupuestoDetailedSortToggle";
import { useState, useMemo } from "react";
import type { Presupuesto } from "../../types/reporte.types";
import { PresupuestoCategoryCard } from "./PresupuestoCategoryCard";
export default function PresupuestoDetailedSection({data}: {data : Presupuesto}) {
    const [sortBy, setSortBy] = useState<SortMode>('percentage');

    const sortedDetailed = useMemo(() => {
        if (!data.detailed) return [];
        const sorted = [...data.detailed];
        if (sortBy === 'percentage') {
        return sorted.sort((a, b) => b.porcentaje_usado - a.porcentaje_usado);
        }
        return sorted.sort((a, b) => b.gastado - a.gastado);
    }, [data.detailed, sortBy]);
  return (
    <div className="mt-8 space-y-4">
      <div className="flex items-center justify-between">
        <div>
          <h4 className="text-sm font-semibold text-foreground tracking-tight">
            Desglose por categoría
          </h4>
          <p className="text-xs text-muted-foreground mt-0.5">
            {sortedDetailed.length} {sortedDetailed.length === 1 ? 'categoría' : 'categorías'} monitoreadas
          </p>
        </div>
        <PresupuestoDetailedSortToggle value={sortBy} onChange={setSortBy} />
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        {sortedDetailed.map((item) => (
          <PresupuestoCategoryCard key={item.categoria} item={item} />
        ))}
      </div>
    </div>
  )
}