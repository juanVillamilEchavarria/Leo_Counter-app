import {Dialog, Transition, TransitionChild, DialogPanel, DialogTitle}from '@headlessui/react'
import {type ModalProps, ModalSizes, ModalVariants } from '../../types/components'

export default function Modal({
    children,
    title,
    open=false,
    variant='secondary',
    onClose,
    size='md'
}:ModalProps
) {
   if(!open) return null
  return (
    <Transition show={open} as="div">
        <Dialog as="div" open={open} onClose={onClose} className="relative z-50">
            <TransitionChild
                enter="ease-out duration-300"
                enterFrom="opacity-0"
                enterTo="opacity-100"
                leave="ease-in duration-200"
                leaveFrom="opacity-100"
                leaveTo="opacity-0"
            >
                <div className="fixed inset-0 bg-black/40" />
            </TransitionChild>
            <div className="fixed inset-0 flex justify-center items-center">
                <TransitionChild
                    enter="ease-out duration-300"
                    enterFrom="opacity-0 scale-95"
                    enterTo="opacity-100 scale-100"
                    leave="ease-in duration-200"
                    leaveFrom="opacity-100 scale-100"
                    leaveTo="opacity-0 scale-95"
                >
                    <DialogPanel className={ `${ModalVariants[variant]} rounded-2xl p-4 ${ModalSizes[size]} flex flex-col gap-2`}>
                        <div className="w-full flex justify-end items-center">
                            <button onClick={onClose}>
                                <i className="fa-solid fa-xmark cursor-pointer"></i>
                            </button>
                        </div>
                        <DialogTitle className="text-2xl font-bold">{title}</DialogTitle>
                        
                        {children}
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>

    </Transition>
  )
}
