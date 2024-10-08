<?php
// Include the database connection file
include("./database/db_con.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $student_number = $conn->real_escape_string($_POST['student_number']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $middle_name = $conn->real_escape_string($_POST['middle_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $suffix = $conn->real_escape_string($_POST['suffix']);
    $birthdate = $conn->real_escape_string($_POST['birthdate']);
    $street = $conn->real_escape_string($_POST['street']);
    $purok = $conn->real_escape_string($_POST['purok']);
    $barangay = $conn->real_escape_string($_POST['barangay']);
    $city = $conn->real_escape_string($_POST['city']);
    $state = $conn->real_escape_string($_POST['state']);
    $guardian_name = $conn->real_escape_string($_POST['guardian_name']);
    $guardian_occupation = $conn->real_escape_string($_POST['guardian_occupation']);
    $is_graduated = $conn->real_escape_string($_POST['is_graduated']);
    $graduation_date = !empty($_POST['graduation_date']) ? $conn->real_escape_string($_POST['graduation_date']) : NULL;

    // SQL query to insert data into students table
    $sql = "INSERT INTO students (student_number, first_name, middle_name, last_name, suffix, birthdate, street, purok, barangay, city, state, guardian_name, guardian_occupation, is_graduated, graduation_date)
            VALUES ('$student_number', '$first_name', '$middle_name', '$last_name', '$suffix', '$birthdate', '$street', '$purok', '$barangay', '$city', '$state', '$guardian_name', '$guardian_occupation', '$is_graduated', '$graduation_date')";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        echo "New student record added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../resources/css/styles.css">
    <title>Student Information Submission</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Submit Student Information</h1>
        <form action="student_info_submission.php" method="POST">
            <div class="mb-3">
                <label for="student_number" class="form-label">Student Number</label>
                <input type="text" class="form-control" id="student_number" name="student_number" required>
            </div>
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="mb-3">
                <label for="middle_name" class="form-label">Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name">
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <div class="mb-3">
                <label for="suffix" class="form-label">Suffix</label>
                <input type="text" class="form-control" id="suffix" name="suffix">
            </div>
            <div class="mb-3">
                <label for="birthdate" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" required>
            </div>
            <div class="mb-3">
                <label for="street" class="form-label">Street</label>
                <input type="text" class="form-control" id="street" name="street">
            </div>
            <div class="mb-3">
                <label for="purok" class="form-label">Purok</label>
                <input type="text" class="form-control" id="purok" name="purok">
            </div>
            <div class="mb-3">
                <label for="barangay" class="form-label">Barangay</label>
                <input type="text" class="form-control" id="barangay" name="barangay" required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="mb-3">
                <label for="state" class="form-label">State</label>
                <input type="text" class="form-control" id="state" name="state" required>
            </div>
            <div class="mb-3">
                <label for="guardian_name" class="form-label">Guardian Name</label>
                <input type="text" class="form-control" id="guardian_name" name="guardian_name">
            </div>
            <div class="mb-3">
                <label for="guardian_occupation" class="form-label">Guardian Occupation</label>
                <input type="text" class="form-control" id="guardian_occupation" name="guardian_occupation">
            </div>
            <button type="submit" class="btn btn-outline-dark">Submit</button>
        </form>
    </div>
</body>
</html>