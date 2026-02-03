import { useDropzone } from "react-dropzone"
import { type DropZoneProps } from "../../types"
import { type FileRejection } from "react-dropzone"
export default function DropZone({
    rejectedFiles,
    onDrop,
    onDropRejected,
    children,
    accept = {'application/pdf': []},
    className = ''
}:DropZoneProps) {
      const {getRootProps, getInputProps, isDragActive, acceptedFiles, fileRejections} = useDropzone({onDrop, accept: accept, maxFiles: 3, onDropRejected})
  return (
        <div {...getRootProps()} className={` p-2 rounded-lg border-2  border-dashed cursor-pointer ${rejectedFiles.length > 0 ?'border-red-500 bg-red-500/20 text-red-500' : 'bg-white/2 border-gray-500 hover:bg-white/10' } ${className}`}>
        <input {...getInputProps()} />
        <div className="w-full flex flex-col items-center relative">
            <i className="fa-solid fa-image text-4xl"></i> 
            <p className="font-2xl">Arrastra o selecciona un archivo</p>
            {children}
                
        </div>
        </div>
  )
}
