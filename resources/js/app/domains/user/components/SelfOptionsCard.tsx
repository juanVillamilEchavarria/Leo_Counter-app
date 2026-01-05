import { Link } from "@inertiajs/react"
import { useLogout } from "../../auth"

export default function SelfOptionsCard() {
    const {form, handleSubmit} = useLogout()
  return (
     <div className="
        flex
        absolute
        flex-col
        bg-zinc-950/80 
        backdrop-blur-2xl
        border
        border-white/80  
        z-50
        shadow-[0_20px_50px_rgba(0,0,0,0.6)]
        rounded-2xl 
        gap-2
        p-5
        w-56


        origin-bottom-left
        "
    >
        <div className="border-b border-white/80">
            <Link 
            href='#' 
            className="
                text-white 
                text-sm
                mb-4 
                flex 
                items-center
                gap-2
                hover:bg-white/10 
                p-2 rounded-xl
                "
            >
            <i className="fa-solid fa-user fa-md"></i>
            <span>Profile</span>
            </Link>
        </div>
        <form onSubmit={handleSubmit} className="w-full">
            <button 
                type="submit" 
                className="
                  text-red-400
                  hover:bg-red-500/10
                    text-sm 
                    flex 
                    items-center 
                    gap-2 
                    p-2 
                    rounded-xl
                    cursor-pointer
                    w-full
                "
            >
            <i className="fa-solid fa-right-from-bracket fa-md"></i>
            <span>Logout</span>
            </button>
        </form>
        
    </div>
  )
}
