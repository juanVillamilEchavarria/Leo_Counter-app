/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.1.0
 */
import { Badge } from '@/app/shared/components/ui/badge';
import { cn } from '@/app/shared/lib/utils';
import { type BudgetStatusConfig } from '../../utils/budget-status';

interface StatusBadgeProps {
  config: BudgetStatusConfig;
  percentage: number;
}

export function PresupuestoDetailedStatusBadge({ config, percentage }: StatusBadgeProps) {
  return (
    <Badge
      variant={config.badgeVariant}
      className={cn(
        'inline-flex items-center gap-1 px-2 py-0.5 text-[11px] font-semibold tracking-tight rounded-full tabular-nums shrink-0',
        config.badgeClassName
      )}
    >
      <i className={cn('fa-solid text-[9px]', config.icon)} />
      {percentage.toFixed(0)}%
    </Badge>
  );
}