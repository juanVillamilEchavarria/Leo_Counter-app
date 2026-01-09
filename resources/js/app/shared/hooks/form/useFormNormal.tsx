import { useForm } from "@inertiajs/react";
import { type FormDataNormalProps } from "../../types";
export default function useFormNormal<TData extends Record<string, any>>({
    action,
    method = 'post',
    data ,
}: FormDataNormalProps<TData>) {
    const form = useForm(data);
    const {delete : destroy} = form

    const submit = ()=>{
      form.clearErrors() 
      const actions = {
            post: form.post,
            put: form.put,
            patch: form.patch,
            delete: destroy,
      }
      actions[method]?.(action)

    }
    const handleSubmit = (e: React.FormEvent<HTMLFormElement>, ) => {
        e.preventDefault();
        submit();
         
    }
  return {
    form,
    submit,
    handleSubmit

  }
}
