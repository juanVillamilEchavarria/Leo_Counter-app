import CardReview from "./CardReview"
export default function BalanceNetoCardReview() {
  return (
     <CardReview label="Balance neto" percentage={10.4} tipo_movimiento="Ingreso" total={7600000} tipo_total="dinero">
            <div className="flex flex-col mt-5 gap-2 w-full">
                <div className="flex items-center gap-1">
                    <p className=" text-center font-bold"><span className="text-green-600">+ 10.4%</span> Respecto al mes anterior</p>
                <i className="fa-solid fa-arrow-trend-up text-green-500"></i>
                </div>
                <small className="text-gray-400 text-center">Tendencia positiva en generación de ingresos</small>
            </div>
            </CardReview>
  )
}
