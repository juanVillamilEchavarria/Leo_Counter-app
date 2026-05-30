/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useState } from "react"

/**
 * hook para manejar el estado de las entradas a mostrar de las tablas
 * @param {number} value 
 * @returns {entries: number, setEntries: (entries: number) => void}
 */
export default function useEntries({
    value
}:{
    value: number
}) {
    const [entries, setEntries] = useState(value);
  return {
    entries,
    setEntries
  }
}
