/**
 * Tipos para el formulario de registro de usuario.
 * @module resources/js/app/domains/auth/types/register.types
 */

import type { InertiaFormProps } from "@inertiajs/react";

/**
 * Datos que envía el formulario de registro.
 */
export interface RegisterFormData {
  /** Nombre del usuario */
  name: string;
  /** Correo electrónico del usuario */
  email: string;
  /** Contraseña del usuario */
  password: string;
  /** Confirmación de la contraseña */
  password_confirmation: string;
}

export type RegisterFormReturn = {
  form: InertiaFormProps<RegisterFormData>;
  handleSubmit: (e: React.FormEvent<HTMLFormElement>) => void;
};
