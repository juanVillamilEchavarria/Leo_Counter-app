import Title from "./Title"
export default function SectionDescription({
    title,
    className,
    paragraph
}:{
    title: string,
    className ?: string
    paragraph: string | React.ReactNode
}) {
  return (
   <div className={`flex flex-col justify-center items-center ${className}`}> 
        <Title title={title} size="4xl" className={` font-principal `} />
        <p className="text-lg font-principal mt-2 ">{paragraph}</p>
   </div>
  )
}
