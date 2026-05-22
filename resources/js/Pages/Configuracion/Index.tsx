import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { ConfiguracionNavBar } from "@/app/domains/configuracion"
import SectionDescription from "@/app/shared/components/common/SectionDescription";
import CanalNotificationSection from '@/app/domains/notificacion/components/CanalNotificationSection'
import SuscriptorNotificacionSection from '@/app/domains/notificacion/components/SuscriptorNotificacionSection'
import type { CanalNotificacion, SuscriptorNotificacion } from "@/app/domains/notificacion";
import type { User } from "@/app/domains/user";
import Title from "@/app/shared/components/common/Title";

export default function Index({
   canales ,
    suscriptores,
    usuarios 
}: { 
      canales?: CanalNotificacion[], 
    suscriptores?: SuscriptorNotificacion[],
     usuarios?:User[] 
    }) {
  const options = {
    usuarios: usuarios || [],
    canales: canales || []
  }

  return (
    <SectionTransition>
      <ConfiguracionNavBar />
      
      <div className="mt-6">
        <Title
        title="Notificaciones"
        className="text-left text-4xl mb-10"
        />
        <div className="flex flex-col gap-10">
          <CanalNotificationSection canales={options.canales} />
        <SuscriptorNotificacionSection suscriptores={suscriptores || []} options={options}/>

        </div>
        

      </div>
    </SectionTransition>
  )
}
