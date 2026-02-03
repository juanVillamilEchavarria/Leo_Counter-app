import { useForm } from "@inertiajs/react";
import { type FormDataNormalProps } from "../../types";
export default function useFormNormal<TData extends Record<string, any>>({
    action,
    method = 'post',
    data ,
}: FormDataNormalProps<TData>) {
    const form = useForm(data);
    const {delete : destroy} = form
            const submit = (options?: Parameters<typeof form.post>[1]) => { // se le pueden pasar opciones, la posicion 1 es options de form.post
                  if (!action) return // si no hay action no hace nada
                  form.clearErrors() // limpia errores antes de enviar
                  const methodMap = {
                    post: () => form.post(action, options),
                    put: () => form.put(action, options),
                    patch: () => form.patch(action, options),
                    delete: () => destroy(action, options),
                  } as const
                  methodMap[method]?.()
          }
    const handleSubmit = (e: React.FormEvent<HTMLFormElement>, options?: Parameters<typeof form.post>[1] ) => {
        e.preventDefault();
        submit( options);   
    }
  return {
    form,
    submit,
    handleSubmit

  }
}
