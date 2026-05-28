import FlashToastListener from "@/app/shared/components/common/FlashToastListener"
import { ToastContainer } from "react-toastify"
export default function GuestLayout({
    children
}:{
    children : React.ReactNode
}) {
  return (
    <div className="flex w-full min-h-screen items-center justify-center bg-linear-to-br from-azul-gris via-azul-claro to-azul-negro font-principal px-4 py-8">
        <ToastContainer className={`mt-20`}  />
        <FlashToastListener />
        {children}
    </div>
  )
}
