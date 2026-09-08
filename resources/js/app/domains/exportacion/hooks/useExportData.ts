/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */
import { useForm } from '@inertiajs/react';
import { useMutation } from '@tanstack/react-query';
import { parseApiErrors, toastHelper } from '@/app/shared/helpers';
import { downloadBlob } from '@/app/shared/helpers/downloadBlob.helper';
import { exportDataApi } from '../api/exportacion.api';
import type {
  ExportableTableKey,
  ExportFormData,
  ExportParams,
} from '../types/exportacion.types';
import type { ServerSideFilters } from '@/app/shared/types/components/common/table.types';
import type { ApiErrorResponse } from '@/app/shared/types/api';
import type { AxiosError } from 'axios';

interface UseExportDataProps {
  table: ExportableTableKey;
  totalRecords: number;
  filters?: ServerSideFilters;
  visibleIds?: string[];
  onSuccess?: () => void;
  onError?: (error: AxiosError<ApiErrorResponse>) => void;
}

/**
 * Hook unificado para exportar datos.
 * Combina el estado del formulario (useForm) con el envío de la petición
 * (useMutation) y gestiona la descarga del blob resultante.
 */
export function useExportData({
  table,
  filters,
  visibleIds,
  onSuccess,
  onError,
}: UseExportDataProps) {
  const form = useForm<ExportFormData>({
    format: 'csv',
    filename: '',
    only_current_page: false,
  });

  const mutation = useMutation({
    mutationFn: (params: ExportParams) => exportDataApi(params),
    onSuccess: (blob) => {
      downloadBlob(blob, form.data.filename.trim() || table, form.data.format);
      toastHelper.success('Exportación generada correctamente');
      onSuccess?.();
      reset();
    },
    onError: (error: AxiosError<ApiErrorResponse>) => {
      const responseData = error.response?.data as any;
      const message = 
      responseData?.error ||      
      responseData?.message ||    
      error.response?.statusText ||
      'Error desconocido';

      toastHelper.error(message);
      onError?.(error);
    },
  });

  const handleExport = () => {
    const params: ExportParams = {
      table,
      format: form.data.format,
      only_current_page: form.data.only_current_page,
      filename: form.data.filename.trim() || undefined,
      filters,
      visibleIds: form.data.only_current_page ? visibleIds : undefined,
    };
    mutation.mutate(params);
  };

  const reset = () => {
    form.reset();
    mutation.reset();
  };

  return {
    form,
    handleExport,
    isExporting: mutation.isPending,
    isSuccess: mutation.isSuccess,
    error: mutation.error,
    reset,
  };
}