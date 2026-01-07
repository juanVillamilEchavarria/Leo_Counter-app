import Title from "./Title"
export default function SectionDescription({
    title,
    paragraph
}:{
    title: string,
    paragraph: string
}) {
  return (
   <> 
        <Title title={title} size="4xl" className="text-center font-principal" />
        <p className="text-center text-lg font-principal mt-2 ">{paragraph}</p>
   </>
  )
}
