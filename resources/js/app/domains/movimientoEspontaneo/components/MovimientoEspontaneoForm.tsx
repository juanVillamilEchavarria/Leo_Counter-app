import Card from "@/app/shared/components/common/Card"
import InputFillable from "@/app/shared/components/form/InputFillable"
import SelectModel from "@/app/shared/components/form/SelectModel"
import TextArea from "@/app/shared/components/form/TextArea"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import SaldoValidationFeedback from "./SaldoValidationFeedback"
import AlertMessage from "@/app/shared/components/common/AlertMessage"
import Button from "@/app/shared/components/common/Button"
import DropZone from "@/app/shared/components/dropZone/DropZone"
import UploadedFileList from "@/app/shared/components/dropZone/UploadedFileList"
import ErrorList from "@/app/shared/components/dropZone/ErrorList"
import useMovimientoEspontaneoUploadFiles from "../hooks/useMovimientoEspontaneoUploadFiles"
import useFormSaldoValidate from "../hooks/useFormSaldoValidate"
import {  useMemo } from "react"
import { useCategoriasMovimientoFilter } from "@/app/shared/hooks"
import { ArchivoMovimientoRoutes } from "@/app/domains/archivoMovimiento"
import { type MovimientoEspontaneoFormProps } from "../types/movimientoEspontaneo.types"

