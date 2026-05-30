/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import ShowModal from "@/app/shared/components/modal/ShowModal"
import { useCallback } from "react"
import { router } from "@inertiajs/react"
import { type PropietarioShowData, PropietarioIcons, PropietarioRoutes } from "../types/propietario.types"
import { BaseIcons } from "@/app/shared/types"
export default function ShowPropietarioModal({
    open,
    item,
    onClose
}:{
    open: boolean,
    item: PropietarioShowData | null
    onClose: () => void
}) {
    const handleOnClose= useCallback(() => {
        onClose()
        router.get(PropietarioRoutes.index(),{},{
          preserveState: true,
          preserveScroll: true
        })
    }, [onClose])
  return (
    <ShowModal
            tittle="Propietario"
              open={open}
              onClose={handleOnClose}
              item={item}
              icons={PropietarioIcons}
            >
              <ul className="flex flex-col w-full">
                <div className="flex gap-2 items-center">
                   <button className="bg-blue-200/20 p-2 rounded-3xl flex items-center " disabled={true}>
                        <i className={`${BaseIcons.cuenta ?? 'fa-solid fa-file'} `}></i>
                    </button>
                    <span className="font-bold capitalize">Cuentas : </span>
                </div>
                {item?.cuentas !== undefined && item !== null && item.cuentas?.length > 0   ? (
                  item.cuentas.map((cuenta) => (
                    <li key={cuenta.id} className="ml-10  list-decimal flex gap-2 items-center">
                      <span className=" capitalize">{cuenta.nombre}</span>
                    </li>
                  ))
                ):(
                  <p className="text-muted-foreground uppercase my-3">Sin cuentas</p>
                )}
              </ul>
            </ShowModal>
  )
}
