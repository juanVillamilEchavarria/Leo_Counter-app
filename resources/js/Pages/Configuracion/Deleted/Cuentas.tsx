import ConfiguracionNavBar from "@/app/domains/configuracion"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import DeletedCuentaTable from "@/app/domains/configuracion/components/table/deleted/DeletedCuentaTable"
import Title from "@/app/shared/components/common/Title"
import { useModalItem } from "@/app/shared/hooks"
import { type Cuenta } from "@/app/domains/cuenta"
export default function Cuentas({
    data
}:{
    data: Cuenta[]
}) {

  const {item, modal, open, close}= useModalItem<Cuenta>()

  console.log(data)
  console.log(item)
  console.log(modal)
  return (
    <SectionTransition>
      <ConfiguracionNavBar />
      <div className="mt-10 flex flex-col gap-5">
        <Title title="Cuentas Eliminadas" as={'h1'} size="3xl" />
        <DeletedCuentaTable data={data} onSelect={(item, modal) => open(item, modal)} />
        </div>
    </SectionTransition>
  )
}
