/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import React from 'react'
import ItemSelected from './ItemSelected'

interface ItemSelectedListProps {
    iterable : Record<string, any>[] | undefined
    removeItem: (id: number) => void
    emptyMessage ?: string
    children ?: React.ReactNode
}
export default function ItemSelectedList({
    iterable,
    removeItem,
    emptyMessage= "No hay registros",
    children
}: ItemSelectedListProps) {
  return (
    <ul className="flex flex-wrap gap-2">
        {iterable && iterable.length>0 ? iterable.map((item) => (
            <li key={item.id}><ItemSelected name={item.nombre} onRemove={() => removeItem(item.id)} />
            </li>
            
        )):(
            <div className="w-full text-center">
            {!children ? <p className="text-sm text-muted-foreground"> {emptyMessage}</p> : children}
            </div>
        )}
    </ul>
  )
}
