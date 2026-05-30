/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
/**
 * Formulario organismo para restablecer contraseña.
 * @module resources/js/app/domains/auth/components/reset-password/ResetPasswordForm
 */

import InputFillable from "@/app/shared/components/form/InputFillable";
import Button from "@/app/shared/components/common/Button";
import AlertMessage from "@/app/shared/components/common/AlertMessage";
import type { InertiaFormProps } from "@inertiajs/react";
import type { ResetPasswordFormData } from "@/app/domains/auth/types/password-reset.types";

interface ResetPasswordFormProps {
  form: InertiaFormProps<ResetPasswordFormData>;
  onSubmit: (e: React.FormEvent<HTMLFormElement>) => void;
}

/**
 * Organismo formulario "Restablecer contraseña".
 * Mantiene exactamente las clases y estructura del archivo original.
 */
export default function ResetPasswordForm({ form, onSubmit }: ResetPasswordFormProps) {
  const { setData } = form;

  return (
    <form onSubmit={onSubmit} className="flex flex-col gap-4 p-2">
      <InputFillable
        placeholder="Nueva contraseña"
        className={`border-2 p-3 border-gray-100 text-gray-200 ${form.errors.password && 'border-red-500! text-red-500!'}`}
        type="password"
        name="password"
        id="password_reset"
        icon={`fa-solid fa-lock fa-xl top-6 text-gray-200 ${form.errors.password && 'text-red-500!'}`}
        onChange={(event: React.ChangeEvent<HTMLInputElement>) => setData('password', event.target.value)}
        value={form.data.password}
      />
      {form.errors.password && <AlertMessage message={form.errors.password} />}

      <InputFillable
        placeholder="Confirmar contraseña"
        className={`border-2 p-3 border-gray-100 text-gray-200 ${form.errors.password_confirmation && 'border-red-500! text-red-500!'}`}
        type="password"
        name="password_confirmation"
        id="password_reset_confirmation"
        icon={`fa-solid fa-lock fa-xl top-6 text-gray-200 ${form.errors.password_confirmation && 'text-red-500!'}`}
        onChange={(event: React.ChangeEvent<HTMLInputElement>) => setData('password_confirmation', event.target.value)}
        value={form.data.password_confirmation}
      />
      {form.errors.password_confirmation && <AlertMessage message={form.errors.password_confirmation} />}
      {form.errors.token && <AlertMessage message={form.errors.token} />}

      <div className="w-2/4 my-4 mx-auto">
        <Button type="submit" variant="transition-blue" className="text-white!" disabled={form.processing}>
          Restablecer
        </Button>
      </div>
    </form>
  );
}
