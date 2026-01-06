import SideBar from "@/app/shared/components/sidebar/SideBar"
import Logo from "@/app/shared/components/common/Logo"
import SideBarToggle from "@/app/shared/components/sidebar/SideBarToggle"
import useOpen from "@/app/shared/hooks/open/useOpen"
import Title from "@/app/shared/components/common/Title"
import TransitionMotion from "../transitions/TransitionMotion"
import NavBar from "../navBar/NavBar"
import SelfUserCard from "@/app/domains/user/components/SelfUserCard"
import { useMessageRedirect } from "../../hooks"
export default function SideBarApp() {
        const {isOpen, setIsOpen} = useOpen(true)
        const {props}= useMessageRedirect()
        const user = props?.auth?.user

        const TrasitionStyle = 'transition-all  duration-400'
  return (
    <SideBar className={`${isOpen ? 'w-80 min-w-80 ' : 'w-20 min-w-15'} h-full scrollbar-none relative ${TrasitionStyle} grid grid-rows-[1fr_auto]`}>
        <SideBarToggle isOpen={isOpen} setIsOpen={setIsOpen} />
            <div className={` grid grid-rows-[auto_1fr] overflow-hidden`}>
                    
                    <div className="flex w-full gap-7 p-1  h-15 ">
                        <div className={`w-15 h-15 shrink-0`} >
                            <Logo className="w-full h-full object-cover"  />
                        </div>
                        
                        <TransitionMotion active={isOpen} initial={{opacity:0, x: -70}}>
                            <Title size="lg" title="Leo Counter" className="text-center text-gray-200 font-cursiva my-4 whitespace-nowrap" />
                        </TransitionMotion>
                    </div>
                    <div className={`flex  flex-col my-5 overflow-y-scroll scrollbar-modern ${TrasitionStyle}`}>
                        <NavBar isOpen={isOpen} />
                    </div>
                     <div className="my-2 p-2 ">
                        
                            <SelfUserCard user={{name: user?.name, role: user?.role}} isOpen={isOpen} />
                            <div className="mt-5 h-5">
                                <TransitionMotion active={isOpen} initial={{opacity:0, x: -70}}>
                                     <p className="m-0 text-center text-gray-200 text-xs whitespace-nowrap">En memoria de Leonardo Villamil &copy;</p>
                            </TransitionMotion>

                            </div>
                             
                            
                    </div>

            </div>
            
           
                

            
        </SideBar>
  )
}
