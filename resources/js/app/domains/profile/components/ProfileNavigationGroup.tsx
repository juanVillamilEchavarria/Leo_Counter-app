import { Link } from "lucide-react"
import { ProfileRoutes, ProfileNavItems } from "../types/profile.types"
import ProfileNavigationItem from "./ProfileNavigationItem"

export default function ProfileNavigationGroup() {
  return (
    <div className="w-[80%] mx-auto mt-10 flex gap-3 border-b border-border ">
           {ProfileNavItems.map((item) => (
            <ProfileNavigationItem  icon={item.icon} routeName={item.routeName} title={item.title} href={item.href} key={item.key}/>
          ))}
        </div>
  )
}
