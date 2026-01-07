import {useFormNormal }from "../../../shared/hooks/";
import { AuthActions,type AuthTypes, type AuthFormReturn } from "../types/auth.types";
import { type UserLogin, type UserRegister } from "@/app/domains/user/types/user.types";

export default function useAuth(props: { type: 'login' }): AuthFormReturn<UserLogin>;
export default function useAuth(props: { type: 'register' }): AuthFormReturn<UserRegister>;
export default function useAuth({
    type
}:{
    type: AuthTypes
}){
  switch(type){
      case 'login':{
        const {form, handleSubmit} =useFormNormal<UserLogin>({
            action : AuthActions.login,
            data:  {
                email: '',
                password: '',
                remember: false
            }
        }); 
        return {
            form,
            handleSubmit
        }}
      case 'register':{
        
        const {form, handleSubmit} = useFormNormal<UserRegister>({
                action : AuthActions.register,
                 data : {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                }
        });
        return {
            form,
            handleSubmit
        }
     }
     default: {
      const _exhaustive: never = type
      throw new Error(`Unhandled auth type: ${_exhaustive}`)
    }
  }

}
