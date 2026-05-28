import { AuthActions, type AuthFacade, type AuthTypes, type AuthLoginFacade, type AuthRegisterFacade } from "./types/auth.types";
import useAuth from "./hooks/useAuth";
import useLogout from "./hooks/useLogout";
import useRegister from "./hooks/useRegister";
import useForgotPassword from "./hooks/useForgotPassword";
import useResetPassword from "./hooks/useResetPassword";
import type { ForgotPasswordFormData, ResetPasswordFormData, ForgotPasswordFormReturn, ResetPasswordFormReturn } from "./types/password-reset.types";

export {
    AuthActions,
    useAuth,
    useLogout,
    useRegister,
    useForgotPassword,
    useResetPassword,
    type AuthTypes,
    type AuthFacade,
    type AuthLoginFacade,
    type AuthRegisterFacade,
    type ForgotPasswordFormData,
    type ResetPasswordFormData,
    type ForgotPasswordFormReturn,
    type ResetPasswordFormReturn
}