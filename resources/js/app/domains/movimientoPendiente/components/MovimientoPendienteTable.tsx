import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import useMovimientoPendiente from "../hooks/useMovimientoPendiente"
import Button from "@/app/shared/components/common/Button"
import CrudButton from "@/app/shared/components/common/CrudButton"
import Modal from "@/app/shared/components/modal/Modal"
import { useSimpleTable } from "@/app/shared/hooks"
import { useDropzone, type FileRejection } from "react-dropzone"
import { useCallback } from "react"
import useMovimientoPendienteActions from "../hooks/useMovimientoPendienteActions"
import { MovimientoPendienteColumns } from "./columns/movimientoPendiente.columns"
import { type MovimientoPendienteTableData, type MarkAsDonePayload } from "../types/movimientoPendiente.types"
export default function MovimientoPendienteTable({
  data
}: {
  data: MovimientoPendienteTableData[]
}) {
  const config = useSimpleTable({
    data,
    pageSize: data.length,
    tableColumns: MovimientoPendienteColumns,
    formModelHook: useMovimientoPendiente
  })
    const {markAsDone, setData, data: formFiles}= useMovimientoPendienteActions<MarkAsDonePayload>()
  const {
    data: paginatedData,
    columns,
    handleDelete,
    itemSelected,
    modalSelected,
    setItemSelected,
    setModalSelected
  } = config
  // dropzone
    const onDrop = useCallback((acceptedFiles : File[], rejectedFiles : FileRejection[]) => {
      const files = acceptedFiles.map(file => {
        return {
          ...file,
          preview: URL.createObjectURL(file)
        }
      })
      setData('comprobantes', files)
      console.log(acceptedFiles);
      console.log(rejectedFiles);
  }, [])
  const onDropRejected = useCallback((fileRejections : FileRejection[]) => {
    setData('comprobantes', [])
  },[])
  const {getRootProps, getInputProps, isDragActive, acceptedFiles, fileRejections} = useDropzone({onDrop, accept:{'application/pdf': []}, maxFiles: 3, onDropRejected})
  
  console.log(formFiles);

  const handleMarkAsDone = async (e : React.FormEvent<HTMLFormElement>) => {
    e.preventDefault()
    if(!itemSelected) return 
    await markAsDone(itemSelected.id)
    setItemSelected(null)
    setModalSelected(null)
  }
  return (
    <>
      <SimpleTable
        data={paginatedData}
        columns={columns}
        pagination={false}
      />
      <DeleteModal
        open={itemSelected !== null && modalSelected === 'delete'}
        spanTitle="Eliminar"
        title='Movimiento Pendiente'
        onClose={() => {setItemSelected(null); setModalSelected(null)}}
        paragraph={`¿Esta seguro de eliminar el Movimiento Pendiente con ID: ${itemSelected?.id} ?`}
        onSubmit={handleDelete}
      >
        <span>Los movimientos pendientes eliminados estaran en la configuracion del sistema</span>
      </DeleteModal>
      <Modal
      size="lg"
       title={(
        <p>Marcar como <span className="text-green-400 border-b-2 border-green-400 rounded-lg">realizado</span></p>
       )}
       open={itemSelected !== null && modalSelected === 'pagar'}
       onClose={() => {setItemSelected(null); setModalSelected(null)}}
       className="h-125 overflow-y-scroll scrollbar-modern"
      >
        <p>Estas seguro de marcar el movimiento pendiente "<span className="font-bold">{itemSelected?.nombre}</span>" como realizado?</p>
        <small>Asegurate antes de esta accion, que realmente el movimiento haya sido realizado. Los Movimientos Pendientes realizados estaran en la tabla de movimientos</small>
          <form onSubmit={handleMarkAsDone} >
              <div className="formulario-campo">
                <div className="w-full flex justify-between">
                   <label >Adjuntar comprobante ~ <small>Este campo es opcional (maximo 3 archivos)</small></label>
                   <div className="w-1/12">
                       <button 
                       type="button"
                       onClick={()=>{setData('comprobantes', [])}}
                        >
                        <i className="fa-solid fa-ban text-2xl text-red-400 hover:text-red-700 transition-all cursor-pointer"></i>
                       </button>
                       </div>
                </div>
              
                
                <div {...getRootProps()} className="bg-white/20 p-2 rounded-lg border-2 border-gray-500 border-dashed hover:bg-white/10 cursor-pointer">
                  <input {...getInputProps()} />
                  <div className="w-full flex flex-col items-center relative">
              
                    
                    
                      <i className="fa-solid fa-image text-4xl"></i> 
                      <p className="font-2xl">Arrastra o selecciona un archivo</p>
                          <div className="w-full flex flex-col">
                          <p className="text-gray-400 font-bold">Archivos subidos:</p>
                          {formFiles.comprobantes && formFiles.comprobantes?.length> 0 ?
                            formFiles.comprobantes.map((file, index) => (
                              <div key={index}>
                                <p>{file.path} - {file.size} bytes</p>
                              </div>
                            ))
                            :
                            <p className="text-gray-400">No se han subido archivos</p>
                          }
                          </div>
                  </div>
                 

                  
                </div>
              </div>
                      <div className="flex w-2/3 mx-auto mt-7 gap-2">
                        <Button
                        type="button"
                        variant="gray"
                        onClick={() => {setItemSelected(null); setModalSelected(null)}}
                        >
                          <span className="text-sm">No, cancelar</span>
                        </Button>
                      <Button
                      type="submit"
                      variant="success"
                      ><span className="text-sm">Si, marcar como realizado</span></Button>
                      </div>
                    </form>

      </Modal>
    </>
  )
}
