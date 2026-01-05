import "./bootstrap";
import "../css/app.css"
import AppLayout from "./Layouts/AppLayout";
import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'

createInertiaApp({
    title: title => title ? `${title} - ${import.meta.env.VITE_APP_NAME}`: import.meta.env.VITE_APP_NAME,
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.tsx', { eager: true })
        const page: any = pages[`./Pages/${name}.tsx`]

        //  layout por defecto es AppLayout
        page.default.layout =
            page.default.layout ||
            ((page: React.ReactNode) => <AppLayout children={page} />)
        return page
    },
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />)
    },
})