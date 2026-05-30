/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */

export default function ShowFile({
    name,
    icon = "fa-solid fa-file-pdf text-red-500 text-xl"
}:{
    name: string,
    icon?: string
}) {
  return (
   <div className="flex items-center gap-2">
        <i className={icon}/>
        <p className="text-sm">{name}</p>
    </div>
  )
}
