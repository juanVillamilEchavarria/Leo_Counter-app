/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
export default function Logo({
    className = ''
}) {
  return (
    <img src="/img/logo.jpg" className={`rounded-full ${className}`} alt="Logo" />
  )
}
