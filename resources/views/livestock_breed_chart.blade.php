<div class="card mb-3">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0" style="color: black;">{{ __('Livestock Breed Distribution') }}</h3>
        <small style="color: black;">{{ __('A summary of the Livestock Breed Distribution across subcounties') }}</small>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="locationSelector" class="form-label">{{ __('Select Location') }}</label>
            <select id="locationSelector" class="form-select">
                <option value="">{{ __('All Locations') }}</option>
                <?php
                    $dataArray = $data->toArray();
                    $uniqueLocations = array_unique(array_column($dataArray, 'location_name'));
                    foreach ($uniqueLocations as $location) {
                        echo '<option value="' . $location . '">' . $location . '</option>';
                    }
                ?>
            </select>
        </div>

        <div class="chart-container" style="position: relative; height:300px;">
            <canvas id="livestockBreedChart"></canvas>
        </div>
    </div>
</div>

<script>
    var originalData = <?php echo json_encode($data); ?>;
    function getRandomColor() {
        return '#' + Math.floor(Math.random()*16777215).toString(16);
    }
    function updateChart(selectedLocation) {
        selectedLocation = selectedLocation || 'Kapeke';
        var filteredData = originalData.filter(item => item.location_name === selectedLocation);
        var groupedData = filteredData.reduce((acc, item) => {
            if (!acc[item.breed_name]) {
                acc[item.breed_name] = { count: 0, color: getRandomColor() };
            }
            acc[item.breed_name].count += item.breed_count;
            return acc;
        }, {});
        var breeds = Object.keys(groupedData);
        var breedData = Object.values(groupedData);

        var ctx = document.getElementById('livestockBreedChart').getContext('2d');
        if (window.myChart) {
            window.myChart.destroy();
        }
        window.myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: breeds,
                datasets: [{
                    label: 'Breed Count',
                    data: breedData.map(item => item.count),
                    backgroundColor: breedData.map(item => item.color),
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        title: { display: true, text: 'Breed' }
                    },
                    y: {
                        title: { display: true, text: 'Breed Count' }
                    }
                }
            }
        });
    }
    var uniqueLocations = [...new Set(originalData.map(item => item.location_name))];
    var defaultLocation = uniqueLocations.length > 0 ? uniqueLocations[0] : '';
    updateChart(defaultLocation);

    document.getElementById('locationSelector').addEventListener('change', function() {
        var selectedLocation = this.value;
        updateChart(selectedLocation);
    });
</script>
