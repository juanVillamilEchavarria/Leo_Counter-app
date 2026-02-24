import { useState } from "react"

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
