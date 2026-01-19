import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import useCategoria from "../hooks/useCategoria"
import { useMemo, useState } from "react"
import { useSimplePagination } from "@/app/shared/hooks"
import { CategoriaColumns } from "./columns/categoria.columns"
import { type Categoria } from "../types/categoria.types"
export default function CategoriaTable({
  data,
  pageSize = 10
}:{
  data: Categoria[],
  pageSize?: number
}) {
    const [categoriaSelected, setCategoriaSelected]= useState<Categoria|null>(null)
      const columns = useMemo(()=>{
           return CategoriaColumns({
               onDelete: (categoria: Categoria)=>{
                   setCategoriaSelected(categoria)
               }
           })
         }, []) 
    const {form, handleSubmit}= useCategoria({method:'delete', id:categoriaSelected?.id})
  const handleDelete = (e: React.FormEvent<HTMLFormElement>)=>{
      if(!categoriaSelected) return
      handleSubmit(e)
      setCategoriaSelected(null)
  }
  const pagination = useSimplePagination(data.length, 10)
    const start = pagination.page * pageSize //es el inicio de donde se va a tomar el registro, ejemplo, si la pagina es 0 y el pageSize es 10, entonces el start es 0
    const end = start + pageSize // es el final de donde se va a tomar el registro, por ejemplo si el start es 0 y el pageSize es 10, entonces el end es 10
    const paginatedData = data.slice(start, end) // es el array que se va a mostrar en la tabla
  return (
    <>
     <SimpleTable
           data={paginatedData}
           columns={columns}
           pagination={true}
           controller={pagination}
       
        />
        <DeleteModal
        open={categoriaSelected !== null}
        onClose={()=> setCategoriaSelected(null)}
         onSubmit={handleDelete}
        spanTitle={'Eliminar'}
        title={' Categoria'}
        paragraph={`¿Esta seguro de eliminar la Categoria: ${categoriaSelected?.nombre} ?`}
        >
          <small>las categorias no pueden ser recuperadas, si esta categoria esta asociada a algun tipo de movimiento fijo, considera inmediatamente luego de esta accion asignar una categoria a dicho movimiento</small>
        </DeleteModal>
     </>
  )
}
