import List from "../common/List"
import NavItem from "./NavItem"
import { useRoute } from "ziggy-js"
import { NavItems } from "../../types/components"
export default function NavBar({
    isOpen
}:{
    isOpen : boolean
}) {
  const route= useRoute()
  return (
     <List className="w-full h-155 flex flex-col ">
            {
                NavItems.map((item) => (
                    <NavItem 
                    {...item}
                    isOpen={isOpen} 
                    key={item.key}
                     />
                ))
            }

     </List>
  )
}
