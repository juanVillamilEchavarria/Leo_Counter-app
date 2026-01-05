export default function List({
    children,
    className = ''
}:{
    children : React.ReactNode
    className ?: string
}) {
  return (
     <ul className={`flex flex-col items-start ${className}`}>
            {children}
    </ul>
  )
}
