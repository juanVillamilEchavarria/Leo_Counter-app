/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import CreateOrEditDescription from "@/app/shared/components/common/CreateOrEditDescription";
import CreateOrEditFormSection from "@/app/shared/components/common/CreateOrEditFormSection"
import {MovimientoPendienteForm} from "@/app/domains/movimientoPendiente";
import { MovimientoPendienteRoutes } from "@/app/domains/movimientoPendiente";
import{ useMovimientoPendiente }from "@/app/domains/movimientoPendiente";
import { type MovimientoPendienteFormOptions } from "@/app/domains/movimientoPendiente";

export default function Create({
    options
}:{
    options: MovimientoPendienteFormOptions
}) {
    const {form, handleSubmit}= useMovimientoPendiente({})

  return (
    <div className="section">
        <CreateOrEditDescription type="create" model="Movimiento Pendiente" />
        <CreateOrEditFormSection
        buttonHref={MovimientoPendienteRoutes.index()}
        >
            <MovimientoPendienteForm {...form} submit={handleSubmit} options={options} />
        </CreateOrEditFormSection>
    </div>
  )
}
