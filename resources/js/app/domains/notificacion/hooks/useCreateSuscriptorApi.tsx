import React from 'react'
import { useSuscriptorMutation } from './api/useSuscriptorMutation'
import type { InertiaForm } from 'node_modules/@inertiajs/react/types/useForm'
import type { SuscriptorApiResponse } from '../api/notificacion.api'
import type { AxiosError } from 'axios'
import type { ApiErrorResponse } from '@/app/shared/types/api'
import { toastHelper } from '@/app/shared/helpers'

interface UseCreateSuscriptorApiReturn {
    setVerifyingId: React.Dispatch<React.SetStateAction<string | null>>,
    setVerified: React.Dispatch<React.SetStateAction<boolean>>,
    form: InertiaForm<SuscriptorApiResponse>,
}

export default function useCreateSuscriptorApi({
    setVerifyingId,
    setVerified,
    form,
}: UseCreateSuscriptorApiReturn) {
  return useSuscriptorMutation({
    action: 'create',
    onSuccess: (data) => {
      if (data && 'id' in data) {
        setVerifyingId(data.id)
        const channel = window.Echo.private(`suscriptor.${data.id}`)

        channel.listen('.SuscriptorVerified', () => {
          setVerified(true)
          channel.stopListening('.SuscriptorVerified')
          window.Echo.leaveChannel(`suscriptor.${data.id}`)
        })
        toastHelper.success('Suscriptor creado. Esperando verificación...')
      }
    },

    onError: (err: AxiosError<ApiErrorResponse>) => {
      if (typeof err === 'object' && 'response' in err && err.response?.data?.errors) {
          console.log(err.response);
      }else{
          toastHelper.error('Error al crear suscriptor. Por favor, revisa los errores e intenta de nuevo.')
      }

    },
  })
}
