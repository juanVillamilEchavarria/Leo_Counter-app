import FlashToastListener from "@/app/shared/components/common/FlashToastListener"
export default function GuestLayout({
    children
}:{
    children : React.ReactNode
}) {
  return (
    <div className="flex w-full h-screen items-center justify-center bg-linear-to-br from-azul-gris via-azul-claro to-azul-negro font-principal">
        {children}
    </div>
  )
}
