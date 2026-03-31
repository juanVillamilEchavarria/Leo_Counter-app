import Title from "@/app/shared/components/common/Title"
import ProfileNavigationGroup from "@/app/domains/profile/components/ProfileNavigationGroup"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { ProfileForm } from "@/app/domains/profile"
export default function Profile() {
  return (
    <SectionTransition>
        <ProfileNavigationGroup />
        <div className="w-[50%] mx-auto mt-10 flex flex-col justify-center">
            <div className="flex flex-col text-foreground gap-5">
                <Title 
                title={
                    <div>
                        <i className="fa-solid fa-child-reaching"></i>
                        <span>Mi Perfil</span>
                    </div>
                    } 
                size="5xl" 
                
                 />
                <p >Aqui puedes actualizar tu informacion</p>
            </div>
            
            <div className="mt-10">
                <ProfileForm />
            </div>
        </div>
     </SectionTransition>
  )
}
