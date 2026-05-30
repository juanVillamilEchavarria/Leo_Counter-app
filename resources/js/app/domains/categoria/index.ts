/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { type Categoria, CategoriaActions, CategoriaRoutes, type CategoriaFormOptions, type CategoriaFormProps, type CategoriaFormData, type CategoriaTableData } from "./types/categoria.types";
import CategoriaTable from "./components/CategoriaTable";
import { CategoriaStaticColumns } from "./components/columns/categoria.columns";
export{
    type Categoria,
    type CategoriaFormData,
    type CategoriaFormOptions,
    type CategoriaFormProps,
    type CategoriaTableData,
    CategoriaActions,
    CategoriaRoutes,
    CategoriaTable,
    CategoriaStaticColumns
}