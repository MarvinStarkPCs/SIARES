<?php

namespace App\Models;
use CodeIgniter\Model;

class ReciclajeModel extends Model
{
    protected $table      = 'reciclajes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'periodo_id',
        'material_id',
        'matricula_id',
        'peso_total'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Reporte por estudiante filtrado por periodo
     */
    public function getReportePorEstudiante($estudianteId, $periodoId = null)
    {
        $builder = $this->select('
                        materiales.nombre AS material,
                        SUM(reciclajes.peso_total) AS total_reciclado
                    ')
                    ->join('matriculas ma', 'ma.id = reciclajes.matricula_id')
                    ->join('users u', 'u.id = ma.estudiante_id')
                    ->join('materiales', 'materiales.id = reciclajes.material_id')
                    ->join('periodos p', 'p.id = reciclajes.periodo_id')
                    ->where('u.id', $estudianteId);

        if ($periodoId !== null) {
            $builder->where('reciclajes.periodo_id', $periodoId);
        }

        return $builder
            ->groupBy('materiales.nombre')
            ->orderBy('materiales.nombre', 'ASC')
            ->findAll();
    }
    /**
     * Reorganizar datos en array clave => valor
     */
    public function getReporteAgrupado($estudianteId, $periodoId = null)
    {
        log_message('debug', 'Generando reporte agrupado para estudiante ID: ' . $estudianteId . ' y periodo ID: ' . $periodoId);
        $reporte = $this->getReportePorEstudiante($estudianteId, $periodoId);

        $materiales = [];
        foreach ($reporte as $row) {
            $materiales[$row['material']] = $row['total_reciclado'];
        }

        return $materiales;
    }
    public function getReporteGeneral($periodoId = null)
{
    $builder = $this->select('
                    materiales.nombre AS material,
                    SUM(reciclajes.peso_total) AS total_reciclado
                ')
                ->join('materiales', 'materiales.id = reciclajes.material_id')
                ->join('periodos p', 'p.id = reciclajes.periodo_id');

    if ($periodoId !== null) {
        $builder->where('reciclajes.periodo_id', $periodoId);
    }

    return $builder
        ->groupBy('materiales.nombre')
        ->orderBy('materiales.nombre', 'ASC')
        ->findAll();
    }
public function getReciclajes($grupoId, $jornadaId, $documento = null)
{


    $builder = $this->db->table('reciclajes r')
        ->select("
            u.documento AS Documento,
            u.name AS Estudiante,
            g.nombre AS Grado,
            gr.nombre AS Grupo,
            j.nombre AS Jornada,
            p.nombre AS Periodo,
            mat.nombre AS Material,
            r.peso_total AS `Peso`,
            r.created_at AS `Fecha Registro`
        ")
        ->join('matriculas m', 'r.matricula_id = m.id')
        ->join('users u', 'm.estudiante_id = u.id')
        ->join('grupos gr', 'm.grupo_id = gr.id')
        ->join('grados g', 'gr.grado_id = g.id')
        ->join('jornadas j', 'm.jornada_id = j.id')
        ->join('periodos p', 'r.periodo_id = p.id')
        ->join('materiales mat', 'r.material_id = mat.id')
        ->where('YEAR(r.created_at)', date('Y'))
        ->where('gr.id', $grupoId)
        ->where('j.id', $jornadaId);

    // Log si documento fue usado
    if (!empty($documento)) {
        $builder->orWhere('u.documento', value: $documento);
    } else {
        log_message('debug', '[ReciclajeModel] Documento no enviado, se traerán todos.');
    }

    // Log de la consulta compilada

    $result = $builder->orderBy('r.created_at', 'DESC')
                      ->get()
                      ->getResult();

    // Log del número de registros devueltos

    return $result;
}



}
