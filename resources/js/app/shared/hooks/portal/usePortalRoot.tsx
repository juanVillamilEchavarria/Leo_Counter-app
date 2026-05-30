/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useEffect, useState } from "react";

export default function usePortalRoot(id: string = "portal-root") {
  const [root, setRoot] = useState<HTMLElement | null>(null);

  useEffect(() => {
    const el = document.getElementById(id);
    if (el) setRoot(el);
  }, [id]);

  return root;
}
