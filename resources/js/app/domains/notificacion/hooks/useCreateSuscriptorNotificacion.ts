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
import { useState } from 'react';
import { toastHelper } from '@/app/shared/helpers';
import useMutationApiErrors from '@/app/shared/hooks/api/useMutationApiErrors';
import { createSuscriptorApi } from '../api/notificacion.api';
import type { SuscriptorFormData } from '../types/notificacion.types';
import type { AxiosError } from 'axios';
import type { ApiErrorResponse } from '@/app/shared/types/api';

/**
 * Hook unificado para crear un suscriptor de notificación.
 * Combina el estado del formulario (useForm) con el envío (useMutation) y
 * gestiona la verificación por WebSocket (Echo) tras la creación.
 */
export function useCreateSuscriptorNotificacion() {
  const form = useForm<SuscriptorFormData>({
    user_id: '',
    canal_notificacion_id: '',
  });

  const [verifyingId, setVerifyingId] = useState<string | null>(null);
  const [verified, setVerified] = useState(false);

  const mutation = useMutation({
    mutationFn: (data: SuscriptorFormData) => createSuscriptorApi(data),
    onSuccess: (data) => {
      if (data && 'id' in data) {
        setVerifyingId(data.id);
        const echo = (window as any).Echo;
        const channel = echo.private(`suscriptor.${data.id}`);
        channel.listen('.SuscriptorVerified', () => {
          setVerified(true);
          channel.stopListening('.SuscriptorVerified');
          echo.leaveChannel(`suscriptor.${data.id}`);
          toastHelper.success('Suscriptor verificado');
        });
      }
    },
    onError: (error: AxiosError<ApiErrorResponse>) => {
      toastHelper.error(error.response?.data?.error || 'Error al crear suscriptor.');
    },
  });

  const { getErrorMessage, getValidationErrors } = useMutationApiErrors(mutation as any);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    form.clearErrors();
    mutation.mutate(form.data);
  };

  const reset = () => {
    form.reset();
    mutation.reset();
    setVerifyingId(null);
    setVerified(false);
  };

  return {
    form,
    handleSubmit,
    verifyingId,
    verified,
    reset,
    isPending: mutation.isPending,
    isSuccess: mutation.isSuccess,
    error: getErrorMessage(),
    validationErrors: getValidationErrors(),
  };
}