import SectionDescription from "@/app/shared/components/common/SectionDescription";
import {CanalNotificacionTable} from "@/app/domains/notificacion";
import type {CanalNotificacion} from "@/app/domains/notificacion";
import SecundaryDescription from "@/app/shared/components/common/SecundaryDescription";

export default function CanalNotificationSection(
    {
        canales,
    }:{
        canales: CanalNotificacion[]
    }) {
  return <div>
    {/* ── Canales de Notificación ── */}
   <SecundaryDescription
       title="Canales"
       paragraph="Mira los canales de notificacion permitidos del sistema"
   />
    <div className="overflow-scroll scrollbar-modern mt-4">
        <CanalNotificacionTable data={canales} />
    </div>
  </div>
}
