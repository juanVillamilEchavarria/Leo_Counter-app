import { type FileRejection } from "react-dropzone";
import { type FileWithPreview } from "../formData";

export type DropZoneProps = {
  rejectedFiles: FileRejection[];
  children?: React.ReactNode;
  onDrop: (acceptedFiles: File[]) => void;
  onDropRejected: (fileRejections: FileRejection[]) => void;
  accept?: { [key: string]: string[] };
  className?: string;
};


export type UploadedFileListProps = {
  files: FileWithPreview[];
  handleDeleteFile: (index: number) => void;
  active?: boolean;
};
