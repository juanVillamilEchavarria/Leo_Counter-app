// Archivo obsoleto tras refactor del módulo Profile a Usuario. Conservado comentado por trazabilidad.
// import { useFormNormal } from "@/app/shared/hooks"
// import { type InertiaFormProps } from "@inertiajs/react";
// import { type ProfileUserData, type PasswordProfileUserData,ProfileActions } from "../types/profile.types";
// interface useProfileProps<T extends ProfileUserData | PasswordProfileUserData> {
//     data ?: T
//     action ?: keyof typeof ProfileActions
// }
// interface useProfileReturn<T extends ProfileUserData | PasswordProfileUserData> {
//     form: InertiaFormProps<T>,
//     submit: ReturnType<typeof useFormNormal>['submit'],
//     handleSubmit: ReturnType<typeof useFormNormal>['handleSubmit']
// }
// /**
//  * Overloads del hook useProfile para manejar tanto la actualizacion del perfil como el cambio de contraseña, dependiendo de los datos que se le pasen y la accion que se quiera realizar, si se le pasan los datos del perfil y la accion es 'profileUpdate' se manejara la actualizacion del perfil, si se le pasan los datos para el cambio de contraseña y la accion es 'passwordUpdate' se manejara el cambio de contraseña
//  * 
//  */
// export default function useProfile(props: { data: PasswordProfileUserData | undefined,action:'passwordUpdate'}):  useProfileReturn<PasswordProfileUserData>;
// export default function useProfile(props : {data: ProfileUserData | undefined, action : 'profileUpdate'}):  useProfileReturn<ProfileUserData>;
// 
// /**
//  * Hook que manejara la actualizacion del perfil y cambio de contraseña del usuario , se encargara de manejar el formulario y la logica de envio de datos al backend
//  * @param {ProfileUserData | PasswordProfileUserData} data - los datos del usuario logueado o para el cambio de contraseña, dependiendo del formulario que se quiera manejar, si es para el perfil se debe enviar un objeto con los campos name, email e id, si es para el cambio de contraseña se debe enviar un objeto con los campos current_password, password y password_confirmation
//  * @param {keyof typeof ProfileActions} action - la accion que se quiere realizar, puede ser 'profileUpdate' para actualizar el perfil o 'passwordUpdate' para cambiar la contraseña, por defecto es 'profileUpdate'
//  * @returns {form, submit, handleSubmit} form: los datos del formulario, submit: funcion para enviar el formulario, handleSubmit: funcion para manejar el evento de submit del formulario
//  */
// export default function useProfile({
//     data,
//     action = 'profileUpdate'
// }: useProfileProps<ProfileUserData | PasswordProfileUserData>) {
//   const { form, submit, handleSubmit } = useFormNormal({
//     action: ProfileActions[action],
//     method: 'put',
//     data
//   });
// 
//   return {
//     form,
//     submit,
//     handleSubmit
//   }
// }
