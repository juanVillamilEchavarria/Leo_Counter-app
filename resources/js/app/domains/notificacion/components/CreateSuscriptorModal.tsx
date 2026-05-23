import Modal from '@/app/shared/components/modal/Modal'
import SuscriptorNotificacionForm from './SuscriptorNotificacionForm'
import useSuscriptorNotificacion from '../hooks/requests/useSuscriptorNotificacion'
import VerificationPending from "@/app/domains/notificacion/components/VerificationPending";
import VerificationSuccess from "@/app/domains/notificacion/components/VerificationSuccess";
import useCreateSuscriptorApi from '../hooks/useCreateSuscriptorApi';
import useSuscriptorVerify from '../hooks/useSuscriptorVerify';
import { useCallback, useMemo } from 'react';
import { selectedChannel, selectedUser } from '../helpers/notificacion.helpers';
import type { SuscriptorNotificacionFormOptions } from '../types/notificacion.types'

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
  options
}: {
  open: boolean
  onClose: () => void
  options : SuscriptorNotificacionFormOptions
}) {
  const {form}= useSuscriptorNotificacion({ method: 'post' })

 const {setVerified, verifyingId, setVerifyingId, verified} = useSuscriptorVerify();

  const { mutate, isPending, validationErrors, reset } = useCreateSuscriptorApi({
      setVerifyingId: setVerifyingId,
      setVerified: setVerified,
      form: form
    })
    const handleClose = useCallback(() => {
    reset()
    form.reset()
    setVerifyingId(null)
    setVerified(false)
    onClose()
  }, [reset, form, onClose])

  const mergedErrors = useMemo(() => ({ ...form.errors, ...validationErrors }), [form.errors, validationErrors])

   const handleSubmit = useCallback((e: React.FormEvent) => {
    e.preventDefault()
    form.clearErrors()
    mutate(form.data)
  }, [form, mutate])
  const userName = selectedUser(form, options)?.name ?? 'Usuario'
  const channelName = selectedChannel(form, options)?.nombre ?? 'Canal'




  return (
    <Modal className='w-150! h-120!'  open={open} onClose={onClose} title={
    <div>
        <span className="text-blue-400 border-b-2 border-blue-500 rounded-lg">Crear</span>
        <span> Suscriptor</span>
    </div>}>
        {verifyingId ? (
            !verified ? (
                <VerificationPending userName={userName} channelName={channelName}/>
            ) : (
                <VerificationSuccess userName={userName} onClose={handleClose}/>
            )
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
