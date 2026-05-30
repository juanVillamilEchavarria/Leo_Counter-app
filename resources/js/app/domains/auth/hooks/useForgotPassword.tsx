/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
/**
 * Hook para manejar "Olvidé mi contraseña".
 * @module resources/js/app/domains/auth/hooks/useForgotPassword
 */

import { route } from "ziggy-js";
import { useFormNormal } from "../../../shared/hooks";
import type { ForgotPasswordFormData, ForgotPasswordFormReturn } from "@/app/domains/auth/types/password-reset.types";

/**
 * Inicializa el formulario y expone form y handleSubmit.
 * @returns {ForgotPasswordFormReturn}
 */
export default function useForgotPassword(): ForgotPasswordFormReturn {
  const { form, handleSubmit } = useFormNormal<ForgotPasswordFormData>({
    action: route("password.email"),
    data: {
      email: "",
    },
  });

  return { form, handleSubmit };
}
