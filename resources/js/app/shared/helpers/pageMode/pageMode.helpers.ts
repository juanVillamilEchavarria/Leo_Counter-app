import { pageModes } from "../../types/pageMode/pageMode.types"
type PageModeValue = typeof pageModes[keyof typeof pageModes]['value']

/**
 * "Strategies" para los distintos modos de página
 */
const modeHandlers: Record<PageModeValue, () => void> = {
    [pageModes.light.value]: () => {
        document.documentElement.classList.remove('dark')
        persistPageMode(pageModes.light.value)
    },
    [pageModes.dark.value]: () => {
        document.documentElement.classList.add('dark')
        persistPageMode(pageModes.dark.value)
    },
    [pageModes.auto.value]: () => {
        const prefersDark = getSystemPageMode()
        document.documentElement.classList.toggle('dark', prefersDark)
        persistPageMode(pageModes.auto.value)
    },
}

export const setPageMode = (mode: PageModeValue): void => {
    const handler = modeHandlers[mode]
    if (!handler) throw new Error(`Modo de página no soportado: ${mode}`)
    handler()
}

export const getPageMode = (): PageModeValue => {
    const saved = localStorage.getItem('page-mode')
    return saved ? Number(saved) : pageModes.auto.value
}

/**
 * Restaura el modo de página guardado en el localStorage o el que el usuario tiene preferido en su sistema operativo
 */
export const restorePageMode = (): void => {
    const mode = getPageMode()
    setPageMode(mode as PageModeValue)
}

/**
 * Coloca el modo de página en el localStorage
 * @param {PageModeValue} mode 
 */
const persistPageMode = (mode: PageModeValue): void => {
    localStorage.setItem('page-mode', String(mode))
}

/**
 *  Obtiene el modo de página del sistema
 * @return {boolean}
 */
const getSystemPageMode = (): boolean => {
    return window.matchMedia('(prefers-color-scheme: dark)').matches
}