export default function MovimientoEspontaneoForm({
    data,
    setData,
    errors,
    submit,
    options,
    processing,
}: MovimientoEspontaneoFormProps) {
       const {
    tipoMovimientoId,
    setTipoMovimientoId,
    categoriasFiltered,
   } = useCategoriasMovimientoFilter({
        options,
        data,
        onCategoriaInvalid : () => setData('categoria_id', undefined)
   })

   const {onDrop,onDropRejected,rejectedFiles,removeFile}= useMovimientoEspontaneoUploadFiles({files: data?.comprobantes, setFiles : (files) => setData('comprobantes', files)})
   const {removeFile: removeExistingFile}= useMovimientoEspontaneoUploadFiles({files: data?.comprobantes_existing, setFiles : (files) => setData('comprobantes_existing', files)})
   const {data : dataValidate, isLoading, isError, error}= useFormSaldoValidate({cuentaId:data?.cuenta_id, monto: data?.monto, tipo_movimiento_id: data?.tipo_movimiento_id, movimiento_id: data?.id})
    const maxFiles = useMemo(() => 3 - (data?.comprobantes_existing ? data.comprobantes_existing.length : 0), [data?.comprobantes_existing])
    const hasExistingFiles = useMemo(() => data?.comprobantes_existing && data?.comprobantes_existing.length > 0, [data?.comprobantes_existing])
  return (
    <Card>
        <form onSubmit={submit} className="formulario-general">
            <legend>Informacion del Movimiento Espontaneo</legend>
            <div className="formulario-campo">
                <label htmlFor="nombre"> Nombre</label>
                <InputFillable
                    placeholder="Ej: Pago de servicios"
                    type="text"
                    name="nombre"
                    id="nombre"
                    value={data?.nombre}
                    onChange={
                        (e: React.ChangeEvent<HTMLInputElement>) => setData('nombre', e.target.value)
                    }
                    className={`border-2 p-3 border-border text-foreground ${errors.nombre && 'border-red-500! text-red-500!'} `}
                    icon={`fa-solid fa-file-signature fa-xl top-6 text-muted-foreground ${errors.nombre && 'text-red-500!'} `}
                />
                <TransitionMotion
                active={errors?.nombre}
                >
                    <AlertMessage message={errors?.nombre} />
                </TransitionMotion>
            </div>
            <div className="flex w-full flex-col gap-4 md:flex-row">
                <div className="formulario-campo w-full">
                    <label htmlFor="tipo_movimiento_id">Tipo de movimiento</label>

                        <SelectModel
                        name="tipo_movimiento_id"
                        id="tipo_movimiento_id"
                        iterable={options.tipos_movimientos}
                        iterableOutput="tipo_movimiento"
                        onChange={(e) => {
                            setTipoMovimientoId(Number(e.target.value));
                            setData('tipo_movimiento_id', Number(e.target.value));
                        }}
                        value={tipoMovimientoId}
                        className={`${errors.tipo_movimiento_id && 'border-red-500! text-red-500!'}`}
                        placeholder="Seleccione un tipo de movimiento"
                        />
                            <TransitionMotion active={errors?.tipo_movimiento_id}>
                                <AlertMessage message={errors?.tipo_movimiento_id} />
                            </TransitionMotion>
                </div>
                <div className="formulario-campo w-full">
                    <label htmlFor="categoria_id">Categoría</label>

                    <SelectModel
                        name="categoria_id"
                        id="categoria_id"
                        iterable={categoriasFiltered}
                        onChange={(e) => setData('categoria_id', e.target.value)}
                        value={data?.categoria_id}
                        className={`${errors.categoria_id && 'border-red-500! text-red-500!'}`}
                        placeholder="Seleccione una categoría"
                        />
                    <TransitionMotion active={errors?.categoria_id}>
                        <AlertMessage message={errors?.categoria_id} />
                    </TransitionMotion>
                </div>
            </div>
            <div className="flex w-full flex-col gap-4 md:flex-row">
                <div className="formulario-campo w-full">
                    <label htmlFor="cuenta_id">Cuenta</label>

                    <SelectModel
                        name="cuenta_id"
                        id="cuenta_id"
                        iterable={options.cuentas}
                        onChange={(e) => setData('cuenta_id',e.target.value)}
                        value={data?.cuenta_id}
                        className={`${errors.cuenta_id && 'border-red-500! text-red-500!'}`}
                        placeholder="Seleccione una cuenta"
                        />
                       {/* Validación de Laravel */}
                        <TransitionMotion active={errors?.cuenta_id}>
                            <AlertMessage message={errors?.cuenta_id} />
                        </TransitionMotion>
                        {/* Error de API */}
                        <TransitionMotion active={isError}>
                            <AlertMessage message={error?.message || 'Error al validar saldo'} />
                        </TransitionMotion>

                        {/* Saldo insuficiente */}
                        <TransitionMotion active={dataValidate?.allowed !== undefined}>
                            <SaldoValidationFeedback allowed={dataValidate?.allowed} />
                        </TransitionMotion>
                </div>
                <div className="formulario-campo w-full">
                    <label htmlFor="monto">Monto</label>
                    <InputFillable
                        type="number"
                        name="monto"
                        id="monto"
                        value={data?.monto}
                        onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('monto', Number(e.target.value))}
                        className={` ${errors.monto && 'border-red-500! text-red-500!'} `}
                    ></InputFillable>

                    <TransitionMotion active={errors?.monto}>
                        <AlertMessage message={errors?.monto} />
                    </TransitionMotion>

                </div>
            </div>
            <div className="formulario-campo">
                <label htmlFor="descripcion">Descripcion</label>
                <TextArea
                    name="descripcion"
                    id="descripcion"
                    value={data?.descripcion}
                    placeholder="Ej: Movimiento fijo del pago de la empleada, cada 15 dias, sale del bolsillo de mamá"
                    icon={`fa-solid fa-note-sticky fa-xl top-6 text-muted-foreground ${errors.descripcion && 'text-red-500!'} `}
                    onChange={(e: React.ChangeEvent<HTMLTextAreaElement>) => setData('descripcion', e.target.value)}
                    className={` h-60 ${errors.descripcion && 'border-red-500! text-red-500!'} `}
                />
                <TransitionMotion active={errors?.descripcion}>
                    <AlertMessage message={errors?.descripcion} />
                </TransitionMotion>
            </div>
            <div className="w-full flex flex-col">
                <p className="text-muted-foreground font-bold">Archivos Adjuntos <small>({data?.comprobantes?.length ?? 0} de {maxFiles} permitidos)</small>:</p>
                {maxFiles > 0 ? (
                    <DropZone onDrop={onDrop} onDropRejected={onDropRejected} rejectedFiles={rejectedFiles} maxFiles={maxFiles}/>
                ) : (
                    <p className="text-muted-foreground italic">Has alcanzado el límite máximo de archivos adjuntos. Elimina algunos archivos existentes para agregar nuevos.</p>
                )}

                    <ErrorList rejectedFiles={rejectedFiles}/>
                    <div className={`${hasExistingFiles ? 'grid grid-cols-1 md:grid-cols-2 gap-4' : 'flex flex-col gap-4'} mt-5`}>

                            { data?.comprobantes_existing && data?.comprobantes_existing?.length>0  &&(

                                 <div className="flex flex-col">
                                    <p className="text-muted-foreground font-bold">Archivos Guardados:</p>
                                <UploadedFileList preview_route={ArchivoMovimientoRoutes.movimientosArchivosShow}  files={data.comprobantes_existing} handleDeleteFile={(index : number, id?: number)=>{
                                    removeExistingFile(index);
                                    setData('comprobantes_delete_ids', [...(data?.comprobantes_delete_ids ?? []), id ?? 0])
                                }} className="text-foreground" />
                                </div>
                            )}

                        <div className="flex flex-col">
                            <p className="text-muted-foreground font-bold">Archivos Nuevos:</p>
                            {data?.comprobantes && data?.comprobantes?.length > 0 ? (
                                <>
                                    <UploadedFileList files={data.comprobantes} handleDeleteFile={(index : number)=>{
                                        removeFile(index);
                                    }} className="text-foreground" />
                                </>

                            ):(
                                <p className="text-muted-foreground font-bold">No hay archivos nuevos</p>
                            )}
                            </div>
                    </div>
            </div>

            <div className="w-full my-5 mx-auto sm:w-1/2 lg:w-1/6">
                <Button
                variant="secondary"
                    type="submit"
                    disabled={processing || isLoading || (dataValidate?.allowed === false && data?.tipo_movimiento_id === 2) }
                >
                    Guardar
                </Button>
            </div>

        </form>
    </Card>
  )
}
