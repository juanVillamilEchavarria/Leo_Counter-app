import { useForm } from "@inertiajs/react";
import { type FormDataNormalProps } from "../../types";
/**
 * Hook para manejar las request de formularios  usando useForm de inertia, soporta los metodos normales, post, put, patch y delete
 * @param {string} action - la ruta a la que se enviara el formulario
 * @param {'post' | 'put' | 'patch' | 'delete'} method
 * @param {Record<string, any>} data - los datos iniciales del formulario, se pueden actualizar con form.setData
 * @returns  {form, submit, handleSubmit} - form es el objeto de useForm, submit es una funcion para enviar el formulario manualmente, handleSubmit es una funcion para usar en el onSubmit del formulario
 */
export default function useFormNormal<TData extends Record<string, any>>({
    action,
    method = 'post',
    data ,
}: FormDataNormalProps<TData>) {
    const form = useForm<TData>(data as TData);
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
