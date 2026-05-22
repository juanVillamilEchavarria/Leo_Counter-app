import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import SuscriptorNotificacionTable from './SuscriptorNotificacionTable'
import CreateSuscriptorModal from './CreateSuscriptorModal'
import EditSuscriptorModal from './EditSuscriptorModal'
import { useModalItem } from "@/app/shared/hooks"
import useSuscriptorNotificacion from '../hooks/useSuscriptorNotificacion'
import SecundaryDescription from "@/app/shared/components/common/SecundaryDescription";
import type { CanalNotificacion, SuscriptorNotificacion, SuscriptorNotificacionFormOptions } from '../types/notificacion.types'

/**
 * Section de Suscriptores de Notificación.
 * contiene la tabla, la descripcion y sus modales
 * @param param0
 * @param param0.suscriptores - los registros de suscriptores
 * @param param0.options - las opciones del formulario
 * @constructor
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.1.0
 */
export default function SuscriptorNotificacionSection(
    {
        suscriptores,
        options
    }: {
        suscriptores: SuscriptorNotificacion[]
        options: SuscriptorNotificacionFormOptions
    }) {
    const { item, modal, open, close, setItem } = useModalItem<SuscriptorNotificacion>()
    const { handleSubmit } = useSuscriptorNotificacion({ method: 'delete', id: item?.id })
  return <div>
      {/* ── Suscriptores de Notificación ── */}
      <div className="mt-10">
          <SecundaryDescription
              title="Suscriptores"
              paragraph="Gestiona los suscriptores de notificaciones por canal"
          />
          <CreateButtonSection>
              <CrudButton
                  icon="fa-solid fa-bell"
                  onClick={() => open(null, 'create')}
              />
          </CreateButtonSection>

          <div className="overflow-scroll scrollbar-modern">
              <SuscriptorNotificacionTable
                  data={suscriptores}
                  onSelect={(item, modalType) => open(item, modalType)}
              />
          </div>
      </div>

      {/* ── Modal: Crear Suscriptor ── */}
      <CreateSuscriptorModal
          open={modal === 'create'}
          onClose={close}
          options={options}
      />

      {/* ── Modal: Editar Suscriptor ── */}
      <EditSuscriptorModal
          open={item !== null && modal === 'edit'}
          onClose={close}
          options={options}
          data={item}
      />

      {/* ── Modal: Eliminar Suscriptor ── */}
      <DeleteModal
          open={item !== null && modal === 'delete'}
          onClose={close}
          onSubmit={(e) => { handleSubmit(e); setItem(null) }}
          title=" Suscriptor"
          paragraph={`¿Está seguro de eliminar el suscriptor: ${item?.user?.name ?? item?.user_id}?`}
      >
          <small>Esta acción no se puede deshacer</small>
      </DeleteModal>
  </div>
}
