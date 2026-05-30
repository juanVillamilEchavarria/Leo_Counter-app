/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import List from "../common/List"
import NavItem from "./NavItem"
import { useRoute } from "ziggy-js"
import { NavItems } from "../../types/components"
import {useMessageRedirect} from "@/app/shared/hooks";
export default function NavBar({
    isOpen
}:{
    isOpen : boolean
}) {
    const {props}= useMessageRedirect();
    const user= props.auth?.user;
    const filteredItems = NavItems.filter(item => {
        if (!item.roles || item.roles.length === 0) return true;
        return user && item.roles.includes(user.role);
    });
  const route= useRoute()
  return (
     <List className="w-full h-155 flex flex-col ">
            {
                filteredItems.map((item) => (
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
