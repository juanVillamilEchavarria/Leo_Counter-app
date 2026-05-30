/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import "./bootstrap";
import "../css/app.css"
import AppLayout from "./Layouts/AppLayout";
import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'
import { restorePageMode } from "./app/shared/helpers/pageMode/pageMode.helpers";
import { configureEcho } from '@laravel/echo-react';

configureEcho({
    broadcaster: 'reverb',
});



restorePageMode()
createInertiaApp({

    title: title => title ? `${title} - Leo Counter`: 'Leo Counter',
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
