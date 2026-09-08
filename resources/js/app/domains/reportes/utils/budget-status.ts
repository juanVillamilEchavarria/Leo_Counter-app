/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.1.0
 */
export type BudgetStatus = 'controlled' | 'alert' | 'critical' | 'overrun';

export interface BudgetStatusConfig {
  status: BudgetStatus;
  gradient: string;
  barGradient: string;
  badgeVariant: 'default' | 'secondary' | 'destructive' | 'outline';
  badgeClassName: string;
  amountColor: string;
  icon: string;
  label: string;
}

export const getBudgetStatus = (percentage: number): BudgetStatusConfig => {
  if (percentage > 90) {
    return {
      status: 'critical',
      gradient: 'bg-red-600/20 dark:bg-red-700/30',
      barGradient: 'bg-gradient-to-r from-red-600/30  to-red-700/40',
      badgeVariant: 'destructive',
      badgeClassName: 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300',
      amountColor: 'text-red-600 dark:text-red-700',
      icon: 'fa-triangle-exclamation',
      label: 'Crítico',
    };
  }
  if (percentage >= 80) {
    return {
      status: 'alert',
      gradient: 'bg-gradient-to-r from-yellow-400/60 to-orange-400/60',
      barGradient: 'bg-gradient-to-r from-yellow-400 via-orange-400 to-orange-500',
      badgeVariant: 'secondary',
      badgeClassName: 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300',
      amountColor: 'text-orange-600 dark:text-orange-400',
      icon: 'fa-triangle-exclamation',
      label: 'Alerta',
    };
  }
  return {
    status: 'controlled',
    gradient: 'bg-gradient-to-r from-green-600/30 to-emerald-700/50',
    barGradient: 'bg-gradient-to-r from-green-600/40 to-emerald-700/40',
badgeVariant: 'default',
      badgeClassName: 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300',
      amountColor: 'text-foreground',
    icon: 'fa-check',
    label: 'En control',
  };
};