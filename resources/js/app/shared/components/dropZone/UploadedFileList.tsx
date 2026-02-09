import TransitionMotion from "../transitions/TransitionMotion"
import { type UploadedFileListProps } from "../../types"
export default function UploadedFileList({
    files,
    handleDeleteFile,
    active = true,
    className = 'text-white/80'
}: UploadedFileListProps) {
  return (
    <TransitionMotion active={active} transition={{duration: .5}}>
            <ul className={`w-3/4 flex flex-col gap-2 ${className}`}>
            {files.map((file, index) => (
            <li
                key={index}
                className=" p-4 rounded-2xl  flex flex-col gap-2"
            >
                <button
                className="cursor-pointer flex justify-end"
                onClick={() => handleDeleteFile(index)}
                type="button"
                >
                <i className="fa-solid fa-xmark text-md"></i>
                </button>
                <iframe
                src={file.preview}
                className="w-full h-40 rounded-xl border"
                />
                <p className="text-sm  truncate">
                {file.name}
                </p>
            </li>
            ))}
            </ul>
    </TransitionMotion>
  )
}
