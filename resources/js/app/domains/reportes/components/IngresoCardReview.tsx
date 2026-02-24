import CardReview from "./CardReview"
export default function IngresoCardReview() {
  return (
    <CardReview label="Total de ingresos" monto={10.4} tipo_movimiento="Ingreso" total={1000000} tipo_total="dinero">
        <div className="flex flex-col mt-5 gap-2 w-full">
            <div className="flex items-center gap-1">
                <p className=" text-center font-bold"><span className="text-green-600">10.4%</span> de Incremento en este mes </p>
            <i className="fa-solid fa-arrow-trend-up text-green-500"></i>
            </div>
            <small className="text-gray-400 text-center">Tendencia positiva en generación de ingresos</small>
        </div>
        </CardReview>
  )
}
