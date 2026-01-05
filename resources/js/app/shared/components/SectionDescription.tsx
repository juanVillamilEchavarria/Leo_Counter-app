import Tittle from "./Tittle"
export default function SectionDescription({
    tittle,
    paragraph
}:{
    tittle: string,
    paragraph: string
}) {
  return (
   <> 
        <Tittle tittle={tittle} size="4xl" className="text-center font-cursiva" />
        <p className="text-center text-lg font-principal mt-2 ">{paragraph}</p>
   </>
  )
}
