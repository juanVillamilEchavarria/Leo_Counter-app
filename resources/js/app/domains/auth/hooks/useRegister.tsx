/**
 * Hook para manejar el registro de usuario (primer administrador).
 * @module resources/js/app/domains/auth/hooks/useRegister
 */

import { route } from "ziggy-js";
import { useFormNormal } from "../../../shared/hooks";
import type { RegisterFormData } from "@/app/domains/auth/types/register.types";

/**
 * Hook que retorna el formulario y la función handleSubmit para el registro.
 * Previene el evento por defecto y delega el envío a useFormNormal.
 */
export default function useRegister() {
  const { form, handleSubmit } = useFormNormal<RegisterFormData>({
    action: route("register.store"),
    data: {
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
    },
  });

  return { form, handleSubmit };
}
