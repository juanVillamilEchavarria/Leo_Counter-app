import { type FileRejection } from "react-dropzone";
import { type FileWithPreview } from "../formData";

export type DropZoneProps = {
  rejectedFiles: FileRejection[];
  children?: React.ReactNode;
  onDrop: (acceptedFiles: File[]) => void;
  onDropRejected: (fileRejections: FileRejection[]) => void;
  accept?: { [key: string]: string[] };
  className?: string;
  maxFiles?: number
};


export type UploadedFileListProps = {
  as?: React.ElementType
  files: FileWithPreview[];
  handleDeleteFile: (index: number, id?: number) => void;
  active?: boolean;
  modifyable?: boolean
  className?: string
  preview_route ?: (id: number) => string
};
