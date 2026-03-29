import ProfileNavigationGroup from "@/app/domains/profile/components/ProfileNavigationGroup"
import Title from "@/app/shared/components/common/Title"
import Card from "@/app/shared/components/common/Card"
import InputFillable from "@/app/shared/components/form/InputFillable"
import Button from "@/app/shared/components/common/Button"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
export default function Password() {
  return (
    <SectionTransition>
        <ProfileNavigationGroup />
        <div className="w-[50%] mx-auto mt-10 flex flex-col justify-center">
            <div className="flex flex-col text-foreground gap-5">
                <Title 
                title={
                    <div>
                        <i className="fa-solid fa-fingerprint"></i>
                        <span>Mi Contraseña</span>
                    </div>
                    } 
                size="5xl" 
                
                 />
                <p >Aqui puedes actualizar tu contraseña</p>
            </div>
            
            <div className="mt-10">
                <Card>
                    <form action="" className="formulario-general">
                        <div className="formulario-campo">
                            <label htmlFor="">Contraseña actual</label>
                            <InputFillable type="text" name="name" id="name" placeholder="Mi Nombre" value={'Juan Villamil'} onChange={()=>{}}/>
                        </div>
                        <div className="formulario-campo">
                            <label htmlFor="">Contraseña Nueva</label>
                            <InputFillable type="text" name="name" id="name" placeholder="Mi Nombre" value={'Juan Villamil'} onChange={()=>{}}/>
                        </div>
                        <div className="formulario-campo">
                            <label htmlFor="">Repetir Contraseña</label>
                            <InputFillable type="text" name="name" id="name" placeholder="Mi Nombre" value={'Juan Villamil'} onChange={()=>{}}/>
                        </div>
                        <div className="w-[20%] mt-5 mx-auto">
                            <Button variant="secondary" type="submit">Guardar</Button>
                            </div>
                    </form>
                </Card>
            </div>
        </div>
     </SectionTransition>
  )
}
