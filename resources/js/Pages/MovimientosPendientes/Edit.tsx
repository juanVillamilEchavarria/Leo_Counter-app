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
import { type MovimientoPendienteFormOptions, type MovimientoPendiente } from "@/app/domains/movimientoPendiente";
import { type CreateAndEditViewWithOptionsProps } from "@/app/shared/types/formData";

export default function Edit({
    options,
    data
}: CreateAndEditViewWithOptionsProps<MovimientoPendiente, MovimientoPendienteFormOptions >) {
    const {form, handleSubmit}= useMovimientoPendiente({method: 'put', id: data?.id, data})

  return (
    <div className="section">
        <CreateOrEditDescription
        type="edit"
        model="Movimiento Pendiente"
        />
            <CreateOrEditFormSection
            buttonHref={MovimientoPendienteRoutes.index()}
            >
                <MovimientoPendienteForm {...form} submit={handleSubmit} options={options}  />
            </CreateOrEditFormSection>
    </div>
  )
}
