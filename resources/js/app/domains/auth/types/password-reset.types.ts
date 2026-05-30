/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
/**
 * Tipos para formularios de restablecimiento de contraseña.
 * @module resources/js/app/domains/auth/types/password-reset.types
 */

import type { InertiaFormProps } from "@inertiajs/react";

/**
 * Datos enviados en el formulario "Olvidé mi contraseña".
 */
export interface ForgotPasswordFormData {
  /** Correo electrónico */
  email: string;
}

/**
 * Retorno del hook useForgotPassword.
 */
export type ForgotPasswordFormReturn = {
  form: InertiaFormProps<ForgotPasswordFormData>;
  handleSubmit: (e: React.FormEvent<HTMLFormElement>) => void;
};

/**
 * Datos del formulario de restablecimiento de contraseña.
 */
export interface ResetPasswordFormData {
  email: string;
  token: string;
  password: string;
  password_confirmation: string;
}

/**
 * Props esperadas por la página ResetPassword.
 */
export type ResetPasswordProps = Pick<ResetPasswordFormData, "email" | "token">;

/**
 * Retorno del hook useResetPassword.
 */
export type ResetPasswordFormReturn = {
  form: InertiaFormProps<ResetPasswordFormData>;
  handleSubmit: (e: React.FormEvent<HTMLFormElement>) => void;
};
