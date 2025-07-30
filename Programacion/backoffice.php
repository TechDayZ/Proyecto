<!-- backoffice.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Backoffice - Aprobación de Usuarios</title>
    <style>
        body {
            background-color: #e6f0fa;
            font-family: Arial, sans-serif;
            padding: 40px;
        }

        h1 {
            text-align: center;
            color: #1a4f7d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #d9e6f2;
        }

        th {
            background-color: #cfe2f3;
            color: #1a4f7d;
        }

        tr:hover {
            background-color: #f2f8fc;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .approve {
            background-color: #3c8dbc;
            color: white;
        }

        .reject {
            background-color: #a6c8e0;
            color: #1a4f7d;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <h1>Panel de Aprobación de Formularios</h1>
    
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <!-- Estos datos son de ejemplo. Luego se reemplazarán con datos reales. -->
            <tr>
                <td>Juan Pérez</td>
                <td>juan@example.com</td>
                <td>091234567</td>
                <td>
                    <button class="btn approve">Aprobar</button>
                    <button class="btn reject">Rechazar</button>
                </td>
            </tr>
            <tr>
                <td>Lucía Gómez</td>
                <td>lucia@example.com</td>
                <td>098765432</td>
                <td>
                    <button class="btn approve">Aprobar</button>
                    <button class="btn reject">Rechazar</button>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>