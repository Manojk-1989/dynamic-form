<!-- Options Modal -->
<div id="optionsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded p-6 w-96 max-w-full max-h-[80vh] overflow-auto">
    <h3 class="text-lg font-semibold mb-4">Edit Options</h3>

    <table class="w-full mb-4 table-auto border-collapse border border-gray-300">
      <thead>
        <tr class="bg-gray-100">
          <th class="border border-gray-300 px-2 py-1 text-left">Option Value</th>
          <th class="border border-gray-300 px-2 py-1 text-left">Description</th>
          <th class="border border-gray-300 px-2 py-1">Action</th>
        </tr>
      </thead>
      <tbody id="optionsTableBody">
        <!-- Option rows will be dynamically added here -->
      </tbody>
    </table>

    <button id="addOptionRow" class="bg-green-500 text-white px-3 py-1 rounded mb-4">+ Add Option</button>

    <div class="flex justify-end gap-2">
      <button id="closeOptionsModal" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
      <button id="saveOptionsModal" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
    </div>
  </div>
</div>
