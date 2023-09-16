<section class="mb-5">
  <div class="container">
    <h4 class="fw-bold border-bottom border-dark pb-2">Dog Post Report</h4>
    <label for="yearFilter">Choose Year:</label>
    <select id="yearFilter">
      <option value="all">All</option>
      @foreach ($report_years as $year)
        <option value="{{ $year }}">{{ $year }}</option>
      @endforeach
    </select>

    <canvas id="myChart" width="400" height="200"></canvas>

    <script>
      var data = @json($data);
      console.log(data);

      var years = @json($years); // Menambahkan tahun ke dalam JavaScript
      console.log(years);

      var months = [];
      var counts = [];

      // Loop untuk mengambil bulan dan jumlah dari data yang ada
      for (var i = 0; i < data.months.length; i++) {
        months.push(data.months[i]);
        counts.push(data.counts[i]);
      }

      var ctx = document.getElementById('myChart').getContext('2d');

      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: months, // Menggunakan array months yang telah diisi sebelumnya
          datasets: [{
            label: 'Dog Post Amount Report',
            data: counts, // Menggunakan array counts yang telah diisi sebelumnya
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          }]
        },
        options: {
          plugins: {
            legend: {
              labels: {
                font: {
                  weight: 'bold'
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });

      // event listener untuk filter tahun
      var yearFilter = document.getElementById('yearFilter');
      yearFilter.addEventListener('change', function () {
        var selectedYear = yearFilter.value;
        var filteredData = filterDataByYear(data, selectedYear, years); // Mengirimkan data tahun ke fungsi
        // debugger;
        updateChart(filteredData);
      });

      // filter berdasarkan tahun
      function filterDataByYear(data, selectedYear, years) {
        if (selectedYear === 'all') {
          return data;
        }

        var filteredMonths = [];
        var filteredCounts = [];

        for (var i = 0; i < data.months.length; i++) {
          if (years[i] == selectedYear) {
            filteredMonths.push(data.months[i]);
            filteredCounts.push(data.counts[i]);
          }
        }

        return {
          months: filteredMonths,
          counts: filteredCounts
        };
      }

      // update grafik
      function updateChart(filteredData) {
        myChart.data.labels = filteredData.months;
        myChart.data.datasets[0].data = filteredData.counts;
        myChart.update();
      }
    </script>
  </div>

  <!-- Adopted report -->
  <div class="container pt-5">
    <h4 class="fw-bold border-bottom border-dark pb-2">Dog Adopted Report</h4>
    <label for="yearFilterAdopt">Choose Year:</label>
    <select id="yearFilterAdopt">
      <option value="all">All</option>
      @foreach ($report_years_adopt as $year)
        <option value="{{ $year }}">{{ $year }}</option>
      @endforeach
    </select>

    <canvas id="myChartAdopted" width="400" height="200"></canvas>

    <script>
      var data_adopt = @json($data_adopt);
      console.log(data_adopt);

      var years_adopt = @json($years_adopt); // Menambahkan tahun ke dalam JavaScript
      console.log(years_adopt);

      var months_adopt = [];
      var counts_adopt = [];

      // Loop untuk mengambil bulan dan jumlah dari data_adopt yang ada
      for (var i = 0; i < data_adopt.months.length; i++) {
        months_adopt.push(data_adopt.months[i]);
        counts_adopt.push(data_adopt.counts[i]);
      }

      var ctx = document.getElementById('myChartAdopted').getContext('2d');

      var myChartAdopted = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: months_adopt, // Menggunakan array months yang telah diisi sebelumnya
          datasets: [{
            label: 'Dog Adopted Amount Report',
            data: counts_adopt, // Menggunakan array counts yang telah diisi sebelumnya
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          }]
        },
        options: {
          plugins: {
            legend: {
              labels: {
                font: {
                  weight: 'bold'
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });

      // event listener untuk filter tahun
      var yearFilterAdopt = document.getElementById('yearFilterAdopt');
      yearFilterAdopt.addEventListener('change', function () {
        var selectedYear = yearFilterAdopt.value;
        var filteredData = filterDataByYearAdopt(data_adopt, selectedYear, years_adopt); // Mengirimkan data tahun ke fungsi
        updateChartAdopt(filteredData);
      });

      // filter berdasarkan tahun
      function filterDataByYearAdopt(data_adopt, selectedYear, years_adopt) {
        if (selectedYear === 'all') {
          return data_adopt;
        }

        var filteredMonths = [];
        var filteredCounts = [];

        for (var i = 0; i < data_adopt.months.length; i++) {
          if (years_adopt[i] == selectedYear) {
            filteredMonths.push(data_adopt.months[i]);
            filteredCounts.push(data_adopt.counts[i]);
          }
        }

        return {
          months_adopt: filteredMonths,
          counts_adopt: filteredCounts
        };
      }

      // update grafik
      function updateChartAdopt(filteredData) {
        myChartAdopted.data.labels = filteredData.months_adopt;
        myChartAdopted.data.datasets[0].data = filteredData.counts_adopt;
        myChartAdopted.update();
      }
    </script>
  </div>
</section>