import { Link } from "@inertiajs/react"
import { useLogout } from "../../auth"
import { ProfileRoutes } from "../../usuario/types/usuario.types"
export default function SelfOptionsCard() {
    const {form, handleSubmit} = useLogout()
  return (
     <div className="
        flex
        flex-col
        bg-background
        backdrop-blur-2xl
        border
        border-border
        shadow-[0_20px_50px_rgba(0,0,0,0.6)]
        rounded-2xl
        gap-2
        p-5
        w-56
        origin-bottom-left
        "
    >
        <div className="border-b border-border">
            <Link
            href={ProfileRoutes.index}
            className="
                text-foreground
                text-sm
                mb-4
                flex
                items-center
                gap-2
                hover:bg-foreground/10
                p-2 rounded-xl
                "
            >
            <i className="fa-solid fa-user fa-md"></i>
            <span>Perfil</span>
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
