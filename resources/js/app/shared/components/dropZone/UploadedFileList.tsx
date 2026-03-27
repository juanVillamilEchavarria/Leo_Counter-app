import TransitionMotion from "../transitions/TransitionMotion"
import { type UploadedFileListProps } from "../../types"

export default function UploadedFileList({
    files,
    handleDeleteFile,
    active = true,
    preview_route,
    className = 'text-primary-foreground/80'
}: UploadedFileListProps) {
  return (
    <TransitionMotion active={active} transition={{duration: .5}}>
            <ul className={`w-3/4 flex flex-col gap-2 ${className}`}>
            {files.map((file, index) => (
            <li
                key={file.id ?? index}
                className=" p-4 rounded-2xl  flex flex-col gap-2"
            >
                <button
                className="cursor-pointer flex justify-end"
                onClick={() => handleDeleteFile(index, file?.id)}
                type="button"
                >
                <i className="fa-solid fa-xmark text-md"></i>
                </button>
                <iframe
                src={file.id !== undefined && preview_route ? preview_route(file.id) : file.preview}
                className="w-full h-40 rounded-xl border"
                />
                <p className="text-sm  truncate">
                {file.name ?? file.nombre}
                </p>
            </li>
            ))}
            </ul>
    </TransitionMotion>
  )
}
