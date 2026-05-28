/**
 * Página de registro (Crear Cuenta Administrador).
 * Mantiene la misma estructura visual y estilos que la página de Login.
 * @module resources/js/Pages/Register
 */

import GuestLayout from "@/Layouts/GuestLayout";
import Card from "@/app/shared/components/common/Card";
import Title from "@/app/shared/components/common/Title";
import Logo from "@/app/shared/components/common/Logo";
import RegisterForm from "@/app/domains/auth/components/register/RegisterForm";
import AlertMessage from "@/app/shared/components/common/AlertMessage";
import { motion, AnimatePresence } from "framer-motion";
import useRegister from "@/app/domains/auth/hooks/useRegister";
import { useMessageRedirect } from "@/app/shared/hooks";

/**
 * Página principal para crear el primer usuario administrador.
 */
export default function Register() {
  const { form, handleSubmit } = useRegister();
  const { flash } = useMessageRedirect();

  return (
    <div className="w-1/4 mx-auto">
      <Card
        className="rounded-2xl!"
      >
        <Logo className="w-1/3 mx-auto" />
        <Title title="Crear Cuenta Administrador" className="text-center text-gray-200 font-cursiva my-4" />
        <Title title="Registro" size="md" className="text-center text-gray-200"></Title>
        <AnimatePresence>
          {flash.error && (
            <motion.div
              initial={{ opacity: 0, y: -4 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -4 }}
              transition={{ duration: 0.25 }}
            >
              <AlertMessage message={flash.error} />
            </motion.div>
          )}
          {flash.success && (
            <motion.div
              initial={{ opacity: 0, y: -4 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -4 }}
              transition={{ duration: 0.25 }}
            >
              <AlertMessage type="success" message={flash.success} />
            </motion.div>
          )}
        </AnimatePresence>

        <RegisterForm form={form} onSubmit={handleSubmit} />

      </Card>
    </div>
  );
}

Register.layout= (page: React.ReactNode)=> <GuestLayout children={page} />

