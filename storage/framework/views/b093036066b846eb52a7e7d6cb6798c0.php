<?php if (isset($component)) { $__componentOriginal843ce966af9a4617c82cfd0251e8de06 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal843ce966af9a4617c82cfd0251e8de06 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.email-layout','data' => ['title' => 'Verificación de Suscripción','headerBackground' => 'linear-gradient(135deg, #5f1e1e 0%, #8a2c2c 100%)','headerSubtitle' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('email-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Verificación de Suscripción','headerBackground' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('linear-gradient(135deg, #5f1e1e 0%, #8a2c2c 100%)'),'headerSubtitle' => '']); ?>
<p style="margin: 0 0 16px; font-size: 20px; font-weight: 600; color: #0f172a;">Hola, <?php echo e($name); ?></p>

            <p style="margin: 0 0 16px;">
                Te han agregado como suscriptor de notificaciones en <strong>Leo Counter</strong>. Para comenzar a recibir alertas por correo electrónico, confirma tu suscripción haciendo clic en el siguiente botón:
            </p>

            <!-- Botón de verificación -->
            <div style="text-align: center; margin: 28px 0;">
                <a href="<?php echo e($signedUrl); ?>" style="display: inline-block; padding: 14px 32px; background-color: #0f172a; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px; letter-spacing: 0.3px; transition: background-color 0.2s;">
                    Verificar suscripción
                </a>
            </div>

            <p style="margin: 0 0 16px; color: #64748b; font-size: 15px;">
                Este enlace expirará en 24 horas por razones de seguridad. Si no solicitaste esta suscripción, puedes ignorar este mensaje.
            </p>

            <p style="margin: 0 0 16px;">
                Si tienes problemas con el botón, copia y pega el siguiente enlace en tu navegador:
            </p>

            <p style="margin: 0 0 24px; word-break: break-all; font-size: 13px; color: #475569; background-color: #f8fafc; padding: 12px; border-radius: 6px; border: 1px solid #e2e8f0;">
                <?php echo e($signedUrl); ?>

            </p>

            <p style="margin: 0;">
                ¡Gracias por usar Leo Counter!<br>
                <span style="color: #64748b; font-size: 14px;">— El equipo de Leo Counter</span>
            </p>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal843ce966af9a4617c82cfd0251e8de06)): ?>
<?php $attributes = $__attributesOriginal843ce966af9a4617c82cfd0251e8de06; ?>
<?php unset($__attributesOriginal843ce966af9a4617c82cfd0251e8de06); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal843ce966af9a4617c82cfd0251e8de06)): ?>
<?php $component = $__componentOriginal843ce966af9a4617c82cfd0251e8de06; ?>
<?php unset($__componentOriginal843ce966af9a4617c82cfd0251e8de06); ?>
<?php endif; ?><?php /**PATH /var/www/html/resources/views/notificaciones/suscriptores/email/verify.blade.php ENDPATH**/ ?>