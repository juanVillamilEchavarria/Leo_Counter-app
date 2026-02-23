import { Area, AreaChart } from "recharts"
import Card from "@/app/shared/components/common/Card"
export default function IngresoAndGastoChart() {
  return (
    <Card>
        <AreaChart>
           <Area type="monotone" dataKey="uv" stroke="#8884d8" />
        </AreaChart>
    </Card>
  )
}
