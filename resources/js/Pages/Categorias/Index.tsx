/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { CategoriaTable } from "@/app/domains/categoria"
import { Link } from "@inertiajs/react"
import { type CategoriaTableData, CategoriaRoutes } from "@/app/domains/categoria"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import { useModalItem } from "@/app/shared/hooks"
import useCategoria from "@/app/domains/categoria/hooks/useCategoria"

export default function Index({
  categorias
}:{
  categorias: {data :CategoriaTableData[]}
}) {
  const {item, modal, open, close}= useModalItem<CategoriaTableData>()
  const {handleSubmit}= useCategoria({method: 'delete', id: item?.id})

  return (
    <SectionTransition>
        <SectionDescription title="Categorias" paragraph="Gestiona Tus Categorias" />
        <CreateButtonSection>
          <CrudButton
           as={Link}
           href={CategoriaRoutes.create()}
           icon="fa-solid fa-tag"
          
          >
          </CrudButton>
        </CreateButtonSection>
        <CategoriaTable data={categorias.data} onSelect={(item, modalType)=>open(item,modalType)} />
        
        <DeleteModal
          open={item !== null && modal === 'delete'}
          onClose={close}
          onSubmit={handleSubmit}
          spanTitle={'Eliminar'}
          title={' Categoria'}
          paragraph={`¿Esta seguro de eliminar la Categoria: ${item?.nombre} ?`}
        >
          <small>las categorias eliminadas estaran en la configuracion del sistema</small>
        </DeleteModal>
    </SectionTransition>
  )
}
