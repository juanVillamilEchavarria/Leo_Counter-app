 import GuestLayout from "@/Layouts/GuestLayout"
 import Card from "@/app/shared/components/common/Card"
 import Title from "@/app/shared/components/common/Title"
 import Logo from "@/app/shared/components/common/Logo"
 import LoginForm from "@/app/domains/auth/components/login/LoginForm"
 import AlertMessage from "@/app/shared/components/common/AlertMessage"
 import { useMessageRedirect } from "@/app/shared/hooks"
 import { motion, AnimatePresence } from 'framer-motion'
 function Login() {
  const {flash} = useMessageRedirect()
  

  return (
    <div className="w-full max-w-md mx-auto">
        <Card
        className="rounded-2xl!"
        >
            <Logo className="w-1/3 mx-auto" />
            <Title title="Hola De Nuevo Familia" className="text-center text-gray-200 font-cursiva my-4" />
            <Title title="Inicia Sesion" size="md" className="text-center text-gray-200"></Title>
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
            </AnimatePresence>
            <LoginForm />
            

   </Card>
    </div>
   
  )
}

Login.layout= (page: React.ReactNode)=> <GuestLayout children={page} />

export default Login
