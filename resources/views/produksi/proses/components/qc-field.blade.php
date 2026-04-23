 @if (in_array($dept, ['QC Before', 'QC After']))
     <div class="mb-4">
         <label for="qty_reject" class="block text-sm font-medium text-gray-700">Qty
             Reject</label>
         <input type="number" name="qty_reject" id="qty_reject" min="0"
             class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
     </div>
     <div class="mb-4">
         <label for="type_reject" class="block text-sm font-medium text-gray-700">Reject
             Reason</label>
         <input type="text" name="type_reject" id="type_reject"
             class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
     </div>
 @endif
