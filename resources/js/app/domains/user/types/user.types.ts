export type User = {
    id: number,
    name: string,
    email: string,
    email_verified_at?: string,
    password?: string,
    remember_token?: string,
    role: keyof typeof Roles,
    created_at?: string,
    updated_at?: string
}

export const Roles = {
    admin: 'admin',
    member: 'member',
    assistant: 'assistant'
} as const

export type UserLogin = Pick<User, 'email' | 'password' >&{
    remember: boolean
}

export type UserRegister = Omit<User, 'id' | 'email_verified_at'| 'created_at' | 'updated_at' | 'remember_token'| 'role'>&{
    password_confirmation: string
}

export type SelfUserCardProps={
    isOpen : boolean
    user:{
        name: string | undefined,
        role: string | undefined
    }
}
export type useSelfUserCardProps={
    isOpen: boolean
}
