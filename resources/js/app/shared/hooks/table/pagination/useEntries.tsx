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
