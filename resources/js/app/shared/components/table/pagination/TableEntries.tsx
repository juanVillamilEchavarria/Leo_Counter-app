/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { type ChangeEvent } from "react"

export default function TableEntries({
    entries,
    setEntries
}:{
    entries: number,
    setEntries: (value: number) => void
}) {
  return (
    <div className="flex items-center gap-3">
        <p className="text-sm">Entradas</p>
        <select className="px-2 py-1 border border-border rounded-lg text-foreground" name="entries" id="entires" value={entries} onChange={(e: ChangeEvent<HTMLSelectElement>) => setEntries(Number(e.target.value))}>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>
  )
}
