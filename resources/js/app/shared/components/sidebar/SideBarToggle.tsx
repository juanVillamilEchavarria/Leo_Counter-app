export default function SideBarToggle({
    isOpen,
    setIsOpen
}:{
    isOpen : boolean,
    setIsOpen : React.Dispatch<React.SetStateAction<boolean>>
}) {
  return (
    <button
                    className="
                        absolute
                        top-1/6
                        -right-7
                        -translate-y-1/2
                        z-50
                        w-8 h-8
                        rounded-full
                        bg-zinc-900
                        border-2 border-azul-claro
                        flex items-center justify-center
                        shadow-lg
                        cursor-pointer
                        hover:bg-azul-claro
                        hover:border-zinc-900
                        transition-all
                        ease-in-out
                        duration-500
                        "
                    onClick={() => setIsOpen(prev => !prev)}
                    >
                        <i className={`fa-solid fa-chevron-right ${isOpen ? 'rotate-180': ''} text-white text-sm transition-all ease-in-out duration-500`} />
                </button>
  )
}
