import Modal from '@/app/shared/components/modal/Modal'
import SuscriptorNotificacionForm from './SuscriptorNotificacionForm'
import useSuscriptorNotificacion from '../hooks/useSuscriptorNotificacion';
import useSendVerificationToSuscriptorApi from '../hooks/useSendVerificationToSuscriptorApi';
import useSuscriptorVerify from '../hooks/useSuscriptorVerify';
import {useCallback, useEffect, useMemo, useState} from 'react';
import { selectedChannel, selectedUser } from '../helpers/notificacion.helpers';
import type {CanalNotificacion, SuscriptorNotificacionFormOptions} from '../types/notificacion.types'
import useSuscriptorNotificacionFormOptionsApi
    from "@/app/domains/notificacion/hooks/api/useSuscriptorNotificacionFormOptionsApi";
import type {UsuarioForForm} from "@/app/domains/user/types/user.types";
import VerificationPendingOrSuccesMessage from './VerificationPendingOrSuccesMessage';
import {router} from "@inertiajs/react";
import {ConfiguracionRoutes} from "@/app/domains/configuracion";

/**
 * Modal para crear un suscriptor de notificación.
 * Abre el formulario con método POST y pasa las props individuales
 * (data, setData, errors, submit, processing) al formulario.
 * @param {object} props
 * @param {boolean} props.open - Si el modal está abierto
 * @param {Function} props.onClose - Callback para cerrar el modal
 * @param {SuscriptorNotificacionFormOptions} props.options - Opciones del formulario
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.1.0
 */
export default function CreateSuscriptorModal({
  open,
  onClose,
}: {
  open: boolean
  onClose: () => void
}) {
    const {form} = useSuscriptorNotificacion()
    const {setVerified, verifyingId, setVerifyingId, verified} = useSuscriptorVerify();
    const {mutate, isPending, validationErrors, reset} = useSendVerificationToSuscriptorApi({
        setVerifyingId: setVerifyingId,
        setVerified: setVerified,
        action: 'create',
    })
    const handleClose = useCallback(() => {
        reset()
        form.reset()
        setVerifyingId(null)
        setVerified(false)
        onClose()
        router.visit(ConfiguracionRoutes.index, {
            preserveScroll: true,
            preserveState: false,
        })
    }, [reset, form, onClose])

    const mergedErrors = useMemo(() => ({...form.errors, ...validationErrors}), [form.errors, validationErrors])

    const handleSubmit = useCallback((e: React.FormEvent) => {
        e.preventDefault()
        form.clearErrors()
        mutate(form.data)
    }, [form, mutate])
    const { data: optionsData } = useSuscriptorNotificacionFormOptionsApi({ enabled: open });
    const [options, setOptions] = useState<SuscriptorNotificacionFormOptions>({} as SuscriptorNotificacionFormOptions);
    useEffect(() => {
        if (optionsData) {
            setOptions({
                canales: optionsData.canales || [],
                usuarios: optionsData.usuarios || []
            });
        }
    }, [optionsData]);
  const userName = selectedUser(form, options)?.name ?? 'Usuario'
  const channelName = selectedChannel(form, options)?.nombre ?? 'Canal'


  return (
    <Modal className={`${verifyingId ? 'w-90! h-80!' : 'w-150! h-120!'} `} open={open} onClose={handleClose} title={
    <div>
        <span className="text-blue-400 border-b-2 border-blue-500 rounded-lg">Crear</span>
        <span> Suscriptor</span>
    </div>}>
        {verifyingId ? (
           <VerificationPendingOrSuccesMessage
               userName={userName}
               channelName={channelName}
               verified={verified}
               handleClose={handleClose}
           />
        ) : (
            <SuscriptorNotificacionForm
                data={form.data}
                setData={form.setData}
                errors={mergedErrors}
                submit={handleSubmit}
                processing={isPending}
                options={options}
            />
        )}
    </Modal>
  )
}
