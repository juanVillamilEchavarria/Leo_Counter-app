import SideBarApp from "@/app/shared/components/sidebar/SideBarApp"
import Header from "@/app/shared/components/header/Header"
import FlashToastListener from "@/app/shared/components/common/FlashToastListener"
import { ToastContainer } from "react-toastify"
import { QueryClientProvider, QueryClient } from "@tanstack/react-query"
import { restorePageMode } from "@/app/shared/helpers/pageMode/pageMode.helpers"
export default function AppLayout({
    children
}:{
    children : React.ReactNode
}) {
    const queryClient = new QueryClient();
    restorePageMode()
  return (
    <QueryClientProvider client={queryClient}>
    <div className="flex h-screen overflow-hidden bg-background">

        <ToastContainer className={`mt-20`}  />
        <FlashToastListener />
        <SideBarApp />
        <section className="flex flex-col h-screen w-full">
            <Header />
            <main className="overflow-y-scroll h-screen scrollbar-modern">
                {children}
            </main>

        </section>
    </div>
    </QueryClientProvider>
  )
}
