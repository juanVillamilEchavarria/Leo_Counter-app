import { useForm } from '@inertiajs/react';
import type {SuscriptorFormData} from "@/app/domains/notificacion";

export function useSuscriptorForm({
    existingData
                                  }:{
    existingData?: SuscriptorFormData
}) {
    return useForm<SuscriptorFormData>({
        user_id: existingData?.user_id ?? '',
        canal_notificacion_id: existingData?.canal_notificacion_id ?? '',
    });
}
