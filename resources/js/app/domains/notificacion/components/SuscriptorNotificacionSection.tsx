import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import SuscriptorNotificacionTable from './SuscriptorNotificacionTable'
import CreateSuscriptorModal from './CreateSuscriptorModal'
import { useModalItem } from "@/app/shared/hooks"
import SecundaryDescription from "@/app/shared/components/common/SecundaryDescription";

import type { CanalNotificacion, SuscriptorNotificacion, SuscriptorNotificacionFormOptions } from '../types/notificacion.types'
import type { UsuarioForForm } from "../../user/types/user.types"

/**
 * Section de Suscriptores de Notificación.
 * contiene la tabla, la descripcion y sus modales
 * @param param0
 * @param param0.suscriptores - los registros de suscriptores
 * @constructor
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.1.0
 */
export default function SuscriptorNotificacionSection(
    {
        suscriptores,
    }: {
        suscriptores: SuscriptorNotificacion[]
    }) {
    const { item, modal, open, close, setItem } = useModalItem<SuscriptorNotificacion>()

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
      />

  </div>
}
