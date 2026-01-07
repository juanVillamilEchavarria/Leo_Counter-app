import { type InertiaFormProps } from "@inertiajs/react"
import { type UserLogin, type UserRegister } from "@/app/domains/user/";
export const AuthActions = {
    login: '/login',
    register: '/register'
}as const
export type AuthTypes = 'login' | 'register'
export type AuthLoginFacade ={
    type: AuthTypes,
    form: InertiaFormProps<UserLogin>
    handleSubmit: (e: React.FormEvent<HTMLFormElement>) => void
}

export type AuthRegisterFacade = {
    type: AuthTypes,
    form: InertiaFormProps<UserRegister>
    handleSubmit: (e: React.FormEvent<HTMLFormElement>) => void
}
export type AuthFacade= AuthLoginFacade | AuthRegisterFacade

export type AuthFormReturn<TData extends Record<string, any>> = {
  form: InertiaFormProps<TData>
  handleSubmit: (e: React.FormEvent<HTMLFormElement>) => void
}

