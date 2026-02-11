import axios from "axios";
const AxiosClient = axios.create({
    baseURL: `${import.meta.env.VITE_API_URL}/api`, 
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    },
    withCredentials: true,
    withXSRFToken: true
    
})
export default AxiosClient