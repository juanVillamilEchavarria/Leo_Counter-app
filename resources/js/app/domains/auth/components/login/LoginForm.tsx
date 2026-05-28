 import InputFillable from "@/app/shared/components/form/InputFillable"
 import Button from "@/app/shared/components/common/Button"
 import AlertMessage from "@/app/shared/components/common/AlertMessage"
 import { Link } from "@inertiajs/react"
 import useAuth from "../../hooks/useAuth"
 import { motion, AnimatePresence } from 'framer-motion'
 import { useRoute } from "ziggy-js"
export default function LoginForm() {
    const router = useRoute()
    const {form, handleSubmit} = useAuth({
        type: 'login'
    })
    const {setData, errors} = form 
    
  return (
    <form onSubmit={handleSubmit} className="flex flex-col gap-4 p-2">
                <InputFillable 
                    placeholder="Email" 
                    className={`border-2 p-3 border-gray-100 text-gray-200 ${errors.email && 'border-red-500! text-red-500!'} `}
                    type="email" 
                    name="email"
                    id="email_login" 
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
                    id="password_login" 
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
                                transition={{ duration: 0.25}}
                            >
                            <AlertMessage message={errors.password} />
                            </motion.div>
                        )}
                </AnimatePresence>
                <div className="w-2/4 my-4 mx-auto">
                     <Button 
                        type="submit"
                        variant="transition-blue"
                        className="text-white!"
                     >
                        Login

                     </Button>
                </div>
                <div className="flex w-full  justify-between">
                    <Link 
                        href="/forgot-password"
                        className="text-gray-200 text-sm hover:underline"
                     >
                    ¿Olvidaste tu contraseña?
                    </Link>
                </div>
            

    </form>
  )
}
