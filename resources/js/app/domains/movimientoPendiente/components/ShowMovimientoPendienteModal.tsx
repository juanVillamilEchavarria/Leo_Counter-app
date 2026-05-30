/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import ShowModal from "@/app/shared/components/modal/ShowModal"
import SuccessOrFailText from "@/app/shared/components/common/SuccessOrFailText"
import { useCallback, useMemo } from "react"
import { router } from "@inertiajs/react"
import { BaseIcons } from "@/app/shared/types"
import { type MovimientoPendienteShowData, MovimientoPendienteRoutes, MovimientoPendienteIcons } from "../types/movimientoPendiente.types"

export default function ShowMovimientoPendienteModal({
  movimiento,
  onClose,
  open
}:{
  movimiento: MovimientoPendienteShowData | null,
  open: boolean
  onClose: () => void,
}){
  const handleOnClose= useCallback(() => {
    onClose()
    router.get(MovimientoPendienteRoutes.index(),{},{
      preserveState: true,
      preserveScroll: true
    })
  }, [onClose])

  const modalData = useMemo(() => {
  if (!movimiento) return null
  const { enough_balance, automatic, ...rest } = movimiento
  return rest
}, [movimiento])
  const enoughBalanceMsgTrue = 'Suficiente para realizar el movimiento'
  const enoughBalanceMsgFalse = 'Insuficiente'


  return (
    <ShowModal
      tittle="Movimiento Pendiente"
      open={ open }
      onClose={handleOnClose}
      item={modalData}
      icons={MovimientoPendienteIcons}
    >
      <div className="flex flex-col gap-2">
        <ul className="grid grid-cols-1 gap-4 my-4">
          {movimiento && movimiento.enough_balance !== null && movimiento.enough_balance !== undefined && movimiento.tipo_movimiento === 'GASTO' && (
            <li className="ml-2 text-lg flex gap-2 items-center">
              <button className="bg-blue-200/20 p-2 rounded-3xl flex items-center " disabled={true}>
                <i className={`${BaseIcons.cuenta ?? 'fa-solid fa-wallet'}`}></i>
              </button>
              <p className="capitalize font-bold">Saldo de la cuenta: </p>
              <p className="ml-2">
                <SuccessOrFailText attribute={movimiento.enough_balance ? enoughBalanceMsgTrue : enoughBalanceMsgFalse} value={enoughBalanceMsgTrue} />
              </p>
            </li>
          )}

          {movimiento && movimiento.movimiento_fijo ? (
            <li className="ml-2 text-lg flex gap-2 items-center">
              <button className="bg-blue-200/20 p-2 rounded-3xl flex items-center " disabled={true}>
                <i className={`fa-regular ${movimiento.automatic ? 'fa-circle-check text-green-400' : 'fa-circle-xmark text-red-400'} text-2xl`} />
              </button>
              <p className="capitalize font-bold">Se registra automáticamente</p>
            </li>
          ) : null}
        </ul>
      </div>
    </ShowModal>
  )
}
