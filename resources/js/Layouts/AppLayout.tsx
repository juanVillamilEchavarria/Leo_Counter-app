import SideBarApp from "@/app/shared/components/sidebar/SideBarApp"
import Header from "@/app/shared/components/header/Header"
import FlashToastListener from "@/app/shared/components/common/FlashToastListener"
import { ToastContainer } from "react-toastify"
export default function AppLayout({
    children
}:{
    children : React.ReactNode
}) {
  return (
    <div className="flex h-screen">

        <ToastContainer className={`mt-20`}  />
        <FlashToastListener />
        <SideBarApp />
        <section className="flex flex-col h-screen w-full">
            <Header />
            <main className="overflow-y-auto h-screen">
                {children}
            </main>

        </section>
    </div>
  )
}
