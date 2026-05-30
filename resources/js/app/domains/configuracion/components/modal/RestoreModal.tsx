/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import Modal from "@/app/shared/components/modal/Modal"
import type React from "react"
import Button from "@/app/shared/components/common/Button"
interface RestoreModalProps{
    title : string
    open : boolean
    onClose : () => void
    paragraph : string
    children ?: React.ReactNode
    handleSubmit : (e: React.FormEvent<HTMLFormElement>) => void
}
/**
 * Modal de restauracion de registro en configuracion
 * @param  {string} title - el nombre del dominio , Ej : Cuentas
 * @param  {boolean} open - si el modal esta abierto o no
 * @param  {() => void} onClose - funcion para cerrar el modal
 * @param  {string} paragraph - el parrafo del modal
 * @param  {React.ReactNode} children - Contenido opcional del modal
 * @param  {(e: React.FormEvent<HTMLFormElement>) => void} handleSubmit - funcion para enviar el formulario
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @returns {JSX.Element}
 */
export default function RestoreModal({
    title,
    open,
    onClose,
    paragraph = '¿Estas seguro de restaurar este registro?',
    children,
    handleSubmit

}:RestoreModalProps) {
  return (
    <Modal
    title= {
        <div>
            <span className="text-green-400 border-b-2 border-green-500 rounded-lg">Restaurar</span>
            <span> {title}</span>
        </div>
    }
    open={open}
    onClose={onClose}
    >
        <div className="w-full flex flex-col">
            <p>{paragraph}</p>
            {children}
            <form onSubmit={handleSubmit}>
                <div className="flex w-full flex-col mx-auto mt-7 gap-2 sm:w-2/3 sm:flex-row">
                    <Button type="button" variant="gray" onClick={onClose}>Cancelar</Button>
                    <Button type="submit" variant="success">Restaurar</Button>
                </div>

            </form>
        </div>

    </Modal>
  )
}
