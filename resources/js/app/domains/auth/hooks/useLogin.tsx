/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
