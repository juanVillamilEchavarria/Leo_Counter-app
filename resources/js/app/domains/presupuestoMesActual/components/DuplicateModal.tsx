/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import Modal from "@/app/shared/components/modal/Modal"
import Button from "@/app/shared/components/common/Button"
import usePresupuestoMesActualActions from "../hooks/usePresupuestoMesActualActions"
import { type PresupuestoMesActualTableData } from "../types/presupuestoMesActual.types"

export default function DuplicateModal({
    onClose,
    open,
    itemSelected
}:{
    onClose: () => void,
    open: boolean,
    itemSelected: PresupuestoMesActualTableData | undefined | null
}) {
      const { duplicate } = usePresupuestoMesActualActions()
    
      const handleDuplicate = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault()
        if (!itemSelected) return
        duplicate(itemSelected.id)
        onClose()
      }
    
  return (
    <Modal
          open={open}
          onClose={onClose}
          size="lg"
          className="overflow-y-scroll scrollbar-modern"
          title={
            (
              <p><span className="text-green-400 border-b-2 border-green-500 rounded-lg">Duplicar ~</span> presupuesto</p>
            )
          }
          
          >
            <div className="flex flex-col gap-2 my-3">
              <p>¿Estas seguro de duplicar para el proximo mes el presupuesto de : <span className="font-bold">{itemSelected?.categoria}</span>?</p>
              <small><i className="fa-solid fa-circle-exclamation text-amber-400"></i> Si lo duplicas, para modificarlo deberas esperar a que aparezca el mes siguiente</small>
              <small>El presupuesto duplicado se creara con el mismo monto. Esta accion esta pensada para casos extraordinarios donde sepas que el proximo mes seguramente tendras el mismo presupuesto</small>
              <form onSubmit={handleDuplicate}>
                 <div className="flex w-full flex-col mx-auto mt-7 gap-2 sm:w-2/3 sm:flex-row">
                                <Button
                                type="button"
                                variant="gray"
                                onClick={onClose}
                                >
                                  no, cancelar
                                </Button>
                              <Button
                              type="submit"
                              variant="success"
                              >Si, duplicar</Button>
                              </div>
    
              </form>
            </div>
    
          </Modal>
  )
}
