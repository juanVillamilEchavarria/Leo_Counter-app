/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
