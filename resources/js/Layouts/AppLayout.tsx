import SideBarApp from "@/app/shared/components/sidebar/SideBarApp"
import Header from "@/app/shared/components/header/Header"
export default function AppLayout({
    children
}:{
    children : React.ReactNode
}) {
  return (
    <div className="flex h-screen">
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
