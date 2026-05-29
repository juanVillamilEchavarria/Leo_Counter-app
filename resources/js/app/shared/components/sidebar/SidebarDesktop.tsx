import React from 'react';
import SideBar from '@/app/shared/components/sidebar/SideBar';
import SideBarToggle from '@/app/shared/components/sidebar/SideBarToggle';
import SidebarContent from '@/app/shared/components/sidebar/SidebarContent';

/**
 * SidebarDesktop
 *
 * Molecula encargada del sidebar en vista de escritorio (lg+).
 * Renderiza el contenedor del sidebar, el toggle lateral y el contenido interno.
 *
 * @author Juan Villamil
 * @since 1.0.0
 * @description Sidebar de escritorio con animación de colapso mediante utilidades de Tailwind.
 */
export default function SidebarDesktop({
  isOpen,
  setIsOpen,
  user,
}: {
  isOpen: boolean;
  setIsOpen: React.Dispatch<React.SetStateAction<boolean>>;
  user: { name?: string; role?: string } | null;
}) {
  const transitionStyle = 'transition-all duration-400';

  return (
    <SideBar
      className={`hidden lg:grid h-full lg:relative scrollbar-none ${
        isOpen ? 'lg:w-80 lg:min-w-80' : 'lg:w-20 lg:min-w-15'
      } ${transitionStyle}`}
    >
      <SideBarToggle isOpen={isOpen} setIsOpen={setIsOpen} className="hidden lg:flex" />
      <SidebarContent isOpen={isOpen} user={{ name: user?.name, role: user?.role }} />
    </SideBar>
  );
}
