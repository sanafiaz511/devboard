<template>
  <div class="flex h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white hidden md:flex flex-col">
      <div class="p-5 text-xl font-bold border-b border-gray-700">
        DevBoard
      </div>

      <nav class="flex-1 p-4 space-y-2">
        <a href="/" class="block px-3 py-2 rounded hover:bg-gray-700">
          Dashboard
        </a>

        <a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">
          GitHub
        </a>

        <a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">
          Tasks
        </a>

        <a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">
          Settings
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

      <!-- Topbar -->
      <header class="h-14 bg-white shadow flex items-center justify-between px-4">

        <h1 class="font-semibold text-gray-700">
          Dashboard
        </h1>

        <div class="flex items-center gap-3">

          <Link
            href="/logout"
            method="post"
            as="button"
            class="px-3 py-1 text-sm bg-red-500 text-white rounded"
          >
            Logout
          </Link>

        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 p-6 overflow-y-auto">
        <slot />
      </main>

    </div>

  </div>
</template>
