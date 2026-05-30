/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
/**
 * Hook para manejar el restablecimiento de contraseña.
 * @module resources/js/app/domains/auth/hooks/useResetPassword
 */

import { route } from "ziggy-js";
import { useFormNormal } from "../../../shared/hooks";
import type { ResetPasswordFormData, ResetPasswordFormReturn } from "@/app/domains/auth/types/password-reset.types";

/**
 * Inicializa el formulario con email y token y expone form y handleSubmit.
 * @param {{email: string, token: string}} props
 * @returns {ResetPasswordFormReturn}
 */
export default function useResetPassword({ email, token }: { email: string; token: string; }): ResetPasswordFormReturn {
  const { form, handleSubmit } = useFormNormal<ResetPasswordFormData>({
    action: route("password.update"),
    data: {
      email,
      token,
      password: "",
      password_confirmation: "",
    },
  });

  return { form, handleSubmit };
}
