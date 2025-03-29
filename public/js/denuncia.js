document.addEventListener('DOMContentLoaded', function() {
    const formSelectorBtns = document.querySelectorAll('.selector-btn');
    const forms = document.querySelectorAll('.denuncia-form');

    formSelectorBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remover clase active de todos los botones y formularios
            formSelectorBtns.forEach(b => b.classList.remove('active'));
            forms.forEach(form => form.classList.remove('active'));

            // Agregar active al botón clickeado
            this.classList.add('active');

            // Mostrar el formulario correspondiente
            const formId = 'form-' + this.dataset.form;
            document.getElementById(formId).classList.add('active');
        });
    });

    // Validación básica de archivos
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const files = this.files;
            const maxSize = 5 * 1024 * 1024; // 5MB

            for (let file of files) {
                if (file.size > maxSize) {
                    alert(`El archivo ${file.name} excede el tamaño máximo de 5MB`);
                    this.value = '';
                    break;
                }
            }
        });
    });
});