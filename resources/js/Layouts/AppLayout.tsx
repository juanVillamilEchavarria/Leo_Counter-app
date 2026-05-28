import SideBarApp from "@/app/shared/components/sidebar/SideBarApp"
import Header from "@/app/shared/components/header/Header"
import FlashToastListener from "@/app/shared/components/common/FlashToastListener"
import { ToastContainer } from "react-toastify"
import { QueryClientProvider, QueryClient } from "@tanstack/react-query"
import { restorePageMode } from "@/app/shared/helpers/pageMode/pageMode.helpers"
import { useState } from "react"

/**
 * Layout principal autenticado.
 * Centraliza el estado del sidebar para mantener colapso en escritorio y
 * apertura por superposición en móvil/tablet sin desplazar el contenido.
 */
export default function AppLayout({
    children
}:{
    children : React.ReactNode
}) {
    const queryClient = new QueryClient();
    const [isOpen, setIsOpen] = useState(true)
    const [isMobileOpen, setIsMobileOpen] = useState(false)
    restorePageMode()
  return (
    <QueryClientProvider client={queryClient}>
    <div className="flex h-screen overflow-hidden bg-background">

        <ToastContainer className={`mt-20`}  />
        <FlashToastListener />
        <SideBarApp
            isOpen={isOpen}
            setIsOpen={setIsOpen}
            isMobileOpen={isMobileOpen}
            setIsMobileOpen={setIsMobileOpen}
        />
        <section className="flex flex-col h-screen w-full">
            <Header
                isOpen={isOpen}
                setIsOpen={setIsOpen}
                isMobileOpen={isMobileOpen}
                setIsMobileOpen={setIsMobileOpen}
            />
            <main className="overflow-y-scroll h-screen scrollbar-modern">
                {children}
            </main>

        </section>
    </div>
    </QueryClientProvider>
  )
}
