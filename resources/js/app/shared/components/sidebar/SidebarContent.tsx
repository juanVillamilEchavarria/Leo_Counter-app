/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import React from "react";
import Logo from "@/app/shared/components/common/Logo";
import Title from "@/app/shared/components/common/Title";
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion";
import NavBar from "@/app/shared/components/navBar/NavBar";
import SelfUserCard from "@/app/domains/user/components/SelfUserCard";

/**
 * SidebarContent
 *
 * @author Juan Villamil (Copilot)
 * @since 2026-05-28
 * @description
 *   Componente reutilizable que contiene el contenido interior del sidebar
 *   (logo, título, navegación y tarjeta de usuario). Diseñado para usarse
 *   tanto dentro del sidebar de escritorio como en el panel montado por
 *   portal en dispositivos móviles. Mantiene la misma estructura y clases
 *   Tailwind que la implementación original.
 */
export interface SidebarContentProps {
  /** Controla expansión/colapso visual en escritorio. En móvil debe pasarse true. */
  isOpen: boolean;
  /** Usuario autenticado o null */
  user: { name?: string; role?: string } | null;
}

export default function SidebarContent({ isOpen, user }: SidebarContentProps) {
  const transitionStyle = "transition-all duration-400";

  return (
    <div className="grid grid-rows-[auto_1fr] overflow-hidden">
      <div className="flex w-full gap-5 p-2 mt-4 h-15">
        <div className="w-12 h-12 shrink-0">
          <Logo className="w-full h-full object-cover" />
        </div>

        <TransitionMotion active={isOpen} initial={{ opacity: 0, x: -70 }}>
          <Title
            size="md"
            title="Leo Counter"
            className="text-center font-cursiva my-4 whitespace-nowrap"
          />
        </TransitionMotion>
      </div>

      <div className={`flex flex-col my-5 overflow-y-scroll scrollbar-modern ${transitionStyle}`}>
        <NavBar isOpen={isOpen} />
      </div>

      <div className="my-2 p-2 border-t border-border/20">
        <SelfUserCard user={{ name: user?.name, role: user?.role }} isOpen={isOpen} />
        <div className="mt-5 h-5">
          <TransitionMotion active={isOpen} initial={{ opacity: 0, x: -70 }}>
            <p className="m-0 text-center text-xs whitespace-nowrap">
              En memoria de Leonardo Villamil &copy;
            </p>
          </TransitionMotion>
        </div>
      </div>
    </div>
  );
}
