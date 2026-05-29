import React from "react";
import { createPortal } from "react-dom";
import SidebarDesktop from '@/app/shared/components/sidebar/SidebarDesktop';
import SidebarMobile from '@/app/shared/components/sidebar/SidebarMobile';
import { useMessageRedirect } from "../../hooks";

interface SideBarAppProps {
  isOpen: boolean;
  setIsOpen: React.Dispatch<React.SetStateAction<boolean>>;
  isMobileOpen: boolean;
  setIsMobileOpen: React.Dispatch<React.SetStateAction<boolean>>;
}

export default function SideBarApp({
  isOpen,
  setIsOpen,
  isMobileOpen,
  setIsMobileOpen,
}: SideBarAppProps) {
  const { props } = useMessageRedirect();
  const user = props?.auth?.user;
  const transitionStyle = "transition-all duration-400";

  return (
    <>
      {/* Overlay móvil */}
      {isMobileOpen && (
        <div
          className="fixed inset-0 z-40 bg-black/50 lg:hidden"
          onClick={() => setIsMobileOpen(false)}
          aria-hidden="true"
        />
      )}

        {/* Versión de escritorio: forma parte del layout */}
        <SidebarDesktop isOpen={isOpen} setIsOpen={setIsOpen} user={user ?? null} />

        {/* Versión móvil/tablet: montada en portal fuera del flujo del DOM */}
        <SidebarMobile isOpen={isMobileOpen} setIsOpen={setIsMobileOpen} user={user ?? null} />
    </>
  );
}
