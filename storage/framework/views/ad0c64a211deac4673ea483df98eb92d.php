
<?php if (isset($component)) { $__componentOriginal843ce966af9a4617c82cfd0251e8de06 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal843ce966af9a4617c82cfd0251e8de06 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.email-layout','data' => ['logoSvg' => $logoSvg,'title' => 'Aviso de Movimiento','headerBackground' => 'linear-gradient(135deg, #1e3a5f 0%, #2c5f8a 100%)','headerSubtitle' => 'Gestión Financiera Inteligente']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('email-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logoSvg' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($logoSvg),'title' => 'Aviso de Movimiento','headerBackground' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('linear-gradient(135deg, #1e3a5f 0%, #2c5f8a 100%)'),'headerSubtitle' => 'Gestión Financiera Inteligente']); ?>
    
    <h2 style="color: #1e3a5f; font-size: 18px; font-weight: 600; margin: 0 0 10px 0;">
        ¡Hola, <?php echo e($name); ?>!
    </h2>
    <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0 0 25px 0;">
        Este es un recordatorio automático de Leo Counter para informarte que tienes un
        <strong style="color: #2c5f8a;">
            <?php echo e($tipo === 'movimiento fijo' ? 'movimiento fijo' : 'movimiento pendiente'); ?>

        </strong>
        programado para los próximos días.
    </p>

    
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 25px;">
        <tr>
            <td style="padding: 20px 25px;">
                <h3 style="color: #1e3a5f; font-size: 15px; font-weight: 600; margin: 0 0 15px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">
                    📋 Detalles del <?php echo e($tipo === 'movimiento fijo' ? 'Movimiento Fijo' : 'Movimiento Pendiente'); ?>

                </h3>

                <table width="100%" cellpadding="8" cellspacing="0" role="presentation">
                    <tr>
                        <td style="color: #718096; font-size: 13px; font-weight: 500; width: 40%;">Nombre:</td>
                        <td style="color: #2d3748; font-size: 13px; font-weight: 600;"><?php echo e($movimiento->getNombre()); ?></td>
                    </tr>
                    <tr>
                        <td style="color: #718096; font-size: 13px; font-weight: 500;">Monto:</td>
                        <td style="color: #2d3748; font-size: 13px; font-weight: 600;">
                            $<?php echo e(number_format($movimiento->getMonto()->getValue(), 2)); ?>

                        </td>
                    </tr>
                    <tr>
                        <td style="color: #718096; font-size: 13px; font-weight: 500;">
                            <?php echo e($tipo === 'movimiento fijo' ? 'Fecha Próximo:' : 'Fecha Programada:'); ?>

                        </td>
                        <td style="color: #2d3748; font-size: 13px; font-weight: 600;">
                            <?php
                                $fecha = $tipo === 'movimiento fijo'
                                    ? $movimiento->getFechaProximo()
                                    : $movimiento->getFechaProgramada();
                            ?>
                            <?php echo e($fecha->format('d/m/Y')); ?>

                        </td>
                    </tr>
                    <?php if($movimiento->getDescripcion()): ?>
                        <tr>
                            <td style="color: #718096; font-size: 13px; font-weight: 500;">Descripción:</td>
                            <td style="color: #2d3748; font-size: 13px;"><?php echo e($movimiento->getDescripcion()); ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
            </td>
        </tr>
    </table>

    
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #ebf8ff; border-left: 4px solid #3182ce; border-radius: 4px; margin-bottom: 25px;">
        <tr>
            <td style="padding: 15px 20px;">
                <p style="color: #2b6cb0; font-size: 13px; line-height: 1.6; margin: 0;">
                    <strong>💡 Recuerda:</strong>
                    <?php if($tipo === 'movimiento fijo'): ?>
                        Puedes gestionar este movimiento fijo desde la sección de <strong>Movimientos Fijos</strong> en tu panel de Leo Counter.
                    <?php else: ?>
                        Puedes confirmar o cancelar este movimiento desde la sección de <strong>Movimientos Pendientes</strong> en tu panel de Leo Counter.
                    <?php endif; ?>
                </p>
            </td>
        </tr>
    </table>

    
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom: 10px;">
        <tr>
            <td align="center">
                <a href="<?php echo e(config('app.url')); ?>" style="display: inline-block; background-color: #2c5f8a; color: #ffffff; text-decoration: none; padding: 12px 35px; border-radius: 6px; font-size: 14px; font-weight: 600;">
                    Ir a Leo Counter
                </a>
            </td>
        </tr>
    </table>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal843ce966af9a4617c82cfd0251e8de06)): ?>
<?php $attributes = $__attributesOriginal843ce966af9a4617c82cfd0251e8de06; ?>
<?php unset($__attributesOriginal843ce966af9a4617c82cfd0251e8de06); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal843ce966af9a4617c82cfd0251e8de06)): ?>
<?php $component = $__componentOriginal843ce966af9a4617c82cfd0251e8de06; ?>
<?php unset($__componentOriginal843ce966af9a4617c82cfd0251e8de06); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/movimientos/alerts/emails/warning_day.blade.php ENDPATH**/ ?>