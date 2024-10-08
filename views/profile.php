<?php
include("../database/db_con.php");

// Get the search query from the URL, if it exists
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';

// Escape special characters to prevent SQL injection
$searchQuery = $conn->real_escape_string($searchQuery);

// Prepare SQL query for searching students
$sql = "SELECT * FROM students";
if (!empty($searchQuery)) {
    $sql .= " WHERE student_number LIKE '%$searchQuery%'
              OR first_name LIKE '%$searchQuery%'
              OR middle_name LIKE '%$searchQuery%'
              OR last_name LIKE '%$searchQuery%'
              OR graduation_date LIKE '%$searchQuery%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../resources/css/styles.css">
    <title>Student Profiles</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include('../components/navbar.php'); ?>

    <main>
        <div class="container">
            <h1>Student Profiles</h1>

            <!-- Flex container for button and search form -->
            <div class="d-flex justify-content-between mb-3">
                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#addRecordModal">
                    Add New Record
                </button>

                <!-- Search Form -->
                <form class="d-flex" action="profile.php" method="GET" role="search">
                    <input class="form-control me-2 custom-search" type="search" name="query" placeholder="Search by Student ID Number, Name or Graduation Date (yy-dd-mm)" aria-label="Search">
                    <button class="btn btn-outline-dark" type="submit">Search</button>
                </form>
            </div>

            <!-- Check if there are search results -->
            <?php if ($result && $result->num_rows > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="center-text">Student ID Number</th>
                            <th class="center-text">Name</th>
                            <th class="center-text">Birthdate</th>
                            <th class="center-text">Address</th>
                            <th class="center-text">Guardian</th>
                            <th class="center-text">Graduated</th>
                            <th class="center-text">Graduation Date</th>
                            <th class="center-text">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($student = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="center-text"><?= htmlspecialchars($student['student_number']); ?></td>
                                <td class="center-text"><?= htmlspecialchars($student['first_name'] . ' ' . $student['middle_name'] . ' ' . $student['last_name'] . ' ' . $student['suffix']); ?></td>
                                <td class="center-text"><?= htmlspecialchars($student['birthdate']); ?></td>
                                <td class="center-text"><?= htmlspecialchars($student['street']  . ' ' . $student['purok']  . ' ' . $student['barangay'] . ' ' . $student['city'] . ' ' . $student['state']); ?></td>
                                <td class="center-text"><?= htmlspecialchars($student['guardian_name']); ?></td>
                                <td class="center-text"><?= $student['is_graduated'] ? 'Yes' : 'No'; ?></td>
                                <td class="center-text"><?= htmlspecialchars($student['graduation_date']); ?></td>
                                <td class="center-text">
                                    <!-- Edit Button -->
                                    <button type="button" class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#editStudentModal<?= $student['student_number']; ?>">
                                        Edit
                                    </button><br>
                                    <!-- Delete Button -->
                                    <form action="delete_student.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="student_number" value="<?= htmlspecialchars($student['student_number']); ?>">
                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-outline" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteStudentModal" 
                                            onclick="setDeleteStudent('<?= htmlspecialchars($student['student_number']); ?>')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No students found.</p>
            <?php endif; ?>
        </div>
    </main>

    <!-- Add Record Modal -->
    <div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRecordModalLabel">Add Student Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="add_student.php" method="POST">
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

                        <div class="mb-3">
                            <label for="is_graduated" class="form-label">Graduated</label>
                            <select class="form-select" id="is_graduated" name="is_graduated" required>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="graduation_date" class="form-label">Graduation Date</label>
                            <input type="date" class="form-control" id="graduation_date" name="graduation_date">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-dark">Add Record</button>
                </div>
                    </form>
            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <?php $result->data_seek(0); // Reset the result set pointer ?>
    <?php while ($student = $result->fetch_assoc()): ?>
    <div class="modal fade" id="editStudentModal<?= $student['student_number']; ?>" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Edit Student Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="edit_student.php" method="POST">
                        <input type="hidden" name="student_number" value="<?= htmlspecialchars($student['student_number']); ?>">
                        
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($student['first_name']); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?= htmlspecialchars($student['middle_name']); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($student['last_name']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="suffix" class="form-label">Suffix</label>
                            <input type="text" class="form-control" id="suffix" name="suffix" value="<?= htmlspecialchars($student['suffix']); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="birthdate" class="form-label">Birthdate</label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?= htmlspecialchars($student['birthdate']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="street" class="form-label">Street</label>
                            <input type="text" class="form-control" id="street" name="street" value="<?= htmlspecialchars($student['street']); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="purok" class="form-label">Purok</label>
                            <input type="text" class="form-control" id="purok" name="purok" value="<?= htmlspecialchars($student['purok']); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="barangay" class="form-label">Barangay</label>
                            <input type="text" class="form-control" id="barangay" name="barangay" value="<?= htmlspecialchars($student['barangay']); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="<?= htmlspecialchars($student['city']); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state" value="<?= htmlspecialchars($student['state']); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="guardian_name" class="form-label">Guardian Name</label>
                            <input type="text" class="form-control" id="guardian_name" name="guardian_name" value="<?= htmlspecialchars($student['guardian_name']); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="guardian_occupation" class="form-label">Guardian Occupation</label>
                            <input type="text" class="form-control" id="guardian_occupation" name="guardian_occupation" value="<?= htmlspecialchars($student['guardian_occupation']); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="is_graduated" class="form-label">Graduated</label>
                            <select class="form-select" id="is_graduated" name="is_graduated" required>
                                <option value="1" <?= $student['is_graduated'] ? 'selected' : ''; ?>>Yes</option>
                                <option value="0" <?= !$student['is_graduated'] ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="graduation_date" class="form-label">Graduation Date</label>
                            <input type="date" class="form-control" id="graduation_date" name="graduation_date" value="<?= htmlspecialchars($student['graduation_date']); ?>">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-dark">Update Record</button>
                </div>
                    </form>
            </div>
        </div>
    </div>
<?php endwhile; ?>

<!-- Delete Student Modal -->
<div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="deleteStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteStudentModalLabel">Delete Student Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this student record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" action="delete_student.php" method="POST" style="display: inline;">
                    <input type="hidden" name="student_number" id="student_number_to_delete">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<footer class="bg-light text-center py-3">
    <p>&copy; <?= date('Y'); ?> Your Institution. All rights reserved.</p>
</footer>

</body>
</html>