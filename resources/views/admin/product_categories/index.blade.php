@extends('admin.layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Product Categories</h1>
        <a href="{{ route('admin.product-categories.create') }}"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg> Add Category
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-semibold">
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Image</th>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Slug</th>
                        <th class="px-6 py-4">Sequence</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">
                            @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->category_name }}"
                                class="h-10 w-10 rounded-full object-cover">
                            @else
                            <span class="text-gray-400">No Image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-700">
                            <button onclick="openSubCategoryModal({{ $category->id }}, this.getAttribute('data-name'))"
                                data-name="{{ $category->category_name }}"
                                class="text-indigo-600 hover:text-indigo-900 hover:underline focus:outline-none">
                                {{ $category->category_name }}
                            </button>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $category->slug }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $category->sequence }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                {{-- View Button Removed --}}
                                <a href="{{ route('admin.product-categories.edit', $category->id) }}"
                                    class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition duration-200"
                                    title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.product-categories.destroy', $category->id) }}"
                                    method="POST" class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition duration-200"
                                        title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                                <p>No categories found.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Subcategory Modal -->
<div id="subCategoryModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div
            class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-5xl">

            <!-- Expanded Header with Add Button -->
            <div class="px-6 py-6 border-b border-gray-100 flex justify-between items-center bg-white">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Categories Management</h3>
                    <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                        <span id="modalNavigationPath" class="flex items-center">
                            <span class="text-gray-400">Manage: </span>
                            <span class="font-semibold text-indigo-600 ml-1" id="subModalSubtitle">--</span>
                        </span>
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" id="modalBackButton" onclick="goBackHierarchy()"
                        class="hidden inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg> Back
                    </button>
                    <button type="button" onclick="toggleForm(true)"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        + Add Item
                    </button>
                    <button type="button" class="text-gray-400 hover:text-gray-500 transition-colors"
                        onclick="closeSubCategoryModal()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="p-6 bg-gray-50/30">

                <!-- Add/Edit Form (Collapsible) -->
                <div id="formContainer"
                    class="hidden mb-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition-all duration-300">
                    <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-2">
                        <h4 class="text-lg font-semibold text-gray-800" id="formTitle">Add New Item</h4>
                        <button type="button" onclick="toggleForm(false)" class="text-gray-400 hover:text-red-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form id="subcategoryForm" onsubmit="saveSubcategory(event)" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="parent_id" id="modalParentId">
                        <input type="hidden" name="subcategory_id" id="modalSubcategoryId">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="category_name" id="modalCategoryNameInput" required
                                    class="block w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                                <input type="text" name="slug" id="modalSlugInput" placeholder="Auto-generated"
                                    class="block w-full rounded-lg border-gray-300 bg-gray-50 text-gray-500 cursor-not-allowed focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                                <input type="file" name="image" id="modalImageInput" accept="image/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sequence</label>
                                <input type="number" name="sequence" id="modalSequenceInput" placeholder="0"
                                    class="block w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" onclick="toggleForm(false)"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </button>
                            <button type="submit" id="saveButton"
                                class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Add Item
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Table Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase text-gray-400 font-bold tracking-wider">
                                    <th class="px-6 py-4">#</th>
                                    <th class="px-6 py-4">Image</th>
                                    <th class="px-6 py-4">Name</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="subCategoryTableBody" class="divide-y divide-gray-100">
                                <!-- Rows injected via JS -->
                            </tbody>
                        </table>
                    </div>

                    <!-- States -->
                    <div id="loadingSubcategories" class="hidden text-center py-12 text-indigo-600">
                        <svg class="animate-spin h-8 w-8 mx-auto mb-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium">Loading Data...</span>
                    </div>

                    <div id="noSubCategories"
                        class="hidden flex flex-col items-center justify-center py-12 text-center">
                        <div class="bg-gray-50 rounded-full p-4 mb-3">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </div>
                        <h3 class="text-gray-900 font-medium text-sm">No items found</h3>
                        <p class="text-gray-500 text-xs mt-1">Get started by adding a new item.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // --- View Modal Logic Removed ---

    // --- Subcategory AJAX Logic ---
    let currentParentId = null;
    let navigationStack = []; // To keep track of hierarchy [{id, name}]

    function openSubCategoryModal(id, name) {
        navigationStack = []; // Reset stack on fresh open
        drillDown(id, name);

        document.getElementById('subCategoryModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        document.querySelector('#subCategoryModal .backdrop-blur-sm').addEventListener('click', closeSubCategoryModal);
    }

    function drillDown(id, name) {
        currentParentId = id;
        navigationStack.push({
            id: id,
            name: name
        });

        updateModalHeader();

        document.getElementById('modalParentId').value = id;
        document.getElementById('subcategoryForm').reset();
        document.getElementById('modalSubcategoryId').value = '';
        toggleForm(false);

        fetchSubcategories(id);
    }

    function goBackHierarchy() {
        if (navigationStack.length > 1) {
            navigationStack.pop(); // Remove current
            const previous = navigationStack.pop(); // Get previous (will be re-pushed by drillDown)
            drillDown(previous.id, previous.name);
        }
    }

    function updateModalHeader() {
        const current = navigationStack[navigationStack.length - 1];
        document.getElementById('subModalSubtitle').innerText = current.name;

        const backBtn = document.getElementById('modalBackButton');
        if (navigationStack.length > 1) {
            backBtn.classList.remove('hidden');
        } else {
            backBtn.classList.add('hidden');
        }
    }

    function closeSubCategoryModal() {
        document.getElementById('subCategoryModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function fetchSubcategories(parentId) {
        const tbody = document.getElementById('subCategoryTableBody');
        const noSubs = document.getElementById('noSubCategories');
        const loading = document.getElementById('loadingSubcategories');

        tbody.innerHTML = '';
        noSubs.classList.add('hidden');
        loading.classList.remove('hidden');

        fetch("{{ url('admin/get-subcategories') }}/" + parentId)
            .then(response => response.json())
            .then(data => {
                loading.classList.add('hidden');

                if (data.length > 0) {
                    data.forEach((sub, index) => {
                        const tr = document.createElement('tr');
                        tr.className = 'hover:bg-gray-50 transition-colors';

                        let nameHtml = sub.category_name;
                        let drillBtn = '';

                        if (navigationStack.length === 1) {
                            // Depth 1: Subcategories - Show name link but NO "Next Layer" button
                            nameHtml = `<button type="button" onclick="drillDown(${sub.id}, '${sub.category_name}')" class="text-indigo-600 hover:underline">${sub.category_name}</button>`;
                            drillBtn = '';
                        } else {
                            // Depth 2+: Sub-subcategories - Plain text and NO button
                            nameHtml = sub.category_name;
                            drillBtn = '';
                        }

                        const editBtn = `<button type="button" onclick='editSubcategory(${JSON.stringify(sub).replace(/'/g, "&#39;")})' class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition duration-200" title="Edit"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>`;

                        const deleteBtn = `<button type="button" onclick="deleteSubcategory(${sub.id})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition duration-200" title="Delete"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>`;

                        const imageHtml = sub.image ?
                            `<img src="/storage/${sub.image}" class="w-10 h-10 rounded-full object-cover border border-gray-100">` :
                            `<div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-xs text-gray-400 font-bold">NA</div>`;


                        tr.innerHTML = `
                                                    <td class="px-6 py-4 text-gray-500 text-sm whitespace-nowrap">${index + 1}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">${imageHtml}</td>
                                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                        ${nameHtml}
                                                    </td>
                                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                                        <div class="flex items-center justify-end gap-2">
                                                            ${drillBtn}
                                                            ${editBtn}
                                                            ${deleteBtn}
                                                        </div>
                                                    </td>
                                                `;
                        tbody.appendChild(tr);
                    });
                } else {
                    noSubs.classList.remove('hidden');
                }
            })
            .catch(err => {
                console.error('Error fetching subcategories:', err);
                loading.classList.add('hidden');
            });
    }

    function toggleForm(show) {
        const container = document.getElementById('formContainer');
        if (show) {
            container.classList.remove('hidden');
            // If subId is empty, it's a fresh ADD
            if (document.getElementById('modalSubcategoryId').value === '') {
                document.getElementById('subcategoryForm').reset();
                document.getElementById('modalParentId').value = currentParentId;
                document.getElementById('formTitle').innerText = 'Add New Item';
                document.getElementById('saveButton').innerText = 'Add Item';
            }
        } else {
            container.classList.add('hidden');
            document.getElementById('subcategoryForm').reset();
            document.getElementById('modalSubcategoryId').value = '';
            document.getElementById('modalParentId').value = currentParentId;
        }
    }

    async function saveSubcategory(event) {
        event.preventDefault();

        const form = document.getElementById('subcategoryForm');
        const formData = new FormData(form);
        const subId = document.getElementById('modalSubcategoryId').value;

        let url = "{{ route('admin.product-categories.ajax-store') }}";
        let method = 'POST';

        if (subId) {
            url = "{{ url('admin/product-categories/ajax-update') }}/" + subId;
            formData.append('_method', 'PUT');
        }

        const saveBtn = document.getElementById('saveButton');
        const originalText = saveBtn.innerText;
        saveBtn.disabled = true;
        saveBtn.innerText = 'Saving...';

        try {
            const response = await fetch(url, {
                method: 'POST', // Always POST for Laravel FormData with _method
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success) {
                toggleForm(false);
                fetchSubcategories(currentParentId);
            } else {
                let errorMessage = result.message || 'Unknown error';
                if (result.errors) {
                    errorMessage += '\n' + Object.values(result.errors).flat().join('\n');
                }
                alert('Error: ' + errorMessage);
            }

        } catch (error) {
            console.error('Error:', error);
            alert('Something went wrong.');
        } finally {
            saveBtn.disabled = false;
            saveBtn.innerText = originalText;
        }
    }

    function editSubcategory(sub) {
        document.getElementById('formTitle').innerText = 'Edit Subcategory';
        document.getElementById('saveButton').innerText = 'Update Subcategory';

        document.getElementById('modalSubcategoryId').value = sub.id;
        document.getElementById('modalCategoryNameInput').value = sub.category_name;
        document.getElementById('modalSlugInput').value = sub.slug;
        document.getElementById('modalSequenceInput').value = sub.sequence || '';

        toggleForm(true);
        document.getElementById('formContainer').scrollIntoView({
            behavior: 'smooth'
        });
    }

    function deleteSubcategory(id) {
        if (!confirm('Are you sure you want to delete this subcategory?')) return;

        fetch("{{ url('admin/product-categories/ajax-destroy') }}/" + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    fetchSubcategories(currentParentId);
                } else {
                    alert('Failed to delete.');
                }
            })
            .catch(err => console.error(err));
    }

    document.getElementById('modalCategoryNameInput').addEventListener('input', function() {
        let slug = this.value.toLowerCase()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');
        document.getElementById('modalSlugInput').value = slug;
    });
</script>
@endsection