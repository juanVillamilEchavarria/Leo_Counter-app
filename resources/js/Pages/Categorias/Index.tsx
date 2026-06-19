/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.1
 */
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { CategoriaTable } from "@/app/domains/categoria"
import { Link } from "@inertiajs/react"
import { type CategoriaTableData, CategoriaRoutes } from "@/app/domains/categoria"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import { useModalItem } from "@/app/shared/hooks"
import useCategoria from "@/app/domains/categoria/hooks/useCategoria"
import SectionDescriptionWithDetails from "@/app/shared/components/common/SectionDescriptionWithDetails"

export default function Index({
  categorias
}:{
  categorias: {data :CategoriaTableData[]}
}) {
  const {item, modal, open, close}= useModalItem<CategoriaTableData>()
  const {handleSubmit}= useCategoria({method: 'delete', id: item?.id})
  const descriptionItems=[
    {
      title: '¿Que son las categorias?',
      description: 'Las categorias son etiquetas que puedes asignar a tus movimientos o presupuestos para organizarlos y clasificarlos, puedes crear categorias para tus gastos e ingresos y asi llevar un control mas detallado de tus finanzas',
      icon: 'fa-solid fa-tags !text-yellow-400'
    },
    {
      title: 'Frecuencia fija o no fija',
      description: 'Marca tus categorias como de frecuencia fija o no fija, las categorias de frecuencia fija son aquellas que representan un concepto recurrente (similar a movimientos fijos), y las categorias de frecuencia no fija son aquellas que usas ocasionalmente',
      icon: 'fa-solid fa-repeat !text-green-400'
    },
        {
      title : 'Restricciones de eliminacion',
      description: 'Las categorias no se eliminan directamente desde aqui, si la marcas como eliminada, se ira a la papelera en configuracion (solo puedes enviar a la papelera las categorias que tu registres, las que son propias del sistema no se eliminan), y desde alli, unicamente las que no tienen registros asociados podran ser eliminadas permanentemente (el acceso a configuracion es restringido unicamente para el administrador)',
      icon: 'fa-solid fa-ban !text-red-400'
    }
  ]

  return (
    <SectionTransition>
        <SectionDescriptionWithDetails 
        principalTitle="Categorias"
         paragraph="Gestiona Tus Categorias"
          items={descriptionItems}
          />
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
