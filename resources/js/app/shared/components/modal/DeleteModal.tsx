/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import Modal from "./Modal"
import Button from "../common/Button"
import { type DeleteModalProps } from "../../types/components"

export default function DeleteModal({
    open = false,
    onClose,
    spanTitle = 'Eliminar',
    title,
    paragraph,
    children,
    onSubmit,
    className = '',
    size = 'lg',
}:DeleteModalProps

) {
  const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    onSubmit(e);
    onClose();
  }
  return (
    <Modal 
            open={open} 
            onClose={onClose} 
            title={ 
            <div>
                <span className="text-red-400 border-b-2 border-red-500 rounded-lg">{spanTitle}</span>
                <span> {title}</span>
            </div>
            } 
            size={size}
          variant="secondary"
          className={className}>
            <p>{paragraph}</p>
                {children}
            <form onSubmit={handleSubmit}>
              <div className="flex w-full flex-col mx-auto mt-7 gap-2 sm:w-2/3 sm:flex-row">
                <Button
                type="button"
                variant="gray"
                onClick={onClose}
                >
                  no, cancelar
                </Button>
              <Button
              type="submit"
              variant="danger"
              >Si, {spanTitle}</Button>
              </div>
            </form>
    
          </Modal>
  )
}
