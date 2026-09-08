/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.1.0
 */
import { ToggleGroup, ToggleGroupItem } from "@/app/shared/components/ui/toggle-group";

export type SortMode = 'percentage' | 'amount';

interface PresupuestoDetailedSortToggleProps {
  value: SortMode;
  onChange: (value: SortMode) => void;
}

export function PresupuestoDetailedSortToggle({ value, onChange }: PresupuestoDetailedSortToggleProps) {
  return (
    <ToggleGroup
      type="single"
      value={value}
      onValueChange={(v) => v && onChange(v as SortMode)}
      size="sm"
      variant="outline"
      className="border border-border/60 rounded-lg overflow-hidden p-0.5 bg-muted/30"
    >
      <ToggleGroupItem
        value="percentage"
        aria-label="Ordenar por porcentaje"
        className="text-xs px-3 rounded-md data-[state=on]:bg-foreground data-[state=on]:text-background text-foreground data-[state=on]:shadow-sm"
      >
        Por %
      </ToggleGroupItem>
      <ToggleGroupItem
        value="amount"
        aria-label="Ordenar por monto"
        className="text-xs px-3 rounded-md data-[state=on]:bg-foreground data-[state=on]:text-background text-foreground data-[state=on]:shadow-sm"
      >
        Por monto
      </ToggleGroupItem>
    </ToggleGroup>
  );
}