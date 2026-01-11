import {Dialog, Transition, TransitionChild, DialogPanel, DialogTitle}from '@headlessui/react'
import {type ModalProps, ModalSizes, ModalVariants } from '../../types/components'

export default function Modal({
  children,
  title,
  open = false,
  variant = 'secondary',
  onClose,
  size = 'md',
}: ModalProps) {
  return (
    <Transition appear show={open} as="div">
      <Dialog as="div" onClose={onClose} className="relative z-50">
        
        {/* Backdrop */}
        <TransitionChild
          enter="ease-out duration-300"
          enterFrom="opacity-0"
          enterTo="opacity-100"
          leave="ease-in duration-200"
          leaveFrom="opacity-100"
          leaveTo="opacity-0"
        >
          <div className="fixed inset-0 bg-black/40 backdrop-blur-sm" />
        </TransitionChild>

        <div className="fixed inset-0 flex items-center justify-center">
          {/* Panel */}
          <TransitionChild
            enter="ease-out duration-300"
            enterFrom="opacity-0 scale-90 translate-y-4"
            enterTo="opacity-100 scale-100 translate-y-0"
            leave="ease-in duration-200"
            leaveFrom="opacity-100 scale-100 translate-y-0"
            leaveTo="opacity-0 scale-95 translate-y-4"
          >
            <DialogPanel
              className={`${ModalVariants[variant]} ${ModalSizes[size]} rounded-2xl p-6 shadow-xl flex flex-col justify-between`}
            >
              <div className="flex justify-end">
                <button onClick={onClose} className='cursor-pointer'>
                  <i className="fa-solid fa-xmark" />
                </button>
              </div>

              <DialogTitle className="text-2xl font-bold">
                {title}
              </DialogTitle>

              {children}
            </DialogPanel>
          </TransitionChild>
        </div>
      </Dialog>
    </Transition>
  )
}
