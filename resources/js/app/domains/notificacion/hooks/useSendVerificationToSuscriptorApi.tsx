/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import React from 'react'
import { useSuscriptorMutation } from './api/useSuscriptorMutation'
import type { AxiosError } from 'axios'
import type { ApiErrorResponse } from '@/app/shared/types/api'
import { toastHelper } from '@/app/shared/helpers'
import type {SuscriptorApiAction, SuscriptorFormData} from "@/app/domains/notificacion";

interface useSendVerificationToSuscriptorApiReturn {
    setVerifyingId: React.Dispatch<React.SetStateAction<string | null>>,
    setVerified: React.Dispatch<React.SetStateAction<boolean>>,
    action?: SuscriptorApiAction
}

export default function useSendVerificationToSuscriptorApi({
    setVerifyingId,
    setVerified,
    action = 'create',
}: useSendVerificationToSuscriptorApiReturn) {
  return useSuscriptorMutation({
    action: action,
    onSuccess: (data) => {
      if (data && 'id' in data) {
        setVerifyingId(data.id)
          const channel = window.Echo.private(`suscriptor.${data.id}`);
          channel.listen('.SuscriptorVerified', () => {
              setVerified(true);
              channel.stopListening('.SuscriptorVerified');
              window.Echo.leaveChannel(`suscriptor.${data.id}`);
              toastHelper.success('Suscriptor verificado')
          });
        toastHelper.success('Suscriptor creado. Esperando verificación...')
      }
    },

    onError: (err: AxiosError<ApiErrorResponse>) => {
          const message = err.response?.data?.error || 'Error al crear suscriptor.';
          if(err.response?.data) toastHelper.error(message)

    },
  })
}
