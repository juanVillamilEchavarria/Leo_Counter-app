import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import SuscriptorNotificacionTable from './SuscriptorNotificacionTable'
import CreateSuscriptorModal from './CreateSuscriptorModal'
import { useModalItem } from "@/app/shared/hooks"
import SecundaryDescription from "@/app/shared/components/common/SecundaryDescription";
import { type SuscriptorTableData } from "../types/notificacion.types"
import useDeleteSuscriptor from "../hooks/useDeleteSuscriptor"
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
        suscriptores: SuscriptorTableData[]
    }) {
    const { item, modal, open, close, setItem } = useModalItem<SuscriptorTableData>()
    const {handleDelete} = useDeleteSuscriptor({
        id: item?.id || ''
    })
    

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
      <DeleteModal
          open={modal === 'delete' && item !== null}
          onClose={close}
          title="Suscriptor"
          paragraph={
            <div>
                <p>¿Estás seguro de eliminar La suscripcion de <span className="font-bold">{item?.usuario}</span> para el canal <span className="font-bold">{item?.canal}</span> ?</p>
            </div>
          }
          onSubmit={(e) => {
                handleDelete(e)
                close()
          }}
      >
      </DeleteModal>

  </div>
}
