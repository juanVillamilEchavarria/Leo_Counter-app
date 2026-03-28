import { setPageMode, getPageMode } from "../../helpers/pageMode/pageMode.helpers"
import { pageModes } from "../../types/pageMode/pageMode.types"
import { useState } from "react"
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from "../ui/dropdown-menu"
import { Button } from "../ui/button"

export default function PageModeSelect() {
    const [current, setCurrent] = useState(getPageMode)

    const handleSelect = (value: number) => {
        setPageMode(value)
        setCurrent(value)
    }

    const currentMode = Object.values(pageModes).find(m => m.value === current)

    return (
        <DropdownMenu>
            <DropdownMenuTrigger asChild>
                <Button variant="outline" className="gap-2 text-foreground">
                    <i className={`fa-solid ${currentMode?.icon}`} />
                    <span>{currentMode?.label}</span>
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
                {Object.values(pageModes).map((m) => (
                    <DropdownMenuItem
                        key={m.value}
                        onClick={() => handleSelect(m.value)}
                        className="gap-2 cursor-pointer"
                    >
                        <i className={`fa-solid ${m.icon}`} />
                        <span>{m.label}</span>
                    </DropdownMenuItem>
                ))}
            </DropdownMenuContent>
        </DropdownMenu>
    )
}