/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import Title from "./Title"
export default function SectionDescription({
    title,
    className,
    paragraph
}:{
    title: string,
    className ?: string
    paragraph: string | React.ReactNode
}) {
  return (
   <div className={`flex flex-col justify-center items-center ${className}`}> 
        <Title title={title} size="4xl" className={` font-principal `} />
        <p className="text-foreground text-lg font-principal mt-2 bg- ">{paragraph}</p>
   </div>
  )
}
