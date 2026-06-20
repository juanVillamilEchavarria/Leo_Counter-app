/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
import React from 'react'

/**
 * Componente para mostrar en la tabla correctamente el json que se muestra en la auditoria sobre los valores antes y despues
 * 
 * @param param0 
 * @returns 
 */

export default function ValuesReview({
    iterable
}:{
    iterable : Record<string, any>
}) {
  return (
    <div className="max-h-32 overflow-y-auto pr-1">
            <dl className="flex flex-col gap-1.5 w-full min-w-[160px]">
                {Object.entries(iterable).map(([key, value]) => {
                    // Formatear el valor para evitar que React oculte booleanos o nulos
                    const displayValue = value === null ? 'null' 
                                       : typeof value === 'boolean' ? (value ? 'Sí' : 'No') 
                                       : String(value);

                    // Formatear la llave para mejor lectura (ej: cuenta_id -> Cuenta id)
                    const displayKey = key.replace(/_/g, ' ');

                    return (
                        <div 
                            key={key} 
                            className="flex justify-between items-start gap-3 text-xs border-b border-border/40 pb-1 last:border-0 last:pb-0"
                        >
                            <dt className="text-muted-foreground font-medium capitalize whitespace-nowrap">
                                {displayKey}
                            </dt>
                            <dd className="text-foreground text-right font-mono text-[11px] break-all bg-muted/30 px-1.5 py-0.5 rounded-md">
                                {displayValue === '' ? (
                                    <span className="italic opacity-50">vacío</span>
                                ) : (
                                    displayValue
                                )}
                            </dd>
                        </div>
                    );
                })}
            </dl>
        </div>
  )
}
