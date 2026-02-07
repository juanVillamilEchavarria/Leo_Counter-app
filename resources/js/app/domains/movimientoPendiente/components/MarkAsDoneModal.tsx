import Modal from "@/app/shared/components/modal/Modal"
import Button from "@/app/shared/components/common/Button";
import DropZone from "@/app/shared/components/dropZone/DropZone";
import ErrorList from "@/app/shared/components/dropZone/ErrorList";
import UploadedFileList from "@/app/shared/components/dropZone/UploadedFileList";
import useMarkAsDone from "../hooks/useMarkAsDone";
import { type MovimientoPendienteShowData } from "../types/movimientoPendiente.types";
export default function MarkAsDoneModal({
    open,
    onClose,
    onSubmit,
    itemSelected,
}:{
    open: boolean,
    onClose: () => void,
    onSubmit: () => void,
    itemSelected: MovimientoPendienteShowData | undefined| null,
}) {
    const {
     onDrop,
    onDropRejected,
    handleOnClose,
    handleMarkAsDone,
    rejectedFiles,
    DeleteFile,
     formFiles,
    setData
  } = useMarkAsDone({onClose, onSubmit, itemSelected})
  return (
    <Modal
        size="lg"
        title={(
        <p>Marcar como <span className="text-green-400 border-b-2 border-green-400 rounded-lg">realizado</span></p>
        )}
        open={open}
        onClose={handleOnClose}
        className="h-125 overflow-y-scroll scrollbar-modern"
    >
    <p>Estas seguro de marcar el movimiento pendiente "<span className="font-bold">{itemSelected?.nombre}</span>" como realizado?</p>
    <small>Asegurate antes de esta accion, que realmente el movimiento haya sido realizado. Los Movimientos Pendientes realizados estaran en la tabla de movimientos</small>
        <form onSubmit={handleMarkAsDone} >
            <div className="formulario-campo">
                <div className="w-full flex justify-between">
                    <label >Adjuntar comprobante ~ <small>Este campo es opcional (maximo 3 archivos)</small></label>
                <div className="w-1/12">
                    {formFiles.comprobantes && formFiles.comprobantes?.length> 0 &&(
                        <button 
                        type="button"
                        onClick={()=>{
                            setData('comprobantes', [])
                        }}
                            >
                            <i className="fa-solid fa-trash text-xl text-red-400 hover:text-red-700 transition-all cursor-pointer"></i>
                        </button>
                    )}
                    </div>
                </div>


            <DropZone 
                onDrop={onDrop} 
                onDropRejected={onDropRejected} 
                rejectedFiles={rejectedFiles} 
            />
            <ErrorList rejectedFiles={rejectedFiles} />

                <div className="w-full flex flex-col">
                    <p className="text-gray-400 font-bold">Archivos subidos:</p>
                    {formFiles.comprobantes && formFiles.comprobantes?.length> 0 ?
                    <UploadedFileList
                    files={formFiles.comprobantes}
                    handleDeleteFile={DeleteFile}
                    />
                    :
                    <p className="text-gray-400">No se han subido archivos</p>
                    }
                </div>
            </div>
            <div className="flex w-2/3 mx-auto mt-7 gap-2">
                <Button
                type="button"
                variant="gray"
                onClick={handleOnClose}
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
  )
}
