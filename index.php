<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UOB Student Nationality Data</title>
    <!-- Include Pico CSS -->
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@1.5.7/css/pico.min.css">
    <style>
        .overflow-table {
            max-height: 500px; /* Limit table height for overflow */
            overflow-y: auto; /* Enable vertical scrolling if necessary */
        }
        body {
            padding: 20px;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>UOB Student Nationality Data</h1>
        <p>Data fetched from the Bahrain Open Data Portal</p>
    </header>

    <main>
        <div class="overflow-table">
            <?php
            // API URL
            $URL = "https://data.gov.bh/api/explore/v2.1/catalog/datasets/01-statistics-of-students-nationalities_updated/records?where=colleges%20like%20%22IT%22%20AND%20the_programs%20like%20%22bachelor%22&limit=100";

            // Fetch data from the API
            $response = file_get_contents($URL);

            // Check if the API request was successful
            if ($response === false) {
                echo "<p>Error fetching data from the API. Please try again later.</p>";
                exit;
            }

            // Decode JSON data
            $data = json_decode($response, true);

            // Check if JSON decoding was successful
            if (json_last_error() !== JSON_ERROR_NONE) {
                echo "<p>Error decoding JSON data: " . json_last_error_msg() . "</p>";
                exit;
            }

            // Check if records exist
            if (!empty($data['results'])) {
                // Display the data in a responsive table
                echo "<table role='grid'>";
                echo "<thead>
                        <tr>
                            <th>Year</th>
                            <th>Semester</th>
                            <th>Program</th>
                            <th>Nationality</th>
                            <th>College</th>
                            <th>Number of Students</th>
                        </tr>
                      </thead>";
                echo "<tbody>";
                foreach ($data['results'] as $record) {
                    $fields = $record;
                    echo "<tr>
                            <td>{$fields['year']}</td>
                            <td>{$fields['semester']}</td>
                            <td>{$fields['the_programs']}</td>
                            <td>{$fields['nationality']}</td>
                            <td>{$fields['colleges']}</td>
                            <td>{$fields['number_of_students']}</td>
                          </tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No records found for the specified criteria.</p>";
            }
            ?>
        </div>
    </main>
</body>
</html>
