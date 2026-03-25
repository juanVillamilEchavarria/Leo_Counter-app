import { type ReporteFormData } from '../../types/reporte.types';
import { useForm } from '@inertiajs/react';
export type FormErrors = Partial<Record<keyof ReporteFormData, string>>;

const createInitialFormData = (): ReporteFormData => ({
  cuentas: [],
  categorias: [],
  startDate: '',
  endDate: '',
  only_categorias_fijas: false,
});
export function useReporteForm(
  initialData: Partial<ReporteFormData> = {}
) {
  const initialFormData = createInitialFormData();
  const form = useForm<ReporteFormData>({
    ...initialFormData,
    ...initialData,});
  return form;
}

