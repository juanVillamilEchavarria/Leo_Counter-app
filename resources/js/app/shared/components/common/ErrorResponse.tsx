export default function ErrorResponse({
    text,
    paragraph
}:{
    text: string,
    paragraph: string
    
}) {
  return (
    <div className="flex flex-col items-center justify-center min-h-100 space-y-4">
          <div className="text-red-500">
            <i className="fa-solid fa-exclamation-triangle text-4xl"></i>
          </div>
          <div className="text-center space-y-2">
            <h3 className="text-lg font-semibold text-gray-900">{text}</h3>
            <p className="text-sm text-muted-foreground">{paragraph}</p>
            <button
              onClick={() => window.location.reload()}
              className="mt-4 px-4 py-2 bg-blue-600 text-primary-foreground rounded-lg hover:bg-blue-700 transition-colors"
            >
              Intentar nuevamente
            </button>
          </div>
        </div>
  )
}
