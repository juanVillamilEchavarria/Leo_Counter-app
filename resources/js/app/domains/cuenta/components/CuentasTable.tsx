import EditAndDeleteActions from "@/app/shared/components/table/EditAndDeleteActions"
import ToggleState from "@/app/shared/components/table/ToggleState";
import { useState } from "react";
export default function CuentasTable() {
  const [active, setActive] = useState(false)
  return (
      <div className="table-container min-w-200">
        <table className="table-general">
            <thead className="table-thead">
                <tr>
                    <th >ID</th>
                    <th >Nombre</th>
                    <th >Saldo Inicial</th>
                    <th >Saldo Actual</th>
                    <th >tipo de cuenta</th>
                    <th >Notas</th>
                    <th >Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody className="table-tbody">
              <tr >
                <td >1</td>
                <td >Cuenta 1</td>
                <td >1000</td>
                <td >2000</td>
                <td >Ahorro</td>
                <td >Notas</td>
                <td className="p-0 w-1/8" >
                    <ToggleState active={active} setActive={setActive} />
                  
                </td>
                <td >
                     <EditAndDeleteActions />
                </td>
              </tr>
               <tr >
                <td >1</td>
                <td >Cuenta 1</td>
                <td >1000</td>
                <td >2000</td>
                <td >Ahorro</td>
                <td >Notas</td>
                <td className="p-0 w-1/8" >
                    <ToggleState active={active} setActive={setActive} />
                  
                </td>
                <td >
                    <EditAndDeleteActions />
                </td>
              </tr>

            </tbody>
        </table>
    </div>
  )
}
