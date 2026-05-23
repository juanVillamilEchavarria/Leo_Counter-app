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
      if (typeof err === 'object' && 'response' in err && err.response?.data?.errors) {
          console.log(err.response);
      }else{
          if(err.response?.data.message) toastHelper.error(err.response.data.message)
      }

    },
  })
}
