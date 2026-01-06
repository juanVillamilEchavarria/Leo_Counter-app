import { useEffect, useState } from "react";

export default function usePortalRoot(id: string = "portal-root") {
  const [root, setRoot] = useState<HTMLElement | null>(null);

  useEffect(() => {
    const el = document.getElementById(id);
    if (el) setRoot(el);
  }, [id]);

  return root;
}
