export default function SideBar({
    children,
    className = ''
}:{
    children : React.ReactNode
    className ?: string
}) {
  return (
    <div className={`h-screen  overflow-visible  relative  bg-linear-to-b from-azul-oscuro via-azul-gris to-azul-negro ${className}`}>
        {children}
    </div> 
  )
}
