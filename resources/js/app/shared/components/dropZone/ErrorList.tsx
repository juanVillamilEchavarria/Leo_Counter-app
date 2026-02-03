import TransitionMotion from "../transitions/TransitionMotion"
import List from "../common/List"
import { type FileRejection } from "react-dropzone"
export default function ErrorList({
    rejectedFiles
}:{
    rejectedFiles : FileRejection[]
}) {
  return (
     <TransitionMotion active={rejectedFiles.length > 0}>
            <List className="mt-2 text-sm text-red-400">
                {rejectedFiles.map((rejection, index) => (
                <li key={index}>
                    <strong>{rejection.file.name}</strong>
                    <ul className="ml-4 list-disc">
                    {rejection.errors.map(err => (
                        <li key={err.code}>
                        {err.message}
                        </li>
                    ))}
                    </ul>
                </li>
                ))}
            </List>
        </TransitionMotion>
  )
}
