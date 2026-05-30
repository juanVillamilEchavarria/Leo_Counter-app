
<?php if (isset($component)) { $__componentOriginal843ce966af9a4617c82cfd0251e8de06 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal843ce966af9a4617c82cfd0251e8de06 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.email-layout','data' => ['logoSvg' => $logoSvg,'title' => 'Restablecer Contraseña','headerBackground' => 'linear-gradient(135deg, #1e3a5f 0%, #2c5f8a 100%)','headerSubtitle' => 'Gestión Financiera Inteligente']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('email-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logoSvg' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($logoSvg),'title' => 'Restablecer Contraseña','headerBackground' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('linear-gradient(135deg, #1e3a5f 0%, #2c5f8a 100%)'),'headerSubtitle' => 'Gestión Financiera Inteligente']); ?>
    
    <h2 style="color: #1e3a5f; font-size: 18px; font-weight: 600; margin: 0 0 10px 0;">
        ¡Hola, <?php echo e($name); ?>!
    </h2>
    <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin: 0 0 25px 0;">
        Has solicitado restablecer tu contraseña en <strong>Leo Counter</strong>. Haz clic en el siguiente botón para crear una nueva contraseña:
    </p>

    
    <div style="text-align: center; margin: 28px 0;">
        <a href="<?php echo e($signedUrl); ?>" style="display: inline-block; padding: 14px 32px; background-color: #2c5f8a; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px; letter-spacing: 0.3px;">
            Restablecer contraseña
        </a>
    </div>

    <p style="color: #64748b; font-size: 15px; margin: 0 0 16px;">
        Este enlace expirará en 60 minutos por razones de seguridad. Si no solicitaste este cambio, puedes ignorar este mensaje.
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
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/auth/emails/password-reset.blade.php ENDPATH**/ ?>