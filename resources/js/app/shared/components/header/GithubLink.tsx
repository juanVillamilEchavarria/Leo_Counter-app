export default function GithubLink() {
  return (
    <div className="flex gap-2 items-center mr-4 text-foreground">
        <i className="fa-brands fa-github text-2xl"></i>
        <a href={import.meta.env.VITE_GITHUB_REPOSITORY} target="_blank" rel="noopener noreferrer">Leo Counter</a>
    </div>
  )
}
