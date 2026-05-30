/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
export default function List({
    children,
    className = ''
}:{
    children : React.ReactNode
    className ?: string
}) {
  return (
     <ul className={`flex flex-col items-start ${className}`}>
            {children}
    </ul>
  )
}
