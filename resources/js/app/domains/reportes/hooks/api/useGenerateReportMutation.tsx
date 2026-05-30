/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useMutation } from '@tanstack/react-query';
import useMutationApiErrors from '@/app/shared/hooks/api/useMutationApiErrors';
import { generateReporteApi } from '../../api/reporte.api';
import { parseApiErrors } from '@/app/shared/helpers';
import {type ApiErrorResponse } from '@/app/shared/types/api';
import { type ReporteFormData, type ReporteApiResponse } from '../../types/reporte.types';
import { type AxiosError } from 'axios';
export function useGenerateReportMutation(
  onSuccess?: (data: ReporteApiResponse) => void,
  onError?: (errors: Record<string, string> | AxiosError<any, any>) => void
) {
  const mutation = useMutation({
    mutationFn: (data: ReporteFormData) => generateReporteApi(data),
    onSuccess: (data) => {
      if (onSuccess) onSuccess(data);
    },
    onError: (error: AxiosError<ApiErrorResponse>) => {
      if(error.response?.data?.errors?.startDate || error.response?.data?.errors?.endDate) return
      if (onError) onError(error);
    },
  });
  const {getErrorMessage, getValidationErrors}= useMutationApiErrors(mutation as any);
  return {
    mutate: async (data : any) => {
      try {
        return await mutation.mutateAsync(data);
      } catch {
      }
    },
    isPending: mutation.isPending,
    isSuccess: mutation.isSuccess,
    isError: mutation.isError,
    error: getErrorMessage(),
    validationErrors: getValidationErrors(),
    reset: () => mutation.reset(),
  };
}
