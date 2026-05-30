/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import React from 'react';
import { createPortal } from 'react-dom';
import TransitionMotion from '@/app/shared/components/transitions/TransitionMotion';
import SidebarContent from '@/app/shared/components/sidebar/SidebarContent';

/**
 * SidebarMobile
 *
 * Molécula encargada del sidebar en dispositivos móviles. Monta un portal en
 * document.body que contiene un overlay y un panel lateral animado con
 * TransitionMotion. El panel aplica `text-foreground` para asegurar la herencia
 * correcta del color del texto en el portal.
 *
 * @author Juan Villamil
 * @since 1.0.0
 * @description Panel lateral móvil animado (overlay fade + panel slide).
 */
export default function SidebarMobile({
  isOpen,
  setIsOpen,
  user,
}: {
  isOpen: boolean;
  setIsOpen: React.Dispatch<React.SetStateAction<boolean>>;
  user: { name?: string; role?: string } | null;
}) {
  if (typeof document === 'undefined') return null;

  return createPortal(
    <>
      {/* Overlay: captura clicks para cerrar y se anima con TransitionMotion */}
      <TransitionMotion
        active={isOpen}
        initial={{ opacity: 0, x: 0, y: 0 }}
        animate={{ opacity: 0.5, x: 0, y: 0 }}
        exit={{ opacity: 0, x: 0, y: 0 }}
        transition={{ duration: 0.2 }}
        className="fixed inset-0 z-40"
      >
        <div className="absolute inset-0 bg-black/50 pointer-events-auto" onClick={() => setIsOpen(false)} aria-hidden />
      </TransitionMotion>

      {/* Panel lateral animado */}
      <TransitionMotion
        active={isOpen}
        initial={{ x: -320, opacity: 0 }}
        animate={{ x: 0, opacity: 1 }}
        exit={{ x: -320, opacity: 0 }}
        transition={{ duration: 0.3 }}
        className="fixed top-0 left-0 z-50 h-full w-3/4 max-w-xs bg-background text-foreground shadow-xl"
      >
        <div className="relative h-full overflow-hidden">
          <button
            className="absolute top-4 right-4 z-10 text-foreground"
            onClick={() => setIsOpen(false)}
            aria-label="Cerrar menú"
          >
            <i className="fa-solid fa-times text-xl" />
          </button>

          <div className="h-full overflow-hidden">
            <SidebarContent isOpen={true} user={{ name: user?.name, role: user?.role }} />
          </div>
        </div>
      </TransitionMotion>
    </>,
    document.body
  );
}
