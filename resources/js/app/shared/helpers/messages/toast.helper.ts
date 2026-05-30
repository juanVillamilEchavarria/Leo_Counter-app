/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { toast } from "react-toastify";
export const toastHelper={
     success: (message: string)=>{
        toast.success(message)
    },
     error:(message: string)=>{
        toast.error(message)
    },
    info :(message: string)=>{
        toast.info(message)
    }
    
}