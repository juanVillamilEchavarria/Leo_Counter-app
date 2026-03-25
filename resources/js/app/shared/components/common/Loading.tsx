export default function Loading({
    text,
    paragraph
}:{
    text: string,
    paragraph: string
}) {
  return (
    <div className="flex flex-col items-center justify-center min-h-100 space-y-4">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
        <div className="text-center space-y-2">
        <h3 className="text-lg font-semibold text-gray-900">{text}</h3>
        <p className="text-sm text-gray-500">{paragraph}</p>
        </div>
    </div>
  )
}
