/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import GuestLayout from "@/Layouts/GuestLayout"
import Card from "@/app/shared/components/common/Card"
import Title from "@/app/shared/components/common/Title"
import Logo from "@/app/shared/components/common/Logo"
import ResetPasswordForm from "@/app/domains/auth/components/reset-password/ResetPasswordForm"
import useResetPassword from "@/app/domains/auth/hooks/useResetPassword"
import type { ResetPasswordProps } from "@/app/domains/auth/types/password-reset.types"

function ResetPassword({ email, token }: ResetPasswordProps) {
    const { form, handleSubmit } = useResetPassword({ email, token })

    return (
        <div className="w-full max-w-md mx-auto">
            <Card className="rounded-2xl!">
                <Logo className="w-1/3 mx-auto" />
                <Title title="Nueva contraseña" size="md" className="text-center text-gray-200 my-4" />
                <ResetPasswordForm form={form} onSubmit={handleSubmit} />
            </Card>
        </div>
    )
}

ResetPassword.layout = (page: React.ReactNode) => <GuestLayout children={page} />

export default ResetPassword
