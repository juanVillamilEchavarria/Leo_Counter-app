import axios from "axios";
const AxiosClient = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    },
    withCredentials: true,
    withXSRFToken: true
    
})
let csrfInitialized = false;
// Interceptor para obtener CSRF cookie
AxiosClient.interceptors.request.use(async (config) => {
    if (!csrfInitialized) {
        try {
            await axios.get('/sanctum/csrf-cookie', {
                withCredentials: true
            });
            csrfInitialized = true;
            console.log('✅ CSRF cookie obtenido');
        } catch (error) {
            console.error('❌ Error obteniendo CSRF cookie:', error);
        }
    }
    return config;
});

// Interceptor de respuesta para debug
AxiosClient.interceptors.response.use(
    (response) => {
        console.log('✅ Respuesta exitosa:', response.data);
        return response;
    },
    (error) => {
        console.error('❌ Error en API:', {
            status: error.response?.status,
            message: error.response?.data?.message,
            errors: error.response?.data?.errors
        });
        return Promise.reject(error);
    }
);

export default AxiosClient