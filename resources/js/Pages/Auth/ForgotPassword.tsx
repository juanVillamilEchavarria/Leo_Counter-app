/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import GuestLayout from "@/Layouts/GuestLayout"
import AlertMessage from "@/app/shared/components/common/AlertMessage"
import Card from "@/app/shared/components/common/Card"
import Logo from "@/app/shared/components/common/Logo"
import Title from "@/app/shared/components/common/Title"
import { useMessageRedirect } from "@/app/shared/hooks"
import ForgotPasswordForm from "@/app/domains/auth/components/forgot-password/ForgotPasswordForm"
import useForgotPassword from "@/app/domains/auth/hooks/useForgotPassword"

function ForgotPassword() {
    const { flash } = useMessageRedirect()
    const { form, handleSubmit } = useForgotPassword()

    return (
        <div className="w-full max-w-md mx-auto">
            <Card className="rounded-2xl!">
                <Logo className="w-1/3 mx-auto" />
                <Title title="Restablecer contraseña" size="md" className="text-center text-gray-200 my-4" />
                {flash.success && <AlertMessage message={flash.success} type="success" />}
                <ForgotPasswordForm form={form} onSubmit={handleSubmit} />
            </Card>
        </div>
    )
}

ForgotPassword.layout = (page: React.ReactNode) => <GuestLayout children={page} />

export default ForgotPassword
