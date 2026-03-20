import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"

interface ActiveReportIteraibleFilterProps {
    setIsOpen: React.Dispatch<React.SetStateAction<boolean>>
    isOpen: boolean
    iterable: string[]
    title : string | React.ReactNode
}
export default function ActiveReportIteraibleFilter({
    setIsOpen,
    isOpen,
    iterable,
    title
}: ActiveReportIteraibleFilterProps) {
  return (
    <div>
        <button
        type="button"
        className="flex items-center gap-2 text-sm text-gray-600 hover:text-blue-600 transition-colors"
        onClick={() => setIsOpen(prev => !prev)}
        >
            <i className="fa-solid fa-tag text-orange-500"></i>
            <span>{iterable.length} {title}</span>
            <i className={`fa-solid fa-chevron-${isOpen ? 'up' : 'down'} transition-all `}></i>
        </button>
        <TransitionMotion active={isOpen} initial={{ x: 0, y: -10, opacity: 0 }} exit={{ x: 0, y: -10, opacity: 0 }}>
            <ul className="ml-6 mt-2 space-y-1 text-xs text-gray-500">
                {iterable.map((item, index) => (
                <li key={index}>• {item}</li>
                ))}
            </ul>
        </TransitionMotion>
        </div>
  )
}
