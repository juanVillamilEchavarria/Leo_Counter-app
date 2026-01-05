import { useForm } from "@inertiajs/react";
import { type FormDataNormalProps } from "../../types";
export default function useFormNormal<TData extends Record<string, any>, TActions extends string>({
    action,
    data ,
}: FormDataNormalProps<TData, TActions>) {
    const form = useForm(data);
    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
         form.clearErrors()   
        form.post(action, {
            onSuccess: () => form.reset(),
        });
    }
  return {
    form,
    handleSubmit
  }
}
