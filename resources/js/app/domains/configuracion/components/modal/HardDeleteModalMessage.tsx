/**
 * Mensaje de alerta para los modales de hard delete
 * @auhtor Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @returns {JSX.Element}
 */
export default function HardDeleteModalMessage() {
  return (
     <small>Este registro sera eliminado permanentemente de la base de datos, no podra ser recuperado, <span className="font-bold">considere seriamente esta accion antes de continuar</span></small>
  )
}
