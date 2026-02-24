import CardReview from "./CardReview"
export default function GastoCardReview() {
  return (
   <CardReview label="Total de gastos" monto={4.4} flow="reverse" tipo_movimiento="Gasto" total={240000} tipo_total="dinero" >
        <div className="flex flex-col mt-5 gap-2 w-full">
            <div className="flex items-center gap-1">
                <p className=" text-center font-bold"><span className="text-red-600">4.4%</span> de Incremento en este mes </p>
            <i className="fa-solid fa-arrow-trend-up text-red-500"></i>
            </div>
            <small className="text-gray-400 text-center">¡Se recomienda revisar categorías principales!</small>
        </div>
        </CardReview>
  )
}
