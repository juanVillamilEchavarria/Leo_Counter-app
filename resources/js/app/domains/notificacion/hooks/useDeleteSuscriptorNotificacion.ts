/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */
import { useMutation } from '@tanstack/react-query';
import { toastHelper } from '@/app/shared/helpers';
import useMutationApiErrors from '@/app/shared/hooks/api/useMutationApiErrors';
import { deleteSuscriptorApi } from '../api/notificacion.api';
import type { AxiosError } from 'axios';
import type { ApiErrorResponse } from '@/app/shared/types/api';

/**
 * Hook unificado para eliminar un suscriptor de notificación.
 * Solo usa useMutation (no requiere formulario).
 */
export function useDeleteSuscriptorNotificacion() {
  const mutation = useMutation({
    mutationFn: (id: string) => deleteSuscriptorApi(id),
    onSuccess: () => {
      toastHelper.success('Suscriptor eliminado');
    },
    onError: (error: AxiosError<ApiErrorResponse>) => {
      toastHelper.error('Error al eliminar suscriptor');
    },
  });

  const { getErrorMessage } = useMutationApiErrors(mutation as any);

  const handleDelete = (id: string) => {
    mutation.mutate(id);
  };

  return {
    handleDelete,
    isPending: mutation.isPending,
    isSuccess: mutation.isSuccess,
    error: getErrorMessage(),
  };
}