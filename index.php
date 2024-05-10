<?php
include_once "classes/Register.php";

$re = new Register();

if (isset($_GET['del'])){
    $id = base64_decode($_GET['del']);
    $deleteStudent = $re->deleteStudent($id);
}
// Pagination Parameters
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get Students and Total Count
$allStudents = $re->allStudent($limit, $offset);
$totalStudents = $re->countStudents();

// Calculate Total Pages
$totalPages = ceil($totalStudents / $limit);

function paginationLinks($page, $totalPages) {
    $pagination = [];

    // Always show the first page
    if ($page > 3) {
        $pagination[] = 1;
        if ($page > 4) {
            $pagination[] = '...';
        }
    }

    // Pages around the current page
    for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++) {
        $pagination[] = $i;
    }

    // Always show the last page
    if ($page < $totalPages - 2) {
        if ($page < $totalPages - 3) {
            $pagination[] = '...';
        }
        $pagination[] = $totalPages;
    }

    return $pagination;
}

$paginationLinks = paginationLinks($page, $totalPages);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        .material-symbols-outlined {
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
        }
    </style>
    <title>Student Lists</title>
</head>

<body class="h-screen flex-row items-center justify-center bg-gray-100">
    <div class="container mx-auto max-w-5xl p-8 bg-white rounded shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Student Registration Form</h1>
        <p>Enter your information using the form below. Make sure your information is correct before submitting.</p>
        <div class="mx-auto max-w-screen-lg px-4 py-8 sm:px-8">
            <?php
                if (isset($deleteStudent)) {
                // Determine the Tailwind classes based on success/failure message
                $isSuccess = strpos($deleteStudent, "Success") !== false;
                $alertClasses = $isSuccess ? "bg-green-100 border-green-400 text-green-700" : "bg-red-100 border-red-400 text-red-700";
                ?>
                <div id="deleteStudent-alert" class="<?= $alertClasses ?> border px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold"><?= $deleteStudent ?></strong>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg onclick="closeAlert('deleteStudent-alert')" class="fill-current h-6 w-6 text-grey-500" role="button"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                    </svg>
                    </span>
                </div>
                <?php
                }
            ?>
            <div class="flex items-center justify-between pb-6">
                <div>
                    <h2 class="font-semibold text-gray-700">User Accounts</h2>
                    <span class="text-xs text-gray-500">View accounts of registered users</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="ml-10 space-x-8 lg:ml-40">
                        <a href="insert-student.php"
                            class="flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white focus:outline-none focus:ring hover:bg-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="24px"
                                fill="#e8eaed">
                                <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                            </svg>
                            Add Student
                        </a>
                    </div>
                </div>
            </div>
            <div class="overflow-y-hidden rounded-lg border">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-blue-600 text-left text-xs font-semibold uppercase tracking-widest text-white">
                                <th class="px-5 py-3">Name</th>
                                <th class="px-5 py-3">Email</th>
                                <th class="px-5 py-3">Phone</th>
                                <th class="px-5 py-3">Photo</th>
                                <th class="px-5 py-3">Address</th>
                                <th class="px-5 py-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-500">
                            <?php
                            if ($allStudents) {
                                while ($row = mysqli_fetch_assoc($allStudents)) {
                                ?>
                                    <tr>
                                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                                            <p class="whitespace-no-wrap"><?= $row["name"]?></p>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                                            <p class="whitespace-no-wrap"><?= $row["email"]?></p>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                                            <p class="whitespace-no-wrap"><?= $row["phone"]?></p>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <img class="h-full w-full rounded-full"
                                                        src="<?= $row["photo"]?>" alt="<?= $row["name"]?>" />
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                                            <p class="whitespace-no-wrap"><?= $row["address"]?></p>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                                            <div class="flex items-center">
                                                <div class="ml-2">
                                                    <a href="edit.php?id=<?= base64_encode($row["id"])?>" class="m-2 inline-flex items-center justify-center rounded-3xl border border-transparent bg-blue-600 px-2 py-2 font-medium text-white hover:bg-blue-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h357l-80 80H200v560h560v-278l80-80v358q0 33-23.5 56.5T760-120H200Zm280-360ZM360-360v-170l367-367q12-12 27-18t30-6q16 0 30.5 6t26.5 18l56 57q11 12 17 26.5t6 29.5q0 15-5.5 29.5T897-728L530-360H360Zm481-424-56-56 56 56ZM440-440h56l232-232-28-28-29-28-231 231v57Zm260-260-29-28 29 28 28 28-28-28Z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                                <div class="ml-2">
                                                    <a href="?del=<?= base64_encode($row["id"])?>" 
                                                        onclick="return confirm('Are you sure you want to delete?')"
                                                        class="m-2 inline-flex items-center justify-center rounded-3xl border border-transparent bg-red-600 px-2 py-2 font-medium text-white hover:bg-red-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m376-300 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 180q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-col items-center border-t bg-white px-5 py-5 sm:flex-row sm:justify-between">
                    <span class="text-xs text-gray-600 sm:text-sm"> Showing <?= ($offset + 1) ?> to <?= min($offset + $limit, $totalStudents) ?> of <?= $totalStudents ?> Entries </span>
                    <div class="mt-2 inline-flex sm:mt-0">
                        <a href="?page=<?= max(1, $page - 1) ?>" class="mr-2 flex h-10 w-10 items-center justify-center rounded-full border border-gray-300 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-100 transition duration-150">←</a>
                        <?php foreach ($paginationLinks as $link) { ?>
                            <?php if ($link == '...') { ?>
                                <span class="mr-2 flex h-10 w-10 items-center justify-center rounded-full border border-gray-300 bg-white text-sm font-semibold text-gray-600">...</span>
                            <?php } else { ?>
                                <a href="?page=<?= $link ?>" class="mr-2 flex h-10 w-10 items-center justify-center rounded-full border border-gray-300 bg-white text-sm font-semibold <?= $link == $page ? 'bg-blue-600 text-white' : 'text-gray-600' ?> hover:bg-gray-100 transition duration-150"><?= $link ?></a>
                            <?php } ?>
                        <?php } ?>
                        <a href="?page=<?= min($totalPages, $page + 1) ?>" class="flex h-10 w-10 items-center justify-center rounded-full border border-gray-300 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-100 transition duration-150">→</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function closeAlert(alertId) {
      var alertElement = document.getElementById(alertId);
      if (alertElement) {
        alertElement.style.display = 'none';
      }
    }
  </script>
</body>

</html>