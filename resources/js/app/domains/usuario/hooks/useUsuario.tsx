import { useFormNormal } from "@/app/shared/hooks"
import { type InertiaFormProps } from "@inertiajs/react";
import { type UsuarioData, type UsuarioPasswordData, UsuarioActions } from "../types/usuario.types";

interface UseUsuarioProps<T extends UsuarioData | UsuarioPasswordData> {
    data?: T
    action?: keyof typeof UsuarioActions
}

interface UseUsuarioReturn<T extends UsuarioData | UsuarioPasswordData> {
    form: InertiaFormProps<T>,
    submit: ReturnType<typeof useFormNormal>['submit'],
    handleSubmit: ReturnType<typeof useFormNormal>['handleSubmit']
}

export default function useUsuario(props: { data: UsuarioPasswordData | undefined, action: 'cambiarPassword' }): UseUsuarioReturn<UsuarioPasswordData>;
export default function useUsuario(props: { data: UsuarioData | undefined, action: 'updateDatosPublicos' }): UseUsuarioReturn<UsuarioData>;

export default function useUsuario({
    data,
    action = 'updateDatosPublicos'
}: UseUsuarioProps<UsuarioData | UsuarioPasswordData>) {
  const { form, submit, handleSubmit } = useFormNormal({
    action: UsuarioActions[action],
    method: 'put',
    data
  });

  return {
    form,
    submit,
    handleSubmit
  }
}
