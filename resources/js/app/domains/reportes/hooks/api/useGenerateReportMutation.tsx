import { useMutation } from '@tanstack/react-query';
import useMutationApiErrors from '@/app/shared/hooks/api/useMutationApiErrors';
import { generateReporteApi } from '../../api/reporte.api';
import { parseApiErrors } from '@/app/shared/helpers';
import {type ApiErrorResponse } from '@/app/shared/types/api';
import { type ReporteFormData } from '../../types/reporte.types';
import { type AxiosError } from 'axios';
export function useGenerateReportMutation(
  onSuccess?: (data: any) => void,
  onError?: (errors: Record<string, string>) => void
) {
  const mutation = useMutation({
    mutationFn: (data: ReporteFormData) => generateReporteApi(data),
    onSuccess: (data) => {
      if (onSuccess) onSuccess(data);
    },
    onError: (error: AxiosError<ApiErrorResponse>) => {
      const errors = parseApiErrors(error);
      if (onError) onError(errors);
    },
  });
  const {getErrorMessage, getValidationErrors}= useMutationApiErrors(mutation as any);
  return {
    mutate: async (data : any) => {
      try {
        await mutation.mutateAsync(data);
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
