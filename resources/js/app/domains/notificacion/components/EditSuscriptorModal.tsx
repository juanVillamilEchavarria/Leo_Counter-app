import Modal from '@/app/shared/components/modal/Modal'
import SuscriptorNotificacionForm from './SuscriptorNotificacionForm'
import useSuscriptorNotificacion from '../hooks/useSuscriptorNotificacion'
import type { SuscriptorNotificacion, SuscriptorNotificacionFormOptions } from '../types/notificacion.types'

/**
 * Modal para editar un suscriptor de notificación.
 * Abre el formulario con método PUT y pasa las props individuales
 * (data, setData, errors, submit, processing) al formulario.
 * @param {object} props
 * @param {boolean} props.open - Si el modal está abierto
 * @param {Function} props.onClose - Callback para cerrar el modal
 * @param {SuscriptorNotificacionFormOptions} props.options - Opciones del formulario
 * @param {SuscriptorNotificacion | null} props.data - Datos del suscriptor a editar
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.1.0
 */
export default function EditSuscriptorModal({
  open,
  onClose,
  options,
  data
}: {
  open: boolean
  onClose: () => void
  options: SuscriptorNotificacionFormOptions
  data: SuscriptorNotificacion | null
}) {
  const { form, handleSubmit } = useSuscriptorNotificacion({
    method: 'put',
    id: data?.id ?? null,
    data: data ?? undefined
  })

  return (
    <Modal open={open} onClose={onClose} title="Editar suscriptor">
      <SuscriptorNotificacionForm
        data={form.data}
        setData={form.setData}
        errors={form.errors}
        submit={handleSubmit}
        processing={form.processing}
        options={options}
      />
    </Modal>
  )
}
