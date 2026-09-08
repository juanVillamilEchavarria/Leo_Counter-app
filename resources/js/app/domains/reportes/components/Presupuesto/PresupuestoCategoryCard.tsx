import { Card, CardContent, CardHeader, CardTitle } from '@/app/shared/components/ui/card';
import { Progress } from '@/app/shared/components/ui/progress';
import { moneyFormat } from '@/app/shared/helpers';
import { PresupuestoDetailedStatusBadge } from './PresupuestoDetailedStatusBadge';
import { getBudgetStatus } from '../../utils/budget-status';
import { type PresupuestoDetailed } from '../../types/reporte.types';

interface CategoryBudgetCardProps {
  item: PresupuestoDetailed;
}

export function PresupuestoCategoryCard({ item }: CategoryBudgetCardProps) {
  const status = getBudgetStatus(item.porcentaje_usado);
  const progressPercent = Math.min(item.porcentaje_usado, 100);

  return (
    <Card className="group relative overflow-hidden border border-border/60 bg-card transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
      <div className={`absolute top-0 left-0 right-0 h-1 ${status.gradient}`} />

      <CardHeader className="px-5 pt-5 pb-3">
        <div className="flex items-start justify-between gap-2">
          <CardTitle className="text-sm font-medium text-foreground truncate">
            {item.categoria}
          </CardTitle>
          <PresupuestoDetailedStatusBadge config={status} percentage={item.porcentaje_usado} />
        </div>
      </CardHeader>

      <CardContent className="px-5 pb-5 space-y-4">
        <div>
          <div className={`text-xl font-bold tracking-tight tabular-nums ${status.amountColor}`}>
            {moneyFormat(item.gastado)}
          </div>
          <div className="text-xs text-muted-foreground mt-1">
            gastado de{' '}
            <span className="font-medium text-foreground tabular-nums">
              {moneyFormat(item.presupuestado)}
            </span>
          </div>
        </div>

        <div className="relative">
          <Progress
            value={progressPercent}
            className="h-1.5"
            indicatorClassName={status.barGradient}
          />
        </div>

        <div className="flex items-center justify-between pt-3 border-t border-border/50">
          <div className="flex items-center gap-1.5 text-xs text-muted-foreground">
            <i
              className={`fa-solid ${
                item.disponible > 0 ? 'fa-wallet' : 'fa-triangle-exclamation text-red-500/60'
              }`}
            />
            <span>{item.disponible >= 0 ? 'Disponible' : 'Excedido'}</span>
          </div>
          <span
            className={`text-sm font-semibold tabular-nums ${
              item.disponible > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400'
            }`}
          >
            {item.disponible < 0 && '−'}
            {moneyFormat(Math.abs(item.disponible))}
          </span>
        </div>
      </CardContent>
    </Card>
  );
}