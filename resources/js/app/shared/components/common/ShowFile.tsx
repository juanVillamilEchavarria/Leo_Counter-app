
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
