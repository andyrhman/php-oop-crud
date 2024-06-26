<?php

include_once "classes/Register.php";

$re = new Register();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $register = $re->addRegister($_POST, $_FILES);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- stylesheet -->
  <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <style>
    .material-symbols-outlined {
      font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
    }

    .alert-success {
      background-color: #d1e7dd;
      border-color: #badbcc;
      color: #0f5132;
    }

    .alert-danger {
      background-color: #f8d7da;
      border-color: #f5c2c7;
      color: #842029;
    }

    .close-icon {
      cursor: pointer;
    }
  </style>

  <!-- from cdn -->
  <script src="https://unpkg.com/@material-tailwind/html@latest/scripts/ripple.js"></script>
  <title>Home</title>
</head>

<body class="h-screen flex-row items-center justify-center bg-gray-100">
  <div class="container mx-auto max-w-xl p-8 bg-white rounded shadow-lg">
    <div class="flex items-center justify-between pb-6">
      <div>
        <h4 class="text-xl font-bold mb-4">Student Registration Form</h4>
      </div>
      <div class="flex items-center justify-between">
        <div class="ml-2 space-x-8 lg:ml-20">
          <a href="index.php"
            class="flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white focus:outline-none focus:ring hover:bg-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
              <path
                d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z" />
            </svg>
            Show Lists
          </a>
        </div>
      </div>
    </div>

    <?php
    if (isset($register)) {
      // Determine the Tailwind classes based on success/failure message
      $isSuccess = strpos($register, "Success") !== false;
      $alertClasses = $isSuccess ? "bg-green-100 border-green-400 text-green-700" : "bg-red-100 border-red-400 text-red-700";
      ?>
      <div id="register-alert" class="<?= $alertClasses ?> border px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold"><?= $register ?></strong>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
          <svg onclick="closeAlert('register-alert')" class="fill-current h-6 w-6 text-green-500" role="button"
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

    <form method="POST" enctype="multipart/form-data">
      <div class="m-10 max-w-sm">
        <label for="name" class="mb-2 block text-sm font-medium">Name</label>
        <div class="relative">
          <input type="text" id="name" name="name"
            class="block w-full rounded-md border border-gray-200 py-3 px-4 pr-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500"
            placeholder="Enter your name" />
          <div class="pointer-events-none absolute inset-y-0 right-0 z-20 flex items-center pr-4">
            <span class="material-symbols-outlined" style="color: #b7b7b7">
              person
            </span>
          </div>
        </div>
      </div>

      <div class="m-10 max-w-sm">
        <label for="email" class="mb-2 block text-sm font-medium">Email</label>
        <div class="relative">
          <input type="email" id="email" name="email"
            class="block w-full rounded-md border border-gray-200 py-3 px-4 pr-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500"
            placeholder="Enter your email" />
          <div class="pointer-events-none absolute inset-y-0 right-0 z-20 flex items-center pr-4">
            <span class="material-symbols-outlined" style="color: #b7b7b7">
              alternate_email
            </span>
          </div>
        </div>
      </div>

      <div class="m-10 max-w-sm">
        <label for="phone" class="mb-2 block text-sm font-medium">Phone</label>
        <div class="relative">
          <input type="text" id="phone" name="phone"
            class="block w-full rounded-md border border-gray-200 py-3 px-4 pr-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500"
            placeholder="Enter your phone number" />
          <div class="pointer-events-none absolute inset-y-0 right-0 z-20 flex items-center pr-4">
            <span class="material-symbols-outlined" style="color: #b7b7b7">
              call
            </span>
          </div>
        </div>
      </div>

      <div class="m-10 max-w-sm">
        <label for="photo" class="mb-2 block text-sm font-medium">Photo</label>
        <div class="relative">
          <input type="file" id="photo" name="photo"
            class="block w-full rounded-md border border-gray-200 py-3 px-4 pr-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500"
            placeholder="" />
          <div class="pointer-events-none absolute inset-y-0 right-0 z-20 flex items-center pr-4">
            <span class="material-symbols-outlined" style="color: #b7b7b7">
              photo_camera
            </span>
          </div>
        </div>
      </div>

      <div class="m-10 max-w-sm">
        <label for="address" class="mb-2 block text-sm font-medium">Address</label>
        <div class="relative">
          <textarea id="address" name="address"
            class="block w-full rounded-md border border-gray-200 py-3 px-4 pr-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500"></textarea>
        </div>
      </div>
      <button class="mt-4 rounded-full bg-blue-800 px-10 py-2 font-semibold text-white" type="submit">Submit</button>
    </form>
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