import { useFormNormal } from "@/app/shared/hooks"
export default function useLogout() {
  const {form, handleSubmit} = useFormNormal({
    action: '/logout',
    data: {}
  })
  return {
    form,
    handleSubmit
  }
}
