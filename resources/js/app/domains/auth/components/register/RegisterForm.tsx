/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
/**
 * Componente organismo RegisterForm para el formulario de registro.
 * Reutiliza los átomos InputFillable, Button y AlertMessage y mantiene
 * exactamente las clases y la estructura visual del LoginForm.
 * @module resources/js/app/domains/auth/components/register/RegisterForm
 */

import InputFillable from "@/app/shared/components/form/InputFillable";
import Button from "@/app/shared/components/common/Button";
import AlertMessage from "@/app/shared/components/common/AlertMessage";
import { motion, AnimatePresence } from "framer-motion";
import type { InertiaFormProps } from "@inertiajs/react";
import type { RegisterFormData } from "@/app/domains/auth/types/register.types";

interface RegisterFormProps {
  form: InertiaFormProps<RegisterFormData>;
  onSubmit: (e: React.FormEvent<HTMLFormElement>) => void;
}

/**
 * Formulario de registro de usuario (organismo).
 * @param {RegisterFormProps} props - form y onSubmit
 * @returns {JSX.Element}
 */
export default function RegisterForm({ form, onSubmit }: RegisterFormProps) {
  const { setData, errors } = form;

  return (
    <form onSubmit={onSubmit} className="flex flex-col gap-4 p-2">
      <InputFillable
        placeholder="Nombre"
        className={`border-2 p-3 border-gray-100 text-gray-200 ${errors.name && 'border-red-500! text-red-500!'} `}
        type="text"
        name="name"
        id="name_register"
        icon={`fa-solid fa-user fa-xl top-6 text-gray-200 ${errors.name && 'text-red-500!'} `}
        onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('name', e.target.value)}
        value={form.data.name}
      />
      <AnimatePresence>
        {errors.name && (
          <motion.div
            initial={{ opacity: 0, y: -20 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -4 }}
            transition={{ duration: 0.25 }}
          >
            <AlertMessage message={errors.name} />
          </motion.div>
        )}
      </AnimatePresence>

      <InputFillable
        placeholder="Email"
        className={`border-2 p-3 border-gray-100 text-gray-200 ${errors.email && 'border-red-500! text-red-500!'} `}
        type="email"
        name="email"
        id="email_register"
        icon={`fa-solid fa-envelope fa-xl top-6 text-gray-200 ${errors.email && 'text-red-500!'} `}
        onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('email', e.target.value)}
        value={form.data.email}
      />
      <AnimatePresence>
        {errors.email && (
          <motion.div
            initial={{ opacity: 0, y: -20 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -4 }}
            transition={{ duration: 0.25 }}
          >
            <AlertMessage message={errors.email} />
          </motion.div>
        )}
      </AnimatePresence>

      <InputFillable
        placeholder="Password"
        className={`border-2 p-3 border-gray-100 text-gray-200 ${errors.password && 'border-red-500! text-red-500!'} `}
        type="password"
        name="password"
        id="password_register"
        icon={`fa-solid fa-lock fa-xl top-6 text-gray-200 ${errors.password && 'text-red-500!'} `}
        onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('password', e.target.value)}
        value={form.data.password}
      />
      <AnimatePresence>
        {errors.password && (
          <motion.div
            initial={{ opacity: 0, y: -20 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -4 }}
            transition={{ duration: 0.25 }}
          >
            <AlertMessage message={errors.password} />
          </motion.div>
        )}
      </AnimatePresence>

      <InputFillable
        placeholder="Confirmar Password"
        className={`border-2 p-3 border-gray-100 text-gray-200 ${errors.password_confirmation && 'border-red-500! text-red-500!'} `}
        type="password"
        name="password_confirmation"
        id="password_confirmation_register"
        icon={`fa-solid fa-lock fa-xl top-6 text-gray-200 ${errors.password_confirmation && 'text-red-500!'} `}
        onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('password_confirmation', e.target.value)}
        value={form.data.password_confirmation}
      />
      <AnimatePresence>
        {errors.password_confirmation && (
          <motion.div
            initial={{ opacity: 0, y: -20 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -4 }}
            transition={{ duration: 0.25 }}
          >
            <AlertMessage message={errors.password_confirmation} />
          </motion.div>
        )}
      </AnimatePresence>

      <div className="w-2/4 my-4 mx-auto">
        <Button
          type="submit"
          variant="transition-blue"
          className="text-white!"
        >
          Crear Cuenta
        </Button>
      </div>
    </form>
  );
}
