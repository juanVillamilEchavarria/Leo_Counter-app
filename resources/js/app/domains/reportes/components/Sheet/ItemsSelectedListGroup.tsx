import ItemSelectedList from "@/app/shared/components/common/ItemSelectedList"
import {type  Cuenta } from "@/app/domains/cuenta"
import { type Categoria } from "@/app/domains/categoria"


interface ItemSelectedListGroupProps {
    cuentas: Cuenta[] | undefined
    categorias: Categoria[] | undefined
    only_categorias_fijas: boolean
    removeCuenta: (id: number) => void
    removeCategoria: (id: number) => void
}
export default function ItemsSelectedListGroup({
    cuentas,
    categorias,
    only_categorias_fijas,
    removeCuenta,
    removeCategoria,
}: ItemSelectedListGroupProps) {
  return (
    <div className="flex flex-col gap-2">
        <p className="text-sm text-muted-foreground">Cuentas seleccionadas:</p>
        <div className="">
         <ItemSelectedList iterable={cuentas} removeItem={removeCuenta} emptyMessage="No hay cuentas seleccionadas" />
        </div>
        <p className="text-sm text-muted-foreground">Categorias seleccionadas:</p>
        <div className="">
         <ItemSelectedList iterable={categorias} removeItem={removeCategoria}>
          {only_categorias_fijas === true ? (
            <p className="text-sm text-blue-500 bg-blue-100 rounded-full px-3 py-1">Todas las categorias fijas seleccionadas</p>
          ):(
            <p className="text-sm text-muted-foreground">No hay categorias seleccionadas</p>
          )}
          </ItemSelectedList>
        </div>
      </div>
  )
}
