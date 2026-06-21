<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Registro de Nuevo Personal</h6>
    </div>
    <div class="card-body">
        <form action="../controllers/PersonalController.php" method="POST">
            <div class="row">
                <!-- Nombre y CI -->
                <div class="col-md-6 mb-3">
                    <label>Nombre Completo</label>
                    <input type="text" name="nombre_completo" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>CI (Cédula de Identidad)</label>
                    <input type="text" name="ci" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <!-- Cargo y Teléfono -->
                <div class="col-md-6 mb-3">
                    <label>Cargo</label>
                    <select name="cargo" class="form-control">
                        <option value="Agente">Agente Inmobiliario</option>
                        <option value="Vendedor">Vendedor</option>
                        <option value="Administrador">Administrador</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-control">
                </div>
                
            </div>

            <div class="row">
                <!-- Email y Estado -->
                <div class="col-md-6 mb-3">
                    <label>Email Corporativo</label>
                    <input type="email" name="email_corporativo" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Estado del Contrato</label>
                    <select name="estado_contrato" class="form-control">
                        <option value="Activo">Activo</option>
                        <option value="Prueba">Prueba</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Registrar en SAPN</button>
        </form>
    </div>
</div>