/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
/**
 * Componente de descripción secundaria.
 * @param param0
 * @param param0.title - el titulo principal
 * @param param0.paragraph - el parrafo secundario
 * @constructor
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
export default function SecundaryDescription ({
    title,
    paragraph
}:{
    title : string,
    paragraph: string
}) {
    return <div>
        <div className="flex flex-col gap-2">
            <p className='text-lg text-muted-foreground'>{title}</p>
            <small className="text-muted-foreground"> {paragraph}</small>
        </div>
    </div>
}
