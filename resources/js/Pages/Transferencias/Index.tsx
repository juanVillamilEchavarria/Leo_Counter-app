/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
import { TransferenciaTable, type Transferencia, TransferenciaForm, useTransferencia } from "@/app/domains/transferencia";
import SectionTransition from "@/app/shared/components/common/SectionTransition";
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection";
import CrudButton from "@/app/shared/components/common/CrudButton";
import Modal from "@/app/shared/components/modal/Modal";
import { useModalItem } from "@/app/shared/hooks";
import SectionDescriptionWithDetails from "@/app/shared/components/common/SectionDescriptionWithDetails";

export default function Index({
    transferencias,
    cuentas
}: {
    transferencias: Transferencia[],
    cuentas: { id: string, nombre: string }[]
}) {
    const { modal, open, close } = useModalItem<Transferencia>();
    const { form, handleTransferenciaCreate } = useTransferencia();

    const handleClose = () => {
        close();
        form.reset();
        form.clearErrors();
    };

    const descriptionItems = [
        {
            title: '¿Qué son las transferencias?',
            description: 'Las transferencias te permiten mover dinero entre tus diferentes cuentas sin afectar tus ingresos o egresos totales, manteniendo el saldo general equilibrado.',
            icon: 'fa-solid fa-exchange-alt !text-blue-400'
        }
    ];

    return (
        <SectionTransition>
            <SectionDescriptionWithDetails
                principalTitle="Transferencias entre Cuentas"
                paragraph={(
                    <span>Gestiona y registra el movimiento de dinero entre tus cuentas.</span>
                )}
                items={descriptionItems}
            />

            <CreateButtonSection>
                <CrudButton
                    onClick={() => open(null, 'create')}
                    icon="fa-solid fa-plus"
                >
                </CrudButton>
            </CreateButtonSection>

            <TransferenciaTable  />

            <Modal open={modal === 'create'} size={'lg'} onClose={handleClose} title={<p className='mb-10'><span className='text-blue-400 border-b rounded-b-lg'>Nueva</span>  Transferencia</p>} >
                <TransferenciaForm
                    data={form.data}
                    setData={form.setData}
                    errors={form.errors}
                    processing={form.processing}
                    submit={(e) => {
                        handleTransferenciaCreate(e);
                        if (!form.hasErrors) {
                            handleClose();
                        }
                    }}
                    options={{ cuentas }}
                />
            </Modal>
        </SectionTransition>
    )
}
