import Modal from '@/app/shared/components/modal/Modal'
import SuscriptorNotificacionForm from './SuscriptorNotificacionForm'
import useSuscriptorNotificacion from '../hooks/useSuscriptorNotificacion'
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
  options: SuscriptorNotificacionFormOptions
}) {
  const { form, handleSubmit } = useSuscriptorNotificacion({ method: 'post' })

  return (
    <Modal className='w-150! h-120!'  open={open} onClose={onClose} title={
    <div>
        <span className="text-blue-400 border-b-2 border-blue-500 rounded-lg">Crear</span>
        <span> Suscriptor</span>
    </div>}>
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
