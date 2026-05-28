/**
 * Formulario organismo para solicitar enlace de restablecimiento.
 * @module resources/js/app/domains/auth/components/forgot-password/ForgotPasswordForm
 */

import InputFillable from "@/app/shared/components/form/InputFillable";
import Button from "@/app/shared/components/common/Button";
import AlertMessage from "@/app/shared/components/common/AlertMessage";
import { Link } from "@inertiajs/react";
import type { InertiaFormProps } from "@inertiajs/react";
import type { ForgotPasswordFormData } from "@/app/domains/auth/types/password-reset.types";

interface ForgotPasswordFormProps {
  form: InertiaFormProps<ForgotPasswordFormData>;
  onSubmit: (e: React.FormEvent<HTMLFormElement>) => void;
}

/**
 * Organismo formulario "Olvidé mi contraseña".
 * Mantiene exactamente las clases y estructura del archivo original.
 */
export default function ForgotPasswordForm({ form, onSubmit }: ForgotPasswordFormProps) {
  const { setData, errors } = form;

  return (
    <form onSubmit={onSubmit} className="flex flex-col gap-4 p-2">
      <InputFillable
        placeholder="Email"
        className={`border-2 p-3 border-gray-100 text-gray-200 ${errors.email && 'border-red-500! text-red-500!'}`}
        type="email"
        name="email"
        id="email_password_reset"
        icon={`fa-solid fa-envelope fa-xl top-6 text-gray-200 ${errors.email && 'text-red-500!'}`}
        onChange={(event: React.ChangeEvent<HTMLInputElement>) => setData('email', event.target.value)}
        value={form.data.email}
      />
      {form.errors.email && <AlertMessage message={form.errors.email} />}
      <div className="w-2/4 my-4 mx-auto">
        <Button type="submit" variant="transition-blue" className="text-white!" disabled={form.processing}>
          Enviar enlace
        </Button>
      </div>
      <Link href="/" className="text-gray-200 text-sm hover:underline">
        Volver al login
      </Link>
    </form>
  );
}
