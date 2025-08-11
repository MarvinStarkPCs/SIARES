<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<title>Material reciclado por estudiante (gramos)</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>

<style>

  h2 {
    color: #2c3e50;
    margin-bottom: 10px;
  }

  #containerChart {
    max-width: 700px;
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    margin: auto;
  }

  label {
    font-weight: 600;
    color: #34495e;
  }

  select {
    margin-bottom: 20px;
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 16px;
    cursor: pointer;
    transition: border-color 0.3s ease;
  }

  select:hover, select:focus {
    border-color: #2980b9;
    outline: none;
  }
</style>

<div id="containerChart">
  <h2>Material reciclado por el estudiante (en gramos)</h2>

  <label for="periodoSelect">Selecciona el período escolar:</label>
  <select id="periodoSelect">
    <option value="Periodo 1">Periodo 1</option>
    <option value="Periodo 2">Periodo 2</option>
    <option value="Periodo 3">Periodo 3</option>
    <option value="Periodo 4">Periodo 4</option>
  </select>

  <canvas id="reciclajeChart" width="600" height="400"></canvas>
</div>

<script>
  // Datos de ejemplo para 4 períodos escolares
  const datosPorPeriodo = {
    "Periodo 1": {
      materiales: ['Plástico', 'Papel', 'Vidrio', 'Metal', 'Cartón'],
      gramos: [3500, 2800, 1200, 700, 4000]
    },
    "Periodo 2": {
      materiales: ['Plástico', 'Papel', 'Vidrio', 'Metal', 'Cartón'],
      gramos: [3200, 3000, 1300, 900, 3500]
    },
    "Periodo 3": {
      materiales: ['Plástico', 'Papel', 'Vidrio', 'Metal', 'Cartón'],
      gramos: [4000, 3200, 1400, 1000, 4500]
    },
    "Periodo 4": {
      materiales: ['Plástico', 'Papel', 'Vidrio', 'Metal', 'Cartón'],
      gramos: [4200, 3400, 1500, 1100, 4700]
    }
  };

  const ctx = document.getElementById('reciclajeChart').getContext('2d');

  let reciclajeChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: datosPorPeriodo["Periodo 1"].materiales,
      datasets: [{
        label: 'Gramos reciclados (g)',
        data: datosPorPeriodo["Periodo 1"].gramos,
        backgroundColor: [
          '#e74c3c',
          '#3498db',
          '#f1c40f',
          '#1abc9c',
          '#9b59b6'
        ],
        borderColor: [
          '#c0392b',
          '#2980b9',
          '#d4ac0d',
          '#16a085',
          '#8e44ad'
        ],
        borderWidth: 2,
        borderRadius: 8,
        barPercentage: 0.6,
        categoryPercentage: 0.7,
        hoverBackgroundColor: '#34495e',
        hoverBorderColor: '#2c3e50'
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      animation: {
        duration: 800,
        easing: 'easeOutQuart'
      },
      plugins: {
        legend: {
          labels: {
            font: {
              size: 14,
              weight: 'bold'
            },
            color: '#2c3e50'
          }
        },
        datalabels: {
          anchor: 'end',
          align: 'right',
          color: '#2c3e50',
          font: {
            weight: 'bold',
            size: 12
          },
          formatter: function(value) {
            return value + ' g';
          }
        }
      },
      scales: {
        x: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Gramos reciclados (g)',
            color: '#2c3e50',
            font: {
              size: 14,
              weight: 'bold'
            }
          },
          ticks: {
            color: '#34495e',
            font: {
              size: 12
            }
          }
        },
        y: {
          ticks: {
            color: '#34495e',
            font: {
              size: 13,
              weight: 'bold'
            }
          }
        }
      }
    },
    plugins: [ChartDataLabels]
  });

  document.getElementById('periodoSelect').addEventListener('change', function() {
    const periodoSeleccionado = this.value;
    const datos = datosPorPeriodo[periodoSeleccionado];

    reciclajeChart.data.labels = datos.materiales;
    reciclajeChart.data.datasets[0].data = datos.gramos;
    reciclajeChart.update();
  });
</script>

<?= $this->endSection() ?>
