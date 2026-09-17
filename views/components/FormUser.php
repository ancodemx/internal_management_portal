<?php
// components/FormUser.php
declare(strict_types=1);

/**
 * Componente de formulario de Usuario (modal + JS).
 * IDs requeridos por tu especificación:
 *  - Modal:  modalFormUser
 *  - Form:   formUser
 *
 * Uso:
 *   require_once __DIR__ . '/components/FormUser.php';
 *   renderFormUserModal([
 *      'action' => '/users/store.php',    // endpoint que recibe el POST
 *      'method' => 'POST',
 *      'csrf'   => $_SESSION['csrf'] ?? '', // opcional
 *   ]);
 *
 * Notas:
 * - Compatible con Bootstrap 4/5 (AdminLTE); si no hay data attributes,
 *   expone window.FormUser.open()/close() como fallback.
 * - Despacha evento "formUser:success" con e.detail = { response }.
 */

if (!function_exists('renderFormUserModal')) {
    function renderFormUserModal(array $opts = []): void
    {
        $action   = $opts['action'] ?? '/users/store.php';
        $method   = strtoupper($opts['method'] ?? 'POST');
        $csrf     = htmlspecialchars((string)($opts['csrf'] ?? ''), ENT_QUOTES, 'UTF-8');

        // Opciones de perfil (value => label)
        $profiles = $opts['profiles'] ?? [
            'admin' => 'Administrador',
            'user'  => 'Usuario',
        ];

        // Título del modal
        $title    = $opts['title'] ?? 'Nuevo usuario';

        // IDs fijos por tu requerimiento
        $modalId  = 'modalFormUser';
        $formId   = 'formUser';

        // Valores por defecto (útil si un día reutilizas para "editar")
        $defaults = $opts['defaults'] ?? [
            'full_name' => '',
            'email'     => '',
            'profile'   => 'user',
        ];

        // Render:
?>
        <!-- Modal -->
        <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" role="dialog" aria-hidden="true"
            aria-labelledby="<?= $modalId ?>Label">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="<?= $modalId ?>Label"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h5>
                        <button type="button" class="close btn btn-link" data-dismiss="modal" aria-label="Close"
                            <?php /* Bootstrap 5 */ ?> data-bs-dismiss="modal">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="<?= $formId ?>" novalidate>
                            <input type="hidden" name="csrf" value="<?= $csrf ?>">

                            <div class="form-group">
                                <label for="fu_full_name">Nombre completo</label>
                                <input type="text" class="form-control" id="fu_full_name" name="full_name"
                                    autocomplete="name" required
                                    value="<?= htmlspecialchars((string)$defaults['full_name'], ENT_QUOTES, 'UTF-8') ?>">
                                <div class="invalid-feedback">El nombre es obligatorio.</div>
                            </div>

                            <div class="form-group">
                                <label for="fu_email">Correo electrónico</label>
                                <input type="email" class="form-control" id="fu_email" name="email"
                                    autocomplete="email" required
                                    value="<?= htmlspecialchars((string)$defaults['email'], ENT_QUOTES, 'UTF-8') ?>">
                                <div class="invalid-feedback">Ingresa un correo válido.</div>
                            </div>

                            <div class="form-group">
                                <label for="fu_password">Contraseña</label>
                                <input type="password" class="form-control" id="fu_password" name="password"
                                    autocomplete="new-password" required minlength="8">
                                <div class="invalid-feedback">La contraseña es obligatoria (mínimo 8 caracteres).</div>
                            </div>

                            <div class="form-group">
                                <label for="fu_password_confirm">Confirmar contraseña</label>
                                <input type="password" class="form-control" id="fu_password_confirm" name="password_confirm"
                                    autocomplete="new-password" required minlength="8">
                                <div class="invalid-feedback">Las contraseñas no coinciden.</div>
                            </div>

                            <div class="form-group">
                                <label for="fu_profile">Perfil</label>
                                <select class="form-control" id="fu_profile" name="profile" required>
                                    <?php foreach ($profiles as $val => $label): ?>
                                        <option value="<?= htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8') ?>"
                                            <?= ($defaults['profile'] ?? '') === $val ? 'selected' : '' ?>>
                                            <?= htmlspecialchars((string)$label, ENT_QUOTES, 'UTF-8') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Selecciona un perfil.</div>
                            </div>

                            <div id="fu_form_alert" class="alert d-none" role="alert"></div>

                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="fu_btn_submit" class="btn btn-primary">Guardar</button>
                    </div>

                </div>
            </div>
        </div>

        <script>
            (function() {
                // Evitar registrar múltiples veces si se incluye el componente en varias vistas
                if (window.__FormUserLoaded) return;
                window.__FormUserLoaded = true;

                // Helpers para abrir/cerrar el modal con Bootstrap 4/5 o fallback puro
                function getModalEl() {
                    return document.getElementById('<?= $modalId ?>');
                }

                const isBs5 = !!window.bootstrap; // AdminLTE 4/BS5 lo define
                function openModal() {
                    const el = getModalEl();
                    if (window.jQuery && jQuery(el).modal) {
                        jQuery(el).modal('show');
                        return;
                    } // BS4
                    if (isBs5 && window.bootstrap?.Modal) {
                        new window.bootstrap.Modal(el).show();
                        return;
                    } // BS5
                    // Fallback básico (sin BS): mostrar bloque
                    el.style.display = 'block';
                    el.classList.add('show');
                }

                function closeModal() {
                    const el = getModalEl();
                    if (window.jQuery && jQuery(el).modal) {
                        jQuery(el).modal('hide');
                        return;
                    } // BS4
                    if (isBs5 && window.bootstrap?.Modal) {
                        const inst = window.bootstrap.Modal.getInstance(el) || new window.bootstrap.Modal(el);
                        inst.hide();
                        return;
                    }
                    // Fallback
                    el.classList.remove('show');
                    el.style.display = 'none';
                }

                // API global sencilla
                window.FormUser = {
                    open: openModal,
                    close: closeModal
                };

                const form = document.getElementById('<?= $formId ?>');
                const btnSubmit = document.getElementById('fu_btn_submit');
                const alertBox = document.getElementById('fu_form_alert');
                const f = {
                    full_name: document.getElementById('fu_full_name'),
                    email: document.getElementById('fu_email'),
                    password: document.getElementById('fu_password'),
                    password_confirm: document.getElementById('fu_password_confirm'),
                    profile: document.getElementById('fu_profile'),
                };

                function clearErrors() {
                    for (const el of Object.values(f)) {
                        el.classList.remove('is-invalid');
                    }
                    alertBox.classList.add('d-none');
                    alertBox.classList.remove('alert-danger', 'alert-success');
                    alertBox.textContent = '';
                }

                function showFieldError(el, msg) {
                    el.classList.add('is-invalid');
                    const fb = el.parentElement.querySelector('.invalid-feedback');
                    if (fb) fb.textContent = msg;
                }

                function validate() {
                    clearErrors();
                    let ok = true;

                    if (!f.full_name.value.trim()) {
                        showFieldError(f.full_name, 'El nombre es obligatorio.');
                        ok = false;
                    }
                    const email = f.email.value.trim();
                    if (!email || !/^\S+@\S+\.\S+$/.test(email)) {
                        showFieldError(f.email, 'Ingresa un correo válido.');
                        ok = false;
                    }
                    const pass = f.password.value;
                    const pass2 = f.password_confirm.value;
                    if (!pass || pass.length < 8) {
                        showFieldError(f.password, 'La contraseña requiere al menos 8 caracteres.');
                        ok = false;
                    }
                    if (!pass2 || pass !== pass2) {
                        showFieldError(f.password_confirm, 'Las contraseñas no coinciden.');
                        ok = false;
                    }
                    if (!f.profile.value) {
                        showFieldError(f.profile, 'Selecciona un perfil.');
                        ok = false;
                    }
                    return ok;
                }

                async function submitForm() {
                    if (!validate()) return;

                    btnSubmit.disabled = true;
                    btnSubmit.dataset._prevText = btnSubmit.textContent;
                    btnSubmit.textContent = 'Guardando...';

                    try {
                        const fd = new FormData(form);
                        const res = await fetch(<?= json_encode($action) ?>, {
                            method: '<?= $method ?>',
                            body: fd,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        const data = await res.json().catch(() => ({}));
                        if (!res.ok || data.ok === false) {
                            // Errores de validación del backend (espera { errors: {campo: msg} } )
                            if (data.errors && typeof data.errors === 'object') {
                                Object.entries(data.errors).forEach(([key, msg]) => {
                                    const el = f[key];
                                    if (el) showFieldError(el, String(msg));
                                });
                            }
                            alertBox.classList.remove('d-none');
                            alertBox.classList.add('alert-danger');
                            alertBox.textContent = data.message || 'Error al guardar. Verifica la información.';
                            return;
                        }

                        // Éxito
                        alertBox.classList.remove('d-none');
                        alertBox.classList.add('alert-success');
                        alertBox.textContent = data.message || 'Usuario creado correctamente.';

                        // Notificar a la vista que lo invocó (útil para refrescar tablas)
                        const ev = new CustomEvent('formUser:success', {
                            detail: {
                                response: data
                            }
                        });
                        document.dispatchEvent(ev);

                        // Cerrar después de un pequeño delay
                        setTimeout(() => {
                            closeModal();
                            form.reset();
                        }, 500);

                    } catch (err) {
                        alertBox.classList.remove('d-none');
                        alertBox.classList.add('alert-danger');
                        alertBox.textContent = 'No se pudo conectar con el servidor.';
                    } finally {
                        btnSubmit.disabled = false;
                        btnSubmit.textContent = btnSubmit.dataset._prevText || 'Guardar';
                    }
                }

                // Eventos
                btnSubmit.addEventListener('click', submitForm);
                // Permitir Enter para enviar
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitForm();
                });
            })();
        </script>
<?php
    }
}
