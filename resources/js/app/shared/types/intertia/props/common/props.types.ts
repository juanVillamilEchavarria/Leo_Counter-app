import { type User } from "@/app/domains/user"
export type InertiaProps = {
    errors?: Record<string, string>,
    auth?: {
        user?: User
    }
    title?: string,
    NoRegistros?: number
}