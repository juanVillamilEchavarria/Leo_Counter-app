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
    onSubmit
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
            size="lg"
          variant="secondary">
            <p>{paragraph}</p>
                {children}
            <form onSubmit={handleSubmit}>
              <div className="flex w-2/3 mx-auto mt-7 gap-2">
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
