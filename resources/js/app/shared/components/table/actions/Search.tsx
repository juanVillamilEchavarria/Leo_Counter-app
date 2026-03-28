import InputFillable from "../../form/InputFillable"
import { type ChangeEvent } from "react"
export default function Search({
    value,
    setValue
}:{
    value: string ,
    setValue: (value: string) => void
}) {
  return (
    <div className="flex w-full my-2 justify-start">
        <InputFillable 
            type="search" 
            icon="fa-solid fa-search text-xl"
            name="search"
            id="search"
            value={value}
            placeholder="Busqueda"
            className="border border-border rounded-2xl transition-all "
            onChange={(e: ChangeEvent<HTMLInputElement>)=> setValue(e.target.value)}
        />
    </div>
  )
}
