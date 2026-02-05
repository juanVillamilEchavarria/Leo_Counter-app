import ShowModal from "@/app/shared/components/modal/ShowModal"
import { useMemo } from "react"
import { ArchivoMovimientoRoutes } from "../../archivoMovimiento"
import { BaseIcons } from "@/app/shared/types"
import { type MovimientoShowData } from "../types/movimiento.types"
export default function MovimientoShowModal({
    movimiento,
    onClose,
}:{
    movimiento: MovimientoShowData | null,
    onClose: () => void,
}) {
    const comprobantes = useMemo(()=>{
        return movimiento?.comprobantes
    }, [movimiento])
    console.log(comprobantes);
  return (
    <ShowModal
    tittle="Movimiento"
    open={movimiento !== null}
    onClose={()=> onClose()}
    item={movimiento}
    > 
          
           
            <div className="flex flex-col gap-2">
                        <div className="flex gap-2 items-center">
                        <button className="bg-blue-200/20 p-2 rounded-3xl flex items-center " disabled={true}>
                            <i className={`${BaseIcons.comprobante ?? 'fa-solid fa-file'} `}></i>
                        </button>
                        <span className="font-bold capitalize">Comprobantes : </span>
                        </div>
                        <ul className="grid grid-cols-2 ">
                            {comprobantes && Object.keys(comprobantes).length > 0 ? (Object.entries(comprobantes).map(([key, value]) => (
                            <li
                                key={key}
                                className=" p-4 rounded-2xl  flex flex-col gap-2 scrollbar-modern"
                            >
                                <div className="flex w-full justify-between items-center gap-3">
                                <div className="flex items-center gap-2">
                                    <i className="fa-solid fa-file-pdf text-red-500 text-xl" />
                                    <p className="text-sm">{value.nombre}</p>
                                </div>
                                <div className="flex justify-between">
                                <a href={ArchivoMovimientoRoutes.movimientosArchivosShow(value.id)} target="_blank" rel="noreferrer noopener" >
                                    <i className="fa-solid fa-eye "></i>
                                </a>
                                    <a href={ArchivoMovimientoRoutes.movimientosArchivosDowland(value.id)} target="_blank">
                                    <i className="fa-solid fa-download"></i>
                                </a>

                                </div>
                                </div>
                                
                            </li>
                            ))): (
                                <p className="text-gray-400 uppercase">No hay comprobantes</p>
                            )}
                        </ul>
                    
                    </div> 
    </ShowModal>
  )
}
