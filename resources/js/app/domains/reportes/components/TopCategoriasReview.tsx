import Card from "@/app/shared/components/common/Card"
import { useState } from "react"
export default function TopCategoriasReview() {

    const dataIngreso =[
        {
            name : 'Ingresos Laborales',
        },
        {
            name : 'Inversiones',
        },
        {
            name : 'Otros',
        },
    ]

    const dataGasto =[
        {
            name : 'Compras',
        },
        {
            name : 'Servicios',
        },
        {
            name : 'Otros',
        },
    ]

    const dataAmbos =[
        {
            name : 'Ingresos Laborales',
        },
        {
            name : 'Inversiones',

        },
        {
            name : 'Compras',
        },
    ]

    const [data, SetData] = useState(dataAmbos)
    const [mode, setMode] = useState("ambos")
  return (
    <Card>
        <div className="flex w-full flex-col gap-2">
            <div className="flex flex-wrap justify-between">
                <div className="flex flex-col gap-2">
                    <h3 className="font-bold">Top categorias</h3>
                    <p className="text-gray-500 text-sm">Ultimos 6 meses</p>
                </div>
                <div className="inline-flex rounded-xl border border-gray-200 p-2">
                    <button 
                    onClick={()=>{setMode('ambos'); SetData(dataAmbos)}}
                    className={` cursor-default!  px-3 rounded-lg text-sm ${mode === "ambos" ? 'bg-gray-900 text-white': 'hover:bg-gray-300 transition-all '}`}>Ambos</button>
                    <button 
                    onClick={()=>{setMode('ingresos'); SetData(dataIngreso)}}
                    className={` cursor-default! px-3 rounded-lg text-sm ${mode === "ingresos" ? 'bg-green-700 text-white': 'hover:bg-gray-300 transition-all '}`}>Ingresos</button>
                    <button 
                    onClick={()=>{setMode('gastos'); SetData(dataGasto)}}
                    className={` cursor-default! px-3 rounded-lg text-sm ${mode === "gastos" ? 'bg-red-700 text-white': 'hover:bg-gray-300 transition-all '}`}>Gastos</button>
                </div>
                 
            </div>
            <ul className="flex flex-col gap-2">
                {data.map((item, index) => (
                    <li key={index}>
                        <p>{index + 1} -{item.name}</p>
                    </li>
                ))}
            </ul>
                   
        </div>

        
    </Card>
  )
}
