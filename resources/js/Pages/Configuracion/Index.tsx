/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
    suscriptores
}: {
      canales?: CanalNotificacion[],
    suscriptores?: SuscriptorNotificacion[],
    }) {
  const options = {
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
          <CanalNotificationSection canales={canales || []} />
        <SuscriptorNotificacionSection suscriptores={suscriptores || []} canales={canales || []}/>

        </div>


      </div>
    </SectionTransition>
  )
}
