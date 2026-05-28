import { type UserLogin } from "@/app/domains/user/types/user.types";
import {useFormNormal} from "@/app/shared/hooks";
import {route} from "ziggy-js";
/**
 * Inicializa el formulario de login y expone form y handleSubmit.
 */
export default function useLogin(){

        const {form, handleSubmit} =useFormNormal<UserLogin>({
            action : route('login.store'),
            data:  {
                email: '',
                password: '',
                remember: false
            }
        });
        return {
            form,
            handleSubmit
        }
}
