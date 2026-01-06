export function getVisiblePages(
    current : number,
    total: number,
    maxVisible: number = 5
) {
    // el start y end no se refiere a los primeros y ultimos indices de la paginacion de la tabla, se refieren a los indices de la paginacion visible


    // calcula la mitad de la paginacion visible, y lo redondea hacia abajo
    let half = Math.floor(maxVisible / 2);
    // calcula el primer numero de la paginacion visible, por default es 0, y devuelve otro numero si el numero dado es mayor a 0
    let start = Math.max(0, current - half);
    // calcula el ultimo numero de la paginacion visible, por default es el ultimo numero de la paginacion, y devuelve otro numero si el numero dado es menor al ultimo
    let end = Math.min(total-1, start + maxVisible - 1);

    // evita mostrar la paginacion incompleta si estamos al final
    start = Math.max(0, end - maxVisible + 1)


    // devuelve un array con los numeros de la paginacion visible
  const pages = []
  for (let i = start; i <= end; i++) {
    pages.push(i)
  }
    return {    
        start,
        end,
        pages
    };
}
