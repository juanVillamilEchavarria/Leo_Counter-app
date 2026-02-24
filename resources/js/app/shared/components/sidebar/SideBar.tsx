export default function SideBar({
    children,
    className = ''
}:{
    children : React.ReactNode
    className ?: string
}) {
  return (
    <div className={`h-screen  overflow-visible  relative  layout-background ${className}`}>
        {children}
    </div> 
  )
}
