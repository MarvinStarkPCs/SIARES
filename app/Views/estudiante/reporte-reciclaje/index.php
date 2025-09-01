<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3 class="mb-4">Reporte de Reciclaje</h3>

    <!-- Selector de periodo -->
    <form method="get" class="mb-4">
        <label for="periodo_id">Selecciona un período:</label>
        <select name="periodo_id" id="periodo_id" class="form-control" onchange="this.form.submit()">
            <?php foreach ($periodos as $p): ?>
                <option value="<?= $p['id'] ?>" <?= ($p['id'] == $periodoId) ? 'selected' : '' ?>>
                    <?= esc($p['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <!-- Cards de materiales -->
    <div class="row">
        <?php if (!empty($materiales)): ?>
            <?php foreach ($materiales as $material => $total): ?>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-success">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= esc($material) ?></h5>
                            <p class="card-text">
                                <strong><?= number_format($total, 2) ?> Gramos</strong>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    No hay registros de reciclaje para este período.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
