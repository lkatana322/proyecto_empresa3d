document.addEventListener('DOMContentLoaded', function() {
    const agregarUsuarioForm = document.getElementById('agregarUsuarioForm');
    const editarUsuarioForm = document.getElementById('editarUsuarioForm');
    const agregarUsuarioBtn = document.getElementById('agregarUsuarioBtn');
    const actualizarUsuarioBtn = document.getElementById('actualizarUsuarioBtn');
  
    const forms = [agregarUsuarioForm, editarUsuarioForm];
    const buttons = [agregarUsuarioBtn, actualizarUsuarioBtn];
  
    forms.forEach((form, index) => {
      if (form) {
        form.addEventListener('submit', function(event) {
          if (!form.checkValidity()) {
            event.preventDefault(); // Previene el envío del formulario si es inválido
            event.stopPropagation();
            form.classList.add('was-validated');
          } else {
            if (buttons[index]) {
              buttons[index].disabled = true; // Deshabilita el botón
              buttons[index].textContent = 'Guardando...'; // Cambia el texto del botón
            }
          }
        });
  
        // Validación de contraseñas
        const passwordField = form.querySelector('[name="contraseña_usuario"], [name="contraseña"]');
        const repeatPasswordField = form.querySelector('[name="repetir_contraseña_usuario"], [name="repetir_contraseña"]');
  
        if (passwordField && repeatPasswordField) {
          passwordField.addEventListener('input', validatePasswords);
          repeatPasswordField.addEventListener('input', validatePasswords);
        }
  
        function validatePasswords() {
          if (passwordField.value !== repeatPasswordField.value) {
            repeatPasswordField.setCustomValidity('Las contraseñas no coinciden');
          } else {
            repeatPasswordField.setCustomValidity('');
          }
        }
  
        // Validación de rol
        const rolSelect = form.querySelector('[name="rol_usuario"], [name="rol"]');
        const telefonoField = form.querySelector('[name="telefono_usuario"], [name="telefono"]');
        const direccionField = form.querySelector('[name="direccion_usuario"], [name="direccion"]');
        const optionalFields = form.querySelectorAll('.cliente-optional');
  
        if (rolSelect) {
          rolSelect.addEventListener('change', handleRoleChange);
  
          function handleRoleChange() {
            const empleadoFields = form.querySelector('#empleado_fields_usuario, #empleado-fields');
            if (rolSelect.value === 'empleado' || rolSelect.value === 'admin') {
              if (empleadoFields) empleadoFields.style.display = 'block';
              if (telefonoField) telefonoField.setAttribute('required', 'required');
              if (direccionField) direccionField.setAttribute('required', 'required');
              optionalFields.forEach(field => field.removeAttribute('disabled'));
            } else {
              if (empleadoFields) empleadoFields.style.display = 'none';
              if (telefonoField) telefonoField.removeAttribute('required');
              if (direccionField) direccionField.removeAttribute('required');
              optionalFields.forEach(field => field.removeAttribute('disabled'));
            }
  
            optionalFields.forEach(field => {
              if (rolSelect.value === 'cliente') {
                field.removeAttribute('required');
                field.classList.remove('is-invalid');
                field.setCustomValidity('');
              } else {
                field.setAttribute('required', 'required');
              }
            });
          }
  
          // Ejecutar validación inicial
          handleRoleChange.call(rolSelect);
        }
      }
    });
  });
  