<?php
// =============================================================
// PHP: SIMULACIÓN DE DATOS (PARA EL DISEÑO DEL FRONT-END)
// =============================================================

// Datos de usuario de ejemplo
$idUsuarioLogueado = 56494869; 
$nombre = "Lucas Matias Diaz Gomensoro";
$email = "socialluhipaing@gmail.com";
$fechNac = "2000-01-01";
$telefono = "97393688";
$foto_perfil = "perfil_56494869_1762304849.jpeg"; 
$mensaje_estado = ""; 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Perfil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --color-primario: #007BFF; 
            --color-secundario: #0056b3;
            --color-fondo: #f4f7fa; 
            --color-texto: #333; 
            --color-blanco: #fff;
            --color-borde: #ccc;
            --color-exito: #28a745;
            --color-error: #dc3545;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--color-fondo);
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .perfil-container {
            background-color: var(--color-blanco);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            padding: 30px;
            margin-top: 50px;
        }

        .perfil-header {
            text-align: center;
            margin-bottom: 30px;
            color: var(--color-primario);
            position: relative;
        }
        
        /* Estilo para el botón de Volver */
        .btn-volver {
            position: absolute;
            top: 0px;
            left: 0px;
            background: none;
            border: none;
            color: var(--color-primario);
            text-decoration: none;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 4px;
            transition: color 0.3s, background-color 0.3s;
            font-size: 0.9em;
            display: inline-flex;
            align-items: center;
        }

        .btn-volver:hover {
            color: var(--color-secundario);
            text-decoration: underline;
        }

        /* Estilos de Formulario y Botones (existentes) */
        /* ... (mantener estilos de form-group, inputs, etc.) */

        .perfil-header h1 { margin-top: 5px; font-size: 2em; }
        .perfil-header i { font-size: 3em; }
        .perfil-form { display: flex; flex-direction: column; gap: 15px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; color: var(--color-texto); }
        .form-group label i { margin-right: 8px; color: var(--color-primario); }
        .form-group input:not([type="file"]) {
            width: 100%; padding: 12px; border: 1px solid var(--color-borde); border-radius: 4px; box-sizing: border-box; transition: border-color 0.3s;
        }
        .form-group input:focus { border-color: var(--color-primario); outline: none; box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25); }
        .foto-group { text-align: center; margin-bottom: 25px; }
        .foto-preview { display: flex; flex-direction: column; align-items: center; }
        .foto-preview img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid var(--color-primario); cursor: pointer; transition: transform 0.3s, box-shadow 0.3s; }
        .foto-preview img:hover { transform: scale(1.05); box-shadow: 0 0 10px rgba(0, 123, 255, 0.5); }
        .foto-preview input[type="file"] { display: none; }
        .nota-foto { font-size: 0.8em; color: #666; margin-top: 8px; }
        .btn-guardar, .btn-modal-action {
            background-color: var(--color-primario);
            color: var(--color-blanco);
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.1s;
        }
        .btn-guardar:hover, .btn-modal-action:hover { background-color: var(--color-secundario); transform: translateY(-1px); }
        .btn-guardar i, .btn-modal-action i { margin-right: 8px; }

        .link-secundario { text-align: center; margin-top: 10px; }
        /* El enlace ahora será un botón */
        .btn-cambiar-pass {
            background: none;
            border: none;
            color: var(--color-secundario);
            text-decoration: underline;
            cursor: pointer;
            font-size: 0.9em;
            padding: 0;
            display: inline-block;
        }
        .btn-cambiar-pass:hover {
            color: var(--color-primario);
        }
        hr { border: 0; border-top: 1px solid var(--color-borde); margin: 25px 0; }
        
        /* ==================== ESTILOS DEL MODAL ==================== */
        .modal {
            display: none; /* Oculto por defecto */
            position: fixed;
            z-index: 1000; 
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.6); /* Fondo semi-transparente oscuro */
            animation: fadeIn 0.3s;
        }

        .modal-content {
            background-color: var(--color-blanco);
            margin: 10% auto; /* 10% desde arriba y centrado */
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            width: 80%;
            max-width: 400px;
            position: relative;
            animation: slideIn 0.3s ease-out;
        }
        
        .modal-header {
            border-bottom: 1px solid var(--color-borde);
            padding-bottom: 15px;
            margin-bottom: 20px;
            color: var(--color-primario);
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.5em;
        }

        .close-btn {
            color: var(--color-borde);
            float: right;
            font-size: 28px;
            font-weight: bold;
            line-height: 20px;
            transition: color 0.2s;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: var(--color-secundario);
            text-decoration: none;
            cursor: pointer;
        }
        
        /* Botones del modal */
        .modal-footer {
            text-align: right;
            padding-top: 15px;
            border-top: 1px solid var(--color-borde);
            margin-top: 20px;
        }

        .btn-cancelar {
            background-color: #6c757d;
            margin-right: 10px;
        }

        .btn-cancelar:hover {
            background-color: #5a6268;
        }

        /* Animaciones */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body>

    <div class="perfil-container">
        <header class="perfil-header">
            <a href="http://localhost/loadingpage" class="btn-volver">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            
            <i class="fas fa-user-circle"></i>
            <h1>Configuración de Perfil</h1>
        </header>

        <?php echo $mensaje_estado; ?>

        <form action="backend_procesar.php" method="POST" enctype="multipart/form-data" class="perfil-form">
            
            <input type="hidden" name="idUser" value="<?php echo $idUsuarioLogueado; ?>">

            <div class="form-group foto-group">
                <label for="foto_perfil">Foto de Perfil</label>
                <div class="foto-preview">
                    <img src="uploads/<?php echo $foto_perfil; ?>" alt="Foto actual" id="current-photo" onerror="this.onerror=null; this.src='uploads/default.jpg';"> 
                    <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*">
                    <p class="nota-foto">Haz clic en la imagen para cambiarla.</p>
                </div>
            </div>

            <div class="form-group">
                <label for="nombre"><i class="fas fa-signature"></i> Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
            </div>

            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Correo Electrónico</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>

            <div class="form-group">
                <label for="fechNac"><i class="fas fa-calendar-alt"></i> Fecha de Nacimiento</label>
                <input type="date" id="fechNac" name="fechNac" value="<?php echo $fechNac; ?>" required>
            </div>

            <div class="form-group">
                <label for="telefono"><i class="fas fa-phone"></i> Teléfono</label>
                <input type="text" id="telefono" name="telefono" value="<?php echo $telefono; ?>" maxlength="9" required>
            </div>

            <hr>

            <button type="submit" class="btn-guardar"><i class="fas fa-save"></i> Guardar Cambios</button>

            <p class="link-secundario">
                <button type="button" id="abrirModalPass" class="btn-cambiar-pass">
                    Cambiar Contraseña
                </button>
            </p>
        </form>
    </div>

    <div id="modalCambiarPass" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn">&times;</span>
                <h2><i class="fas fa-lock"></i> Actualizar Contraseña</h2>
            </div>
            
            <form id="formCambiarPass" action="backend_cambiar_pass.php" method="POST">
                <input type="hidden" name="idUser" value="<?php echo $idUsuarioLogueado; ?>">
                
                <div class="form-group">
                    <label for="current_password">Contraseña Actual</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>

                <div class="form-group">
                    <label for="new_password">Nueva Contraseña</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmar Nueva Contraseña</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-guardar btn-cancelar" id="cerrarModalBtn">Cancelar</button>
                    <button type="submit" class="btn-guardar btn-modal-action"><i class="fas fa-check"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        // 1. Lógica de Previsualización de Imagen
        const fotoInput = document.getElementById('foto_perfil');
        const currentPhoto = document.getElementById('current-photo');
        currentPhoto.onclick = () => fotoInput.click();
        fotoInput.onchange = (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => { currentPhoto.src = e.target.result; }
                reader.readAsDataURL(file);
            }
        };

        // 2. Lógica del Modal
        const modal = document.getElementById('modalCambiarPass');
        const btnAbrir = document.getElementById('abrirModalPass');
        const btnCerrar = document.querySelector('.close-btn');
        const btnCancelar = document.getElementById('cerrarModalBtn');

        // Función para abrir el modal
        btnAbrir.onclick = function() {
            modal.style.display = 'block';
        }

        // Función para cerrar el modal usando la 'X' o el botón Cancelar
        btnCerrar.onclick = function() {
            modal.style.display = 'none';
        }
        btnCancelar.onclick = function() {
            modal.style.display = 'none';
        }

        // Cierra el modal si el usuario hace clic fuera de él
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>

</body>
</html>