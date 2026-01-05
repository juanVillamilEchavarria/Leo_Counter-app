export default function SideBar({
    children
}:{
    children : React.ReactNode
}) {
  return (
    <div className="h-screen  overflow-visible  relative p-2 bg-linear-to-b from-azul-oscuro via-azul-gris to-azul">
        {children}
    </div> 
  )
}
