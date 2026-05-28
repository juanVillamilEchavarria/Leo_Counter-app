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
                        -right-5
                        -translate-y-1/2
                        z-50
                        w-8 h-8
                        rounded-full
                        bg-background
                        border-2 border-border
                        hidden lg:flex items-center justify-center
                        shadow-lg
                        cursor-pointer
                        hover:bg-accent
                        hover:border-border
                        transition-all
                        ease-in-out
                        duration-500
                        "
                    onClick={() => setIsOpen(prev => !prev)}
                    >
                        <i className={`fa-solid fa-chevron-right ${isOpen ? 'rotate-180': ''} text-foreground text-sm transition-all ease-in-out duration-500`} />
                </button>
  )
}
