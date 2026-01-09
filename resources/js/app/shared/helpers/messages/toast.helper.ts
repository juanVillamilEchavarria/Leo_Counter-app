import { toast } from "react-toastify";
export const toastHelper={
     success: (message: string)=>{
        toast.success(message)
    },
     error:(message: string)=>{
        toast.error(message)
    }
    
}